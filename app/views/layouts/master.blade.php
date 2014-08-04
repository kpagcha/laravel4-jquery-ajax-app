<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>My App</title>
	{{ HTML::style('css/bootstrap.css') }}
	{{ HTML::style('css/myapp.css') }}
	{{ HTML::style('css/jquery-ui.css') }}
	{{ HTML::script('js/jquery.js') }}
	<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
</head>
<body>
	<div class="container-fluid">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
						<span class="sr-only">Activar navegación</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="{{ URL::to('/') }}" class="navbar-brand">My App</a>
				</div>
				<div class="collapse navbar-collapse" id="navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="{{ Request::path() == '/' ? 'active' : '' }}"><a href="{{ URL::to('/') }}">Página de inicio</a></li>
						<li class="{{ Request::path() == 'directions' ? 'active' : '' }}"><a href="{{ URL::to('/directions') }}">Direcciones</a></li>
						<li class="{{ Request::path() == 'country' ? 'active' : '' }}">{{ link_to_route('country.index', 'CRUD países') }}</li>
						<li class="{{ Request::path() == 'city' ? 'active' : '' }}">{{ link_to_route('city.index', 'CRUD ciudades') }}</li>
						<li class="{{ Request::path() == 'color' ? 'active' : '' }}">{{ link_to_route('color', 'Color') }}</li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
	<div class="container">
		@yield('content')
	</div>
	{{ HTML::script('js/bootstrap.js') }}
</body>
</html>