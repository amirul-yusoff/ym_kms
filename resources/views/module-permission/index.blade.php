@extends('layouts.app')
@section('title', $title)
@section('content')
@include('partials.breadcrumb')

<div class="wrapper wrapper-content animated fadeInRight">
	@include('partials.message')
	<div class="row">
		{{-- @if (\Session::has('success'))
				<div class="alert alert-success">
					<ul>
						<li>{!! \Session::get('success') !!}</li>
					</ul>
				</div>
		@endif
		@if (\Session::has('warning'))
				<div class="alert alert-warning">
					<ul>
						<li>{!! \Session::get('warning') !!}</li>
					</ul>
				</div>
		@endif --}}
		<div class="col-lg-12">
			<div class="float-e-margins">
				<div class="ibox-title">
					<h5>{{ $title }}</h5>
					<div class="ibox-tools">
						<a href="{{route('module-permission.create')}}" class="btn btn-xs btn-primary">
							<i class="fa fa-plus"></i> Create
						</a>
				</div>
				<div class="ibox-content">
					
					<table id="LOC" class="table table-striped table-bordered" data-page-length="25" max-width =  "10px">
						<thead>
							<tr>

								<th>ID</th>
								<th>Module Name</th>
								<th>Description</th>
								<th>Url</th>
								<th>Icon</th>
								<th>Parent Name</th>
								<th>Permission To View</th>
								{{-- <th width="5px">Action</th> --}}

							</tr>
						</thead>
						<tbody>
							@foreach ($data as $item)
								<tr>
									<td>{{$item->id}}</td>
									<td>{{$item->module_name}}</td>
									<td>{{$item->description}}</td>
									<td>{{$item->url}}</td>
									<td>{{$item->icon}}</td>
									<td>
										@if ($item->parent != NULL)
											{{$item->parent->module_name}}
										@endif
									</td>
									<td>
										@if ($item->getToViewPermission != NULL)
											{{$item->getToViewPermission->getToViewPermission->name}}
										@endif
									</td>
									{{-- <td>
										<a class="btn btn-xs btn-primary" href="{{ route('request-manpower.edit',$item->id ) }}">
											<i class="fa fa-pencil"> Edit</i>
										</a><br>
										<a href="{{route('request-manpower.print',$item->id )}}" class="btn btn-xs btn-primary">
											<i class="fa fa-plus"></i> Print
										</a>
									</td> --}}
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