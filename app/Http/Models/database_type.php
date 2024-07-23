<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class database_type extends Model
{
	protected $table = 'database_type';

	public $timestamps = false;

	protected $fillable = [
		'id',
		'database_name',
		'is_production',
	];

}
