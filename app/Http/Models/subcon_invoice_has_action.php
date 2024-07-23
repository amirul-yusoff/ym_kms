<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class subcon_invoice_has_action extends Model
{
	protected $table = 'subcon_invoice_has_action';

	protected $fillable = [
		'id',
		'subcon_invoice_id',
		'take_action_by_jtkms_member_id',
		'take_action_by_jtkms_member_name',
		'action',
		'reason',
		'created_at',
		'updated_at',
		'stage_from',
		'stage_to',
		'take_action_by_subconkms_member_id',
		'take_action_by_subconkms_member_name',
		
	];
	  
}
