@extends('layouts.admincommon')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('blogadmin/article')}}">文章列表首页</a> &raquo; 文章管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>添加文章</h3>
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
                <a href="blogadmin/article/create"><i class="fa fa-plus"></i>添加文章</a>
                <a href="blogadmin/article"><i class="fa fa-recycle"></i>全部文章</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('blogadmin/article')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>文章分类：</th>
                        <td>
                            <select name="cate_id">
                                <option value="0">==顶级分类==</option> 
                                @foreach($cate_list as $vo)
                                    <option value="{{$vo->cate_id}}">{{$vo->_cate_name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" class="lg" name="art_title">
                            <span><i class="fa fa-exclamation-circle yellow"></i>标题可以写30个字</span>
                        </td>
                    </tr>
                    <tr>
                        <th>关键词：</th>
                        <td>
                            <textarea name="art_tag"></textarea>
                            <span><i class="fa fa-exclamation-circle yellow"></i>关键词与关键词之间，用英文状态下的逗号隔开</span>
                        </td>
                    </tr>
                    <tr>
                        <th>文章描述：</th>
                        <td>
                            <textarea class="lg" name="art_description"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>文章内容：</th>
                        <td>
                            <style>
                                .edui-default{line-height: 28px;}
                                div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                                {overflow: hidden; height:20px;}
                                div.edui-box{overflow: hidden; height:22px;}
                            </style>
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources/extends/ueditor/ueditor.config.js')}}"></script>
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources/extends/ueditor/ueditor.all.min.js')}}"> </script>
                            <script type="text/javascript" charset="utf-8" src="{{asset('resources/extends/ueditor/lang/zh-cn/zh-cn.js')}}"></script>

                            {{--输入框主体--}}
                            <script id="editor" name="art_content" type="text/plain" style="width:1024px;height:500px;"></script>

                            {{--实例化编辑器，不实例化无法显示输入框--}}
                            <script>
                                var ue = UE.getEditor('editor');
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <th>缩略图：</th>
                        <td>
                            <script type="text/javascript" src="{{asset('resources/extends/uploadify/jquery.uploadify.min.js')}}"></script>
                            <link rel="stylesheet" type="text/css" href="{{asset('resources/extends/uploadify/uploadify.css')}}">
                            <style>
                                .uploadify{display:inline-block;}
                                .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
                                table.add_tab tr td span.uploadify-button-text{color: #fff; margin:0;}
                                #art_thumb_img {
                                    max-width:200px;
                                }
                            </style>
                            <input type="text" name="art_thumb" size="50px">
                            <input id="file_upload" name="file_upload" type="file">
                            <script type="text/javascript">
                                <?php $timestamp = time();?>
                                $(function() {
                                    $('#file_upload').uploadify({
                                        'formData'     : {
                                            'timestamp' : '<?php echo $timestamp;?>',
                                            '_token'    : "{{csrf_token()}}"
                                        },
                                        'buttonText': "选择要上传的图片",
                                        'swf'      : "{{asset('resources/extends/uploadify/uploadify.swf')}}",
                                        'uploader' : "{{url('blogadmin/upload')}}",
                                        'onUploadSuccess' : function(file, data, response) {
                                            $('input[name=art_thumb]').val(data);
                                            $('#art_thumb_img').attr('src','/'+data);
                                        }
                                    });
                                });
                            </script>
                            <tr>
                                <th>缩略图预览：</th>
                                <td>
                                    <img src="" alt="" id="art_thumb_img">
                                </td>
                            </tr>
                        </td>
                    </tr>
                    <tr>
                        <th>文章作者：</th>
                        <td>
                            <input type="text" class="sm" name="art_editor" value="热心网友">
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