<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/9
 * Time: 8:52
 */

namespace app\admin\validate;


use think\Validate;

class Brand extends Validate {
    protected $rule=[
        'name'=>'require',
        'sort'=>'require|number|between:1,99',
    ];
    //提示消息
    protected $message=[
        'name.require'=>'请输入品牌名称',
        'sort.require'=>'请输入品牌排序',
        'sort.number'=>'品牌排序必须是数字',
        'sort.between'=>'品牌排序必须在1到99之间',
    ];
}