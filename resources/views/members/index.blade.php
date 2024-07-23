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
						<div class="ibox-tools">
							@if ($createButton)
								<a href="{{route($url.'.create')}}" class="btn btn-xs btn-primary">
									<i class="fa fa-plus"></i> Create New Member
								</a>
							@endif
						</div>
					</div>
					<div class="ibox-content">
						<table id="data_table" class="table table-striped table-bordered" data-page-length="25">
							<thead>
								<tr>
									<th>#</th>
									<th>Image</th>
									<th>Employee Code</th>
									<th>Employee Name</th>
									<th>Department</th>
									<th>Position</th>
									<th>Status</th>
									<th width="200px"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($members as $key => $member)
									<tr>
										<td>{{$key + 1}}</td>
										<td class="member-image">
											@if(!is_null($member->image) && $member->image != '')
											{{Html::image('/upload/members/thumbnail/'.$member->image, $member->employee_name, ['class' => 'img-circle img-sm'])}}
										@else
											{{Html::image('/image/no-image.png', $member->employee_name, ['class' => 'img-circle img-sm'])}}
										@endif
										</td>
										<td>{{$member->employee_code}}</td>
										<td>{{$member->employee_name}}</td>
										<td>{{$member->department}}</td>
										<td>{{$member->position}}</td>
										<td>{{$member->status}}</td>
										<td>
											{{Form::open(['class'=>'pull-right', 'method'=>'delete', 'route'=>['members-management.destroy', $member->id]])}}
												@if ($editButton)
													<a href="{{url('members-management/'.$member->id.'/edit')}}" class="btn btn-xs btn-success">
														<i class="fa fa-pencil"></i> Edit
													</a>
												@endif
												@if ($deleteButton)
													<button type="submit" class="btn btn-xs btn-danger">
														<i class="fa fa-trash"></i> Delete
													</button>
												@endif
											{{Form::close()}}
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