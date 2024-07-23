<?php

namespace App\Http\Controllers;
use App\Http\Models\member_department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class memberDepartmentController extends Controller
{
	public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    if (! Gate::allows('member_departments_view') && ! Gate::allows('member_departments_all')) {
            return abort(401);
        }
        $createButton = 0;
        $editButton = 0;
        $deleteButton = 0;
        if (Gate::allows('member_departments_create') || Gate::allows('member_departments_all')) {
            $createButton = 1;
        }
        if (Gate::allows('member_departments_edit') || Gate::allows('member_departments_all')) {
            $editButton = 1;
        }
        if (Gate::allows('member_departments_delete') || Gate::allows('member_departments_all')) {
            $deleteButton = 1;
        }
        $title = 'Member Department';
        $url = 'cmember-department';
        $breadcrumb = [
            [
                'name'=>$title,
                'url'=>$url
            ],
        ];
        $memberDepartments = member_department::orderBy('department_name')->get();

        return view('member_department.index', compact('createButton','editButton','deleteButton','title', 'breadcrumb', 'url', 'memberDepartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    if (! Gate::allows('member_departments_create') && ! Gate::allows('member_departments_all')) {
            return abort(401);
        }
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    if (! Gate::allows('member_departments_create') && ! Gate::allows('member_departments_all')) {
            return abort(401);
        }
    	$this->validate($request, [
        	'department_name' => 'required|unique:member_department'
        ]);

        $input = $request->all();
        $input['created_by'] = Auth::user()->employee_name;
        member_department::create($input);

        return redirect('member-department')->with('success', 'Member Department created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	    if (! Gate::allows('member_departments_view') && ! Gate::allows('member_departments_all')) {
            return abort(401);
        }
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    if (! Gate::allows('member_departments_view') && ! Gate::allows('member_departments_all')) {
            return abort(401);
        }
        // 
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
	    if (! Gate::allows('member_departments_edit') && ! Gate::allows('member_departments_all')) {
            return abort(401);
        }
    	$this->validate($request, [
        	'department_name' => 'required|unique:member_department,department_name,'.$id
        ]);

        $input = $request->all();
        $department = member_department::find($id);
        $department->update($input);

        return redirect('member-department')->with('success', 'Member Department updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    if (! Gate::allows('member_departments_delete') && ! Gate::allows('member_departments_all')) {
            return abort(401);
        }
        member_department::findOrFail($id)->delete();

        return redirect('member-department')->with('success', 'Member Department deleted');
    }
}