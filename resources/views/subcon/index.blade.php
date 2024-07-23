@extends('layouts.app')
@section('title', $title)

@section('content')
	@include('partials.breadcrumb')
	<div class="wrapper wrapper-content animated fadeInRight">
		@include('partials.message')
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5></h5>
						<div class="ibox-tools">
							@if($permission->can_create)
								<a href="{{route($url.'.create')}}" class="btn btn-xs btn-primary">
									<i class="fa fa-plus"></i> Client Invoice Entry
								</a>
							@endif
						</div>
					</div>
					<div class="ibox-content">
						<table id="data_table" class="table table-striped table-bordered" data-page-length="25">
							<thead>
								<tr>
									<th width="70px">Invoice #</th>
									<th width="70px">Invoice Date</th>
									<th width="70px">Project Code</th>
									<th width="70px">PO No</th>
									<th width="40px">Gross Amount</th>
									<th width="40px">Retention Amount</th>
									<th width="40px">Net Amount</th>
									<th width="100px">Paid Amount</th>
									<th width="50px">Is Final Claim</th>
									<th width="200px"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($invoices as $key => $invoice)
									<tr id="{{$invoice->id}}">
										<td>{{Form::hidden('id[]',$invoice->id)}}{{Form::hidden('tableRow',$key) }}
											@if($invoice->invoice_no)
											{{ $invoice->invoice_no }}
											@else
											{{ Form::text('invoice_no[]', null, ['class'=>'form-control', 'size' => 10]) }}
											@endif
										</td>
										<td>{{ $invoice->date->format('d-m-Y') }}</td>
										<td>{{ $invoice->project->project_code }}</td>
										<td>{{ Form::text('po_no[]',$invoice->po_no, ['class'=>'form-control', 'size' => 16]) }}</td>
										<td>{{ Form::text('gross_amount[]',$invoice->gross_amount, ['class'=>'form-control gross_amount currency', 'size' => 12]) }}</td>
										<td>{{ Form::text('retention_amount[]',$invoice->retention_amount, ['class'=>'form-control retention_amount currency', 'size' => 10]) }}</td>
										<td>{{ Form::text('net_amount[]',$invoice->net_amount, ['class'=>'form-control net_amount currency', 'size' => 12]) }}</td>
										<td>{{ $invoice->paid_amount }}</td>
										<td>{{ Form::checkbox('is_final_claim[]', $invoice->id, $invoice->is_final_claim, ['class'=>'form-control finalClaim']) }}</td>
										<td class="project-actions">
												@if($permission->can_update)
													<a href="{{route($url.'.edit', $invoice->id) }}" class="btn btn-outline btn-success btn-sm">
														<i class="fa fa-pencil"></i> <span class="hidden-md hidden-sm">Edit</span>
													</a>
												@endif
												@if($permission->can_delete)
													<button type="submit" class="btn btn-outline btn-danger btn-sm deleteRecord" data-id="{{ $invoice->id }}">
														<i class="fa fa-trash"></i> <span class="hidden-md hidden-sm">Del</span>
													</button>
												@endif
										</td>
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
<script>
const anGrossAmount = AutoNumeric.multiple('.gross_amount.currency', {
	maximumValue: "99999999999",
    minimumValue: "0",
	unformatOnSubmit: true
});

const anRetentionAmount = AutoNumeric.multiple('.retention_amount.currency', {
	maximumValue: "99999999999",
    minimumValue: "0",
	unformatOnSubmit: true
});

const anNetAmount = AutoNumeric.multiple('.net_amount.currency', {
	maximumValue: "99999999999",
	minimumValue: "0",
	unformatOnSubmit: true
});

