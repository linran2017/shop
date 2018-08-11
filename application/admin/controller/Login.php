<?php

namespace app\admin\controller;

use app\common\model\Admin;
use houdunwang\crypt\Crypt;
use think\Controller;

class Login extends Controller{
    /*
     * 后台管理员登录
     */
    public function login(Admin $admin){
        //halt(Crypt::encrypt('admin888'));
        if(request()->isPost()){
            $res=$admin->login(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'admin/entry/index');
            }else{
                $this->error($res['msg']);
            }
        }
        return $this->fetch();
    }
    /*
     * 退出登录
     */
    public function logout(){
        session(null);
        $this->success('退出成功','admin/login/login');
    }
}
