<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MShopMails extends Model
{
    use SoftDeletes;
    protected $table = 'm_shop_mails';
    protected $hidden = ['created_at', 'deleted_at'];
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];
    protected $fillable = [
        "id",
        "shop_id",
        "mail_type",
        "subject",
        "body"
        ];
    public function m_shops()
    {
        return $this->hasMany('App\Models\MShop', 'shop_id', 'id');
    }
}
