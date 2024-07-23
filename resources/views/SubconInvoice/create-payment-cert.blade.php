@extends('layouts.app')
@section('title', $title)

@section('content')
@include('partials.breadcrumb')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="">
		{{ Form::open(['url' => 'subcon/invoices/storePaymentCert','id' => 'create']) }}
		{{Form::hidden('creditorInvoiceID', $id)}}
		@include('partials.message')
		<div class="row">
			<div class="col-sm-4">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Payment Certificate Information:</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group row">
							<label for="PaymentNo" class="col-sm-4 control-label">Payment No. :</label>
							<div class="col-sm-8">
								{{ Form::text('PaymentNo', $number, ['class' => 'form-control','readonly']) }}
							</div>
						</div>
						<div class="form-group row">
							<label for="PayCertDate" class="col-sm-4 control-label"><span class="required">*</span> Date :</label>
							<div class="col-sm-8">
								<div class="input-group">
								{{ Form::text('PayCertDate', $currentDateTime, ['class' => 'form-control datepicker']) }}
								<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
								</div>
							</div>
						</div>
				
						

						<div class="form-group row">
							<label for="ApprovedWorkDone" class="col-sm-4 control-label"><span class="required">*</span> Work Done :</label>
							<div class="col-sm-8">
								<div class="input-group">
								<span class="input-group-addon">RM</span>
								{{ Form::text('ApprovedWorkDone', null, ['class' => 'form-control currency', 'autocomplete' => 'off']) }}
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="Retention" class="col-sm-4 control-label">Retention :</label>
							<div class="col-sm-8">
								<div class="input-group">
								<span class="input-group-addon">RM</span>
								{{ Form::text('Retention', 0, ['class' => 'form-control currency']) }}
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="DebitNote" class="col-sm-4 control-label">Debit Note/BackCharge:</label>
							<div class="col-sm-8">
								<div class="input-group">
								<span class="input-group-addon">RM</span>
								{{ Form::text('DebitNote', 0, ['class' => 'form-control currency']) }}
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="Other" class="col-sm-4 control-label">Back Charge/Insurance Note:</label>
							<div class="col-sm-8">

								{{ Form::text('Other', null, ['class' => 'form-control capitalize']) }}

							</div>
						</div>
						<div class="form-group row">
							<label for="GST" class="col-sm-4 control-label">SST :</label>
							<div class="col-sm-8">
								<div class="input-group">
								<span class="input-group-addon">RM</span>
								{{ Form::text('GST', 0, ['class' => 'form-control currencyTax']) }}
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="PreviousPayment" class="col-sm-4 control-label">Previous Work Done :</label>
							<div class="col-sm-8">
								<div class="input-group">
								<span class="input-group-addon">RM</span>
								{{ Form::text('PreviousPayment', $lastPaymentAmount, ['class' => 'form-control currencyPreviousPaid', 'readonly']) }}
								</div>
							</div>
						</div>
						
						<div class="form-group row">
							<label for="AmountDue" class="col-sm-4 control-label">AmountDue :</label>
							<div class="col-sm-8">
								<div class="input-group">
								<span class="input-group-addon">RM</span>
								{{ Form::text('AmountDue', null, ['class' => 'form-control currencyNegative']) }}
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="FinalPayment" class="col-sm-4 control-label">Final payment :</label>
							<div class="col-sm-8">
								{{ Form::radio('FinalPayment', '-1', ['class' => 'form-control']) }} Yes
								{{ Form::radio('FinalPayment', '0', ['class' => 'form-control']) }} No
							</div>
						</div>
						{{ Form::hidden('PreparedBy', $user->employee_code, ['class' => 'form-control']) }}
						{{ Form::hidden('ProjectCode', $projectRegistry->Project_Code, ['class' => 'form-control']) }}
						{{ Form::hidden('WorkOrderNo', $workorder->WorkOrderNumber, ['class' => 'form-control']) }}
						{{ Form::hidden('WOid', $workorder->ID, ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Subcon Invoice Details</h5>
					</div>
					<div class="ibox-content">
                        <div class="form-group row">
							<label for="PeriodEnding" class="col-sm-4 control-label">Invoice Date :</label>
							<div class="col-sm-8">
								<div class="input-group">
									{{ Form::text('PeriodEndingDisplay', $creditorInvoice->CreditorInvoiceDate->format('d-m-Y'), ['class' => 'form-control', 'readonly']) }}
									{{ Form::hidden('PeriodEnding', $creditorInvoice->CreditorInvoiceDate, ['class' => 'form-control-static']) }}
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="InvoiceNo" class="col-sm-4 control-label">Subcon Invoice No. :</label>
							<div class="col-sm-8">
								{{ Form::text('InvoiceNoDisplay', $creditorInvoice->InvoiceNum, ['class' => 'form-control', 'readonly']) }}
								{{ Form::hidden('InvoiceNo', $creditorInvoice->InvoiceNum, ['class' => 'form-control-static']) }}
							</div>
						</div>
						<div class="form-group row">
							<label for="InvoiceNo" class="col-sm-4 control-label">Invoice Amount :</label>
							<div class="col-sm-8">
								{{ Form::text('InvoiceAmountDisplay', $creditorInvoice->InvAmount, ['class' => 'form-control currency', 'readonly']) }}
							</div>
						</div>
					</div>
				</div>
				<div class="ibox">
					<div class="ibox-title">
						<h5>JMS and WO Details</h5>
					</div>
					<div class="ibox-content">
						<div class="form-group row">
							<label for="Vendor" class="col-sm-4 control-label">Vendor :</label>
							<div class="col-sm-8">
								<p>{{ $workorder->Vendor }}</p>
								{{ Form::hidden('Vendor', $workorder->Vendor, ['class' => 'form-control-static', 'readonly']) }}
							</div>
						</div>
                        <div class="form-group row">
							<label for="WorkOrderNo" class="col-sm-4 control-label">WO # :</label>
							<div class="col-sm-8">
								<p>{{ $workorder->WorkOrderNumber }}</p>
								{{ Form::hidden('WorkOrderNo', $workorder->WorkOrderNumber, ['class' => 'form-control-static', 'readonly']) }}
							</div>
						</div>
                        <div class="form-group row">
							<label for="WorkOrderNo" class="col-sm-4 control-label">Contract Amount :</label>
							<div class="col-sm-8">
								<p class='currency'>{{ $workorder->CostofWork }}</p>
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
							<li>Concept of Payment Cert, Work Done is total CUMULATIVE value of work</li>
							<li>Previous WorkDone = The last Payment Cert's Wor kDone Value</li>
							<li>Please key in Back charge or insurance Note if there's any damage by subcon</li>
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
				{{Form::hidden('recreate', 1)}}
			</div>
		</div>
		{{ Form::close() }}
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">

$(document).ready(function() 
{
	const anCurrencyElement = AutoNumeric.multiple('.currency', {
		maximumValue: "9999999",
		minimumValue: "0",
		unformatOnSubmit: true
	});

	const anCurrencyNegative = AutoNumeric.multiple('.currencyNegative', {
		maximumValue: "9999999",
		minimumValue: "-10000000",
		unformatOnSubmit: true
	});

	const anCurrencyTax = AutoNumeric.multiple('.currencyTax', {
		maximumValue: "9999999",
		minimumValue: "0",
		unformatOnSubmit: true
	});

	const anPreviousPaid = AutoNumeric.multiple('.currencyPreviousPaid', {
		maximumValue: "9999999",
		minimumValue: "0",
		unformatOnSubmit: true
	});

	$("[name='ApprovedWorkDone']").on('focusout', function(e){
		recalculate();
		calculateRetention();
	});

	$("[name='Retention']").on('focusout', function(e){
		recalculate();
	});
	$("[name='GST']").on('focusout', function(e){
		recalculate();
	});
	$("[name='DebitNote']").on('focusout', function(e){
		recalculate();
	});


	function recalculate(){
		var ApprovedWorkDone = anCurrencyElement[0].getNumber();
		
		var Retention = anCurrencyElement[1].getNumber();
		var DebitNote = anCurrencyElement[2].getNumber();
		var tax = anCurrencyTax[0].getNumber();

		var PreviousPayment = anPreviousPaid[0].getNumber();

		var AmountDue = (ApprovedWorkDone - PreviousPayment - DebitNote - Retention) + tax;

		anCurrencyNegative[0].set(AmountDue);
	}

	function calculateRetention(){
		var ApprovedWorkDone = anCurrencyElement[0].getNumber();
		
		retention = ApprovedWorkDone * 0.05;

		anCurrencyElement[1].set(retention);
	}
});
</script>
@endsection 