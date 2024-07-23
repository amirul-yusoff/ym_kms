<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class subcon_invoice extends Model
{
	protected $table = 'subcon_invoice';

	protected $fillable = [
		'id',
		'wo_number',
		'wo_id',
		'invoice_date',
		'loc_date',
		'invoice_submission',
		'invoice_number',
		'invoice_amount',
		'status',
		'description',
		'created_at',
		'updated_at',
		'created_by',
		'stage',
		'company_id',
		
	];

	public function getFiles()
	{
		return $this->hasMany('App\Http\Models\subcon_invoice_has_document', 'subcon_invoice_id', 'id');
	}
	public function findCreatedBy()
	{
		return $this->hasOne('App\Http\Models\Member', 'id', 'created_by');
	}
}
