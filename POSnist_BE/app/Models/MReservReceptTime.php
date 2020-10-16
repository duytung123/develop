<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MReservReceptTime extends Model
{
    use SoftDeletes; 
    protected $table = 'm_reserv_recept_times';
    protected $hidden = ['created_at','deleted_at'];
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];
    protected $fillable = [
        "id",
        "shop_id",
        "recept_type",
        "recept_start",
        "recept_end",
        "recept_start_mo",
        "recept_end_mo",
        "recept_start_tu",
        "recept_end_tu",
        "recept_start_we",
        "recept_end_we",
        "recept_start_th",
        "recept_end_th",
        "recept_start_fr",
        "recept_end_fr",
        "recept_start_sa",
        "recept_end_sa",
        "recept_start_su",
        "recept_end_su",
        "recept_start_ho",
        "recept_end_ho",
        "created_at",
        "updated_at",
        "deleted_at"
        ];
}
