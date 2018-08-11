<?php

namespace app\common\model;

use think\Model;

class Websit extends Model{
    protected $table='store_websit';
    protected $pk='id';
    /*
     * 更改公司信息
     */
    public function edit($data){
        //halt($data);
        $result=$this->validate(true)->allowField(true)
            ->save($data,[$this->pk=>$data['id']]);
        if($result){
            return ['valid'=>1,'msg'=>'修改成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }
}
