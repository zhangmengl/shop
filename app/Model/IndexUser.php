<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class IndexUser extends Model
{
    protected $table = 'index_user';
    protected $primaryKey = 'id';
    // 关闭时间戳
    public $timestamps = false;
    //protected $fillable = ['user_name','email','password','reg_time'];
    protected $guarded = ['passwords'];
}
