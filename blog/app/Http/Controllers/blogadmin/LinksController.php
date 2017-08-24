<?php

namespace App\Http\Controllers\blogadmin;

use App\Http\model\Links;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends CommonController
{
    public function index() {
        $links = Links::orderBy('link_order','desc')->paginate(5);
        return view('blogadmin.links.index',compact('links'));
    }

    public function create() {
        return view('blogadmin.links.create');
    }
    
    //Order排序
    public function order() {
        //先获取表单提交的数据
        $input = Input::all();
        //根据传递的link_id获取数据库对应的数据
        $links = Links::find($input['link_id']);
        //将获取到的表单数据中的link_order的值，赋给数据库中对应的字段
        $links->link_order = $input['link_order'];
        //更新数据库
        $re = $links->update();
        if($re) {
            $data = [
                'status' => 0,
                'msg'    => "排序更新成功",
            ];
        }else{
            $data = [
                'status' => 1,
                'msg'    => "排序更新失败",
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
                'link_name'   => 'required',
                'link_title'  => 'required',
                'link_url'    => 'required|url'
            ];
            $messages = [
                'link_name.required'    => '友链名称为必填项',
                'link_title.required'   => '友链标题为必填项',
                'link_url.required'     => '友链的链接为必填项',
                'link_url.url'          => '友链链接的格式不合法，请重新输入'
            ];
            $validator = Validator::make($input,$rules,$messages);
            if($validator->passes()) {
                $re = Links::create($input);
                return redirect('blogadmin/links');
            }else{
                return back()->withErrors($validator);
            }

        }else{
            return view('blogadmin.links');
        }
    }

    //修改友情链接
    public function edit($link_id) {
        if($link_id) {
            //通过主键id查找数据
            $linkdata = Links::find($link_id);
            return view('blogadmin/links/edit',compact('linkdata'));
        }else{
            return back()->with('errors','ID参数不合法');
        }
    }

    //保存修改过的友情链接
    public function update($link_id) {
        $input = Input::except('_token','_method');
        $re = Links::where('link_id',$link_id)->update($input);
        if($re) {
            return redirect('blogadmin/links');
        }else{
            return back()->with('errors','友情链接更新失败，请稍后重试');
        }
    }

    //异步删除友情链接
    public function destroy($link_id) {
        //根据id，删除字段
        $re = Links::where('link_id',$link_id)->delete();
        if($re) {
            $data = [
                'status' => 0,
                'msg'    => '友链删除成功',
            ];
        }else {
            $data = [
                'status' => 1,
                'msg'    => '友链删除失败',
            ];
        }
        return $data;
    }

}
