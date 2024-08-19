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
				{{ Form::open(['route' => ['project-registry.displayPO', $project_code], 'method' => 'GET']) }}
					<div class="row">
						<div class="col-md-3">
							<label for="item">Item</label>
							<select name="item" class="form-control" id="item">
								<option disabled selected></option>
								@foreach ($dropDownItem as $key => $value)
									<option value="{{$value}}"{{ ( $value == $selectedItem) ? 'selected' : '' }}>{{ $value}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-3">
							<label for="description">Description</label>
							{{ Form::text('description',  request('description') ?? '' , ['class' => 'form-control', 'placeholder' => 'Enter Description']) }}      
						</div>
						<div class="col-md-3">
							<label for="status">Status</label>
							<select name="status" class="form-control" id="status">
								<option disabled selected></option>
								@foreach ($dropDownStatus as $key => $value)
									<option value="{{$value}}"{{ ( $value == $selectedStatus) ? 'selected' : '' }}>{{ $value}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-3">
							<label for="supplier">Supplier</label>
							<select name="supplier" class="form-control" id="supplier">
								<option disabled selected></option>
								@foreach ($dropDownSupplier as $key => $value)
									<option value="{{$value}}"{{ ( $value == $selectedSupplier) ? 'selected' : '' }}>{{ $value}}</option>
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
								<th>PO Number</th>
								<th>Item</th>
								<th>Description</th>
								<th>Quantity</th>
								<th>Rate</th>
								<th>Total Price</th>
								<th>Status</th>
								<th>Supplier</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $item)
								<tr>
									{{-- <td>{{$item->id}}</td> --}}
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
		$('#item').select2({placeholder: "Select Item", allowClear: true, width: '100%'});
		$('#status').select2({placeholder: "Select Status", allowClear: true, width: '100%'});
		$('#supplier').select2({placeholder: "Select Supplier", allowClear: true, width: '100%'});

		$('#project').DataTable( {
			dom: 'Bfrtip',
			buttons: ['copy', 'csv', 'excel', 'print']
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