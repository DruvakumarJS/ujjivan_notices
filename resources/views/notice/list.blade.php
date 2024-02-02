@extends('layouts.app')

@section('content')

<div class="container-body">
  
	<div class="container-header">
		
		<div id="div2">
			<a href="{{ route('choose_template')}}"><button class="btn btn-outline-primary">Create New Notice</button></a>
		</div> 

        <div id="div2" style="margin-right: 30px">
           <form method="GET" action="{{route('search_notice')}}">
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

        <!-- <div id="div2" style="margin-right: 30px">
           <form method="GET" action="{{route('notices',$lang)}}">
            @csrf
             <div class="input-group mb-3">
                <select class="form-control form-select" id="languages" name="lang" onchange="if(this.value != 0) { this.form.submit(); }">
                @foreach($languages as $key=>$value)
                <option {{ ( $value->code == $lang )?'selected':'' }} value="{{$value->code}}">{{$value->name}}</option>

                @endforeach
                
              </select>

              
              </div>
           </form>
        </div> -->

        <div id="div2" style="margin-right: 30px">
           
             <div class="input-group mb-3">
                <select class="form-control form-select" id="languages" name="lang" >
                @foreach($languages as $key=>$value)
                <option {{ ( $value->code == $lang )?'selected':'' }} value="{{$value->code}}">{{$value->name}}</option>

                @endforeach
                
              </select>

              </div>
          
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
						<th>N ID</th>
						<th>Name</th>
                        <th>Description</th>
						<th>PAN India</th>
			            <th>Notice Type</th>

			            <th>Published Date</th>
			            <th>Version</th>
			            <th></th>
			            <th></th>
			            <th></th>
			            <th></th>
            
					</tr>
				</thead>

				<tbody>
		          @foreach($data as $key=>$value)
		          <tr>
		          	<td>{{$value->document_id}}</td>
		          	
		             <td >{{$value->name}}</td>
		             <td >{{$value->description}}</td>
		             <td>{{$value->is_pan_india}}</td>
		             <td>{{$value->notice_type}}</td>
		             <td>{{$value->published_date}}</td>
		             <td>{{$value->version}}</td> 
		             <!-- <td>{{$value->status}}</td> -->
		             <td>
		             	 <a target="_blank" href="{{ URL::to('/') }}/noticefiles/{{$lang}}_{{$value->filename}}"><button class="btn btn-sm btn-outline-primary">View</button></a>	
		             </td>
		             <td>
		             	@if($value->notice_type == 'ujjivan')
			             <a href="{{ route('edit_multi_notice_datails',[$value->notice_group,$lang])}}"><button class="btn btn-sm btn-outline-secondary">Edit</button></a>
			             @else
			             <a href="{{ route('edit_multi_rbi_notice_datails',[$value->notice_group,$lang])}}" ><button class="btn btn-sm btn-outline-secondary">Edit</button></a>
			             @endif
		             </td>
		             <td>
		             	@if($value->status == 'Draft')
		             	<a href="{{route('modify_notice_status',$value->id)}}"><button class="btn btn-sm btn-dark">Publish</button></a>
		             	@else
		             	<a  href="{{route('modify_notice_status',$value->id)}}"><button class="btn btn-sm btn-info text-white" >UnPublish</button></a>
		             	@endif

		             </td>
		           
		             <td>
		             	 <a onclick="return confirm('You are deleting a Notice?')" href="{{ route('delete_notice_datails',$value->id)}}"><button class="btn btn-sm btn-outline-danger">Delete</button></a>
		             </td>
				  </tr>		
		          @endforeach
				</tbody>
			</table>

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
    
     var href = window.location.origin + '/notices/' + edit_id ;
    // alert(href);

     window.location=href;
})
</script>



    
@endsection