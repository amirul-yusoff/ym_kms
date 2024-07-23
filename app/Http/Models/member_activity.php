<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class member_activity extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'member_id',
		'method',
		'table_changed',
		'table_id',
		'reference_code',
		'content_changed',
		'created_at'
	];

	/**
	 * Scope a query to only include activities of a given type.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeOfType($query, $type)
	{
		return $query->where('table_changed', $type);
	}

	public function member()
	{
		return $this->belongsTo('App\Http\Models\Member');
	}
}
