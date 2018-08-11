<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/9
 * Time: 8:52
 */

namespace app\admin\validate;


use think\Validate;

class Category extends Validate {
    protected $rule=[
        'name'=>'require',
        'pid'=>'require',
        'sort'=>'require|number|between:1,99',
    ];
    //提示消息
    protected $message=[
        'name.require'=>'请输入栏目名称',
        'pid.require'=>'请选择所属栏目',
        'sort.require'=>'请输入栏目排序',
        'sort.number'=>'栏目排序必须是数字',
        'sort.between'=>'栏目排序必须在1到99之间',
    ];
}