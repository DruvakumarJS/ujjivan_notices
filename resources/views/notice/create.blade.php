@extends('layouts.app')

@section('content')



<div class="container-body">
  <label class="label-bold">Create New Notice</label>
    <div class="container-header">
        
    </div>

    <div class="page-container">
       <hr/>
      
       <form method="POST" action="{{ route('save_notice')}}">
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
                    <span class="" id="basic-addon3">Is PAN India Notice ? * </span>
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
                    <span class="" id="basic-addon3">Is Region Wise Notice ? * </span>
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
                    <span class="" id="basic-addon3">Select Regions  </span>
                  </div>
            </div> 
          <div class="col-6">
             <div class="input-group mb-3">
             <select class="form-control selectpicker" multiple name="regions[]" id="region_list" >
                <option value="East">East</option>
                <option value="West">West</option>
                <option value="North">north</option>
                <option value="South">south</option>
              </select>

              </div>
            </div>
       </div>


       <div class="row" id="state_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Is State wise Notice ?  </span>
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
                    <span class="" id="basic-addon3">Select States  </span>
                  </div>
            </div> 
          <div class="col-6">
             <div class="input-group mb-3">
             <select class="form-control selectpicker" multiple search="true" name="states[]" id="state_list" >
                <option value="Karnataka">Karnataka</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Kerala">Kerala</option>
                <option value="Telangana">Telangana</option>
              </select>

              </div>
            </div>
       </div>

       <div class="row" id="state_dropdown_list">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Available Languages</span>
                  </div>
            </div> 
          <div class="col-6">
             <div class="input-group mb-3">
             <select class="form-control selectpicker" multiple search="true" name="lang[]" required="" >
                <option value="Kannada">Kannada</option>
                <option value="English">English</option>
                <option value="Hindi">Hindi</option>
                <option value="Urdu">Urdu</option>
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
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                 </select>
                </div>
            </div>   
       </div>

    
       
       <div id="div3" class="div-margin">
         <button class="btn btn-success" type="submit">Submit</button> 
       </div>

     </form>
    </div>    
    
</div>

<script type="text/javascript">
  var mode = document.getElementById("pan").value;
  //$('#region_list').prop('disabled', true);
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
 
</script>




@endsection