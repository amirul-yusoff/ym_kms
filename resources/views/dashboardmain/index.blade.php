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
					
					<table id="LOC" class="table table-striped table-bordered" data-page-length="25" max-width =  "10px">
						<thead>
							<tr>
								<th>ID</th>
								<th>Work Order</th>
								<th>Invoice Date</th>
								<th>Invoice Submission Date</th>
								<th>Invoice Created At</th>
								<th>Invoice Number</th>
								<th>Invoice Amount</th>
								<th>Status</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $item)
							<tr>
								<td>{{$item->id}}</td>
								<td>{{$item->wo_number}}</td>
								<td>{{$item->invoice_date}}</td>
								<td>{{$item->invoice_submission}}</td>
								<td>{{$item->created_at}}</td>
								<td>{{$item->invoice_number}}</td>
								<td>{{$item->invoice_amount}}</td>
								<td>{{$item->status}}</td>
								<td>{{$item->description}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
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
		$('#LOC').DataTable( {
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'print'
			]
		} );
	} );
</script>
<script type="text/javascript">
$('#myModal').modal('show')
$('.modal').on('shown.bs.modal', function (e) {
        $('.modal.show').each(function (index) {
            $(this).css('z-index', 1101 + index*2);
        });
        $('.modal-backdrop').each(function (index) {
            $(this).css('z-index', 1101 + index*2-1);
        });
    });
</script>
@endsection