<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MClasse extends Model
{
    use SoftDeletes;
    protected $table = 'm_classes';
    protected $hidden = ['created_at'];
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];
    protected $fillable = [
        "id",
        "name",
        "category_cd",
        "shop_id",
        "sort"
        ];
    public function m_shop()
    {
        return $this->belongsTo('App\Models\Mshop','shop_id','id');
    }

    public function m_skills()
    {
        return $this->hasMany('App\Models\MSkill','class_id','id');
    }

    public function m_items()
    {
        return $this->hasMany('App\Models\MItem','class_id','id');
    }

    public function m_courses()
    {
        return $this->hasMany('App\Models\MCourse','class_id','id');
    }
}

