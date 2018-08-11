<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Attr as AttrModel;
class Attr extends Commen {

    /*
     * 属性列表
     */
    public function index(){
        $goodsId=input('param.id');
        $data=db('attr')->where('attr_gid',$goodsId)->select();
        return view('',compact('data'));
    }

    /*
     * 属性添加
     */
    public function store(AttrModel $attr){
        if (request()->isPost()){
            $res=$attr->store(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'admin/goods/index');
            }else{
                $this->error($res['msg']);
            }
        }
        return view('');
    }

    /*
     * 属性添加
     */
    public function edit(AttrModel $attr){
        $attrId=input('param.id');
        if (request()->isPost()){
            $res=$attr->edit(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'admin/goods/index');
            }else{
                $this->error($res['msg']);
            }
        }
        $oldData=db('attr')->where('attr_id',$attrId)->find();
        return view('',compact('oldData'));
    }

    /*
     * 删除属性
     */
    public function del(AttrModel $attr){
        $attrId=input('get.id');
        $res=$attr->del($attrId);
        if($res['valid']){
            $this->success($res['msg'],'admin/goods/index');
        }else{
            $this->error($res['msg']);
        }
    }
}
