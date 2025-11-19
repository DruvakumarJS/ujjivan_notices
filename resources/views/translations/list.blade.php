@extends('layouts.app')

@section('content')

<div class="container">
  <div class="d-flex">
  	<label class="label-header">Google Translate Contents</label>
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
			<thead class="text-center">
				<th>Created Date</th>
        <th>Name/NID</th>
				<th>Language</th>
				<th>Original Characters Count</th>
				<th>Translated By</th>
        @if(Auth::user()->role !='Editor')
        <th>Reviewer Email</th>
        @endif
        <th>Modified Date</th>
				<th>Status</th>
        <th>Action</th>
			</thead>

			<tbody>
				@foreach($data as $key=>$val)
                  <tr class="text-center">
                  	<td>{{ date('d-m-Y',strtotime($val->created_at))}}</td>
                    <td>{{ $val->name}}</td>
                    <td>{{ $val->language}}</td>
                  	<td>{{ $val->character_count}}</td>
                  	<td>{{ $val->translated_by}}</td>
                    @if(Auth::user()->role !='Editor')
                    <td>{{ $val->reviewer_email}}</td>
                    @endif
                    <td>{{  date('d-m-Y H:i:s',strtotime($val->updated_at))}}</td>
                  	<td>{{ $val->status}}</td>
                  	<td>
                      @if(Auth::user()->role != 'Editor')
                      <a href="{{route('view_translated',encrypt($val->id))}}"><button class="btn btn-sm btn-secondary">View</button></a>
                      @endif
                      @if($val->status != 'Finished')
                  		<a href="{{route('edit_translated',encrypt($val->id))}}"><button class="btn btn-sm btn-danger text-white">EDIT</button></a>
                      @endif
                      

                  	</td>
                  </tr>

                  
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection
