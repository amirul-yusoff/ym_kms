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
									<th>PO Number</th>
									<th>item</th>
									<th>description</th>
									<th>quantity</th>
									<th>rate</th>
									<th>total_price</th>
									<th>status</th>
									<th>supplier</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($data as $item)
								<tr>
									<td>{{$item->id}}</td>
									<td>{{$item->po_id}}</td>
									<td>{{$item->item}}</td>
									<td>{{$item->description}}</td>
									<td>{{$item->quantity}}</td>
									<td>{{$item->rate}}</td>
									<td>{{$item->total_price}}</td>
									<td>{{$item->status}}</td>
									<td>{{$item->supplier}}</td>
									
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