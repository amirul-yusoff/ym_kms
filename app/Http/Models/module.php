<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class module extends Model
{
	protected $table = 'module';

	protected $fillable = [
		'parent_id',
		'module_type',
		'module_name',
		'description',
		'platform',
		'status',
		'url',
		'icon',
		'isdelete',
		'created_at',
		'created_by',
		'updated_by',
		'updated_at',
	];

	public function parent()
	{
		return $this->belongsTo('App\Http\Models\module', 'parent_id', 'id');
	}

	public function getToViewPermission()
	{
		return $this->HasOne('App\Http\Models\module_permission', 'module_id', 'id');
	}

	public function submenu()
	{
		return $this->hasMany('App\Http\Models\module', 'parent_id', 'id');
	}
}
