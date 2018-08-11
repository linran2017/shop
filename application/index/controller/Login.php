<?php

namespace app\index\controller;

use houdunwang\crypt\Crypt;
use think\Controller;
use app\common\model\User;
class Login extends Commen {
    /*
     * 用户登录
     */
    public function index(User $user){
        if(request()->isPost()){
            $res=$user->login(input('post.'));
            if ($res['valid']){
                $url=file_get_contents('url.text');
                if($url){
                    $this->redirect($url);
                }else{
                    $this->redirect('/');
                }
            }
        }
        $title='Knock--登录';
        return view('',compact('title'));
    }

    /*
     * 用户名验证
     */
    public function username(){
        if(request()->isAjax()){
            $username=input('post.username');
            $info=db('user')->where('username',$username)->find();
            if($info){
                return 1;
            }else{
                return 0;
            }
        }
    }

    /*
     * 密码验证
     */
    public function userpassword(){
        $username=input('post.username');
        $userpassword=input('post.userpassword');
        $info=db('user')->where('username',$username)->find();
        $userpassword=Crypt::encrypt($userpassword);
        if ($userpassword==$info['userpassword']){
            return 1;
        }else{
            return 0;
        }
    }

    /*
     * 用户退出
     */
    public function logout(){
        session(null);
        $this->redirect('index/login/index');
    }
}
