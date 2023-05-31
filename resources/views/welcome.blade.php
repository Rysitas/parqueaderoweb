<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Parqueadero</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Styles -->
        <style>
        .jumbotron {
            background-color: #f9fafb;
        }
        
        .jumbotron h1,
        .jumbotron p {
            text-align: center;
        }

    </style>
</head>

<body class="antialiased">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Parking</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    @if (Route::has('login'))
                    <li class="nav-item">
                        @auth
                        <a href="{{ url('/dashboard') }}" class="nav-link">Inicio</a>
                        @else
                        <a href="{{ route('login') }}" class="nav-link">Log in</a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-link">Registrar</a>
                        @endif
                        @endauth
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="jumbotron">
            <h1>Bienvenido a mi Parqueadero</h1>
            <p>Sistema de parqueadero.</p>
        </div>
    </div>

</body>

</html>

