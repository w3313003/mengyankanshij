<?php
namespace app\admin\controller;

use first\Verify;
use think\Controller;
use think\Request;

class Index extends Controller
{

    public function login(Request $request)
    {
        if (request()->isPost()){
            $username=htmlspecialchars(trim(input('post.username')));
            $password=htmlspecialchars(trim(input('post.password')));

            $result = $this->validate(input('post.'),[
                'username|管理员' =>'require|min:4|max:18',
                'password|密码' =>'require|min:6|max:16',
            ]);
            if ($result !== true){
                return ['error'=>false,'info'=>$result];
            }

            if (!$this->check_verify(input('post.code'))){
                return ['error'=>false,'info'=>'验证码错误！'];

            }
            $result = db('manage')->where('username',$username)->find();
            if (false === $result OR md5($password) != $result['password']){
                return ['error'=>false,'info'=>'用户或密码不存在！！'];
            }
            if ($result['status'] !=1){
                return ['error'=>false,'info'=>'账户已被禁用！'];
            }
            //写入session
            unset($result['password']);
            session('userinfo',$result);
            return ['error'=>true,'info'=>'登录成功！','href'=>url('Manage/index')];

        }
        return $this->fetch();

    }

    public function verify(){
        $config =    array(
            'fontSize'    =>    16,    // 验证码字体大小
            'length'      =>    4,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点
//            'fontSize' => 15,
//            'length'   =>3,
//            'useNoise' =>false,
            'codeSet'  =>'0123456789'
        );
        $Verify = new Verify($config);
        $Verify->entry();
    }

    public function check_verify($code, $id = ''){
        $verify = new Verify();
        return $verify->check($code, $id);
    }  //验证码函数调用


    public function loginout(){
        session(null);
        $this->redirect('index/login');
    }
}
