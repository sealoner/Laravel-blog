@extends('layouts.admincommon')
@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('blogadmin/config')}}">网站配置项首页</a> &raquo; 全部网站配置项
    </div>
    <!--面包屑配置项 结束-->

    <div class="result_wrap">
        <div class="result_title">
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p style="color: orangered;">{{$error}}</p>
                        @endforeach
                    @else
                        <p style="color: orangered;">{{$errors}}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!--搜索结果页面 列表 开始-->
    <form action="{{url('blogadmin/config/changecontent')}}" method="post">
        {{csrf_field()}}
        <div class="result_wrap">
            <!--快捷配置项 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('blogadmin/config/create')}}"><i class="fa fa-plus"></i>新增网站配置项</a>
                    <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                    <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
                </div>
            </div>
            <!--快捷配置项 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th>排序</th>
                        <th class="tc">ID</th>
                        <th>配置项标题</th>
                        <th>配置项名称</th>
                        <th>内容</th>
                        <th>操作</th>
                    </tr>
                    @foreach($config as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$v->conf_id}})" onkeyup="this.value=this.value.replace(/\D/g,'')" value="{{$v->conf_order}}">
                        </td>
                        <td class="tc">{{$v->conf_id}}</td>
                        <td>{{$v->conf_title}}</td>
                        <td>{{$v->conf_name}}</td>
                        <td>
                            {{--<input type="hidden" value="{{$v->conf_id}}" name="conf_id[]">--}}
                            {!! $v->_html !!}
                        </td>
                        <td>
                            <a href="{{url('blogadmin/config/'.$v->conf_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delConf({{$v->conf_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="btn_group">
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回" >
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

    <script>
        //排序修改成功/失败提示框
        function changeOrder(obj,conf_id) {
            var conf_order = $(obj).val();
            $.post("{{url('blogadmin/config/order')}}",{'_token':'{{csrf_token()}}','conf_order':conf_order,'conf_id':conf_id},function(data){
            location.href = location.href;
            if(data.status == 0) {
                layer.msg(data.msg,{icon:6});
            }else{
                layer.msg(data.msg,{icon:5});
            }

            });
        }
        //删除提示框
        function delConf(conf_id) {
            layer.confirm('是否确认删除这篇文章吗？', {
                btn: ['确定','我再想想']
            },function () {
                $.post('{{url('blogadmin/config/')}}/'+conf_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data) {
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