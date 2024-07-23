<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class supplier_invoice_has_action extends Model
{
	protected $table = 'supplier_invoice_has_action';

	protected $fillable = [
		'id',
		'supplier_invoice_id',
		'take_action_by_jtkms_member_id',
		'take_action_by_jtkms_member_name',
		'action',
		'reason',
		'created_at',
		'updated_at',
		'stage_from',
		'stage_to',
		'take_action_by_supplierkms_member_id',
		'take_action_by_supplierkms_member_name',
		
	];
	  
}
