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
   <label class="label-bold">Create New Notice</label>
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
      
       <form method="POST" action="{{ route('update_multi_rbi_notice_datails')}}" enctype="multipart/form-data">
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

       <div class="row" id="region_dropdown_list" id="region_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Select Region(s) </span>
                  </div>
            </div> 
          <div class="col-6">
             <div class="input-group mb-3">
            <select class="form-control selectpicker" multiple name="regions[]" id="region_list">
             
                @foreach($regions as $key=>$value)
                   <option value="{{$value->id}}" <?php echo(in_array($value->id,explode(',',$data->regions)) )?'selected':'' ?> >{{$value->name}}</option>
                @endforeach
              </select>

              </div>
            </div>
       </div>

        <input type="hidden" name="" id="sel_states" value="{{$data->states}}">
        <div class="row" id="state_dropdown_list">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Select State(s) </span>
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

       <input type="hidden" name="" id="sel_branches" value="{{$data->branch_code}}">
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
                 <input class="form-control" type="text" name="document_id" value="{{$data->document_id}}" maxlength="10" required>
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
                 <input class="form-control" type="text" name="version" value="{{$data->version}}" maxlength="10" required>
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

       @foreach($rbi_data as $keyl=>$value)
        <hr/>
        <div class="row">
         <div style="width: 1000px" >
          <div class="card">
            <h5 class="card-header">
                    <a data-toggle="collapse" href="#collapse-example" aria-expanded="true" aria-controls="collapse-example" id="heading-example" class="d-block">
                        <i class="fa fa-chevron-down pull-right"></i>
                        {{$value['lang_name']}}
                    </a>
                </h5>

                   <div id="collapse-example" class="collapse show" aria-labelledby="heading-example">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                              <div class="text-sm-end" >
                               <span class="" id="basic-addon3">{{ __('Notice Tittle *') }}</span>

                              </div>
                            </div> 
                            <div class="col-6">
                                <div class="input-group mb-3">
                                 <input class="form-control" type="text" name="notice[{{$keyl}}][tittle]" value="{{$value->name}}" maxlength="250" required>
                                </div>
                            </div>   
                       </div>
                       
                       <div class="row">
                            <div class="col-2">
                              <div class="text-sm-end" >
                                <span class="" id="basic-addon3">{{ __('Notice Description *') }}</span>
                              </div>
                            </div> 
                            <div class="col-6">
                                <div class="input-group mb-3">
                                 <input class="form-control" type="text" name="notice[{{$keyl}}][description]" value="{{$value->description}}" maxlength="250" required>
                                </div>
                            </div>   
                       </div>

                        <div class="row" id="state_div">
                          <div class="col-2">
                                <div class="text-sm-end" >
                                  <span  id="basic-addon3">Repalce File </span>
                                </div>
                          </div> 
                          <div class="col-6" id="state_dropdown">
                              <div class="input-group mb-3">
                                 <input type="file" name="notice[{{$keyl}}][rbi_file]" accept="application/pdf">
                              </div>
                          </div>   
                       </div>

                      
                       <input type="hidden" name="notice[{{$keyl}}][langauge]" value="{{$value->lang_code}}">
                      <input type="hidden" name="notice[{{$keyl}}][id]" value="{{$value->id}}">
                  </div>
                </div> 
              </div> 
            
       @endforeach


       <input type="hidden" name="selected_lang_code" value="{{$langarray}}">
       <input type="hidden" name="notice_group" value="{{$id}}">
       <input type="hidden" name="default_lang" value="{{$lang}}">
        
      
  

      <input type="hidden" name="selected_languages" value="{{$selected_languages}}">
      <div id="div3" class="div-margin">
         <button class="btn btn-success" type="submit">Update</button> 
      </div>

     </form>
   </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
     // $('#region_list').prop('disabled', true);
      $('#state_list').prop('disabled', true);
      $('#region_list').prop('disabled', true);
      $('#branch_list').prop('disabled', true);

      var pan = document.getElementById("pan").value;
      if(pan == 'No'){
         $('#state_list').prop('disabled', false);
         $('#region_list').prop('disabled', false);
         $('#branch_list').prop('disabled', false);
      }
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

           /*$('#selectpicker1').prop('disabled', false);
           $('#selectpicker1').selectpicker('refresh');
           
           $('#branches').prop('disabled', false);
           $('#branches').selectpicker('refresh');*/

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
    //get staes list

     var _token = $('input[name="_token"]').val();
     var selectedValues = $('#region_list').val();
     var selected_states =$('#sel_states').val() ;
   
      $.ajax({
           url:"{{ route('get_states_list') }}",
           method:"GET",
           data:{regions:selectedValues, _token:_token },
           dataType:"json",
           success:function(data)
           {
            //alert(data);
            console.log(data);

            var optionsHtml = '';

            $.each(data, function(index, item) {
              var statename = item.state;
              //alert(selected_states);
            
              optionsHtml += '<option value="' + item.state + '" >' + item.state + '</option>';
            });

            // Generate the multiselect dropdown HTML
            var selectPickerHtml1 = '<select id="selectpicker1" multiple="multiple" class="form-control selectpicker" name="states[]" required >' + optionsHtml + '</select>';

            console.log('Generated HTML:', selectPickerHtml1); // Debugging
            // Append the HTML to the container
            $('#multiselect-container').html(selectPickerHtml1);

            // Initialize the multiselect plugin
           
            var stateArray = selected_states.split(",");
          
            $('#selectpicker1 option').each(function() {
            if (stateArray.includes($(this).val())) {
              $(this).prop('selected', true);
            }
          });

          // Refresh selectpicker after updating selected options
          $('#selectpicker1').selectpicker('refresh');
           $('#selectpicker1').selectpicker();
            set_branch_list(stateArray);

           }

          });

    //end

     function set_branch_list(statelist){
   
    
    var _token = $('input[name="_token"]').val();
    var branchCode = $('#sel_branches').val();

      $.ajax({
           url:"{{ route('get_branch_list') }}",
           method:"GET",
           data:{states:statelist, _token:_token },
           dataType:"json",
           success:function(data)
           {
           // alert(data);
            console.log(data);

            var optionsbranch = '';

            $.each(data, function(index, item) {
            
              optionsbranch += '<option value="' + item.id + '">' + item.branch_code + '-' + item.district + '</option>';
            });

            // Generate the multiselect dropdown HTML
            var selectPickerbranch = '<select id="branches" multiple="multiple" class="form-control selectpicker" name="branches[]" required>' + optionsbranch + '</select>';

            console.log('Generated HTML:', selectPickerbranch); // Debugging
            // Append the HTML to the container
            $('#multiselect-branch-container').html(selectPickerbranch);

             var branchArray = branchCode.split(",");
          
            $('#branches option').each(function() {
            if (branchArray.includes($(this).val())) {
                $(this).prop('selected', true);
              }
            });

          // Refresh selectpicker after updating selected options
          $('#branches').selectpicker('refresh');

            // Initialize the multiselect plugin
            $('#branches').selectpicker();

            $('#branches').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            var branchlist = $(this).val();
            if(clickedIndex == '0'){
              //alert('ll');
            }
          
             });
            
           
           }

          });
   }



    //end set branch 




    $('#region_list').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
      var selectedValues = $(this).val();
     // alert(selectedValues);

      

      var _token = $('input[name="_token"]').val();

      $.ajax({
           url:"{{ route('get_states_list') }}",
           method:"GET",
           data:{regions:selectedValues, _token:_token },
           dataType:"json",
           success:function(data)
           {
           // alert(data);
            console.log(data);

            var optionsHtml = '';

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
            //console.log('Selected Values:', selectedValues2);

           get_branch_list(selectedValues2);
          });

           
           }

          });

       
   

    });


   function get_branch_list(statelist){
    //alert(statelist);

    var _token = $('input[name="_token"]').val();

      $.ajax({
           url:"{{ route('get_branch_list') }}",
           method:"GET",
           data:{states:statelist, _token:_token },
           dataType:"json",
           success:function(data)
           {
           // alert(data);
            console.log(data);

            var optionsbranch = '';

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
            if(clickedIndex == '0'){
              //alert('ll');
            }
          
             });
            
           
           }

          });
   } 

  

  });
</script>


@endsection

