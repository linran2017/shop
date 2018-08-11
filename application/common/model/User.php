<?php

namespace app\common\model;

use houdunwang\crypt\Crypt;
use think\Model;

class User extends Model{
    protected $table='store_user';
    protected $pk='userid';
    /*
     * 用户注册，把用户名和密码保存到用户表里
     */
    public function store($data){
        //halt($data);
        $data['userpassword']=Crypt::encrypt($data['userpassword']);
        $result=$this->allowField(true)->save($data);
        if($result){
            return ['valid'=>1];
        }
    }

    /*
     * 用户登录
     */
    public function login($data){
        $info=db('user')->where('username',$data['username'])->find();
        session('username',$info['username']);
        session('userid',$info['userid']);
        return ['valid'=>1];
    }
}
