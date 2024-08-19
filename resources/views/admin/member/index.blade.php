@extends('layouts.admin')
@section('title', $title)

@section('content')
@include('partials.breadcrumb')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="wrapper wrapper-content animated fadeInRight">
    @include('partials.message')
    <style>
        .form-control {
            height: 30px;
        }
        .select2-container--default .select2-selection--single {
            border-radius: 4px;
            height: 30px;
            padding: 3px;
        }
        .has-value {
            background-color: #e0f7fa;
            border-color: #4caf50;
        }
        .select2-container.has-value .select2-selection {
            background-color: #e0f7fa;
            border-color: #4caf50;
        }
        .select2-container.no-value .select2-selection {
            background-color: #ffffff;
            border-color: #ced4da; 
        }
    </style>
    <div class="row">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{ $title }}</h5>
                @can('users_manage')
                    <div class="ibox-tools">
                        <a href="{{ route("admin.members.create") }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.member.title_singular') }}
                        </a>
                        <a href="{{ route('module-permission.index') }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-plus"></i> Add Module Permission
                        </a>                        
                    </div>
                @endcan
            </div>
            <div class="ibox-content">
                {{ Form::open(['route' => 'admin.members.index', 'method' => 'GET']) }}
					<div class="row">
						<div class="col-md-3">
							<label for="employee_code">Employee Code</label>
                            {{ Form::text('employee_code',  request('employee_code') ?? '' , ['class' => 'form-control', 'placeholder' => 'Employee Code']) }}      
						</div>        
                        <div class="col-md-3">
							<label for="company_id">Company Name</label>
							<select name="company_id" class="form-control" id="company_id">
								<option disabled selected></option>
								@foreach ($dropDownCompany as $key => $value)
									<option value="{{$value}}"{{ ( $value == $selectedCompany) ? 'selected' : '' }}>{{ $key }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-3">
							<label for="employee_name">Employee Name</label>
							{{ Form::text('employee_name',  request('employee_name') ?? '' , ['class' => 'form-control', 'placeholder' => 'Employee Name']) }}      
						</div>
						<div class="col-md-3">
							<label for="position">Position</label>
							<select name="position" class="form-control" id="position">
								<option disabled selected></option>
								@foreach ($dropDownPosition as $key => $value)
									<option value="{{$value}}"{{ ( $value == $selectedPosition) ? 'selected' : '' }}>{{ $value}}</option>
								@endforeach
							</select>
						</div>
					</div>					
					<div class="row">
                        <div class="col-md-12">
                            <div style="padding-top: 25px;">
                                <button type="submit" class="btn btn-primary" style="width:100%">
                                    <i class="fa fa-search"></i><span class="hidden-sm"> Search</span>
                                </button>
                            </div>
                        </div>
                    </div>		
				{{Form::close()}}
				<br/>
				
                <table id="member" class="table table-striped table-bordered table-hover datatable datatable-User" data-page-length="25">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>Image</th>
                            <th>Employee Code</th>
                            <th>Company Name</th>
                            <th>{{ trans('cruds.user.fields.name') }}</th>
                            <th>Position</th>
                            <th>{{ trans('cruds.user.fields.roles') }}</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $member)
                            <tr data-entry-id="{{ $member->id }}">
                                <td></td>
                                <td>
                                    @if(!is_null($member->image) && $member->image != '')
                                        {{Html::image('/upload/members/thumbnail/'.$member->image, $member->employee_name, ['class' => 'img-circle img-sm'])}}
                                    @else
                                        {{Html::image('/image/no-image.png', $member->employee_name, ['class' => 'img-circle img-sm'])}}
                                    @endif
                                </td>
                                <td>{{$member->employee_code}}</td>
                                <td>{{$member->findCompanyID->Co_Name}}</td>
                                <td>{{$member->employee_name ?? ''}}</td>
                                <td>{{$member->position ?? ''}}</td>
                                <td>
                                    @foreach($member->roles()->pluck('name') as $role)
                                        <span class="badge badge-info">{{ $role }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.members.show', $member->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.members.edit', $member->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                    <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#company_id').select2({placeholder: "Select Company", allowClear: true, width: '100%'});
		$('#position').select2({placeholder: "Select Position", allowClear: true, width: '100%'});
		$('#roles').select2({placeholder: "Select Roles", allowClear: true, width: '100%'});

		$('#member').DataTable( {
			dom: 'Bfrtip',
			buttons: ['copy', 'csv', 'excel', 'print'],
            searching: false
		});

        function checkFields() {
			$('input[type="text"]').each(function() {
				if ($(this).val() !== '') {
					$(this).addClass('has-value');
				} else {
					$(this).removeClass('has-value');
				}
			});
			$('select').each(function() {
				var select2Container = $(this).siblings('.select2-container');
				if ($(this).val() && $(this).val().length > 0) {
					select2Container.addClass('has-value').removeClass('no-value');
				} else {
					select2Container.addClass('no-value').removeClass('has-value');
				}
			});
		}

		checkFields();

		$('input[type="text"], select').on('change', function() {
			checkFields();
		});
	});
</script>
<script>
$(function () {
  let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
  let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
  let printButtonTrans = '{{ trans('global.datatables.print') }}'
  let languages = {
    'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
  };
  $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
  $.extend(true, $.fn.dataTable.defaults, {
    language: {
      url: languages['{{ app()->getLocale() }}']
    },
    columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets: 0
    }, {
        orderable: false,
        searchable: false,
        targets: -1
    }],
    select: {
      style:    'multi+shift',
      selector: 'td:first-child'
    },
    order: [],
    pageLength: 100,
    dom: 'lBfrtip<"actions">',
    buttons: [
      {
        extend: 'csv',
        className: 'btn-default',
        text: csvButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'pdf',
        className: 'btn-default',
        text: pdfButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'print',
        className: 'btn-default',
        text: printButtonTrans,
        exportOptions: {
          columns: ':visible'
        }
      }
    ]
  });
  $.fn.dataTable.ext.classes.sPageButton = '';
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    console.log(dtButtons);
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
    let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.members.mass_destroy') }}",
        className: 'btn-danger',
        action: function (e, dt, node, config) {
            var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                return $(entry).data('entry-id')
            });
            if (ids.length === 0) {
                alert('{{ trans('global.datatables.zero_selected') }}')
                return
            }
            if (confirm('{{ trans('global.areYouSure') }}')) {
                $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method: 'POST',
                url: config.url,
                data: { ids: ids, _method: 'DELETE' }})
                .done(function () { location.reload() })
            }
        }
    }
    
    dtButtons.push(deleteButton)
    $('.datatable-User:not(.ajaxTable)').({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).()
            .columns.adjust();
    });
})
</script>
@endsection