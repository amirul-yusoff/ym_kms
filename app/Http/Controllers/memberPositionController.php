<?php

namespace App\Http\Controllers;
use App\Http\Models\member_position;
use App\Http\Controllers\Helpers\saveActivityHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class memberPositionController extends Controller
{
	public function __construct(saveActivityHelper $activityHelper)
    {
        $this->activityHelper = $activityHelper;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    if (! Gate::allows('member_positions_view') && ! Gate::allows('member_positions_all')) {
            return abort(401);
        }
        $createButton = 0;
        $editButton = 0;
        $deleteButton = 0;
        if (Gate::allows('member_positions_create') || Gate::allows('member_positions_all')) {
            $createButton = 1;
        }
        if (Gate::allows('member_positions_edit') || Gate::allows('member_positions_all')) {
            $editButton = 1;
        }
        if (Gate::allows('member_positions_delete') || Gate::allows('member_positions_all')) {
            $deleteButton = 1;
        }
        $title = 'Member Position';
        $url = 'member-position';
        $breadcrumb = [
            [
                'name'=>$title
            ]
        ];
        $memberPositions = member_position::orderBy('position_name')->get();

        return view('member_position.index', compact('createButton','editButton','deleteButton','title', 'breadcrumb', 'url', 'memberPositions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    if (! Gate::allows('member_positions_create') && ! Gate::allows('member_positions_all')) {
            return abort(401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    if (! Gate::allows('member_positions_create') && ! Gate::allows('member_positions_all')) {
            return abort(401);
        }
    	$this->validate($request, [
        	'position_name' => 'required|unique:member_position'
        ]);

        $input = $request->all();
        $input['created_by'] = Auth::user()->employee_name;
        //Create new member
        member_position::create($input);
        $getTableID = member_position::orderBy('id', 'DESC')->first();

        //Track changes
        $changes = [];
        foreach($input as $key => $i) {
            $changes[] = $key.','.$i;
        }

        if(count($changes)) {
            $this->activityHelper->saveActivity('Create', 'member_position', $getTableID->id, $getTableID->position_name, $changes);
        }

        return redirect('member-position')->with('success', 'Member Position created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	    if (! Gate::allows('member_positions_view') && ! Gate::allows('member_positions_all')) {
            return abort(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    if (! Gate::allows('member_positions_edit') && ! Gate::allows('member_positions_all')) {
            return abort(401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
	    if (! Gate::allows('member_positions_edit') && ! Gate::allows('member_positions_all')) {
            return abort(401);
        }
    	$this->validate($request, [
        	'position_name' => 'required|unique:member_position,position_name,'.$id
        ]);

        $input = $request->all();
        $position = member_position::find($id);
        $position->update($input);

        return redirect('member-position')->with('success', 'Member Position updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    if (! Gate::allows('member_positions_delete') && ! Gate::allows('member_positions_all')) {
            return abort(401);
        }
        member_position::findOrFail($id)->delete();

        return redirect('member-position')->with('success', 'Member Position deleted');
    }
}