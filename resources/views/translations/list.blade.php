@extends('layouts.app')

@section('content')

<div class="container">
	<label class="label-header">Google Translate Contents</label>
    
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
				<th>Language</th>
				<th>Original Characters Count</th>
				<th>Translated By</th>
        <th>Reviewer Email</th>
        <th>Modified Date</th>
				<th>Status</th>
        <th>Action</th>
			</thead>

			<tbody>
				@foreach($data as $key=>$val)
                  <tr class="text-center">
                  	<td>{{ date('d-m-Y',strtotime($val->created_at))}}</td>
                    <td>{{ $val->language}}</td>
                  	<td>{{ $val->character_count}}</td>
                  	<td>{{ $val->translated_by}}</td>
                    <td>{{ $val->reviewer_email}}</td>
                    <td>{{  date('d-m-Y H:i:s',strtotime($val->updated_at))}}</td>
                  	<td>{{ $val->status}}</td>
                  	<td>
                  		<a href="{{route('edit_translated',encrypt($val->id))}}"><button class="btn btn-sm btn-danger text-white">EDIT</button></a>

                      <a href="{{route('view_translated',encrypt($val->id))}}"><button class="btn btn-sm btn-secondary">View</button></a>

                  	</td>
                  </tr>

                  
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection
