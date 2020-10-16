<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MCourse extends Model
{
    use SoftDeletes;
    protected $casts = [
            'created_at' => 'date:Y-m-d H:i:s',
            'updated_at' => 'date:Y-m-d H:i:s',
            'deleted_at' => 'date:Y-m-d H:i:s',
        ];
    protected $table = 'm_courses';
    protected $hidden = ['created_at'];
    protected $fillable = [
        'id',
        'class_id',
        'category_cd',
        'name',
        'treatment_time',
        'buffer_time',
        'count',
        'price',
        'tax_id',
        'limit_date',
        'color_code',
        'sort',
        'month_menu_flg',
        'updated_at'
        ];
    public function m_classes()
    {
        return $this->belongsTo('App\Models\MClasse','class_id','id');
    }
}
