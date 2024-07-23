@extends('layouts.app')

<?php
	$color = [
		'Active' => 'primary',
		'Deactived' => 'danger'
	];
	$title = 'User Profile';
	$breadcrumb = [
		[
			'name'=>$title
		]
	];
?>
@section('title', $title)

@section('content')
	@include('partials.breadcrumb')
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>{{$title}}</h5>
						<div class="ibox-tools">
							<a href="{{url('member/'.$member->id.'/edit')}}" class="btn btn-xs btn-info">
								<i class="fa fa-edit"></i> Edit Profile
							</a>
							<a href="{{url('member/password-reset/'.$member->id)}}" class="btn btn-xs btn-info pull-right">
								<i class="fa fa-refresh"></i> Change Password
							</a>
						</div>
					</div>
					<div class="ibox-content">
						<h4>{{$member->employee_name}}<span style="margin-left: 50px;">{{$member->employee_code}}</span></h4>
						<hr/>
						<div class="form-horizontal">
							<div class="row">
								<div class="col-sm-2">
									@if(!is_null($member->image) && $member->image != '')
										{{Html::image('/upload/members/thumbnail/'.$member->image, $member->employee_name, ['class' => 'img-circle img-sm'])}}
									@else
										{{Html::image('/image/no-image.png', $member->employee_name, ['class' => 'img-circle img-sm'])}}
									@endif
								</div>
								<div class="col-sm-8">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-sm-3">Company Code:</label>
											<div class="col-sm-9">
												<p>{{$member->employee_code}}</p>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3">Company Name:</label>
											<div class="col-sm-9">
												<p>{{$member->employee_name}}</p>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3">Username:</label>
											<div class="col-sm-9">
												<p>{{$member->username}}</p>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3">E-Mail:</label>
											<div class="col-sm-9">
												<p>{{$member->mbr_email}}</p>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-sm-3">Status:</label>
											<div class="col-sm-9">
												<span class="label label-{{$color[$member->status]}}">
													{{$member->status}}
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
