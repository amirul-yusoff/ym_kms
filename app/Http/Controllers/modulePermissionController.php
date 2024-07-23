<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Helpers\saveActivityHelper;
use Illuminate\Http\Request;
use App\Http\Models\module;
use App\Http\Models\ticket;
use App\Http\Models\ticket_log;
use App\Http\Models\workorder;
use App\Http\Models\project_registry;
use App\Http\Models\workorder_has_budget_code;
use App\Http\Models\project_workorder_has_update_projectcost;
use App\Http\Models\purchase_order_detail;
use App\Http\Models\project_workorder_has_update_materialcost;
use App\Http\Models\role_has_permissions;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Models\module_permission;
use App\Http\Models\Member;
use Illuminate\Support\Facades\Gate;
use Datatables;
use DB;
use PDF;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Input;
use Carbon\Carbon;
use App\Http\Requests;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Str;

use Twilio\Rest\Client;
use GuzzleHttp\Client as GuzzleClient;


class modulePermissionController extends Controller
{

    public function __construct(saveActivityHelper $activityHelper, Request $request)
    {
        $this->request = $request;
        $this->activityHelper = $activityHelper;
        $this->user = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $title = 'Module Permission';
        $breadcrumb = [
            [
                'name' => $title,
                'url' => 'module-permission'
            ],
        ];
        $data = module::with('getToViewPermission.getToViewPermission','parent')->get();

        return view('module-permission.index', compact('data','title', 'breadcrumb'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $title = 'Create Module Permission';
        $breadcrumb = [
            [
                'name'=>'Module Permission',
                'url'=>'module-permission'
            ],
            [
                'name'=>$title,
                'url'=>'module-permission'
            ],
        ];

        $user = Auth::user();
        $userCode = $user["employee_code"];
        $currentDateTime = Carbon::now()->toDateString();
        
        $data = module::with('parent')->where('parent_id',0)->get();
        $permissions = Permission::get();
        
        return view('module-permission.create',compact('data','permissions','user','title','breadcrumb','userCode','currentDateTime','user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $this->request->all();
        $mesasge = '';
        $currentDateTime = Carbon::now()->toDateString();
        $user = Auth::user();
        $this->validate($request, [
            'permissions'=>'required',
            'module_name'=>'required',
        ]);
        
        if ($input['parent_id'] == NULL) {
            $createModule['parent_id'] = 0;
        }else{
            $createModule['parent_id'] = $input['parent_id'];
        }
        $createModule['module_type'] = 'Web';
        $createModule['module_name'] = $input['module_name'];
        $createModule['description'] = $input['description'];
        $createModule['platform'] = 'web';
        $createModule['status'] = 'on';
        $createModule['url'] = $input['url'];
        $createModule['icon'] = $input['icon'];
        $createModule['created_at'] = Carbon::now();
        $createModule['created_at'] = $user->id;

        ///start
        $roles = Role::where('name','superadmin')->first();
        if ($roles != NULL) {
            $checkroles = role_has_permissions::where('permission_id',$input['permissions'])
            ->where('role_id',$roles->id)
            ->first();
            if ($checkroles == NULL) {
                $updatePermission['permission_id'] = $input['permissions'];
                $updatePermission['role_id'] = $roles->id;
                $permissionUpdate = role_has_permissions::create($updatePermission);
                $mesasge .= ' Role Created adn Assign the persmission to superadmin ,';
            }
        }
        ///end

        $mesasge .= ' Module '. $input['module_name'].' Created,';
        $module = module::create($createModule);

        if ($input['permissions'] != NULL) {
            $createPermission['module_id'] = $module->id;
            $createPermission['permission_id'] = $input['permissions'];
            $createPermission['created_at'] = Carbon::now();
            $createPermission['created_at'] = $user->id;
            $createPermission = module_permission::create($createPermission);
            $mesasge .= ' Module Pemission Created,';
        }

        return redirect()
        ->action(
            'modulePermissionController@index',
        )
        ->with('success', 'Module created! ('.$mesasge.')');
    }

    public function edit(Request $request,$id)
    {
        $input = $this->request->all();
        
        $data = request_manpower::with('getRMFNamelist','getRMFJobScope')->find($id);
        // dd($data);
        $user = Auth::user();
        $title = 'Edit RMF';
        $breadcrumb = [
            [
                'name'=>'Request Manpower',
                'url'=>'request-manpower'
            ],
            [
                'name'=>$title,
                'url'=>'request-manpower'
            ],
        ];
        $currentDateTime = Carbon::now()->toDateString();
        $member = Member::where('isdelete',0)->get();
        $projectCode = project_registry::where('Project_Status','!=','Cancelled')
        ->where('Project_Status','!=','Closed')
        ->orwhere('Project_Status','New')
        ->orwhere('Project_Status','Work In Progress')
        ->orwhere('Project_Status','Completed')
        ->get();

        return view('request-manpower.edit',compact('projectCode','member','data','user','title','breadcrumb','currentDateTime'));
    }

    public function update(Request $request,$id)
    {
        $input = $this->request->all();
        
        $currentDateTime = Carbon::now()->toDateString();
        $user = Auth::user();
        $projectCode = project_registry::where('Project_ID',$input['project_code'])->first();
        $nameSBU = Member::where('id',$input['name_sbu_se'])->first();
        $createRMF['date'] = $input['date'];
        $createRMF['updated_by'] = $user->id;
        $createRMF['project_id'] = $input['project_code'];
        $createRMF['project_code'] = $projectCode->Project_Code;
        $createRMF['name_sbu_se'] = $nameSBU->employee_name;
        $createRMF['name_sbu_se_id'] = $input['name_sbu_se'];
        $createRMF['rmd_no'] = $input['rmd_no'];
        $createRMF['team'] = $input['team'];
        $createRMF['start_date'] = $input['start_date'];
        $createRMF['end_date'] = $input['end_date'];
        $createRMF['total_days_day_time'] = $input['total_days_day_time'];
        $createRMF['total_days_night_time'] = $input['total_days_night_time'];
        $createRMF['updated_at'] = Carbon::now();

        $rmf = request_manpower::where('id',$id)->update($createRMF);

        $deleteNameList = request_manpower_name_list::where('rmf_id',$id)->delete();
        // dd($input['nameList']);
        foreach ($input['nameList'] as $index => $nameList){
            $nameWorker = Member::where('id',$nameList['worker_name'])->first();
            $createNameList = [];
            $createNameList['rmf_id'] = $id;
            $createNameList['project_code'] = $projectCode->Project_Code;
            $createNameList['rmd_no'] = $input['rmd_no'];
            $createNameList['worker_name'] = $nameWorker->employee_name;
            $createNameList['worker_id'] = $nameWorker->id;
            $createNameList['worker_nameworker_nameworker_name'] = $nameList['worker_name'];
            $createNameList['rate'] = $nameList['rate'];
            $createNameList['qty'] = $nameList['qty'];
            $createNameList['total_amount'] = $nameList['total_amount'];
            $createNameList['created_at'] = Carbon::now();
            $createNameList['created_by'] = $user->employee_code;

            $rmf_name_list = request_manpower_name_list::create($createNameList);
        }
        $deleteNameList = request_manpower_job_scope::where('rmf_id',$id)->delete();

        foreach ($input['jobScopeList'] as $index => $jobScopeList){
            $createJobScopeList = [];
            $createJobScopeList['rmf_id'] = $id;
            $createJobScopeList['project_code'] = $projectCode->Project_Code;
            $createJobScopeList['rmd_no'] = $input['rmd_no'];
            $createJobScopeList['job_scope'] = $jobScopeList['job_scope'];
            $createJobScopeList['span'] = $jobScopeList['span'];
            $createJobScopeList['qty'] = $jobScopeList['quantity'];
            $createJobScopeList['unit'] = $jobScopeList['unit'];
            $createJobScopeList['start_date'] = $jobScopeList['start_date'];
            $createJobScopeList['end_date'] = $jobScopeList['end_date'];
            $createJobScopeList['duration'] = $jobScopeList['duration'];
            $createJobScopeList['created_at'] = Carbon::now();
            $createJobScopeList['created_by'] = $user->employee_code;

            $rmf_job_scope = request_manpower_job_scope::create($createJobScopeList);
        }

        
        return redirect()
        ->action(
            'requestManpowerController@index',
        )
        ->with('success', 'RMF Updated!');
    }

    public function show(Request $request,$id)
    {
        $input = $this->request->all();
        
        $data = ticket::with('findRequester','findAssignedTo')->find($id);
        $user = Auth::user();
        $title = 'View Ticket';
        $breadcrumb = [
            [
                'name'=>'Ticketing System',
                'url'=>'ticketing-system'
            ],
            [
                'name'=>$title,
                'url'=>'ticketing-system'
            ],
        ];
        $currentDateTime = Carbon::now()->toDateString();
        $category = [
            'Web KMS'=>'Web KMS',
            'Database'=>'Database',
            'Email Managemnt'=>'Email Managemnt',
            'Office 365'=>'Office 365',
            'Server'=>'Server',
            'PowerComputer'=>'PowerComputer',
            'PnC Server'=>'PnC Server',
            'Domain'=>'Domain',
            'Documentation'=>'Documentation',
            'FAQ'=>'FAQ',
            'Request Quotation'=>'Request Quotation',
            'Laptop and Accessories'=>'Laptop and Accessories',
        ];
        $member = Member::where('isdelete',0)->get();
        $statusSelection = [
            'New'=>'New',
            'Processing'=>'Processing',
            'Completed'=>'Completed',
        ];

        return view('ticketing-system.display',compact('data','user','title','breadcrumb','currentDateTime','category','member','statusSelection'));
    }

    public function addCategory(Request $request)
    {
        $input = $request->all();
        $user = Auth::user()->employee_code;

        $addCategory['category'] = $input['category'];
        $addCategory['created_by'] = $user;
        $addCategory['created_at'] = Carbon::now();
        $createData = ticketing_system_category::create($addCategory);

        return redirect()->action('ticketingSystemController@index')->with('success', 'New Category has been Created!!');
    }
    
}
