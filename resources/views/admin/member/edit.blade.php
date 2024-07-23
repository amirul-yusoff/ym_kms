@extends('layouts.app')

@section('title', $title)

@section('content')
@include('partials.breadcrumb')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="">
		{{Form::model($member, array('route' => array('admin.members.update', $member->id), 'method' => 'PUT', 'enctype'=>"multipart/form-data"))}}
		{{Form::hidden('id', $member->id)}}
		@include('partials.message')
		<div class="row">
			<div class="col-sm-4">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Primary Information:</h5>
					</div>
					<div class="ibox-content">
                        <div class="form-group row {{ $errors->has('employee_code') ? 'has-error' : '' }}">
							<label for="employee_code" class="col-sm-4 form-control-label"><span class="required">*</span>{{ trans('cruds.member.fields.employee_code') }} :</label>
							<div class="col-sm-8 ">
                                {{Form::text('employee_code', null, ['class'=>'form-control form-control-sm', 'required','readonly'])}}
                                @if($errors->has('employee_code'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('employee_code') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.member.fields.employee_code_helper') }}
                                </p>
							</div>
                        </div>
                        <div class="form-group row {{ $errors->has('employee_name') ? 'has-error' : '' }}">
							<label for="employee_name" class="col-sm-4 form-control-label"><span class="required">*</span>{{ trans('cruds.member.fields.employee_name') }} :</label>
							<div class="col-sm-8 ">
                                {{Form::text('employee_name', null, ['class'=>'form-control form-control-sm', 'required','readonly'])}}
                                @if($errors->has('employee_name'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('employee_name') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.member.fields.employee_name_helper') }}
                                </p>
							</div>
                        </div>
                        <div class="form-group row {{ $errors->has('roles') ? 'has-error' : '' }}">
                            <label for="roles" class="col-sm-4 form-control-label"><span class="required">*</span>{{ trans('cruds.member.fields.roles') }} :
                                <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span>
                            </label>
                            <div class="col-sm-8 ">
                                <select name="roles[]" id="roles" class="form-control chosen-select" multiple="multiple" required>
                                    @foreach($roleList as $id => $roles)
                                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($member) && $member->roles()->pluck('name', 'id')->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('roles'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('roles') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.member.fields.roles_helper') }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('mbr_email') ? 'has-error' : '' }}">
                            <label for="mbr_email" class="col-sm-4 form-control-label"><span class="required">*</span>{{ trans('cruds.member.fields.email') }} :</label>
                            <div class="col-sm-8 ">
                                {{Form::text('mbr_email', null, ['class'=>'form-control form-control-sm', 'required'])}}
                                @if($errors->has('mbr_email'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('mbr_email') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.member.fields.email_helper') }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('is_active') ? 'has-error' : '' }}">
                            <label for="is_active" class="col-sm-4 form-control-label"><span class="required">*</span>{{ trans('cruds.member.fields.is_active') }} :</label>
                            <div class="col-sm-8 ">
                                {{Form::select("is_active", [1=>'Active', 0=>'Deactivated'], null, ['class'=>'form-control', 'required'])}}
                                @if($errors->has('is_active'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('is_active') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.member.fields.is_active_helper') }}
                                </p>
                            </div>
                        </div>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Secondary Information</h5>
					</div>
					<div class="ibox-content">
                        <div class="form-group row">
                            <label for="company_id" class="col-sm-4 form-control-label">Company :</label>
                            <div class="col-sm-8 ">
                                <select name="company_id" class="form-control" id="company_id" required>
                                    <option value="{{$member->company_id}}">{{$companyName}}</option>
                                    @foreach ($companyList as $company)
                                        <option value="{{$company->id}}">{{$company->Co_Name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                            <label for="image" class="col-sm-4 form-control-label">{{ trans('cruds.member.fields.image') }} :</label>
                            <div class="col-sm-8 ">
                                {{Form::file("image", null, ['class'=>'form-control'])}}
                                @if($errors->has('image'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('image') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.member.fields.image_helper') }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('password') ? 'has-error' : '' }}">
                            <label for="password" class="col-sm-4 form-control-label">{{ trans('cruds.member.fields.password') }}</label>
                            <div class="col-sm-8 ">
                                {{ Form::password('password', array('id' => 'password', "class" => "form-control", "autocomplete" => "off")) }}
                                @if($errors->has('password'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.member.fields.password_helper') }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                            <label for="password_confirmation" class="col-sm-4 form-control-label">{{ trans('cruds.member.fields.confirmation') }}</label>
                            <div class="col-sm-8 ">
                                {{ Form::password('password_confirmation', array('id' => 'password_confirmation', "class" => "form-control", "autocomplete" => "off")) }}
                                @if($errors->has('password_confirmation'))
                                    <em class="invalid-feedback">
                                        {{ $errors->first('password_confirmation') }}
                                    </em>
                                @endif
                                <p class="helper-block">
                                    {{ trans('cruds.member.fields.confirmation_helper') }}
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
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
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