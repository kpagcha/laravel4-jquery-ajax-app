@extends('layouts.master')

@section('content')

<h1>Direcciones <small>petición síncrona</small></h1>

<div class="col-sm-6">
	{{ Form::open(['url' => '/directions', 'method' => 'post', 'class' => 'form-horizontal', 'id' => 'form']) }}
		<div class="form-group">
			{{ Form::label('origin', 'Origen', ['class' => 'col-sm-2 control-label']) }}
			<div class="col-sm-10">
				{{ Form::text('origin', Input::get('origin'), ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'origin']) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('destination', 'Destino', ['class' => 'col-sm-2 control-label']) }}
			<div class="col-sm-10">
				{{ Form::text('destination', Input::get('destination'), ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'destination']) }}
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2">
				{{ Form::submit('Buscar', ['class' => 'btn btn-default']) }}
			</div>
		</div>
	{{ Form::close() }}
</div>

<div class="clearfix"></div>

@if(isset($directions))
	<div class="clearfix"></div>
	<div class="col-sm-12">
		<pre>
			{{ $directions }}
		</pre>
	</div>
@endif

@stop