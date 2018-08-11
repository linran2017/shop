<?php

namespace app\admin\controller;

use app\system\controller\Component;
use houdunwang\arr\Arr;
use think\Controller;
use think\Request;
use app\common\model\Goods as GoodsModel;
class Goods extends Commen {
    public function index(){
        $data=db('goods')->where('goods_onsale',1)
            ->order('goods_sort desc,sendtime desc')->select();
         return view('',compact('data'));
    }

    /*
     *
     * 商品添加
     */
    public function store(GoodsModel $goods){
        if(request()->isPost()){
            $res=$goods->store(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
            }else{
                $this->error($res['msg']);
            }
        }
        //栏目
        $category=db('category')->select();
        $category=Arr::tree($category,'name','id','pid');
        //品牌
        $brand=db('brand')->select();
        return view('',compact('category','brand'));
    }

    /*
     *
     * 商品编辑
     */
    public function edit(GoodsModel $goods){
        $goodsId=input('param.id');
        if(request()->isPost()){
            $res=$goods->edit(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
            }else{
                $this->error($res['msg']);
            }
        }
        //栏目
        $category=db('category')->select();
        $category=Arr::tree($category,'name','id','pid');
        //品牌
        $brand=db('brand')->select();
        //旧数据
        $oldData=db('goods')->where('goods_id',$goodsId)->find();
        return view('',compact('category','brand','oldData'));

    }
    /*
     * 商品下架
     */
    public function unonsale(GoodsModel $goods){
        $goodId=input('param.id');
        $res=$goods->unonsale($goodId);
        if($res['valid']){
            $this->success($res['msg']);
        }
        $data=db('goods')->where('goods_onsale',0)
            ->order('goods_sort desc,sendtime desc')->select();
        return view('',compact('data'));
    }

    /*
     * 商品上架
     */
    public function onsale(GoodsModel $goods){
        $goodId=input('param.id');
        $res=$goods->onsale($goodId);
        if($res['valid']){
            $this->success($res['msg'],'index');
        }
    }

    /*
     * 删除商品
     *
     */
    public function del(GoodsModel $goods){
        $goodsId=input('get.id');
        $res=$goods->del($goodsId);
        if($res['valid']){
            $this->success($res['msg'],'index');
        }else{
            $this->error($res['msg']);
        }
    }
}
