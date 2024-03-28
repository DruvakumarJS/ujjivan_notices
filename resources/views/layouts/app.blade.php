<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ 'resources/saas/content-styles.css' }}" rel="stylesheet" type="text/css">

    <!-- ckEditor -->
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    

     <script rel="stylesheet" src="{{ asset('jquery/jquery.min.js') }}"></script>

  <!-- multiselect -->
 
    <link rel="stylesheet" href="{{ asset('multiselect/bootstrap-select.css') }}"></script>
    <script  src="{{ asset('multiselect/bootstrap.bundle.min.js') }}"></script>
    <script  src="{{ asset('multiselect/bootstrap-select.min.js') }}"></script>
  
  <!-- multiselect --> 

    <!-- Autocomplete -->
     <link rel="stylesheet" href="{{ asset('jquery/jquery-ui.min.css') }}">
     <script src="{{ asset('jquery/jquery-ui.min.js') }}"></script>
    <!-- Autocomplete -->

    <script src="{{ asset('sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('chart/chart.js') }}"></script>
    <script src="{{ asset('datepicker/moment.min.js') }}"></script>
    <script src="{{ asset('datepicker/daterangepicker.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('datepicker/daterangepicker.css') }}" />

</head>
<body>
    <div id="app">
        <nav class="navbar fixed-top navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <img src="/uconnect-logo.png" alt=""><label style="color:#056262;font-size: 18px;font-weight: bolder;">{{ config('app.name', 'Laravel') }}</label>
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

        <main class="py-4" >
           <div class="row align-items-stretch h-100 mx-0 px-0">

                  <div class="col-2 left-menu border-right h-100" >
                  @if(Auth::check())
                      <ul class="list-group">
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                              <a  href="{{ route('home')}}" > <label>Dashboard</label> </a>
                          </li>
                          <!-- <li class="list-group-item d-flex justify-content-between align-items-center">
                              <a href="{{ route('templates')}}"><label>Templates</label> </a> 
                          </li> -->
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                              <a  href="{{ route('notices','en')}}" ><label>Notices</label></a>
                          </li>
                          @if(auth::user()->role == 'admin')
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                              <!-- <a href="{{ route('devices')}}">
                                  <label>Devices</label>
                              </a> -->
                              <a onclick="requestpassword()" href="#">
                                  <label>Devices</label>
                              </a>
                          </li>
                          
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a onclick="settingspassword()" href="#"> <label>Settings</label> </a>
                          </li>
                          @endif
                      </ul>
                    @endif
                  </div>

                  <div class="col-10 h-100 right-content">
                  @yield('content')
                  </div>

            </div>
        </main>
    </div>
</body>

<script type="text/javascript">
  function requestpassword(){
   swal({
  title: 'Authorize Yourself',
  html: '',
  content: {
    element: "input",
    attributes: {
      placeholder: "Enter Password",
      type: "text",
      id: "input-field",
      className: "form-control",
      type:"password"
    },
  },
  buttons: {
   /* cancel: {
      visible: true,
      className: 'btn btn-danger'
    },*/
    confirm: {
      className : 'btn btn-success'
    }
  },
 }).then(
 
 function() {
   var input = $('#input-field').val();
   var _token = $('input[name="_token"]').val();
   var response = ""

   if(input != ''){
    $.ajax({
     url:"{{ route('authenticate') }}",
     method:"POST",
     data:{input:input, _token:_token },
     dataType:"json",
     success:function(data)
     {
      console.log(data)

      if(data == 'Authorized'){
        swal("", data, "success");
        window.location.href = "{{ route('devices')}}";
      }
      else{
        swal("", data, "error");
      }


     }
    })
   }
 }
 );
}

</script>

<script type="text/javascript">
  function settingspassword(){
   swal({
  title: 'Authorize Yourself',
  html: '',
  content: {
    element: "input",
    attributes: {
      placeholder: "Enter Password",
      type: "text",
      id: "input-field",
      className: "form-control",
      type:"password"
    },
  },
  buttons: {
   /* cancel: {
      visible: true,
      className: 'btn btn-danger'
    },*/
    confirm: {
      className : 'btn btn-success'
    }
  },
 }).then(
 
 function() {
   var input = $('#input-field').val();
   var _token = $('input[name="_token"]').val();
   var response = ""

   if(input != ''){
    $.ajax({
     url:"{{ route('authenticate') }}",
     method:"POST",
     data:{input:input, _token:_token },
     dataType:"json",
     success:function(data)
     {
      console.log(data)

      if(data == 'Authorized'){
        swal("", data, "success");
        window.location.href = "{{ route('settings')}}";
      }
      else{
        swal("", data, "error");
      }


     }
    })
   }
 }
 );
}

</script>

</html>
