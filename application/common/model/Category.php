<?php

namespace app\common\model;

use houdunwang\arr\Arr;
use think\Model;

class Category extends Model{
    protected $table='store_category';
    protected $pk='id';
    /*
     * 栏目添加
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
     * 获得自己和子类以外的栏目
     */
    public function getCategoryData($id){
        //获得子类栏目的所有id
        $data=db('category')->select();
        $ids=$this->sonId($data,$id);
        $ids[]=$id;
        $category=db('category')->whereNotIn('id',$ids)->select();
        return Arr::tree($category,'name','id','pid');
    }

    /*
     * 获得子类栏目所有id
     */
    private function sonId($data,$id){
        $temp=[];
        foreach ($data as $v){
            if($v['pid']==$id){
                $temp[]=$v['id'];
                $this->sonId($data,$v['id']);
            }
        }
        return $temp;
    }

    /*
     * 编辑栏目
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
     * 删除栏目
     */
    public function del($id){
        //把该栏目下的pid换成该栏目的id
        $pid=db('category')->where('id',$id)->value('pid');
        db('category')->where('pid',$id)->update(['pid'=>$pid]);
        if(self::destroy($id)){
            return ['valid'=>1,'msg'=>'删除成功'];
        }else{
            return ['valid'=>0,'msg'=>'删除失败'];
        }
    }
}
