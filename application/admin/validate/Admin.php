<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/9
 * Time: 8:52
 */

namespace app\admin\validate;


use think\Validate;

class Admin extends Validate {
    protected $rule=[
        'username'=>'require',
        'password'=>'require'
    ];
    //提示消息
    protected $message=[
        'username.require'=>'请输入用户名',
        'password.require'=>'请输入密码'
    ];
}