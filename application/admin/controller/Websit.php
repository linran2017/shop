<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Websit as WebsitModel;
class Websit extends Commen {
    public function index(){
        $websit=new WebsitModel();
        if(request()->isPost()){
            $res=$websit->edit(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
            }else{
                $this->error($res['msg']);
            }
        }
        $data=db('websit')->where('id',1)->find();
        //halt($data);
        return view('',compact('data'));
    }
}