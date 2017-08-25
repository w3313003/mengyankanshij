<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Request;
class Userconter extends Common
{
//会员中心
    public function index()
    {
        if (request()->isPost()) {
            $mynews=db('user')->where('phone',getSessionCookie('memberinf.phone'))->find();
            return json_encode($mynews);
        }
    }

  
    //购买记录
    public function purchase ()
    {
        if (request()->isPost()) {
           $ocollec = db('user')->field('delpur')->where('phone', getSessionCookie('memberinf.phone'))->find();
            $collec = db('user')->field('purchase')->where('phone', getSessionCookie('memberinf.phone'))->find();
            $ocollecs = explode(",",$ocollec['delpur']);
            $collecs = explode(",",$collec['purchase']);
            $collecss=array_diff($collecs,$ocollecs);
                $pvideo='';
                foreach($collecss as $v){
                        $videos=db('video')->where('id',$v)->find();
                        $pvideo[]=$videos;
                }
                return json_encode($pvideo);
        }
    }

//购买记录删除
   public function dellpure ()
    {
        if (request()->isPost()) {
          $videoid=input("post.id");
            $collec = db('user')->field('delpur')->where('phone', getSessionCookie('memberinf.phone'))->find();
            $collecarr = explode(",", $collec["delpur"]);
            $collecarr[] = $videoid;
            $newcollec= ltrim(implode(',', $collecarr),',');
            $idarr = [
                'delpur' => $newcollec,
            ];
            db('user')->where('phone', getSessionCookie('memberinf.phone'))->update($idarr);

        }
    }

    //观看记录
    public function looks ()
    {
        if (request()->isPost()) {

        }
    }

    //收藏记录
    public function collection ()
    {
       
               if (request()->isPost()) {
           $collec = db('user')->field('collec')->where('phone', getSessionCookie('memberinf.phone'))->find();
                $collecarr = explode(",", $collec["collec"]);
                $pvideo='';
                foreach($collecarr as $v){
                        $videos=db('video')->where('id',$v)->find();
                        $pvideo[]=$videos;
                }
                return json_encode($pvideo);
        }
 
    }
    // 收藏记录删除
    public function dellcoll ()
    {
        if (request()->isPost()) {
               $id=input("post.id");
        $file=db('user')->where('phone',getSessionCookie('memberinf.phone'))->field('collec')->find();
        $filearr = explode(",", $file["collec"]);
        $arr[]='';
        foreach( $filearr as $k=>$v) {
            if($id == $v) unset($filearr[$k]);
            $arr=$filearr;
        }
        $newcollec = ltrim(implode(',', $arr),',');
        $arr = [
            'collec' => $newcollec,

        ];
        $update = db('user')->where('phone', getSessionCookie('memberinf.phone'))->update($arr);

        }
    }


//上传头像

    public function heard()
    { if (request()->isPost()) {
        header('Content-type:text/html;charset=utf-8');
        $base64_image_content = input('post.img');
     
//匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
        $type = $result[2];
        $new_file =ROOT_PATH . 'public' . DS . "upload\\".date('Ymd',time())."\\";
   
        if(!is_dir($new_file))
    {
//检查是否有该文件夹，如果没有就创建，并给予最高权限
mkdir($new_file, 0700);
}
$new_file = $new_file.time().".{$type}";
if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){

    $pic=str_replace(ROOT_PATH . 'public','http://'.$_SERVER['SERVER_NAME'],$new_file);
    $arr=[
        'pic'=>$pic
    ];
    $up=db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($arr);
    if($up){
        $find=db('user')->where('phone',getSessionCookie('memberinf.phone'))->find();
        $farr=[
            'pic'=>$find['pic'],
            'picinfo'=>'头像保存成功'
        ];
        return json_encode($farr);
    }else{
        return '头像保存失败';
    }

}else{
return '新文件保存失败';
}

        }

    }
    }
    //个人资料
    public function personal()
    {
        if (request()->isPost()) {
           $userarr=[
               'username'=>trim(input('post.username')),
               'sex'=>trim(input('post.sex')),
               'age'=>trim(input('post.age')),
           ];
           $useeinser=db('user')->where('phone',getSessionCookie('memberinf.phone'))->update($userarr);
           if($useeinser){
                return '保存信息成功';
           }else{
               return '保存信息失败';
           }
        }
    }


    //爱心邀请
    public function invitation ()
    {
        if (request()->isPost()) {
              $myinfo=db('user')->where('phone',getSessionCookie('memberinf.phone'))->find();
           $num=db('user')->where(['yourscode'=>$myinfo['mycode'],'status'=>1])->count();
            $priceid=db('user')->field('purchase')->where(['yourscode'=>$myinfo['mycode'],'status'=>1])->select();
            $alarr=0;
            foreach ($priceid as $v){
                $farr= explode(",", $v['purchase']);
                $marr=0;
                foreach($farr as $s){
                    $parr=0;
                    $m=intval($s);
                        $single=db('video')->where('id',$m)->find();
                        $marr+=$single['single'];
                }
                $alarr+=$marr;
                
            }
            $snum=[
                'num'=>$num,
                'alarr'=>$alarr
            ];
            return json_encode($snum);
        }
    }
    //客服
    public function services ()
    {
        if (request()->isPost()) {
        $services=db('service')->where('status',1)->select();
        return json_encode($services);
        }
    }

  //充值记录
    public function record()
    {
        if (request()->isPost()) {
            $reprice=db('recharge')->where(['phone'=>getSessionCookie('memberinf.phone'),'status'=>1])->select();
             return json_encode($reprice);
        }
    }
    //提现表单
    public function wtables ()
    {   if (request()->isPost()) {
         $user=db('user')->where('phone',getSessionCookie('memberinf.phone'))->find();
            $privearr=$user['picesum']+$user['rebate'];   
             return json_encode($privearr);   
             }     
    }

    //立即提现
    public function withds ()
    {
        if (request()->isPost()) {
            if(empty(trim(input('post.phone')))){
                return json_encode('手机号码不能为空');
            }
            $user=db('user')->where('phone',trim(input('post.phone')))->find();
            $privearr=$user['picesum']+$user['rebate'];
            if (trim(input('post.wprice'))>$privearr){
                return json_encode('提现金额错误');
            }
            if(empty(trim(input('post.truename')))){
                return json_encode('真实姓名不能为空');
            }
            if(empty(trim(input('post.card')))){
                return json_encode('银行卡号不能为空');
            }
            var_dump(getSessionCookie('mobile'));
            if (getSessionCookie('code') == input('post.code')&&getSessionCookie('mobile') ==trim(input('post.phone'))) {
            $sarr=[
                'phone'=>trim(input('post.phone')),
                'truename'=>trim(input('post.truename')),
                'card'=>trim(input('post.card')),
                'wprice'=>trim(input('post.wprice')),
                'time'=>time(),
                'status'=>0,
            ];
            $upprice=db('withd')->insert($sarr);
            if ($upprice){
                return '提现申请成功';
            }else{
                return '提现申请失败';
            }
        }else{
            return json_encode('验证码错误！');
        }
      }
    }

}