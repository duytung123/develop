<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class MTaxe extends Model
{
    use SoftDeletes; 
    protected $table = 'm_taxes';
    protected $hidden = ['created_at'];
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];
    protected $fillable = [
        "id",
        "name",
        "tax",
        "reduced_flg",
        "start_date",
        "end_date",
        "updated_at",
    ];
    public function m_skills()
    {
        return $this->hasMany('App\Models\MSkill', 'tax_id', 'id');
    }
}
