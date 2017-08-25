<?php
namespace app\index\controller;

use app\common\controller\Common;
use think\Request;
use first\Category;
use think\Db;
class Videoclass extends Common
{
  

    public function index()
    {
        if (request()->isPost()) {
            
            if (input('post.select') == 1) {
                $freetimeasc = db('video')->where(['status' => 1, 'type' => 0, 'pid' => input('post.pid')])->order('time asc')->select();
                return json_encode($freetimeasc);
            }
            if (input('post.select') == 2) {
                $freedesc = db('video')->where(['status' => 1, 'type' => 0, 'pid' => input('post.pid')])->order('time desc')->select();
                return json_encode($freedesc);
            }
            if (input('post.select') == 3) {
                $freelookasc = db('video')->where(['status' => 1, 'type' => 0, 'pid' => input('post.pid')])->order('looks asc')->select();
                return json_encode($freelookasc);
            }
            if (input('post.select') == 4) {
                $freelookdesc = db('video')->where(['status' => 1, 'type' => 0, 'pid' => input('post.pid')])->order('looks desc')->select();
                return json_encode($freelookdesc);
            }
            

        }
        if (input('post.select') == 2) {
            $freetimeasc = db('video')->where(['status' => 1, 'type' => 0])->order('time asc')->select();
            return json_encode($freetimeasc);
        }
        if (input('post.select') == 2) {
            $freedesc = db('video')->where(['status' => 1, 'type' => 0])->order('time desc')->select();
            return json_encode($freedesc);
        }
        if (input('post.select') == 3) {
            $freelookasc = db('video')->where(['status' => 1, 'type' => 0])->order('looks asc')->select();
            return json_encode($freelookasc);
        }
        if (input('post.select') == 4) {
            $freelookdesc = db('video')->where(['status' => 1, 'type' => 0])->order('looks desc')->select();
            return json_encode($freelookdesc);
        }
        $videoclass = db('videoclass')->where('status', 1)->select();

        return json_encode($videoclass);
    }

//大脑开发
    public function develop()
    {
        if (input('post.select') == 1) {
            $freetimeasc = db('video')->where(['status' => 1, 'type' => 1])->order('time asc')->select();
            return json_encode($freetimeasc);
        }
        if (input('post.select') == 2) {
            $freedesc = db('video')->where(['status' => 1, 'type' => 1])->order('time desc')->select();
            return json_encode($freedesc);
        }
        if (input('post.select') == 3) {
            $freelookasc = db('video')->where(['status' => 1, 'type' => 1])->order('looks asc')->select();
            return json_encode($freelookasc);
        }
        if (input('post.select') == 4) {
            $freelookdesc = db('video')->where(['status' => 1, 'type' => 1])->order('looks desc')->select();
            return json_encode($freelookdesc);
        }

    }
    //所属分类
    public function videoclassarr(){
        $classarr=db('videoclass')->where('status',1)->select();
        $videoarrs=db('video')->where('status',1)->select();
        $arrs=[
            'classarr'=>$classarr,
             'videoarrs'=>$videoarrs
        ];
       return json_encode($arrs);
    }

