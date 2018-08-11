<?php

namespace app\admin\controller;

use think\Controller;

class Entry extends Commen{
    public function index(){
        //框架版本号
        $version=THINK_VERSION;
        return view('',compact('version'));
    }
}