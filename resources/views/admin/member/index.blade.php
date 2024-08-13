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
                    <table id="data_table" class="table table-striped table-bordered table-hover datatable datatable-User" data-page-length="25">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    Image
                                </th>
                                <th>
                                    Employee Code
                                </th>
                                <th>
                                    Company Name
                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.name') }}
                                </th>
                                <th>
                                    Position
                                </th>
                                <th>
                                    {{ trans('cruds.user.fields.roles') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $key => $member)
                                <tr data-entry-id="{{ $member->id }}">
                                    <td>

                                    </td>
                                    <td>
                                        @if(!is_null($member->image) && $member->image != '')
                                            {{Html::image('/upload/members/thumbnail/'.$member->image, $member->employee_name, ['class' => 'img-circle img-sm'])}}
                                        @else
                                            {{Html::image('/image/no-image.png', $member->employee_name, ['class' => 'img-circle img-sm'])}}
                                        @endif
                                    </td>
                                    <td>
                                        {{$member->employee_code}}
                                    </td>
                                    <td>
                                        {{-- {{$member->findCompanyID->Co_Name}} --}}
                                    </td>
                                    <td>
                                        {{$member->employee_name ?? ''}}
                                    </td>
                                    <td>
                                        {{$member->position ?? ''}}
                                    </td>
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
</div>
@endsection
@section('script')
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