@extends('layouts.app')
@section('content')

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
	 <label class="label-bold">Create Custom Notice</label>
	 <div class="page-container">

     @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  
              @endforeach
              <li>{{ $error }}</li>
          </ul>
      </div>
     @endif

	 <hr/>
      
       <form method="POST" action="{{ route('save_custom_notice')}}" enctype="multipart/form-data">
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

       <div class="row" id="region_dropdown_list" id="region_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Select Region(s)  </span>
                  </div>
            </div> 
          <div class="col-6">
             <div class="input-group mb-3">
             <select class="form-control selectpicker" multiple name="regions[]" id="region_list">
             
                @foreach($regions as $key=>$value)
                   <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
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
            
               <div id="multiselect-container" class="form-control" style="padding: 0px;">
                  <select class="form-control selectpicker" id="state_list" >
              </select>

               </div>

              </div>
            </div>
       </div>

        <div class="row" id="state_dropdown_list">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Select Branch(s)  </span>
                  </div>
            </div> 
          <div class="col-6">
             <div class="input-group mb-3">
            
               <div id="multiselect-branch-container" class="form-control" style="padding: 0px;">
                  <select class="form-control selectpicker" id="branch_list" >
              </select>

               </div>

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
                 <input class="form-control" type="text" name="document_id" maxlength="10" required>
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
                 <input class="form-control" type="text" name="version" maxlength="10"  required>
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
                 <input class="form-control" type="text" name="publish_date" id="publish_date" autocomplete="off" required>
                </div>
            </div>   
       </div>

       <input type="hidden" name="selected_lang_code" value="{{$selected_lang_code}}">
       <input type="hidden" name="notice_type" value="{{$notice_type}}">
       <input type="hidden" name="dropdown_lang" value="{{$dropdown_lang}}">
      
      @foreach($selected_languages as $keyl=>$lang)
      <hr/>
       <div class="row">
        <div style="width: 1000px" >
          <div class="card">
            <h5 class="card-header">
                <a data-toggle="collapse" href="#collapse-example" aria-expanded="true" aria-controls="collapse-example" id="heading-example" class="d-block">
                    <i class="fa fa-chevron-down pull-right"></i>
                    {{$lang->lang}} - {{$lang->name}}
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
                             <input class="form-control" type="text" name="notice[{{$keyl}}][tittle]" maxlength="250" required>
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
                             <input class="form-control" type="text" name="notice[{{$keyl}}][description]" maxlength="250" required>
                            </div>
                        </div>   
                   </div> 

                   <div class="row">
                     <div class="col-md-12">
                      <div class="card text-black bg-white border border-primary" style="min-height: 250px;">
                        <div class="card-header text-muted text-black"  style="background-color: white">
                          <img src="{{ url('/')}}/images/mainLogo.svg" style="height: 30px;float: right;">
                        </div>

                        <div class="card-body">
                        <table  class="table table-responsive " id="dynamicAddRemove">
                          <tr>
                            <td>
                                  <div class="row">
                                     <div class="col-md-5">
                                      <input class="form-control" type="text" name="contact[0][name]"> 
                                     </div>

                                     <div class="col-md-5">
                                      <select class="form-control form-select" name="contact[0][value]">
                                        <option>Select value</option>
                                        @foreach($info_columns as $info)
                                           <option value="{{$info}}">{{$info}}</option>
                                        @endforeach
                                      </select> 
                                     </div>
                                     <div class="col-md-1">
                                      <button class="btn btn-sm btn-outline-secondary remove-input-mandate" >Remove</button>
                                    </div>
                                  </div>    
                            </td>
                          </tr>
                        </table>
                         </div>
                        
                        <div class="row">
                            <div class="col-7">
                               <button type="button" name="add" id="dynamic-ar" class="btn btn-outline-success div-margin">Add Row </button>
                               
                            </div>
                        </div> 

                       
                        
                      </div>
                       
                     </div>
                   </div>

                   <input class="form-control" type="hidden" name="notice[{{$keyl}}][langauge]" value="{{$lang->code}}">
                   
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

<script type="text/javascript">
    var i = 0;
    var j = 'n';
    $("#dynamic-ar").click(function () {
        ++i;
         $("#dynamicAddRemove").append('<tr><td><div class="row"><div class="col-md-5"><input class="form-control" type="text" name="contact['+ i +'][name]"></div><div class="col-md-5"><select class="form-control form-select" name="contact['+ i +'][value]"><option>Select value</option>@foreach($info_columns as $info)<option value="{{$info}}">{{$info}}</option>@endforeach</select> </div><div class="col-md-1"><button class="btn btn-sm btn-outline-secondary remove-input-mandate" >Remove</button></div></div></td></tr>');
        

        document.getElementById("btnn").style.display="block";
    });
    $(document).on('click', '.remove-input-field', function () {
    
      if (j==0 && i==1){
       
        alert('There must be atleast one address');
      }
      else
       {
        $(this).parents('tr').remove();
         --i;
      }

    });

     $(document).on('click', '.remove-input-mandate', function () {
     
      if(!i == 0){
      j=0;
        $(this).parents('tr').remove();
       
      }
      else {
        alert('There must be atleast one address');
      }
        
    });
      
</script>

