<?php

namespace app\admin\controller;

use think\auth\Auth;
use think\Controller;
use think\Request;

class Commen extends Controller{
    public function __construct(){
        if(!session('admin_id'&& !session('admin_username'))){
            $this->redirect('admin/login/login');
        }
        //规则验证
        $rule=request()->module() . '/' .request()->controller() . '/' . request()->action();
        //halt($rule);
        //执行验证
        $res=(new Auth())->check($rule,session('admin_id'));
        if(!$res){
            $this->error('抱歉，您没有操作权限!');
        }
    }
}