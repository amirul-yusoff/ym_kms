@extends('layouts.app')

<?php
	$submiturl = route('reset-password.update', $data->id);
	$method = 'put';
	$edit = true;
	$title = 'Change User Password';
	$breadcrumb = [
		[
			'name'=>'User Profile',
			'url'=>'member/'.$data->id
		],
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
					</div>
					<div class="ibox-content">
						@include('partials.message')
						<h4>{{$data->employee_name}}<span style="margin-left: 50px;">{{$data->employee_code}}</span></h4>
						<hr/>
						{{Form::model($data, ['url'=>$submiturl, 'method'=>$method, 'class'=>'form-horizontal'])}}
							<div class="row">
								<div class="col-sm-8">
									<div class="form-group">
										<label for="current_password" class="col-sm-3 control-label">Current Password:</label>
										<div class="col-sm-9">
											<input type="password" name="current_password" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label for="password" class="col-sm-3 control-label">New Password:</label>
										<div class="col-sm-9">
											<input type="password" name="password" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label for="password_confirmation" class="col-sm-3 control-label">Confirm New Password:</label>
										<div class="col-sm-9">
											<input type="password" name="password_confirmation" class="form-control">
										</div>
									</div>
									<button class="btn btn-primary" type="submit">
										<i class="fa fa-floppy-o"></i>
										Submit
									</button>
								</div>
							</div>
						{{Form::close()}}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
