@extends('layouts.admincommon')
@section('content')
    <!--面包屑网站配置项 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('blogadmin/config')}}">网站配置项首页</a> &raquo; 网站配置项管理
    </div>
    <!--面包屑网站配置项 结束-->

	<!--结果集标题与网站配置项组件 开始-->
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
    <!--结果集标题与网站配置项组件 结束-->

    <div class="result_wrap">
        <form action="{{url('blogadmin/config')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>标题：</th>
                        <td>
                            <input type="text" class="lg" name="conf_title">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置项标题不能为空</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>名称：</th>
                        <td>
                            <input type="text" class="lg" name="conf_name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置项名称不能为空</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>类型：</th>
                        <td>
                            <input type="radio" name="field_type" value="input" checked="checked" onclick="showTr()">input&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="field_type" value="textarea" onclick="showTr()">textarea&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="field_type" value="radio" onclick="showTr()">radio
                        </td>
                    </tr>
                    <tr class="field_value">
                        <th><i class="require">*</i>类型值：</th>
                        <td>
                            <input type="text" class="lg" name="field_value" value="">
                            <p><i class="fa fa-exclamation-circle yellow"></i>类型值只有在类型为radio的情况下才需要配置，格式1|开启，格式0|关闭</p>
                        </td>
                    </tr>
                    <tr>
                        <th>网站配置项排序：</th>
                        <td>
                            <input type="text" class="sm" name="conf_order" value="0">
                            <span><i class="fa fa-exclamation-circle yellow"></i>默认为0，根据添加时间进行排序。</span>
                        </td>
                    </tr>
                    <tr>
                        <th>说明：</th>
                        <td>
                            <textarea name="conf_tips" id="" cols="30" rows="10"></textarea>
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

    {{--使用JS控制，选择类型时，只有在选择radio时才会出现类型值的配置项--}}
    <script>
        showTr();
        function showTr() {
            //声明一个变量，当我们触发这个方法时，当input表单的name值为field_type且为选中状态时，获取这个表单的value值
            var type = $('input[name=field_type]:checked').val();
            //alert(type);
            //对这个变量进行判断,如果值为radio，显示类型值的表单，如果不是，隐藏
            //所以需要先给类型值赋一个class，来控制它的类型
            if(type == 'radio') {
                //操控class值为field_value的标签，进行显示操作
                $('.field_value').show();
            }else{
                $('.field_value').hide();
            }
        }
    </script>
@endsection