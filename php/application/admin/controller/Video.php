<?php
namespace app\admin\controller;


use think\Controller;
use think\Request;

class Video extends Controller
{
    //视频分类
    public function videoclass_list(){
        $class=$class=db('videoclass')->paginate(10);
        $this->assign('class',$class);
        $page = $class->render();
        $this->assign('page', $page);
        return $this->fetch();
    }
    public function video_classadd(){
        if (request()->isPost()) {
            if (empty(input('post.'))) {
                return ['error' => false, 'info' => '缺少必要参数！'];
            }
            $result = $this->validate(input('post.'), [
                'classid|视频分类' => 'require|min:1',
            ]);
            if ($result !== true) {
                return ['error' => false, 'info' => $result];
            }
            $arr = array(
                'name' => trim(input('post.classid')),
            );
            if (db('videoclass')->insert($arr)) {
                return ['error' => true, 'info' => '添加成功！'];
            } else {
                return ['error' => false, 'info' => '添加失败'];
            }
        }
        return $this->fetch();
    }

    //删除
    public function video_classdel()
    {
        $id = input('post.id');
        if (empty($id)) {
            return ['error' => false, 'info' => '缺少必要参数！'];
        }
        $res = db('videoclass')->where('id', $id)->field('id,name,status')->find();
        $sel = db('video')->where('pid', $res["name"])->select();
        if ($sel) {
            return ['error' => false, 'info' => '先删除视频，再删除导航！'];
        } else {
            $del = db('videoclass')->where('id', $id)->delete();
            if ($del) {
                return ['error' => true, 'info' => '删除成功！'];
            } else {
                return ['error' => false, 'info' => '删除失败！'];
            }
        }
    }
    //批量
    public function video_classdelall()
    {
        $id = input('post.');
        if (empty($id)) {
            return ['error' => false, 'info' => '没有选中ID！'];
        }
        $arr = $id['ids'];
        $selarr='';
        foreach ($arr as $v) {
            $res = db('videoclass')->where('id',$v)->field('id,name,status')->find();
            $sel = db('video')->where('pid', $res["name"])->select();
            $selarr=$sel;
        }
        if ($selarr) {
            return ['error' => false, 'info' => '先删除视频，再删除导航！'];
        } else {
            $arr = $id['ids'];
            $del = db('videoclass')->delete($arr);
            if ($del) {
                return ['error' => true, 'info' => '删除成功！'];
            } else {
                return ['error' => false, 'info' => '删除失败！'];
            }
        }
    }
    //修改
    public function video_classedit(Request $request){
        $id=intval($request->param('id'));
        $res=db('videoclass')->where('id',$id)->field('id,name,status')->find();
        $this->assign('res',$res);
        if (request()->isPost()){
            if (empty(input('post.id'))){
                return ['error'=>false,'info'=>'缺少必要参数'];
            }
            $result = $this->validate(input('post.'),[
                'classid|视频分类' =>'require|min:1',
            ]);
            if ($result !== true){
                return ['error'=>false,'info'=>$result];
            }
            $arr=array(
                'id'=>input('post.id'),
                'name'=>input('post.classid'),
                'status'=>input('post.status')
            );

            if (db('videoclass')->update($arr)){
                return ['error'=>true,'info'=>'修改成功！'];
            }
            else{
                return ['error'=>false,'info'=>'修改失败！'];
            }
        }
        return $this->fetch();

    }
    //系列
  public function series_list(){
        $class=$class=db('series')->paginate(10);
        $this->assign('class',$class);
        $page = $class->render();
        $this->assign('page', $page);
        return $this->fetch();
    }
    public function series_add(){
        if (request()->isPost()) {
            if (empty(input('post.'))) {
                return ['error' => false, 'info' => '缺少必要参数！'];
            }
            $result = $this->validate(input('post.'), [
                'classid|视频分类' => 'require|min:1',
            ]);
            if ($result !== true) {
                return ['error' => false, 'info' => $result];
            }
            $arr = array(
                'sname' => trim(input('post.classid')),
            );
            if (db('series')->insert($arr)) {
                return ['error' => true, 'info' => '添加成功！'];
            } else {
                return ['error' => false, 'info' => '添加失败'];
            }
        }
        return $this->fetch();
    }

