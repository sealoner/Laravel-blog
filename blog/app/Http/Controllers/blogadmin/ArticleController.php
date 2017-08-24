<?php

namespace App\Http\Controllers\blogadmin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
//    文章控制器和分类控制器的结构相似
    //get.blogadmin/article
    public function index()
    {
        $allArt = Article::orderBy('art_id','desc')->paginate(5);
        return view('blogadmin/article/index',compact('allArt'));
    }

    //gte.blogadmin/article/create
    //添加分类
    public function create()
    {
        $cate_list = (new Category)->tree();
        return view('blogadmin/article/create', compact('cate_list'));
    }

    //post.admin/category
    //用来接收我们提交的新增的文章的数据
    public function store()
    {
        $input = Input::except('_token');
        $input['art_time'] = time();

        //做数据验证
        $rules = [
            'art_title' => 'required',
            'art_content' => 'required',
            'art_description' => 'required',
        ];
        $messages = [
            'art_title.required' => '标题不能为空',
            'art_content.required' => '内容不能为空',
            'art_description.required' => '描述不能为空',
        ];
        $validator = Validator::make($input, $rules, $messages);
        //如果验证通过
        if ($validator->passes()) {
            //那么才可以将数据存入数据库中
            $re = Article::create($input);
            if ($re) {
                return redirect('blogadmin/article');
                } else {
                    return back()->with('errors', '提交失败，请稍后重试。');
                }
            } else {
                return back()->withErrors($validator);
        }
    }

    //修改文章
    //get.blogadmin/article/{article}/edit
    public function edit($art_id) {
        if($art_id) {
            $data = Article::find($art_id);
            $cate_list = (new Category) -> tree();
            return view('blogadmin/article/edit',compact('data','cate_list'));
        }else {
            return back()->with('errors','参数错误，请重试！');
        }
    }
    
    //更新文章
    ////put.blogadmin/article/{article}
    public function update($art_id) {
        //剔除不需要的字段
        $input = Input::except('_token','_method','file_upload');
        //将剔除后的字段的数据更新至数据库中
        $re = Article::where('art_id',$art_id)->update($input);
        if($re) {
            return redirect('blogadmin/article');
        }else{
            return back()->with('errors','更新失败，请稍后重试');
        }
    }

    //删除文章
    //delete .blogadmin/article/{article}
    public function destroy($art_id) {
        //通过获取的文章的id号删除文章
        $re = Article::where('art_id',$art_id)->delete();
        //根据返回的状态码，判断文章是否删除成功，并返回给JS一组JSON数据
        if($re) {
            $data = [
                'status' => 0,
                'msg'    => '文章删除成功',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg'    => '文章删除失败，请重试',
            ];
        }
        return $data;
    }
}
