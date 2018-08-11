<?php
namespace app\index\controller;

use think\Controller;

class Index extends Commen {
    public function index(){
        //保存当前地址栏地址
        $this->url();
        //网页头部标题
        $title='Knock--首页';
        //新品商品
        $newGoods=db('goods')->where('goods_onsale',1)
            ->order('sendtime desc')
            ->limit(3)->select();
        //推荐宝贝
        $commendGoods=db('goods')->where('goods_commend',1)
            ->limit(3)->select();
        //热卖宝贝
        $hotGoods=db('goods')->where('goods_hot',1)
            ->limit(3)->select();
        return view('',compact('title','newGoods','commendGoods','hotGoods'));

    }
}
