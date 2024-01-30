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
    <link href="{{ asset('css/content-styles.css') }}" rel="stylesheet" type="text/css">

   <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="noreferrer"></script> -->

   <!--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
     -->
</head>
<body>
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

<script>
 var data = [];
function createHashMap() {
   const parent = document.getElementById('test').children;

   for (var i = 0; i < parent.length; i++) {
   var childre = parent[i].id;
   var child_data = document.getElementById(childre).children;

   for(var j=0 ; j<child_data.length ; j++){
    data.push(child_data[j]);
   }
   console.log('child are ', i+" : "+ data);

    }

    var hashMap = {};

    for (var i = 0; i < data.length; i++) {
        var currentElement = data[i];

         console.log('elements2', currentElement.innerText.trim());

        // Use content-based identifier for figure tags
        var id;
        if (currentElement.tagName.toLowerCase() === 'figure') {
            // Generate an ID for figure elements
            id = 'table_' + i;
            var value = currentElement.innerText.trim();
            // Add the dynamically generated id to the HashMap
            hashMap[id] = value;
        } else {
            // Generate a default ID for other elements
            id = 'element_' + i;
            var value = currentElement.innerText.trim();
            // Add the dynamically generated id to the HashMap
            hashMap[id] = value;
        }
    }

    Android.onReceiveHashMap(JSON.stringify(hashMap));
}

function highlightElement(index) {

    console.log('elements', data.innerText);

    // Reset the style of all elements
    for (var i = 0; i < data.length; i++) {
        data[i].style.backgroundColor = '';
    }

    // Highlight the specified element in yellow
    var elementToHighlight = data[index];
    if (elementToHighlight) {
        elementToHighlight.style.backgroundColor = 'yellow';
        elementToHighlight.style.padding = "5px 5px 5px 5px";
        elementToHighlight.scrollIntoView({ behavior: 'smooth', block: 'center' });

      }
}
</script>

</html>
