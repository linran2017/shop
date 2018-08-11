<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/9
 * Time: 8:52
 */

namespace app\admin\validate;


use think\Validate;

class Rule extends Validate {
    protected $rule=[
        'title'=>'require',
        'name'=>'require',
        'pid'=>'require',
        'nav'=>'require'
    ];
    //提示消息
    protected $message=[
        'title.require'=>'请输入规则中文名',
        'name.require'=>'请输入规则标识',
        'pid.require'=>'请现在所属规则',
        'nav.require'=>'请输入规则导航',
    ];
}