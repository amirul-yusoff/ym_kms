<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Helpers\saveActivityHelper;
use App\Http\Controllers\Helpers\dbCheckerHelper;
Use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Models\module;
use App\Http\Models\subcon_invoice;
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


class invoiceController  extends Controller
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
        $title = 'Invoice Module';
        $breadcrumb = [
            [
                'name' => $title,
                'url' => 'my-invoice'
            ],
        ];
        $data = subcon_invoice::with('getFiles')
        ->where('company_id',Auth::user()->company_id)
        ->get();
        
        return view('invoice.index', compact('data','title', 'breadcrumb'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $title = 'Invoice Module';
        $action = 'Create';
        $breadcrumb = [
            [
                'name' => $title,
                'url' => 'my-invoice'
            ],
            [
                'name' => $action.' '.$title,
                'url' => 'my-invoice'
            ],
        ];
        $woData = workorder_db_one::where('Status','=','Active')
        ->where('company_id',Auth::user()->company_id)
        ->get();
        $now = Carbon::now();
        
        return view('invoice.create',compact('user','title','breadcrumb','woData','now'));
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
        $woData = workorder_db_one::find($input['wo_number']);

        $input['wo_number'] = $woData->WorkOrderNumber;
        $input['wo_id'] = $woData->ID;
        $input['status'] = 'Pending Admin To take Action';
        $input['created_by'] = Auth::user()->id;
        $input['stage'] = 1;
        $input['company_id'] = Auth::user()->company_id;

        $store = subcon_invoice::create($input);

        $files = $request->file('files');
        if ($files) {
            $id = $store->id;
            // Use Illuminate\Support\Facades\Http;
            // /Photo/project/kms
            // /Photo/project/kms
            foreach ($files as $key => $file) {
                $timenow = Carbon::now();
                // Generate a unique name for the file
                $fileName = date("Y-m-d-H-i-s") . "_" . $file->getClientOriginalName();
                $hashname = md5($file->getClientOriginalName() . $timenow . rand());
                $ids = [
                    'original_id' => $id,
                    'original_filename' => $fileName,
                    'original_hash' => $hashname,
                    'original_extension' => $file->getClientOriginalExtension(),
                    'original_mimetype' => $file->getMimeType(),
                    'original_size' => $file->getSize(),
                    'original_upload_by' => Auth::user()->employee_code,
                    'original_carbon_now_data' => Carbon::now(),
                    'original_document_type' => ' ',
                    'original_db_table' => 'subcon_invoice_has_document',
                    'original_folder_name' => 'subcon_invoice_id',
                    'original_id_file_name' => 'subcon_invoice_id',
                ];
                

                $isProduction = $this->dbCheckerHelper->dbProductionChecker();
                if ($isProduction) {
                    $urls = [
                        'url1' => 'http://powercomputer.ds.jatitinggi.com/jati/webservice/public-v1.1.0/uploadFileFromSubconKMS.php', //internal
                        'url2' => 'https://smsapp.jatitinggi.com:30443/jati/webservice/public-v1.1.0/uploadFileFromSubconKMS.php',    //external
                    ];
                } else {
                    $urls = [
                        'url1' => 'http://powercomputer.ds.jatitinggi.com/jati/webservice/public-v1.1.0/uploadFileFromSubconKMS_test.php', //internal
                        'url2' => 'https://smsapp.jatitinggi.com:30443/jati/webservice/public-v1.1.0/uploadFileFromSubconKMS_test.php',    //external
                    ];
                }

                $response = null;
                
                try {
                    foreach ($urls as $url) {
                        // Send the POST request with the file attached as multipart form data
                        $response = Http::attach(
                            'file',                   // Form field name for the file
                            file_get_contents($file->path()),    // File content
                            $file->getClientOriginalName()       // File name
                        )
                        ->attach('original_id', $ids['original_id'])
                        ->attach('original_filename', $ids['original_filename'])
                        ->attach('original_hash', $ids['original_hash'])
                        ->attach('original_extension', $ids['original_extension'])
                        ->attach('original_mimetype', $ids['original_mimetype'])
                        ->attach('original_size', $ids['original_size'])
                        ->attach('original_upload_by', $ids['original_upload_by'])
                        ->attach('original_carbon_now_data', $ids['original_carbon_now_data'])
                        ->attach('original_document_type', $ids['original_document_type'])
                        ->attach('original_db_table', $ids['original_db_table'])
                        ->attach('original_folder_name', $ids['original_folder_name'])
                        ->attach('original_id_file_name', $ids['original_id_file_name'])
                        ->post($url);
                        
                        // Check if the response was successful
                        if ($response->successful()) {
                            // Successfully connected to the URL, break the loop
                            break;
                        }
                    }
        
                    
                } catch (\Exception $e) {
                    // Handle any exceptions that may occur during the upload
                    dd($e->getMessage());
                }

                // Check if both URLs failed to connect
                if ($response->failed()) {
                    // Handle the error appropriately (log, display to the user, etc.)
                    dd("Failed to connect to Server");
                    // For example: return response()->json(['error' => 'Failed to connect to both URLs'], 500);
                }
            }
        }

        return redirect()
        ->action(
            'invoiceController@index',
        )
        ->with('success', 'Invoice submited!');
    }

    public function edit(Request $request,$id)
    {
        $input = $this->request->all();
        $data = subcon_invoice::with('getFiles','findCreatedBy')->find($id);

        if($data->company_id != Auth::user()->company_id){
            dd("Please, You are not allowed to update this Invoice");
        }

        $user = Auth::user();
        $title = 'Invoice Module';
        $action = 'Edit';
        $breadcrumb = [
            [
                'name' => $title,
                'url' => 'my-invoice'
            ],
            [
                'name' => $action.' '.$title,
                'url' => 'my-invoice'
            ],
        ];
        $woData = workorder_db_one::where('Status','=','Active')
        ->where('company_id',Auth::user()->company_id)
        ->get();
        $now = Carbon::now();
        
        return view('invoice.edit',compact('user','title','breadcrumb','woData','now','data'));
    }

    public function editStage3(Request $request,$id)
    {
        $input = $this->request->all();
        $data = subcon_invoice::with('getFiles','findCreatedBy')->find($id);

        if($data->company_id != Auth::user()->company_id){
            dd("Please, You are not allowed to update this Invoice");
        }

        $user = Auth::user();
        $title = 'Invoice Module';
        $action = 'Edit';
        $breadcrumb = [
            [
                'name' => $title,
                'url' => 'my-invoice'
            ],
            [
                'name' => $action.' '.$title,
                'url' => 'my-invoice'
            ],
        ];
        $woData = workorder_db_one::where('Status','=','Active')
        ->where('company_id',Auth::user()->company_id)
        ->get();
        $now = Carbon::now();
        
        return view('invoice.edit_stage_three',compact('user','title','breadcrumb','woData','now','data'));
    }

    public function updateStage3(Request $request,$id)
    {
        $input = $this->request->all();

        $updateStage3['invoice_number'] = $input['invoice_number'];
        $updateStage3['invoice_amount'] = $input['invoice_amount'];

        $data = subcon_invoice::with('findCreatedBy')->find($id);
        if($data->company_id != Auth::user()->company_id){
            dd("Please, You are not allowed to update this Invoice");
        }
        $data->update($updateStage3);

        $files = $request->file('files');
        if ($files) {
            $id = $id;
            // Use Illuminate\Support\Facades\Http;
            // /Photo/project/kms
            // /Photo/project/kms
            foreach ($files as $key => $file) {
                $timenow = Carbon::now();
                // Generate a unique name for the file
                $fileName = date("Y-m-d-H-i-s") . "_" . $file->getClientOriginalName();
                $hashname = md5($file->getClientOriginalName() . $timenow . rand());
                $ids = [
                    'original_id' => $id,
                    'original_filename' => $fileName,
                    'original_hash' => $hashname,
                    'original_extension' => $file->getClientOriginalExtension(),
                    'original_mimetype' => $file->getMimeType(),
                    'original_size' => $file->getSize(),
                    'original_upload_by' => Auth::user()->employee_code,
                    'original_carbon_now_data' => Carbon::now(),
                    'original_document_type' => ' ',
                    'original_db_table' => 'subcon_invoice_has_document',
                    'original_folder_name' => 'subcon_invoice_id',
                    'original_id_file_name' => 'subcon_invoice_id',
                ];
                

                $isProduction = $this->dbCheckerHelper->dbProductionChecker();
                if ($isProduction) {
                    $urls = [
                        'url1' => 'http://powercomputer.ds.jatitinggi.com/jati/webservice/public-v1.1.0/uploadFileFromSubconKMS.php', //internal
                        'url2' => 'https://smsapp.jatitinggi.com:30443/jati/webservice/public-v1.1.0/uploadFileFromSubconKMS.php',    //external
                    ];
                } else {
                    $urls = [
                        'url1' => 'http://powercomputer.ds.jatitinggi.com/jati/webservice/public-v1.1.0/uploadFileFromSubconKMS_test.php', //internal
                        'url2' => 'https://smsapp.jatitinggi.com:30443/jati/webservice/public-v1.1.0/uploadFileFromSubconKMS_test.php',    //external
                    ];
                }

                $response = null;
                
                try {
                    foreach ($urls as $url) {
                        // Send the POST request with the file attached as multipart form data
                        $response = Http::attach(
                            'file',                   // Form field name for the file
                            file_get_contents($file->path()),    // File content
                            $file->getClientOriginalName()       // File name
                        )
                        ->attach('original_id', $ids['original_id'])
                        ->attach('original_filename', $ids['original_filename'])
                        ->attach('original_hash', $ids['original_hash'])
                        ->attach('original_extension', $ids['original_extension'])
                        ->attach('original_mimetype', $ids['original_mimetype'])
                        ->attach('original_size', $ids['original_size'])
                        ->attach('original_upload_by', $ids['original_upload_by'])
                        ->attach('original_carbon_now_data', $ids['original_carbon_now_data'])
                        ->attach('original_document_type', $ids['original_document_type'])
                        ->attach('original_db_table', $ids['original_db_table'])
                        ->attach('original_folder_name', $ids['original_folder_name'])
                        ->attach('original_id_file_name', $ids['original_id_file_name'])
                        ->post($url);
                        
                        // Check if the response was successful
                        if ($response->successful()) {
                            // Successfully connected to the URL, break the loop
                            break;
                        }
                    }
        
                    
                } catch (\Exception $e) {
                    // Handle any exceptions that may occur during the upload
                    dd($e->getMessage());
                }

                // Check if both URLs failed to connect
                if ($response->failed()) {
                    // Handle the error appropriately (log, display to the user, etc.)
                    dd("Failed to connect to Server");
                    // For example: return response()->json(['error' => 'Failed to connect to both URLs'], 500);
                }
            }
        }

        return redirect()
        ->action(
            'invoiceController@index',
        )
        ->with('success', 'Invoice updated!');
    }
    public function update(Request $request,$id)
    {
        $input = $this->request->all();
        
        $woData = workorder_db_one::find($input['wo_number']);

        $input['wo_number'] = $woData->WorkOrderNumber;
        $input['wo_id'] = $woData->ID;
        $input['status'] = 'Pending Admin To take Action';
        $input['created_by'] = Auth::user()->id;
        $input['stage'] = 1;
        $input['company_id'] = Auth::user()->company_id;

        $data = subcon_invoice::with('findCreatedBy')->find($id);
        if($data->company_id != Auth::user()->company_id){
            dd("Please, You are not allowed to update this Invoice");
        }
        $data->update($input);

        $files = $request->file('files');
        if ($files) {
            $id = $id;
            // Use Illuminate\Support\Facades\Http;
            // /Photo/project/kms
            // /Photo/project/kms
            foreach ($files as $key => $file) {
                $timenow = Carbon::now();
                // Generate a unique name for the file
                $fileName = date("Y-m-d-H-i-s") . "_" . $file->getClientOriginalName();
                $hashname = md5($file->getClientOriginalName() . $timenow . rand());
                $ids = [
                    'original_id' => $id,
                    'original_filename' => $fileName,
                    'original_hash' => $hashname,
                    'original_extension' => $file->getClientOriginalExtension(),
                    'original_mimetype' => $file->getMimeType(),
                    'original_size' => $file->getSize(),
                    'original_upload_by' => Auth::user()->employee_code,
                    'original_carbon_now_data' => Carbon::now(),
                    'original_document_type' => ' ',
                    'original_db_table' => 'subcon_invoice_has_document',
                    'original_folder_name' => 'subcon_invoice_id',
                    'original_id_file_name' => 'subcon_invoice_id',
                ];
                

                $isProduction = $this->dbCheckerHelper->dbProductionChecker();
                if ($isProduction) {
                    $urls = [
                        'url1' => 'http://powercomputer.ds.jatitinggi.com/jati/webservice/public-v1.1.0/uploadFileFromSubconKMS.php', //internal
                        'url2' => 'https://smsapp.jatitinggi.com:30443/jati/webservice/public-v1.1.0/uploadFileFromSubconKMS.php',    //external
                    ];
                } else {
                    $urls = [
                        'url1' => 'http://powercomputer.ds.jatitinggi.com/jati/webservice/public-v1.1.0/uploadFileFromSubconKMS_test.php', //internal
                        'url2' => 'https://smsapp.jatitinggi.com:30443/jati/webservice/public-v1.1.0/uploadFileFromSubconKMS_test.php',    //external
                    ];
                }

                $response = null;
                
                try {
                    foreach ($urls as $url) {
                        // Send the POST request with the file attached as multipart form data
                        $response = Http::attach(
                            'file',                   // Form field name for the file
                            file_get_contents($file->path()),    // File content
                            $file->getClientOriginalName()       // File name
                        )
                        ->attach('original_id', $ids['original_id'])
                        ->attach('original_filename', $ids['original_filename'])
                        ->attach('original_hash', $ids['original_hash'])
                        ->attach('original_extension', $ids['original_extension'])
                        ->attach('original_mimetype', $ids['original_mimetype'])
                        ->attach('original_size', $ids['original_size'])
                        ->attach('original_upload_by', $ids['original_upload_by'])
                        ->attach('original_carbon_now_data', $ids['original_carbon_now_data'])
                        ->attach('original_document_type', $ids['original_document_type'])
                        ->attach('original_db_table', $ids['original_db_table'])
                        ->attach('original_folder_name', $ids['original_folder_name'])
                        ->attach('original_id_file_name', $ids['original_id_file_name'])
                        ->post($url);
                        
                        // Check if the response was successful
                        if ($response->successful()) {
                            // Successfully connected to the URL, break the loop
                            break;
                        }
                    }
        
                    
                } catch (\Exception $e) {
                    // Handle any exceptions that may occur during the upload
                    dd($e->getMessage());
                }

                // Check if both URLs failed to connect
                if ($response->failed()) {
                    // Handle the error appropriately (log, display to the user, etc.)
                    dd("Failed to connect to Server");
                    // For example: return response()->json(['error' => 'Failed to connect to both URLs'], 500);
                }
            }
        }

        return redirect()
        ->action(
            'invoiceController@index',
        )
        ->with('success', 'Invoice updated!');
    }

    public function verifyAndSubmit(Request $request,$id)
    {
        $stage = 2; //submit and verify
        $input = $request->all();
        $data = subcon_invoice::with('findCreatedBy')->find($id);

        $hasAction['subcon_invoice_id'] = $id;
        $hasAction['take_action_by_subconkms_member_id'] = Auth::user()->id;
        $hasAction['take_action_by_subconkms_member_name'] = Auth::user()->employee_name;
        $hasAction['action'] = 'Submit and Verify Invoice';
        $hasAction['created_at'] = Carbon::now();
        $hasAction['stage_from'] = $data->stage;
        $hasAction['stage_to'] = $stage;
        $store = subcon_invoice_has_action::create($hasAction);

        $changeSubmit['stage'] = $stage;
        $changeSubmit['status'] = 'In Review';
        $data->update($changeSubmit);

        return redirect()
        ->action(
            'invoiceController@index',
        )
        ->with('success', 'Invoice submited To be review!');
    }

    public function verifyAndSubmitS3(Request $request,$id)
    {
        $stage = 4; //submit and verify
        $input = $request->all();
        $data = subcon_invoice::with('findCreatedBy')->find($id);

        $hasAction['subcon_invoice_id'] = $id;
        $hasAction['take_action_by_subconkms_member_id'] = Auth::user()->id;
        $hasAction['take_action_by_subconkms_member_name'] = Auth::user()->employee_name;
        $hasAction['action'] = 'Submit and Verify Invoice';
        $hasAction['created_at'] = Carbon::now();
        $hasAction['stage_from'] = $data->stage;
        $hasAction['stage_to'] = $stage;
        $store = subcon_invoice_has_action::create($hasAction);

        $changeSubmit['stage'] = $stage;
        $changeSubmit['status'] = 'In Review';
        $data->update($changeSubmit);

        return redirect()
        ->action(
            'invoiceController@index',
        )
        ->with('success', 'Invoice submited To be review!');
    }
    
    
}
