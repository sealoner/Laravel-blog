<?php

namespace App\Http\Controllers\home;

use App\Http\Model\Article;
use App\Http\model\Links;
use App\Http\Model\Navs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    //使用php的魔术函数__constract,当页面载入时，自动加载此函数下的方法
    public function __construct()
    {
        $navs = Navs::all();
        //点击率最高的6篇文章
        $hotart = Article::orderBy('art_view','desc')->take(6)->get();
        //最新发布的8篇文章
        $new = Article::orderBy('art_time','desc')->take(8)->get();
        //友情链接
        $link = Links::orderBy('link_order','desc')->get();

        View::share('hotart',$hotart);
        View::share('new',$new);
        View::share('navs',$navs);
        View::share('link',$link);
    }
}
