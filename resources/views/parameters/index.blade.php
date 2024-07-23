@extends('layouts.app')
<?php
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
							@if ($createButton)
								<button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#categoryModal">
									<i class="fa fa-plus"></i> Create {{$title.' '.$modelTitle}}
								</button>
							@endif
						</div>
					</div>
					<div class="ibox-content">
						@include('partials.message')
						<input type="hidden" id="pageData" data-url="{{$url}}" data-title="{{$title}}" data-modelTitle="{{$modelTitle}}">

						<table id="data_table" class="table table-striped table-bordered" data-page-length="25">
							<thead>
								<tr>
									<th width="20px">#</th>
									<th>{{$title.' '.$modelTitle}}</th>
									<th width="200px"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($data as $key => $d)
									<tr>
										<td>{{$key + 1}}</td>
										<td>
											<text type="button" data-toggle="modal" data-target="#categoryModal" data-category="{{$d}}">
												{{$d->Item}}
											</text>
										</td>
										<td>
											{{Form::open(['class'=>'pull-right', 'method'=>'delete', 'route'=>[$url.'.destroy', $d->Parameter_ID]])}}
											@if ($createButton)
													<button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#categoryModal" data-category="{{$d}}">
														<i class="fa fa-pencil"></i> Edit
													</button>
												@endif
												@if ($createButton)
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
		$modalId = 'categoryModal';
		$formName = 'category_form';
		$form = [
			[
				'type'=>'text',
				'name'=>'Item',
				'label'=>$modelTitle,
				'required'=>true
			]
		];
	?>
	@include('partials.modal')
@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
			$('#categoryModal').on('show.bs.modal', function(event) {
				var button = $(event.relatedTarget);
				var data = button.data('category');
				var modal = $(this);
				var submitTo = $('#pageData').data('url');
				var title = $('#pageData').data('title');
				var modelTitle = $('#pageData').data('modelTitle');

				modal.find('h3').text(title+' Details');
				if(data !== undefined) {
					modal.find('input[name=Item]').val(data['Item']);
					modal.find('#category_form').attr('action', submitTo+'/'+data['Parameter_ID']);
					modal.find('input[name=_method]').val('put');
					modal.find('.modal-title').text('Edit '+title);
					modal.find('.created_by').text('Created by '+data['created_by']+' at '+data['created_at']+'.');
				} else {
					modal.find('input[name=Item]').val('');
					modal.find('#category_form').attr('action', submitTo);
					modal.find('input[name=_method]').val('post');
					modal.find('.modal-title').text('Add '+title);
					modal.find('.created_by').text('');
				}
			});

			$('#categoryModal').on('shown.bs.modal', function () {
			    $('input[name=Item]').focus();
			})
		});
	</script>
@endsection