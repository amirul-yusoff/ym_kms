<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;



class excelController extends Controller
{
    public function ExportClients()
    {
    	Excel::create('clients', function($excel){
    		$excel->sheet('clients', function($sheet){
    			$sheet->loadView('excel.exportClients');
    		});
    	})->export('xlsx');
    }
}
