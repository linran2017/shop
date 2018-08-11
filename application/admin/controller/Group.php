<?php

namespace app\admin\controller;
use app\common\model\Group as GroupModel;
use think\Controller;

class Group extends Commen {
    /*
     * 用户组列表
     */
    public function index(){
        $data=db('auth_group')->select();
        return view('',compact('data'));
    }

    /*
     * 用户组添加
     */
    public function store(GroupModel $group){
        if(request()->isPost()){
            $res=$group->store(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
            }else{
                $this->error($res['msg']);
            }
        }
        //获取所有规则
        $rules=$this->getRules();
        //halt($rules);
        return view('',compact('rules'));
    }

    /*
     * 用户组编辑
     */
    public function edit(GroupModel $group){
        $id=input('param.id');
        if(request()->isPost()){
            $res=$group->edit(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
            }else{
                $this->error($res['msg']);
            }
        }
        //获取所有规则
        $rules=$this->getRules();
        //halt($rules);
        //获得该用户组的权限编号
        $oldData=db('auth_group')->where('id',$id)->find();
       // halt($oldData);
        $ruleIds=explode(',',$oldData['rules']);
        //halt($ruleIds);
        return view('',compact('rules','ruleIds','oldData'));
    }

    /*
     * 把相同规则的导航合并
     */
    private function getRules(){
        $data=db('auth_rule')->select();
        $rules=[];
        foreach ($data as $v){
            $rules[$v['nav']][]=$v;
        }
        return $rules;
    }

    /*
     * 删除用户组
     */
    public function del(){
        $id=input('get.id');
        //删除管理员用户组关系表中uid为$id的所有数据
        db('auth_group_access')->where('group_id',$id)->delete();
        if(GroupModel::destroy($id)){
            $this->success('删除成功','index');
        }
    }

    /*
     * 管理组详情
     */
    public function detail(){
        $id=input('param.id');
        //获得该用户组的权限编号
        $oldData=db('auth_group')->where('id',$id)->find();
        // halt($oldData);
        $ruleIds=explode(',',$oldData['rules']);
        $data=db('auth_rule')->whereIn('id',$ruleIds)->select();
        $rules=[];
        foreach ($data as $k=>$v){
            $rules[$v['nav']][]=$v;
    }
        //halt($rules);
        //halt($ruleIds);
        return view('',compact('rules','oldData'));
    }
}
