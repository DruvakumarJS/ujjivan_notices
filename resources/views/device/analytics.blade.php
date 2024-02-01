@extends('layouts.app')

@section('content')

<div class="container-body">
 
	<div class="container-header">
		
		<div id="div2">
			<a href="{{ route('devices')}}"><button class="btn btn-outline-primary">Device List</button></a>
		</div> 

    <div id="div2" style="margin-right: 30px">
       <form method="POST" action="{{route('get_device_health_data')}}" >
        @csrf
         <div class="input-group mb-3">
            <input class="form-control" id="date" type="text" name="search_date" autocomplete="off" value="{{$date}}" >
            <div class="input-group-prepend">
               <button class="btn btn-outline-secondary rounded-0" id="search_date" type="submit" >Search</button>
            </div>
          </div>
       </form>
      </div>

		<div id="div1">
      <label class="label-bold">Devices Analytics</label>
    </div>

	</div>

  <div class="container-body">
    <div class="card">
      <div class="row">
        <div class="col-md-6">
          <label class="label-bold">Branch Name : </label> <label>{{$data->branch->name}} , {{$data->branch->branch_code}},{{$data->branch->ifsc}}</label>
        </div>
        <div class="col-md-6">
          <label class="label-bold">Device ID : </label> <label>{{$data->mac_id}} </label>
        </div>
       
        
      </div>

      <div class="row">
        
         <div class="col-md-6">
          <label  class="label-bold">Area : </label> <label>{{$data->branch->area}}, {{$data->branch->city}},
          {{$data->branch->state}}, {{$data->branch->pincode}}</label>
        </div>
        <div class="col-md-6">
          <label  class="label-bold">last updated date: </label> <label>{{$data->last_updated_date}}</label>
        </div>
         
        
      </div>
      
    </div>

    <label>API data : </label><label>{{$api_data}}</label>
    
  </div>
		
	</div>

  <script type="text/javascript">
  $( function() {
      $( "#date" ).datepicker({
        maxDate:0,
        dateFormat: 'yy-mm-dd',
        onSelect: function(dateText, $el) {
         // alert(dateText);
            $('#search_date').click();
           $('.date').hide();
   
        }
      });
    });

  
</script>
	

@endsection