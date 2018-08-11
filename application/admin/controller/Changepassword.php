<?php

namespace app\admin\controller;

use app\common\model\Admin;
use think\Controller;

class Changepassword extends Commen {
    /*
     * 修改后台密码
     *
     */
 /*   public function changepassword(Admin $admin){
      //halt(session('admin_id'));
        if(request()->isPost()){
            $res=$admin->changepassword(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'admin/entry/index');
            }else{
                $this->error($res['msg']);
            }
        }
        return view('');
    }*/
}
