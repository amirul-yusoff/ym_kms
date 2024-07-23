<?php

namespace App\Http\Models;

use App\Http\Models\parameter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class member_position extends Model
{
	use SoftDeletes;
	
	protected $table = 'member_position';

	protected $date = ['deleted_at'];

	protected $fillable = [
		'position_name',
		'created_by'
	];

    public function memberPositionList()
    {
    	return member_position::orderBy('position_name', 'ASC')->get()->pluck('position_name', 'id')->toArray();
    }

    public function getGroupName($id)
    {
    	return parameter::where('Parameter_ID', '=', $id)->value('item');
    }
}
