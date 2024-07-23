@extends('layouts.app')

<?php
	$color = [
		'Active' => 'primary',
		'Deactived' => 'danger'
	];

	$submiturl = route('member.update', $data->id);
	$method = 'put';
	$edit = true;
	$title = 'Edit User Profile';
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
									<div class="col-sm-6">
										<div class="form-group">
											<label for="username" class="col-sm-4 control-label">Username:</label>
											<div class="col-sm-8">
												<p class="text-label">{{$data->username}}</p>
											</div>
										</div>
										<div class="form-group">
											<label for="mbr_email" class="col-sm-4 control-label">E-Mail:</label>
											<div class="col-sm-8">
												<p class="text-label">{{$data->mbr_email}}</p>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-sm-4 control-label">Status:</label>
											<div class="col-sm-8">
												<p class="text-label">
													<span class="label label-{{$color[$data->status]}}">
														{{$data->status}}
													</span>
												</p>
											</div>
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

@section('script')
	<script type="text/javascript">
		$(function() {
			'use strict';

			$('#image').fileupload({
				url: '{{route("system.upload")}}?folder=upload/members',
				dataType: 'json',
				dropZone: $('#image .dropzone'),
				pasteZone: null,
				disableImageResize: true,
				imageMaxWidth: 1366,
				imageMaxHeight: 1080,
				acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
				maxNumberOfFiles: 1,
				singleFileUploads: false,
				getNumberOfFiles: function() {
					return $('#image .files div').size();
				},
				done: function(e, data) {
					forms.fileUploadDone('image', data, 1);
				}
			}).on('fileuploadadd', function(e, data) {
				forms.fileUploadAdd('image', data, 1);
			}).on('fileuploadprogressall', function(e, data) {
				$(this).find('#progress').show();
				var progress = parseInt(data.loaded / data.total * 100, 10);
				$('#image #progress .progress-bar').css('width', progress+'%');
				$('#progress_value').text(progress+'%');
			});

			if($('#imageinput').val() != '') {
				forms.fileUploadDone('image', $('#imageinput').val(), 1, 'true');
			}
		});

		function preDeleteFile(e) {
			forms.deleteFile(e);
		}
	</script>
@endsection
