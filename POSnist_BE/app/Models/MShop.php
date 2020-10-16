<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MShop extends Model
{

      use Notifiable,
        SoftDeletes;
    protected $table = 'm_shops';
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];
    protected $fillable = [
        "id",
        "name",
        "company_id",
        "postal_cd",
        "prefecture",
        "city",
        "address",
        "tel",
        "email",
        "opening_time",
        "closing_time",
        "time_break",
        "facility",
        'language'
        ];
    public function m_classes()
    {
        return $this->hasMany('App\Models\MClasse', 'shop_id', 'id');
    }

    public function m_skills()
    {
        return $this->hasManyThrough('App\Models\MSkill', 'App\Models\MClasse', 'shop_id', 'class_id', 'id');
    }

    public function m_payments()
    {
        return $this->hasManyThrough('App\Models\MPayment', 'App\Models\TShopsPayment', 'shop_id', 'payment_id', 'id');
    }

    public function t_shops_payments()
    {
        return $this->hasMany('App\Models\TShopsPayment', 'shop_id', 'id');
    }

    public function m_disscount()
    {
        return $this->hasMany('App\Models\MDiscount', 'shop_id', 'id');
    }

    public function m_staffs()
    {
        return $this->hasMany('App\Models\MStaff', 'shop_id', 'id');
    }

    public function m_shop_mail_destinations()
    {
        return $this->belongsTo('App\Models\MShopMailDestinations','shop_id','id');
    }

    public function m_shop_mails()
    {
        return $this->belongsTo('App\Models\MShopMails', 'shop_id', 'id');
    }
    public function m_reserv_recepts()
    {
        return $this->hasMany('App\Models\MReservation', 'shop_id', 'id');
    }
    public function m_shopterms()
    {
        return $this->hasMany('App\Models\MReservation', 'shop_id', 'id');
    }
    public function m_shop_holidaies()
    {
        return $this->hasMany('App\Models\MShopHolidaie','shop_id','id');
    }
    public function  m_shop_public_holidaies()
    {
        return $this->hasMany('App\Models\MShopPublicHolidaies','shop_id','id');
    }
}
