@if(isset($countries))
	<table class="table table-striped table-responsive">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Continente</th>
				<th>Capital</th>
				<th>Lengua</th>
				<th>Habitantes</th>
				<th>Moneda</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($countries as $country)
				<tr>
					<td>{{ $country->name }}</td>
					<td>{{ $country->continent }}</td>
					<td>{{ $country->capital }}</td>
					<td>{{ $country->language }}</td>
					<td>{{ number_format($country->population, 0, "", "&#8239;") }}</td>
					<td>{{ $country->currency }}</td>
					<td>
						{{ Form::open(['class' => 'pull-right']) }}
							<span class="glyphicon glyphicon-pencil btn btn-xs btn-success"></span>
							{{ Form::hidden('edit-id', $country->id) }}
						{{ Form::close() }}
					</td>
					<td>
						{{ Form::open(['class' => 'pull-right']) }}
							<span class="glyphicon glyphicon-remove btn btn-xs btn-danger"></span>
							{{ Form::hidden('id', $country->id) }}
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
			</tr>
		</tbody>
	</table>
	{{ $countries->links() }}
@endif