@extends('layouts.homecommon')
@section('info')
    <title>{{$article->art_title}}</title>
    <meta name="keywords" content="个人博客模板,博客模板" />
    <meta name="description" content="寻梦主题的个人博客模板，优雅、稳重、大气,低调。" />
@endsection
@section('content')
<link href="{{asset('resources/views/home/css/new.css')}}" rel="stylesheet">
<article class="blogs">
  <h1 class="t_nav"><span>您当前的位置：<a href="/index.html">首页</a>&nbsp;&gt;&nbsp;<a href="/news/s/">{{$article->cate_name}}
    </span><a href="/" class="n1">网站首页</a><a href="/" class="n2">{{$article->cate_name}}</a></h1>
  <div class="index_about">
    <h2 class="c_titile">{{$article->art_title}}</h2>
    <p class="box_c"><span class="d_time">发布时间：{{date('Y-m-d',$article->art_time)}}</span><span>编辑：{{$article->art_editor}}</span><span>查看次数：{{$article->art_view}}</span></p>
    <ul class="infos">
      {!! $article->art_content !!}
    </ul>
    <div class="keybq">
    <p><span>关键字词</span>：{{$article->art_tag}}</p>
    
    </div>
    <div class="ad"> </div>
    <div class="nextinfo">
      <p>上一篇：
        @if($art['pre'])
        <a href="{{url('/home/article/'.$art['pre']->art_id)}}">{{$art['pre']->art_title}}</a>
        @else
          <span>到头了，没有上一篇了</span>
        @endif
      </p>
      <p>下一篇：
        @if($art['next'])
          <a href="{{url('home/article/'.$art['next']->art_id)}}">{{$art['next']->art_title}}</a>
        @else
          <span>到底了，没有下一篇了</span>
        @endif

      </p>
    </div>
    <div class="otherlink">
      <h2>相关文章</h2>
      <ul>
        @if($data)
          @foreach($data as $v)
              <li><a href="{{url('/home/article'.$v->art_id)}}" title="{{$v->art_title}}">{{$v->art_title}}</a></li>
          @endforeach
        @else
            <span>没有相关文章</span>
        @endif

      </ul>
    </div>
  </div>
  <aside class="right">
    <div class="news">
      @parent
      <ul class="website">
        @foreach($link as $x=>$y)
          <li><a href="{{url("$y->link_url")}}" title="{{$y->link_title}}">{{$y->link_name}}</a></li>
        @endforeach
      </ul>
@endsection