// Carga los países en la tabla; paginación soportada
function renderCountries(url) {
	if (url === undefined) url = '/country/all';
	$.get(url, function(data) {
			$('#countries-table').empty();
			if (data['empty'] == false) {
				$('#countries-table').append(data['html']);
				$('#clear-countries-form').show();
			} else {
				$('#countries-table').append('<div class="alert alert-info">No hay países en la base de datos</div>');
				$('#clear-countries-form').hide();
			}
		});
}

// Limpia los valores del formulario
function clearFormInput(form) {
	$(':input', form)
	  .not(':button, :submit, :reset, :hidden')
	  .val('')
	  .removeAttr('checked')
	  .removeAttr('selected');
}

// Llamada inicial al acceder a countries.index para cargar los países en la tabla
renderCountries();

// Paginación async
var curPage = null;
$(document).on('click', '.pagination a', function (event) {
    event.preventDefault();
    if ( $(this).attr('href') != '#' ) {
        $("html, body").animate({ scrollTop: 0 }, "fast");
        curPage = $(this).attr('href');
        renderCountries(curPage);
    }
});

// Crear país async
$('#create-country-form').submit(function(event) {
	$.post('/country/store', $('#create-country-form').serialize(), function(data) {

		// if ($('.table > tbody > tr').length == 5) {
		// 	if (curPage) {
		// 		nextPage = nextPageURL(curPage, 'page');
		// 		renderCountries(nextPage);
		// 		curPage = nextPage;
		// 	} else {
		// 		renderCountries('http://localhost:8000/country/all?page=2')
		// 	}
		// } else {
		// 	if (curPage) {
		// 		renderCountries(curPage);
		// 	} else {
		// 		renderCountries();
		// 	}
		// }

		renderCountries();

		clearFormInput('#create-country-form');

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

// Vaciar la tabla countries async
$('#clear-countries-form').submit(function(event) {
	if (confirm('¿Limpiar datos de la tabla?')) {
		$.post('/country/clear', function(data) {
			renderCountries();
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

// Eliminar un país
$(document).on('click', '.glyphicon-remove', function(event) {
	var thiz = $(this);
	var id = thiz.next('input:hidden').val();

	$.ajax({
		url: '/country/' + id,
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
						renderCountries(curPage);
					} else {
						var page = getURLParameter(curPage, 'page');
						if (page !== '1') {
							prevPage = previousPageURL(curPage, 'page');
							renderCountries(prevPage);
							curPage = prevPage;
						} else {
							renderCountries();
						}
					}
					executed = true;
				}
			});
	});
});

// Editar país
$(document).on('click', '.glyphicon-pencil', function(event) {
	var row = $(this).closest('tr');
	var id = row.find("input[name='edit-id']").val();
	$.get('/country/' + id + '/edit', function(data) {
		row.html(data['html']).find('div.row').hide().slideDown('400');
	});
});

// Guardar edición
$(document).on('click', '.glyphicon-floppy-disk', function(event) {
	var id = $(this).closest('tr').find("input[name='update-id']").val();
	$.ajax({
		url: '/country/' + id,
		type: 'put',
		data: $('#edit-country-form').serialize(),
		context: this
	})
	.done(function(data) {
		if (data['status']) {
			$(this).closest('tr').find('div').slideUp('400').delay('400', function() {
				renderCountries(curPage);
			});
		} else {
			$('#edit-errors').find('ul').html(data['errors']);
			$('#edit-errors').modal();
		}
	});
});

// Cancelar edición
$(document).on('click', '.glyphicon-ban-circle', function(event) {
	$(this).closest('tr').find('div').slideUp('400').delay('400', function() {
		renderCountries(curPage);
	});
});