@extends('layouts.homecommon');
@section('info')
  <title>{{Config::get('webconfig.web_title')}} - {{Config::get('webconfig.seo_title')}}</title>
  <meta name="keywords" content="个人博客模板,博客模板" />
  <meta name="description" content="寻梦主题的个人博客模板，优雅、稳重、大气,低调。" />
  <link href="{{asset('resources/views/home/css/style.css')}}"rel="stylesheet">
@endsection
@section('content')
<div class="banner">
</div>
<div class="template">
  <div class="box">
    <h3>
      <p><span>点击率最高的六篇</p>
    </h3>
    <ul>
    @foreach($hotart as $k=>$v)
      <li><a href="/"  target="_blank"><img
                  @if($v->art_thumb != null)
                  src="{{url("$v->art_thumb")}}"
                  @else
                  src="{{url('/resources/images/thumb.jpg')}}"
                  @endif
          ></a><span>{{$v->art_title}}</span></li>
    @endforeach
    </ul>
  </div>
</div>
<article>
  <h2 class="title_tj">
    <p>文章<span>推荐</span></p>
  </h2>
  <div class="bloglist left">
    @foreach($data as $m=>$v)
    <h3>{{$v->art_title}}</h3>
    <figure><img
              @if($v->art_thumb != null)
              src="{{url("$v->art_thumb")}}"
              @else
              src="{{url('/resources/images/thumb.jpg')}}"
              @endif
      ></figure>
    <ul>
      <p>{{$v->art_description}}</p>
      <a title="{{$v->art_title}}" href="{{url('home/article/'.$v->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
    </ul>
    <p class="dateview"><span>{{date('Y-m-d',$v->art_time)}}</span><span>作者：{{$v->editor}}</span><span>来源：[<a href="/news/life/">{{$v->cate_name}}</a>]</span></p>
    @endforeach
      <div class="page">
        {{$data->links()}}
      </div>
  </div>
  <aside class="right">
    <div class="weather"><iframe width="250" scrolling="no" height="60" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=12&icon=1&num=1"></iframe></div>

    <div class="news">
    @parent
    <ul class="website">
      @foreach($link as $x=>$y)
      <li><a href="{{url("$y->link_url")}}" title="{{$y->link_title}}">{{$y->link_name}}</a></li>
      @endforeach
    </ul> 
    </div>  
@endsection