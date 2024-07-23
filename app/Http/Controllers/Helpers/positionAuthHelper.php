<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Models\members;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class positionAuthHelper
{
    public $PT1 = 0;
    public $PT2 = 0;
    public $PT3 = 0;
    public $PT4 = 0;
    public $PT5 = 0;
    public $PT6 = 0;
    public $PT7 = 0;

	/**
     * Return position permission via Associative Arrays (this was initial coding, now changed to object).
     *
     * @param  string  $position
     * @return  boolean  $rolePermission
     */
    public function positionAuth($position) 
    {
        if (preg_match('/1/', $position)) {
            $this->PT1 = 1;
        }
        if (preg_match('/2/', $position)) {
            $this->PT2 = 1;
        }
        if (preg_match('/3/', $position)) {
            $this->PT3 = 1;
        }
        if (preg_match('/4/', $position)) {
            $this->PT4 = 1;
        }
        if (preg_match('/5/', $position)) {
            $this->PT5 = 1;
        }
        if (preg_match('/6/', $position)) {
            $this->PT6 = 1;
        }
        if (preg_match('/7/', $position)) {
            $this->PT7 = 1;
        }
        return $this;
    }

    public function test()
    {
        var_dump(get_object_vars($this));
    }
}
