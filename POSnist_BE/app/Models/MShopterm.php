<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MShopterm extends Model
{
    use Notifiable,
    SoftDeletes;
    protected $table = 'm_shopterms';
    protected $hidden = ['created_at'];
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];
    protected $fillable = [
        'id',
        'shop_id',
        'terms',
        'privacy_policy',
        'update_at'
        ];
    public function m_shop()
    {
        return $this->belongsTo('App\Models\MShop', 'shop_id', 'id');
    }
}
