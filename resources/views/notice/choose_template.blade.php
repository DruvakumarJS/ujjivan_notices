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
</style>

<div class="container-body">
	<label class="label-bold">Templates</label>
	<div class="container-header">
		
	</div>

	<div class="page-container">
     <form method="GET" action="{{route('create_notice')}}">
     	@csrf
		<div class="row div-margin">
			@foreach($data as $key=>$value)

				<div class="col-md-2 col-lg-2 col-sm-2">
					 <label>
          <input class="div-margin" type="radio" name="template_id" value="{{$value->id}}" selected required class="card-input-element" style="margin-left: 30px" /><span style="margin-left: 10px">{{ $value->name}}</span>

				  <div class="card border border-primary" style="height: 400px">

				  	

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
       <div id="div3">
       	<button class="btn btn-primary">Proceed</button>
       </div>
		
	</form>	
	
</div>

@endsection