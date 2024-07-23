@extends('layouts.app')
@section('title', $title)

@section('content')
@include('partials.breadcrumb')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="">
		{{ Form::open(['url' => $url,'id' => 'create']) }}
		@include('partials.message')
		<div class="row">
			<div class="col-sm-4">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Primary Information:</h5>
					</div>
					<div class="ibox-content">
						<div class="form-group row">
							<label for="project_id" class="col-sm-4 form-control-label"><span class="required">*</span> Project Code :</label>
							<div class="col-sm-8 ">
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
							<label for="payment_term" class="col-sm-4 form-control-label"><span class="required">*</span> Payment Terms :</label>
							<div class="col-sm-8">
								{{Form::select('payment_term', $paymentTermLists, 30, ['class'=>'form-control form-control-sm', 'required'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="loc_no" class="col-sm-4 form-control-label">LOC Number :</label>
							<div class="col-sm-8">
								{{Form::text('loc_no', null, ['class'=>'form-control form-control-sm'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="gross_amount" class="col-sm-4 form-control-label"><span class="required">*</span> Gross Amount :</label>
							<div class="col-sm-8">
								{{Form::text('gross_amount', null, ['class'=>'form-control form-control-sm currency', 'required'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="retention_amount" class="col-sm-4 form-control-label">Retention Amount :</label>
							<div class="col-sm-8">
								{{Form::text('retention_amount', null, ['class'=>'form-control form-control-sm currency'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="net_amount" class="col-sm-4 form-control-label"><span class="required">*</span> Net Amount :</label>
							<div class="col-sm-8">
								{{Form::text('net_amount', null, ['class'=>'form-control form-control-sm', 'required'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="claim_no" class="col-sm-4 form-control-label"><span class="required">*</span> Claim No :</label>
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
							<label for="po_no" class="col-sm-4 form-control-label">PO No :</label>
							<div class="col-sm-8">
								{{Form::text('po_no', null, ['class'=>'form-control form-control-sm'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="remarks" class="col-sm-4 form-control-label">Remarks :</label>
							<div class="col-sm-8">
								{{Form::text('remarks', null, ['class'=>'form-control form-control-sm'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="is_final_claim" class="col-sm-4 form-control-label">Is Final Claim :</label>
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
						<ul>
							<li>Fields marked with * is required</li>
							<li>Secondary information is optional</li>
							<li>Invoice can be generated from an existing Letter of Claims or created manually</li>
							<li>Normally, you do not need to manually create an invoice and it can be generated from the LOC page</li>
							<li>Field Description</li>
							<li>Project Code for projects that's not marked as Closed</li>
							<li>Invoice Number, invoice number as created in Autocount, Unity or from licensed company</li>
							<li>Payment Terms, normally 30 days, or back to back</li>
						</ul>
						
						<br/>
						
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<button class="btn btn-primary" type="submit">
					<i class="fa fa-floppy-o"></i>
					Save &gt; Return
				</button>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<button type="submit" class="btn btn-info saveAndCreateNew">
					<i class="fa fa-plus"></i> Save &gt; Create Again
				</button>
				{{Form::hidden('recreate', 0)}}
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
	
	$(".saveAndCreateNew").click(function(){
		$('input[name=recreate]').val(1);
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