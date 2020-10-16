<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MCompanie extends Model
{
    use Notifiable,
        SoftDeletes;
    protected $table='m_companies';
    protected $hidden = ['created_at'];
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
        'deleted_at' => 'date:Y-m-d H:i:s',
    ];
    protected $primaryKey='id';
    protected $fillable = ['user_id','name','postal_cd','prefecture','city','area','address','accounting','cutoff_date'];

    public function m_shops()
    {
        return $this->hasMany('App\Models\MShop','company_id','id');
    }
}
