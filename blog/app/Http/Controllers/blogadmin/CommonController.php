<?php

namespace App\Http\Controllers\blogadmin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //图片上传
    public function upload() {
        $file = Input::file('Filedata');
        //判断文件是否有效
        //注：这里的很多方法都是laravel内置的方法，不要弄混了
        if($file->isValid()) {
            //获取临时文件的绝对路径
            $realPath   = $file->getRealPath();

            //获取上传文件的后缀
            $entension  = $file->getClientOriginalExtension();

            //移动文件并重命名
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            //base_path()表示项目最原始的目录，顶级目录
            $path = $file->move(base_path().'/uploads',$newName);
            $filepath = 'uploads/'.$newName;
            return $filepath;
        }
    }
}
