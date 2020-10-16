<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MStaff extends Model
{
    use Notifiable,SoftDeletes;
    protected $hidden = ['created_at','deleted_at'];
    protected $table = 'm_staffs';
    protected $casts = ['updated_at'  => 'date:Y-m-d H:i:s',];
    protected $fillable = ['shop_id','name','name_kana','staff_img','sex'];


    public function m_shops()
    {
        return $this->belongsTo('App\Models\MShop','shop_id','id');
    }
}