    //付费视频详情
    public function videomyinfo(Request $request)
    {
        if (request()->isPost()) {
            $collec = db('user')->field('purchase')->where('id', getSessionCookie('memberinf.id'))->find();
            $collecarr = explode(",", $collec["purchase"]);
            if (in_array(input("post.id"), $collecarr)) {
               $videoarry = db('series')->where('status',1)->select();
                $varrys='';
                foreach ($videoarry as $v){
                    $varry = db('video')->where('series', $v['sname'])->select();
                    $varrys[]=$varry;
                }
                $filesinfo = db('video')->where('id', input("post.id"))->find();
                $arr = array(
                    'looks' => $filesinfo["looks"] + 1,
                );
                $num = db('video')->where('id', input("post.id"))->update($arr);
                 $mess = db('videomessage')->where('aid',input("post.id"))->select();
                    $videomess = Category::toLevel($mess);
                    $aboutvideo=db('video')->where(['status'=>1,'pid'=>$filesinfo['pid']])->select();
                if ($num) {
                    $infoarry=[
                        'varrys'=>$varrys,
                        'filesinfo'=>$filesinfo,
                        'videomess'=>$videomess,
                        'aboutvideo'=>$aboutvideo
                    ];
                    return json_encode($infoarry);
                } else {
                    return '未找到相关';
                }
            }else{
                $videoarry = db('series')->where('status',1)->select();
                $varrys='';
                foreach ($videoarry as $v){
                    $varry = db('video')->where('series', $v['sname'])->select();
                    $varrys[]=$varry;
                }
                
                $filesinfo = db('video')->where('id', input("post.id"))->find();
                $arr = array(
                    'looks' => $filesinfo["looks"] + 1,
                );
                $num = db('video')->where('id', input("post.id"))->update($arr);
                 $mess = db('videomessage')->where('aid',input("post.id"))->select();
                    $videomess = Category::toLevel($mess);
                    $aboutvideo=db('video')->where(['status'=>1,'pid'=>$filesinfo['pid']])->select();
                    $barrages=db('barrage')->where(['status'=>1,'type'=>1])->find();
                if ($num) {
                    $infoarry=[
                        'varrys'=>$varrys,
                        'filesinfo'=>$filesinfo,
                        'videomess'=>$videomess,
                        'aboutvideo'=>$aboutvideo,
                        'infomess'=>'未购买',
                        'barrages'=>$barrages
                    ];
                    return json_encode($infoarry);
                } else {
                    return '未找到相关';
                }
            }

        }
    }
    //免费视频详情
    public function videoinfo()
    {
        if (request()->isPost()) {
            $collec = db('user')->where('id', getSessionCookie('memberinf.id'))->find();
           if($collec['oppor']<1){
               $collecarr = explode(",", $collec["purchase"]);
                if (in_array(input("post.id"), $collecarr)) {
                   $freemyinfo = db('video')->where('id', input("post.id"))->find();
               $arr = array(
                   'looks' => $freemyinfo["looks"] + 1,
                   
               );
               $num = db('video')->where('id', input("post.id"))->update($arr);
               if ($num) {
                   $mess = db('videomessage')->where('aid',input("post.id"))->select();
                    $videomess = Category::toLevel($mess);
                    $onvideo=db('video')->where('id',input("post.id"))->find();
                    $aboutvideo=db('video')->where(['status'=>1,'pid'=>$onvideo['pid']])->select();
                     $barrages=db('barrage')->where(['status'=>1,'type'=>0])->find();
                    $mandvarr=[
                         'aboutvideo'=>$aboutvideo,
                            'videomess'=>$videomess,
                            'freemyinfo'=>$freemyinfo,
                            'message'=>'观看次数已用完',
                            'barrages'=>$barrages
                            ];
                    return json_encode($mandvarr);
               } else {
                  return json_encode('未找到相关');
               }
                }else{
                    $freemyinfo = db('video')->where('id', input("post.id"))->find();
                     $mess = db('videomessage')->where('aid',input("post.id"))->select();
                    $videomess = Category::toLevel($mess);
                    $onvideo=db('video')->where('id',input("post.id"))->find();
                    $aboutvideo=db('video')->where(['status'=>1,'pid'=>$onvideo['pid']])->select();
                     $barrages=db('barrage')->where(['status'=>1,'type'=>0])->find();
                    $mandvarr=[
                         'freemyinfo'=>$freemyinfo,
                         'aboutvideo'=>$aboutvideo,
                            'videomess'=>$videomess,
                            'message'=>'观看次数已用完',
                             'barrages'=>$barrages
                            ];
                    return json_encode($mandvarr);
                }
              
           }else{
               $freemyinfo = db('video')->where('id', input("post.id"))->find();
               $arr = array(
                   'looks' => $freemyinfo["looks"] + 1,
               );
               $users = db('user')->where('id', getSessionCookie('memberinf.id'))->find();
                $varr = array(
                  
                   'oppor'=>$users["oppor"] - 1,
               );
               $vnum = db('user')->where('id', getSessionCookie('memberinf.id'))->update($varr);
               $num = db('video')->where('id', input("post.id"))->update($arr);
               if ($num&&$vnum) {
                   $mess = db('videomessage')->where('aid',input("post.id"))->select();
                    $videomess = Category::toLevel($mess);
                    $onvideo=db('video')->where('id',input("post.id"))->find();
                    $aboutvideo=db('video')->where(['status'=>1,'pid'=>$onvideo['pid']])->select();
                    $mandvarr=[
                         'aboutvideo'=>$aboutvideo,
                            'videomess'=>$videomess,
                            'freemyinfo'=>$freemyinfo
                            ];
                    return json_encode($mandvarr);
               } else {
                   return '未找到相关';
               }
           }
        }
    }
    public function videocollt(Request $request)
    {
        $id=$request->param('id');
        $num_collec=db('video')->field('collect')->where('id',$id)->find();
        $num_zan = db('files_info')->field('thumbs')->where('id', $id)->find();
        $filesinfo=[
            'num_collec'=>$num_collec,
            'num_zan'=>$num_zan
        ];
        return json_encode($filesinfo);
    }
    public function colloc(){
        if (request()->isPost()) {
            $id=input('post.id');
            if (input("post.colle")=='zan'){
                $num = db('video')->field('thusum')->where('id', $id)->find();
                $num_collec = $num["thusum"] + 1;
                $arr = [
                    'thusum' => $num_collec,
                ];
                $update = db('video')->where('id', $id)->update($arr);
                if ($update) {
                    return '点赞成功';
                }

            }
            if(!getSessionCookie('memberinf.phone')){
                return '请先登录';
            }elseif(input("post.colle")=='colle') {
                $collec = db('user')->field('collec')->where('id', getSessionCookie('memberinf.id'))->find();
                $collecarr = explode(",", $collec["collec"]);
                if (in_array(input("post.id"), $collecarr)) {
                    return '您已经收藏过了';

                } else {
                    $collecarr[] = input("post.id");
                    $newcollec= ltrim(implode(',', $collecarr),',');
                    $arr = [
                        'collec' => $newcollec,

                    ];
                    $update = db('user')->where('id', getSessionCookie('memberinf.id'))->update($arr);
                    if ($update) {
                        $num = db('video')->field('collecnum')->where('id', $id)->find();
                        $num_collec = $num["collecnum"] + 1;
                        $arr = [
                            'collecnum' => $num_collec,
                        ];
                        $update = db('video')->where('id', $id)->update($arr);
                        if ($update) {
                            return '收藏成功';
                        }

                    }
                }
            }


        }
    }

