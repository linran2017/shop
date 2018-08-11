<?php

namespace app\admin\controller;

use think\Controller;

class Order extends Commen{
    /*
     * 全部订单列表
     */
    public function index(){
        $data=db('order')->alias('o')
            ->join('user u','o.order_uid=u.userid')->select();
        return view('',compact('data'));
    }

    /*
     * 未付款订单列表
     */
    public function unpay(){
        $data=db('order')->alias('o')
            ->join('user u','o.order_uid=u.userid')
            ->where('order_pay',0)->select();
        return view('',compact('data'));
    }

    /*
     * 已付款订单列表
     */
    public function pay(){
        $data=db('order')->alias('o')
            ->join('user u','o.order_uid=u.userid')
            ->where('order_pay',1)->select();
        return view('',compact('data'));
    }

    /*
     * 订单详情页
     */
    public function detail(){
        //获得订单数据
        $id=input('param.order_id');
        $orderData=db('order')->alias('o')
            ->join('address ad','ad.address_id=o.order_aid')
            ->join('user u','o.order_uid=u.userid')
            ->where('order_id',$id)->find();  // halt($orderData);
        $orderData['buy']=db('buy')->alias('b')
            ->join('attr a','b.buy_attrid=a.attr_id')
            ->join('goods g','g.goods_id=a.attr_gid')
            ->where('buy_oid',$id)->select();
        foreach ($orderData['buy'] as $k=>$v){
            $orderData['buy'][$k]['subtotalprice']=0;
            $orderData['buy'][$k]['subtotalprice']+=$v['buy_attrnum']*$v['goods_price'];
        }
        //halt($oldData)
        return view('',compact('title','orderData'));
    }
}