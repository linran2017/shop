<?php

namespace app\admin\controller;

use houdunwang\arr\Arr;
use think\Controller;
use app\common\model\Category  as CategoryModel;
class Category extends Commen{
    /*
     * 栏目列表
     */
    public function index(){
        $data=db('category')->select();
        $data=Arr::tree($data,'name','id','pid');
        return view('',compact('data'));
    }
    /*
     * 栏目添加
     */
    public function store(CategoryModel $category){
        if(request()->isPost()){
            $res=$category->store(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
            }else{
                $this->error($res['msg']);
            }
        }
        return view('');
    }
    /*
     * 添加子类
     */
    public function addson(CategoryModel $category){
        $id=input('param.id');
        if(request()->isPost()){
            $res=$category->store(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
            }else{
                $this->error($res['msg']);
            }
        }
        $data=db('category')->where('id',$id)->find();
        return view('',compact('data'));
    }

    /*
     * 编辑栏目
     */
    public function edit(CategoryModel $category){
        $id=input('param.id');
        $oldData=db('category')->where('id',$id)->find();
        //获得自己和子类以外的栏目
        $categoryData=$category->getCategoryData($id);
        if(request()->isPost()){
            $res=$category->edit(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
            }else{
                $this->error($res['msg']);
            }
        }
        return view('',compact('oldData','categoryData'));
    }

    /*
     * 删除栏目
     */
    public function del(CategoryModel $category){
        $id=input('get.id');
        $res=$category->del($id);
        if($res['valid']){
            $this->success($res['msg'],'index');
        }else{
            $this->error($res['msg']);
        }
    }
}