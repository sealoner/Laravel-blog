@extends('layouts.homecommon')
@section('info')
    <title>{{$field->cate_name}} - {{Config::get('webconfig.web_title')}}</title>
    <meta name="keywords" content="个人博客模板,博客模板" />
    <meta name="description" content="寻梦主题的个人博客模板，优雅、稳重、大气,低调。" />
    <link href="{{asset('resources/views/home/css/style.css')}}"rel="stylesheet">
@endsection
@section('content')
<article class="blogs">
<h1 class="t_nav"><span>{{$field->cate_title}}</span><a href="/" class="n1">网站首页</a><a href="/" class="n2">{{$field->cate_name}}</a></h1>
<div class="newblog left">

    @foreach($artlist as $a)
   <h2>{{$a->art_title}}</h2>
   <p class="dateview"><span>发布时间：{{date('Y-m-d',$a->art_time)}}</span><span>作者：{{$a->art_editor}}</span><span>分类：[<a href="/news/life/">程序人生</a>]</span></p>
    <figure><img
                @if($a->art_thumb != null)
                src="{{url("$a->art_thumb")}}"
                @else
                src="{{url('/resources/images/thumb.jpg')}}"
                @endif
        ></figure>
    <ul class="nlist">
      <p>{{$a->art_description}}</p>
      <a title="/" href="/" target="_blank" class="readmore">阅读全文>></a>
    </ul>
    <div class="line"></div>
    @endforeach

    <div class="blank"></div>
    <div class="ad">  
    <img src="images/ad.png">
    </div>
    <div class="page">

<ul class="pagination">
    {{$artlist->links()}}
</ul>

 
    </div>
</div>
<aside class="right">
    <br>
    @if($sublist->all())
   <div class="rnav">
      <ul>
      @foreach($sublist as $k=>$s)
       <li class="rnav{{$k+1}}"><a href="/download/" target="_blank">{{$s->cate_name}}</a></li>
      @endforeach
     </ul>      
   </div>
    @endif
<div class="news">
    @parent
</div>
@endsection