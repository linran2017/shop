<?php

namespace app\common\model;

use houdunwang\crypt\Crypt;
use think\Loader;
use think\Model;
use think\Validate;

class Admin extends Model{
    protected $table='store_admin';
    protected $pk='id';
    /*
     * 后台登录
     */
    public function login($data){
        //halt($data);
        $validate=Loader::validate('Admin');
        if(!$validate->check($data)){
            //halt($validate->getError());
            return ['valid'=>0,'msg'=>$validate->getError()];
        }
        //如果在后台用户表中没有找到这个用户名，证明用户不存在
        $info=db('admin')->where('username',$data['username'])->find();
        //halt($info);
        if(!$info){
            return ['valid'=>0,'msg'=>'该用户不存在'];
        }

        //如果用户输入的密码加密后和这一条用户的密码不相等，证明密码错误
        $res=Crypt::encrypt($data['password'])==$info['password'];
        if(!$res){
            return ['valid'=>0,'msg'=>'密码错误'];
        }
        //登录成功，session保存用户信息
        session('admin_id',$info['id']);
        session('admin_username',$info['username']);
        return ['valid'=>1,'msg'=>'登录成功'];
    }
    /*
     * 修改密码
     */
   /* public function changepassword($data){
        //halt($data);
        //执行应用
        $validate=new Validate([
            'password'=>'require',
            'new_password'=>'require',
            'confirm_password'=>'require|confirm:new_password'
        ],[
            'password.require'=>'请输入旧密码',
            'new_password.require'=>'请输入新密码',
            'confirm_password.require'=>'请确认新密码',
            'confirm_password.confirm'=>'确认密码和新密码不一致'
        ]);
        if(!$validate->check($data)){
            return ['valid'=>0,'msg'=>$validate->getError()];
        }
        //验证旧密码是否正确
        $password=Crypt::encrypt($data['password']);
        $newPassword=Crypt::encrypt($data['new_password']);
        $userinfo=db('admin')->where('id',session('admin_id'))
            ->where('password',$password)
            ->find();
        if(!$userinfo){
            return ['valid'=>0,'msg'=>'旧密码错误'];
        }
        //修改密码
        db('admin')->where('id',session('admin_id'))
            ->where('password',$password)->update(['password'=>$newPassword]);
        return ['valid'=>1,'msg'=>'修改密码成功'];
    }*/

    /*
     * 管理员添加
     */
    public function store($data){
        //密码加密后存入到数据库
        if($data['password']){
            $data['password']=Crypt::encrypt($data['password']);
        }
        //如果有相同的用户名就提示不能同名
        $username=db('admin')->where('username',$data['username'])->find();
        if($username){
            return ['valid'=>0,'msg'=>'已经有同名的管理员，请勿重复添加'];
        }
        $result=$this->validate(true)->save($data);
        if($result){
            return ['valid'=>1,'msg'=>'添加成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    /*
     * 管理员编辑
     */
    public function edit($data){
        //密码加密后存入到数据库
        if($data['password']){
            $data['password']=Crypt::encrypt($data['password']);
        }
        //如果有相同的用户名并且编号不相同就提示不能同名
        $username=db('admin')->where("id!={$data['id']}")
            ->where('username',$data['username'])->find();
        if($username){
            return ['valid'=>0,'msg'=>'已经有同名的管理员，请勿重复添加'];
        }
        $result=$this->validate(true)->save($data,[$this->pk=>$data['id']]);
        if($result){
            return ['valid'=>1,'msg'=>'编辑成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }
}
