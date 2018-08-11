<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Link as LinkModel;
class Link extends Commen {
    /*
     * 友链列表首页
     */
    public function index(){
        $data=db('link')->select();
        return view('',compact('data'));
    }

    /*
     * 友链添加
     */
    public function store(LinkModel $link){
        if(request()->isPost()){
            $res=$link->store(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
            }else{
                $this->error($res['msg']);
            }
        }
        return view('');
    }

    /*
     * 友链编辑
     */
    public function edit(LinkModel $link){
        $id=input('param.id');
        if(request()->isPost()){
            $res=$link->edit(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
            }else{
                $this->error($res['msg']);
            }
        }
        $oldData=db('link')->where('id',$id)->find();
        return view('',compact('oldData'));
    }

    /*
     * 删除友链
     */
    public function del(LinkModel $link){
        $id=input('get.id');
        $res=$link->del($id);
        if($res['valid']){
            $this->success($res['msg'],'index');
        }
    }
}
