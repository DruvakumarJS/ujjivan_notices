@extends('layouts.app')

@section('content')

<div class="container-body">
 
	<div class="container-header">
		
		<div id="div2">
			<a href="{{ route('add_device')}}"><button class="btn btn-outline-primary">Register New Device</button></a>
		</div> 

    <div id="div2" style="margin-right: 30px">
           <form method="POST" action="{{route('search_device')}}">
            @csrf
             <div class="input-group mb-3">
                <input class="form-control" type="text" name="search" placeholder="Search here" value="{{$search}}">
                <div class="input-group-prepend">
                   <button class="btn btn-outline-secondary rounded-0" type="submit" >Search</button>
                </div>
              </div>
           </form>
          </div>
		<div id="div1">
      <label class="label-bold">Devices list</label>
    </div>
	</div>

	<div class="page-container div-margin">
		<div class="card">
			<table class="table table-responsive table-stripped">
				<thead>
					<tr>
            <th>Serial Number</th>
            <th>Region Name</th>
            <th>Branch Code</th>
            <th>Branch Name</th>
            <th>Address</th>
            <th>State</th>
            <th>Device Status</th>
            <th>Last updated</th>
            <th>Action</th>
            
					</tr>
				</thead>

				<tbody>
          @foreach($data as $key=>$value)
					<tr>
            <td id="valueToCopy{{$key}}">{{$value->deviceID}}</td>
            <td>{{$value->branch->region->name}}</td>
            <td>{{$value->branch->branch_code}}</td>
            <td>{{$value->branch->name}}</td>
            <td width="200px">{{$value->branch->area}} , {{$value->branch->city}} ,{{$value->branch->district}} , {{$value->branch->pincode}}</td>
            <td>{{$value->branch->state}}</td>
            @php

            $last_updated_time = strtotime($value->last_updated_date);
            $last_updated_date = date('Y-m-d',strtotime($value->last_updated_date));
            $current_time = strtotime(date('Y-m-d H:i'));
            $cur_date = (date('Y-m-d'));

            $diffrence_sec = $current_time - $last_updated_time ;
            $diffrence_minutes = $diffrence_sec/60 ;

            $day_diffrence = strtotime($cur_date) - strtotime($last_updated_date) ;
            $day_diffrence_minutes = $day_diffrence/60 ;

            if($day_diffrence_minutes !=0 && $diffrence_minutes > 2880){ $status='Dead'; }

            elseif($diffrence_minutes > 120 && $diffrence_minutes < 2880){$status='Offline';}

            else {$status='Online';}
            

            if($status == 'Online')$clor = '#008000';
            if($status == 'Offline')$clor = '#FFA500';
            if($status == 'Dead')$clor = '#FF0000';
             
            @endphp
            <td style="color: {{ $clor }} ">{{$status}}</td>
            <td>{{($value->last_updated_date != '')?date(date('d-m-Y H:i',strtotime($value->last_updated_date))):''}}</td>
            <td width="250px">
              <a href="{{ route('view_device_datails',$value->id)}}"><button class="btn btn-sm btn-outline-primary">Details</button></a>
              <a href="{{ route('edit_device_datails',$value->id)}}"><button class="btn btn-sm btn-outline-secondary">Edit</button></a>
              <a onclick="return confirm('You are deleting a Device?')" href="{{ route('delete_device_datails',$value->id)}}"><button class="btn btn-sm btn-outline-danger">Delete</button></a>
              <a href="{{ route('analytics',$value->id)}}"><button class="btn btn-sm btn-dark text-white">Analytics</button></a><div style="height: 2px"></div>
                <button class="btn btn-sm btn-warning text-white" onclick="copyAndRedirect('{{$value->deviceID}}')" >Remote</button>

            </td>
            
						
					</tr>

          
          @endforeach
				</tbody>
			</table>

      <label>Showing {{ $data->firstItem() }} to {{ $data->lastItem() }}
                of {{$data->total()}} results</label>

            {!! $data->links('pagination::bootstrap-4') !!}
			
		</div>
		
	</div>
	
</div>

<script>
    function copyAndRedirect(valueToCopy) {
     // alert(valueToCopy)
        // Copy the value to the clipboard
        var tempInput = document.createElement("input");
        tempInput.style.position = "absolute";
        tempInput.style.left = "-9999px";
        tempInput.value = valueToCopy;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);

        // URL to open
        var url = "https://biz.airdroid.com/#/devices/list/-100";

        // Open the URL
        window.open(url, "_blank");
    }
</script>


    
@endsection