<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/9
 * Time: 8:52
 */

namespace app\admin\validate;


use think\Validate;

class Attr extends Validate {
    protected $rule=[
        'attr_name'=>'require',
        'attr_img'=>'require',
        'attr_stock'=>'require|number',
    ];
    //提示消息
    protected $message=[
        'attr_name.require'=>'请输入属性名称',
        'attr_img.require'=>'请上传属性图片',
        'attr_stock.require'=>'请输入属性库存',
        'attr_stock.number'=>'商品属性必须是数字',
    ];
}