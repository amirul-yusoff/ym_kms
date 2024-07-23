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
						<a href="{{route('my-invoice-supplier.create')}}" class="btn btn-xs btn-primary">
							<i class="fa fa-plus"></i> Create
						</a>
				</div>
				<div class="ibox-content">
					<span>
						0. complete <br>
						1. create/edit (upload the DO, Invoice) <br>
						2. submit (JT To certified the details Yes = 3 , No = 1) <br>
						3. pending hardcopy "JT QS" (Yes = 0 ) <br><br>

					</span>
					<table id="LOC" class="table table-striped table-bordered" data-page-length="25" max-width =  "10px">
						<thead>
							<tr>
								<th>ID</th>
								<th>PO Number</th>
								<th>Created At</th>
								<th>Invoice Number</th>
								<th>Invoice Amount</th>
								<th>Stage</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $item)
							<tr>
								<td>{{$item->id}}</td>
								<td>
									@foreach ($item->getPO as $data)
										{{$data->po_number}},
									@endforeach
								</td>
								<td>{{$item->created_at}}</td>
								<td>{{$item->invoice_number}}</td>
								<td>{{$item->invoice_amount}}</td>
								<td>{{$item->stage}}</td>
								<td>{{$item->description}}</td>
								<td>
									@if ($item->stage == 1)
									<a href="{{ route('my-invoice-supplier.edit', ['my_invoice_supplier' => $item->id]) }}" class="btn btn-xs btn-primary">
										<i class="fa fa-pencil"></i> Edit
									</a>
									<a href="{{ route('myInvoiceSupplier.verifyAndSubmit', ['my_invoice' => $item->id]) }}" class="btn btn-xs btn-primary">
										<i class="fa fa-thumbs-up"></i> Verify and Submit
									</a>
									@endif

									@if ($item->stage == 3)
									 Please Prepare the hardcopy to be sent
									@endif

									@if ($item->stage == 0)
									 Invoice Subcon Completed
									@endif

								</a>
								</td>
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