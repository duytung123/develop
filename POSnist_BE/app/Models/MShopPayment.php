<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MShopPayment extends Model
{
    use Notifiable,
        SoftDeletes;
    protected $table = 'm_shops_payments';
    protected $hidden = ['created_at'];
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];

    protected $fillable = [
        "id",
        "shop_id",
        "name",
        "sort",
        "update_up",
        ];
        
}

