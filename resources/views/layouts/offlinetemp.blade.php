<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    
    <script src="./Ujjivan_files/app.js.download" defer=""></script>

    <link href="./Ujjivan_files/app.css" rel="stylesheet">
    
    <link href="./Ujjivan_files/style.css" rel="stylesheet">
   
    <link href="./Ujjivan_files/content-styles.css" rel="stylesheet" type="text/css">  
    
    <script src="./Ujjivan_files/ckeditor.js.download"></script>

</head>
<body>
    <div id="app">
        
        <main class="py-4" >
           <div class="row mx-0 px-0 justify-content-center">
                  <div class="col-12 justify-content-center" style="max-width: 950px">
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
