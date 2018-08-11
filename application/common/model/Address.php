<?php

namespace app\common\model;

use think\Model;

class Address extends Model{
    protected $table='store_address';
    protected $pk='address_id';
    protected $auto=['address_uid'];
    /*
     * 自动添加用户编号
     */
    protected function setAddressUidAttr(){
        return session('userid');
    }

    /*
     * 用户地址添加
     */
    public function store($data){
        $res=$this->allowField(true)->save($data);
        if($res){
            return ['valid'=>1,'msg'=>'添加成功'];
        }
    }

    /*
     * 设为默认地址
     */
    public function setdefault($id){
        //把默认地址改为不默认
        db('address')->where('default',1)->update(['default'=>0]);
        //把点击的这一条地址改为默认地址
        db('address')->where('address_id',$id)->update(['default'=>1]);
        return ['valid'=>1];
    }

    /*
     * 编辑地址
     */
    public function edit($data){
        $res=$this->allowField(true)->save($data,[$this->pk=>$data['address_id']]);
        if($res){
            return ['valid'=>1];
        }
    }
    //选择地址
    public function check($data){
        db('address')->where('address_uid',session('userid'))
            ->update(['check'=>0]);
        db('address')->where('address_id',$data['id'])
            ->update(['check'=>1]);
        return 1;
    }
}