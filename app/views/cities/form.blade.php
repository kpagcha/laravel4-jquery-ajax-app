<div class="form-group">
	{{ Form::label('name', 'Nombre', ['class' => 'control-label']) }}
	{{ Form::text('name', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Nombre de la ciudad', 'id' => 'input-name']) }}
</div>
<div class="form-group">
	{{ Form::label('population', 'Habitantes', ['class' => 'control-label']) }}
	{{ Form::text('population', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Número total de habitantes', 'id' => 'input-population']) }}
</div>
<div class="form-group">
	{{ Form::label('country', 'País', ['class' => 'control-label']) }}
	{{ Form::select('country', $countries, null, ['class' => 'form-control', 'id' => 'input-country']) }}
</div>
<div class="form-group">
	{{ Form::submit('Enviar', ['class' => 'btn btn-default', 'id' => 'submit-country']) }}
</div>