<?php

namespace App\Http\Controllers\blogadmin;

use App\Http\Model\Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends CommonController
{
    public function index() {
        $config = Config::orderBy('conf_order','desc')->get();
        $arr = [];
        //将网站配置项的内容遍历出来，再传到视图页面中去
        foreach($config as $k=>$v) {
            $id =$v->conf_id;
            $ft = $v->field_type;
            switch($ft) {
                case 'input':
                    $config[$k]->_html = '<input type="text" class="lg" name="conf_content['.$id.']" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $config[$k]->_html = '<textarea type="text" class="lg" name="conf_content['.$id.']">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    //1|开启,0|关闭
                    $arr = explode(',',$v->field_value);
                    $str = '';
                    foreach($arr as $m=>$n){
                        //1|开启
                        $r = explode('|',$n);
                        $c = $v->conf_content==$r[0]?' checked ':'';

                        $str .= '<input type="radio" name="conf_content['.$id.']" value="'.$r[0].'"'.$c.'>'.$r[1].'　';
                    }
                    $config[$k]->_html = $str;
                    break;
            }
        }

        return view('blogadmin.config.index',compact('config'));
    }

    public function create() {
        return view('blogadmin.config.create');
    }

    //Order排序
    public function order() {
        //先获取表单提交的数据
        $input = Input::all();
        //根据传递的link_id获取数据库对应的数据
        $config = Config::find($input['conf_id']);
        //将获取到的表单数据中的link_order的值，赋给数据库中对应的字段
        $config->conf_order = $input['conf_order'];
        //更新数据库
        $re = $config->update();
        if($re) {
            $data = [
                'status' => 0,
                'msg'    => "栏目排序更新成功",
            ];
        }else{
            $data = [
                'status' => 1,
                'msg'    => "栏目排序更新失败",
            ];
        }
        return $data;
    }
    //post.admin/category
    //用来接收我们提交的新增的分类
    public function store()
    {
        $input = Input::except('_token');
        //做校验
        if($input) {
            $rules = [
                'conf_name'   => 'required',
                'conf_title'  => 'required',
            ];
            $messages = [
                'conf_name.required'    => '配置项名为必填项',
                'conf_title.required'   => '配置项标题为必填项',
            ];
            $validator = Validator::make($input,$rules,$messages);
            if($validator->passes()) {
                $re = Config::create($input);
                return redirect('blogadmin/config');
            }else{
                return back()->withErrors($validator);
            }

        }else{
            return view('blogadmin.config');
        }
    }

    //修改网站配置
    public function edit($conf_id) {
        if($conf_id) {
            //通过主键id查找数据
            $confdata = Config::find($conf_id);
            $this->putFile();
            return view('blogadmin/config/edit',compact('confdata'));
        }else{
            return back()->with('errors','ID参数不合法');
        }   
    }

    //保存修改过的网站配置
    public function update($conf_id) {
        $input = Input::except('_token','_method');
        $re = Config::where('conf_id',$conf_id)->update($input);
        if($re) {
            $this->putFile();
            return redirect('blogadmin/config');
        }else{
            return back()->with('errors','配置项栏更新失败，请稍后重试');
        }
    }

    //异步删除网站配置
    public function destroy($conf_id) {
        //根据id，删除字段
        $re = Config::where('conf_id',$conf_id)->delete();
        if($re) {
            $data = [
                'status' => 0,
                'msg'    => '栏目删除成功',
            ];
        }else {
            $data = [
                'status' => 1,
                'msg'    => '栏目删除失败',
            ];
        }
        $this->putFile();
        return $data;
    }
    //config首页，类型值修改
    public function changecontent() {
        $input = Input::all();
        if($input) {
            foreach($input['conf_content'] as $k=>$v) {
                Config::where('conf_id',$k)->update(['conf_content'=>$v]);
            }
//            dd($input['conf_content']);
            //当网站的配置项内容改变时，自动调用putFile方法，更新生成配置文件
            $this->putFile();
            return back()->with('errors','配置项更新成功');
        }else{
            return back()->with('errors','配置项更新失败');
        }
    }

    public function show() {
        $this->putFile();
    }

//将数据库中的数据拿出并重组，方法根目录下的config文件夹中的对应网站配置文件中
    public function putFile() {
        $config = Config::pluck('conf_content','conf_name')->all();
        $path = base_path().'\config\webconfig.php';
        $str = '<?php return '.var_export($config,true).';';
        //var_export()返回的是$config的字符串表示
        //将配置项以数组的格式放入文件中
        file_put_contents($path,$str);
    }

}
