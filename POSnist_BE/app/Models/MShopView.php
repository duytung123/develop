<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MShopView extends Model
{
    use Notifiable,SoftDeletes;
    protected $table = 'm_shop_views';
    protected $hidden = ['created_at','deleted_at'];
    protected $casts =
    [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];
    protected $fillable =
    [
        "shop_id",
        "log_img",
        "name",
        "postal_cd",
        "prefecture",
        "city",
        "area",
        "address",
        "tel",
        "access"
    ];
    public function m_shops()
    {
        return $this->belongsTo('App\Models\MShop','shop_id','id');
    }
}
