<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/9
 * Time: 8:52
 */

namespace app\admin\validate;


use think\Validate;

class Goods extends Validate {
    protected $rule=[
        'goods_title'=>'require',
        'goods_cid'=>'require',
        'goods_bid'=>'require',
        'goods_master'=>'require',
        'goods_price'=>'require|number',
        'goods_sort'=>'require|number|between:1,999',
        'goods_introduce'=>'require',
    ];
    //提示消息
    protected $message=[
        'goods_title.require'=>'请输入商品名称',
        'goods_cid.require'=>'请上选择所属栏目',
        'goods_bid.require'=>'请选择商品品牌',
        'goods_master.require'=>'请上传商品主图',
        'goods_price.require'=>'请输入商品价格',
        'goods_price.number'=>'商品价格必须是数字',
        'goods_sort.require'=>'请输入商品排序',
        'goods_sort.number'=>'商品排序必须为数字',
        'goods_sort.between.'=>'商品排序必须在1到999之间',
        'goods_introduce.require'=>'请输入商品介绍',
    ];
}