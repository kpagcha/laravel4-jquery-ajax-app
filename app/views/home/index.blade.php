@extends('layouts.master')

@section('content')

<div class="well"><code id="url"></code></div>

<div class="col-sm-6">
	{{ Form::open(['class' => 'form-horizontal', 'id' => 'form']) }}
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
			<div class="col-sm-10 input-group">
				<span class="input-group-addon">{{ Form::radio('mode', 'driving', true) }} En coche</span>
				<span class="input-group-addon">{{ Form::radio('mode', 'walking', false) }} A pie</span>
				<span class="input-group-addon">{{ Form::radio('mode', 'bicycling', false) }} En bicicleta</span>
				<span class="input-group-addon">{{ Form::radio('mode', 'transit', false) }} Transporte público</span>
			</div>
		</div>
	{{ Form::close() }}
</div>

<div class="clearfix"></div>

<div id="directions-container" class="row hide">
	<div class="clearfix"></div>
	<div class="col-sm-12">
		<div id="directions-status" class="col-sm-6 alert alert-info" style="text-align:center"></div>
		<div id="directions-info" class="hide">
			<div class="well col-md-12">
				<p>
					<strong>Origen</strong><span id="origin-info"></span>
				</p>
				<p>
					<strong>Destino</strong><span id="destination-info"></span>
				</p>
				<hr class="custom-divider">
				<p>
					<strong>Distancia</strong><span id="distance-info"></span>
				</p>
				<p>
					<strong>Duración</strong><span id="duration-info"></span>
				</p>
			</div>
			<div id="route-container">
				<ul id="route-list" class="list-group"></ul>
			</div>
		</div>
	</div>
</div>

{{ HTML::script('js/directions.js') }}

@stop