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

    <!-- Styles -->
    <link rel="stylesheet" href="{{ env('APP_URL') }}/css/app.css" />
    <link rel="stylesheet" href="{{ env('APP_URL') }}/css/style.css" />
    <link rel="stylesheet" href="{{ env('APP_URL') }}/css/content-styles.css"  type="text/css"/>
    
    <!-- ckEditor -->
    <!-- <script src="{{ asset('ckeditor/ckeditor.js') }}"></script> -->
   <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/super-build/ckeditor.js"></script>

     <script rel="stylesheet" src="{{ env('APP_URL') }}/jquery/jquery.min.js"></script>

  <!-- multiselect -->
    <link rel="stylesheet" href="{{ env('APP_URL') }}/multiselect/bootstrap-select.css"/>
    <script rel="stylesheet" src="{{ env('APP_URL') }}/multiselect/bootstrap.bundle.min.js"></script>
    <script rel="stylesheet" src="{{ env('APP_URL') }}/multiselect/bootstrap-select.min.js"></script>
    
   
  <!-- multiselect --> 

    <!-- Autocomplete -->
    <link rel="stylesheet" href="{{ env('APP_URL') }}/jquery/jquery-ui.min.css"/>
    <script rel="stylesheet" src="{{ env('APP_URL') }}/jquery/jquery-ui.min.js"></script>
    <!-- Autocomplete -->

    <script rel="stylesheet" src="{{ env('APP_URL') }}/sweetalert/sweetalert.min.js"></script>
    <script rel="stylesheet" src="{{ env('APP_URL') }}/chart/chart.js"></script>
    <script rel="stylesheet" src="{{ env('APP_URL') }}/datepicker/moment.min.js"></script>
    <script rel="stylesheet" src="{{ env('APP_URL') }}/datepicker/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}/datepicker/daterangepicker.css"/>

   
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

                        <div class="dropdown">

                            <a href="" data-bs-toggle="dropdown" aria-expanded="true"> <img class="circle" src="{{asset('images/notification.svg')}}" style="width: 20px;height: 20px;margin-left: 10px;margin-top: 10px"> <span class="badge rounded-pill badge-notification bg-danger" id="n_count"></span> </a>
                            <ul class="dropdown-menu dropdown-menu-end" id="notifications">
                               
                            </ul>
                         </div>

                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="">{{ __('Login') }}</a>
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

                          @if(auth::user()->id == '3')
                         
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                              <a href="{{ route('devices')}}">
                                  <label>Devices</label>
                              </a>
                              <!-- <a onclick="requestpassword()" href="#">
                                  <label>Devices</label>
                              </a> -->
                          </li>

                          @endif

                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{route('audit')}}"> <label>Audit Trail</label> </a>
                          </li>
                          
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a  href="{{route('settings')}}"> <label>Branch Master</label> </a>
                          </li>

                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a  href="{{route('emergency_contacts','en')}}"> <label>Emergency Contacts</label> </a>
                          </li>
                         
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
<script type="text/javascript">
  $( document ).ready(function() {
     var _token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
     var dropdown = $("#notifications");
        
     var response = ""
     
      $.ajax({
       url:"{{ route('notification') }}",
       method:"GET",
       data:{_token:_token },
       dataType:"json",
       success:function(data)
       {
        console.log(data);
        var datasize = data.length;
        if(datasize > 0 ){
          $("#n_count").text(''+datasize);
           
            for(var count = 0; count < data.length; count++){
              var name = data[count].name + ' - '+ data[count].branch_code;
              var elapsedTime = data[count].elapsed_time;
              var nameSpan = $("<span style='font-weight:bold'></span>").text(name).css("display", "block");
            var remainingContentSpan = $("<span></span>").text("Device is running continuously from past " + elapsedTime).css("display", "block");
            // Append name and remaining content spans to the list item
            var listItem = $("<li style='width:300px;padding-left:5px;'></li>").append(nameSpan).append(remainingContentSpan);
            // Append list item to the list
            dropdown.append(listItem);
            // Append divider after the list item
            dropdown.append($("<li style='display:inline-block;width:5px;height:50%;background-color:#ccc;margin-right:5px;margin-left:5px;'></li>"));
      
            }

            dropdown.css({
            "max-height": "500px", // Set the maximum height of the list
            "overflow-y": "auto" // Make the list vertically scrollable
        });
        }
        else{
           var name = 'No notification available' ;
               dropdown.append($("<li style='width:250px;margin-left:5px;margin-right:5px;'></li>").attr("value", name).text(name));
        }
        
        
        
       
       }
      })

       
    });

</script>

</html>
