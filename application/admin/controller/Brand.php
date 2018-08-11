<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Brand as BrandModel;
class Brand extends Commen {
    /*
     * 品牌列表
     */
    public function index(){
        $data=db('brand')->select();
        return view('',compact('data'));
    }

    /*
     * 品牌添加
     */
    public function store(BrandModel $brand){
        if (request()->isPost()){
            $res=$brand->store(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
            }else{
                $this->error($res['msg']);
            }
        }
        return view('');
    }

    /*
     * 品牌编辑
     */
    public function edit(BrandModel $brand){
        $id=input('param.id');
        if (request()->isPost()){
            $res=$brand->edit(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
            }else{
                $this->error($res['msg']);
            }
        }
        $oldData=db('brand')->where('id',$id)->find();
        //halt($oldData);
        return view('',compact('oldData'));
    }

    /*
     * 删除品牌
     */
    public function del(BrandModel $brand){
        $id=input('get.id');
        $res=$brand->del($id);
        if($res['valid']){
            $this->success($res['msg'],'index');
        }else{
            $this->error($res['msg']);
        }
    }
}
