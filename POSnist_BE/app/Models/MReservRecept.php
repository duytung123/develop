<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MReservRecept extends Model
{
    use Notifiable,
     SoftDeletes;
    protected $table = 'm_reserv_recepts';
    protected $hidden = ['created_at'];
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];
    protected $fillable = [
        'id',
        'shop_id',
        'reserv_interval',
        'recept_rest',
        'recept_amount',
        'cancel_setting_flg',
        'cancel_limit',
        'future_reserv_num',
        'cancel_wait_flg',
        'update_at'
        ];
    public function m_shop()
    {
        return $this->belongsTo('App\Models\MShop', 'shop_id', 'id');
    }
}
