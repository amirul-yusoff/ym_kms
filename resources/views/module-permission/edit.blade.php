@extends('layouts.app')
@section('title', $title)
@section('content')
@include('partials.breadcrumb')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="wrapper wrapper-content animated fadeInRight">
	@include('partials.message')
	<div class="row">
		<div class="col-lg-12">
			<div class="float-e-margins">
				<div class="ibox-title">
					<h5>{{ $title }}</h5>
					<div class="ibox-tools">
							{{-- <a href="{{route('request-manpower.print')}}" class="btn btn-xs btn-primary">
								<i class="fa fa-plus"></i> Print
							</a> --}}
					</div>
					<div class="ibox-content">
        				<div class="row">
							{{ Form::open(array('route' => ['request-manpower.update', $data->id], 'files' => true))}}
							{{ Form::hidden('id', $data->id) }}
							{{ method_field('PUT') }}
							<div class="col-sm-6">
								<div class="form-group">
									<label for="date" class="col-sm-4 control-label">Date :</label>
									<div class="col-sm-8">
										{{ Form::text('date', $currentDateTime, ['class' => 'form-control ','readonly']) }}
									</div>
								</div><br><br>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="createdby" class="col-sm-4 control-label">Issued by :</label>
									<div class="col-sm-8">
										{{ Form::text('created_by', $user->employee_code, ['class' => 'form-control ','readonly']) }}
									</div>
								</div><br><br>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
										<label for="parent_id" class="col-sm-4 control-label">Parent ID :</label>
										<div class="col-sm-8">
											<select name="parent_id" class="form-control" id="parent_id" required>
												<option value="">Please Select Parent ID</option>
												@foreach ($data as $item)
													<option value="{{$item->id}}">{{$item->module_name}}</option>
												@endforeach
											</select>
										</div>
								</div><br><br>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
                    				<i style="color: #d10000;">Need To<b>'Choose'</b> permission</i>
									<label for="permissions" class="col-sm-4 control-label">Permission :</label>
									<div class="col-sm-8">
										<select name="permissions" class="form-control" id="permissions" required>
											<option value="">Please Select Permission</option>
											@foreach ($permissions as $permission)
												<option value="{{$permission->id}}">{{$permission->name}}</option>
											@endforeach
										</select>
									</div>
								</div><br><br>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="module_name" class="col-sm-4 control-label">Module Name :</label>
									<div class="col-sm-8">
										{{ Form::text('module_name', NULL, ['class' => 'form-control ']) }}
									</div>
								</div><br><br>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="description" class="col-sm-4 control-label">Description :</label>
									<div class="col-sm-8">
										{{ Form::text('description', NULL, ['class' => 'form-control ']) }}
									</div>
								</div><br><br>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
                    					<i style="color: #d10000;">Need To KeyIn<b>'module-permission'</b> for URL</i>
										<label for="url" class="col-sm-4 control-label">Url :</label>
									<div class="col-sm-8">
										{{ Form::text('url', NULL, ['class' => 'form-control ']) }}
									</div>
								</div><br><br>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
                    				<i style="color: #d10000;">Only KeyIn <b>'laptop'</b> not <b>'fa fa-laptop'</b></i>
									<label for="icon" class="col-sm-4 control-label">Icon :</label>
									<div class="col-sm-8">
										{{ Form::text('icon', NULL, ['class' => 'form-control ']) }}
									</div>
								</div><br><br>
							</div>
							<div class="col-sm-12">
								<button id="submitButton" button class="btn btn-primary" type="submit">
									<i class="fa fa-plus"> </i>
									Save
								</button>
							</div>
							{{Form::close()}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>
@endsection

@section('script')
<script type="text/javascript">
	const BaseURL = "{{ url('/') }}"
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/request-manpower/nameListEdit.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/request-manpower/jobScopeListEdit.js') }}" charset="utf-8"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
			$('#name_sbu_se').select2();
			$('#project_code').select2();
		});
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