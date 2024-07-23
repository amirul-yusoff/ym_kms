<?php

namespace App\Http\Controllers;
use App\Http\Models\Member;
use App\Http\Models\member_department;
use App\Http\Models\member_position;
use App\Http\Controllers\Helpers\saveActivityHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
use Carbon\Carbon;
use App\Http\Models\company;
use Illuminate\Support\Facades\Gate;

class membersManagementController extends Controller
{
	public function __construct(saveActivityHelper $activityHelper)
    {
        $this->activityHelper = $activityHelper;
        $this->department = member_department::orderBy('department_name')->pluck('department_name', 'department_name')->all();
        $this->position = member_position::orderBy('position_name')->pluck('position_name', 'position_name')->all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        if (! Gate::allows('member_profiles_view') && ! Gate::allows('member_profiles_all')) {
            return abort(401);
        }
        $createButton = 0;
        $editButton = 0;
        $deleteButton = 0;
        if (Gate::allows('member_profiles_create') || Gate::allows('member_profiles_all')) {
            $createButton = 1;
        }
        if (Gate::allows('member_profiles_edit') || Gate::allows('member_profiles_all')) {
            $editButton = 1;
        }
        if (Gate::allows('member_profiles_delete') || Gate::allows('member_profiles_all')) {
            $deleteButton = 1;
        }
        $title = 'Members Management';
        $url = 'members-management';
        $breadcrumb = [
            [
                'name'=>$title
            ]
        ];
        $members = Member::NotDeleted()->Active()->get();
        
        return view('members.index', compact('createButton','editButton','deleteButton','title', 'breadcrumb', 'url', 'members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('member_profiles_create') && ! Gate::allows('member_profiles_all')) {
            return abort(401);
        }
        $department = $this->department;
        $position = $this->position;
        $subconList = company::activeSubcons();
        return view('members.manage', compact('department', 'position'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('member_profiles_create') && ! Gate::allows('member_profiles_all')) {
            return abort(401);
        }
    	$this->validate($request, [
    		'employee_code' => 'required|unique:members',
            'employee_name' => 'required',
            'department' => 'required',
            'position' => 'required',
            'mbr_email' => 'required|email|unique:members',
            'username' => 'required|unique:members',
            'password' => 'required|same:confirmation|min:10|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
    	]);
       
        $input = $request->all();
        $input['position'] = $input['position'];
        $input['department'] = implode(', ', $input['department']);
        $input['email'] = $input['mbr_email'];
        $input['password'] = Hash::make($input['password']);
        $input['created_by'] = Auth::user()->employee_name;
        $input['created_date'] = Carbon::now();
  
        $member = Member::create($input);
      
        return redirect('members-management/'.$member->id.'/edit')->with('success', 'Member created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('member_profiles_view') && ! Gate::allows('member_profiles_all')) {
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
        if (! Gate::allows('member_profiles_edit') && ! Gate::allows('member_profiles_all')) {
            return abort(401);
        }
        $data = Member::find($id);
        $department = $this->department;
        $position = $this->position;
        $subconList = company::activeSubcons();

        $password = '';
        $subconList = company::select('id', 'co_name')->where('categories', 'Subcontractor')->where('isdelete', 0)->orderBy('co_name', 'ASC')->pluck('co_name', 'id');

        return view('members.manage', compact('data', 'department', 'position','password', 'subconList'));
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
        if (! Gate::allows('member_profiles_edit') && ! Gate::allows('member_profiles_all')) {
            return abort(401);
        }
        $this->validate($request, [
            'employee_code' => 'required|unique:members,employee_code,'.$id,
            'employee_name' => 'required',
            'department' => 'required',
            'position' => 'required',
            'mbr_email' => 'required|email|unique:members,mbr_email,'.$id,
            'password' => 'sometimes|nullable|same:confirmation|min:10|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
    	]);

        $input = $request->all();

        $input['email'] = $input['mbr_email'];
        $input['position'] = $input['position'];
        $input['department'] = implode(', ', $input['department']);
        
        $member = Member::find($id);

        //Track changes
        $changes = [];
        foreach($member->toArray() as $key => $i) {
            if(isset($input[$key])) {
                if($input[$key] != $i && $input[$key] != '') {
                    $changes[] = $key.','.$i;
                }
            }
        }

        if(count($changes)) {
            $this->activityHelper->saveActivity('Update', 'members', $member->id, $member->employee_code, $changes);
        }

        //Update members
        $member->employee_code = $input['employee_code'];
        $member->employee_name = $input['employee_name'];
        $member->position = $input['position'];
        $member->department = $input['department'];
        $member->mbr_email = $input['mbr_email'];
        $member->username = $input['username'];
        $member->mbr_email = $input['mbr_email'];
        $member->firstname = $input['firstname'];
        $member->lastname = $input['lastname'];
        $member->nickname = $input['nickname'];
        $member->status = $input['status'];
        $member->company_id = $input['company_id'];
        if(!is_null($input['password'])){
            $member->password = Hash::make($input['password']);
        }
        $member->save();
        


       // $media = $member->image->pluck('file_name')->toArray();

       // foreach ($request->input('image', []) as $file) {
      //      if (count($media) === 0 || !in_array($file, $media)) {
   //             $member->addMedia(storage_path('app/public/upload/members/' . $file))->toMediaCollection('image');
   //         }
   //     }


        return redirect('members-management/'.$id.'/edit')->with('success', 'Member updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('member_profiles_delete') && ! Gate::allows('member_profiles_all')) {
            return abort(401);
        }
        Member::findOrFail($id)->update(['isdelete' => 1]);

        return redirect()->route('members-management.index')->with('success', 'Member deleted');
    }


    public function storeImage(Request $request)
    {
        $path = public_path('upload/members');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function deleteImage(Request $request)
    {
       
    }
}
