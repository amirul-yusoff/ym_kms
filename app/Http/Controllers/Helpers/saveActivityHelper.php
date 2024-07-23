<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Models\member_activity;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class saveActivityHelper
{
	/**
     * Save the user activities.
     *
     * @param  string  $method
     * @param  string  $table
     * @param  int  $id
     * @param  string  $ref_code
     * @param  array  $changes
     */
    public function saveActivity($method, $table, $id, $ref_code, $changes)
    {
    	$user = Auth::user();
    	member_activity::create([
            'member_id' => $user->id,
            'method' => $method,
            'table_changed' => $table,
            'table_id' => $id,
            'reference_code' => $ref_code,
            'content_changed' => json_encode($changes),
            'created_at' => Carbon::now()
        ]);
    }
}
