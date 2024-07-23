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
							@if ($createButton)
							<a href="{{route('subcon.invoices.createNoneJMS')}}" class="btn btn-xs btn-primary">
								<i class="fa fa-plus"></i> Create None JMS Invoices
							</a>
						@endif
						</div>
					</div>
					<div class="ibox-content">
						<table id="data_table" class="table table-striped table-bordered" data-page-length="25">
							<thead>
								<tr>
									<th>Submission Date</th>
									<th>Invoice #</th>
									<th>Invoice Date</th>
									<th>Work Order Number</th>
									<th>Invoice Amount</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($invoices as $key => $invoice)
								

									<tr id="{{$invoice->CreditorInvoiceID}}">
										<td>{{\Carbon\Carbon::parse($invoice->DateReceived)->format('d/m/Y')}}</td>
										<td>{{Form::hidden('id[]',$invoice->CreditorInvoiceID)}}{{Form::hidden('tableRow',$key) }}
											{{ $invoice->InvoiceNum }}
										</td>
										<td>
											{{\Carbon\Carbon::parse($invoice->CreditorInvoiceDate)->format('d/m/Y') }}</td>
										<td>{{ $invoice->WorkOrderNumber }}</td>
										<td class="invoiceAmount">{{ $invoice->InvAmount }}</td>
										<td>{{ $invoice->status }}</td>
										<td class="project-actions">
											@if ($editButton && $invoice->status == 'New')
												<a href="{{route('subcon.invoice.edit', $invoice->CreditorInvoiceID) }}" class="btn btn-outline btn-xs btn-success">
													<i class="fa fa-pencil"></i> <span class="hidden-md hidden-sm">Edit</span>
												</a>

											@endif
											@if ($deleteButton && $invoice->status == 'New')
												<a class="btn btn-outline btn-warning btn-xs deleteRecord" data-id="{{ $invoice->CreditorInvoiceID }}">
													<i class="fa fa-trash"></i> <span class="hidden-md hidden-sm">Delete</span>
												</a>
											@endif										
											<a href="{{url('subcon/invoices/review/'.$invoice->CreditorInvoiceID)}}" class="btn btn-outline btn-primary btn-xs">
												<i class="fa fa-eye"></i> <span class="hidden-md hidden-sm">View</span>
											</a>
												
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
const anGrossAmount = AutoNumeric.multiple('.invoiceAmount', {
	maximumValue: "99999999999",
    minimumValue: "0",
	unformatOnSubmit: true
});



$(document).ready(function(){
	$(".deleteRecord").click(function(){
		var id = $(this).data("id");
		var recordName = $(this).parent('td').parent('tr').find("td:eq(1)").text();
		
		var confirmation = confirm("Are you sure you want to delete the invoice number "+ recordName.trim() + " ?");

		if (confirmation) {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax(
			{
				type: "POST",
				url: "invoice/"+id,
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

});


</script>

@endsection