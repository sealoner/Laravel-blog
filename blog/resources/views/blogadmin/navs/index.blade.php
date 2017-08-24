@extends('layouts.admincommon')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('blogadmin/navs')}}">导航栏首页</a> &raquo; 全部导航栏
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
        <form action="" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择导航栏:</th>
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
                    <a href="{{url('blogadmin/navs/create')}}"><i class="fa fa-plus"></i>新增导航栏</a>
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
                        <th>排序</th>
                        <th class="tc">ID</th>
                        <th>导航名称</th>
                        <th>导航别名</th>
                        <th>导航地址</th>
                        <th>操作</th>
                    </tr>
                    @foreach($navs as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" onchange="changeOrder(this,{{$v->nav_id}})" onkeyup="this.value=this.value.replace(/\D/g,'')" value="{{$v->nav_order}}">
                        </td>
                        <td class="tc">{{$v->nav_id}}</td>
                        <td>{{$v->nav_name}}</td>
                        <td>{{$v->nav_alias}}</td>
                        <td>{{$v->nav_url}}</td>
                        <td>
                            <a href="{{url('blogadmin/navs/'.$v->nav_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delNav({{$v->nav_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="page_nav">
                    {{$navs->links()}}
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

    <script>
        //排序修改成功/失败提示框
        function changeOrder(obj,nav_id) {
            var link_order = $(obj).val();
            $.post("{{url('blogadmin/navs/order')}}",{'_token':'{{csrf_token()}}','nav_order':nav_order,'nav_id':nav_id},function(data){
            location.href = location.href;
            if(data.status == 0) {
                layer.msg(data.msg,{icon:6});
            }else{
                layer.msg(data.msg,{icon:5});
            }

            });
        }
        //删除提示框
        function delNav(nav_id) {
            layer.confirm('是否确认删除这篇文章吗？', {
                btn: ['确定','我再想想']
            },function () {
                $.post('{{url('blogadmin/navs/')}}/'+nav_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data) {
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