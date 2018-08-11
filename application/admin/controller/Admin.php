<?php

namespace app\admin\controller;
use app\common\model\Admin as AdminModel;
use houdunwang\crypt\Crypt;
use think\Controller;
use app\common\model\GroupAccess;
class Admin extends Commen {
    /*
     * 管理员列表
     */
    public function index(){
        $data=db('admin')->select();
        //循环每一个管理员表的数据
        foreach($data as $k=>$v){
            //依次获得每一个管理员所属的用户组，得到一个用户组的数组
            $group=db('auth_group')->alias('g')
                ->join('auth_group_access ga','g.id=ga.group_id')
                ->where('ga.uid',$v['id'])->column('title');
            //把每一个管理员所属的用户组的数组依次按逗号隔开组合为字符串，
            //然后再添加到每一个管理员数据的group字段中
            $data[$k]['group']=implode(',',$group);
        }
        //halt($data);
        return view('',compact('data'));
    }

    /*
     * 管理员添加
     */
    public function store(AdminModel $admin){
        if(request()->isPost()){
            $res=$admin->store(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
            }else{
                $this->error($res['msg']);
            }
        }
        return view('');
    }

    /*
     * 管理员编辑
     */
    public function edit(AdminModel $admin){
        $id=input('param.id');
        if(request()->isPost()) {
            $res = $admin->edit(input('post.'));
            if ($res['valid']) {
                $this->success($res['msg'], 'index');
            } else {
                $this->error($res['msg']);
            }
        }
        $oldData=db('admin')->where('id',$id)->find();
        $oldData['password']=Crypt::decrypt($oldData['password']);
        return view('',compact('oldData'));
    }

    /*
     * 给管理员分配权限
     */
    public function setauth(GroupAccess $groupAccess){
        $id=input('param.id');
        if(request()->isPost()){
            $res=$groupAccess->setauth(input('post.'));
            if ($res['valid']) {
                $this->success($res['msg'], 'index');
            } else {
                $this->error($res['msg']);
            }
        }
        //获得该管理员的用户名
        $username=db('admin')->where('id',$id)->value('username');
        //获得所有用户组
        $groupData=db('auth_group')->select();
        //获得该管理员所在的所有用户组
        $oldGroup=db('auth_group_access')->where('uid',$id)->column('group_id');
        //halt($oldGroup);
        return view('',compact('username','groupData','oldGroup'));
    }

    /*
     * 管理员删除
     */
    public function del(){
        $id=input('param.id');
        if (AdminModel::destroy($id)){
            $this->success('删除成功','index');
        }
    }
}
