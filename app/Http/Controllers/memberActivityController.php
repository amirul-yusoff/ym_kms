<?php

namespace App\Http\Controllers;
use App\Http\Models\member_activity;
use App\Http\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class memberActivityController extends Controller
{
	public function __construct()
	{
    	    	
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $date
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $date = null)
    {
	    if (! Gate::allows('member_activities_view')) {
            return abort(401);
        }
        $viewButton = 0;
        if (Gate::allows('member_activities_view')) {
            $viewButton = 1;
        }
        $title = 'Member Activities';
        $url = 'member-activity';
        $breadcrumb = [
            [
                'name'=>$title
            ]
        ];
        $member = Member::with('activities')->find(Auth::user()->id);
        if(isset($request['date'])){
            if(!is_null($request['date']) && !empty($request['date'])) {
                $date = $request['date'];
            } else {
                $today = Carbon::today();
                $date = $today->toDateString();
            }
        }
        $activities = member_activity::with('member')->whereDate('created_at', '=', $date)->orderBy('created_at', 'desc')->get()->groupBy('table_changed');

        return view('activity.index', compact('viewButton','title', 'breadcrumb', 'url', 'activities', 'date'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	if (! Gate::allows('member_activities_view')) {
            return abort(401);
        }
        $title = 'Member Activity Details';
        $url = 'member-activity/'.$id;
        $breadcrumb = [
            [
                'name'=>'Member Activities',
                'url'=>'member-activity'
            ],
            [
                'name'=>$title
            ]
        ];
    	$activity = member_activity::find($id);

    	return view('activity.view', compact('title', 'breadcrumb', 'url', 'activity'));
    }
}