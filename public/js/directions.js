var timer = 0;
var firstKeyNotPressed = true;

var eventGetDirectons = function() {
	if  (!$('#directions-info').hasClass('hide')) {
		$('#directions-info').addClass('hide');
	}
	clearTimeout(timer);
	timer = setTimeout(getDirections, 200);
};

$('.form-control').keypress(eventGetDirectons);
$('input[type=radio]').click(eventGetDirectons);

function getDirections() {
	var o = $('#origin').val();
	var d = $('#destination').val();
	var m = $("input:radio[name='mode']:checked").val();

	timer = 0;

	if (firstKeyNotPressed) {
		$('#directions-container').removeClass('hide');
	}
	if ($('#directions-status').hasClass('alert-warning')) {
		$('#directions-status').addClass('alert-info');
		$('#directions-status').removeClass('alert-warning');	
	}
	$('#directions-status').removeClass('hide');
	$('#directions-status').html('Calculando ruta...');
	
	$.get('/search', { origin: o, destination: d, mode: m })
		.done(function(data) {

			$('#url').html(data['url']);

			if (data['status'] == 'OK') {

				$('#directions-info').removeClass('hide');
				$('#directions-status').addClass('hide');

				$('#origin-info').html(data['origin']);
				$('#destination-info').html(data['destination']);
				$('#distance-info').html(data['distance']);
				$('#duration-info').html(data['duration']);

				$('#route-list').empty();
				var total_distance = parseFloat(data['distance_value']);
				$.each(data['route']['step'], function(index, val) {
					var distance = parseFloat(data['route']['distance_value'][index]);
					var inner_value = 
						'<li class="list-group-item" style="background-color:rgba(90,140,255,'
						+ distance/total_distance
						+ ');">' + val
						+ '<div><small>' + data['route']['distance'][index]
						+ ' &#8212; ' + data['route']['duration'][index]
						+ ' &#8212; ' + data['route']['mode'][index]
						+ '</small></div></li>';
					$('#route-list').append(inner_value);
				});

			} else {

				$('#directions-status').removeClass('alert-info');
				$('#directions-status').addClass('alert-warning');

				switch (data['status']) {
					case 'ZERO_RESULTS':
						$('#directions-status').html('No se pudo encontrar una ruta');
						break;
					case 'NOT_FOUND':
						$('#directions-status').html('No se pudo codificar geográficamente al menos una de las ubicaciones especificadas');
						break;
					case 'MAX_WAYPOINTS_EXCEEDED':
						$('#directions-status').html('Se proporcionaron demasiados hitos (máx. 8)');
						break;
					case 'INVALID_REQUEST':
						$('#directions-status').html('Solicitud inválida');
						break;
					case 'OVER_QUERY_LIMIT':
						$('#directions-status').html('El servicio ha recibido demasiadas solicitudes en el tiempo permitido');
						break;
					case 'REQUEST_DENIED':
						$('#directions-status').html('Solicitud de servicio denegada');
						break;
					case 'UNKNOWN_ERROR':
						$('#directions-status').html('No se ha podido procesar el servicio de rutas debido a un error en el servidor. Por favor, intentálo de nuevo');
						break;
					default:
						$('#directions-status').html('Error desconocido');
				}
			}
		});
}