@extends('layouts.app')
@section('title', $title)

@section('content')
@include('partials.breadcrumb')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="">
		{{ Form::open(['url' => 'admin/roles','id' => 'create']) }}
		@include('partials.message')
		<div class="row">
			<div class="col-sm-4">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Primary Information:</h5>
					</div>
					<div class="ibox-content">
						<div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
							<label for="name" class="col-sm-4 form-control-label"><span class="required">*</span>{{ trans('cruds.role.fields.title') }} :</label>
							<div class="col-sm-8 ">
                                {{Form::text('name', null, ['class'=>'form-control form-control-sm', 'required'])}}
                                @if($errors->has('name'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.role.fields.title_helper') }}
                                </p>
							</div>
                        </div>
                        
                        <div class="form-group row {{ $errors->has('permission') ? 'has-error' : '' }}">
							<label for="permission" class="col-sm-4 form-control-label"><span class="required">*</span>{{ trans('cruds.role.fields.permissions') }} :</label>
							<div class="col-sm-8 ">
                                {{Form::select('permission[]', $permissionLists, null,['multiple' => true, 'class'=>"chosen-select", 'required', 'style'=>"width:350px;", 'tabindex'=>"4"])}}
                                
                                @if($errors->has('permission'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('permission') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.role.fields.title_helper') }}
                                </p>
							</div>
                        </div>
					</div>
				</div>
			</div>
			
			<div class="col-sm-4">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Usage Tips</h5>
					</div>
					<div class="ibox-content">
						<ul>
							<li>Fields marked with * is required</li>
						</ul>
						
						<br/>
						
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<button class="btn btn-primary" type="submit">
					<i class="fa fa-floppy-o"></i>
					{{ trans('global.save') }}
				</button>
			</div>
		</div>
		{{ Form::close() }}
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function()
{
    $('.chosen-select').chosen({width: "100%"});
});

</script>	
@endsection




