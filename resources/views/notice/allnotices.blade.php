@extends('layouts.publictemp')

@section('content')
 <style>
        /* Override Bootstrap card padding */
        .card {
            padding: 0; /* Set padding to 0 or adjust as needed */
            padding-left: 20px;
            padding-bottom: 20px;
            border-radius: 10px; 
        }
        .card-title-bg {
            background-color: #088672; /* Set your desired background color */
            color: #fff; /* Set text color for better contrast */
            padding: 10px; /* Add padding for better visual appearance */
            border-bottom-left-radius: 10px; /* Match the card's border-radius */
            border-bottom-right-radius: 10px;
            width: 40px;
            text-align: center; /* Match the card's border-radius */
        }
    </style>

<div class="container-body">
  
	<div class="container-header">

		<div class="row">
			  <div class="input-group mb-3">
	                <select class="form-control form-select" id="languages" name="lang" >
	                @foreach($languages as $key=>$value)
	                <option {{ ( $value->code == $lang )?'selected':'' }} value="{{$value->code}}">{{$value->name}}</option>

	                @endforeach
	                
	              </select>

              </div>



              <div >
	           <form method="GET" action="{{route('search_public_notice')}}"  >
	            @csrf
	             <div class="input-group mb-3">
	                <input class="form-control" type="text" name="search" placeholder="Search here" value="{{$search}}">

	                 <input type="hidden" name="lang" value="{{$lang}}">
	                <div class="input-group-prepend">
	                   <button class="btn btn-outline-secondary rounded-0" type="submit" >Search</button>
	                </div>
	              </div>
	           </form>
        </div> 
	
			
		</div>

		
		
	
	</div> 

	<div class="page-container div-margin">

	    <label class="label-bold">Notices</label>
	   
		<div class="row no-gutters" >
			@foreach($data as $key=>$value)
				<div class="col-md-6 col-sm-6">
					<a href="{{ URL::to('/') }}/noticefiles/{{$value->lang_code}}_{{$value->filename}}" style="text-decoration:none" >
					<div class="card shadow-sm border border-grey " >
						<div class="card-title-bg" style="background-color: primary">{{ $key+1}}</div>
						<h6 class="div-margin label-bold" style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;">{{$value->name}}</h6>
						<label style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;">{{ $value->description}}</label>
					</div>
					</a>
				</div>
			@endforeach
			
		</div>
      <label>Showing {{ $data->firstItem() }} to {{ $data->lastItem() }}
                of {{$data->total()}} results</label>

            {!! $data->appends('abc')->links('pagination::bootstrap-4') !!}
			
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



    
@endsection