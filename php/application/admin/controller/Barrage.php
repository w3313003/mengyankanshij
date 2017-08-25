<?php
namespace app\admin\controller;


use think\Controller;
use think\Request;
use think\Session;

class Barrage extends Controller{
    public function barrage_list(){
        $db=db('barrage')->order('id asc')->paginate(10);
        $this->assign('db',$db);
        $page = $db->render();
        $this->assign('page', $page);
        return $this->fetch();
    }
    //修改会员
    public function barrage_edit(Request $request){
        $id=intval($request->param('id'));
        $res=db('barrage')->where('id',$id)->find();
        $this->assign('res',$res);
        if (request()->isPost()){
            if (empty(input('post.'))){
                return ['error'=>false,'info'=>'缺少必要参数'];
            }
            $arr=array(
                'barrage'=>input('post.barrage'),
                'status'=>input('post.status'),
            );

            if (db('barrage')->where('id',input('post.id'))->update($arr)){
                return ['error'=>true,'info'=>'编辑成功！'];
            }
            else{
                return ['error'=>false,'info'=>'编辑失败！'];
            }


        }
        return $this->fetch();

    }
    public function barrage_eject(Request $request){
        $id=intval($request->param('id'));
        $eject=db('barrage')->where('id',$id)->field('barrage')->find();
        $this->assign('eject',$eject);
        return $this->fetch();
    }
}