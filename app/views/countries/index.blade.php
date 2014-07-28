@extends('layouts.master')

@section('content')

<div class="col-md-6">
	<div id="info-success" class="alert alert-success hidden"></div>
	<ul id="info-errors" class="alert alert-warning list-unstyled hidden"></ul>
	{{ Form::open(['id' => 'create-country-form']) }}
		@include('countries.form')
	{{ Form::close() }}
</div>
<div class="col-md-6">
	<div class="col-md-12" id="countries-table">
		@include('countries.list')
	</div>

	<div style="margin-bottom:20px">
		{{ Form::open(['id' => 'clear-countries-form']) }}
			{{ Form::submit('Vaciar tabla', ['class' => 'btn btn-default']) }}
		{{ Form::close() }}
	</div>
</div>

{{ HTML::script('js/countries.js') }}

@stop