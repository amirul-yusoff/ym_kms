@if($errors->any())
	<div class="alert alert-danger">
		There is errors related to your record entry as below, please correct it and try again
		<ul>
			@foreach($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
		</ul>
	</div>
@elseif($message = Session::get('success'))
	<div class="alert alert-success">
		<p>{{ $message }}</p>
	</div>
@endif
