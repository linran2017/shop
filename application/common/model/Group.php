<?php

namespace app\common\model;

use think\Model;

class Group extends Model{
    protected $table='store_auth_group';
    protected $pk='id';

    /*
     * 用户组添加
     */
    public function store($data){
        //halt($data);
        $data['rules']=isset($data['rules'])?implode(',',$data['rules']):'';
        //halt($data);
        $result=$this->validate(true)->save($data);
        if($result){
            return ['valid'=>1,'msg'=>'添加成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    public function edit($data){
        $data['rules']=isset($data['rules'])?implode(',',$data['rules']):'';
        //halt($data);
        $result=$this->validate(true)->save($data,[$this->pk=>$data['id']]);
        if($result){
            return ['valid'=>1,'msg'=>'保存成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }
}
