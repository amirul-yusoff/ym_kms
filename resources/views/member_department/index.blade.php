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
								<button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#departmentModal">
									<i class="fa fa-plus"></i> Create New Department
								</button>
							@endif
						</div>
					</div>
					<div class="ibox-content">
						<table id="data_table" class="table table-striped table-bordered" data-page-length="25">
							<thead>
								<tr>
									<th width="30px">#</th>
									<th>Department Name</th>
									<th width="200px"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($memberDepartments as $key => $memberDepartment)
									<tr>
										<td>{{$key + 1}}</td>
										<td>{{$memberDepartment->department_name}}</td>
										<td>
											{{Form::open(['class'=>'pull-right', 'method'=>'delete', 'route'=>['member-department.destroy', $memberDepartment->id]])}}
												@if ($editButton)
													<button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#departmentModal" data-department="{{$memberDepartment}}">
														<i class="fa fa-pencil"></i> Edit
													</button>
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
	<?php
		$modalId = 'departmentModal';
		$formName = 'department_form';
		$form = [
			[
				'type'=>'text',
				'name'=>'department_name',
				'label'=>'Department',
				'required'=>true
			]
		];
	?>
	@include('partials.modal')
@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
			$('#departmentModal').on('show.bs.modal', function(event) {
				var button = $(event.relatedTarget);
				var data = button.data('department');
				var modal = $(this);
				modal.find('h3').text('Member Department Details');
				if(data !== undefined) {
					modal.find('input[name=department_name]').val(data['department_name']);
					modal.find('#department_form').attr('action', 'member-department/'+data['id']);
					modal.find('input[name=_method]').val('put');
					modal.find('.modal-title').text('Edit Member Department');
					modal.find('.created_by').text('Created by '+data['created_by']+' at '+data['created_at']+'.');
				} else {
					modal.find('input[name=department_name]').val('');
					modal.find('#department_form').attr('action', 'member-department');
					modal.find('input[name=_method]').val('post');
					modal.find('.modal-title').text('Add Member Department');
					modal.find('.created_by').text('');
				}
			});
		});
	</script>
@endsection