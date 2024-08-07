<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ env('APP_URL') }}/js/app.js" defer></script>
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link src="{{ env('APP_URL') }}/css/app.css" rel="stylesheet">
    <link src="{{ env('APP_URL') }}/css/style.css" rel="stylesheet">
    
</head>
<body>
    <div id="app">

<nav class="navbar fixed-top navbar-expand-md navbar-light bg-white ">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <img src="/uconnect-logo.png" alt="">{{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

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
<header>
 <!-- Side Bar starts -->

<nav>
 <div class="sidebar navbar-collapse" style="margin-top: 80px">
    <!-- list-group-item list-group-item-action py-2 ripple -->
 
        <a href="" >
          <label>Dashboard</label>
        </a>
        
        <a href="" >
          <label>Templates</label>
        </a>

        <a href="" >
          <label>Notices</label>
        </a>
        
        <a href="{{route('add_device')}}" >
          <label>Device Registration</label>
        </a>

</div>

</nav>
<!-- Side  Bar ends -->

</header>

<main class="py-4" style="margin-top: 80px;margin-left: 120px">
           
                  <div >
                  @yield('content')
                  </div>

            </div>
        </main>
        
    </div>
</body>
</html>
