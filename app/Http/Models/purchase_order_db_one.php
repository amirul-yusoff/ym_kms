<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class purchase_order_db_one extends Model
{
	// Specify which connection to use
	protected $table = 'purchase_order';
    protected $connection = 'db_jtkms';  // Ensure this is the correct connection name from config/database.php
    public $timestamps = false;
}
