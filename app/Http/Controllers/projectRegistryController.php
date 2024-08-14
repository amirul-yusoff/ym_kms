<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Helpers\saveActivityHelper;
use App\Http\Controllers\Helpers\dbCheckerHelper;
Use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Models\module;
use App\Http\Models\purchase_order_db_one;
use App\Http\Models\purchase_order_detail_db_one;
use App\Http\Models\project_registry; 
use App\Http\Models\paymentcertificate_db_one; 
use App\Http\Models\subcon_invoice;
use App\Http\Models\supplier_invoice_has_po;
use App\Http\Models\supplier_invoice_has_action;
use App\Http\Models\supplier_invoice_has_document;
use App\Http\Models\subcon_invoice_has_action;
use App\Http\Models\workorder_db_one;
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


class projectRegistryController  extends Controller
{

    public function __construct(saveActivityHelper $activityHelper, Request $request,dbCheckerHelper $dbCheckerHelper)
    {
        $this->request = $request;
        $this->activityHelper = $activityHelper;
        $this->dbCheckerHelper = $dbCheckerHelper;
        $this->user = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $title = 'Project Registry';
        $breadcrumb = [
            [
                'name' => $title,
                'url' => 'project_registry'
            ],
        ];

        $data = project_registry::with('getWO');

        $dropDownProjectCode = project_registry::groupBy('Project_Code')->pluck('Project_Code');
        $selectedProjectCode = $request->Project_Code;

        $dropDownProjectType = project_registry::groupBy('project_type')->pluck('project_type');
        $selectedProjectType = $request->project_type;
        
        $dropDownProjectTeam = project_registry::groupBy('project_team')->pluck('project_team');
        $selectedProjectTeam = $request->project_team;
        
        $dropDownProjectStatus = project_registry::groupBy('Project_Status')->pluck('Project_Status');
        $selectedProjectStatus = $request->Project_Status;

        if($request->filled('Project_ID')) {
            $data->where('Project_ID', 'like', '%' . $request->Project_ID . '%'); 
        }
        if($request->filled('Project_Code')) {
            $data->where('Project_Code', 'like', '%' .  $selectedProjectCode . '%'); 
        }
        if($request->filled('Project_Short_name')) {
            $data->where('Project_Short_name', 'like', '%' .  $request->Project_Short_name . '%'); 
        }
        if($request->filled('Project_Title')) {
            $data->where('Project_Title', 'like', '%' . $request->Project_Title . '%'); 
        }
        if($request->filled('Project_Contract_No')) {
            $data->where('Project_Contract_No', 'like', '%' . $request->Project_Contract_No . '%'); 
        }
        if($request->filled('project_type')) {
            $data->where('project_type', 'like', '%' .  $selectedProjectType . '%'); 
        }
        if($request->filled('project_team')) {
            $data->where('project_team', 'like', '%' . $selectedProjectTeam . '%'); 
        }
        if($request->filled('Project_Status')) {
            $data->where('Project_Status', 'like', '%' . $selectedProjectStatus . '%'); 
        }

        $data = $data->get();       
        return view('project_registry.index', compact('data','title', 'breadcrumb', 'dropDownProjectCode', 'selectedProjectCode', 'dropDownProjectType', 'selectedProjectType', 'dropDownProjectTeam', 'selectedProjectTeam', 'dropDownProjectStatus', 'selectedProjectStatus'));
    }

    public function displayWorkorder(Request $request,$project_code)
    {
        $input = $request->all();
        $title = 'Work Order';
        $breadcrumb = [
            [
                'name' => 'Project Registry',
                'url' => 'project_registry'
            ],
            [
                'name' => $title,
                'url' => 'project_registry'
            ],
        ];
        $data = workorder_db_one::with('paymentcert')->where('ProjectCode',$project_code);

        $dropDownWorkOrderNumber = workorder_db_one::where('ProjectCode',$project_code)->groupBy('WorkOrderNumber')->pluck('WorkOrderNumber');
        $selectedWorkOrderNumber = $request->WorkOrderNumber;

        $dropDownStatus = workorder_db_one::where('ProjectCode',$project_code)->groupBy('Status')->pluck('Status');
        $selectedStatus = $request->Status;
        
        $dropDownVendor = workorder_db_one::where('ProjectCode',$project_code)->groupBy('Vendor')->pluck('Vendor');
        $selectedVendor = $request->Vendor;

        if($request->filled('WorkOrderNumber')) {
            $data->where('WorkOrderNumber', 'like', '%' . $selectedWorkOrderNumber . '%'); 
        }
        if($request->filled('Status')) {
            $data->where('Status', 'like', '%' .  $selectedStatus . '%'); 
        }
        if($request->filled('Vendor')) {
            $data->where('Vendor', 'like', '%' .  $selectedVendor . '%'); 
        }
        if($request->filled('DescriptionofWork')) {
            $data->where('DescriptionofWork', 'like', '%' . $request->DescriptionofWork . '%'); 
        }
        $data = $data->get();
        return view('work_order.index', compact('data', 'project_code', 'title', 'breadcrumb', 'dropDownWorkOrderNumber', 'selectedWorkOrderNumber', 'dropDownStatus', 'selectedStatus', 'dropDownVendor', 'selectedVendor'));
    }

