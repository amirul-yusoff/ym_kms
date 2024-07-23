@extends('layouts.app')
@section('title', $title)
@section('content')
@include('partials.breadcrumb')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="wrapper wrapper-content animated fadeInRight">
	@include('partials.message')
	<div class="row">
		<div class="col-lg-12">
			<div class="float-e-margins">
				<div class="ibox-title">
					<h5>{{ $title }}</h5>
					<div class="ibox-tools">
					</div>
					<div class="ibox-content">
        				<div class="row">
							{{ Form::open(array('route' => 'my-invoice-supplier.store', 'files' => true))}}
							<div class="col-sm-6">
								<div class="form-group">
									<label for="invoice_number" class="col-sm-4 control-label">Invoice Number :</label>
									<div class="col-sm-8">
										{{ Form::text('invoice_number', null, ['class' => 'form-control']) }}
									</div>
								</div><br><br>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="created_by" class="col-sm-4 control-label">Created By :</label>
									<div class="col-sm-8">
										{{ Form::text('created_by', Auth::user()->employee_name, ['class' => 'form-control','readonly']) }}
									</div>
								</div><br><br>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="invoice_amount" class="col-sm-4 control-label">Invoice Amount :</label>
									<div class="col-sm-8">
										{{ Form::number('invoice_amount', null, ['class' => 'form-control', 'step' => '0.01']) }}
									</div>
								</div><br><br>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="po_number" class="col-sm-2 control-label">PO Number :</label>
									<div class="col-sm-10">
										<select name="po_number[]" class="form-control" id="po_number" multiple required>
											<option value="">Please Select PO</option>
											@foreach ($poData as $polist)
												<option value="{{$polist->po_number}}">{{$polist->po_number}} || {{$polist->vendor}}</option>
											@endforeach
										</select>
									</div>
								</div><br><br>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="files[]" class="col-sm-2 control-label">Files (DO, Invoice):</label>
									<div class="col-sm-10">
										{{ Form::file('files[]', ['class' => 'form-control form-control-sm', 'multiple', 'accept' => '.xlsx']) }}
									</div>
								</div><br><br>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="description" class="col-sm-2 control-label">Description :</label>
									<div class="col-sm-10">
										{{ Form::textarea('description', null, ['class' => 'form-control']) }}
									</div>
								</div><br><br>
							</div>
							
							<div class="col-sm-12">
								<button id="submitButton" button class="btn btn-primary" type="submit">
									<i class="fa fa-plus"> </i>
									Save
								</button>
							</div>
							{{Form::close()}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>
@endsection

@section('script')
<script type="text/javascript">
	const BaseURL = "{{ url('/') }}"
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/request-manpower/nameListCreate.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/request-manpower/jobScopeListCreate.js') }}" charset="utf-8"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
			$('#po_number').select2();
		});
	</script>
<script type="text/javascript">
	const anElement = AutoNumeric.multiple('.currency');
	$(document).ready(function() {
		$('#LOC').DataTable( {
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'print'
			]
		} );
	} );
</script>
<script type="text/javascript">
$('#myModal').modal('show')
$('.modal').on('shown.bs.modal', function (e) {
        $('.modal.show').each(function (index) {
            $(this).css('z-index', 1101 + index*2);
        });
        $('.modal-backdrop').each(function (index) {
            $(this).css('z-index', 1101 + index*2-1);
        });
    });
</script>
@endsection