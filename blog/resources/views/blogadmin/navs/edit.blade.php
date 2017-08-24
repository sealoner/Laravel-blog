@extends('layouts.admincommon')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('blogadmin/links')}}">导航栏首页</a> &raquo; 导航管理
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>修改导航栏目</h3>
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
        <div class="result_content">
            <div class="short_wrap">
                <a href="blogadmin/navs/create"><i class="fa fa-plus"></i>添加栏目</a>
                <a href="blogadmin/navs"><i class="fa fa-recycle"></i>全部栏目</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('blogadmin/navs/'.$navdata->nav_id)}}" method="post">
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>栏目名称：</th>
                    <td>
                        <input type="text" class="lg" name="nav_name" value="{{$navdata->nav_name}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>名称最好不超过4个字符</span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>栏目别名：</th>
                    <td>
                        <input type="text" class="sm" name="nav_alias" value="{{$navdata->nav_alias}}">
                    </td>
                </tr>
                <tr>
                    <th>栏目地址：</th>
                    <td>
                        <input class="lg" name="nav_url" value="{{$navdata->nav_url}}" placeholder="格式为：http://www.XXX.com或http://XXX.com"></input>
                    </td>
                </tr>
                <tr>
                    <th>栏目排序：</th>
                    <td>
                        <input type="text" class="sm" name="nav_order" value="{{$navdata->nav_order}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>默认为0，根据添加时间进行排序。</span>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection