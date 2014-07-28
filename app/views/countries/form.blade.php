<div class="form-group">
	{{ Form::label('name', 'Nombre', ['class' => 'control-label']) }}
	{{ Form::text('name', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Nombre del país', 'id' => 'input-name']) }}
</div>
<div class="form-group">
	{{ Form::label('continent', 'Continente', ['class' => 'control-label']) }}
	{{ Form::text('continent', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Continente donde se encuentra', 'id' => 'input-continent']) }}
</div>
<div class="form-group">
	{{ Form::label('capital', 'Capital', ['class' => 'control-label']) }}
	{{ Form::text('capital', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Ciudad capital', 'id' => 'input-capital']) }}
</div>
<div class="form-group">
	{{ Form::label('language', 'Lengua', ['class' => 'control-label']) }}
	{{ Form::text('language', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Lengua oficial', 'id' => 'input-language']) }}
</div>
<div class="form-group">
	{{ Form::label('population', 'Habitantes', ['class' => 'control-label']) }}
	{{ Form::text('population', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Número total de habitantes', 'id' => 'input-population']) }}
</div>
<div class="form-group">
	{{ Form::label('currency', 'Moneda', ['class' => 'control-label']) }}
	{{ Form::text('currency', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Moneda que se usa', 'id' => 'input-currency']) }}
</div>
<div class="form-group">
	{{ Form::submit('Enviar', ['class' => 'btn btn-default', 'id' => 'submit-country']) }}
</div>