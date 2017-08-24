<?php

namespace App\Http\Controllers\home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\model\Links;
use App\Http\Model\Navs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends CommonController
{
    //前台首页
    public function index()
    {
        $data = Article::Join('category','category.cate_id','=','article.cate_id')->orderBy('art_time','desc')->paginate(5);
        return view('home/index',compact('data'));
    }

    public function cat($cate_id)
    {
        if($cate_id) {
            //根据分类的id，获取此分类下的所有文章
            $artlist = Article::where('cate_id',$cate_id)->orderBy('art_time','desc')->paginate(5);
            $field = Category::find($cate_id);
            //$field获取到的是顶级分类
            //下面要做一下子分类
            $sublist = Category::where('cate_pid',$cate_id)->get();
            return view('home/cat',compact('artlist','field','sublist'));
        }else{
            $artlist = Article::orderBy('art_time','desc')->paginate(5);
            return view('home/cat',compact('artlist'));
        }

    }

    public function article($art_id)
    {
//        $article = Article::find($art_id);
        $article = Article::Join('category','category.cate_id','=','article.cate_id')->where('art_id',$art_id)->first();

        //查看次数自增
        Article::where('art_id',$art_id)->increment('art_view',5);

        //相关文章
        //这里的处理方法为获取同一个分类下的全部文章
        $data = Article::where('cate_id',$article->cate_id)->orderBy('art_id','desc')->take(4)->get();


        //根据$art_id，获取当前文章的上一篇和下一篇
        //上一篇
        $art['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        //下一篇
        $art['next']= Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
        return view('home/article',compact('article','art','data'));
    }
}
