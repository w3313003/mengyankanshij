<?php
namespace app\admin\controller;


use think\Controller;
use think\Request;
use think\Session;

class Free extends Controller{
    public function free_list(){
        $db=db('free')->select();
        $this->assign('db',$db);
        return $this->fetch();
    }
    public function free_edit(Request $request){
        $id=intval($request->param('id'));
        $db=db('free')->where('id',$id)->find();
        $this->assign('db',$db);
        if (request()->isPost()){
            if (empty(input('post.'))){
                return ['error'=>false,'info'=>'缺少必要参数'];
            }
            $arr=array(
                'base'=>input('post.base'),
                'givefree'=>input('post.givefree'),
            );

            if (db('free')->where('id',input('post.id'))->update($arr)){
                return ['error'=>true,'info'=>'编辑成功！'];
            }
            else{
                return ['error'=>false,'info'=>'编辑失败！'];
            }


        }
        return $this->fetch();
    }
}