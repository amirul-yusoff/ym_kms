<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>#</th>
				<th>Tender No.</th>
				<th>Tender Title</th>
				<th>Tender Shortname</th>
                <th>Client</th>
                <th>Client Reference</th>
				<th>Tender Category</th>
				<th>Quantity Surveyor</th>
                <th>License Company</th>
                <th>Tender Sum</th>
                <th>Result</th>
                <th>Remarks</th>
			</tr>
		</thead>
		@foreach($data as $key => $d)
		<tr>
			<td>{{ $key + 1}}</td>
			<td>{{ $d->Tender_No}}</td>
			<td>{{ $d->Tender_Title }}</td>
            <td>{{ $d->Tender_Shortname }}</td>
            <td>{{ $d->Tender_To }}</td>
            <td>{{ $d->{'ClientReference:'} }}</td>
            <td>{{ $d->Tender_Category }}</td>
			<td>
                @if( !is_null($d->nickname) )
                    {{ $d->nickname }}
                @elseif( !is_null($d->Tender_QS) )
                    {{ $d->Tender_QS }}
                @else
                    null
                @endif
            </td>
            <td>{{ $d->Tender_Co }}</td>
            <td>{{ $d->Tender_Sum }}</td>
            <td>{{ $d->Tender_Result }}</td>
            <td>{{ $d->remarks }}</td>
		</tr>
		@endforeach
	</table>
</body>
</html> 