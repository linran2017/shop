<?php

namespace app\common\model;

use think\Model;
use app\common\model\Attr;
class Goods extends Model{
    protected $table='store_goods';
    protected $pk='goods_id';
    //自动添加商品发布时间
    protected $insert=['sendtime'];
    //自动添加商品新数据
    protected $update=['updatetime'];
    protected function setSendTimeAttr(){
        return time();
    }
    protected function setUpdateTimeAttr(){
        return time();
    }

    /*
     *
     * 添加商品
     */
    public function store($data){
      //  halt($data);
        $restule=$this->validate(true)->allowField(true)->save($data);
        if($restule){
            return ['valid'=>1,'msg'=>'添加成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    /*
     * 商品编辑
     */
    public function edit($data){
        //  halt($data);
        $restule=$this->validate(true)
            ->allowField(true)->save($data,[$this->pk=>$data['goods_id']]);
        if($restule){
            return ['valid'=>1,'msg'=>'保存成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    /*
     * 商品下架
     */
    public function unonsale($id){
        if (db('goods')->where('goods_id',$id)->update(['goods_onsale'=>0])){
            return ['valid'=>1,'msg'=>'下架成功'];
        }
    }


    /*
     * 商品下架
     */
    public function onsale($id){
        if (db('goods')->where('goods_id',$id)->update(['goods_onsale'=>1])){
            return ['valid'=>1,'msg'=>'上架成功'];
        }
    }


    /*
     * 删除商品
     */
    public function del($id){
        //获取属性attr_gid为$id的属性
        $attr=db('attr')->where('attr_gid',$id)->select();
        //halt($attr);
        //循环商品下的所有属性
        foreach ($attr as $v){
            $attrImg=$v['attr_img'];
            //删除属性的图片
            $this->delImg($attrImg);
        }
        //删除该商品下所有属性
       db('attr')->where('attr_gid',$id)->delete();
        //获取该商品的主图
        $goodsImg=db('goods')->where('goods_id',$id)->value('goods_master');
        //删除目录中的该商品的主图
        $this->delImg($goodsImg);
        if(self::destroy($id)){
            return ['valid'=>0,'msg'=>'删除成功'];
        }else{
            return ['valid'=>1,'msg'=>'删除失败'];
        }
    }
    /*
     * 删除图片
     */
    private function delImg($img){
        //截取字符串变为/uploads/20171115\1a0816dc31d370befd95016dca9868b6.jpeg
        $img=strstr($img,'/uploads');
        //最后在最前面加‘.’变为./uploads/20171115\1a0816dc31d370befd95016dca9868b6.jpeg
        $img=str_replace('/uploads','./uploads',$img);
        //删除这个属性的图片
        unlink($img);
    }

}