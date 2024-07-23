$(document).ready(function() {
	$('#data_table').DataTable();

	$('.datepicker').datetimepicker({
		format: 'YYYY-MM-DD'
	});
	
	$('.timepicker').datetimepicker({
		format: 'HH:mm:ss'
	});
});