    //删除
    public function series_del()
    {
        $id = input('post.id');
        if (empty($id)) {
            return ['error' => false, 'info' => '缺少必要参数！'];
        }
        $res = db('series')->where('id', $id)->find();
        $sel = db('video')->where('series', $res["sname"])->select();
        if ($sel) {
            return ['error' => false, 'info' => '先删除视频，再删除导航！'];
        } else {
            $del = db('series')->where('id', $id)->delete();
            if ($del) {
                return ['error' => true, 'info' => '删除成功！'];
            } else {
                return ['error' => false, 'info' => '删除失败！'];
            }
        }
    }
    //批量
    public function series_delall()
    {
        $id = input('post.');
        if (empty($id)) {
            return ['error' => false, 'info' => '没有选中ID！'];
        }
        $arr = $id['ids'];
        $selarr='';
        foreach ($arr as $v) {
            $res = db('series')->where('id',$v)->find();
            $sel = db('video')->where('pid', $res["sname"])->select();
            $selarr=$sel;
        }
        if ($selarr) {
            return ['error' => false, 'info' => '先删除视频，再删除导航！'];
        } else {
            $arr = $id['ids'];
            $del = db('series')->delete($arr);
            if ($del) {
                return ['error' => true, 'info' => '删除成功！'];
            } else {
                return ['error' => false, 'info' => '删除失败！'];
            }
        }
    }
    //修改
    public function series_edit(Request $request){
        $id=intval($request->param('id'));
        $res=db('series')->where('id',$id)->find();
        $this->assign('res',$res);
        if (request()->isPost()){
            if (empty(input('post.id'))){
                return ['error'=>false,'info'=>'缺少必要参数'];
            }
            $result = $this->validate(input('post.'),[
                'classid|视频分类' =>'require|min:1',
            ]);
            if ($result !== true){
                return ['error'=>false,'info'=>$result];
            }
            $arr=array(
                'id'=>input('post.id'),
                'sname'=>input('post.classid'),
                'status'=>input('post.status')
            );

            if (db('series')->update($arr)){
                return ['error'=>true,'info'=>'修改成功！'];
            }
            else{
                return ['error'=>false,'info'=>'修改失败！'];
            }
        }
        return $this->fetch();

    }
    //视频
    public function video_edit(Request $request)
    {
        $id=intval($request->param('id'));
          $sarr=db('series')->select();
        $this->assign('sarr',$sarr);
        $res=db('video')->where('id',$id)->find();
        $class=db('videoclass')->select();
        $this->assign('class',$class);
        $this->assign('res',$res);
        if (request()->isPost()){
            if (empty(input('post.id'))){
                return ['error'=>false,'info'=>'缺少必要参数'];
            }
            $result = $this->validate(input('post.'),[
                'title|标题' =>'require|min:1',
                'content|内容' =>'require|min:1',
                'url|外链地址' =>'require|min:1',
                'classid|所属分类' =>'require|min:1',
            ]);
            if ($result !== true){
                return ['error'=>false,'info'=>$result];
            }
            if (empty(input('post.pic'))){
                $arr=array(
                    'id'=>input('post.id'),
                    'series'=>input('post.sname'),
                    'videoname'=>input('post.title'),
                    'videourl' =>input('post.url'),
                    'videocont'=>input('post.content'),
                    'collecnum'=>input('post.collecnum'),
                    'looks'=>input('post.looks'),
                    'thusum'=>input('post.thusum'),
                    'pid'=>input('post.classid'),
                    'type'=>input('post.type'),
                    'single'=>input('post.single'),	
                'pack'=>input('post.pack'),

                );
            }else{
                $arr=array(
                    'id'=>input('post.id'),
                    'series'=>input('post.sname'),
                    'videoname'=>input('post.title'),
                    'videourl' =>input('post.url'),
                    'pic'=>'http://'.$_SERVER['SERVER_NAME'].input('post.pic'),
                    'videocont'=>input('post.content'),
                    'pid'=>input('post.classid'),
                    'type'=>input('post.type'),
                    'single'=>input('post.single'),	
                'pack'=>input('post.pack'),
                );
            }

            if (db('video')->update($arr)){
                return ['error'=>true,'info'=>'修改成功！'];
            }
            else{
                return ['error'=>false,'info'=>'修改失败！'];
            }

        }

        return $this->fetch();

    }

    public function files_eject(Request $request){
        $id=intval($request->param('id'));
        $eject=db('video')->where('id',$id)->field('videocont')->find();
        $this->assign('eject',$eject);
        return $this->fetch();
    }
    public function files_teject(Request $request){
        $id=intval($request->param('id'));
        $eject=db('video')->where('id',$id)->field('videourl')->find();
        $this->assign('eject',$eject);
        return $this->fetch();
    }


    public function video_add()
    {
        $class=db('videoclass')->select();
        $this->assign('class',$class);
          $sarr=db('series')->select();
        $this->assign('sarr',$sarr);
        if (request()->isPost()) {
            if (empty(input('post.'))) {
                return ['error' => false, 'info' => '缺少必要参数！'];
            }
            $result = $this->validate(input('post.'), [
                'title|标题' => 'require|min:1',
                'url|外链地址' => 'require|min:1',
                'content|内容' => 'require|min:1',
                'pic|缩略图' => 'require|min:1',
                'classid|所属分类' => 'require|min:1',
            ]);
            if ($result !== true) {
                return ['error' => false, 'info' => $result];
            }
            $arr=array(
                'videoname'=>input('post.title'),
                'videocont'=>input('post.content'),
                'videourl'=>input('post.url'),
                 'pic'=>'http://'.$_SERVER['SERVER_NAME'].input('post.pic'),
                'time'=>time(),
                'pid'=>input('post.classid'),
                'series'=>input('post.sname'),
                'single'=>input('post.single'),	
                'pack'=>input('post.pack'),
            );
            if (db('video')->insert($arr)){
                return ['error'=>true,'info'=>'添加成功！'];
            }
            else{
                return ['error'=>false,'info'=>'添加失败！'];
            }
        }

        return $this->fetch();

    }

    public function video_list()
    {
       $class=db('video')->select();
        $carr='';
       foreach ($class as $v){
           $cname=db('videoclass')->where('id',$v['pid'])->select();
           $carr=$cname;
       }
        $this->assign('carr',$carr);
        $vio=db('video')->paginate(10);
        $this->assign('class',$class);
        $this->assign('vio',$vio);
        $page = $vio->render();
        $this->assign('page', $page);
        return $this->fetch();
    }

    public function del()
    {
        $id=input('post.id');
        if (empty($id)){
            return ['error'=>false,'info'=>'缺少必要参数！'];
        }
        $del=db('video')->where('id',$id)->delete();
        if ($del){
            return ['error'=>true,'info'=>'删除成功！'];
        }
        else{
            return ['error'=>false,'info'=>'删除失败！'];
        }
    }
}