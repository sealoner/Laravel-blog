<?php

namespace App\Http\Controllers\blogadmin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once 'resources\extends\Verify\Code.class.php';
class RegisterController extends CommonController
{
    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function register() {
        //首先获取生成的验证码
        $code = new \Code;
        $verify = $code->get();
        $input = Input::all();
        //其次获取注册页面提交过来的数据
        if($input) {
            //用户名暂时不验证
            //先验证两次输入的密码是否相同
            if($input['user_password'] != $input['user_repassword']) {
                return back()->with('ErrorMsg','两次密码输入不相同，请重新输入');
            }elseif(strtoupper($input['code']) != $verify) {
                return back()->with('ErrorMsg','验证码输入错误，请重新输入');
            }
            //验证成功，将获取到的用户名和密码存入数据表中
            $saveuser = new User();
            $saveuser->user_name = $input['user_name'];
            $saveuser->user_password = Crypt::encrypt($input['user_password']);
            $saveuser->save();
            echo "注册成功";
            return redirect('blogadmin/login');
        }else{
            return view('blogadmin.register')->with('title','用户后台注册');
        }

    }
}
