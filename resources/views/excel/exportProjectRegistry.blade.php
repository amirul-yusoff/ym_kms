<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>#</th>
				<th>Project Code</th>
				<th>Project Title</th>
				<th>Tender Shortname</th>
				<th>Project Client</th>
				<th>Type of Work</th>
				<th>Contract No.</th>
				<th>Contract Sum</th>
				<th>VO Sum</th>
                <th>Project Status</th>
                <th>Project Team</th>
                <th>Commencement Date</th>
                <th>Completion Date</th>
                <td>Prepared Date</td>
                <th>Prepared By</th>
			</tr>
		</thead>
		@foreach($data as $key => $d)
		<tr>
			<td>{{ $key + 1}}</td>
			<td>{{ $d->Project_Code}}</td>
			<th>{{ $d->Project_Title }}</th>
			<td>{{ $d->Project_Short_name }}</td>
			<td>{{ $d->Project_Client }} </td>
			<td>{{ $d->project_type }}</td>
			<td>{{ $d->Project_Contract_No }}</td>
			<td>{{ $d->contract_original_value }}</td>
			<td>{{ $d->contract_vo_value }}</td>
            <td>{{ $d->Project_Status }}</td>
            <td>{{ $d->project_team }}</td>
            <td>{{ $d->Project_Commencement_Date }}</td>
            <td>{{ $d->Project_Completion_Date }}</td>
            <td>{{ $d->Project_Date_Prepared }}</td>
            <td>{{ $d->Project_Prepared_by }}</td>
		</tr>
		@endforeach
	</table>
</body>
</html> 