@extends('layouts.app')

@section('content')
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/super-build/ckeditor.js"></script>

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

<!-- <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
 -->

<div class="container-body">
  <label class="label-bold">Edit RBI Notice</label>
    <div class="container-header">
        
    </div>

    <div class="page-container">
       <hr/>
      
       <form method="POST" action="{{ route('update_rbi_notice_datails',$id)}}" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Notice Tittle * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">
                 <input class="form-control" type="text" name="tittle" value="{{$data->name}}" required>
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
                 <input class="form-control" type="text" name="description" value="{{$data->description}}" required>
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
                    <span class="" id="basic-addon3">State-wise </span>
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
                    <span class="" id="basic-addon3">Select State(s)  </span>
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
                    <span class="" id="basic-addon3">NB ID</span>
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
                 <input class="form-control" type="text" name="version" value="{{$data->version}}" required>
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
                 <input class="form-control" type="text" name="publish_date" id="publish_date" value="{{$data->published_date}}" autocomplete="off"  required>
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
                 <input class="form-control" type="file" name="rbi_file" >
                </div>
            </div>   
       </div>
        <input type="hidden" name="lang" value="{{$data->lang_code}}">


      

      
       <input type="hidden" name="id" value="{{$id}}">
       
       
       <div id="div3" class="div-margin">
         <button class="btn btn-success" type="submit">Submit</button> 
       </div>

     </form>
    </div>    
    
</div>

<script type="text/javascript">
 
  //$('#region_list').prop('disabled', true);
  //$('#region_prompt').prop('disabled', true);
 // $('#state_prompt').prop('disabled', true);

  var pan = document.getElementById('pan').value;
  var region = document.getElementById('region_prompt').value;
  //alert(region);

    if(pan == 'Yes'){
     
         $('#region_prompt').prop('disabled', true);
         document.getElementById("region_prompt").required = false;

         $('#state_prompt').prop('disabled', true);
         document.getElementById("state_prompt").required = false;
    }

    else if(pan == 'No'){
      $('#region_prompt').prop('disabled', false);
         document.getElementById("region_prompt").required = true;

    }

    else if(region == 1){
     // alert(region);
         
         $('#state_prompt').prop('disabled', true);
         document.getElementById("state_prompt").required = false;
    }
    else if(region == '0'){
      alert('ll');
        $('#state_prompt').prop('disabled', false);
         document.getElementById("state_prompt").required = true;
    }



   $('select').on('change', function() {
    //alert(this.value);
     
       if(this.value == "No"){
          
           $('#region_prompt').prop('disabled', false);
           document.getElementById("region_prompt").required = true;
       }

       if(this.value == "Yes"){
          
           $("#region_prompt").val("0");
           $("#state_prompt").val("na");

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