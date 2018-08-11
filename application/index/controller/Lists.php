<?php

namespace app\index\controller;

use think\Controller;
use app\common\model\Goods;
class Lists extends Commen{
    public function index(){
        //保存当前地址栏地址
        $this->url();
        $topcateId=input('param.topcate_id');
        $cateId=input('param.cate_id');
        $brandId=input('param.brand_id');
        //如果点击的是顶级栏目
        if($topcateId){
            //是顶级栏目
            //栏目名称
            $page=db('category')->where('id',$topcateId)->value('name');
            //获得顶级栏目下的所有栏目
            $cateData=db('category')->where('pid',$topcateId)->select();
            //halt($cateData);
            //先定义一个存储商品数据的空数组
            $goodsData=[];
            //先定义一个存储栏目id的空数组把被点击的顶级栏目的id追加到栏目id里
            $cateIds[]=$topcateId;
            //循环栏目数据，
            foreach ($cateData as $v){
                //依次把二级栏目id添加到栏目id的数组里
                $cateIds[]=$v['id'];
            }
            //如果存在$_GET['a']
            if(isset($_GET['a'])){
                $sort=$_GET['a'];
                //如果$_GET['a']等于price
                if($sort=='price'){
                    //就找到顶级栏目和该顶级栏目下的二级栏目下的所有商品，把商品按价格升序排序
                    $goodsData=db('goods')->whereIn('goods_cid',$cateIds)
                        ->order('goods_'.$sort.' asc')
                        ->where('goods_onsale',1)->select();
                    //如果$_GET['a']等于updatetime
                }else if($sort=='updatetime'){
                    //就找到顶级栏目和该顶级栏目下的二级栏目下的所有商品，按更新时间降序排序
                    $goodsData=db('goods')->whereIn('goods_cid',$cateIds)
                        ->order($sort.' desc')
                        ->where('goods_onsale',1)->select();
                }

            }else{
                //如果没有$_GET['a']，就找到顶级栏目和该顶级栏目下的二级栏目下的所有商品
                $goodsData=db('goods')->whereIn('goods_cid',$cateIds)
                    ->where('goods_onsale',1)->select();
            }
        }

        //如果点击的是二级栏目
        if($cateId){
            //获得二级栏目的名称
            $page=db('category')->where('id',$cateId)->value('name');
            //如果存在$_GET['a']
            if (isset($_GET['a'])){
                $sort=$_GET['a'];
                //如果$_GET['a']等于price
                if ($sort=='price'){
                    //就找到该栏目下的所有商品，并且按价格升序排序
                    $goodsData=db('goods')->where('goods_cid',$cateId)
                        ->order('goods_'.$sort.' asc')
                        ->where('goods_onsale',1)->select();
                    //如果$_GET['a']等于updatetime
                }else if($sort=='updatetime'){
                    //就找到该栏目下的所有商品，并且按更新时间降序排序
                    $goodsData=db('goods')->where('goods_cid',$cateId)
                        ->order($sort.' desc')
                        ->where('goods_onsale',1)->select();
                }
                //如果没有$_GET['a']，就找到该栏目下的所有商品
            }else{
                $goodsData=db('goods')->where('goods_cid',$cateId)
                    ->where('goods_onsale',1)->select();
            }
            //halt($goodsData);

        }
        //如果点击是品牌
        if($brandId){
            //获得品牌名称
           $page=db('brand')->where('id',$brandId)->value('name');
            //如果存在$_GET['a']
            if (isset($_GET['a'])){
                $sort=$_GET['a'];
                //如果$_GET['a']等于price
                if ($sort=='price'){
                    //就找到该品牌下的所有商品，并且按价格升序排序
                    $goodsData=db('goods')->where('goods_bid',$brandId)
                        ->where('goods_onsale',1)
                        ->order('goods_'.$sort.' asc')->select();
                    //如果$_GET['a']等于updatetime
                }else if($sort=='updatetime'){
                    //就找到该品牌下的所有商品，并且按更新时间降序排序
                    $goodsData=db('goods')->where('goods_bid',$brandId)
                        ->where('goods_onsale',1)
                        ->order($sort.' desc')->select();
                }
            }else{
                //如果没有$_GET['a']，就找到该品牌下的所有商品
                $goodsData=db('goods')->where('goods_bid',$brandId)
                    ->where('goods_onsale',1)->select();
            }
        }
        //获得商品数量
        $num=count($goodsData);

        // halt($num);
        //halt($goodsData);
        //获取所有品牌
        $brandData=db('brand')->order('sort desc')->select();
        //网页头部标题
        $title='Knock--'.$page;
        //halt($page);
        return view('',compact('title','cateData','page','goodsData','brandData','num'));
    }

}