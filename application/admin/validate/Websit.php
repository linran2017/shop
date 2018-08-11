<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/9
 * Time: 8:52
 */

namespace app\admin\validate;


use think\Validate;

class Websit extends Validate {
    protected $rule=[
        'name'=>'require',
        'logo'=>'require',
        'introduce'=>'require',
        'address'=>'require',
        'tel'=>'require',
        'copyright'=>'require',
        'email'=>'require|email',
    ];
    //提示消息
    protected $message=[
        'name.require'=>'请输入公司名称',
        'logo.require'=>'请上传公司图标',
        'introduce.require'=>'请输入公司简介',
        'address.require'=>'请输入公司地址',
        'tel.require'=>'请输入公司电话',
        'copyright.require'=>'请输入版权信息',
        'email.require'=>'请输入公司邮箱',
        'email.email'=>'邮箱格式不正确',
    ];
}