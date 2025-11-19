@extends('layouts.app')

@section('content')

<div class="container">
   <div class="d-flex">
    <label class="label-header">Google Translate Quota usage Details</label>
    <a class="ms-auto" href="{{ route('translatation')}}"><button class="btn btn-dark ">Back</button></a>
  </div>

    @if(Session::has('message'))
            <p id="mydiv" class="text-danger text-center label-bold">{{ Session::get('message') }}</p>
              @endif 
           
               @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            
                        @endforeach
                        <li>{{ $error }}</li>
                    </ul>
                </div>
              @endif   

	<div class="mt-4">
		<table class="table table-responsive table-bordered table-striped">
			<thead>
				<th>Month</th>
				<th>Created Date</th>
				<th>Quota</th>
				<th>Usage</th>
				<th>Remaining</th>
				<th>Action</th>
			</thead>

			<tbody>
				@foreach($data as $key=>$val)
                  <tr>
                  	<td>{{ date('M Y',strtotime($val->month))}}</td>
                  	<td>{{ date('d,M Y',strtotime($val->created_at))}}</td>
                  	<td>{{ $val->quota}}</td>
                  	<td>{{ $val->used}}</td>
                  	<td>{{ intval($val->quota)-intval($val->used)}}</td>
                  	<td>
                  		<a id="MyapprovalModal_{{$key}}"><button class="btn btn-sm btn-secondary">Edit</button></td></a>
                  	</td>
                  </tr>

                  <div class="modal fade" id="approvalstatusModal_{{$key}}" tabindex="-1" aria-labelledby="MyapprovalModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="MyapprovalModalLabel">Update QUota Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form method="POST" action="{{ route('update_quota_details')}}">
                      @csrf
                      <div class="modal-body">
                         <div class="form-group">
                          <label for="recipient-name" class="col-form-label">Month</label>
                          <input type="text" class="form-control" name="name" value="{{ $val->month}}" readonly>
                        </div>
                        <div class="form-group">
                          <label for="message-text" class="col-form-label">Quota</label>
                          <input type="text" class="form-control"name="quota_value" value="{{ $val->quota}}" required> 
                        </div>
                        
                      <input type="hidden" name="quotaid" value="{{$val->id}}">
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div>
                    </form>
                   </div> 
                    
                  </div>
                </div>    
              </div>

             <script type="text/javascript" nonce="wUDPhZ1Z60CsrpnMCukimCi">
               $(document).ready(function(){
                          $('#MyapprovalModal_{{$key}}').click(function(){

                            $('#approvalstatusModal_{{$key}}').modal('show');
                          });
                        });
             </script>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection
