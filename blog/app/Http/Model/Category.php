<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //设置需要进行操作的数据库的名称
    protected $table = "category";
    //设置主键
    protected $primaryKey = "cate_id";
    //设置更新时间戳字段
//    const CREATED_AT = 'create_time';
//    const UPDATED_AT = 'update_time';
    public $timestamps = false;
    protected $guarded = [];

    public function tree() {
        $categorys = $this->orderBy('cate_order','desc')->get();
        //当前方法调用getTree方法，并将$categorys变量传过去
        return $this->getTree($categorys,'cate_pid','cate_id','cate_name');
    }

    //无限极分类方法
    public function getTree($data,$field_pid,$field_id,$field_name,$pid=0) {
        $arr = array();
        foreach($data as $k=>$v) {
            if ($v->$field_pid == $pid) {
                $data[$k]["_".$field_name] = $data[$k][$field_name];
                $arr[] = $data[$k];
                foreach ($data as $m => $n) {
                    if ($n->$field_pid == $v->$field_id) {
                        $data[$m]["_".$field_name] = '┣━ ' . $data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }
}

















