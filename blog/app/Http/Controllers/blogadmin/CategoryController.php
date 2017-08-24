<?php

namespace App\Http\Controllers\blogadmin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    //get.admin/category
    //文章列表分类
    public function index()
    {
        $categorys = (new Category)->tree();
        return view('blogadmin.category.index')->with('categorys', $categorys);
    }


    public function order()
    {
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        //对category数据表中的cate_order字段进行更新
        $re = $cate->update();
        //对$re做判断，显示对应的提示信息
        if ($re) {
            $data = [
                'status' => '0',
                'msg' => '排序信息更新成功',
            ];
        } else {
            $data = [
                'status' => '1',
                'msg' => '排序信息更新失败，请稍后重试！',
            ];
        }
        //这里一定要return一下！你不return，就没有返回值传出去了，回调函数怎么接收呢？
        return $data;
    }

    //post.admin/category
    //用来接收我们提交的新增的分类
    public function store()
    {
        //获取除_token字段以外的我们提交的所有数组的值
        $input = Input::except('_token');
        //对提交的数据进行validation验证
        if ($input) {
            $rules = [
                'cate_name' => 'required',
                'cate_order' => 'numeric',
            ];
            $messages = [
                'cate_name.required' => '分类名称为必填字段',
                'cate_order.numeric' => '排序规则必须为数字',
            ];
            $validator = Validator::make($input, $rules, $messages);
            //判断validator验证是否通过;
            //如果通过，将数据存入数据表中，并返回分类页面
            //如果不通过，返回上一页面并提示错误信息
            if ($validator->passes()) {
                $re = Category::create($input);
                return redirect('blogadmin/category');
            } else {
                return back()->withErrors($validator);
            }
        } else {
            return view('blogadmin.category.create');
        }
    }

    //get.blogadmin/category/create
    //添加分类
    public function create()
    {
        //获取cate_pid=0的分类信息
        $cate_list = Category::where('cate_pid', 0)->get();
        return view('blogadmin.category.create', compact('cate_list'));
    }

    //get.admin/category/{category}
    //显示单个分类信息
    public function show()
    {

    }

    //delete.admin/category/{category}
    //删除单个分类
    public function destroy($cate_id)
    {
        //根据获取的cate_id，删除对应的分类信息
        $re = Category::where('cate_id', $cate_id)->delete();
        //如果我们删除了一个顶级分类，则将它下面存在的子分类全部变为顶级分类，即pid=>0
        Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
        //做个判断，组装成json数组的格式，返回给视图模块中的JS中的回调函数
        if ($re) {
            $data = [
                'status' => 0,
                'msg' => '分类删除成功',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '分类删除失败，请稍后重试',
            ];
        }
        //$data返回给JS中的回调函数
        return $data;
    }
    //put.admin/category/{category}
    //更新分类
    public function update($cate_id) {
        $input = Input::except('_token','_method');
        //根据cate_id，将数据更新至数据库中
        $re = Category::where('cate_id',$cate_id)->update($input);
        //判断
        if($re) {
            return redirect('blogadmin/category');
        }else{
            return back()->with('errors','分类信息更新失败，请稍后重试');
        }
    }

    //get.admin/category/{category}/edit
    //编辑分类
    public function edit($cate_id) {
        //现在我来根据当前数据的cate_id的值去数据库中获取数据
        $catedata = Category::find($cate_id);
        $cate_list = Category::where('cate_pid',0)->get();
        //将获取到的数据回显给视图页面
        return view('blogadmin.category.edit',compact('catedata','cate_list'));
    }
}


















