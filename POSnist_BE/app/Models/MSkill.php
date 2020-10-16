<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MSkill extends Model
{
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];
    protected $table = "m_skills";
    protected $hidden = ['created_at'];
    use Notifiable,SoftDeletes;// add soft delete
     protected $fillable = [
        "id",
        "class_id",
        "category_cd",
        "name",
        "treatment_time",
        "buffer_time",
        "price",
        "tax_id",
        "web_flg",
        "sort",
        "color_code",
        "update_at"
    ];
    public function m_classes()
    {
        return $this->belongsTo('App\Models\MClasse','class_id','id');
    }
    public function m_taxes()
    {
        return $this->belongsTo('App\Models\MTaxe','tax_id','id');
    }
}
