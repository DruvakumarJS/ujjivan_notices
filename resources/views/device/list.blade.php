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
            <th>Region Name</th>
            <th>Branch Code</th>
            <th>Branch Name</th>
            <th>Address</th>
            <th>State</th>
            <th>Device Status</th>
            <th>Last updated</th>
            <th></th>
            
					</tr>
				</thead>

				<tbody>
          @foreach($data as $key=>$value)
					<tr>
            <td>{{$value->branch->region->name}}</td>
            <td>{{$value->branch->branch_code}}</td>
            <td>{{$value->branch->name}}</td>
            <td>{{$value->branch->area}} , {{$value->branch->city}} ,{{$value->branch->district}} , {{$value->branch->pincode}}</td>
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

            if($day_diffrence_minutes !=0 && $diffrence_minutes > 120){ $status='Dead'; }

            elseif($diffrence_minutes > 120){$status='Offline';}

            else {$status='Online';}
            

            if($status == 'Online')$clor = '#008000';
            if($status == 'Offline')$clor = '#FFA500';
            if($status == 'Dead')$clor = '#FF0000';
             
            @endphp
            <td style="color: {{ $clor }} ">{{$status}}</td>
            <td>{{$value->last_updated_date}}</td>
            <td width="250px">
              <a href="{{ route('view_device_datails',$value->id)}}"><button class="btn btn-sm btn-outline-primary">Details</button></a>
              <a href="{{ route('edit_device_datails',$value->id)}}"><button class="btn btn-sm btn-outline-secondary">Edit</button></a>
              <a onclick="return confirm('You are deleting a Device?')" href="{{ route('delete_device_datails',$value->id)}}"><button class="btn btn-sm btn-outline-danger">Delete</button></a>
              <a href="{{ route('analytics',$value->id)}}"><button class="btn btn-sm btn-dark text-white">Analytics</button></a>
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


<div class="modal" id="mymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add Stock</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            <div class="modal-body">
                 
             <div class="form-build">
              <div class="row">
                <div class="col-6">
                  <form method="post" action="" enctype="multipart/form-data" >
                    @csrf
                    

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Category*</label>
                      <div class="col-7">
                         <select class="form-control form-select" name="category" required>
                           <option value="">Select Category </option>
                           <option value="Spray">Spray</option>
                           <option value="Nutrition">Nutrition</option>
                           <option value="Seeds">Seeds</option>
                           <option value="others">others</option>
                         </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Product Name*</label>
                      <div class="col-7">
                          <input class="form-control" name="name" type="text" placeholder="Enter Product Name" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Product Brand *</label>
                      <div class="col-7">
                          <input class="form-control" name="brand" type="text" placeholder="Enter Brand Name"  required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Weight/Volume/Count* </label>
                      <div class="col-7">
                          <input class="form-control" name="weight" type="number" placeholder="Enter Product Weight/Volume" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Measurement* </label>
                      <div class="col-7">
                         <select class="form-control form-select" name="measurement">
                           <option value="">Select</option>
                           <option value="kg">kg</option>
                           <option value="grams">grams</option>
                           <option value="liter">liter</option>
                           <option value="ml">ml</option>
                           <option value="numbers">numbers</option>
                         </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Expiry Date </label>
                      <div class="col-7">
                          <input class="form-control" name="expiry" type="date"  >
                      </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-4 col-form-label">Source of Import </label>
                        <div class="col-7">
                            <input class="form-control" name="source" type="text" placeholder="Enter Address of the Source"  >
                        </div>
                      </div>


                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Product Comments * </label>
                      <div class="col-7">
                        <textarea class="form-control" placeholder="Comments here..." name="comments" required></textarea>
                      </div>
                    </div>



                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Product Image </label>
                      <div class="col-7">
                        <input class="form-control" type="file" name="image">
                      </div>
                    </div>
                    
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-outline-success">Save </button>
                        <button type="button" class="btn btn-sm btn-outline-primary"data-bs-dismiss="modal" aria-label="Close">Close</button>
                      </div>
                  </form>
                  
                </div>
                
              </div>
               
             </div>

            </div>

           
          </div>
        </div>
      </div>

<script>
	$(document).ready(function(){
		$('#updateModal').click(function(){

		  $('#updatemodal').modal('show');
		});
	});  
</script>      
@endsection