    //活动一楼留言
    public function filemessage(Request $request){
        if (request()->isPost()){
            if(!getSessionCookie('memberinf.phone')){
                return json_encode('请登录');
            }
            if (empty(input('post.content'))){
                return json_encode('请输入留言内容');
            }
            $id=input('post.id');
            $arr=array(
                'aid'=>$id,
                'u_nickname'=>getSessionCookie('memberinf.username'),
                'u_pic'=>getSessionCookie('memberinf.pic'),
                'u_message'=>input('post.content'),
                'time'=>time(),
                'name'=>input('post.name'),
                'pid'=>0
            );
            $mas=db('videomessage')->insert($arr);
            if ($mas){
                 $mess = db('videomessage')->where('aid',input("post.id"))->select();
                    $videomess = Category::toLevel($mess);
                    $messarr=[
                        'vmessages'=>$videomess,
                        'tinfo'=>'留言成功'
                    ];
                return json_encode($messarr);
            }else{
                return json_encode('留言失败');
            }

        }
    }

    //多楼留言
    public function filedmess(Request $request){
        if (request()->isPost()) {
            $pid=input('post.pid');
            $aid=input('post.aid');
            if (!getSessionCookie('memberinf.phone')) {
                return json_encode('请登录');
            }
            if (empty(input('post.content'))) {
                return json_encode('请输入留言内容');
            }
            if (empty($pid) || empty($aid)) {
                return json_encode('缺少必要参数');
            }
            
            $arr=array(
                'aid'=>$aid,
                'u_nickname'=>getSessionCookie('memberinf.username'),
                'u_pic'=>getSessionCookie('memberinf.pic'),
                'u_message'=>htmlspecialchars(input('post.content')),
                'time'=>time(),
                'name'=>input('post.name'),
                'pid'=>input('post.pid')
            );
            $mas=db('videomessage')->insert($arr);
            if ($mas){
                 $mess = db('videomessage')->where('aid',input("post.aid"))->select();
                    $videomess = Category::toLevel($mess);
                    $messarr=[
                        'vmessages'=>$videomess,
                        'tinfo'=>'留言成功'
                    ];
                return json_encode($messarr);
            }else{
                return json_encode('留言失败');
            }

        }
    }

      public function search(Request $request = null)
    {
        if (request()->isPost()) {
            $soarr = db('video')->where('status', 1)->where('videoname', 'like', '%'.input('post.search').'%')->select();
            if($soarr){
                return json_encode($soarr);
            }else{
               
                return '未找到相关内容';
            }
            
        }
    }
}