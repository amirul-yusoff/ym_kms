<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{

	protected $fillable = [
		'sender_code',
		'receiver_code',
		'content',
		'link',
		'has_read'
	];

	public function sender()
	{
		return $this->belongsTo('App\Http\Models\Member', 'sender_code', 'employee_code');
	}

	public function receiver()
	{
		return $this->belongsTo('App\Http\Models\Member', 'receiver_code', 'employee_code');
	}
}
