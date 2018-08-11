<?php

namespace app\common\model;

use think\Model;

class Cart extends Model{
    protected $table='store_cart';
    protected $pk='cart_id';
    protected $auto=['cart_uid'];
    //自动添加用户编号
    protected function setCartUidAttr(){
        return session('userid');
    }

    /*
     * 添加购物车数据
     */
    public function store($data){
        $cartAid=$data['cart_attrid'];
        $cart=db('cart')->where('cart_attrid',$cartAid)
            ->where('cart_uid',session('userid'))->find();
        if($cart){
            //如果存在这个商品属性就增加数量
            //获得该属性的库存
            $stock=db('attr')->where('attr_id',$data['cart_attrid'])
                ->value('attr_stock');
            //获得之前购物车里这个属性的数量
            $afterNum=db('cart')->where('cart_attrid',$cartAid)
                ->where('cart_uid',session('userid'))->value('cart_attrnum');
            //如果增加后的数量大于库存
            if($afterNum+$data['cart_attrnum']>$stock){
                return ['valid'=>0];
            }else{
                $result=db('cart')->where('cart_attrid',$cartAid)
                    ->where('cart_uid',session('userid'))
                    ->setInc('cart_attrnum',$data['cart_attrnum']);
                if ($result){
                    return ['valid'=>1];
                }
            }

        }else{
            //如果没有就添加一条购物车数据
            $result=$this->allowField(true)->save($data);
            if ($result){
                return ['valid'=>1];
            }
        }

    }

    /*
     * 更改购物车里商品的属性
     */
    public function num($data){
        $result=db('cart')->where('cart_id',$data['cart_id'])
            ->update(['cart_attrnum'=>$data['cart_attrnum']]);
        if($result){
            return 1;
        }
    }

    /*
     * 更改购物车中的选中
     */
    public function checked($data){
        $result=db('cart')->where('cart_id',$data['cart_id'])
            ->update(['cart_checked'=>$data['cart_checked']]);
        if($result){
            return 1;
        }
    }

    /*
     * 全选更改
     */
    public function allchecked($data){
       //halt($data);
        $result=db('cart')->where('cart_uid',session('userid'))
            ->update(['cart_checked'=>$data['cart_checked']]);
        if($result){
            return 1;
        }
    }

    /*
     * 删除购物车中所有被选中的商品
     */
    public function alldel(){
        $result=db('cart')->where('cart_uid',session('userid'))
            ->where('cart_checked',1)->delete();
        if($result){
            return 1;
        }
    }

}