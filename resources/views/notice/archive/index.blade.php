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

<div class="container">
  
	<div class="container-header">
		
        <div id="div2" style="margin-right: 30px">
           <form method="GET" action="{{route('search_archive_notice')}}">
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

        @php
        if($search == ''){
          $filter = 'all';
         }
         else{
         $filter = $search;
     }

        @endphp

       <!--   <div id="div3" style="margin-right: 30px">
             <a href="{{route('export_notices',[$lang,$filter])}}"><button class="btn btn-light btn-outline-secondary" > Download CSV</button></a>
          </div>	

        -->

	<div id="div1">
      <label class="label-bold">Ujjivan Notices Archive</label>
    </div>

	</div> 

	<div class="page-container div-margin">
		<div class="card">
			<table class="table table-responsive table-striped table-bordered border-dark">
				<thead class="table-dark border-warning">
					<tr>
						<th>#</th>
						<th>N ID</th>

						<th>Name</th>
						@if($lang == 'all')
						<th>Notice Language</th>
						@endif
						<th>Available Languages</th>
						<th>PAN India</th>
						<th>Notice Type</th>
						<th>Creation Date</th>
			            <th>Archived Date</th>
			            <th>Version</th>
			            <!-- <th>Status</th> -->
			            <th></th>
			           
					</tr>
				</thead>

				<tbody>
		          @foreach($data as $key=>$value)
		          <tr>
		          	<td class="border-warning">{{$key+1}}.</td>
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
		             <td>{{date('d M Y H:i:s',strtotime($value->created_at)) }}</td>
		             <td>{{date('d M Y H:i:s',strtotime($value->updated_at)) }}</td>
		             <td>{{$value->version}}</td> 
		             <!-- <td>{{$value->status}}</td>  -->
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

                        		 @if($value->template_id != '3' && $value->template_id != '4')
                        		
                                <div class="card">
                                	<div class="card-header bg-primary text-white">Action on {{$value->document_id}} - {{$value->lang_name}} Notice</div>
                                	<div class="card-body">
                                		
                                		<a href="{{ route('view_archive_notice_datails',[$value->id])}}"><button class="btn btn-sm btn-outline-secondary">View</button></a>
                                		                          		
                                	</div>
                                </div>

                                @endif

                                <div class="card">
                                	<div class="card-header bg-primary text-white">Action on {{$value->document_id}} - Multilingual(All language) Notice</div>
                                	<div class="card-body">
                                		<a href="{{ route('view_multilingual_archive_notice_datails',[$value->notice_group,$lang])}}"><button class="btn btn-sm btn-outline-secondary">View All</button></a>
                                                                     		
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
    
     var href = window.location.origin + '/notices-archive/' + edit_id ;
    // alert(href);

     window.location=href;
})
</script>



    
@endsection