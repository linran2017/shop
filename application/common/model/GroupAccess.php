<?php

namespace app\common\model;

use think\Model;

class GroupAccess extends Model{
    protected $table='store_auth_group_access';

    /*
     * 分配权限
     */
    public function setauth($data){
       //halt($data);
        //如果auth_group_access表中的uid等于$data['uid']，就证明该管理员已经有用户组
        $oldData=db('auth_group_access')->where('uid',$data['uid'])->find();
        //就删除uth_group_access表中的uid等于$data['uid']的所有数据，
        //删除之前所在的用户组，然后重新添加用户组
        if($oldData){
            db('auth_group_access')->where('uid',$data['uid'])->delete();
        }
        if(!isset($data['group_id'])){
            return ['valid'=>0,'msg'=>'请选择所属用户组'];
        }
        //把用户组编号和该管理员的id依次添加到管理员用户组关系表中
        foreach ($data['group_id'] as $v){
            $accesss=[
                'uid'=>$data['uid'],
                'group_id'=>$v
            ];
            $groupAccess=new GroupAccess();
            $groupAccess->save($accesss);
        }
        return ['valid'=>1,'msg'=>'分配权限成功'];
    }
}
