@extends('layouts.login')

@section('content')

<div class="container-body">
  
	<div class="container-header">
	
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
		            
				  </tr>		
		          @endforeach
				</tbody>
			</table>

     
		</div>
		
	</div>
	
</div>

    
@endsection