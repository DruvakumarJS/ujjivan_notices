@extends('layouts.app')

@section('content')
<style>
       
.container {
    max-width: 900px;

}
       
.ck-editor__editable[role="textbox"] {
    /* editing area */
    min-height: 200px;
}
.ck-content .image {
    /* block images */
    max-width: 80%;
    margin: 20px auto;
}

</style>

<div class="container">
    
    <div class="d-flex justify-content-center">
        <h3 class="mb-3 text-center">🌐 Content Translator</h3>
    <a class="ms-auto" href="{{ route('translatation')}}"><button class="btn btn-dark ">Back</button></a>
  </div>

    @if(Session::has('message'))
    <p id="mydiv" class="text-danger text-center">{{ Session::get('message') }}</p>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            alert("{{ Session::get('message') }}");
        });
    </script>
@endif


    <form id="translateForm">
        <div class="mb-3">
            <label for="editor" class="form-label fw-bold">Enter or Paste your HTML Text:</label>
            
          <div class="form-group">
              <label for="recipient-name" class="col-form-label">Name of the Notice</label>
              <input type="text" class="form-control" name="name" id="name" required style="border: 1px #000 solid">
            </div>
            
        </div>
        <textarea class="form-control" name="text" id="editor" style="border: 1px #000 solid"></textarea>

       <div class="row mt-2 " id="state_dropdown_list" >
          <div class="col-10">
             <label>Select Languages</label>
             <div class="input-group mb-3">
             
              <select class="selectpicker"  multiple search="true" id="language" name="language[]" required="" style="width: 100% !important;border: 1px #000 solid">
                @foreach($languages as $key=>$value)
                <option value="{{$value->code}}">{{$value->lang}} - {{$value->name}}</option>

                @endforeach
                
              </select>

              </div>
            </div>
        </div>

        <div class="d-flex">
            <button type="button" id="translateBtn" class="ms-auto btn btn-primary">Translate</button>
        </div>
    </form>

    <div id="output" class="mt-4"></div>
</div>

<script>
    document.getElementById('translateBtn').addEventListener('click', async function() {
    const text = editorInstance.getData();
    const selectedOptions = Array.from(document.getElementById('language').selectedOptions);
    const languages = selectedOptions.map(option => option.value);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const noticename = $('#name').val();
    
    if (!noticename.trim()) {
        alert('Please enter notice name or NID...');
        return;
    }

    if (!text.trim()) {
        alert('Please enter some text!');
        return;
    }
    if (languages.length === 0) {
        alert('Please select at least one language!');
        return;
    }

    document.getElementById('output').innerHTML =
        '<div class="alert alert-info">⏳ Translating... Please wait...</div>';

    try {
        const response = await fetch("{{ route('translate.ckdata') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({ text, languages , noticename})
        });

        const contentType = response.headers.get("content-type");

        // 🔹 If it's JSON, show alert (quota or error message)
        if (contentType && contentType.includes("application/json")) {
            const json = await response.json();
            if (json.status === "error") {
                Swal.fire({
                  title: "Translation Quota",
                  text: json.message,
                  icon: "info"
                });
                document.getElementById('output').innerHTML = "";
                return;
            }
        }

        // 🔹 Otherwise treat as HTML (translation result)
        const html = await response.text();
        document.getElementById('output').innerHTML = html;

    } catch (error) {
        console.error(error);
        document.getElementById('output').innerHTML =
            '<div class="alert alert-danger">❌ Something went wrong. Please try again later.</div>';
    }
});


 


</script>

<script>
let editorInstance; // ✅ define globally

CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
    toolbar: {
        items: [
            'exportPDF','exportWord', '|',
            'findAndReplace', 'selectAll', '|',
            'heading', '|',
            'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
            'bulletedList', 'numberedList', 'todoList', '|',
            'outdent', 'indent', '|',
            'undo', 'redo',
            '-',
            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
            'alignment', '|',
            'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
            'specialCharacters', 'horizontalLine', 'pageBreak', '|',
            'textPartLanguage', '|',
            'sourceEditing'
        ],
        shouldNotGroupWhenFull: true
    },
    list: {
        properties: {
            styles: true,
            startIndex: true,
            reversed: true
        }
    },
    heading: {
        options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
            { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
            { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
            { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
        ]
    },
    placeholder: '',
    fontFamily: {
        options: [
            'default',
            'Arial, Helvetica, sans-serif',
            'Courier New, Courier, monospace',
            'Georgia, serif',
            'Lucida Sans Unicode, Lucida Grande, sans-serif',
            'Tahoma, Geneva, sans-serif',
            'Times New Roman, Times, serif',
            'Trebuchet MS, Helvetica, sans-serif',
            'Verdana, Geneva, sans-serif'
        ],
        supportAllValues: true
    },
    fontSize: {
        options: [ 10, 12, 14, 'default', 18, 20, 22 ],
        supportAllValues: true
    },
    htmlSupport: {
        allow: [
            {
                name: /.*/,
                attributes: true,
                classes: true,
                styles: true
            }
        ]
    },
    htmlEmbed: {
        showPreviews: true
    },
    link: {
        decorators: {
            addTargetToExternalLinks: true,
            defaultProtocol: 'https://',
            toggleDownloadable: {
                mode: 'manual',
                label: 'Downloadable',
                attributes: {
                    download: 'file'
                }
            }
        }
    },
    mention: {
        feeds: [
            {
                marker: '@',
                feed: [
                    '@apple', '@bears', '@brownie', '@cake', '@candy', '@chocolate', '@cookie', '@cream',
                    '@cupcake', '@donut', '@ice', '@jelly-o', '@pie', '@sweet', '@wafer'
                ],
                minimumCharacters: 1
            }
        ]
    },
    removePlugins: [
        'AIAssistant',
        'CKBox',
        'CKFinder',
        'EasyImage',
        'RealTimeCollaborativeComments',
        'RealTimeCollaborativeTrackChanges',
        'RealTimeCollaborativeRevisionHistory',
        'PresenceList',
        'Comments',
        'TrackChanges',
        'TrackChangesData',
        'RevisionHistory',
        'Pagination',
        'WProofreader',
        'MathType',
        'SlashCommand',
        'Template',
        'DocumentOutline',
        'FormatPainter',
        'TableOfContents',
        'PasteFromOfficeEnhanced'
    ]
}).then(editor => {
    editorInstance = editor; // ✅ assign globally
}).catch(error => {
    console.error('CKEditor initialization failed:', error);
});
        </script>
@endsection