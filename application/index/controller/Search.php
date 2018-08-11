<?php

namespace app\index\controller;

use think\Controller;

class Search extends Commen{
    /*
     * 搜索页面
     */
    public function index(){
        //记住当前地址
        $this->url();
        $keywords=input('param.keywords');
        //halt($keywords);
        //在商品表中查询商品名称和搜索关键词一样的字段
       $data=db('goods')->where('goods_title','like','%'.$keywords.'%')
           ->select();
       //halt($data);
        $page=$keywords;
        //网页头部标题
        $title='Knock--搜索';
        return view('',compact('title','data','page'));
    }
}
