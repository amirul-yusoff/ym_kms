<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Helpers\saveActivityHelper;
use App\Http\Controllers\Helpers\dbCheckerHelper;
Use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Models\module;
use App\Http\Models\purchase_order_db_one;
use App\Http\Models\project_registry ;
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


class workorderController  extends Controller
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
        dd("index");
    }

    public function indexByProject(Request $request)
    {
        $title = 'Project Registry';
        $breadcrumb = [
            [
                'name' => $title,
                'url' => 'project_registry'
            ],
        ];
        $data = project_registry::all();
       
        return view('project_registry.index', compact('data','title', 'breadcrumb'));
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
