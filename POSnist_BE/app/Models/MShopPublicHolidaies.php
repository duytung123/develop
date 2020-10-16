<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MShopPublicHolidaies extends Model
{
    use  SoftDeletes;
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];
    protected $table = 'm_shop_public_holidaies';
    protected $hidden = ['created_at'];
    protected $fillable = [
        'id',
        'shop_id',
        'date',
        'updated_at'
        ];
    public function m_shops()
    {
        return $this->belongsTo('App\Models\MShop','shop_id','id');
    }
}
