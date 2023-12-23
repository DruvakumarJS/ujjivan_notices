@extends('layouts.app')

@section('content')

<div class="container-body">
  
	<div class="container-header">
		
		<div id="div2">
			<a href="{{ route('create_notice')}}"><button class="btn btn-outline-primary">Create New Notice</button></a>
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
      <label class="label-bold">Notices</label>
    </div>
	</div>

	<div class="page-container div-margin">
		<div class="card">
			<table class="table table-responsive table-stripped">
				<thead>
					<tr>
						<th>Name</th>
                        <th>Description</th>
						<th>PAN India</th>
			            <th>Region Specific</th>
			            <th>State Specific</th>
			            <th>Available Languages</th>
			            <th>Voice over</th>
			            <th>Status</th>
			            <th></th>
            
					</tr>
				</thead>

				<tbody>
		          @foreach($data as $key=>$value)
		          <tr>
		             <td>{{$value->name}}</td>
		             <td>{{$value->description}}</td>
		             <td>{{$value->is_pan_india}}</td>
		             <td>{{($value->is_region_wise == '1')?'Yes':'No'}}</td>
		             <td>{{($value->is_state_wise == 'ya')?'Yes':'No'}}</td> 
		             <td>{{$value->available_languages}}</td>
		             <td>{{$value->voiceover}}</td> 
		             <td>{{$value->status}}</td>
		             <td>
		             	 <a href="{{ route('view_notice_datails',$value->id)}}"><button class="btn btn-sm btn-outline-primary">View More</button></a>
			             <a href="{{ route('edit_notice_datails',$value->id)}}"><button class="btn btn-sm btn-outline-secondary">Edit</button></a>
			             <a onclick="return confirm('You are deleting a Notice?')" href="{{ route('delete_notice_datails',$value->id)}}"><button class="btn btn-sm btn-outline-danger">Delete</button></a>
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

    
@endsection