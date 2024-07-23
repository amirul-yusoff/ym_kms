@extends('layouts.app')
@section('content')
@include('partials.breadcrumb')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5></h5>
                    <div class="ibox-tools">
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="card-header">
                        {{ trans('cruds.role.title_singular') }} {{ trans('global.list') }}
                    </div>
                    <table id="data_table" class="table table-striped table-bordered" data-page-length="25">
                        <tbody>
                            <tr>
                                <th>
                                    {{ trans('cruds.role.fields.id') }}
                                </th>
                                <td>
                                    {{ $role->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.role.fields.title') }}
                                </th>
                                <td>
                                    {{ $role->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Permissions
                                </th>
                                <td>
                                    @foreach($role->permissions()->pluck('name') as $permission)
                                        <span class="label label-info label-many">{{ $permission }}</span>
                                    @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>

                <nav class="mb-3">
                    <div class="nav nav-tabs">

                    </div>
                </nav>
                <div class="tab-content">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection