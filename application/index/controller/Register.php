<?php

namespace app\index\controller;

use think\Controller;
use app\common\model\User;
class Register extends Commen {
    public function index(User $user){
        if(request()->isPost()){
            $res=$user->store(input('post.'));
            if ($res['valid']){
                $this->redirect('index/login/index');
            }
        }
        $title='Knock--注册';
        return view('',compact('title'));
    }

    /*
     * 用户名是否存在
     */
    public function username(){
        if(request()->isAjax()){
            $username=input('post.username');
            //如果用户表中没有这个用户
            $info=db('user')->where('username',$username)->find();
            if(!$info){
                return 1;
            }else{
                return 0;
            }
        }
    }

    /*
  * 发送邮件
  */
    public function sendcaptcha(){
        //p($_POST['email']);
        $mail=new Mail();
        //随机验证码，加密微秒数，从第一个字符开始截取，截取4位
        $captcha=substr(md5(microtime(true)),0,4);
        //把用户的邮箱，给用户发送的验证码，和当前发送验证码的时间存储到session中，
        //用来注册的时候的验证
        session('captcha',$captcha);
        session('email',input('post.email'));
        session('savetime',time());
        $res=$mail->send(input('post.email'),'欢迎您注册“Knock”网站，您注册验证码是：'.$captcha.'，5分钟后验证码失效，千万不能泄露！');
        if($res){
            //发送成功
            echo json_encode(['errorno'=>1,'errormsg'=>'ok']);
        }else{
            //发送失败
            echo json_encode(['errorno'=>0,'errormsg'=>'请联系管理员 发送信息到“linran136@163.com”']);
        }
    }
    /*
     * 邮箱验证码
     */
    public function captcha(){
        if(request()->isAjax()){
            $captcha=input('post.captcha');
            if($captcha!==session('captcha')){
                return 0;
            }else{
                return 1;
            }
        }
    }
}
