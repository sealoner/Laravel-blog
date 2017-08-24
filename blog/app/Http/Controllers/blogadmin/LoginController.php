<?php

namespace App\Http\Controllers\blogadmin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

require_once 'resources\extends\Verify\Code.class.php';

class LoginController extends CommonController
{
    public function login() {

        //判断表单提交方式
        if($input = Input::all()) {
        //这里的$input表示的是提交的表单中的全部数据,是个数组的形式
            //先对用户提交的验证码进行验证
            $code = new \Code;
            $verify = $code->get();
            //对用户输入的用户名和密码进行判断
            $username = $input['user_name'];
            $user = DB::table('user')->where('user_name',$username)->first();
            if($username != $user->user_name || $input['user_password'] != Crypt::decrypt($user->user_password)) {
                return back()->with('ErrorMsg','用户名或密码错误，请重新输入！');
            }
            //对验证码进行验证
            if($verify != strtoupper($input['code'])) {
                //如果验证码错误，使用back()函数，返回前一页面，并传递一个错误提示参数
                //然后去视图中接收这个参数
                return back()->with('ErrorMsg','验证码错误');//传递的参数是保存在session中的
//                return dd(session()->all());
            }
            session(['user'=>$user]);
//            dd(session('user'));
            return redirect('blogadmin/index');
        }else{
//            session(['user'=>null]);
            $config = [
                'title'=>'后台登录',
            ];
            return view('blogadmin.login',compact('config'));
        }
    }

    //实例化Code类，调用make方法，生成验证码
    public function code() {
        $code = new \Code;
        $code->make();
    }

    //清除session，实现退出功能
    public function quit() {
        session(['user'=>null]);
        return redirect('blogadmin/login');
    }
    
}



























