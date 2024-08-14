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
				{{ Form::open(array('route' => array('project_registry.index')) )}}
				{{ method_field('GET') }}
					<div class="row">
						<div class="col-md-3">
							<label for="Project_ID">ID</label>
							{{ Form::text('Project_ID', request('Project_ID'), ['class' => 'form-control', 'placeholder' => 'Enter Project ID']) }}							
						</div>
						<div class="col-md-3">
							<label for="Project_Code">JT Project Code</label>
							<select name="Project_Code" class="form-control" id="Project_Code">
								<option disabled selected></option>
								@foreach ($dropDownProjectCode as $key => $value)
									<option value="{{$value}}"{{ ( $value == $selectedProjectCode) ? 'selected' : '' }}>{{ $value}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-3">
							<label for="Project_Short_name">Project Short Name</label>
							{{ Form::text('Project_Short_name', request('Project_Short_name'), ['class' => 'form-control', 'placeholder' => 'Enter Project Short Name']) }}
						</div>						
						<div class="col-md-3">
							<label for="Project_Title">Project Title</label>
							{{ Form::text('Project_Title', request('Project_Title'), ['class' => 'form-control', 'placeholder' => 'Enter Project Title']) }}
						</div>
					</div>
					<div class="row" style="padding-top: 15px">
						<div class="col-md-3">
							<label for="Project_Contract_No">Project Contract No</label>
							{{ Form::text('Project_Contract_No', request('Project_Contract_No'), ['class' => 'form-control', 'placeholder' => 'Enter Project Contract No']) }}
						</div>
						<div class="col-md-3">
							<label for="project_type">Project Type</label>
							<select name="project_type" class="form-control" id="project_type">
								<option disabled selected></option>
								@foreach ($dropDownProjectType as $key => $value)
									<option value="{{$value}}"{{ ( $value == $selectedProjectType) ? 'selected' : '' }}>{{ $value}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-3">
							<label for="project_team">Project Team</label>
							<select name="project_team" class="form-control" id="project_team">
								<option disabled selected></option>
								@foreach ($dropDownProjectTeam as $key => $value)
									<option value="{{$value}}"{{ ( $value == $selectedProjectTeam) ? 'selected' : '' }}>{{ $value}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-3">
							<label for="Project_Status">Project Status</label>
							<select name="Project_Status" class="form-control" id="Project_Status">
								<option disabled selected></option>
								@foreach ($dropDownProjectStatus as $key => $value)
									<option value="{{$value}}"{{ ( $value == $selectedProjectStatus) ? 'selected' : '' }}>{{ $value}}</option>
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
					<table id="project" class="table table-striped table-bordered" data-page-length="20" max-width =  "10px">
						<thead>
							<tr>
								<th>ID</th>
								<th>JT Project Code</th>
								<th>Project Short name</th>
								<th>Project Title</th>
								<th>Project Contract No</th>
								<th>Project Type</th>
								<th>Project Team</th>
								<th>Project Status</th>
								<th>View WO</th>
								<th>View Purchase Order</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $item)
								<tr>
									<td>{{$item->Project_ID}}</td>
									<td>{{$item->Project_Code}}</td>
									<td>{{$item->Project_Short_name}}</td>
									<td>{{$item->Project_Title}}</td>
									<td>{{$item->Project_Contract_No}}</td>
									<td>{{$item->project_type}}</td>
									<td>{{$item->project_team}}</td>
									<td>{{$item->Project_Status}}</td>
									<td>
										<a class="btn btn-xs btn-primary" href="{{ route('project-registry.displayWorkorder', ['project_code'=>$item->Project_Code],) }}"><i class="fa fa-eye"> View WO ({{count($item->getWO)}})</i></a>
									</td>
									<td>
										<a class="btn btn-xs btn-primary" href="{{ route('project-registry.displayPO', ['project_code'=>$item->Project_Code],) }}"><i class="fa fa-eye"> View PO </i></a>
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
		$('#Project_Code').select2({placeholder: "Select Project Code", allowClear: true, width: '100%'});
		$('#project_type').select2({placeholder: "Select Project Type", allowClear: true, width: '100%'});
		$('#project_team').select2({placeholder: "Select Project Team", allowClear: true, width: '100%'});
		$('#Project_Status').select2({placeholder: "Select Project Status", allowClear: true, width: '100%'});

		$('#project').DataTable( {
			dom: 'Bfrtip',
			buttons: ['copy', 'csv', 'excel', 'print'],
			searching: false
		} );
	} );
</script>
@endsection