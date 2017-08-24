<?php

namespace App\Http\Controllers\blogadmin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends Controller
{
    public function index() {
        $navs = Navs::orderBy('nav_order','desc')->paginate(5);
        return view('blogadmin.navs.index',compact('navs'));
    }

    public function create() {
        return view('blogadmin.navs.create');
    }

    //Order排序
    public function order() {
        //先获取表单提交的数据
        $input = Input::all();
        //根据传递的link_id获取数据库对应的数据
        $navs = Navs::find($input['nav_id']);
        //将获取到的表单数据中的link_order的值，赋给数据库中对应的字段
        $navs->nav_order = $input['nav_order'];
        //更新数据库
        $re = $navs->update();
        if($re) {
            $data = [
                'status' => 0,
                'msg'    => "栏目排序更新成功",
            ];
        }else{
            $data = [
                'status' => 1,
                'msg'    => "栏目排序更新失败",
            ];
        }
        return $data;
    }
    //post.admin/category
    //用来接收我们提交的新增的分类
    public function store()
    {
        $input = Input::except('_token');
        //做校验
        if($input) {
            $rules = [
                'nav_name'   => 'required',
                'nav_alias'  => 'required',
                'nav_url'    => 'required|url'
            ];
            $messages = [
                'nav_name.required'    => '导航名为必填项',
                'nav_alias.required'   => '导航别名为必填项',
                'nav_url.required'     => '导航链接为必填项',
                'nav_url.url'          => '导航链接的格式不合法，请重新输入'
            ];
            $validator = Validator::make($input,$rules,$messages);
            if($validator->passes()) {
                $re = Navs::create($input);
                return redirect('blogadmin/navs');
            }else{
                return back()->withErrors($validator);
            }

        }else{
            return view('blogadmin.navs');
        }
    }

    //修改友情链接
    public function edit($nav_id) {
        if($nav_id) {
            //通过主键id查找数据
            $navdata = Navs::find($nav_id);
            return view('blogadmin/navs/edit',compact('navdata'));
        }else{
            return back()->with('errors','ID参数不合法');
        }   
    }

    //保存修改过的友情链接
    public function update($nav_id) {
        $input = Input::except('_token','_method');
        $re = Navs::where('nav_id',$nav_id)->update($input);
        if($re) {
            return redirect('blogadmin/navs');
        }else{
            return back()->with('errors','导航栏更新失败，请稍后重试');
        }
    }

    //异步删除友情链接
    public function destroy($nav_id) {
        //根据id，删除字段
        $re = Navs::where('nav_id',$nav_id)->delete();
        if($re) {
            $data = [
                'status' => 0,
                'msg'    => '栏目删除成功',
            ];
        }else {
            $data = [
                'status' => 1,
                'msg'    => '栏目删除失败',
            ];
        }
        return $data;
    }
}
