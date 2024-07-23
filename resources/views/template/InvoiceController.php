<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\project_registry;
use App\Http\Models\Invoice;
use App\Http\Models\permission;
use App\Http\Controllers\Helpers\saveActivityHelper;
use Carbon\Carbon;

class InvoiceController extends Controller
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
        $title = 'Invoices';
        $url = 'client-invoices';
        $breadcrumb = [
            [
                'name'=>$title,
                'url'=>$url
            ],
        ];
        $invoices = Invoice::notPaid();
        return view('Invoice.index', compact('title', 'breadcrumb', 'url', 'invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Invoices';
        $action = 'Create';
        $url = 'client-invoices';
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
        $projects = project_registry::getWIPCompletedProjects();
        $projectLists = $projects->pluck('Project_Code','Project_ID')->all();
        $paymentTermLists = ["3" => "Back to Back", "30" => "30 days"];
        $claimNoLists = ["1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10", "11" => "11", "12" => "12", "13" => "13", "14" => "14", "15" => "15", "TOC" => "TOC", "CC" => "CC"];
        return view('Invoice.create', compact('title', 'breadcrumb', 'url', 'projectLists', 'paymentTermLists', 'permission', 'claimNoLists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'project_id' => 'required',
            'invoice_no' => 'required|unique:invoices',
            'payment_term' => 'required',
            'gross_amount' => 'required|numeric|min:0|not_in:0',
            'retention_amount' => 'required|numeric|min:0|lt:gross_amount',
            'net_amount' => 'required|numeric|min:0|lte:gross_amount',
            'claim_no' => 'required'
        ]);
        $input = $request->all();
        $input['issued_by'] = Auth::user()->id;
        $input['date'] = Carbon::now();
        
        $invoice = Invoice::create($input);
        $changes = [];
        foreach($input as $key => $i) {
            if(isset($invoice[$key])) {
                if($i != '') {
                    $changes[] = $key.','.$i;
                }
            }
        }
        if(count($changes)) {
            $this->activityHelper->saveActivity('Create', 'invoices', $invoice->id, $invoice->id, $changes);
        }
        if($request->recreate) {
            return redirect('client-invoices/create')->with('success', 'Created');
        } else {
            return redirect('client-invoices')->with('success', 'Created');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $title = 'Invoices';
        $action = 'Edit';
        $url = 'client-invoices';
        $breadcrumb = [
            [
                'name'=>$title,
                'url'=>$url
            ],
            [
                'name'=>$action.' '.$title,
                'url'=>$url
            ],
        ];
        $projects = project_registry::getWIPCompletedProjects();
        $projectLists = $projects->pluck('Project_Code','Project_ID')->all();
        $invoice = Invoice::find($id);
        $paymentTermLists = ["3" => "Back to Back", "30" => "30 days"];
        $claimNoLists = ["1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10", "11" => "11", "12" => "12", "13" => "13", "14" => "14", "15" => "15", "TOC" => "TOC", "CC" => "CC"];

        return view('Invoice.edit', compact('title', 'breadcrumb', 'url', 'projectLists', 'invoice', 'paymentTermLists', 'claimNoLists'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'project_id' => 'required',
            'invoice_no' => "required|unique:invoices,invoice_no,$request->id",
            'payment_term' => 'required',
            'gross_amount' => 'required|numeric|min:0|not_in:0',
            'retention_amount' => 'required|numeric|min:0|lt:gross_amount',
            'net_amount' => 'required|numeric|min:0|lte:gross_amount',
            'claim_no' => 'required'
        ]);
        $input = $request->all();
        $invoice = Invoice::find($request->id);
        $invoice->update($input);
        $changes = [];
        foreach($input as $key => $i) {
            if(isset($invoice[$key])) {
                if($i != '') {
                    $changes[] = $key.','.$i;
                }
            }
        }
        if(count($changes)) {
            $this->activityHelper->saveActivity('Update', 'invoices', $invoice->id, $invoice->id, $changes);
        }

        return redirect()->route('client-invoices.index')->with('success','Completed Work updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Invoice::destroy($id);
        return response()->json(['success' => 'Invoice has been deleted!']);
    }

    public function updateFields(Request $request)
    {
        $this->validate($request, [
            'invoiceID' => 'required',
            'column' => 'required',
            'value' => 'required|numeric'
        ]);
        $invoiceID = $request->invoiceID;
        $invoice = Invoice::find($invoiceID);
        if($request->column == 'gross_amount[]') {
            $invoice->gross_amount = $request->value;
            $field = 'Gross Amount';
        } elseif($request->column == 'retention_amount[]') {
            $invoice->retention_amount = $request->value;
            $field = 'Retention Amount';
        } elseif($request->column == 'net_amount[]') {
            $invoice->net_amount = $request->value;
            $field = 'Net Amount';
        } 
        $invoice->save();
        return response()->json(['success' => 'Invoice '.$field.' updated with value '.$request->value]);
    }

    public function updateInvoiceNo(Request $request)
    {
        $this->validate($request, [
            'invoiceID' => 'required',
            'value' => 'required|unique:invoices,invoice_no'
        ]);
    
        $invoiceID = $request->invoiceID;
        $invoice = Invoice::find($invoiceID);
        $invoice->invoice_no = $request->value;
        $invoice->save();
        return response()->json(['success'=>'Invoice Number is updated']);
    }

    public function updatePONo(Request $request)
    {
        $this->validate($request, [
            'invoiceID' => 'required',
            'value' => 'required'
        ]);
    
        $invoiceID = $request->invoiceID;
        $invoice = Invoice::find($invoiceID);
        $invoice->po_no = $request->value;
        $invoice->save();
        return response()->json(['success'=>'PO Number is updated']);
        
    }

    public function updateFinalClaim(Request $request)
    {
        $this->validate($request, [
            'invoiceID' => 'required',
            'apply' => 'required'
        ]);

        $invoiceID = $request->invoiceID;
        $invoice = Invoice::find($invoiceID);
        $invoice->is_final_claim = $request->apply;
        $invoice->save();
        return response()->json(['success'=>'Invoice is final claim status updated']);
    }

}
