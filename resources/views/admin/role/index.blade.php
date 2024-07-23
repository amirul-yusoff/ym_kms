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
                        <a href="{{ route("admin.roles.create") }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.role.title_singular') }}
                        </a>
                    </div>
                    @endcan
                </div>
                <div class="ibox-content">
                    <table id="role_table" class="table table-bordered table-striped table-hover datatable datatable-Role">
                        <thead>
                            <tr>
                                <th width="10px"></th>
                                <th>{{ trans('cruds.role.fields.id') }}</th>
                                <th>{{ trans('cruds.role.fields.title') }}</th>
                                <th>{{ trans('cruds.role.fields.permissions') }}</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $key => $role)
                                <tr data-entry-id="{{ $role->id }}">
                                    <td>
        
                                    </td>
                                    <td>
                                        {{ $role->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $role->name ?? '' }}
                                    </td>
                                    <td>
                                        @foreach($role->permissions()->pluck('name') as $permission)
                                            <span class="badge badge-info">{{ $permission }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.roles.show', $role->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
        
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.roles.edit', $role->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
        
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
        url: "{{ route('admin.roles.mass_destroy') }}",
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


    $('.datatable-Role:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection