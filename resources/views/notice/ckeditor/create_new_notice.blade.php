@extends('layouts.app')
@section('content')
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/super-build/ckeditor.js"></script>
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script> -->

<style type="text/css">
	
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

<div class="container-body">
	 <label class="label-bold">Create New Notice</label>
	 <div class="page-container">

	 <hr/>
      
       <form method="POST" action="{{ route('save_notice')}}" enctype="multipart/form-data">
        @csrf 	

	 <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Notice Tittle * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">
                 <input class="form-control" type="text" name="tittle" required>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Notice Description * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">
                 <input class="form-control" type="text" name="description" required>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">PAN India * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">
                 <select class="form-control form-select" name="is_pan_india" id="pan" required>
                  <option value="">Select</option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                 </select>
                </div>
            </div>   
       </div>

       <div class="row" >
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Region-wise  </span>
                  </div>
            </div> 
            <div class="col-6" >
                <div class="input-group mb-3" id="region_dropdown">
                 <select class="form-control form-select" name="is_region_wise" id="region_prompt" >
                  <option value="">Select</option>
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                 </select>
                </div>
            </div>   
       </div>

       <div class="row" id="region_dropdown_list" id="region_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Select Region(s)  </span>
                  </div>
            </div> 
          <div class="col-6">
             <div class="input-group mb-3">
             <select class="form-control selectpicker" multiple name="regions[]" id="region_list" >
              <option value="">Select Region</option>
                @foreach($regions as $key=>$value)
                   <option value="{{$value->name}}">{{$value->name}}</option>
                @endforeach
              </select>

              </div>
            </div>
       </div>


       <div class="row" id="state_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">State-wise </span>
                  </div>
            </div> 
            <div class="col-6" id="state_dropdown">
                <div class="input-group mb-3">
                 <select class="form-control form-select" name="is_state_wise" id="state_prompt" >
                  <option value="">Select</option>
                  <option value="ya">Yes</option>
                  <option value="na">No</option>
                 </select>
                </div>
            </div>   
       </div>

        <div class="row" id="state_dropdown_list">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Select State(s)  </span>
                  </div>
            </div> 
          <div class="col-6">
             <div class="input-group mb-3">
             <select class="form-control selectpicker" multiple search="true" name="states[]" id="state_list" >
                <!-- <option value="Karnataka">Karnataka</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Kerala">Kerala</option>
                <option value="Telangana">Telangana</option> -->
                <option value="">Select Region</option>
                @foreach($branch as $key=>$value)
                   <option value="{{$value->state}}">{{$value->state}}</option>
                @endforeach

              </select>

              </div>
            </div>
       </div>

       <div class="row" id="state_dropdown_list">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Select Languages</span>
                  </div>
            </div> 
          <div class="col-6">
             <div class="input-group mb-3">
             <!-- <select class="form-control selectpicker" multiple search="true" id="languages" name="lang[]" required="" onchange="selectedValues()">
                <option value="Assamese">Assamese</option>
                <option value="Bengali">Bengali</option>
                <option value="English" selected>English</option>
                <option value="Ghazi">Ghazi</option>
                <option value="Gujarati">Gujarati</option>
                <option value="Hindi">Hindi</option>
                <option value="Kannada">Kannada</option>
                <option value="Malayalam">Malayalam</option>
                <option value="Marathi">Marathi</option>
                <option value="Oriya">Oriya</option>
                <option value="Punjabi">Punjabi</option>
                <option value="Tamil">Tamil</option>
                <option value="Telugu">Telugu</option>
                <option value="Urdu">Urdu</option>
              </select> -->

              <select class="form-control selectpicker"  multiple search="true" id="languages" name="lang[]" required="" onchange="selectedValues()">
              	@foreach($languages as $key=>$value)
              	<option value="{{$value->code}}">{{$value->name}}</option>

              	@endforeach
              	
              </select>

              </div>
            </div>
       </div>

       <div class="row" id="state_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Voice Over Required</span>
                  </div>
            </div> 
            <div class="col-6" id="state_dropdown">
                <div class="input-group mb-3">
                 <select class="form-control form-select" name="voice_over" required>
                  <option value="">Select</option>
                  <option value="Y">Yes</option>
                  <option value="N">No</option>
                 </select>
                </div>
            </div>   
       </div>


       <input type="hidden" name="template_id" value="{{$template_id}}">

       <input class="form-control" type="hidden" name="" id="langs">
      	

	 @php
       $data = json_encode($template->details , TRUE); 	
     @endphp

     <div class="row">
     	<div class="col-md-8">
     		
     		<div class="card text-black bg-white border border-primary">
     			<!-- header -->
     			<div class="card-header text-muted text-black"  style="background-color: white"><img src="{{ url('/')}}/images/mainLogo.svg" style="height: 30px;float: right;"> </div>
                <!-- header -->
                
		        @foreach($arr as $keys=>$values)
		         @php
                  $data = explode(',',$values->coloum);
                @endphp
                
                <!-- single content -->
                 @if(sizeof($data) == 1)
                   @foreach($data as $key1=>$views)
                   @if($views == 'textarea')
                   <div class="div-margin">
                   </div>
                   	 <textarea class="form-control" id="content_{{$keys+1}}_{{$key1+1}}"  name="row{{$keys+1}}_{{$key1+1}}" ></textarea>  

                   	 <script>
					   CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key1+1}}"), {
					        toolbar: {
					           items: [
					                 'selectAll', '|',
					                'heading', '|',
					                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
					                'bulletedList', 'numberedList', 'todoList', '|',
					                'outdent', 'indent', '|',
					                'undo', 'redo',
					                '-',
					                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
					                'alignment', '|',
					                
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
					                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
					                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
					                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
					                        '@sugar', '@sweet', '@topping', '@wafer'
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
					    });
					</script>
					@elseif($views == 'table')
					<div class="div-margin">
                   </div>
					  <textarea class="form-control" id="content_{{$keys+1}}_{{$key1+1}}"  name="row{{$keys+1}}_{{$key1+1}}" ></textarea>  

                   	 <script>
					   CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key1+1}}"), {
					        toolbar: {
					           items: [
					                'insertTable',
					                '|',
					                'heading', '|',
					                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
					                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight'
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
					                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
					                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
					                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
					                        '@sugar', '@sweet', '@topping', '@wafer'
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
					    });
					</script>
					@elseif($views == 'img')
					<div class="div-margin">
                   </div>
					  <textarea class="form-control" id="content_{{$keys+1}}_{{$key1+1}}"  name="row{{$keys+1}}_{{$key1+1}}" ></textarea>  

                   	 <script>
					   CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key1+1}}"), {
					        toolbar: {
					           items: [
					                'uploadImage',
					                '|',
					                'heading', '|',
					                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
					                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight'
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
					                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
					                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
					                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
					                        '@sugar', '@sweet', '@topping', '@wafer'
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
					    });
					</script>
					@endif
                   @endforeach

                   <!--End single content -->

                <!--col 6 content -->
                @elseif(sizeof($data) == 2)
                <div class="row div-margin">
                 @foreach($data as $key2=>$views2)
                  <div class="col-md-6">
                  	 @if($views2 == 'textarea')
                   	 <textarea class="form-control" id="content_{{$keys+1}}_{{$key2+1}}"  name="row{{$keys+1}}_{{$key2+1}}" ></textarea>  

                   	 <script>
					   CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key2+1}}"), {
					        toolbar: {
					           items: [
					                 'selectAll', '|',
					                'heading', '|',
					                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
					                'bulletedList', 'numberedList', 'todoList', '|',
					                'outdent', 'indent', '|',
					                'undo', 'redo',
					                '-',
					                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
					                'alignment', '|',
					                
					                'specialCharacters', 'horizontalLine', 'pageBreak', '|',
					                'textPartLanguage', '|',
					                'sourceEditing'
					            ],
					            shouldNotGroupWhenFull: false
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
					                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
					                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
					                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
					                        '@sugar', '@sweet', '@topping', '@wafer'
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
					    });
					</script>
					@elseif($views2 == 'table')
					  <textarea class="form-control" id="content_{{$keys+1}}_{{$key2+1}}"  name="row{{$keys+1}}_{{$key2+1}}" ></textarea>  

                   	 <script>
					   CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key2+1}}"), {
					        toolbar: {
					           items: [
					                'insertTable','|',
					                'undo', 'redo','|',
					                'heading', '|',
					                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
					                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight'
					            ],
					            shouldNotGroupWhenFull: false
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
					                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
					                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
					                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
					                        '@sugar', '@sweet', '@topping', '@wafer'
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
					    });
					</script>
					@elseif($views2 == 'img')
					  <textarea class="form-control" id="content_{{$keys+1}}_{{$key2+1}}"  name="row{{$keys+1}}_{{$key2+1}}" ></textarea>  

                   	 <script>
					   CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key2+1}}"), {
					        toolbar: {
					           items: [
					                'uploadImage','|',
					                'undo', 'redo','|',
					                'heading', '|',
					                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
					                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight'
					            ],
					            shouldNotGroupWhenFull: false
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
					                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
					                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
					                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
					                        '@sugar', '@sweet', '@topping', '@wafer'
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
					    });
					</script>
					@endif
                  </div>

                 @endforeach
                	
                </div>

                <!--End col 6 content -->

                <!-- Col 4 content -->

                @elseif(sizeof($data) == 3)
                <div class="row div-margin">
                 @foreach($data as $key3=>$views3)
                  <div class="col-md-4">
                  	 @if($views3 == 'textarea')
                   	 <textarea class="form-control" id="content_{{$keys+1}}_{{$key3+1}}"  name="row{{$keys+1}}_{{$key3+1}}" ></textarea>  

                   	 <script>
					   CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key3+1}}"), {
					        toolbar: {
					           items: [
					                 'selectAll', '|',
					                'heading', '|',
					                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
					                'bulletedList', 'numberedList', 'todoList', '|',
					                'outdent', 'indent', '|',
					                'undo', 'redo',
					                '-',
					                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
					                'alignment', '|',
					                
					                'specialCharacters', 'horizontalLine', 'pageBreak', '|',
					                'textPartLanguage', '|',
					                'sourceEditing'
					            ],
					            shouldNotGroupWhenFull: false
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
					                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
					                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
					                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
					                        '@sugar', '@sweet', '@topping', '@wafer'
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
					    });
					</script>
					@elseif($views3 == 'table')
					  <textarea class="form-control" id="content_{{$keys+1}}_{{$key3+1}}"  name="row{{$keys+1}}_{{$key3+1}}" ></textarea>  

                   	 <script>
					   CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key3+1}}"), {
					        toolbar: {
					           items: [
					                'insertTable','|',
					                'undo', 'redo','|',
					                'heading', '|',
					                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
					                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight'
					            ],
					            shouldNotGroupWhenFull: false
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
					                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
					                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
					                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
					                        '@sugar', '@sweet', '@topping', '@wafer'
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
					    });
					</script>
					@elseif($views3 == 'img')
					  <textarea class="form-control" id="content_{{$keys+1}}_{{$key3+1}}"  name="row{{$keys+1}}_{{$key3+1}}" ></textarea>  

                   	 <script>
					   CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key3+1}}"), {
					        toolbar: {
					           items: [
					                'uploadImage','|',
					                'undo', 'redo','|',
					                'heading', '|',
					                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
					                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight'
					            ],
					            shouldNotGroupWhenFull: false
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
					                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
					                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
					                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
					                        '@sugar', '@sweet', '@topping', '@wafer'
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
					    });
					</script>
					@endif
                  </div>

                 @endforeach
                	
                </div>

                <!--End col 4 content -->
                 @endif


		        @endforeach
                <!-- Footer -->
     			<div class="card-footer text-muted text-black bg-white">
		          <label style="color: black">Version 1</label>
			         <div id="div3">
			           <label  style="color: black">{{date('d M Y')}}</label>
			         </div>
		        </div>
		        <!-- Footer -->
     		</div>
     		
     		
     	</div>
     	
     </div>
      <div id="div3" class="div-margin">
         <button class="btn btn-success" type="submit">Submit</button> 
      </div>

     </form>
	 </div>
</div>


@endsection

