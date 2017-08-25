<?php
namespace app\admin\controller;


use think\Controller;
use think\Request;
use think\Session;

class Rebate extends Controller{
    public function rebate_list(){
        $db=db('rebate')->where('id',1)->find();
        $this->assign('db',$db);
        return $this->fetch();
    }
    public function rebate_edit(){
        $db=db('rebate')->where('id',1)->find();
        $this->assign('db',$db);
        if (request()->isPost()){
            if (empty(input('post.'))){
                return ['error'=>false,'info'=>'缺少必要参数'];
            }
            $arr=array(
                'first'=>input('post.first'),
                'second'=>input('post.second'),
            );

            if (db('rebate')->where('id',input('post.id'))->update($arr)){
                return ['error'=>true,'info'=>'编辑成功！'];
            }
            else{
                return ['error'=>false,'info'=>'编辑失败！'];
            }


        }
        return $this->fetch();
    }
}