$(document).ready(function(){
	$('input[name="invoice_no[]"]').on('change', function(e) {
		var name = $(this).attr('name');
		var value = $(this).val();
		var id = $(this).parent('td').parent('tr').attr('id');
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: "POST",
			url: "client-invoices/update-invoice-no",
			data: {invoiceID: id, column: name, value: value},
			success: function(data){
				setTimeout(function() {
					toastr.options = {
						showMethod: 'slideDown',
						timeOut: 1500
					};
					toastr.success(data.success);
				}, 1);
			},
			error: function(xhr, ajaxOptions, thrownError){
				var errorMessage = '';
				if( xhr.status === 422 ) {
					var errors = $.parseJSON(xhr.responseText)['errors'];
					$.each(errors, function (key, val) {
						errorMessage += key + "_error "+val[0]+'<br/>'; 
                    });
				}
				setTimeout(function() {
					toastr.options = {
						showMethod: 'slideDown',
						timeOut: 4500
					};
					toastr.info(errorMessage);
				}, 1);
			}
		});
	});

	$('input[name="po_no[]"]').on('change', function(e) {
		var value = $(this).val();
		var id = $(this).parent('td').parent('tr').attr('id');
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: "POST",
			url: "client-invoices/update-po-no",
			data: {invoiceID: id, value: value},
			success: function(data){
				console.log(data.success);
				setTimeout(function() {
					toastr.options = {
						showMethod: 'slideDown',
						timeOut: 1500
					};
					toastr.success(data.success);
				}, 1);
			},
			error: function(xhr, ajaxOptions, thrownError){
				var errorMessage = '';
				if( xhr.status === 422 ) {
					var errors = $.parseJSON(xhr.responseText)['errors'];
					$.each(errors, function (key, val) {
						errorMessage += key + "_error "+val[0]+'<br/>'; 
                    });
				}
				setTimeout(function() {
					toastr.options = {
						showMethod: 'slideDown',
						timeOut: 4500
					};
					toastr.info(errorMessage);
				}, 1);
			}
		});
	});

	$('.currency').on('change', function(e) {
		var rowValue = $(this).parent('td').parent('tr').children().eq(0).children().eq(1).val();
		var name = $(this).attr('name');
		var value = $(this).val();
		
		if(name == 'gross_amount[]') {
			value = anGrossAmount[rowValue].getNumericString();
		} else if (name == 'retention_amount[]') {
			value = anRetentionAmount[rowValue].getNumericString();
		} else if (name == 'net_amount[]') {
			value = anNetAmount[rowValue].getNumericString();
		} 
		
		var id = $(this).parent('td').parent('tr').attr('id');
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: "POST",
			url: "client-invoices/update-fields",
			data: {invoiceID: id, column: name, value: value},
			success: function(data){
				setTimeout(function() {
					toastr.options = {
						showMethod: 'slideDown',
						timeOut: 1500
					};
					toastr.success(data.success);
					
				}, 1);
			},
			error: function(xhr, ajaxOptions, thrownError){
				var errorMessage = '';
				console.log(xhr.status);
				if( xhr.status === 422 ) {
					var errors = $.parseJSON(xhr.responseText)['errors'];
					$.each(errors, function (key, val) {
						errorMessage += key + "_error "+val[0]+'<br/>'; 
                    });
				}
				setTimeout(function() {
					toastr.options = {
						showMethod: 'slideDown',
						timeOut: 4500
					};
					toastr.info(errorMessage);
				}, 1);
			}
		});
	});
	
	
	$(".deleteRecord").click(function(){
		var id = $(this).data("id");
		var recordName = $(this).parent('td').parent('tr').find("td:eq(0)").text();
		
		var confirmation = confirm("Are you sure you want to delete the record "+ recordName.trim() + " ?");

		if (confirmation) {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax(
			{
				type: "POST",
				url: "client-invoices/"+id,
				data: {
					_method: "DELETE",
					id: id,
				},
				success: function(data){
					setTimeout(function() {
						toastr.options = {
							showMethod: 'slideDown',
							timeOut: 1500
						};
						toastr.success(data.success);
					}, 1);
					location.reload();
				},
				error: function(xhr, ajaxOptions, thrownError){
					var errorMessage = '';
					console.log(xhr.status);
					if( xhr.status === 422 ) {
						var errors = $.parseJSON(xhr.responseText)['errors'];
						$.each(errors, function (key, val) {
							errorMessage += key + "_error "+val[0]+'<br/>'; 
						});
					}
					setTimeout(function() {
						toastr.options = {
							showMethod: 'slideDown',
							timeOut: 4500
						};
						toastr.info(errorMessage);
					}, 1);
				}
			});
		}
	});


	$(".finalClaim").on("change", function () {
		var val = $(this).val();
		var apply = $(this).is(':checked') ? 1 : 0;
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({type: "POST",
			url: "<?php echo url('/client-invoices/update-final-claim'); ?>",
			data: {invoiceID: val, apply: apply},
			success: function(){
				setTimeout(function() {
					toastr.options = {
						showMethod: 'slideDown',
						timeOut: 1500
					};
					toastr.success('Final Claim Updated');
				}, 300);
			},
			error: function(xhr, ajaxOptions, thrownError){
				var errorMessage = '';
				console.log(xhr.status);
				if( xhr.status === 422 ) {
					var errors = $.parseJSON(xhr.responseText)['errors'];
					$.each(errors, function (key, val) {
						errorMessage += key + "_error "+val[0]+'<br/>'; 
					});
				}
			
				setTimeout(function() {
					toastr.options = {
						showMethod: 'slideDown',
						timeOut: 4500
					};
					toastr.info(errorMessage);
				}, 1);
			}
			
		});
	});
});


</script>

@endsection