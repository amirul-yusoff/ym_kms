@extends('layouts.app')
@section('title', $title)

@section('content')
@include('partials.breadcrumb')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		{{Form::open(['url' => 'subcon/invoices/storeNotJMS','id' => 'create', 'files'=> true, 'method'=>'POST'] )}}

	@include('partials.message')
		<div class="row">
			<div class="col-sm-4">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Primary Information:</h5>
					</div>
					<div class="ibox-content">
						<div class="form-group row">
							<label for="workorder_id" class="col-sm-4 form-control-label"><span class="required">*</span> Work Order Number :</label>
							<div class="col-sm-8 ">
								{{Form::select('workorder_id', $workorderLists['Select'], null, ['class'=>'form-control form-control-sm workorder', 'required', 'placeholder'=>'Select WorkOrder No.'])}}
							</div>
						</div>
						<div class="form-group row">
							<label for="CreditorInvoiceDate"
								class="col-md-4 col-form-label"><span class="required">*</span> Invoice Date :</label>
							<div class="col-md-8">
								{{ Form::text('CreditorInvoiceDate', $current_date_time, ['class' => 'form-control datepicker']) }}
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
							<label for="invoice_document" class="col-sm-4 form-control-label"><span class="required">*</span> Invoice Document:</label>
							<div class="col-sm-8">
								{{Form::file('invoice_document', null, ['class'=>'form-control form-control-sm', 'required'])}} pdf files only, Max 2MB size
							</div>
						</div>
						<div class="form-group row">
							<label for="work_order_document" class="col-sm-4 form-control-label"><span class="required">*</span>Signed Work Order Document:</label>
							<div class="col-sm-8">
								{{Form::file('work_order_document', null, ['class'=>'form-control form-control-sm', 'required'])}} pdf, jpeg, png, bmp files only, Max 2MB size
							</div>
						</div>
						<div class="form-group row">
							<label for="first_supporting_document" class="col-sm-4 form-control-label">1st Supporting Document:</label>
							<div class="col-sm-8">
								{{Form::file('first_supporting_document', null, ['class'=>'form-control form-control-sm', 'required'])}} pdf, jpeg, png, bmp files only, Max 2MB size
							</div>
						</div>
						<div class="form-group row">
							<label for="second_supporting_document" class="col-sm-4 form-control-label">2nd Supporting Document:</label>
							<div class="col-sm-8">
								{{Form::file('second_supporting_document', null, ['class'=>'form-control form-control-sm', 'required'])}} pdf, jpeg, png, bmp files only, Max 2MB size
							</div>
						</div>
						<div class="form-group row">
							<label for="third_supporting_document" class="col-sm-4 form-control-label">3rd Supporting Document:</label>
							<div class="col-sm-8">
								{{Form::file('third_supporting_document', null, ['class'=>'form-control form-control-sm', 'required'])}} pdf, jpeg, png, bmp files only, Max 2MB size
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Primary Information:</h5>
					</div>
					<div class="ibox-content">
						<div class="form-group row">
							<label for="DateReceived" class="col-md-4 col-form-label">DateReceived :</label>
							<div class="col-md-8">
								{{ Form::text('DateReceived', $current_date_time, ['class' => 'form-control','readonly'  ]) }}
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
							<li>You need to attach a PDF copy of the invoice, signed copy of the work order, up to 3 supporting documents for your work</li>
							<li>Milling and Paving and Road Works
								<ul>Test Report (Coring)</ul>
								<ul>Test Report (CBR)</ul>
								<ul>Test Report (CBR)</ul>
							</li>
							<li>Security or Safety Health Office Service
								<ul>Log Book/Attendance</ul>
							</li>
							<li>Competent / Charge-man
								<ul>Certificate</ul>
								<ul>Permit</ul>
							</li>
							<li>Sewerage Works
								<ul>Pressure Test</ul>
							</li>
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

	function generatepaymentterm() {
		var sevenAcceptanceArray = [
			"100% upon completion of the works 7 days upon receiving invoice submission from the sub-contractor"
		];
		var fourteenAcceptanceArray = [
			"100% upon completion of the works 14 days upon receiving invoice submission from the sub-contractor."
		];
		var thirthyteenAcceptanceArray = [
			"100% upon completion of the works 30 days upon receiving invoice submission from the sub-contractor."
		];
		var fourtyfiveAcceptanceArray = [
			"100% upon completion of the works 45 days upon receiving invoice submission from the sub-contractor.",
			"60% upon piping completion 40% upon completion cabling works. 45 days upon receiving invoice submission from the sub-contractor."
		];
		var ninetyAcceptanceArray = [
			"60% upon completion of works.45 days upon receiving invoice submission from the sub-contractor.20% 90 days up on 1st 60% invoice submission date.20% 180 days upon invoice date."
		];
		//alert($('input[name=PaymentTermold]').val());

		if (sevenAcceptanceArray.includes($('input[name=PaymentTermold]').val())) {
			//alert("7");
			$('input[name=PaymentTerm]').val('7');

		} else if (fourteenAcceptanceArray.includes($('input[name=PaymentTermold]').val())) {
			//alert("14");
			$('input[name=PaymentTerm]').val('14');

		} else if (thirthyteenAcceptanceArray.includes($('input[name=PaymentTermold]').val())) {
			//alert("30");
			$('input[name=PaymentTerm]').val('30');

		} else if (fourtyfiveAcceptanceArray.includes($('input[name=PaymentTermold]').val())) {
			// alert("45");
			$('input[name=PaymentTerm]').val('45');

		} else {
			//alert("111");
			$('input[name=PaymentTerm]').val('90');
		}


	}

</script>
@endsection