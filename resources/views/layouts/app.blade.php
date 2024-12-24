@php
	$url=  Route::currentRouteName();
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
            <div class="container-fluid">
				<a class="navbar-brand" href="{{route('home')}}">Navbar</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
              	</button>
              	<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<li class="nav-item">
							<a  class="nav-link " aria-current="page" href="#">Repertórios</a>
						</li>
						<li class="nav-item">
							<a class="nav-link @if($url ==  'musica' )active @endif" href="{{route('musica')}}">Musicas</a>
						</li>
						<li class="nav-item">
							<a class="nav-link @if($url ==  'editor' )active @endif" href="{{route('editor')}}">Inserir musica</a>
						</li>
						<li class="nav-item">
							<a class="nav-link @if($url ==  'musico' )active @endif" href="{{route('musico')}}">Musico</a>
						</li>
						<li class="nav-item">
							<a class="nav-link @if($url ==  'acorde' )active @endif" href="{{route('acorde')}}">Acorde</a>
						</li>
						<li class="nav-item">
							<a class="nav-link @if($url ==  'tom' )active @endif" href="{{route('tom')}}">Tom</a>
						</li>
						<li class="nav-item">
							<a class="nav-link @if($url ==  'ritimo' )active @endif" href="{{route('ritimo')}}">Ritímo</a>
						</li>
					</ul>
                	{{-- <form class="d-flex" role="search">
                  		<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                  		<button class="btn btn-outline-success" type="submit">Search</button>
                	</form> --}}
              	</div>
            </div>
          </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>