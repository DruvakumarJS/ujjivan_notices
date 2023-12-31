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
      
       <form method="POST" action="{{ route('save_rbi_notice')}}" enctype="multipart/form-data">
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

       <input type="hidden" name="selected_lang_code" value="{{$selected_lang_code}}">
       <input type="hidden" name="notice_type" value="{{$notice_type}}">
      
      @foreach($selected_languages as $keyl=>$lang)
      <hr/>
       <div class="row">
        <div style="width: 1000px" >
          <div class="card">
            <h5 class="card-header">
                <a data-toggle="collapse" href="#collapse-example" aria-expanded="true" aria-controls="collapse-example" id="heading-example" class="d-block">
                    <i class="fa fa-chevron-down pull-right"></i>
                    {{$lang->name}}
                </a>
            </h5>
            <div id="collapse-example" class="collapse show" aria-labelledby="heading-example">
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                          <div class="text-sm-end" >
                            @if($lang->code == 'as')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang->code == 'bn')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang->code == 'en')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang->code == 'gu')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang->code == 'hi')<span class="" id="basic-addon3">{{ __('सूचना टुकड़ी *') }}</span>
                            @elseif($lang->code == 'kn')<span class="" id="basic-addon3">{{ __('ಸೂಚನೆ ಶೀರ್ಷಿಕೆ *') }}</span>
                            @elseif($lang->code == 'kh')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang->code == 'ml')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang->code == 'mr')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang->code == 'or')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang->code == 'pa')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang->code == 'ta')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang->code == 'te')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @elseif($lang->code == 'ur')<span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>
                            @endif

                          </div>
                        </div> 
                        <div class="col-6">
                            <div class="input-group mb-3">
                             <input class="form-control" type="text" name="notice[{{$keyl}}][tittle]" required>
                            </div>
                        </div>   
                   </div>
                   
                   <div class="row">
                        <div class="col-2">
                          <div class="text-sm-end" >
                            @if($lang->code == 'as')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang->code == 'bn')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang->code == 'en')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang->code == 'gu')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang->code == 'hi')<span class="" id="basic-addon3">{{ __('सूचना विवरण *') }}</span>
                            @elseif($lang->code == 'kn')<span class="" id="basic-addon3">{{ __('ಸೂಚನೆ ವಿವರಣೆ *') }}</span>
                            @elseif($lang->code == 'kh')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang->code == 'ml')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang->code == 'mr')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang->code == 'or')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang->code == 'pa')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang->code == 'ta')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang->code == 'te')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                            @elseif($lang->code == 'ur')<span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>@endif
                          </div>
                        </div> 
                        <div class="col-6">
                            <div class="input-group mb-3">
                             <input class="form-control" type="text" name="notice[{{$keyl}}][description]" required>
                            </div>
                        </div>   
                   </div>

                  
                   <div class="row">
                        <div class="col-2">
                          <div class="text-sm-end" >
                            @if($lang->code == 'as')<span class="" id="basic-addon3">{{ __('Select File *') }}</span>
                            @elseif($lang->code == 'bn')<span class="" id="basic-addon3">{{ __('Choose File *') }}</span>
                            @elseif($lang->code == 'en')<span class="" id="basic-addon3">{{ __('Choose File *') }}</span>
                            @elseif($lang->code == 'gu')<span class="" id="basic-addon3">{{ __('Choose File *') }}</span>
                            @elseif($lang->code == 'hi')<span class="" id="basic-addon3">{{ __('फाइलें चुनें *') }}</span>
                            @elseif($lang->code == 'kn')<span class="" id="basic-addon3">{{ __('ಫೈಲ್ ಆಯ್ಕೆ *') }}</span>
                            @elseif($lang->code == 'kh')<span class="" id="basic-addon3">{{ __('Choose File *') }}</span>
                            @elseif($lang->code == 'ml')<span class="" id="basic-addon3">{{ __('Choose File *') }}</span>
                            @elseif($lang->code == 'mr')<span class="" id="basic-addon3">{{ __('Choose File *') }}</span>
                            @elseif($lang->code == 'or')<span class="" id="basic-addon3">{{ __('Choose File *') }}</span>
                            @elseif($lang->code == 'pa')<span class="" id="basic-addon3">{{ __('Choose File *') }}</span>
                            @elseif($lang->code == 'ta')<span class="" id="basic-addon3">{{ __('Choose File *') }}</span>
                            @elseif($lang->code == 'te')<span class="" id="basic-addon3">{{ __('Choose File *') }}</span>
                            @elseif($lang->code == 'ur')<span class="" id="basic-addon3">{{ __('Choose File *') }}</span>
                            @endif

                          </div>
                        </div> 
                        <div class="col-6">
                            <div class="input-group mb-3">
                              <input type="file" name="notice[{{$keyl}}][rbi_file]" required>
                            </div>
                        </div>   
                   </div>

                   <input type="hidden" name="notice[{{$keyl}}][langauge]" value="{{$lang->code}}">
                   
                </div>
            </div>
           </div>
        </div>
         
       </div>
      @endforeach 
    

      <input type="hidden" name="selected_languages" value="{{$selected_languages}}">
      <div id="div3" class="div-margin">
         <button class="btn btn-success" type="submit">Submit</button> 
      </div>

     </form>
	 </div>
</div>


@endsection

