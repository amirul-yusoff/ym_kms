<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class sessions extends Model
{
	protected $table = 'sessions';

	public $timestamps = false;

	protected $fillable = [
		'id',
		'user_id',
		'ip_address',
		'user_agent',
		'payload',
		'last_activity'
	];
}
