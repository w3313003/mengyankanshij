<?php
namespace app\index\controller;

use app\common\controller\Common;
use app\index\model\Send;
use think\Db;

class Index extends Common
{
    public function index()
    {
       $banner= db('banner')->where('status',1)->select();
        $videonew=db('video')->where('status',1)->order('time desc')->select();
        $videohot=db('video')->where('status',1)->order('looks asc')->select();
       $arrs=[
           'banner'=>$banner,
           'videonew'=>$videonew,
           'videohot'=>$videohot,
       ];
        return json_encode($arrs);

    }

    public function register()
    {
        if (request()->isPost()) {
            $user=db('user')->where('phone',trim(input('post.phone')))->find();
            if($user){
                return json_encode('用户已存在');
            }
            if(empty(trim(input('post.phone')))){
                return json_encode('手机号码不能为空');
            }

            if(empty(trim(input('post.password')))){
                return json_encode('密码不能为空');
            }
             if(empty(trim(input('post.age')))){
                return json_encode('年龄不能为空');
            }
        if (getSessionCookie('code') == input('post.code')&&getSessionCookie('mobile') ==trim(input('post.phone'))) {
            $yourscode=db('user')->where(['status'=>1,'yourscode'=>trim(input('post.yourscode'))])->find();
           if ($yourscode!=false || trim(input('post.yourscode'))==''){
             
               $arr = array(
                   'phone' =>empty(getSessionCookie('mobile'))?trim(input('post.mobile')):getSessionCookie('mobile'),
                   'password'=>md5(trim(input('post.password'))),
                   'username'=>'eyes_'.time(),
                   'pic' =>'http://'.$_SERVER['SERVER_NAME'].'/static/index/images/moren.png',
                   'yourscode'=>trim(input('post.yourscode'))==''?time().rand(100, 999):trim(input('post.yourscode')),
                   'mycode'=>time().rand(100, 999),
                   'time'=>time(),
                   'sex'=>trim(input('post.sex'))==1?'男':'女',
                   'age'=>trim(input('post.age')),
                   'oppor'=>3
               );
               $insert=db('user')->insert($arr);
               if($insert){
                   if (!empty(trim(input('post.yourscode')))){
                       $arr=array(
                           'oppor'=>  $yourscode['oppor']+3,
                       );
                       db('user')->where('phone',$yourscode['phone'])->update($arr);
                       return json_encode('注册完成');
                   }else{
                       return json_encode('注册完成');
                   }

               }else{
                   return json_encode('注册失败');
               }
           }else{
               return json_encode('请输入正确的邀请码');
           }

        }else{
            return json_encode('验证码错误！');
        }

    }
    }
    public function mobiles()
    {  if (request()->isPost()) {
        header('Content-Type: text/plain; charset=utf-8');
        vendor('api_demo.SmsDemo');
        if(empty(input('post.mobile'))){
            return '手机号码不能为空';
        }
        $number=rand("100000", "999999");
        $accessKeyId='LTAIvoyxIucLso3A';
        $accessKeySecret='uBPdPg9FqxwznIOad4TrK0rq6ZZZEJ';
        $demo = new \SmsDemo($accessKeyId,$accessKeySecret);
        $signName='安徽融发信息咨询有限公司';
        $templateCode='SMS_78400025';
        $phoneNumbers=input('post.mobile');
        $templateParam =[
            "name" => ''.$number.'',
            "product" => "dsd"
        ];
        $outId = null;
        $response = $demo->sendSms($signName,$templateCode,$phoneNumbers,$templateParam, $outId);
        setSessionCookie('code',$templateParam['name']);
        setSessionCookie('mobile',$phoneNumbers);
        if ($response){
            return json_encode('短信下发成功');
        }else{
            return json_encode('网络繁忙，稍后再试');
        }
    }

    }
    public function reset()
    {
         if (request()->isPost()) {
             $user=db('user')->where('phone',getSessionCookie('mobile'))->find();
         if (getSessionCookie('code') ==input('post.code')&& $user['phone'] == input('post.mobile')) {
           $users=db('user')->where('phone',getSessionCookie('mobile'))->find();
            if (trim(input('post.password')) === trim(input('post.tpassword'))) {
                if(md5(trim(input('post.password')))!=$users['password']){
                $arr = ['password' => md5(trim(input('post.password')))];
                $rests=db('user')->where('phone',getSessionCookie('mobile'))->update($arr);
                if($rests){
                    return json_encode('修改密码完成');
                }else{
                    return json_encode('修改密码失败');
                }
                }else{
                    return json_encode('密码不能为原始密码');
                }    
            }else{
               return json_encode('两次密码不相同'); 
            }
        }else{
            return json_encode('验证码或手机号码不正确'); 
        }
     }
}

    public function login()
    {
            $username=htmlspecialchars(trim(input('post.username')));
            $password=htmlspecialchars(trim(input('post.password')));
            if (empty($username)){
                return json_encode('手机用户名不能为空');
            }
            if (empty($password)){
                return json_encode('密码不能为空');
            }
            $result = db('user')->where('phone',$username)->find();
            if (false === $result OR md5($password) != $result['password']){
                return json_encode('手机号或密码不存在');
            }
            if (true === $result and $result['status'] !=1){
                return ('该会员被禁用，请联系客服');
            }
            //写入session
            if ($result){
                unset($result['password']);
                setSessionCookie('memberinf',$result);
                return '登录成功';
            }

    }

    public function loginout(){
        session(null);
        cookie(null);
        return '退出成功';
    }

}
