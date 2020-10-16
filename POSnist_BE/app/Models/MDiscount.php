<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MDiscount extends Model
{
	protected $casts = ['updated_at'  => 'date:Y-m-d H:i:s',];
	protected $table = 'm_discounts';
	protected $hidden = ['created_at','deleted_at'];
	protected $fillable = [];
	use Notifiable,SoftDeletes;
	public function m_shops()
	{
		return $this->belongsTo('App\Models\MShop','shop_id','id');
	}
}
