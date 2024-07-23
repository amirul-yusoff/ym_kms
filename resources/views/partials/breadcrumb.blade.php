<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>{{isset($breadcrumb_title) ? $breadcrumb_title : $title}}</h2>
		<ol class="breadcrumb">
			<li><a href="{{url('/')}}">Home</a></li>
			@foreach($breadcrumb as $b)
				@if($b != end($breadcrumb))
					<li><a href="{{url($b['url'])}}">{{$b['name']}}</a></li>
				@else
					<li class="active">{{$b['name']}}</li>
				@endif
			@endforeach
		</ol>
	</div>
</div>
