@extends('layouts.admin')
@section('title', $title)

@section('content')
    @include('partials.breadcrumb')
    <div class="wrapper wrapper-content animated fadeInRight">
        @include('partials.message')
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5></h5>
                        <div class="ibox-tools"></div>
                    </div>
                    <div class="ibox-content">
                        <div class="card">
                            <div class="card-header">
                                {{ trans('global.show') }} {{ trans('cruds.member.title') }}
                            </div>

                            <div class="card-body">
                                <div class="mb-2">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th>
                                                    {{ trans('cruds.member.fields.id') }}
                                                </th>
                                                <td>
                                                    {{ $member->id }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    {{ trans('cruds.member.fields.name') }}
                                                </th>
                                                <td>
                                                    {{ $member->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    {{ trans('cruds.member.fields.email') }}
                                                </th>
                                                <td>
                                                    {{ $member->email }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Roles
                                                </th>
                                                <td>
                                                    @foreach($member->roles()->pluck('name') as $role)
                                                        <span class="label label-info label-many">{{ $role }}</span>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                                        {{ trans('global.back_to_list') }}
                                    </a>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection