<?php

namespace app\index\controller;

use think\Controller;
use think\Cookie;
use think\Request;

class Commen extends Controller{
    public function __construct(Request $request = null)
    {

        parent::__construct($request);
        //搜索
        if(isset($_GET['keywords'])){
            $keywords=$_GET['keywords'];
            $this->redirect('index/search/index',['keywords'=>$keywords]);
        }
        //购物车的每一个商品属性的数量
        $cartAttrnum=db('cart')->where('cart_uid',session('userid'))
            ->where('cart_checked',1)->field('cart_attrnum')->select();
        //halt($cartAttrnum);
        //先给商品属性数量的总数定义一个初始值
        $totalNum=0;
        //循环购物车的每一个商品属性的数量，
        //依次把他们相加，获得该用户的购物车中商品属性的总数
        foreach ($cartAttrnum as $v){
            $totalNum+=$v['cart_attrnum'];
        }
        //halt($totalNum);
        $this->assign('totalNum',$totalNum);
        //顶级栏目
        $topCategory=db('category')->where('pid',0)->select();
        //二级栏目
        //$buttomCategory=[];
        foreach ($topCategory as $k=>$v){
            $id=$v['id'];
            $category=db('category')->where('pid',$id)->select();
            $topCategory[$k]['bottom']=$category;
        }//halt($topCategory);
        $this->assign('topCategory',$topCategory);
        //网站配置
        $websit=db('websit')->where('id',1)->find();
        $this->assign('websit',$websit);
        //halt($websit);
        //品牌
        $brand=db('brand')->select();
        $this->assign('brand',$brand);
        //友情链接
        $link=db('link')->select();
        $this->assign('link',$link);
        //用户名
        $username=session('username');
        $this->assign('username',$username);
        $userid=session('userid');
        $this->assign('userid',$userid);


    }

    /*
     *保存当前地址
     */
    public function url(){
        //保存当前地址栏地址
        $str=<<<str
<script>
document.cookie='url='+window.location.href;
</script>
str;
        echo $str;
        $url=Cookie::get('url');
        file_put_contents('url.text',$url);
    }
    //去个人中心，加购物车，购物时没有登录去登录
    public function goin(){
        if (!session('userid') && !session('username')){
            $this->redirect('index/login/index');
        }
    }
}
