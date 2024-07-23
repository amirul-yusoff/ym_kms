<?php
	// example for the input type to use with modal.
	// 1. text
	// 	[
	// 		'type'=>'text',
	// 		'name'=>'name',
	// 		'label'=>'label',
	// 		'required'=>true or false,
	// 		'id'=>'id',
	// 		'readonly'=>true or false
	// 	]
	// 2. textarea
	// 	[
	// 		'type'=>'textarea',
	// 		'name'=>'name',
	// 		'label'=>'label',
	// 		'required'=>true or false
	// 	]
	// 3. datepicker
	// 	[
	// 		'type'=>'datepicker',
	// 		'name'=>'name',
	// 		'label'=>'label',
	// 		'required'=>true or false
	// 	]
	// 4. checkbox
	// 	[
	// 		'type'=>'checkbox',
	// 		'name'=>'name',
	// 		'label'=>'label',
	// 		'required'=>true or false,
	// 		'id'=>'id',
	// 		'value'=>'value'
	// 	]
	// 5. select
	// 	[
	// 		'type'=>'select',
	// 		'name'=>'name',
	// 		'label'=>'label',
	// 		'required'=>true or false,
	// 		'select'=>'select',
	// 		'id'=>'id'
	// 	]
	// 6. custom_select
	// 	[
	// 		'type'=>'custom_select',
	// 		'name'=>'name',
	// 		'label'=>'label',
	// 		'required'=>true or false,
	// 		'select'=>'select',
	// 		'id'=>'id',
	// 		'value'=>'value',
	// 		'o_name'=>'o_name, o_name'
	// 	]
	// 7. hidden
	// 	[
	// 		'type'=>'custom_select',
	// 		'name'=>'name',
	// 		'value'=>'value'
	// 	]
?>
<div class="modal fade" id="{{$modalId}}" tabindex="-1" role="dialog" aria-labelledby="{{$modalId}}Label">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="{{$modalId}}Label"></h4>
			</div>
			<div class="modal-body">
				{{Form::open(['id'=>$formName, 'class'=>'form-horizontal'])}}
					<h3></h3>
					<hr>
					<input type="hidden" name="_method">

					@foreach($form as $f)
						@if($f['type'] == 'hidden')
							<input type="hidden" name="{{$f['name']}}" value="{{$f['value']}}">
						@else
							<div class="form-group">
								<label for="{{$f['name']}}" class="col-sm-3 control-label">{{$f['label']}}:@if($f['required'])<span class="required">*</span>@endif</label>
								<div class="col-sm-9">
									@if($f['type'] == 'select')
										{{Form::select($f['name'], $f['select'], null, ['class'=>'form-control', 'id'=>isset($f['id']) ? $f['id'] : null, $f['required'] ? 'required' : null, 'placeholder'=>'Please select'])}}
									@elseif($f['type'] == 'custom_select')
										<select class="form-control" name="{{$f['name']}}" id="{{isset($f['id']) ? $f['id'] : null}}">
											<option value="">Please select</option>
											@if($f['value'] == 'value')
												@foreach($f['select'] as $value => $s)
													<option value="{{$value}}" data-name="{{$s}}">{{$value}}&nbsp;|&nbsp;{{$s}}</option>
												@endforeach
											@else
												@foreach($f['select'] as $s)
													<option value="{{$s->$f['value']}}">
														<?php
															$o_name = explode(',', $f['o_name']);
														?>
														{{$s->$o_name[0]}}@if($o_name[1])&nbsp;|&nbsp;{{$s->$o_name[1]}}@endif
													</option>
												@endforeach
											@endif
										</select>
									@elseif($f['type'] == 'checkbox')
										{{Form::checkbox($f['name'], $f['value'], false, ['class'=>'checkbox_custom', 'id'=>$f['id']])}}
									@elseif($f['type'] == 'datepicker')
										<div class="input-group">
											{{Form::text($f['name'], null, ['class'=>'form-control datepicker', $f['required'] ? 'required' : null])}}
											<span class="input-group-addon">
												<span class="fa fa-calendar"></span>
											</span>
										</div>
									@elseif($f['type'] == 'textarea')
										{{Form::textarea($f['name'], null, ['class'=>'form-control textarea_custom', 'rows'=>'3', $f['required'] ? 'required' : null])}}
									@else
										{{Form::text($f['name'], null, ['class'=>'form-control', $f['required'] ? 'required' : null])}}
									@endif
								</div>
							</div>
						@endif
					@endforeach
					@if(isset($selfSubmit))
						<button id="submit-form" class="btn btn-primary" type="button">
							Submit
						</button>
					@else
						{{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
					@endif
					<br/>
					<br/>
					<i class="created_by"></i>
				{{Form::close()}}
			</div>
		</div>
	</div>
</div>
