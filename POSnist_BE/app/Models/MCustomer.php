<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;


use Illuminate\Foundation\Auth\User as Authenticatable;

class MCustomer extends Authenticatable implements JWTSubject
{
    use Notifiable,
        SoftDeletes;
    protected $table = 'm_customers';
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];
    protected $fillable = [
        "shop_id",
        "customer_no",
        "firstname",
        "lastname",
        "firstname_kana",
        "lastname_kana",
        "sex",
        "email",
        "tel",
        "login_id",
        "password",
        "staff_id",
        "member_flg",
        "customer_img",
        "postal_cd",
        "prefecture",
        "city",
        "area",
        "address",
        "language",
        "visit_cnt",
        "first_visit",
        "last_visit"
        ];


     protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function AuthAcessToken(){
    return $this->hasMany('\App\Models\MCustomer');
        }

     public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        public function getJWTCustomClaims()
        {
            return [];
        }
}
