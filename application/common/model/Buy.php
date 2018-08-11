<?php

namespace app\common\model;

use think\Model;

class Buy extends Model{
    protected $table='store_buy';
    protected $pk='buy_id';

    /*
     * 提交订单的商品属性
     */
    public function store($data){
        $this->save($data);
    }
}
