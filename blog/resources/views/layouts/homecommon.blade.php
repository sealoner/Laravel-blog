<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    @yield('info')
    <link href="{{asset('resources/views/home/css/base.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/index.css')}}" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="{{asset('resources/views/home/js/modernizr.js')}}"></script>
    <![endif]-->
</head>
<body>
<header>
    <div id="logo"><a href="/"></a></div>
    <nav class="topnav" id="topnav">
        @foreach($navs as $k=>$v)
            <a href="{{$v->nav_url}}"><span>{{$v->nav_name}}</span><span class="en">{{$v->nav_alias}}</span></a>
        @endforeach
    </nav>
    </nav>
</header>
@section('content');
<!-- Baidu Button BEGIN -->
<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
    document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script>
<!-- Baidu Button END -->
<h3>
    <p>最新<span>文章</span></p>
</h3>
<ul class="rank">
    @foreach($new as $a=>$b)
        <li><a href="/" title="{{$b->art_title}}" target="_blank">{{$b->art_description}}</a></li>
    @endforeach
</ul>
<h3 class="ph">
    <p>点击<span>排行</span></p>
</h3>
<ul class="paih">
    @foreach($hotart as $h)
        <li><a href="/" title="{{$h->art_title}}" target="_blank">{{$h->art_description}}</a></li>
    @endforeach
</ul>
<h3 class="links">
    <p>友情<span>链接</span></p>
</h3>
@show

</aside>
</article>
<footer>
    <p>Design by 后盾网 <a href="http://www.miitbeian.gov.cn/" target="_blank">http://www.houdunwang.com</a> <a href="/">网站统计</a></p>
</footer>
<script src="{{asset('resources/views/home/js/silder.js')}}"></script>
</body>
</html>