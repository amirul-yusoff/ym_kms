<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Models\database_type;


class dbCheckerHelper
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
    public function dbProductionChecker()
    {
        $databaseType = database_type::first();
        $databaseProduction = false;
        if ($databaseType['is_production'] == true) {
            $databaseProduction = true;
        }
        return $databaseProduction;
    }
}
