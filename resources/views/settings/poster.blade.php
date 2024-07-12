@extends('layouts.app')

@section('content')

<div class="container-header">
 
</div>

<div class="container-body">
  <label class="label-bold">Poster and Disclaimer</label>

    <div>
         @if(Session::has('message'))
            <p id="mydiv" class="text-danger text-center">{{ Session::get('message') }}</p>
        @endif 
     
         @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      
                  @endforeach
                  <li>{{ $error }}</li>
              </ul>
          </div>
        @endif   
    </div>

    <div class="page-container div-margin">
      <form method="post" action="{{ route('update_poster')}}" enctype="multipart/form-data" >
        @csrf

          <hr/>
          <label class="label-bold">Display Standiee Disclaimer </label>

          <div class="form-group row div-margin">
            <label for="" class="col-2 col-form-label">Disclaimer (Bottom)*</label>
            <div class="col-6">
                <textarea class="form-control" name="disclaimer2" onkeyup="textAreaAdjust(this)" style="overflow:hidden" required></textarea>
            </div>
          </div>  

          <hr/>
          <label class="label-bold">Display Standiee Poster </label>
          <p>A full screen image wil be displayed in display standiee when it is set to active for the provided interval .Later the application will rollouts automatically to show notices . </p>

          <div class="form-group row div-margin">
            <label for="" class="col-2 col-form-label">Advertisement </label>
            <div class="col-6">
                <select class="form-control form-select" name="announcement" onchange="handleChange(this);" >
                  <option value="">Select</option>
                  <option value="1" >Active</option>
                  <option value="0" >Inactive</option>
                </select>
            </div>
          </div>

          <div class="form-group row div-margin">
            <label for="" class="col-2 col-form-label">Start Date and Time </label>
            <div class="col-6">
                <input class="form-control" type="datetime-local" name="start" id="start" >
            </div>
          </div>

          <div class="form-group row div-margin">
            <label for="" class="col-2 col-form-label">End Date and Time </label>
            <div class="col-6">
                <input class="form-control" type="datetime-local" name="end" id="end" >
            </div>
          </div>

          <div class="form-group row div-margin">
            <label for="" class="col-2 col-form-label">File </label>
            <div class="col-6">
                <input class="form-control" type="file" name="announcement_file" id="announcement_file" accept="image/*">
            </div>
          </div>
  
          <p>NOTE : To update Poster and Disclaimer to a particular branch , please visit Branch Master -> Edit -> update  . </p>
          <p>Use this interface to update Poster and Disclaimer to all branches at single shot .</p>
         <div class="div-margin" >
            
            <button type="submit" class="btn btn-sm btn-outline-success">Submit </button>
            
          </div>
      </form>
            
  
    </div>    
    
</div>

<script type="text/javascript">
  function textAreaAdjust(element) {
  element.style.height = "1px";
  element.style.height = (25+element.scrollHeight)+"px";
}

$('select').on('change', function() {
   
   //alert(this.value);
   if(this.value == '1'){
     $('#start').prop('required',true);
     $('#end').prop('required',true);
     $('#announcement_file').prop('required',true);
   }
   else{
     $('#start').prop('required',false);
     $('#end').prop('required',false);
     $('#announcement_file').prop('required',false);
   }
  });

</script>
  
@endsection