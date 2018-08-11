<?php

namespace app\common\model;

use think\Model;
use app\common\model\Buy;
class Order extends Model{
    protected $table='store_order';
    protected $pk='order_id';
    //自动添加用户id
    protected $auto=['order_uid'];
    //自动添加创建订单时间
    protected $insert=['order_createtime'];
    protected function setOrderUidAttr(){
        return session('userid');
    }
    protected function setOrderCreatetimeAttr(){
        return time();
    }

    /*
     * 添加订单时间
     */
    public function store($data){

        //订单编号为当前时间加随机数md5加密后取前10位字符
        $data['order_code']=substr(md5(date('ymdHis').mt_rand(0,9999999)),0,10);
        $this->save($data);
        //获得购物车中选中的商品
        $buy=db('cart')->where('cart_uid',session('userid'))
            ->where('cart_checked',1)->select();
        //halt($buy);
        //获得该订单的id
        $orderId=db('order')->where('order_code',$data['order_code'])
            ->value('order_id');
        foreach ($buy as $k=>$v){
            $attr=[];
            $attr['buy_attrid']=$v['cart_attrid'];
            $attr['buy_attrnum']=$v['cart_attrnum'];
            $attr['buy_oid']=$orderId;
            $buy=new Buy();
            $buy->store($attr);
        }
        return ['valid'=>1,'id'=>$orderId];
    }

    /*
     * 订单处理
     */
        public function handle($data){
           $this->save($data,[$this->pk=>$data['order_id']]);
           //获得该订单编号
           $id=$data['order_id'];
           //获得该订单下面的所有商品属性
           $attr=db('buy')->where('buy_oid',$id)->select();
           //该订单下的所有商品属性的库存减去购买的库存
           foreach ($attr as $v){
               $attrid=$v['buy_attrid'];
               $attrnum=$v['buy_attrnum'];
               db('attr')->where('attr_id',$attrid)->setDec('attr_stock',$attrnum);
           }
           return ['valid'=>1];
    }
}