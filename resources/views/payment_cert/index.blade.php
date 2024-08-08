@extends('layouts.app')
@section('title', $title)
@section('content')
@include('partials.breadcrumb')

<div class="wrapper wrapper-content animated fadeInRight">
	@include('partials.message')
	<div class="row">
		<div class="col-lg-12">
			<div class="float-e-margins">
				<div class="ibox-title">
					<h5>{{ $title }}</h5>
					<div class="ibox-tools">
				</div>
				<div class="ibox-content">
					<div class="table-responsive" style="overflow-x: auto;">
						<table id="project" class="table table-striped table-bordered" data-page-length="25" max-width =  "10px">
							<thead>
								<tr>
									<th>ID</th>
									<th>WorkOrderNumber</th>
									<th>Vendor</th>
									<th>PayCertDate</th>
									<th>PC No</th>
									<th>InvoiceNo</th>
									<th>ApprovedWorkDone</th>
									<th>Retention</th>
									<th>PreviousPayment</th>
									<th>AmountDue</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($data as $item)
								<tr>
									<td>{{$item->PaymentCertID}}</td>
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
			<div class="ibox-title">
				
			</div>
		</div>
	</div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>
@endsection

@section('script')

<script type="text/javascript">
	
</script>
<script type="text/javascript">
	const anElement = AutoNumeric.multiple('.currency');
	$(document).ready(function() {
		$('#project').DataTable( {
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'print'
			]
		} );
	} );
</script>
@endsection