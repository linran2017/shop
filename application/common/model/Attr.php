<?php

namespace app\common\model;

use think\Model;

class Attr extends Model{
    protected $table='store_attr';
    protected $pk='attr_id';
    /*
     * 添加属性
     */
    public function store($data){
        //halt($data);
        $result=$this->validate(true)->allowField(true)->save($data);
        if($result){
            return ['valid'=>1,'msg'=>'添加成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    /*
     * 添加属性
     */
    public function edit($data){
        //halt($data);
        $result=$this->validate(true)
            ->allowField(true)->save($data,[$this->pk=>$data['attr_id']]);
        if($result){
            return ['valid'=>1,'msg'=>'保存成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    /*
     * 删除属性
     */
    public function del($id){
        //获取属性的图片地址
        //图片地址http://shop.dev/uploads/20171115\1a0816dc31d370befd95016dca9868b6.jpeg
        $img=db('attr')->where('attr_id',$id)->value('attr_img');
        //截取字符串变为/uploads/20171115\1a0816dc31d370befd95016dca9868b6.jpeg
        $img=strstr($img,'/uploads');
        //最后在最前面加‘.’变为./uploads/20171115\1a0816dc31d370befd95016dca9868b6.jpeg
        $img=str_replace('/uploads','./uploads',$img);
        //删除这个属性的图片
        unlink($img);
        //删除这个属性的数据
        if(self::destroy($id)){
            return ['valid'=>1,'msg'=>'删除成功'];
        }else{
            return ['valid'=>1,'msg'=>'删除失败'];
        }
    }
}
