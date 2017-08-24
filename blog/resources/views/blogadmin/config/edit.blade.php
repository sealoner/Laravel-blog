@extends('layouts.admincommon')
@section('content')
    <!--面包屑网站配置 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('blogadmin/config')}}">网站配置首页</a> &raquo; 网站配置管理
    </div>
    <!--面包屑网站配置 结束-->

    <!--结果集标题与网站配置组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>修改网站配置目</h3>
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
                <a href="{{url('blogadmin/config/create')}}"><i class="fa fa-plus"></i>添加配置</a>
                <a href="blogadmin/config"><i class="fa fa-recycle"></i>全部配置</a>
            </div>
        </div>
    </div>
    <!--结果集标题与网站配置组件 结束-->

    <div class="result_wrap">
        <form action="{{url('blogadmin/config/'.$confdata->conf_id)}}" method="post">
            {{--<input type="hidden" name="_method" value="put">--}}
            {{--或者使用这种格式--}}
            {{method_field('PUT')}}
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>标题：</th>
                    <td>
                        <input type="text" class="lg" name="conf_title" value="{{$confdata->conf_title}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>配置项标题不能为空</span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>名称：</th>
                    <td>
                        <input type="text" class="lg" name="conf_name" value="{{$confdata->conf_name}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>配置项名称不能为空</span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>类型：</th>
                    <td>
                        <input type="radio" name="field_type" value="input" @if($confdata->field_type=='input') checked @endif onclick="showTr()">input
                        <input type="radio" name="field_type" value="textarea"  @if($confdata->field_type=='textarea') checked @endif onclick="showTr()">textarea
                        <input type="radio" name="field_type" value="radio" @if($confdata->field_type=='radio') checked @endif onclick="showTr()">radio
                    </td>
                </tr>
                <tr class="field_value">
                    <th><i class="require">*</i>类型值：</th>
                    <td>
                        <input type="text" class="lg" name="field_value" value="{{$confdata->field_value}}">
                        <p><i class="fa fa-exclamation-circle yellow"></i>类型值只有在类型为radio的情况下才需要配置，格式1|开启，格式0|关闭</p>
                    </td>
                </tr>
                <tr>
                    <th>网站配置项排序：</th>
                    <td>
                        <input type="text" class="sm" name="conf_order" value="{{$confdata->conf_order}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>默认为0，根据添加时间进行排序。</span>
                    </td>
                </tr>
                <tr>
                    <th>说明：</th>
                    <td>
                        <textarea name="conf_tips" id="" cols="30" rows="10">{{$confdata->conf_content}}</textarea>
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
    <script>
        showTr();
        function showTr() {
            var type=$('input[name=field_type]:checked').val();
            if(type == 'radio') {
                $('.field_value').show();
            }else{
                $('.field_value').hide();
            }
        }
    </script>
@endsection