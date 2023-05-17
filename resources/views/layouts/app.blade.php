<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    
    <!-- Latest compiled JavaScript 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @guest
                    <a class="navbar-brand" href="{{ url('/dashboard') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                @else
                    <a class="navbar-brand" href="{{ url('/dashboard') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <a class="navbar-brand" href="{{ url('/lesson') }}">
                        Tvarkaraštis
                    </a>
                    <a class="navbar-brand" href="{{ url('/module') }}">
                        Moduliai
                    </a>
                    <a class="navbar-brand" href="{{ url('/room') }}">
                        Kabinetai
                    </a>
                    <a class="navbar-brand" href="{{ url('/mail') }}">
                        Laiskai
                    </a>
                    @if (Auth::user()->role >= 3)
                        <a class="navbar-brand" href="{{ url('/school') }}">
                            Mokyklos
                        </a>
                        <a class="navbar-brand" href="{{ url('/rule') }}">
                            Taisyklė
                        </a>
                        <a class="navbar-brand" href="{{ url('/timetable') }}">
                            Tvarkaraščių Archyvas
                        </a>
                        <a class="navbar-brand" href="{{ url('/timeslot') }}">
                            Pamokos laikas
                        </a>
                    @endif
                    @if (Auth::user()->role == 2)
                        <a class="navbar-brand" href="{{ url('/group') }}">
                            Grupės
                        </a>
                        <a class="navbar-brand" href="{{ url('/grade') }}">
                            Pažymiai
                        </a>
                    @endif
                    @if (Auth::user()->role == 1)
                        <a class="navbar-brand" href="{{ url('/grade') }}">
                            Pažymiai
                        </a>
                    @endif
                @endguest

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @include('inc.messages')
            @yield('content')
        </main>
    </div>
</body>
</html>