    public function displayPO(Request $request,$project_code)
    {
        $input = $request->all();
        
        $title = 'Purchase Order';
        $breadcrumb = [
            [
                'name' => 'Project Registry',
                'url' => 'project_registry'
            ],
            [
                'name' => $title,
                'url' => 'project_registry'
            ],
        ];
        $data = purchase_order_detail_db_one::where('project_code',$project_code);
        
        $dropDownItem = purchase_order_detail_db_one::where('project_code',$project_code)->groupBy('item')->pluck('item');
        $selectedItem = $request->item;

        $dropDownStatus = purchase_order_detail_db_one::where('project_code',$project_code)->groupBy('status')->pluck('status');
        $selectedStatus = $request->status;
        
        $dropDownSupplier = purchase_order_detail_db_one::where('project_code',$project_code)->groupBy('supplier')->pluck('supplier');
        $selectedSupplier = $request->supplier;

        if($request->filled('item')) {
            $data->where('item', 'like', '%' . $selectedItem . '%'); 
        }
        if($request->filled('description')) {
            $data->where('description', 'like', '%' . $request->description . '%'); 
        }
        if($request->filled('status')) {
            $data->where('status', 'like', '%' .  $selectedStatus . '%'); 
        }
        if($request->filled('supplier')) {
            $data->where('supplier', 'like', '%' .  $selectedSupplier . '%'); 
        }
        $data = $data->get();

        return view('purchase_order.index', compact('project_code', 'data','title', 'breadcrumb','dropDownItem', 'selectedItem', 'dropDownStatus', 'selectedStatus', 'dropDownSupplier', 'selectedSupplier'));
    }

    public function displayPaymentCert(Request $request,$project_code,$woId)
    {
        $input = $request->all();
        $title = 'Payment Cert';
        $breadcrumb = [
            [
                'name' => 'Project Registry',
                'url' => 'project_registry'
            ],
            [
                'name' => 'Work Order',
                'url' => 'project_registry/'.$project_code.'/workorder'
            ],
            [
                'name' => $title,
                'url' => 'project_registry'
            ],
        ];

        $selectedStartDate = $request->start_date ?: Carbon::now()->startOfYear()->toDateString();
        $selectedEndDate = $request->end_date ?: Carbon::now()->endOfMonth()->toDateString();

        $data = paymentcertificate_db_one::whereBetween('PayCertDate', [$selectedStartDate, $selectedEndDate])->where('WorkOrderNo','LIKE','%/'.$woId.'/%');

        $dropDownWorkOrderNo = paymentcertificate_db_one::where('WorkOrderNo','LIKE','%/'.$woId.'/%')->groupBy('WorkOrderNo')->pluck('WorkOrderNo');
        $selectedWorkOrderNo = $request->WorkOrderNo;

        $dropDownVendor = paymentcertificate_db_one::where('WorkOrderNo','LIKE','%/'.$woId.'/%')->groupBy('Vendor')->pluck('Vendor');
        $selectedVendor = $request->Vendor;

        $dropDownInvoiceNo = paymentcertificate_db_one::where('WorkOrderNo','LIKE','%/'.$woId.'/%')->groupBy('InvoiceNo')->pluck('InvoiceNo');
        $selectedInvoiceNo = $request->InvoiceNo;

        if($request->filled('WorkOrderNo')) {
            $data->where('WorkOrderNo', 'like', '%' .  $selectedWorkOrderNo . '%'); 
        }
        if($request->filled('Vendor')) {
            $data->where('Vendor', 'like', '%' . $selectedVendor . '%'); 
        }        
        if($request->filled('PaymentNo')) {
            $data->where('PaymentNo', 'like', '%' .  $request->PaymentNo . '%'); 
        }
        if($request->filled('InvoiceNo')) {
            $data->where('InvoiceNo', 'like', '%' . $selectedInvoiceNo . '%'); 
        }
        $data = $data->get();
        
        return view('payment_cert.index', compact('project_code', 'woId', 'data','title', 'breadcrumb', 'selectedStartDate', 'selectedEndDate', 'dropDownWorkOrderNo', 'selectedWorkOrderNo', 'dropDownVendor', 'selectedVendor', 'dropDownInvoiceNo', 'selectedInvoiceNo'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    public function edit(Request $request,$id)
    {
    }

    public function editStage3(Request $request,$id)
    {
    }

    public function updateStage3(Request $request,$id)
    {
    }
    public function update(Request $request,$id)
    {
    }

    
}
