@extends('layouts.app')
@section('title', $title)

@section('content')
@include('partials.breadcrumb')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		{{Form::model($invoice, array('route' => array('subcon.invoice.jms-update', $invoice->CreditorInvoiceID), 'method' => 'POST', 'files'=> true))}}
		{{Form::hidden('id', $invoice->CreditorInvoiceID)}}
		{{Form::hidden('project_code', $invoice->ProjectCode)}}
		{{Form::hidden('workorderNumber', $invoice->WorkOrderNumber)}}

	@include('partials.message')
		<div class="row">
			<div class="col-sm-4">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Primary Information:</h5>
					</div>
					<div class="ibox-content">
						<div class="form-group row">
							<label for="CreditorInvoiceDate"
								class="col-md-4 col-form-label"><span class="required">*</span> Invoice Date :</label>
							<div class="col-md-8">
								{{ Form::text('CreditorInvoiceDate', null, ['class' => 'form-control datepicker']) }}
							</div>
						</div>
						
						<div class="form-group row">
							<label for="InvoiceNum" class="col-md-4 col-form-label"><span class="required">*</span> Invoice Number :</label>
							<div class="col-md-8">
								{{ Form::text('InvoiceNum', null, ['class' => 'form-control capitalize', 'required'  ]) }}
							</div>
						</div>
						<div class="form-group row">
							<label for="InvAmount" class="col-md-4 col-form-label"><span class="required">*</span> Invoice Amount :</label>
							<div class="col-md-8">
								{{ Form::text('InvAmount', null, ['class' => 'form-control currency', 'required','autocomplete'=>"off"  ]) }}
							</div>
						</div>
						<div class="form-group row">
							<label for="invoice_document" class="col-sm-4 form-control-label"><span class="required">*</span> Invoice Document :</label>
							<div class="col-sm-8">
								@if (isset($invoice->invoice_document))
									<img src="{{ route('subcon.self-service.get-document-small', $invoice->invoice_document) }}" style="float:left; padding-right: 50px">
								@endif
								{{Form::file('invoice_document', null, ['class'=>'form-control form-control-sm', 'required'])}} pdf, jpeg, png, bmp files only, Max 2MB size
							</div>
						</div>
						<div class="form-group row">
							<label for="first_supporting_document" class="col-sm-4 form-control-label">1st Supporting Document :</label>
							<div class="col-sm-8">
								@if (isset($invoice->first_supporting_document))
									<img src="{{ route('subcon.self-service.get-document-small', $invoice->first_supporting_document ?? '') }}" style="float:left; padding-right: 50px">
								@endif
								{{Form::file('first_supporting_document', null, ['class'=>'form-control form-control-sm', 'required'])}} pdf, jpeg, png, bmp files only, Max 2MB size
							</div>
						</div>
						<div class="form-group row">
							<label for="second_supporting_document" class="col-sm-4 form-control-label">2nd Supporting Document :</label>
							<div class="col-sm-8">
								@if (isset($invoice->second_supporting_document))
									<img src="{{ route('subcon.self-service.get-document-small', $invoice->second_supporting_document ?? '') }}" style="float:left; padding-right: 50px">
								@endif
								{{Form::file('second_supporting_document', null, ['class'=>'form-control form-control-sm', 'required'])}} pdf, jpeg, png, bmp files only, Max 2MB size
							</div>
						</div>
						<div class="form-group row">
							<label for="third_supporting_document" class="col-sm-4 form-control-label">3rd Supporting Document :</label>
							<div class="col-sm-8">
								@if (isset($invoice->third_supporting_document))
									<img src="{{ route('subcon.self-service.get-document-small', $invoice->third_supporting_document ?? '') }}" style="float:left; padding-right: 50px">
								@endif
								{{Form::file('third_supporting_document', null, ['class'=>'form-control form-control-sm', 'required'])}} pdf, jpeg, png, bmp files only, Max 2MB size
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Reference:</h5>
					</div>
					<div class="ibox-content">
						<div class="form-group row">
							<label for="DateReceived" class="col-md-4 col-form-label">Submission Date :</label>
							<div class="col-md-8">
								{{ Form::text('DateReceived', null, ['class' => 'form-control','readonly'  ]) }}
							</div>
						</div>
						<div class="form-group row">
							<label for="Vendor" class="col-md-4 col-form-label">Vendor :</label>
							<div class="col-md-8">
								{{ Form::text('Vendor', null, ['class' => 'form-control' ,'readonly' ]) }}
							</div>
						</div>
						<div class="form-group row">
							<label for="ProjectCode" class="col-md-4 col-form-label">ProjectCode :</label>
							<div class="col-md-8">
								{{ Form::text('ProjectCode', null, ['class' => 'form-control' ,'readonly'  ]) }}
							</div>
						</div>
						<div class="form-group row">
							<label for="WorkOrderNumber" class="col-md-4 col-form-label">WorkOrderNumber
								:</label>
							<div class="col-md-8">
								{{ Form::text('WorkOrderNumber', null, ['class' => 'form-control' ,'readonly']) }}
							</div>
						</div>
						<div class="form-group row">
							<label for="PaymentTerm" class="col-md-4 col-form-label"><span class="required">*</span> Payment Term in Days :</label>
							<div class="col-md-8">
								{{Form::text('PaymentTerm', null, ['class' => 'form-control', 'readonly'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="paymentT" class="col-md-4 col-form-label">Payment Terms
								:</label>
							<div class="col-md-8">
								{{ Form::textarea('paymentT', $workorder->PaymentTerm, ['class' => 'form-control' ,'readonly', 'rows' => 6  ]) }}
							</div>
						</div>
						<div class="form-group row">
							<label for="CostOfWork" class="col-md-4 col-form-label">WO Value :</label>
							<div class="col-md-8">
								{{ Form::text('CostOfWork', $workorder->CostofWork, ['class' => 'form-control currency' ,'readonly' ]) }}
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
							<li>You need to attach a PDF copy of the invoice</li>
							<li>You will also need to post the actual invoice to Jati Tinggi Holding Sdn Bhd, attention Account Payable Department</li>

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
					Save 
				</button>
			</div>
		</div>
		{{ Form::close() }}

	</div>
</div>

@endsection

@section('script')

<script type="text/javascript">
	$(document).ready(function () {

		$('.capitalize').blur(function () {
			// Capitalize all alphabet
			$(this).val($(this).val().toUpperCase());
			// Remove Space
			$(this).val($(this).val().replace(/\s/g, ''));
			// remove initial slash "/", uf found
			$(this).val($(this).val().replace(/^[//]+/, ''));

		});

		const anCurrencyElement = AutoNumeric.multiple('.currency', {
			maximumValue: "99999999999",
			minimumValue: "-99999999999",
			unformatOnSubmit: true
		});

		const anNumberOnlyElement = AutoNumeric.multiple('.allowNumberOnly', {
			maximumValue: "99999999999",
			minimumValue: "0",
			unformatOnSubmit: true
		});

	});

</script>
@endsection