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
   <!--  <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->

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
                <a class="navbar-brand" href="{{ route('ujjivan_notices','en') }}">
                    <img src="/ujjivan.svg" alt="" style="height: 30px;">
                </a>
               
            </div>

        </nav>

        <main class="py-4" >
           <div class="row align-items-stretch h-100 mx-0 px-0">

                  <div class="col-12" style="margin-top: 50px">
                  @yield('content')
                  </div>

            </div>
        </main>
    </div>
</body>

<script>
        const paragraphsContainer = document.getElementById('paragraphs');
        const speechSynthesis = window.speechSynthesis;
        let currentParagraphIndex = 0;
        let utterance;

        function speak() {
            if (speechSynthesis.speaking) {
                speechSynthesis.cancel();
            }

            const allParagraphs = Array.from(paragraphsContainer.children);
            const currentParagraph = allParagraphs[currentParagraphIndex];
            const currentText = currentParagraph.textContent;

            utterance = new SpeechSynthesisUtterance(currentText);
            utterance.addEventListener('start', () => highlightParagraph(currentParagraph));
            utterance.addEventListener('end', () => {
                removeHighlight(currentParagraph);
                currentParagraphIndex++;
                if (currentParagraphIndex < allParagraphs.length) {
                    speak();
                } else {
                    currentParagraphIndex = 0; // Reset index for future readings
                }
            });

            speechSynthesis.speak(utterance);
        }

        function highlightParagraph(paragraph) {
            paragraph.classList.add('highlight');
        }

        function removeHighlight(paragraph) {
            paragraph.classList.remove('highlight');
        }
    </script>
</html>
