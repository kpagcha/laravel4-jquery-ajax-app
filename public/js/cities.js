// Carga las ciudades en la tabla; paginación soportada
function renderCities(url) {
	if (url === undefined || url === null) url = '/city/all';
	$.get(url, function(data) {
			$('#cities-table').empty();
			if (data['empty'] == false) {
				$('#cities-table').append(data['html']);
				$('#clear-cities-form').show();
			} else {
				$('#cities-table').append('<div class="alert alert-info">No hay ciudades en la base de datos</div>');
				$('#clear-cities-form').hide();
			}
			if (data['countries']) {
				$('#input-country').removeAttr('disabled');
			} else {
				$('#input-country').attr('disabled', 'disabled');
			}
		});
}

// Limpia los valores del formulario
function clearFormInput(form) {
	$(':text').val('');
}

// Llamada inicial al acceder a cities.index para cargar las ciudades en la tabla
renderCities();

// Paginación async
var curPage = null;
$(document).on('click', '.pagination a', function (event) {
    event.preventDefault();
    if ( $(this).attr('href') != '#' ) {
        $("html, body").animate({ scrollTop: 0 }, "fast");
        curPage = $(this).attr('href');
        renderCities(curPage);
    }
});

// Crear ciudad async
$('#create-city-form').submit(function(event) {
	$.post('/city/store', $('#create-city-form').serialize(), function(data) {

		renderCities(curPage);

		clearFormInput('#create-city-form');

		if (data['status']) {

			$('#info-errors').addClass('hidden');
			$('#info-success').removeClass('hidden');
			$('#info-success').html(data['message']);

		} else {

			$('#info-success').addClass('hidden');
			$('#info-errors').removeClass('hidden');
			$('#info-errors').html(data['errors']);

		}
	});
	event.preventDefault();
});

// Vaciar la tabla cities async
$('#clear-cities-form').submit(function(event) {
	if (confirm('¿Limpiar datos de la tabla?')) {
		$.post('/city/clear', function(data) {
			renderCities();
			$('#info-errors').addClass('hidden');
			$('#info-success').removeClass('hidden');
			$('#info-success').html(data['message']);
		});
	}
	event.preventDefault();
});

// Devuelve el valor de un parámetro de la URL
function getURLParameter(url, parameter) {
	var pos = url.indexOf(parameter);
	if (pos === -1) {
		return false;
	}
	pos += parameter.length + 1;
	substr = url.substr(pos);
	end = substr.indexOf('&');
	if (end === -1) {
		return substr;
	}
	return substr.substr(0, end);
}

// Devuelve una URL con la anterior página
function previousPageURL(url, parameter) {
	var pos = url.indexOf(parameter);
	if (pos === -1) {
		return false;
	}
	pos += parameter.length + 1;
	substr = url.substr(pos);
	end = substr.indexOf('&');
	page_value = (end === -1) ? substr : substr.substr(0, end);
	end += pos + page_value.length;
	first_chunk = url.substr(0, pos);
	last_chunk = url.substr(end + 1, url.length);
	prev_page = parseInt(page_value) - 1;
	prev_page_url = first_chunk + prev_page + last_chunk;
	return prev_page_url;
}

// Devuelve una URL con la siguiente página
function nextPageURL(url, parameter) {
	var pos = url.indexOf(parameter);
	if (pos === -1) {
		return false;
	}
	pos += parameter.length + 1;
	substr = url.substr(pos);
	end = substr.indexOf('&');
	page_value = (end === -1) ? substr : substr.substr(0, end);
	end += pos + page_value.length;
	first_chunk = url.substr(0, pos);
	last_chunk = url.substr(end + 1, url.length);
	next_page = parseInt(page_value) + 1;
	next_page_url = first_chunk + next_page + last_chunk;
	return next_page_url;
}

// Eliminar una ciudad
$(document).on('click', '.glyphicon-remove', function(event) {
	var thiz = $(this);
	var id = thiz.next('input:hidden').val();

	$.ajax({
		url: '/city/' + id,
		type: 'DELETE'
	})
	.done(function(data) {
		var executed = false;
		thiz.closest('tr')
			.find('td')
			.wrapInner('<div style="display: block;" />')
			.parent()
			.find('td > div')
			//.find('div')
			.slideUp(200)
			.delay(200, function() {
				if (!executed) {
					thiz.closest('td').remove();
					if ($('.table > tbody > tr').length > 1) {
						renderCities(curPage);
					} else {
						var page = getURLParameter(curPage, 'page');
						if (page !== '1') {
							prevPage = previousPageURL(curPage, 'page');
							renderCities(prevPage);
							curPage = prevPage;
						} else {
							renderCities();
						}
					}
					executed = true;
				}
			});
	});
});

// Editar ciudad
$(document).on('click', '.glyphicon-pencil', function(event) {
	var row = $(this).closest('tr');
	var id = row.find("input[name='edit-id']").val();
	$.get('/city/' + id + '/edit', function(data) {
		var edit = row.html(data['html']).find('div#edit-form-container');
		edit.hide().slideDown('400');
		if (data['countries']) {
			edit.find('select').removeAttr('disabled');
		} else {
			edit.find('select').attr('disabled', 'disabled');
		}
	});
});

// Guardar edición
$(document).on('click', '.glyphicon-floppy-disk', function(event) {
	var id = $(this).closest('tr').find("input[name='update-id']").val();
	$.ajax({
		url: '/city/' + id,
		type: 'put',
		data: $('#edit-city-form').serialize(),
		context: this
	})
	.done(function(data) {
		if (data['status']) {
			$(this).closest('tr').find('div').slideUp('400').delay('400', function() {
				renderCities(curPage);
			});
		} else {
			$('#edit-errors').find('ul').html(data['errors']);
			$('#edit-errors').modal();
		}
	});
});

// Cancelar edición
$(document).on('click', '.glyphicon-ban-circle', function(event) {
	$(this).closest('tr').find('div#edit-form-container').slideUp('400').delay('400', function() {
		renderCities(curPage);
	});
});