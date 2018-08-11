<?php

namespace app\common\model;

use think\Model;

class Brand extends Model{
    protected $table='store_brand';
    protected $pk='id';
    /*
     * 品牌添加
     */
    public function store($data){
        $result=$this->validate(true)->save($data);
        if($result){
            return ['valid'=>1,'msg'=>'添加成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }
    /*
     * 品牌编辑
     */
    public function edit($data){
        $result=$this->validate(true)->save($data,[$this->pk=>$data['id']]);
        if($result){
            return ['valid'=>1,'msg'=>'编辑成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    /*
     * 删除品牌
     */
    public function del($id){
        if(self::destroy($id)){
            return ['valid'=>1,'msg'=>'删除成功'];
        }else{
            return ['valid'=>0,'msg'=>'删除失败'];
        }
    }
}
