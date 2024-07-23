@extends('layouts.app')

<?php
	$title = 'View Subcon Invoice';
	$breadcrumb = [
		[
			'name'=>'Subcon Invoices',
			'url'=>'subcon/invoice'
],
		[
			'name'=>'View Subcon invoice'
		]
	];
?>
@section('title', 'SubCon Invoices')

@section('content')
	@include('partials.breadcrumb')
	<div class="wrapper wrapper-content animated fadeInRight">
		@include('partials.message')
		<div class="row">
			<div class="col-sm-6">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Project : {{$creditorInvoice->ProjectCode}}</h5>
                    </div>
                    <div class="ibox-content">
						<div class="form-group row">
                            <label for="Tender_No" class="col-sm-4 control-label"> Work Order :</label>
                            <div class="col-sm-8">
								{{$creditorInvoice->WorkOrderNumber ?? 'Empty'}}
							</div>
                        </div>
                        <div class="form-group row">
                            <label for="Tender_No" class="col-sm-4 control-label"> Vendor :</label>
                            <div class="col-sm-8">
								{{$creditorInvoice->Vendor ?? 'Empty'}}
							</div>
						</div>
						<div class="form-group row">
                            <label for="Tender_No" class="col-sm-4 control-label"> Invoice Submission Date :</label>
                            <div class="col-sm-8">
								{{\Carbon\Carbon::parse($creditorInvoice->DateReceived)->format('d/m/Y') ?? 'Empty'}}
							</div>
						</div>
						<div class="form-group row">
                            <label for="Tender_No" class="col-sm-4 control-label"> Invoice Date :</label>
                            <div class="col-sm-8">
								{{\Carbon\Carbon::parse($creditorInvoice->CreditorInvoiceDate)->format('d/m/Y') ?? 'Empty'}}
							</div>
                        </div>
                        <div class="form-group row">
                            <label for="Tender_Co" class="col-sm-4 control-label"> Invoice Number :</label>
                            <div class="col-sm-8">
								{{$creditorInvoice->InvoiceNum ?? 'Empty'}}
							</div>
						</div>
						<div class="form-group row">
                            <label for="Tender_Co" class="col-sm-4 control-label"> Invoice Amount :</label>
                            <div class="col-sm-8 currency">
								{{$creditorInvoice->InvAmount ?? 'Empty'}}
							</div>
						</div>
						<div class="form-group row">
                            <label for="status" class="col-sm-4 control-label"> Status :</label>
                            <div class="col-sm-8 currency">
								{{$creditorInvoice->status ?? ''}}
							</div>
						</div>
						<div class="form-group row">
                            <label for="reason" class="col-sm-4 control-label"> Reason :</label>
                            <div class="col-sm-8 currency">
								{{$creditorInvoice->reason ?? ''}}
							</div>
						</div>
						<div class="form-group row">
                            <label for="reason" class="col-sm-4 control-label"> Invoice Reviewed On :</label>
                            <div class="col-sm-8 currency">
								{{\Carbon\Carbon::parse($creditorInvoice->pe_action_date)->format('d/m/Y') ?? 'Empty'}}
							</div>
                        </div>
						
                    </div>
				</div>
				
            </div>

            <div class="col-sm-6">
				@if($creditorInvoice->status == 'New' && $isProjectPE && Gate::allows('subcon_jms_approve'))
				<div class="ibox">
					<div class="ibox-title">
						<h5>Approve Invoice and Generate Payment Certificate</h5>
					</div>
					<div class="ibox-content">
						<div class="form-group row">
                            <div class="col-sm-12">
								<a href="{{route('subcon.invoice.create-paymentcert', $creditorInvoice->CreditorInvoiceID) }}" class="btn btn-xs btn-success">
									<i class="fa fa-money">Approve</i>
								</a>
							</div>
                        </div>
        			</div>
				</div>

				@endif
				@if($creditorInvoice->status == 'New' && $isProjectPE && Gate::allows('subcon_jms_approve'))
				{{Form::model($creditorInvoice, array('route' => array('subcon.invoice.reject')) )}}
				{{Form::hidden('id', $creditorInvoice->CreditorInvoiceID)}}
				{{Form::hidden('action', 'Rejected')}}
				<div class="ibox">
					<div class="ibox-title">
						<h5>Fill in reason, if you're rejecting an Invoice:</h5>
					</div>
					<div class="ibox-content">
						<div class="form-group row">
							<div class="col-sm-8">
								{{Form::text('reason', $creditorInvoice->reason, ['class'=>'form-control'])}}
							</div>
							<div class="col-sm-4">
								<button type="submit" class="btn btn-xs btn-warning pe-reject" id="{{$creditorInvoice->CreditorInvoiceID}}">
									<i class="fa fa-check-square-o">REJECT Invoice</i> 
								</button>
							</div>
						</div>
					</div>
				</div>
				{{ Form::close() }}
				@endif
			</div>           
		</div>
		
	
		<div class="row">
			<div class="ibox-content">
				<h4>Supporting Documents</h4>
				<div class="table-responsive">
					
				</div>
				<br/>
						
				<div>
					<div id="progressTitle">Work Order </div>
					@if(!is_null($creditorInvoice->work_order_document))
						<a href="{{route('subcon.self-service.get-document', $creditorInvoice->work_order_document) }}" target="_blank">
							Work Order Document
						</a>
					@else
						<div>No Work Order Attached.</div>
					@endif
				</div>
				<br/>
				<div>
					<div id="progressTitle">Payment Cert BQ </div>
					@if(!is_null($paymentBQPath))
						<a href="{{route('subcon.self-service.get-document', $paymentBQPath) }}" target="_blank">
							Payment Cert BQ
						</a>
					@else
						<div>No Payment Cert BQ Attached</div>
					@endif
				</div>
				<br/>
				<div>
					<div>Invoice</div>
					@if(!is_null($creditorInvoice->invoice_document))
						<a href="{{route('subcon.self-service.get-document', $creditorInvoice->invoice_document) }}" target="_blank">
							Invoice Document
						</a>
					@else
						<div>No Invoice Attached.</div>
					@endif
				</div>
				<br/>
				<div>
					<div>1st Supporting Document</div>
					@if(!is_null($creditorInvoice->first_supporting_document))
						<a href="{{route('subcon.self-service.get-document', $creditorInvoice->first_supporting_document) }}" target="_blank">
							1st Supporting Document
						</a>
					@else
						<div>No 1st Supporting Document Attached.</div>
					@endif
				</div>
				<br/>
				<div>
					<div>2nd Supporting Document</div>
					@if(!is_null($creditorInvoice->second_supporting_document))
						<a href="{{route('subcon.self-service.get-document', $creditorInvoice->second_supporting_document) }}" target="_blank">
							2nd Supporting Document
						</a>
					@else
						<div>No 2nd Supporting Document Attached.</div>
					@endif
				</div>
				<br/>
				<div>
					<div>3rd Supporting Document</div>
					@if(!is_null($creditorInvoice->third_supporting_document))
						<a href="{{route('subcon.self-service.get-document', $creditorInvoice->third_supporting_document) }}" target="_blank">
							3rd Supporting Document
						</a>
					@else
						<div>No 3rd Supporting Document Attached.</div>
					@endif
				</div>
				<br/>
			</div>
		</div>
	</div>
@endsection

@section('script')
<script>
const anGrossAmount = AutoNumeric.multiple('.currency', {
	maximumValue: "99999999999",
    minimumValue: "0",
	unformatOnSubmit: true
});
</script>

@endsection
