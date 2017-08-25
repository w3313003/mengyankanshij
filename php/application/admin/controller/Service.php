<?php
namespace app\admin\controller;


use think\Controller;
use think\Request;
use think\Session;
class Service extends Controller{
    public function service_list(){
        $ban=db('service')->select();
        $this->assign('db',$ban);
        return $this->fetch();
    }
    public function service_edit(Request $request){
        $id=intval($request->param('id'));
        $this->assign('id',$id);
        if (request()->isPost()){
            if (empty(input('post.id'))){
                return ['error'=>false,'info'=>'缺少必要参数！'];
            }
            if (empty(input('post.pic'))){
                return ['error'=>false,'info'=>'请上传照片！'];
            }
            $arr=array(
                'spic'=>'http://'.$_SERVER['SERVER_NAME'].input('post.pic'),
            );
            if (db('service')->where('id',input('post.id'))->update($arr)){
                return ['error'=>true,'info'=>'修改成功！'];
            }
            else{
                return ['error'=>false,'info'=>'修改失败！'];
            }


        }
        return $this->fetch();
    }
    public function uploads(){
        $file = request()->file('file');
        $savePath = ROOT_PATH . 'public' . DS . 'uploads';
        $info = $file->validate(['size'=>4048000000,'ext'=>'jpg,png,gif,jpeg'])->move($savePath);
        if (!$info){
            return json(['error'=>false,'info'=>$file->getError()]);
        }
//        $imgpath = $savePath.DS.$info->getSaveName();
        // $this->img($imgpath);
        $path2=str_replace('\\','/',$info->getSaveName());
        return json(['error'=>true,'info'=>'上传成功！','file'=>'/uploads/'.$path2]);
    }
}