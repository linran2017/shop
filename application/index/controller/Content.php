<?php

namespace app\index\controller;

use think\Controller;

class Content extends Commen {
    public function index(){
        //保存当前地址栏地址
        $this->url();
        //获得地址栏参数，即被点击的商品id
        $goodsId=input('param.goods_id');
        //在商品表中查询商品id为$goodsId的这一条数据
        $goodsData=db('goods')->where('goods_id',$goodsId)->find();
        //在栏目表中查询id为商品goods_cid的这一组数据
        $cateData=db('category')->where('id',$goodsData['goods_cid'])->find();
        //查询所有商品
        $brandData=db('brand')->select();
        //查询栏目表里的顶级栏目
        $topcateData=db('category')->where('pid',0)->select();
        //新品商品
        $newGoods=db('goods')->where('goods_onsale',1)
            ->order('sendtime desc')
            ->limit(4)->select();
        //推荐商品
        $commendData=db('goods')->where('goods_commend',1)
            ->limit(3)->where('goods_onsale',1)->select();
        //查询属性表中所有属于该商品的所有属性
        $attrData=db('attr')->where('attr_gid',$goodsId)->select();
        //先定义一个属性值库存的变量，初始值为0
        $attrStock=0;
        //循环该商品的所有订单
        foreach ($attrData as $v){
            //把属性的库存依次累加，获得该商品的所有属性库存之和
            $attrStock=$attrStock+$v['attr_stock'];
        }
        //halt($attrStock);
        //halt($attrData);
        //halt($commendData);
        //网页头部标题
        $title='Knock--'.$goodsData['goods_title'];
        return view('',compact('title','cateData','attrStock','attrData','commendData','goodsData','brandData','topcateData','newGoods'));
    }
}
