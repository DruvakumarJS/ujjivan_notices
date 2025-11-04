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

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

   
</head>
<body>
    <div id="app">
        <nav class="navbar fixed-top navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <label style="color:#056262;font-size: 18px;font-weight: bolder;color: #1B1833" >{{ config('app.name', 'Laravel') }}</label>
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
                          <li class="list-group-item d-flex justify-content-between align-items-center {{ request()->routeIs('home') ? 'bg-warning text-danger' : '' }}" >
                              <a  href="{{ route('home')}}" > <label class="label-bold">Dashboard</label> </a>
                          </li>
                          <!-- <li class="list-group-item d-flex justify-content-between align-items-center">
                              <a href="{{ route('templates')}}"><label>Templates</label> </a> 
                          </li> -->
                          <li class="list-group-item d-flex justify-content-between align-items-center {{ (request()->routeIs('notices','en') || request()->routeIs('choose_template') || request()->routeIs('create_notice')|| request()->routeIs('select_language')|| request()->routeIs('edit_notice_datails')|| request()->routeIs('edit_multi_notice_datails')|| request()->routeIs('notices','en')|| request()->routeIs('notices','en')|| request()->routeIs('notices','en')|| request()->routeIs('notices','en') || request()->routeIs('search_notice') || request()->routeIs('edit_rbi_notice') || request()->routeIs('edit_multi_rbi_notice_datails') )? 'bg-warning text-danger' : '' }}">
                              <a  href="{{ route('notices','en')}}" ><label class="label-bold">Notices</label></a>
                          </li>

                          @if(auth::user()->id == '3')
                         
                          <li class="list-group-item d-flex justify-content-between align-items-center {{ (request()->routeIs('devices') || request()->routeIs('add_device') || request()->routeIs('view_device_datails') || request()->routeIs('edit_device_datails') || request()->routeIs('analytics') || request()->routeIs('search_device') )? 'bg-warning text-danger' : '' }}">
                              <a href="{{ route('devices')}}">
                                  <label class="label-bold">Devices</label>
                              </a>
                              <!-- <a onclick="requestpassword()" href="#">
                                  <label>Devices</label>
                              </a> -->
                          </li>

                          @endif

                          
                          <li class="list-group-item d-flex justify-content-between align-items-center {{ request()->routeIs('settings') ? 'bg-warning text-danger' : '' }}">
                            <a  href="{{route('settings')}}"> <label class="label-bold">Branch Master</label> </a>
                          </li>

                          <li class="list-group-item d-flex justify-content-between align-items-center {{ request()->routeIs('emergency_contacts','en') ? 'bg-warning text-danger' : '' }}">
                            <a  href="{{route('emergency_contacts','en')}}"> <label class="label-bold">Emergency Contacts</label> </a>
                          </li>

                          <li class="list-group-item d-flex justify-content-between align-items-center {{ request()->routeIs('ombudsman_contacts') ? 'bg-warning text-danger' : '' }}">
                            <a  href="{{route('ombudsman_contacts','en')}}"> <label class="label-bold">Banking Ombudsman Contacts Details </label> </a>
                          </li>

                          <li class="list-group-item d-flex justify-content-between align-items-center {{ (request()->routeIs('notices_history','en') || request()->routeIs('view_archive_notice_datails') ||request()->routeIs('view_multilingual_archive_notice_datails') ||request()->routeIs('search_archive_notice'))? 'bg-warning text-danger' : '' }}">
                            <a  href="{{route('notices_history','en')}}"> <label class="label-bold">Notices Archive </label> </a>
                          </li>

                          <li class="list-group-item d-flex justify-content-between align-items-center {{ (request()->routeIs('notices_recycle','en') || request()->routeIs('view_recycle_notice_datails') || request()->routeIs('view_multilingual_recycle_notice_datails'))? 'bg-warning text-danger' : '' }}">
                            <a href="{{route('notices_recycle','en')}}"> <label class="label-bold">Recycle Bin</label> </a>
                          </li>

                          <li class="list-group-item d-flex justify-content-between align-items-center {{ request()->routeIs('audit') ? 'bg-warning text-danger' : '' }}">
                            <a target="_blank" href="{{route('manage_users')}}"> <label class="label-bold">User Management</label> </a>
                          </li>

                          <li class="list-group-item d-flex justify-content-between align-items-center {{ request()->routeIs('audit') ? 'bg-warning text-danger' : '' }}">
                            <a href="{{route('translatation')}}"> <label class="label-bold">Translator</label> </a>
                          </li>

                          <li class="list-group-item d-flex justify-content-between align-items-center {{ request()->routeIs('audit') ? 'bg-warning text-danger' : '' }}">
                            <a href="{{route('audit')}}"> <label class="label-bold">Audit Trail</label> </a>
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
