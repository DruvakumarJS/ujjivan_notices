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
   
     <form method="GET" action="{{route('create_notice')}}">
     	@csrf
		<div class="row div-margin">
       <p>Type of Notice you want to create</p>
        <div class="div-margin">
           <input type="radio" id="ujjivan" name="notice_type" value="ujjivan" onchange="handleChange(this);" <?php echo($notice_type == 'ujjivan')? 'checked' : 'disabled'  ?> >
           <label for="html">Ujjivan Notice</label>
           <input type="radio" id="rbi" name="notice_type" value="rbi" style="margin-left: 30px;" onchange="handleChange(this);" <?php echo($notice_type == 'rbi')? 'checked' : 'disabled'  ?> >
           <label for="html">RBI Notice</label><notice_type>
        </div>

        <div class="text-sm-start div-margin" >
          <span class="" id="basic-addon3">Select Languages for creating Notice</span>
        </div>

        <div class="row" id="state_dropdown_list" >
          <div class="col-10">
             <div class="input-group mb-3">

              <select class="selectpicker"  multiple search="true" id="languages" name="lang[]" required="" onchange="selectedValues()"  style="height: 100%;">
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
          <input class="div-margin radioInput" type="radio" name="template_id" value="{{$value->id}}" <?php echo($value->id == $template_id)?'checked':''  ?> disabled required  class="card-input-element" style="margin-left: 30px" /><span style="margin-left: 10px">{{ $value->name}}</span>

				  <div class="card border border-primary" style="height: 250px">

				  	

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
                         <textarea class="form-control div-margin" style="height: 50px" placeholder="your text" readonly></textarea>
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
		

    
        <input type="hidden" name="noticeid" value="{{$id}}">
        <input type="hidden" name="template_id" value="{{$template_id}}">
        <input type="hidden" name="dropdown_lang" value="{{$lang}}">

       <div id="div3">
       	<button class="btn btn-primary">Proceed</button>
       </div>
		
	</form>	
	
</div>

<script type="text/javascript">

  var notice ='<?php echo $notice_type  ?>' ;
  //alert(notice);
  /*if(notice == 'ujjivan'){
  
    $('#templates').removeClass('d-none');
    $(".radioInput").prop("required", true);
    
  }
  else{
     $('#templates').addClass('d-none');
     $(".radioInput").removeAttr("required");
    
  }*/

   function handleChange(src) {
  var x = document.getElementById("templates");
  if(src.value == 'ujjivan'){
  
    $('#templates').removeClass('d-none');
    $(".radioInput").prop("required", true);
    
  }
  else{
     $('#templates').addClass('d-none');
     $(".radioInput").removeAttr("required");
    
  }
  }
</script>

@endsection