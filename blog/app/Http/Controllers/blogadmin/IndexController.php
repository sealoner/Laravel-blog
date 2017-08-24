<?php

namespace App\Http\Controllers\blogadmin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{
    public function index() {
        return view('blogadmin.index');
    }

    public function info() {
        return view('blogadmin.info');
    }
    //修改密码的逻辑
    public function pass() {
        //对表单提交的数据进行Validator验证
        $input = Input::all();
        if($input) {
            //构建验证规则
            $rules = [
                'password'=>'required|between:6,20|confirmed',
                'password_o'=>'required',
            ];
            //自定义错误提示信息
            $messages = [
                'password.required' => '密码不能为空',
                'password.between'  => '新密码长度要在6~20位之间',
                'password.confirmed'=> '两次密码输入不相同',

                'password_o.required'=> '请输入原密码',
            ];
            //如果获取到了表单中提交的数据，实例化Validator这个类，并调用make方法，获取数据，并添加验证规则
            $validate = Validator::make($input,$rules,$messages);

            if($validate->passes()) {
                //连接数据库，将获取到的数据与数据库中的数据进行比较
                $user = session('user');
                $username = $user->user_name;
                $users = User::where('user_name',$username)->first();
                //如果输入的原密码和数据库中国保存的密码相同，那么更新数据库中的密码
                if($input['password_o'] == Crypt::decrypt($users->user_password)) {
                    $users->user_password = Crypt::encrypt($input['password']);
                    //调用save或update方法
                    $users->update();
                    return redirect('blogadmin/info');
                }else {
                    //否则，回到上一页面，并且的返回错误信息
                    //将错误信息放到errors这个集合中
                   return back()->with('errors','原密码输入错误请重新输入！');
//                    return back()->withErrors('原密码输入错误，请确认后重新输入');
                }
            }else {
//                将错误信息显示在视图页面中
//            withError()方法的第一个参数是要闪存进session中的错误信息，第二个参数是一个别名！如果要在前台视图中引用，还是需要$errors->errmsg
//                     也就是说$errors变量就是从session闪存中拿取数据专用的
//                dd($validate->errors()->all());
            return back()->withErrors($validate);
            }
        }else{
            return view('blogadmin.pass');
        }
    }
}
