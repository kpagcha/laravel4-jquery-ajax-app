@if(isset($cities))
	<table class="table table-striped table-responsive">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Habitantes</th>
				<th>País</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($cities as $city)
				<tr>
					<td>{{ $city->name }}</td>
					<td>{{ $city->population != 0 ? number_format($city->population, 0, "", "&#8239;") : '?' }}</td>
					<td>{{ $city->country ? $city->country->name : '?' }}</td>
					<td>
						{{ Form::open(['class' => 'pull-right']) }}
							<span class="glyphicon glyphicon-pencil btn btn-xs btn-success"></span>
							{{ Form::hidden('edit-id', $city->id) }}
						{{ Form::close() }}
					</td>
					<td>
						{{ Form::open(['class' => 'pull-right']) }}
							<span class="glyphicon glyphicon-remove btn btn-xs btn-danger"></span>
							{{ Form::hidden('id', $city->id) }}
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
			</tr>
		</tbody>
	</table>
	{{ $cities->links() }}
@endif