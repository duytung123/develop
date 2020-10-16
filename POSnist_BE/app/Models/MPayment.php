<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MPayment extends Model
{
    use SoftDeletes;

    protected $table = 'm_payments';
    protected $hidden = ['created_at']; 
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];
    protected $fillable = [
        'id',
        'payment',
        'updated_at',
        ];
    
}
