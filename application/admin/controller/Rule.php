<?php

namespace app\admin\controller;

use houdunwang\arr\Arr;
use think\Controller;
use app\common\model\Rule as RuleModel;
class Rule extends Commen {
    /*
     * 规则列表
     */
    public function index(){
        $data=db('auth_rule')->select();
        $data=Arr::tree($data,'title','id','pid');
        //halt($data);
        return view('',compact('data'));
    }

    /*
     * 规则添加
     */
    public function store(RuleModel $rule){
        if(request()->isPost()){
            $res=$rule->store(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
            }else{
                $this->error($res['msg']);
            }
        }
        $ruleData=db('auth_rule')->select();
        $ruleData=Arr::tree($ruleData,'title','id','pid');
        return view('',compact('ruleData'));
    }

    /*
     * 规则编辑
     */
    public function edit(RuleModel $rule){
        $id=input('param.id');
        if(request()->isPost()){
            $res=$rule->edit(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
            }else{
                $this->error($res['msg']);
            }
        }
        $oldData=db('auth_rule')->where('id',$id)->find();
        //获得子规则和自己的所有规则的编号
        $ruleIds=$rule->getIds($id);
       // halt($ruleIds);
        //获得不是子规则和自己的所有规则
        $ruleData=db('auth_rule')->whereNotIn('id',$ruleIds)->select();
        $ruleData=Arr::tree($ruleData,'title','id','pid');
        //halt($ruleData);
        return view('',compact('oldData','ruleData'));
    }

    /*
     * 规则删除
     */
    public function del(RuleModel $rule){
        $id=input('param.id');
        $res=$rule->del($id);
        if($res['valid']){
            $this->success($res['msg'],'index');
        }
    }
}
