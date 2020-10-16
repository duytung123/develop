<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MItem extends Model
{
    //
    use Notifiable,
        SoftDeletes;
    protected $table = 'm_items';
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];
    protected $fillable = [
        "id",
        "class_id",
        "category_cd",
        "name",
        "used_date",
        "price",
        "tax_id",
        "sort",
        "created_at",
        "updated_at"
    ];
    public function m_classes()
    {
        return $this->belongsTo('App\Models\MClasse','class_id','id');
    }
}
