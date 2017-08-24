<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>{{$config['title']}}</title>
	<link rel="stylesheet" href="{{asset('resources/views/blogadmin/style/css/ch-ui.admin.css')}}">
	<link rel="stylesheet" href="{{asset('resources/views/blogadmin/style/font/css/font-awesome.min.css')}}">
</head>
<body style="background:#F3F3F4;">
	<div class="login_box">
		<h1>Blog</h1>
		<h2>欢迎使用博客管理平台</h2>
		<div class="form">

			<form action="" method="post">
				{{csrf_field()}}
				<ul>
					<li>
					<input type="text" name="user_name" class="text"/>
						<span><i class="fa fa-user"></i></span>
					</li>
					<li>
						<input type="password" name="user_password" class="text"/>
						<span><i class="fa fa-lock"></i></span>
					</li>
					<li>
						<input type="text" class="code" name="code"/>
						<span><i class="fa fa-check-square-o"></i></span>
						{{--这样写，是根据我们在web.php中添加的路由生成的，调用的是blogadmin前缀下的code方法，
						如果我们把这一条路由改成别的了，验证码就会报错--}}
						<img src="{{url('blogadmin/code')}}" alt="" onclick="this.src='{{url('blogadmin/code')}}?'+Math.random()">
					</li>
					@if(session('ErrorMsg'))
						<p style="color:red">{{session('ErrorMsg')}}</p>
					@endif
						<li>
							<input type="submit" value="立即登陆"/>
						</li>
				</ul>
			</form>
			<p><a href="#">返回首页</a> &copy; 2016 Powered by <a href="http://www.houdunwang.com" target="_blank">http://www.houdunwang.com</a></p>
		</div>
	</div>
</body>
</html>