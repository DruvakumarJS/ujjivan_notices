@extends('layouts.app')

@section('content')
 <link rel="stylesheet" href="{{ env('APP_URL') }}/multiselect/bootstrap-select.css"/>
    <script rel="stylesheet" src="{{ env('APP_URL') }}/multiselect/bootstrap.bundle.min.js"></script>
    <script rel="stylesheet" src="{{ env('APP_URL') }}/multiselect/bootstrap-select.min.js"></script>
<div class="container">
    <h3 class="mb-3 text-center">🌐 Google Translate Multi-Language Tool</h3>

    <form id="translateForm" method="POST">
        @csrf
        <div class="mb-3">
            <label for="text" class="form-label fw-bold">Enter English Text:</label>
            <textarea name="text" id="text" class="form-control" rows="10"
                      placeholder="Paste or type your paragraph here..." required></textarea>
        </div>

        <!-- <div class="mb-3">
            <label for="languages" class="form-label fw-bold">Select Languages:</label>
            <select id="languages" name="languages[]" class="form-select" multiple>
                <option value="hi">Hindi</option>
                <option value="ta">Tamil</option>
                <option value="te">Telugu</option>
                <option value="kn">Kannada</option>
                <option value="ml">Malayalam</option>
                <option value="bn">Bengali</option>
                <option value="gu">Gujarati</option>
                <option value="pa">Punjabi</option>
                <option value="mr">Marathi</option>
                <option value="or">Odia</option>
                <option value="ur">Urdu</option>
            </select>
            <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple.</small>
        </div> -->

        <div class="row mt-5" id="state_dropdown_list" >
          <div class="col-10">
             <div class="input-group mb-3">

              <select class="selectpicker"  multiple search="true" name="languages[]" style="" >
                @foreach($languages as $key=>$value)
                <option value="{{$value->code}}">{{$value->lang}} - {{$value->name}}</option>

                @endforeach
                
              </select>

              </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Translate</button>
    </form>

    <div id="output" class="mt-5"></div>
</div>

<script>
    $('#translateForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('translate.multiple') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                $('#output').html('');

                let html = `<div class='card p-3'>
                    <h5>Original (English)</h5>
                    <div class='alert alert-secondary'>${response.original}</div>
                    <h5 class='mt-3'>Translations</h5>
                    <div class='row'>`;

                $.each(response.translations, function (lang, text) {
                    html += `<div class='col-md-6 mb-3'>
                        <div class='card border-success'>
                            <div class='card-header bg-success text-white fw-bold text-uppercase'>${lang}</div>
                            <div class='card-body'><p>${text}</p></div>
                        </div>
                    </div>`;
                });

                html += `</div>
                    <a href="{{ route('translate.download', 'html') }}" class='btn btn-outline-secondary me-2'>Download HTML</a>
                    <a href="{{ route('translate.download', 'doc') }}" class='btn btn-outline-primary'>Download DOCX</a>
                    </div>`;

                $('#output').html(html);
            },
            error: function (xhr) {
                alert("Error: " + xhr.responseText);
            }
        });
    });
</script>
@endsection

