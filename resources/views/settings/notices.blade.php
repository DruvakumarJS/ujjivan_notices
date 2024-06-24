@extends('layouts.app')

@section('content')

<style type="text/css">
	 td{
		max-width: 150px;
		overflow: hidden;
		text-overflow: clip;
		white-space: nowrap;
		}

	    ::-webkit-scrollbar {
		  height: 4px;              
		  width: 4px;    
		  }

   .scrollable-cell {
     
      overflow-x: auto;/* Display ellipsis (...) for overflowed content */
  }  

</style>

<div class="container-body">
  
	<div class="container-header">

	<div id="div1">
      <label class="label-bold">Notices</label>
    </div>

    <div id="div2" style="margin-right: 30px">
       <form method="POST" action="{{route('search_branch_notice')}}">
        @csrf
         <div class="input-group mb-3">
            <input class="form-control" type="text" name="search" placeholder="Search by Notice ID" value="{{$search}}">

             <input type="hidden" name="lang" value="{{$lang}}">
             <input type="hidden" id="branchid" name="id" value="{{$id}}">

            <div class="input-group-prepend">
               <button class="btn btn-outline-secondary rounded-0" type="submit" >Search</button>
            </div>
          </div>
       </form>
    </div>

    <div id="div2" style="margin-right: 30px">
           
         <div class="input-group mb-3">
         	<input type="hidden" id="branch_id" name="id" value="{{$id}}">
            <select class="form-control form-select" id="languages" name="lang" >
             <option value="all" >All Languages</option>	
            @foreach($languages as $key=>$value)
            <option {{ ( $value->code == $lang )?'selected':'' }} value="{{$value->code}}">{{$value->lang}} - {{$value->name}}</option>

            @endforeach
            
          </select>

          </div>
          
        </div>    

	</div> 

	<div class="page-container div-margin">
		<div class="card">
			<table class="table table-responsive table-stripped">
				<thead>
					<tr>
						<th>N ID</th>
						<th>Name</th>
						
						<th>Notice Language</th>
						
						<th>Available Languages</th>
						<th>PAN India</th>
						<th>Notice Type</th>
			            <th>Created Date</th>
			            <th>Version</th>
			            <th>Status</th>
			            <th>Action</th>
			            
            
					</tr>
				</thead>

				<tbody>
		          @foreach($data as $key=>$value)
		          <tr>
		          	<td>{{$value->document_id}}</td>
		             <td style="max-width: 200px;" class="scrollable-cell"  data-toggle="tooltip" data-placement="top" title="{{$value->name}}">{{$value->name}}</td>
		             @php
                       $languages = $value->available_languages;
                       $langarray = array();
                       $split = explode(',',$languages);
                       foreach($split as $code){
                          $language = $code ; 
                          if($language == 'as')$langarray[]='Assamese';
                          if($language == 'bn')$langarray[]='Bengali';
                          if($language == 'en')$langarray[]='English';
                          if($language == 'gu')$langarray[]='Gujarati';
                          if($language == 'hi')$langarray[]='Hindi';
                          if($language == 'kn')$langarray[]='Kannada';
                          if($language == 'kh')$langarray[]='Khasi';
                          if($language == 'ml')$langarray[]='Malayalam';
                          if($language == 'mr')$langarray[]='Marathi';
                          if($language == 'or')$langarray[]='Oriya/Odia';
                          if($language == 'pa')$langarray[]='Punjabi';
                          if($language == 'ta')$langarray[]='Tamil';
                          if($language == 'te')$langarray[]='Telugu';
                          if($language == 'ar')$langarray[]='Urdu';

                       }
                       $langlist = implode(',',$langarray);

		             @endphp

						<td>{{$value->langauge->lang}}</td>
					 
		             <td style="max-width: 150px;" class="scrollable-cell"  data-toggle="tooltip" data-placement="top" title="{{$langlist}}">{{$langlist}}</td>
		            <!--  <td style="max-height: 200px">
		             	<table>
		             	@foreach($langarray as $val)
		             	
		             	<tr>
		             		<td>{{$val}}</td>
		             	</tr>

		             	@endforeach
		             	</table>
		             </td> -->
		             <td>{{$value->is_pan_india}}</td>
		             <td>{{$value->notice_type}}</td>
		             <td>{{date('d M Y',strtotime($value->created_at)) }}</td>
		             <td>{{$value->version}}</td> 
		             <td>{{$value->status}}<!-- {{ ($value->status=='Published') ? 'Published' : 'UnPublished'}} --></td> 
		             <td>
		             	@if($value->notice_type == 'custom_ujjivan')
                          <a target="_blank" href="{{ URL::to('/') }}/custom_noticefiles/{{$value->lang_code}}_{{$branchcode}}_{{$value->filename}}"><button class="btn btn-sm btn-outline-primary">View</button></a>
		             	@else
		             	 <a target="_blank" href="{{ URL::to('/') }}/noticefiles/{{$value->lang_code}}_{{$value->filename}}"><button class="btn btn-sm btn-outline-primary">View</button></a>
		             	@endif
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
     let branchid = <?php echo $id; ?>;
    // alert(branchid);

    
     var href = window.location.origin + '/branch-notices/' + edit_id + "/" + branchid ;
    // alert(href);

     window.location=href;
})
</script>



    
@endsection