<script type="text/javascript">
  $(document).ready(function() {
      $('#region_list').prop('disabled', true);
      $('#state_list').prop('disabled', true);
      $('#branch_list').prop('disabled', true);
      $('#region_prompt').prop('disabled', true);
      $('#state_prompt').prop('disabled', true);
    });
</script>

<script type="text/javascript">
  var mode = document.getElementById("pan").value;
   var langArray = [];
  //$('#region_list').prop('disabled', true);

   $('select').on('change', function() {
     
       if(this.value == "No"){
          
           $('#region_list').prop('disabled', false);
           $('#region_list').selectpicker('refresh');
           document.getElementById("region_list").required = true;

           $('#state_list').prop('disabled', false);
           $('#state_list').selectpicker('refresh');
            document.getElementById("state_list").required = true; 

       }

       if(this.value == "Yes"){
          
           $('#region_list').prop('disabled', true);
           $('#region_list').prop('selectedIndex', -1);
           $('#region_list').selectpicker('refresh');
           document.getElementById("region_list").required = false;

           $('#selectpicker1').prop('disabled', true);
           $('#selectpicker1').prop('selectedIndex', -1);
           $('#selectpicker1').selectpicker('refresh');

           $('#selectpicker').prop('disabled', true);
           $('#selectpicker').prop('selectedIndex', -1);
           $('#selectpicker').selectpicker('refresh');
           
           $('#branches').prop('disabled', true);
           $('#branches').prop('selectedIndex', -1);
           $('#branches').selectpicker('refresh');
          
           $('#state_list').prop('disabled', true);
           $('#state_list').prop('selectedIndex', -1);
           $('#state_list').selectpicker('refresh');
           document.getElementById("state_list").required = false; 

           $('#branch_list').prop('disabled', true);
           $('#branch_list').prop('selectedIndex', -1);
           $('#branch_list').selectpicker('refresh');
           document.getElementById("branch_list").required = false; 
 
       }

       if(this.value == "0"){
           $('#region_list').prop('disabled', true);
           $('#region_list').selectpicker('refresh');
           document.getElementById("region_list").required = false;

           $('#state_prompt').prop('disabled', false);
           document.getElementById("state_prompt").required = true;
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
<script>
  $(document).ready(function() {
    $('#region_list').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
      var regions = $(this).val();
     // alert(selectedValues);

      

      var _token = $('input[name="_token"]').val();

      $.ajax({
           url:"{{ route('get_states_list') }}",
           method:"GET",
           data:{regions:regions, _token:_token },
           dataType:"json",
           success:function(data)
           {
           // alert(data);
            console.log(data);

            var optionsHtml = '<option value="all">All</option>';

            $.each(data, function(index, item) {
            
              optionsHtml += '<option value="' + item.state + '">' + item.state + '</option>';
            });

            // Generate the multiselect dropdown HTML
            var selectPickerHtml = '<select id="selectpicker" multiple="multiple" class="form-control selectpicker" name="states[]" required>' + optionsHtml + '</select>';

            console.log('Generated HTML:', selectPickerHtml); // Debugging
            // Append the HTML to the container
            $('#multiselect-container').html(selectPickerHtml);

            // Initialize the multiselect plugin
            $('#selectpicker').selectpicker();

            $('#selectpicker').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            var selectedValues2 = $(this).val();
           // alert(selectedValues2);
            if (selectedValues2 && selectedValues2.includes('all')) {
            // Disable all options except "All"
            $('#selectpicker option:not([value="all"])').prop('selected', false);
            selectedValues2='all';
            } else {
                // Enable all options
                $('#selectpicker option').prop('disabled', false);
            }

            // Refresh the selectpicker to apply changes
            $('#selectpicker').selectpicker('refresh');

           get_branch_list(regions,selectedValues2);
          });

           
           }

          });

       
   

    });


   function get_branch_list(regions,statelist){
    //alert(statelist);

    var _token = $('input[name="_token"]').val();

      $.ajax({
           url:"{{ route('get_branch_list') }}",
           method:"GET",
           data:{regions:regions,states:statelist, _token:_token },
           dataType:"json",
           success:function(data)
           {
           // alert(data);
            console.log(data);

            var optionsbranch = '<option value="all">All</option>';

            $.each(data, function(index, item) {
            
              optionsbranch += '<option value="' + item.id + '">' + item.branch_code + '-' + item.district + '</option>';
            });

            // Generate the multiselect dropdown HTML
            var selectPickerbranch = '<select id="branches" multiple="multiple" class="form-control selectpicker" name="branches[]" required>' + optionsbranch + '</select>';

            console.log('Generated HTML:', selectPickerbranch); // Debugging
            // Append the HTML to the container
            $('#multiselect-branch-container').html(selectPickerbranch);

            // Initialize the multiselect plugin
            $('#branches').selectpicker();

            $('#branches').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            var branchlist = $(this).val();
            
            if (branchlist && branchlist.includes('all')) {
            // Disable all options except "All"
            $('#branches option:not([value="all"])').prop('selected', false);
            branchlist='all';
            } else {
                // Enable all options
                $('#branches option').prop('disabled', false);
            }
             $('#branches').selectpicker('refresh');
          
             });
            
           
           }

          });
   } 
      

  });
</script>


@endsection

