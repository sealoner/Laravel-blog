<?php

namespace App\Http\model;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    //设置需要进行操作的数据库的名称
    protected $table = "links";
    //设置主键
    protected $primaryKey = "link_id";
    //设置更新时间戳字段
    //const CREATED_AT = 'create_time';
    //const UPDATED_AT = 'update_time';
    public $timestamps = false;
    protected $guarded = [];
}
