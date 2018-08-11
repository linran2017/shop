<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/9
 * Time: 8:52
 */

namespace app\admin\validate;


use think\Validate;

class Group extends Validate {
    protected $rule=[
        'title'=>'require',
        'rules'=>'require'
    ];
    //提示消息
    protected $message=[
        'title.require'=>'请输入用户组名称',
        'rules.require'=>'请选择用户组权限'
    ];
}