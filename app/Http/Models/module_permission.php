<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class module_permission extends Model
{
	protected $table = 'module_permission';

	protected $fillable = [
		'id',
		'module_id',
		'permission_id',
		'created_at',
		'created_by',
		'updated_by',
		'updated_at',
	];

	public function getToViewPermission()
	{
		return $this->HasOne('Spatie\Permission\Models\Permission', 'id', 'permission_id');
	}
}
