<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class role_has_permissions extends Model
{
	protected $table = 'role_has_permissions';

	public $timestamps = false;
	
	protected $fillable = [
		'permission_id',
		'role_id',
	];
}
