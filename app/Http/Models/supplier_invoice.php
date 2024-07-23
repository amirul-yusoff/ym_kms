<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class supplier_invoice extends Model
{
	protected $table = 'supplier_invoice';

	protected $fillable = [
		'id',
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
		return $this->hasMany('App\Http\Models\supplier_invoice_has_document', 'supplier_invoice_id', 'id');
	}
	public function getPO()
	{
		return $this->hasMany('App\Http\Models\supplier_invoice_has_po', 'supplier_invoice_id', 'id');
	}
	public function findCreatedBy()
	{
		return $this->hasOne('App\Http\Models\Member', 'id', 'created_by');
	}
}
