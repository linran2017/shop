<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/9
 * Time: 8:52
 */

namespace app\admin\validate;


use think\Validate;

class Link extends Validate {
    protected $rule=[
        'name'=>'require',
        'url'=>'require',
    ];
    //提示消息
    protected $message=[
        'name.require'=>'请输入友链名称',
        'sort.require'=>'请输入友链】网址',
    ];
}