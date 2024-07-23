<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class member_department extends Model
{
	use SoftDeletes;
	
	protected $table = 'member_department';

	protected $date = ['deleted_at'];

	protected $fillable = [
		'department_name',
		'created_by'
	];
}
