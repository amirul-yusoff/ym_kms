@extends('layouts.app')
@section('title', $title)

@section('content')
@include('partials.breadcrumb')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="wrapper wrapper-content animated fadeInRight">
	@include('partials.message')
	<style>
		.form-control {
			height: 30px;
		}
		.select2-container--default .select2-selection--single {
			border-radius: 4px;
			height: 30px;
			padding: 3px;
		}
		.has-value {
			background-color: #e0f7fa;
			border-color: #4caf50;
		}
		.select2-container.has-value .select2-selection {
			background-color: #e0f7fa;
			border-color: #4caf50;
		}
		.select2-container.no-value .select2-selection {
			background-color: #ffffff;
			border-color: #ced4da; 
		}
	</style>
	<div class="row">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>{{ $title }}</h5>
				<div class="ibox-tools"></div>
			</div>
			<div class="ibox-content">
				{{ Form::open(['route' => ['project-registry.displayPaymentCert', $project_code, $woId], 'method' => 'GET']) }}
					<div class="row">
						<div class="col-md-3">
							<label for="start_date">Payment Cert Start Date</label>
							<div class="input-group">
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>
								{{ Form::text('start_date',  $selectedStartDate ?? '' , ['class' => 'form-control datepicker']) }}
							</div>
						</div>
						<div class="col-md-3">
							<label for="end_date">Payment Cert End Date</label>
							<div class="input-group">                                    
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>
								{{ Form::text('end_date',  $selectedEndDate ?? '' , ['class' => 'form-control datepicker']) }}      
							</div>
						</div>
						{{-- <div class="col-md-3">
							<label for="WorkOrderNo">Work Order No</label>
							<select name="WorkOrderNo" class="form-control" id="WorkOrderNo">
								<option disabled selected></option>
								@foreach ($dropDownWorkOrderNo as $key => $value)
									<option value="{{$value}}"{{ ( $value == $selectedWorkOrderNo) ? 'selected' : '' }}>{{ $value}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-3">
							<label for="Vendor">Vendor</label>
							<select name="Vendor" class="form-control" id="Vendor">
								<option disabled selected></option>
								@foreach ($dropDownVendor as $key => $value)
									<option value="{{$value}}"{{ ( $value == $selectedVendor) ? 'selected' : '' }}>{{ $value}}</option>
								@endforeach
							</select>
						</div>	 --}}
						<div class="col-md-3">
							<label for="PaymentNo">Payment Cert No</label>
							{{ Form::text('PaymentNo',  request('PaymentNo') ?? '' , ['class' => 'form-control', 'placeholder' => 'Enter Payment Cert No']) }}      
						</div>	
						<div class="col-md-3">
							<label for="InvoiceNo">Invoice No</label>
							<select name="InvoiceNo" class="form-control" id="InvoiceNo">
								<option disabled selected></option>
								@foreach ($dropDownInvoiceNo as $key => $value)
									<option value="{{$value}}"{{ ( $value == $selectedInvoiceNo) ? 'selected' : '' }}>{{ $value}}</option>
								@endforeach
							</select>
						</div>						
					</div>					
					<div class="row">
                        <div class="col-md-12">
                            <div style="padding-top: 25px;">
                                <button type="submit" class="btn btn-primary" style="width:100%">
                                    <i class="fa fa-search"></i><span class="hidden-sm"> Search</span>
                                </button>
                            </div>
                        </div>
                    </div>		
				{{Form::close()}}
				<br/>
				
				<div class="table-responsive" style="overflow-x: auto;">
					<table id="project" class="table table-striped table-bordered" data-page-length="25" max-width =  "10px">
						<thead>
							<tr>
								{{-- <th>ID</th> --}}
								<th>Work Order Number</th>
								<th>Vendor</th>
								<th>Payment Cert Date</th>
								<th>PC No</th>
								<th>Invoice No</th>
								<th>Approved Work Done</th>
								<th>Retention</th>
								<th>Previous Payment</th>
								<th>Amount Due</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $item)
								<tr>
									{{-- <td>{{$item->PaymentCertID}}</td> --}}
									<td>{{$item->WorkOrderNo}}</td>
									<td>{{$item->Vendor}}</td>
									<td>{{$item->PayCertDate}}</td>
									<td>{{$item->PaymentNo}} 
										@if ($item->FinalPayment)
										 (Final)
										@endif
									</td>
									<td>{{$item->InvoiceNo}}</td>
									<td>{{$item->ApprovedWorkDone}}</td>
									<td>{{$item->Retention}}</td>
									<td>{{$item->PreviousPayment}}</td>
									<td>{{$item->AmountDue}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript">
	const anElement = AutoNumeric.multiple('.currency');
	$(document).ready(function() {		
		// $('#WorkOrderNo').select2({placeholder: "Select Work Order No", allowClear: true});
		// $('#Vendor').select2({placeholder: "Select Vendor", allowClear: true});
		$('#InvoiceNo').select2({placeholder: "Select Invoice No", allowClear: true, width: '100%'});

		$('#project').DataTable( {
			dom: 'Bfrtip',
			buttons: ['copy', 'csv', 'excel', 'print'],
			searching: false
		} );
		function checkFields() {
			$('input[type="text"]').each(function() {
				if ($(this).val() !== '') {
					$(this).addClass('has-value');
				} else {
					$(this).removeClass('has-value');
				}
			});
			$('select').each(function() {
				var select2Container = $(this).siblings('.select2-container');
				if ($(this).val() && $(this).val().length > 0) {
					select2Container.addClass('has-value').removeClass('no-value');
				} else {
					select2Container.addClass('no-value').removeClass('has-value');
				}
			});
		}

		checkFields();

		$('input[type="text"], select').on('change', function() {
			checkFields();
		});
	} );
</script>
@endsection