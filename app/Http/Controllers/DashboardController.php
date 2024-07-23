<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Helpers\positionAuthHelper;
use App\Http\Models\Member;
use DB;
use Carbon\Carbon;
use App\Http\Models\project_registry;
use App\Http\Models\JointMeasurementSheet;
use App\Http\Models\subcon_invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function __construct(positionAuthHelper $positionAuthHelper, Request $request)
    {
	    
        $this->positionAuthHelper = $positionAuthHelper;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Dashboard';
        $breadcrumb = [
            [
                'name'=>$title,
            ]
        ];
        $data = subcon_invoice::with('getFiles')
        ->where('company_id',Auth::user()->company_id)
        ->get();

        return view('dashboardmain.index', compact('title', 'breadcrumb','data'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'This is Show route for dashboard';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
