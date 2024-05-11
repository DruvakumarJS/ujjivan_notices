@extends('layouts.publictemp')

@section('content')
 <style>
        /* Override Bootstrap card padding */
        .card {
            padding-left: 10px; /* Set padding to 0 or adjust as needed */
            padding-right: 10px;
            padding-bottom: 10px;
            padding-top: 0px;
            border-radius: 10px; 
            margin-bottom: 10px;
        }
        .card-title-bg {
            background-color: #088672; /* Set your desired background color */
            color: #fff; /* Set text color for better contrast */
            padding: 5px; /* Add padding for better visual appearance */
            border-bottom-left-radius: 10px; /* Match the card's border-radius */
            border-bottom-right-radius: 10px;
            width: 30px;
            text-align: center; /* Match the card's border-radius */
        }
        .new-label {
		    position: absolute;
		    top: 5px;
		    right: 5px;
		    background-color: orange; /* You can change the background color */
		    color: white;
		    padding: 3px 6px;
		    font-size: 10px;
		    border-radius: 3px;
		}
    </style>

<div class="container-body">
  
	<div class="container-header">

		
		<div class="row">
			<div class="col-6">
				<div class="input-group mb-3">
	                <select class="form-control form-select" id="languages" name="lang" >
	                @foreach($languages as $key=>$value)
	                <option {{ ( $value->code == $lang )?'selected':'' }} value="{{$value->code}}">{{$value->lang}} - {{$value->name}}</option>

	                @endforeach
	                
	              </select>

              </div>
              
			</div>
			
			<div class="col-6">
				
	             <div class="input-group mb-3">
	               
	                <select class="form-control form-select" id="notice" name="notice">
	                 <option value="">Select Notice</option>	
	                 @foreach($data as $keys=>$values)
	                <option value="{{$values->id}}">{{$values->name}}</option>

	                @endforeach
	                </select>

	              
	              </div>
	          
			</div>
			
		</div>

		
		
	
	</div> 

	<div class="page-container ">

	    <label class="label-bold">Notices</label>
	   
		<div class="row" >
			@foreach($data as $key=>$value)
			<div class="col-12">
			    @if($value->notice_type == 'ujjivan')
			    <a href="{{ URL::to('/') }}/noticefilesforweb/{{$value->lang_code}}_{{$value->filename}}" style="text-decoration:none" >
			    @else
			    <a href="{{ URL::to('/') }}/noticefiles/{{$value->lang_code}}_{{$value->filename}}" style="text-decoration:none" >
			    @endif
			    <div class="card shadow-sm border border-grey " >
			        <div class="card-title-bg label-bold" style="background-color: primary;font-size: 12px">{{  $key+1 }}</div>
			        
			        <!-- Add the "new" label here -->
			        <div class="new-label">{{ ($value->notice_type == 'ujjivan')?'Ujjivan':'RBI'}}</div>
			        
			        <h6 class="div-margin label-bold" style="font-size: 12px" >{{$value->name}}</h6>
			    </div>
			    </a>
			</div>	
			@endforeach
			
		</div>
      
			
		</div>
		
	</div>
	
</div>



<script type="text/javascript">
	$("[name='lang']").on("change", function (e) {
		//alert( window.location.origin);
     let edit_id = $(this).val();
    
     var href = window.location.origin + '/ujjivan_notices/' + edit_id ;
    // alert(href);

     window.location=href;
})
</script>

<script type="text/javascript">
	$("[name='notice']").on("change", function (e) {
		//alert( window.location.origin);
     let edit_id = $(this).val();
     let lang = '{{ $lang }}';
    // alert(lang);

    if(edit_id != ""){

      var href = window.location.origin + '/search_notice/' + lang + '/' +edit_id ;
      $("#notice").val("");
      window.location=href;
    }    
    
})
</script>



    
@endsection