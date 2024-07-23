<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class supplier_invoice_has_po extends Model
{
	protected $table = 'supplier_invoice_has_po';

	protected $fillable = [
		'id',
		'supplier_invoice_id',
		'po_number',
	];

	public function findCreatedBy()
	{
		return $this->hasOne('App\Http\Models\Member', 'id', 'created_by');
	}
}
