@extends('layouts.app')
@section('title', $title)

@section('content')
@include('partials.breadcrumb')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="wrapper wrapper-content animated fadeInRight">
	@include('partials.message')
	<div class="row">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>{{ $title }}</h5>
				<div class="ibox-tools"></div>
			</div>
			<div class="ibox-content">
				{{ Form::open(['route' => ['project-registry.displayWorkorder', $project_code], 'method' => 'GET']) }}
					<div class="row">
						<div class="col-md-3">
							<label for=">WorkOrderNumber">Work Order Number</label>
							<select name="WorkOrderNumber" class="form-control" id="WorkOrderNumber">
								<option disabled selected></option>
								@foreach ($dropDownWorkOrderNumber as $key => $value)
									<option value="{{$value}}"{{ ( $value == $selectedWorkOrderNumber) ? 'selected' : '' }}>{{ $value}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-3">
							<label for="Status">Status</label>
							<select name="Status" class="form-control" id="Status">
								<option disabled selected></option>
								@foreach ($dropDownStatus as $key => $value)
									<option value="{{$value}}"{{ ( $value == $selectedStatus) ? 'selected' : '' }}>{{ $value}}</option>
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
						</div>						
						<div class="col-md-3">
							<label for="DescriptionofWork">Description of Work</label>
							{{ Form::text('DescriptionofWork', request('DescriptionofWork'), ['class' => 'form-control', 'placeholder' => 'Enter Description']) }}
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
								<th>Status</th>
								<th>Vendor</th>
								<th>Description of Work</th>
								<th>View PC</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $item)
								<tr>
									{{-- <td>{{$item->ID}}</td> --}}
									<td>{{$item->WorkOrderNumber}}</td>
									<td>{{$item->Status}}</td>
									<td>{{$item->Vendor}}</td>
									<td>{{$item->DescriptionofWork}}</td>
									<td>
										<a class="btn btn-xs btn-primary" href="{{ route('project-registry.displayPaymentCert', ['project_code' => $item->ProjectCode, 'woId' => $item->ID]) }}">
											<i class="fa fa-eye"> View PC</i>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript">
	const anElement = AutoNumeric.multiple('.currency');
	$(document).ready(function() {
		$('#WorkOrderNumber').select2({placeholder: "Select Work Order Number", allowClear: true, width: '100%'});
		$('#Status').select2({placeholder: "Select Status", allowClear: true, width: '100%'});
		$('#Vendor').select2({placeholder: "Select Vendor", allowClear: true, width: '100%'});
		
		$('#project').DataTable( {
			dom: 'Bfrtip',
			buttons: ['copy', 'csv', 'excel', 'print']
		} );
	} );
</script>
@endsection