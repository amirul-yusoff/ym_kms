<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Member;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Models\member_department;
use App\Http\Models\member_position; 
use App\Http\Models\companies_db_one; 
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMembersRequest;
use App\Http\Requests\Admin\UpdateMembersRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Models\company;

class MemberController extends Controller
{
    /**
     * 
     * Display a listing of Member.
     *
     * @return \Illuminate\Http\Response
     */
    use UploadTrait;

    public function index()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $title = 'Member Management';
        $url = 'admin/members';
        $breadcrumb = [
            [
                'name'=>$title,
                'url'=>$url
            ],
        ];
        $members = Member::with('findCompanyID')->NotDeleted()->Active()->get();

        return view('admin.member.index', compact('title', 'breadcrumb', 'url', 'members'));
    }

    /**
     * Show the form for creating new Member.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $title = 'Member';
        $action = 'Create';
        $url = 'admin/members';
        $breadcrumb = [
            [
                'name'=>$title,
                'url'=>$url
            ],
            [
                'name'=>$action. ' ' .$title,
                'url'=>$url
            ],
        ];

        $departmentList = member_department::orderBy('department_name')->pluck('department_name', 'department_name')->all();
        $positionList = member_position::orderBy('position_name')->pluck('position_name', 'position_name')->all();
        $roleList = Role::get()->pluck('name', 'name');
        $companyList = companies_db_one::get();

        return view('admin.member.create', compact('title', 'breadcrumb', 'url', 'departmentList', 'positionList', 'roleList','companyList'));
    }

    /**
     * Store a newly created Member in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMembersRequest $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        
        $input = $request->all();
        
        // Don't understand why need to create two emails, but we'll fix it later
        $input['email'] = $input['mbr_email'];
        $input['username'] = $username = strstr($input['mbr_email'], '@', true); //"username" 
        $input['created_by'] = Auth::user()->employee_name;
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $count = Member::all();
        $countMember = count($count);
        $countMember = $countMember+1;
        $runningRumber = str_pad($countMember, 4, "0", STR_PAD_LEFT);
        $input['employee_code'] = 'SC'.$runningRumber;
        $member = Member::create($input);
        $member->assignRole($roles);
        // Need code to save image somewhere in server
        if ($request->has('image')) {
            // Get image file
            $image = $request->file('image');
            // Make a image name based on user name and current timestamp, does it overwrite?
            $name = Str::slug($request->input('mbr_email'));
            // Define folder path
            $folder = '/upload/images/members';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $member->image = $filePath;
            $member->save();
        }
        if ($input['is_active']){
            member::where('employee_code', '=', $input['employee_code'])->update(['status' => 'Active']);
        }else{
            member::where('employee_code', '=', $input['employee_code'])->update(['status' => 'Deactived']);
        }
        
        return redirect()->route('admin.members.index');
    }


    /**
     * Show the form for editing Member.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $title = 'Member';
        $action = 'Edit';
        $url = 'admin/members';
        $breadcrumb = [
            [
                'name'=>$title,
                'url'=>$url
            ],
            [
                'name'=>$action. ' ' .$title,
                'url'=>$url
            ],
        ];
        $departmentList = member_department::orderBy('department_name')->pluck('department_name', 'department_name')->all();
        $positionList = member_position::orderBy('position_name')->pluck('position_name', 'position_name')->all();
        $roleList = Role::get()->pluck('name', 'name');
        $companyList = companies_db_one::get();
        $companyName = '';
        if($member->company_id != NULL){
            $company = companies_db_one::where('id',$member->company_id)->first();
            $companyName = $company->Co_Name;
        }
        
        return view('admin.member.edit', compact('title', 'breadcrumb', 'url', 'member', 'departmentList', 'positionList', 'roleList','companyList','companyName'));
    }

    /**
     * Update Member in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMembersRequest $request, Member $member)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        
        $member->update($request->all());
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $member->syncRoles($roles);
        $input = $request->all();
        
        if ($request->has('image')) {
            // Get image file
            $image = $request->file('image');
            // Make a image name based on user name and current timestamp, does it overwrite?
            $name = Str::slug($request->input('mbr_email'));
            // Define folder path
            $folder = '/upload/images/members';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = '["'. $name. '.' . $image->getClientOriginalExtension().'"]';
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $member->image = $filePath;
            $member->save();
        }
        if ($input['is_active']){
            member::where('employee_code', '=', $input['employee_code'])->update(['status' => 'Active']);
        }else{
            member::where('employee_code', '=', $input['employee_code'])->update(['status' => 'Deactived']);
        }

        return redirect()->route('admin.members.index');
    }

    public function show(Member $member)
    {
        $title = 'Member';
        $action = 'View';
        $url = 'admin/members';
        $breadcrumb = [
            [
                'name'=>$title,
                'url'=>$url
            ],
            [
                'name'=>$action. ' ' .$title,
                'url'=>$url
            ],
        ];
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $member->load('roles');

        return view('admin.member.show', compact('title', 'breadcrumb', 'url', 'member'));
    }

    /**
     * Remove Member from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $member->delete();

        return redirect()->route('admin.members.index');
    }

    /**
     * Delete all selected Member at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        Member::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

}