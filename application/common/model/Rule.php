<?php

namespace app\common\model;

use think\Model;

class Rule extends Model{
    protected $table='store_auth_rule';
    protected $pk='id';
    /*
     * 规则添加
     */
    public function store($data){
        $result=$this->validate(true)->save($data);
        if($result){
            return['valid'=>1,'msg'=>'添加成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    /*
     * 规则编辑
     */
    public function edit($data){
        //halt($data);
        $result=$this->validate(true)->save($data,[$this->pk=>$data['id']]);
        if($result){
            return['valid'=>1,'msg'=>'保存成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    /*
     * 获得自己和子规则的编号
     */
    public function getIds($id){
        $ids=$this->sonIds($id);
        $ids[]=$id;
        return $ids;
    }

    /*
     * 获得子规则的编号
     */
    private function sonIds($id){
        $rules=db('auth_rule')->select();
        $temp=[];
        foreach ($rules as $v){
            if ($v['pid']==$id){
                $temp[]=$v['id'];
            }
        }
        return $temp;
    }

    /*
     * 删除规则
     */
    public function del($id){
        //1,获得该规则下的pid
        $pid=db('auth_rule')->where('id',$id)->value('pid');
        //2，把该规则下的子子规则的pid改为该更改的pid
        db('auth_rule')->where('pid',$id)->update(['pid'=>$pid]);
        //3,删除该规则
        if (self::destroy($id)){
            return ['valid'=>1,'msg'=>'删除成功'];
        }
    }
}
