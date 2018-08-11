<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/11/10
 * Time: 12:47
 */

namespace app\system\controller;


class Component{
    public function upload(){
        //halt($_FILES);
        //不转义
        //echo json_encode(HD_ROOT,JSON_UNESCAPED_SLASHES);

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        //halt(ROOT_PATH);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move( ROOT_PATH . 'public' . DS . 'uploads' );
        //halt($info->getSaveName());
        if ( $info ) {
            $data = [
                'name'       => input( 'post.name' ) ,
                'filename'   => $info->getFilename() ,
                'path'       => 'uploads/' . $info->getSaveName() ,
                'extension'  => $info->getExtension() ,
                'createtime' => time() ,
                'size'       => $info->getSize() ,
            ];
            $json=json_encode( [ 'valid' => 1 , 'message' => HD_ROOT.'uploads/'.$info->getSaveName()]);
            //return [ 'valid' => 1 , 'message' => HD_ROOT.'uploads/'.$info->getSaveName()];
        }
        else {
            // 上传失败获取错误信息
            $json=json_encode( [ 'valid' => 0 , 'message' => $file->getError() ] );
        }
        exit($json);
    }
    public function multupload(){
        // 获取表单上传文件
        $files = request()->file('imgs');
        //halt($files);
        foreach($files as $file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
               // echo $info->getExtension();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
               $msg=$info->getFilename();
            }else{
                // 上传失败获取错误信息
                $msg=$file->getError();
            }
            exit($msg);
        }
    }
}