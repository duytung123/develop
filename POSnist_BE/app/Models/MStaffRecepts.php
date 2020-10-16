<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MStaffRecepts extends Model
{
    use SoftDeletes;
    protected $casts = [
            'created_at' => 'date:Y-m-d H:i:s',
            'updated_at' => 'date:Y-m-d H:i:s',
            'deleted_at' => 'date:Y-m-d H:i:s',
        ];
    protected $table = 'm_staff_recepts';
    protected $hidden = ['created_at'];
    protected $fillable = [
        'id',
        'staff_id',
        'recept_amount',
        'web_flg',
        'nomination',
        'updated_at'
        ];
    
}
