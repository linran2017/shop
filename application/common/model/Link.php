<?php

namespace app\common\model;

use think\Model;

class Link extends Model{
    protected $table='store_link';
    protected $pk='id';
    /*
     * 友链添加
     */
    public function store($data){
        $result=$this->validate(true)->save($data);
        if ($result){
            return ['valid'=>1,'msg'=>'添加成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    /*
      * 友链添加
      */
    public function edit($data){
        //halt($data);
        $result=$this->validate(true)
            ->save($data,[$this->pk=>$data['id']]);
        if ($result){
            return ['valid'=>1,'msg'=>'保存成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    /*
     * 删除友链
     */
    public function del($id){
        if (self::destroy($id)){
            return ['valid'=>1,'msg'=>'删除成功'];
        }
    }
}