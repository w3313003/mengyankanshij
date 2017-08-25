<?php
namespace app\admin\controller;


use think\Controller;
use think\Request;
use think\Session;

class Member extends Controller{

    public function member_list(){
        $db=db('user')->order('id asc')->paginate(10);
        $this->assign('db',$db);
        $page = $db->render();
        $this->assign('page', $page);
        return $this->fetch();
    }
    public function member_eject(Request $request){
        $id=intval($request->param('id'));
        $eject=db('user')->where('id',$id)->field('collec')->find();

        $arr= explode(',',$eject['collec']);
        $videosarr='';
        foreach ($arr as $vs) {
            $videos = db('video')->where('id', $vs)->field('videoname')->find();
            $videosarr[] = $videos;
        }
        $news='';
        foreach ($videosarr as $v) {
            $news[] = $v['videoname'];
        }
        $newarr=implode(',',$news);
        $this->assign('newarr',$newarr);
        return $this->fetch();
    }
    public function member_seject(Request $request){
        $id=intval($request->param('id'));
        $eject=db('user')->where('id',$id)->field('purchase')->find();

        $arr= explode(',',$eject['purchase']);
        $videosarr='';
        foreach ($arr as $vs) {
            $videos = db('video')->where('id', $vs)->field('videoname')->find();
            $videosarr[] = $videos;
        }
        $news='';
        foreach ($videosarr as $v) {
            $news[] = $v['videoname'];
        }
        $newarr=implode(',',$news);
        $this->assign('newarr',$newarr);
        return $this->fetch();
    }

    //修改会员
    public function member_edit(Request $request){
        $id=intval($request->param('id'));
        $res=db('user')->field('id,status')->where('id',$id)->find();
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

    //删除
    public function member_del(){
        $id=input('post.id');
        if (empty($id)){
            return ['error'=>false,'info'=>'缺少必要参数！'];
        }
        $del=db('user')->where('id',input('post.id'))->delete();
        if ($del){
            return ['error'=>true,'info'=>'删除成功！'];
        }
        else{
            return ['error'=>false,'info'=>'删除失败！'];
        }
    }
}