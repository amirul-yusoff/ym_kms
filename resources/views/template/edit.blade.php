@extends('layouts.app')

@section('title', $title)

@section('content')
@include('partials.breadcrumb')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="">
		{{Form::model($invoice, array('route' => array($url.'.update', $invoice->id), 'method' => 'PUT'))}}
		{{Form::hidden('id', $invoice->id)}}
		@include('partials.message')
		<div class="row">
			<div class="col-sm-4">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Primary Information:</h5>
					</div>
					<div class="ibox-content">
						<div class="form-group row">
							<label for="project_id" class="col-sm-4 form-control-label"><span class="required">*</span>Project Code :</label>
							<div class="col-sm-8">
								{{Form::select('project_id', $projectLists, ['class'=>'form-control form-control-sm', 'required'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="invoice_no" class="col-sm-4 form-control-label"><span class="required">*</span> Invoice Number :</label>
							<div class="col-sm-8">
								{{Form::text('invoice_no', null, ['class'=>'form-control form-control-sm', 'required'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="payment_term" class="col-sm-4 form-control-label"><span class="required">*</span> Payment Terms:</label>
							<div class="col-sm-8">
								{{Form::select('payment_term', $paymentTermLists, 30, ['class'=>'form-control form-control-sm'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="loc_no" class="col-sm-4 form-control-label">LOC Number:</label>
							<div class="col-sm-8">
								{{Form::text('loc_no', null, ['class'=>'form-control form-control-sm'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="gross_amount" class="col-sm-4 form-control-label"><span class="required">*</span> Gross Amount:</label>
							<div class="col-sm-8">
								{{Form::text('gross_amount', null, ['class'=>'form-control form-control-sm currency', 'required'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="retention_amount" class="col-sm-4 form-control-label">Retention Amount:</label>
							<div class="col-sm-8">
								{{Form::text('retention_amount', null, ['class'=>'form-control form-control-sm currency'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="net_amount" class="col-sm-4 form-control-label"><span class="required">*</span> Net Amount:</label>
							<div class="col-sm-8">
								{{Form::text('net_amount', null, ['class'=>'form-control form-control-sm currency', 'required'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="claim_no" class="col-sm-4 form-control-label"><span class="required">*</span> Claim No:</label>
							<div class="col-sm-8">
								{{Form::select('claim_no', $claimNoLists, ['class'=>'form-control form-control-sm', 'required'])}}
							</div>
						</div>						
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Secondary Information</h5>
					</div>
					<div class="ibox-content">
						<div class="form-group row">
							<label for="po_no" class="col-sm-4 form-control-label">PO No:</label>
							<div class="col-sm-8">
								{{Form::text('po_no', null, ['class'=>'form-control form-control-sm'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="remarks" class="col-sm-4 form-control-label">Remarks:</label>
							<div class="col-sm-8">
								{{Form::text('remarks', null, ['class'=>'form-control form-control-sm'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="is_final_claim" class="col-sm-4 form-control-label">Is Final Claim:</label>
							<div class="col-sm-1">
								{{Form::checkbox('is_final_claim', null, 0, ['class'=>'form-control form-control-sm'])}}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Usage Tips</h5>
					</div>
					<div class="ibox-content">
						Primary Information is mandatory or most likely need to be filled Information
						<br/>
						Secondary information is optional
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<button class="btn btn-primary" type="submit">
					<i class="fa fa-floppy-o"></i>
					Submit
				</button>
				
			</div>
		</div>
		{{ Form::close() }}
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
grossAmount = document.getElementsByName('gross_amount')[0];
retentionAmount = document.getElementsByName('retention_amount')[0];
netAmount = document.getElementsByName('net_amount')[0];
const [anGrossAmount, anRetentionAmount, anNetAmount] = AutoNumeric.multiple([grossAmount, retentionAmount, netAmount], {
	maximumValue: "99999999999",
    minimumValue: "0",
	unformatOnSubmit: true
});

$(document).ready(function()
{
	$('input[name=gross_amount]').on('focusout', function(e) {
		calculateRetention();
	});
});

function calculateRetention() {
	if (!$('input[name=gross_amount]').val()){
		$('input[name=gross_amount]').val(0);
	}
	
	var grossAmount =parseFloat($('input[name=gross_amount]').val().replace(/,/g, ''));
	+(Math.round(grossAmount + "e+2")  + "e-2");
	var retentionAmount = grossAmount*0.1;
	var netAmount = grossAmount*0.9;
	
	retentionAmount = Math.round( ( retentionAmount + Number.EPSILON ) * 100 ) / 100;
	netAmount = Math.round( ( netAmount + Number.EPSILON ) * 100 ) / 100;

	anRetentionAmount.set(retentionAmount);
	anNetAmount.set(netAmount);
}

</script>	
@endsection