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
		
		<div id="div2">
			<a href="{{ route('choose_template',$lang)}}"><button class="btn btn-outline-primary">Create New Notice</button></a>
		</div> 

        <div id="div2" style="margin-right: 30px">
           <form method="POST" action="{{route('search_notice')}}">
            @csrf
             <div class="input-group mb-3">
                <input class="form-control" type="text" name="search" placeholder="Search by Notice ID" value="{{$search}}">

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
                 <option value="all" >All Languages</option>	
                @foreach($languages as $key=>$value)
                <option {{ ( $value->code == $lang )?'selected':'' }} value="{{$value->code}}">{{$value->lang}} - {{$value->name}}</option>

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
						@if($lang == 'all')
						<th>Notice Language</th>
						@endif
						<th>Available Languages</th>
						<th>PAN India</th>
						<th>Notice Type</th>
			            <th>Created Date</th>
			            <th>Version</th>
			            <th>Status</th>
			            <th></th>
			            
            
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

		             @if($lang == 'all')
						<td>{{$value->langauge->lang}}</td>
					 @endif
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
		             <td><a  id="MybtnModal_{{$key}}"><button class="btn btn-sm btn-outline-secondary">Action</button></a></td>
		             <!-- <td>{{$value->status}}</td> -->
		             <!-- <td>
		             	 <a target="_blank" href="{{ URL::to('/') }}/noticefiles/{{$lang}}_{{$value->filename}}"><button class="btn btn-sm btn-outline-primary">View</button></a>	
		             </td>
		             <td>
		             	@if($value->notice_type == 'ujjivan')
			             <a href="{{ route('edit_multi_notice_datails',[$value->notice_group,$lang])}}"><button class="btn btn-sm btn-outline-secondary">Edit All</button></a>
			             <a href="{{ route('edit_notice_datails',[$value->id])}}"><button class="btn btn-sm btn-outline-secondary">Modify</button></a>
			             @else
			             <a href="{{ route('edit_multi_rbi_notice_datails',[$value->notice_group,$lang])}}" ><button class="btn btn-sm btn-outline-secondary">Edit</button></a>
			             @endif
		             </td>
		             <td>
		             	 <a href="{{ route('select_language',[$lang,$value->id])}}"  ><button class="btn btn-sm btn-outline-info">Add</button></a>	
		             </td>
		             <td>
		             	@if($value->status == 'Draft')
		             	<a onclick="return confirm('You are Publishing the Notice - {{$value->document_id}}')"  href="{{route('modify_notice_status',$value->id)}}"><button class="btn btn-sm btn-dark">Publish</button></a>
		             	@else
		             	<a  onclick="return confirm('You are UnPublishing the Notice - {{$value->document_id}}')"  href="{{route('modify_notice_status',$value->id)}}"><button class="btn btn-sm btn-outline-warning" >UnPublish</button></a>
		             	@endif

		             </td>
		           
		             <td>
		             	 <a onclick="return confirm('You are deleting a Notice?')" href="{{ route('delete_notice_datails',$value->id)}}"><button class="btn btn-sm btn-outline-danger">Delete</button></a>
		             </td> -->
				  </tr>	


				   <!-- Edit modal -->

                 <div class="modal" id="modal_{{$key}}"  >
			        <div class="modal-dialog modal-m" >
			          <div class="modal-content">
			            <div class="modal-header">
			              <h5 class="modal-title"> Notice - {{$value->document_id}}</h5>
			             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			               
			            </div>
			            <div class="modal-body">
			                 
			             <div class="form-build">
			              <div class="row">
			                <div class="col-12">
			                  
                               <label class="label-bold">{{$value->name}}</label>

                                @php
                        		 if($lang == 'all'){
                        		  $langs = $value->lang_code ; 
                        		 }
                        		 else{
                        		  $langs =$lang;
                        		}
                        		 
                        		
                        		@endphp 
                        		
                                <div class="card">
                                	<div class="card-header bg-primary text-white">Action on {{$value->document_id}} - {{$value->lang_name}} Notice</div>
                                	<div class="card-body">

                                		<a target="_blank" href="{{ URL::to('/') }}/noticefiles/{{$langs}}_{{$value->filename}}"><button class="btn btn-sm btn-outline-primary">View</button></a>

                                		@if($value->notice_type == 'ujjivan')
							            <a href="{{ route('edit_notice_datails',[$value->id])}}"><button class="btn btn-sm btn-outline-secondary">Edit</button></a>
							             @else
							             <a href="{{ route('edit_rbi_notice',[$value->id])}}" ><button class="btn btn-sm btn-outline-secondary">Edit</button></a>
							             @endif

                                		@if($value->status == 'Draft' OR $value->status == 'UnPublished')
						             	<a onclick="return confirm('You are Publishing the Notice - {{$value->document_id}}')"  href="{{route('modify_notice_status',$value->id)}}"><button class="btn btn-sm btn-outline-dark">Publish</button></a>
						             	@else
						             	<a  onclick="return confirm('You are UnPublishing the Notice - {{$value->document_id}}')"  href="{{route('modify_notice_status',$value->id)}}"><button class="btn btn-sm btn-outline-warning" >UnPublish</button></a>
						             	@endif

                                		<a onclick="return confirm('You are deleting a N{{$value->document_id}} Notice')" href="{{ route('delete_notice_datails',$value->id)}}"><button class="btn btn-sm btn-outline-danger">Delete</button></a>                               		
                                	</div>
                                </div>

                                <div class="card">
                                	<div class="card-header bg-primary text-white">Action on {{$value->document_id}} - Multilingual(All language) Notice</div>
                                	<div class="card-body">
                                		<a href="{{route('view_notices',[$value->notice_group,$lang])}}"><button class="btn btn-sm btn-outline-primary">View All</button></a>

                                		@if($value->notice_type == 'ujjivan')
							             <a href="{{ route('edit_multi_notice_datails',[$value->notice_group,$lang])}}"><button class="btn btn-sm btn-outline-secondary">Edit All</button></a>
							             
							             @else
							             <a href="{{ route('edit_multi_rbi_notice_datails',[$value->notice_group,$lang])}}" ><button class="btn btn-sm btn-outline-secondary">Edit All</button></a>
							             @endif

                                		
						             	<a onclick="return confirm('You are Publishing all N{{$value->document_id}} notices')"  href="{{route('modify_all_notice_status',[$value->notice_group,'Publish'])}}"><button class="btn btn-sm btn-outline-dark">Publish All</button></a>
						             
						             	<a  onclick="return confirm('You are UnPublishing all N{{$value->document_id}} notices')"  href="{{route('modify_all_notice_status',[$value->notice_group,'UnPublish'])}}"><button class="btn btn-sm btn-outline-warning" >UnPublish All</button></a>
						             	
		             	
                                		<a onclick="return confirm('You are deleting all N{{$value->document_id}} notices')" href="{{ route('delete_all_notice_datails',$value->notice_group)}}"><button class="btn btn-sm btn-outline-danger">Delete All</button></a>                                		
                                	</div>
                                </div>

                                <div>
                               	   <a href="{{ route('select_language',[$lang,$value->id])}}"><button class="btn btn-sm btn-outline-success">Add new {{$value->document_id}} Notice</button></a>
                                </div>
			                    
			                    
			                    <!-- <div class="form-group row">
			                      <label for="" class="col-4 col-form-label">Region Name*</label>
			                      <div class="col-7">
			                          <input class="form-control" name="name" type="text" placeholder="Enter Region Name" required value="{{$value->name}}">
			                      </div>
			                    </div>

			                    <div class="form-group row">
			                      <label for="" class="col-4 col-form-label">Region Code *</label>
			                      <div class="col-7">
			                          <input class="form-control" name="branch_code" type="text" placeholder="Enter Region Code"  required value="{{$value->region_code}}">
			                      </div>
			                    </div>
			                     -->
			                  
			                </div>
			                
			              </div>
			               
			             </div>

			            </div>

			           
			          </div>
			        </div>
			      </div>

			       <script>
			        $(document).ready(function(){
			          $('#MybtnModal_{{$key}}').click(function(){
			            $('#modal_{{$key}}').modal('show');
			          });
			        });  
			        </script>

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