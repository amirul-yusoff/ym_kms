@extends('layouts.app')

<?php
	use App\Http\Models\permission;
	use App\Http\Models\special_permission;
?>
@section('title', $title)

@section('content')
	@include('partials.breadcrumb')
	<div class="wrapper wrapper-content animated fadeInRight">
		@include('partials.message')
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>{{$title}}</h5>
					</div>
					<div class="ibox-content">
						<h3>{{$member->employee_code}} - {{$member->employee_name}}</h3>
						{{Form::model($member, ['url'=>route('accessibility-control.update', $member->id), 'method'=>'put'])}}
							<input type="hidden" name="employee_code" value="{{$member->employee_code}}">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Module</th>
											<th>Description</th>
											<th width="10%">Create</th>
											<th width="10%">Read</th>
											<th width="10%">Update</th>
											<th width="10%">Delete</th>
										</tr>
									</thead>
									<tbody>
										@foreach($modules as $key => $moduleType)
											<tr style="background-color: #eee;">
												<th>{{$key}}</th>
												<th></th>
												<th><input type="checkbox" name="permission" class="checkbox_all create_{{str_replace(' ', '', $key)}}_all" section-name="create_{{str_replace(' ', '', $key)}}" /></li></th>
												<th><input type="checkbox" name="permission" class="checkbox_all read_{{str_replace(' ', '', $key)}}_all" section-name="read_{{str_replace(' ', '', $key)}}" /></li></th>
												<th><input type="checkbox" name="permission" class="checkbox_all update_{{str_replace(' ', '', $key)}}_all" section-name="update_{{str_replace(' ', '', $key)}}" /></li></th>
												<th><input type="checkbox" name="permission" class="checkbox_all delete_{{str_replace(' ', '', $key)}}_all" section-name="delete_{{str_replace(' ', '', $key)}}" /></li></th>
											</tr>
											@foreach($moduleType as $k => $m)
												<?php
													$permission = permission::where('employee_code', $member->employee_code)->where('module_id', $m->id)->where('isdelete', 0)->first();
												?>
					
												<tr id={{$m->id}}>
													<td><span style="margin-left: 2em;"></span>{{$k + 1}}. {{$m->module_name}}</td>
													<td>{{$m->description}}</td>
													<td class="centering">
														{{Form::checkbox($m->id.'[can_create]', -1, (isset($permission['can_create'])&&$permission['can_create']<0 ? true : false),array('class' => 'checkbox create_'.str_replace(' ', '', $key), 'section-name' => 'create_'.str_replace(' ', '', $key)))}}
													</td>
													<td class="centering">
														{{Form::checkbox($m->id.'[can_read]', -1, (isset($permission['can_read'])&&$permission['can_read']<0 ? true : false),array('class' => 'checkbox read_'.str_replace(' ', '', $key), 'section-name' => 'read_'.str_replace(' ', '', $key)))}}
													</td>
													<td class="centering">
														{{Form::checkbox($m->id.'[can_update]', -1, (isset($permission['can_update'])&&$permission['can_update']<0 ? true : false),array('class' => 'checkbox update_'.str_replace(' ', '', $key), 'section-name' => 'update_'.str_replace(' ', '', $key)))}}
													</td>
													<td class="centering">
														{{Form::checkbox($m->id.'[can_delete]', -1, (isset($permission['can_delete'])&&$permission['can_delete']<0 ? true : false),array('class' => 'checkbox delete_'.str_replace(' ', '', $key), 'section-name' => 'delete_'.str_replace(' ', '', $key)))}}
													</td>
												</tr>
												@foreach($m->submenu as $s)
													<?php
														$permission = permission::where('employee_code', $member->employee_code)->where('module_id', $s->id)->where('isdelete', 0)->first();
													?>
													<tr>
														<td><span style="margin-left: 4em;"></span><i class="fa fa-angle-double-right"></i> {{$s->module_name}}</td>
														<td>{{$s->description}}</td>
														<td class="centering">
															{{Form::checkbox($s->id.'[can_create]', -1, (isset($permission['can_create'])&&$permission['can_create']<0 ? true : false),array('class' => 'checkbox create_'.str_replace(' ', '', $key), 'section-name' => 'create_'.str_replace(' ', '', $key)))}}
														</td>
														<td class="centering">
															{{Form::checkbox($s->id.'[can_read]', -1, (isset($permission['can_read'])&&$permission['can_read']<0 ? true : false),array('class' => 'checkbox read_'.str_replace(' ', '', $key), 'section-name' => 'read_'.str_replace(' ', '', $key)))}}
														</td>
														<td class="centering">
															{{Form::checkbox($s->id.'[can_update]', -1, (isset($permission['can_update'])&&$permission['can_update']<0 ? true : false),array('class' => 'checkbox update_'.str_replace(' ', '', $key), 'section-name' => 'update_'.str_replace(' ', '', $key)))}}
														</td>
														<td class="centering">
															{{Form::checkbox($s->id.'[can_delete]', -1, (isset($permission['can_delete'])&&$permission['can_delete']<0 ? true : false),array('class' => 'checkbox delete_'.str_replace(' ', '', $key), 'section-name' => 'delete_'.str_replace(' ', '', $key)))}}
														</td>
													</tr>
												@endforeach
											@endforeach
										@endforeach
										<tr style="background-color: #eee;">
											<th colspan="6">Specials</th>
										</tr>
										
										@foreach($specialModules as $key => $specialModule)
											
											<?php
												$specialPermission = special_permission::where('employee_code', $member->employee_code)->where('module_id', $specialModule->id)->where('isdelete', 0)->first();
											?>
											
											<tr>
												<td><span style="margin-left: 2em;"></span><i>{{$key+1}}. </i> {{$specialModule->module_name}}</td>
												<td>{{$specialModule->description}}</td>
												@if(!is_null($specialPermission))
													<td>
														{{Form::checkbox($specialModule->id.'[permission]', 1, ($specialPermission['permission'] ? true : false),array('class' => 'selectAllspecial'))}}
													</td>
												@else
													<td>
														{{Form::checkbox($specialModule->id.'[permission]', 1, 0,array('class' => 'selectAllspecial'))}}
													</td>
												@endif
												<td colspan="3"></td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							<button class="btn btn-primary" type="submit">
								<i class="fa fa-floppy-o"></i>
								Submit
							</button>
						{{Form::close()}}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
<script type="text/javascript">
	
$(document).ready(function()
{
	// This need select2 jQeury, it is not yet deployed in Server side.
	// $('.js-example-basic-single').select2();
    $('.checkbox_all').click(function(e) {
		var sectionName = $(this).attr('section-name');
		
		if ($(this).is(':checked', true)) {
			$("." + sectionName).prop('checked', true);  
		} else {  
			$("." + sectionName).prop('checked', false);  
		}
		console.log(sectionName);
	});
	$('.checkbox').click(function() {
		var sectionName = $(this).attr('section-name');
		if ($('.' + sectionName + ':checked').length == $('.' + sectionName).length) {
			$('.' + sectionName + "_all").prop('checked', true);
		} else {
			$('.' + sectionName + "_all").prop('checked', false);
		}
		console.log(sectionName);
	});
});
</script>
@endsection