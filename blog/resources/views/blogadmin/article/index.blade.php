@extends('layouts.admincommon')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('blogadmin/article')}}">文章列表首页</a> &raquo; 全部文章
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
        <form action="" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择文章:</th>
                    <td>
                        <select onchange="javascript:location.href=this.value;">
                            <option value="">全部</option>
                            <option value="http://www.baidu.com">百度</option>
                            <option value="http://www.sina.com">新浪</option>
                        </select>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('blogadmin/article/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                    <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                    <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>文章标题</th>
                        <th>标签</th>
                        <th>点击</th>
                        <th>作者</th>
                        <th>发布时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($allArt as $v)
                    <tr>
                        <td class="tc">{{$v->art_id}}</td>
                        <td><a href="{{url('blogadmin/article/'.$v->art_id.'/edit')}}">{{$v->art_title}}</a></td>
                        <td>{{$v->art_tag}}</td>
                        <td>{{$v->art_view}}</td>
                        <td>{{$v->art_editor}}</td>
                        <td>{{date('Y-m-d H:i:s',$v->art_time)}}</td>
                        <td>
                            <a href="{{url('blogadmin/article/'.$v->art_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delArt({{$v->art_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="page_nav">
                    {{$allArt->links()}}
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

    <script>
        //排序修改成功/失败提示框
        function changeOrder(obj,cate_id) {
            var cate_order = $(obj).val();
            $.post("{{url('blogadmin/order')}}",{'_token':'{{csrf_token()}}','cate_order':cate_order,'cate_id':cate_id},function(data){

            if(data.status == 0) {
                layer.msg(data.msg,{icon:6});
            }else{
                layer.msg(data.msg,{icon:5});
            }

            });
        }
        //删除提示框
        function delArt(art_id) {
            layer.confirm('是否确认删除这篇文章吗？', {
                btn: ['确定','我再想想']
            },function () {
                $.post('{{url('blogadmin/article/')}}/'+art_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data) {
//                    当删除数据成功是，自动刷新页面，并显示笑脸/哭脸
                    location.href = location.href;
                    if(data.status == 0) {
                        layer.msg(data.msg,{icon:6});
                    }else{
                        layer.msg(data.msg,{icon:5});
                    }
                });
                }
            );
        };
    </script>
@endsection