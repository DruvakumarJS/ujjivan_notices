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
      
       <form method="POST" action="{{ route('update_multilang_notice',)}}" enctype="multipart/form-data">
        @method('PUT')
        @csrf   

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
                  <option <?php echo($data->is_pan_india == 'Yes')?'selected':'' ?> value="Yes">Yes</option>
                  <option <?php echo($data->is_pan_india == 'No')?'selected':'' ?> value="No">No</option>
                 </select>
                </div>
            </div>   
       </div>

       <div class="row" >
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Region-wise </span>
                  </div>
            </div> 
            <div class="col-6" >
                <div class="input-group mb-3" id="region_dropdown">
                 <select class="form-control form-select" name="is_region_wise" id="region_prompt" >
                  <option value="">Select</option>
                  <option <?php echo($data->is_region_wise == '1')?'selected':'' ?> value="1">Yes</option>
                  <option <?php echo($data->is_region_wise == '0')?'selected':'' ?> value="0">No</option>
                 </select>
                </div>
            </div>   
       </div>

       <div class="row" id="region_dropdown_list" id="region_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Select Region(s) </span>
                  </div>
            </div> 
          <div class="col-6">
             <div class="input-group mb-3">
             <select class="form-control selectpicker" multiple name="regions[]" id="region_list" >
               @php $region_list = explode(',',$data->regions); @endphp
                <option <?php echo(in_array('East',$region_list))?'selected':''  ?> value="East">East</option>
                <option <?php echo(in_array('West',$region_list))?'selected':''  ?> value="West">West</option>
                <option <?php echo(in_array('North',$region_list))?'selected':''  ?> value="North">north</option>
                <option <?php echo(in_array('South',$region_list))?'selected':''  ?> value="South">south</option>
              </select>

              </div>
            </div>
       </div>


       <div class="row" id="state_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">State-wise</span>
                  </div>
            </div> 
            <div class="col-6" id="state_dropdown">
                <div class="input-group mb-3">
                 <select class="form-control form-select" name="is_state_wise" id="state_prompt" >
                  <option value="">Select</option>
                  <option <?php echo($data->is_state_wise == 'ya')?'selected':'' ?> value="ya">Yes</option>
                  <option <?php echo($data->is_state_wise == 'na')?'selected':'' ?> value="na">No</option>
                 </select>
                </div>
            </div>   
       </div>

        <div class="row" id="state_dropdown_list">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Select State(s) </span>
                  </div>
            </div> 
          <div class="col-6">
             <div class="input-group mb-3">
             <select class="form-control selectpicker" multiple search="true" name="states[]" id="state_list" >
                
                @php $state_list = explode(',',$data->states); @endphp
                <option <?php echo(in_array('Karnataka',$state_list))?'selected':''  ?> value="Karnataka">Karnataka</option>
                <option <?php echo(in_array('Tamil Nadu',$state_list))?'selected':''  ?> value="Tamil Nadu">Tamil Nadu</option>
                <option <?php echo(in_array('Kerala',$state_list))?'selected':''  ?> value="Kerala">Kerala</option>
                <option <?php echo(in_array('Telangana',$state_list))?'selected':''  ?> value="Telangana">Telangana</option>
              </select>

              </div>
            </div>
       </div>

      

       <div class="row" id="state_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Voice Over Needed</span>
                  </div>
            </div> 
            <div class="col-6" id="state_dropdown">
                <div class="input-group mb-3">
                 <select class="form-control form-select" name="voice_over" required>
                  <option value="">Select</option>
                  <option <?php echo($data->voiceover == 'Y')?'selected':'' ?> value="Y">Yes</option>
                  <option <?php echo($data->voiceover == 'N')?'selected':'' ?> value="N">No</option>
                 </select>
                </div>
            </div>   
       </div>

        <div class="row" id="state_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">N ID *</span>
                  </div>
            </div> 
            <div class="col-6" id="state_dropdown">
                <div class="input-group mb-3">
                 <input class="form-control" type="text" name="document_id" value="{{$data->document_id}}" required>
                </div>
            </div>   
       </div>

       <div class="row" id="state_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Notice Version *</span>
                  </div>
            </div> 
            <div class="col-6" id="state_dropdown">
                <div class="input-group mb-3">
                 <input class="form-control" type="text" name="version" value="{{$data->version}}"  required>
                </div>
            </div>   
       </div>

       <div class="row" id="state_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Publishing Date *</span>
                  </div>
            </div> 
            <div class="col-6" id="state_dropdown">
                <div class="input-group mb-3">
                 <input class="form-control" type="text" name="publish_date" id="publish_date" value="{{$data->published_date}}" autocomplete="off" required>
                </div>
            </div>   
       </div>


       <input type="hidden" name="template_id" value="{{$data->template_id}}">
       <input type="hidden" name="selected_lang_code" value="{{$langarray}}">
       <input type="hidden" name="notice_group" value="{{$id}}">
       <input type="hidden" name="default_lang" value="{{$lang}}">

      
      @foreach($noticeDetails as $keyl=>$lang)

      <hr/>
       <div class="row">
        <div style="width: 1000px" >
          <div class="card">
            <label class="card-header text-primary font-bolder" dir="{{ $lang['notice_content']['lang_code']== 'ar' ? 'rtl' : 'ltr' }}" >{{$lang['language']}}</label>
            <!-- <h5 class="card-header">
                <a data-toggle="collapse" href="#collapse-example" aria-expanded="true" aria-controls="collapse-example" id="heading-example" class="d-block">
                    <i class="fa fa-chevron-down pull-right"></i>
                    {{$lang['language']}}
                </a>
            </h5> -->
            <div id="collapse-example" class="collapse show" aria-labelledby="heading-example" dir="{{ $lang['notice_content']['lang_code']== 'ar' ? 'rtl' : 'ltr' }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                          <div class="text-sm-end" >
                            @if($lang['notice_content']['lang_code'] == 'as')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'bn')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'en')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'gu')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'hi')<span class="" id="basic-addon3">{{ __('सूचना टुकड़ी *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'kn')<span class="" id="basic-addon3">{{ __('ಸೂಚನೆ ಶೀರ್ಷಿಕೆ *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'kh')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'ml')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'mr')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'or')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'pa')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'ta')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'te')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'ar')<span class="" id="basic-addon3">{{ __('نوٹس ٹائٹل
 *') }}</span>
                            @endif

                          </div>
                        </div> 
                        <div class="col-6">
                            <div class="input-group mb-3">
                             <input class="form-control" type="text" name="notice[{{$keyl}}][tittle]" value="{{$lang['name']}}" dir="{{ $lang['notice_content']['lang_code']== 'ar' ? 'rtl' : 'ltr' }}" required>
                            </div>
                        </div>   
                   </div>
                   
                   <div class="row">
                        <div class="col-2">
                          <div class="text-sm-end" >
                            @if($lang['notice_content']['lang_code'] == 'as')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'bn')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'en')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'gu')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'hi')<span class="" id="basic-addon3">{{ __('सूचना विवरण *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'kn')<span class="" id="basic-addon3">{{ __('ಸೂಚನೆ ವಿವರಣೆ *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'kh')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'ml')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'mr')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'or')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'pa')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'ta')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'te')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang['notice_content']['lang_code'] == 'ar')<span class="" id="basic-addon3">{{ __('نوٹس کی تفصیل
 *') }}</span>@endif
                          </div>
                        </div> 
                        <div class="col-6">
                            <div class="input-group mb-3">
                             <input class="form-control" type="text" name="notice[{{$keyl}}][description]" value="{{$lang['desc']}}" dir="{{ $lang['notice_content']['lang_code']== 'ar' ? 'rtl' : 'ltr' }}" required>
                            </div>
                        </div>   
                   </div>
                   <input type="hidden" name="notice[{{$keyl}}][langauge]" value="{{$lang['notice_content']['lang_code']}}">

                  <input type="hidden" name="notice[{{$keyl}}][id]" value="{{$lang['notice_content']['id']}}">
                  <input type="hidden" name="notice[{{$keyl}}][notice_id]" value="{{$lang['notice_content']['notice_id']}}">
                   <!-- ckEditor -->

                   <div class="row">
                      <div class="col-md-12">
                        
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
                                     @php
                                      $rowval = $keys+1;
                                      $colval = $key1+1;
                                      $cVal = 'c'.$rowval.$colval;
                                     @endphp
                                   @if($views == 'textarea')
                                   <div class="div-margin">
                                   </div>
                            
                                     <textarea class="form-control" id="content_{{$keys+1}}_{{$key1+1}}_{{$lang['notice_content']['lang_code']}}"  name="notice[{{$keyl}}][row{{$keys+1}}_{{$key1+1}}]" >{{ $lang['notice_content'][$cVal]}}</textarea> 

                                     @php
                                     $script_src = "https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/translations/".$lang['notice_content']['lang_code']. ".js";
                                     @endphp

                                     <script src="{{$script_src}}"></script>

                                     <script>
                             CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key1+1}}_{{$lang['notice_content']['lang_code']}}"), {
                                  language: {
                                    // The UI will be English.
                                    ui: '{{$lang['notice_content']['lang_code']}}',

                                    // But the content will be edited in Arabic.
                                    content: '{{$lang['notice_content']['lang_code']}}'
                                   },

                                   toolbar: {
                                     viewportTopOffset : 70, 
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
                                          'uploadImage','insertTable','|','sourceEditing'
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
                            <textarea class="form-control" id="content_{{$keys+1}}_{{$key1+1}}_{{$lang['notice_content']['lang_code']}}"  name="notice[{{$keyl}}][row{{$keys+1}}_{{$key1+1}}]" ></textarea>  

                            @php
                             $script_src = "https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/translations/".$lang['notice_content']['lang_code']. ".js";
                             @endphp

                             <script src="{{$script_src}}"></script>

                                     <script>
                             CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key1+1}}_{{$lang['notice_content']['lang_code']}}"), {
                                  language: {
                                    // The UI will be English.
                                    ui: '{{$lang['notice_content']['lang_code']}}',

                                    // But the content will be edited in Arabic.
                                    content: '{{$lang['notice_content']['lang_code']}}'
                                   },
                                  toolbar: {
                                     viewportTopOffset : 70, 
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
                            <textarea class="form-control" id="content_{{$keys+1}}_{{$key1+1}}_{{$lang['notice_content']['lang_code']}}"  name="notice[{{$keyl}}][row{{$keys+1}}_{{$key1+1}}]" ></textarea>  

                            @php
                             $script_src = "https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/translations/".$lang['notice_content']['lang_code']. ".js";
                            @endphp

                             <script src="{{$script_src}}"></script>

                                     <script>
                             CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key1+1}}_{{$lang['notice_content']['lang_code']}}"), {
                                 language: {
                                    // The UI will be English.
                                    ui: '{{$lang['notice_content']['lang_code']}}',

                                    // But the content will be edited in Arabic.
                                    content: '{{$lang['notice_content']['lang_code']}}'
                                   },

                                  toolbar: {
                                     viewportTopOffset : 70, 
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
                                     <textarea class="form-control" id="content_{{$keys+1}}_{{$key2+1}}_{{$lang['notice_content']['lang_code']}}"  name="notice[{{$keyl}}][row{{$keys+1}}_{{$key2+1}}]" ></textarea> 

                                     @php
                                     $script_src = "https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/translations/".$lang['notice_content']['lang_code']. ".js";
                                    @endphp

                                     <script src="{{$script_src}}"></script> 

                                     <script>
                             CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key2+1}}_{{$lang['notice_content']['lang_code']}}"), {
                                  language: {
                                    // The UI will be English.
                                    ui: '{{$lang['notice_content']['lang_code']}}',

                                    // But the content will be edited in Arabic.
                                    content: '{{$lang['notice_content']['lang_code']}}'
                                   },

                                  toolbar: {
                                     viewportTopOffset : 70, 
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
                            <textarea class="form-control" id="content_{{$keys+1}}_{{$key2+1}}_{{$lang['notice_content']['lang_code']}}"  name="notice[{{$keyl}}][row{{$keys+1}}_{{$key2+1}}]" ></textarea> 

                            @php
                             $script_src = "https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/translations/".$lang['notice_content']['lang_code']. ".js";
                            @endphp

                             <script src="{{$script_src}}"></script> 

                                     <script>
                             CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key2+1}}_{{$lang['notice_content']['lang_code']}}"), {
                                  language: {
                                    // The UI will be English.
                                    ui: '{{$lang['notice_content']['lang_code']}}',

                                    // But the content will be edited in Arabic.
                                    content: '{{$lang['notice_content']['lang_code']}}'
                                   },

                                  toolbar: {
                                     viewportTopOffset : 70, 
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
                            <textarea class="form-control" id="content_{{$keys+1}}_{{$key2+1}}_{{$lang['notice_content']['lang_code']}}"  name="notice[{{$keyl}}][row{{$keys+1}}_{{$key2+1}}]" ></textarea>  

                            @php
                             $script_src = "https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/translations/".$lang['notice_content']['lang_code']. ".js";
                            @endphp

                             <script src="{{$script_src}}"></script>

                                     <script>
                             CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key2+1}}_{{$lang['notice_content']['lang_code']}}"), {
                                  language: {
                                    // The UI will be English.
                                    ui: '{{$lang['notice_content']['lang_code']}}',

                                    // But the content will be edited in Arabic.
                                    content: '{{$lang['notice_content']['lang_code']}}'
                                   },

                                  toolbar: {
                                     viewportTopOffset : 70, 
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
                                     <textarea class="form-control" id="content_{{$keys+1}}_{{$key3+1}}_{{$lang['notice_content']['lang_code']}}"  name="notice[{{$keyl}}][row{{$keys+1}}_{{$key3+1}}]" ></textarea> 

                                     @php
                                     $script_src = "https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/translations/".$lang['notice_content']['lang_code']. ".js";
                                    @endphp

                                    <script src="{{$script_src}}"></script> 

                                     <script>
                             CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key3+1}}_{{$lang['notice_content']['lang_code']}}"), {
                                  language: {
                                    // The UI will be English.
                                    ui: '{{$lang['notice_content']['lang_code']}}',

                                    // But the content will be edited in Arabic.
                                    content: '{{$lang['notice_content']['lang_code']}}'
                                   },

                                  toolbar: {
                                     viewportTopOffset : 70, 
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
                            <textarea class="form-control" id="content_{{$keys+1}}_{{$key3+1}}_{{$lang['notice_content']['lang_code']}}"  name="notice[{{$keyl}}][row{{$keys+1}}_{{$key3+1}}]" ></textarea>  

                            @php
                             $script_src = "https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/translations/".$lang['notice_content']['lang_code']. ".js";
                            @endphp

                             <script src="{{$script_src}}"></script>

                                     <script>
                             CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key3+1}}_{{$lang['notice_content']['lang_code']}}"), {
                                  language: {
                                    // The UI will be English.
                                    ui: '{{$lang['notice_content']['lang_code']}}',

                                    // But the content will be edited in Arabic.
                                    content: '{{$lang['notice_content']['lang_code']}}'
                                   },

                                  toolbar: {
                                     viewportTopOffset : 70, 
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
                            <textarea class="form-control" id="content_{{$keys+1}}_{{$key3+1}}_{{$lang['notice_content']['lang_code']}}"  name="notice[{{$keyl}}][row{{$keys+1}}_{{$key3+1}}]" ></textarea>  

                            @php
                             $script_src = "https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/translations/".$lang['notice_content']['lang_code']. ".js";
                            @endphp

                             <script src="{{$script_src}}"></script>

                                     <script>
                             CKEDITOR.ClassicEditor.create(document.getElementById("content_{{$keys+1}}_{{$key3+1}}_{{$lang['notice_content']['lang_code']}}"), {
                                  language: {
                                    // The UI will be English.
                                    ui: '{{$lang['notice_content']['lang_code']}}',

                                    // But the content will be edited in Arabic.
                                    content: '{{$lang['notice_content']['lang_code']}}'
                                   },
                                   
                                  toolbar: {
                                     viewportTopOffset : 70, 
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
                          <!-- <div class="card-footer text-muted text-black bg-white">
                              <label style="color: black">Version 1</label>
                               <div id="div3">
                                 <label  style="color: black">{{date('d M Y')}}</label>
                               </div>
                            </div> -->
                            <!-- Footer -->
                        </div>
                        
                        
                      </div>
                      
                     </div>



                   <!-- ckEditor -->
                </div>
            </div>
           </div>
        </div>
         
       </div>
      @endforeach 
    
     @php
       $data = json_encode($template->details , TRUE);  
     @endphp

      <input type="hidden" name="selected_languages" value="{{$selected_languages}}">
      <div id="div3" class="div-margin">
         <button class="btn btn-success" type="submit">Update</button> 
      </div>

     </form>
   </div>
</div>

<script type="text/javascript">
  var mode = document.getElementById("pan").value;
   var langArray = [];
 // $('#region_list').prop('disabled', true);
 // $('#state_list').prop('disabled', true);
  $('#region_prompt').prop('disabled', true);
  $('#state_prompt').prop('disabled', true);

   $('select').on('change', function() {
     
       if(this.value == "No"){
          
           $('#region_prompt').prop('disabled', false);
           document.getElementById("region_prompt").required = true;
       }

       if(this.value == "Yes"){
          
           $('#region_prompt').prop('disabled', true);
           document.getElementById("region_prompt").required = false;

           $('#state_prompt').prop('disabled', true);
           document.getElementById("state_prompt").required = false;
 
       }

      if(this.value == "1"){
           $('#region_list').prop('disabled', false);
           document.getElementById("region_list").required = true;

           $('#state_prompt').prop('disabled', true);
           document.getElementById("state_prompt").required = false;
       }

       if(this.value == "0"){
           $('#region_list').prop('disabled', true);
           document.getElementById("region_list").required = false;

           $('#state_prompt').prop('disabled', false);
           document.getElementById("state_prompt").required = true;
       }

       if(this.value == "ya"){
           $('#state_list').prop('disabled', false);
           document.getElementById("state_list").required = true;          
       }
      



  });

   function auto_grow(element) {
  element.style.height = "250px";
  element.style.height = (element.scrollHeight) + "px";
}
 
</script>

<script>
    ClassicEditor.create( document.querySelector( '#content' ) )
        .catch( error => {
            console.error( error );
        } );
 
</script>

<script type="text/javascript">
   $( "#publish_date" ).datepicker({
        //minDate:0,
        dateFormat: 'yy-mm-dd',
        onSelect: function(dateText, $el) {
         // alert(dateText);
          
          
        }
      });
</script>


@endsection
