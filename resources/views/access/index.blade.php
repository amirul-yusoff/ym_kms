@extends('layouts.app')
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
						<div class="ibox-tools"></div>
					</div>
					<div class="ibox-content">
						<table id="data_table" class="table table-striped table-bordered" data-page-length="25">
							<thead>
								<tr>
									<th width="20px">#</th>
									<th width="60px">Image</th>
									<th width="100px">Employee Code</th>
									<th>Employee Name</th>
									<th>Department</th>
									<th>Position</th>
									<th>Roles</th>
									<th width="50px"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($members as $key => $member)
									<tr>
										<td>{{$key + 1}}</td>
										<td class="member-image">
											@if(!is_null($member->image) && $member->image != '')
												{{Html::image('/upload/members/thumbnail/'.$member->image, null, ['class' => 'img-circle img-sm'])}}
											@else
												{{Html::image('/image/no-image.png', $member->employee_name, ['class' => 'img-circle img-sm'])}}
											@endif
										</td>
										<td>{{$member->employee_code}}</td>
										<td>{{$member->employee_name}}</td>
										<td>{{$member->department}}</td>
										<td>
											<?php $position = explode(', ', $member->position); ?>
											{{$position[0]}}
										</td>
										<td>
											@foreach($member->roles as $role)
												{{$role->name}}
											@endforeach
										</td>
										<td>
											@if	($editButton)
												<a href="{{route('accessibility-control.edit', $member->id)}}" class="btn btn-xs btn-success btn-edit pull-right">
													<i class="fa fa-pencil"></i> Edit
												</a>
											@endif
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