@extends('layouts.app')

<?php
	if(isset($data)) {
		$title = 'Edit Member Profile';
		$submiturl = route('members-management.update', $data->id);
		$method = 'put';
		$edit = true;
	} else {
		$title = 'Add New Member';
		class dumpdata extends Eloquent {}
		$data = new dumpdata;
		$submiturl = route('members-management.store');
		$method = 'post';
		$edit = false;
	}
	$breadcrumb = [
		[
			'name'=>'Members Management',
			'url'=>'members-management'
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
						{{Form::model($data, ['url'=>$submiturl, 'method'=>$method, 'class'=>'form-horizontal'])}}
							<h3>Member Profile</h3>
							<hr/>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="employee_code" class="col-sm-3 control-label">Employee Code:<span class="required">*</span></label>
										<div class="col-sm-9">
											{{Form::text('employee_code', null, ['class'=>'form-control', 'required'])}}
										</div>
									</div>
									<div class="form-group">
										<label for="employee_name" class="col-sm-3 control-label">Employee Name:<span class="required">*</span></label>
										<div class="col-sm-9">
											{{Form::text('employee_name', null, ['class'=>'form-control', 'required'])}}
										</div>
									</div>
									<div id="position">
										<div class="form-group position">
											<label for="position" class="col-sm-3 control-label">Position:<span class="required">*</span></label>
											<div class="col-sm-9">
												{{Form::select("position", $position, $data->position, ['class'=>'form-control', 'placeholder'=>'Please select', 'required'])}}
											</div>
										</div>
									</div>
									
									<?php
										if($edit) {
											$departments = explode(', ', $data->department);
										} else {
											$departments = [
												0 => ''
											];
										}
									?>
									<div id="department">
										@foreach($departments as $key => $d)
											<div class="form-group department">
												<label for="department" class="col-sm-3 control-label">Department {{$key+1}}:<span class="required">*</span></label>
												<div class="col-sm-9">
													{{Form::select("department[$key]", $department, $d, ['class'=>'form-control', 'placeholder'=>'Please select', 'required'])}}
												</div>
											</div>
										@endforeach
									</div>
									<p style="text-align: right;">
										<a href="#" onclick="add('department')">+ Add department</a>
									</p>
									<p id="remove_department" style="text-align: right; display: {{count($departments) > 1 ? 'block' : 'none'}};">
										<a href="#" onclick="remove('department')">- Remove last department</a>
									</p>
									<div class="form-group">
										<label for="mbr_email" class="col-sm-3 control-label">E-mail:<span class="required">*</span></label>
										<div class="col-sm-9">
											{{Form::email('mbr_email', null, ['class'=>'form-control', 'required'])}}
										</div>
									</div>
									<div class="form-group">
										<label for="image" class="col-sm-3 control-label">Image</label>
										<div class="col-sm-9">
											<div class="needsclick dropzone" id="document-dropzone">
		
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="username" class="col-sm-3 control-label">Username:<span class="required">*</span></label>
										<div class="col-sm-9">
											{{Form::text('username', null, ['class'=>'form-control', 'required'])}}
										</div>
									</div>
									@if ($title == 'Add New Member')
									<div class="form-group">
									<label for="username" class="col-sm-3 control-label">Password:<span class="required">*</span></label>
									<div class="col-sm-9">
										{{ Form::password('password', array('id' => 'password', "class" => "form-control", "autocomplete" => "off")) }}
									</div>
									</div>
									<div class="form-group">
										<label for="username" class="col-sm-3 control-label">Confirm Password:<span class="required">*</span></label>
										<div class="col-sm-9">
											{{ Form::password('confirmation', array('id' => 'confirmation', "class" => "form-control", "autocomplete" => "off")) }}
										</div>
										</div>	
									@else
									<div class="form-group">
									<label for="username" class="col-sm-3 control-label">Update Password:</label>
									<div class="col-sm-9">
										{{ Form::password('password', array('id' => 'password', "class" => "form-control", "autocomplete" => "off")) }}
									</div>
									</div>
									<div class="form-group">
										<label for="username" class="col-sm-3 control-label">Confirm Password:</label>
										<div class="col-sm-9">
											{{ Form::password('confirmation', array('id' => 'confirmation', "class" => "form-control", "autocomplete" => "off")) }}
										</div>
										</div>	
									@endif
									<div class="form-group">
										<label for="firstname" class="col-sm-3 control-label">Firstname:</label>
										<div class="col-sm-9">
											{{Form::text('firstname', null, ['class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group">
										<label for="lastname" class="col-sm-3 control-label">Lastname:</label>
										<div class="col-sm-9">
											{{Form::text('lastname', null, ['class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group">
										<label for="nickname" class="col-sm-3 control-label">Nickname:</label>
										<div class="col-sm-9">
											{{Form::text('nickname', null, ['class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group">
										<label for="status" class="col-sm-3 control-label">Status:</label>
										<div class="col-sm-9">
											{{Form::select('status', ['Active'=>'Active', 'Deactived'=>'Deactived'], null, ['class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group">
										<label for="company_id" class="col-sm-3 control-label">SubCon Company:</label>
										<div class="col-sm-9">
											{{Form::select('company_id', $subconList, null, ['class'=>'form-control', 'placeholder'=>'Select for Subcon Account'])}}

										</div>
									</div>
								</div>
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
	var uploadedDocumentMap = {}
  	Dropzone.options.documentDropzone = {
    	url: '{{route("members.uploadImage")}}',
		maxFilesize: 1, // MB
		maxFiles: 1,
    	addRemoveLinks: true,
		headers: {
		'X-CSRF-TOKEN': "{{ csrf_token() }}"
		},
		success: function (file, response) {
		$('form').append('<input type="hidden" name="image" value="' + response.name + '">')
		uploadedDocumentMap[file.name] = response.name
		},
		removedfile: function (file) {
		file.previewElement.remove()
		var name = ''
		if (typeof file.file_name !== 'undefined') {
			name = file.file_name
		} else {
			name = uploadedDocumentMap[file.name]
		}
		$('form').find('input[name="image"][value="' + name + '"]').remove()
		},
		init: function () {
			@if(isset($data) && $data->image)
				let mockFile = { name: "", size: 123450 };
				let resizeThumbnail = true;
				this.displayExistingFile(mockFile, '{{url("/")}}/upload/members/{{$data->image}}', resizeThumbnail);

				
			@endif
			this.on("removedfile", function (file) {
				$.post({
					url: '{{route("members.deleteImage")}}',
					data: {id: file.name, _token: $('[name="_token"]').val()},
					dataType: 'json',
					success: function (data) {
						total_photos_counter--;
						$("#counter").text("# " + total_photos_counter);
					}
				});
			});
    	}
 	}

		function add(type) {
			var main = document.getElementById(type),
				div = document.createElement('div'),
				i = $('.'+type).length,
				t = parseInt(i + 1),
				html;
			html = '<div class="form-group '+type+'"><label for="'+type+'" class="col-sm-3 control-label">'+titleCase(type)+' '+t+':<span class="required">*</span></label><div class="col-sm-9"><select name="'+type+'['+i+']" class="form-control" required><option value="">Please select</option>';
			if(type == 'department') {
				html = html + '@foreach($department as $d)<option value="{{$d}}">{{$d}}</option>@endforeach';
			} else if(type == 'position') {
				html = html + '@foreach($position as $p)<option value="{{$p}}">{{$p}}</option>@endforeach';
			}
			div.innerHTML = html+'</select></div></div>';
			main.appendChild(div);
			showHideRemove(type)
		}

		function remove(type) {
			var count = $('.'+type).length;
			if(count > 1) {
				$('#'+type+' .'+type).slice(-1).remove();
			}
			showHideRemove(type);
		}

		function showHideRemove(type) {
			var count = $('.'+type).length;
			if(count > 1) {
				$('#remove_'+type).show();
			} else {
				$('#remove_'+type).hide();
			}
		}

		function titleCase(string) {
			return string.charAt(0).toUpperCase() + string.slice(1);
		}

		

		function preDeleteFile(e) {
			forms.deleteFile(e);
		}
	</script>
@endsection
