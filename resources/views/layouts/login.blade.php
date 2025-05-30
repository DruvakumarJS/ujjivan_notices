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

    <script src="{{ env('APP_URL') }}/jquery/jquery.min.js" rel="stylesheet"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ env('APP_URL') }}/css/app.css" rel="stylesheet">
    
</head>
<body style="background-color: #056262">
    <div id="app">
        
        <main class="py-4" >
           <div class="row mx-0 px-0">
                  <div class="col-12">
                  @yield('content')
                  </div>

            </div>
        </main>
    </div>
</body>
</html>
