<?php
namespace app\admin\controller;


use think\Controller;
use think\Request;
use think\Session;

class Manage extends Controller{

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        if (empty(Session::get('userinfo'))){
            $this->redirect('index/login');
        }
    }

    //显示后台
    public function index(){
        return $this->fetch();

    }

    //管理员设置
    public function set_admin(){
        $res=db('manage')->field('id,username,status')->select();
        $this->assign('db',$res);
        return $this->fetch();
    }


    public function admin_add(){
        if (request()->isPost()){
            if (empty(input('post.'))){
                return ['error'=>false,'info'=>'缺少必要参数！'];
            }
            $result = $this->validate(input('post.'),[
                'username|管理员' =>'require|min:4|max:18|unique:manage',
            ]);
            if ($result !== true){
                return ['error'=>false,'info'=>$result];
            }
            $arr=array(
                'username'=>trim(input('post.username')),
                'password'=>trim(md5(input('post.password')))
            );
            $res=db('manage')->insert($arr);
            if ($res){
                return ['error'=>true,'info'=>'添加成功！'];
            }else{
                return ['error'=>false,'info'=>'添加失败'];
            }

        }
        return $this->fetch();
    }


    public function admin_edit(Request $request){
        $id=intval($request->param('id'));
        $res=db('manage')->field('id,username,status')->where('id',$id)->find();
        $this->assign('res',$res);
        if (request()->isPost()){
            if (empty(input('post.'))){
                return ['error'=>false,'info'=>'缺少必要参数'];
            }
            $arr=array(
                'id'=>input('post.id'),
                'username'=>htmlspecialchars(trim(input('post.username'))),
                'password'=>htmlspecialchars(trim(md5(input('post.password')))),
                'status'=>input('post.status')
            );
            $result = $this->validate(input('post.'),[
                'username|管理员' =>'require|min:4|max:18|unique:manage',
            ]);
            if ($result !== true){
                return ['error'=>false,'info'=>$result];
            }
            $manage= new \app\chest\model\Manage();
            if (false !== $manage->allowField(true)->isUpdate(true)->save($arr)){
                return ['error'=>true,'info'=>'修改成功！'];
            }
            else{
                return ['error'=>false,'info'=>'修改失败！'];
            }


        }
        return $this->fetch();
    }


    public function del(){
        $id=input('post.id');
        if (empty($id)){
            return ['error'=>false,'info'=>'缺少必要参数！'];
        }
        $uid=session('userinfo.id');
        if ($uid == $id){
            return ['error'=>false,'info'=>'不可删除当前管理员！'];
        }
        $del=db('manage')->delete($id);
        if ($del){
            return ['error'=>true,'info'=>'删除成功！'];
        }
        else{
            return ['error'=>false,'info'=>'删除失败！'];
        }

    }

























}