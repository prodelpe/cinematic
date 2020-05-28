<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name'))</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito|Boogaloo" rel="stylesheet">

        <!-- CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="/css/style.css" rel="stylesheet" type="text/css"/>
        
        <!-- Font Awesome -->
        <link href="/fontawesome/css/all.min.css" rel="stylesheet" type="text/css"/>
    </head>

    <body id='@yield("body-id", config("app.name"))'>

        <header>
            <!-- menu -->
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <div class="container">

                    <a class="navbar-brand" href="{{ route('welcome') }}">{{ config('app.name', 'Cinematic') }}</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarsExampleDefault">

                        {!! Form::open(['method' => 'GET', 'action'=>'SearchController@index', 'class'=>'form-inline my-2 my-lg-0 mr-auto']) !!}
                        @csrf
                        {!! Form::text('search', null, ['class' => 'form-control mr-sm-2', 'placeholder'=>'Buscar', 'aria-label'=>'Search']); !!}
                        {!! Form::hidden('page', 1) !!}
                        {!! Form::submit('Buscar', ['class' => 'btn btn-outline-success my-2 my-sm-0']); !!}
                        {!! Form::close() !!}

                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle cinematic-language" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-globe-americas mr-2"></i></a>
                                <div class="dropdown-menu bg-dark" aria-labelledby="dropdown01">
                                    <a class="dropdown-item text-white-50 cinematic-lang" href="{{ url('locale/en') }}" >English</a>
                                    <a class="dropdown-item text-white-50 cinematic-lang" href="{{ url('locale/es') }}" >Español</a>
                                </div>
                            </li>

                            @if (Route::has('login'))
                            @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/home') }}">{{ __('custom.home') }}</a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('custom.login') }}</a>
                            </li>

                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('custom.register') }}</a>
                            </li>
                            @endif
                            @endauth
                            @endif

                        </ul>

                    </div>
                </div> 
            </nav>
            <!-- end menu -->

        </header>

        <main role="main">
            @yield('content')
        </main>

        <footer class="footer bg-dark text-white text-right mt-5 pt-4 pb-3">
            <div class="container">
                <p>© Cinematic <?php echo date("Y"); ?></p>
            </div>

            <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
            <script src="/js/scripts.js" integrity=""></script>
        </footer>

    </body>
</html>