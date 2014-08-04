<div class="modal fade" id="edit-errors" tabindex="-1" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog">
	    <div class="modal-content">
	    	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
        		<h4 class="modal-title">Errores en el formulario</h4>
    		</div>
	    	<div class="modal-body">
	    		<ul class="list-unstyled"></ul>
	    	</div>
	    </div>
	</div>
</div>
<td colspan="0">
	<div class="col-md-12" id="edit-form-container">
		{{ Form::open(['id' => 'edit-country-form']) }}
		<div class="form-group col-md-12">
			<div class="col-md-3">
				{{ Form::label('name', 'Nombre', ['class' => 'control-label']) }}
			</div>
			<div class="col-md-9">
				{{ Form::text('name', $country->name, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Nombre del país', 'id' => 'update-name']) }}
			</div>
		</div>
		<div class="form-group col-md-12">
			<div class="col-md-3">
				{{ Form::label('continent', 'Continente', ['class' => 'control-label']) }}
			</div>
			<div class="col-md-9">
				{{ Form::text('continent', $country->continent, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Continente donde se encuentra', 'id' => 'update-continent']) }}
			</div>
		</div>
		<div class="form-group col-md-12">
			<div class="col-md-3">
				{{ Form::label('capital', 'Capital', ['class' => 'control-label']) }}
			</div>
			<div class="col-md-9">
				{{ Form::text('capital', $country->capital, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Ciudad capital', 'id' => 'update-capital']) }}
			</div>
		</div>
		<div class="form-group col-md-12">
			<div class="col-md-3">
				{{ Form::label('language', 'Lengua', ['class' => 'control-label']) }}
			</div>
			<div class="col-md-9">
				{{ Form::text('language', $country->language, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Lengua oficial', 'id' => 'update-language']) }}
			</div>
		</div>
		<div class="form-group col-md-12">
			<div class="col-md-3">
				{{ Form::label('population', 'Habitantes', ['class' => 'control-label']) }}
			</div>
			<div class="col-md-9">
				{{ Form::text('population', $country->population, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Número total de habitantes', 'id' => 'update-population']) }}
			</div>
		</div>
		<div class="form-group col-md-12">
			<div class="col-md-3">
				{{ Form::label('currency', 'Moneda', ['class' => 'control-label']) }}
			</div>
			<div class="col-md-9">
				{{ Form::text('currency', $country->currency, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Moneda que se usa', 'id' => 'update-currency']) }}
			</div>
		</div>
		<div class="form-group col-md-12">
			<span class="glyphicon glyphicon-floppy-disk btn btn-success"></span>
			<span class="glyphicon glyphicon-ban-circle btn btn-primary"></span>
			{{ Form::hidden('update-id', $country->id) }}
		</div>
		{{ Form::close() }}
	</div>
</td>