<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class permission extends Model
{
	protected $table = 'permission';

	public $timestamps = false;

	protected $fillable = [
		'employee_code',
		'module_id',
		'can_create',
		'can_read',
		'can_update',
		'can_delete',
		'isdelete'
	];

	public function scopeNotDelete($query)
	{
		return $query->where('isdelete', 0);
	}

	public function scopeHasAccess($query, $employeeCode, $moduleID)
	{
		return $query->where('employee_code', $employeeCode)->where('module_id', $moduleID)->notDelete()->first();
	}

	public function module()
	{
		return $this->belongsTo('App\Http\Models\module', 'module_id');
	}

}
