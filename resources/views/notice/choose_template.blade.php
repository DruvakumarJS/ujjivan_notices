@extends('layouts.app')

@section('content')
<style type="text/css">
	.table-condensed{
  font-size: 10px;
}

tr {
   line-height: 10px;
   min-height: 10px;
   height: 10px;
}
.dropdown-menu{
    transform: translate3d(0px, 35px, 0px)!important;

}

body {
  overflow: hidden; /* Hide scrollbars */
}


</style>

<div class="container-body">
	<label class="label-bold">Templates</label>
	<div class="container-header">
		
	</div>

	<div class="page-container">
   
     <form method="POSt" action="{{route('create_notice')}}">
     	@csrf
		<div class="row div-margin">
       <p class="label-bold"> * Please select type of Notice you want to create</p>
        <div class="div-margin">
           <input type="radio" id="ujjivan" name="notice_type" value="ujjivan" onchange="handleChange(this);" checked >
           <label for="html">Statndard Ujjivan Notice</label>
           <input type="radio" id="rbi" name="notice_type" value="rbi" style="margin-left: 30px;" onchange="handleChange(this);">
           <label for="html">RBI Notice</label><notice_type>

           <input type="radio" id="custom_ujjivan" name="notice_type" value="custom_ujjivan" style="margin-left: 30px;" onchange="handleChange(this);">
           <label for="html">Custom Ujjivan Notice</label><notice_type>
        </div>

        <div class="text-sm-start div-margin" >
          <span class="label-bold" id="basic-addon3"> * Select Languages for creating Notice</span>
        </div>
        
        <div class="row" id="state_dropdown_list" >
          <div class="col-10">
             <div class="input-group mb-3">

              <select class="selectpicker"  multiple search="true" id="languages" name="lang[]" required="" onchange="selectedValues()" style="height: 100%;border-color: red">
                @foreach($languages as $key=>$value)
                <option value="{{$value->code}}">{{$value->lang}} - {{$value->name}}</option>

                @endforeach
                
              </select>

              </div>
            </div>
        </div>

         
     <div id="templates" class="d-flex">
    
			@foreach($data as $key=>$value)

				<div class="col-md-2 col-lg-2 col-sm-2 ms-1" >
					 <label>
          <input class="div-margin radioInput" type="radio" name="template_id" value="{{$value->id}}" selected required class="card-input-element" style="margin-left: 30px" /><span style="margin-left: 10px">{{ $value->name}}</span>

				  <div class="card border border-primary" style="height: 250px;min-width: 200px">

				  	

				  	@php
             $details = $value->details ;
             $arr = json_decode($details);
				  	@endphp

				  	@foreach($arr as $keys=>$values)
                   <!-- <label style="color: black">{{ $values->coloum }}</label> -->
                   @php
                     $data = explode(',',$values->coloum);
                   @endphp
                   
                   
                   @if(sizeof($data) == 1)
                    @foreach($data as $views)
                       
                       @if($views == 'textarea')
                         <textarea class="form-control div-margin" style="height: 20px" placeholder="your text" disabled="disabled"></textarea>
                         <!-- <div class="textareaElement form-control div-margin" contenteditable dis></div> -->
                          @elseif($views == 'table')
                          <input type="button"class="btn btn-dark div-margin" value="Table">

                       @else
                         <img class="div-margin" src="{{ url('/')}}/placeholder.jpg" style="height: 50px;display: block;margin-left:auto;margin-right: auto ">
                       @endif

                   @endforeach
                    
                   @elseif(sizeof($data) == 2)
                   
                    <div class="row div-margin">
                       @foreach($data as $views2)
                      <div class="col-md-6">
                        @if($views2 == 'textarea')
                        <textarea class="form-control" style="height: 50px" readonly></textarea>
                        @elseif($views2 == 'table')
                          <input type="button"class="btn btn-dark " value="Table">

                        @else
                        <img src="{{ url('/')}}/placeholder.jpg" style="height: 50px;display: block;margin-left:auto;margin-right: auto ">
                        @endif
                      </div>
                       @endforeach
                      
                      
                    </div>

                   
                   @else
                   
                    <div class="row div-margin">
                       @foreach($data as $views3)
                      <div class="col-md-4">
                        @if($views3 == 'textarea')
                        <textarea class="form-control" style="height: 50px" readonly></textarea>
                        @elseif($views3 == 'table')
                          <input type="button"class="btn btn-dark " value="Table">

                        @else
                       <img  src="{{ url('/')}}/placeholder.jpg" style="height: 50px;width:40px;display: block;margin-left:auto;margin-right: auto ">
                        @endif
                      </div>
                       @endforeach
                      
                      
                    </div>

                   @endif
                  
                @endforeach
                   
				  </div>
				</label>
				</div>

			@endforeach
			 </div>
	
        <input type="hidden" name="dropdown_lang" value="{{$lang}}">

       <div id="div">
       	 <button class="btn btn-primary" id="fixedbutton">Proceed</button>
       </div>

		</div>
	</form>	
	
</div>

<script type="text/javascript">
   function handleChange(src) {
  var x = document.getElementById("templates");
  if(src.value == 'ujjivan'){
  
   // $('#templates').removeClass('d-none');
    $(".radioInput").prop("required", true);
    $(".radioInput").prop("disabled", false);
    
  }
  else if(src.value == 'custom_ujjivan'){
  
     $(".radioInput").removeAttr("required");
     $(".radioInput").prop("disabled", true);
     $(".radioInput").prop("checked", false);

     $('#languages').selectpicker('val',['en']);
    // $('#languages').prop("disabled", true);


    
  }
  else{
    // $('#templates').addClass('d-none');
     $(".radioInput").removeAttr("required");
     $(".radioInput").prop("disabled", true);
     $(".radioInput").prop("checked", false);
    
  }
  }

  $(document).ready(function() {
    $('.languages').selectpicker();
});
</script>

@endsection