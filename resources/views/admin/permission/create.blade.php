@extends('layouts.app')
@section('title', $title)

@section('content')
@include('partials.breadcrumb')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="">
		{{ Form::open(['url' => $url,'id' => 'create']) }}
		@include('partials.message')
		<div class="row">
			<div class="col-sm-4">
				<div class="ibox">
					<div class="ibox-title">
						<h5>{{ trans('global.create') }} {{ trans('cruds.permission.title_singular') }} :</h5>
					</div>
					<div class="ibox-content">
						<div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
							<label for="name" class="col-sm-4 form-control-label"><span class="required">*</span>{{ trans('cruds.permission.fields.title') }} :</label>
							<div class="col-sm-8 ">
                                {{Form::text('name', null, ['class'=>'form-control form-control-sm', 'required'])}}
                                @if($errors->has('name'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.permission.fields.title_helper') }}
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