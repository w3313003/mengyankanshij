<?php
namespace app\admin\controller;


use think\Controller;
use think\Request;
use think\Session;

class Withd extends Controller{
    public function withd_list(){
        $db=db('withd')->order('id asc')->paginate(10);
        $this->assign('db',$db);
        $page = $db->render();
        $this->assign('page', $page);
        return $this->fetch();
    }
    //修改会员
    public function withd_edit(Request $request){
        $id=intval($request->param('id'));
        $res=db('withd')->field('id,status')->where('id',$id)->find();
        $this->assign('res',$res);
        if (request()->isPost()){
            if (empty(input('post.'))){
                return ['error'=>false,'info'=>'缺少必要参数'];
            }
            $arr=array(
                'status'=>input('post.status'),
            );

            if (db('user')->where('id',input('post.id'))->update($arr)){
                return ['error'=>true,'info'=>'编辑成功！'];
            }
            else{
                return ['error'=>false,'info'=>'编辑失败！'];
            }


        }
        return $this->fetch();

    }

    public function withd_del(){
        $id=input('post.id');
        if (empty($id)){
            return ['error'=>false,'info'=>'缺少必要参数！'];
        }
        $del=db('withd')->where('id',input('post.id'))->delete();
        if ($del){
            return ['error'=>true,'info'=>'删除成功！'];
        }
        else{
            return ['error'=>false,'info'=>'删除失败！'];
        }
    }
}