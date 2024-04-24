@extends('layouts.app')

@section('content')
<style type="text/css">
  thead th {
 
  height: 50px;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="container-header">
           
            <div id="div2" style="margin-right: 30px">
           <form method="GET" action="{{route('search_audit')}}">
            @csrf
            <input type="hidden" name="search" value="{{$search}}">
             <div class="input-group mb-3">
                <input class="form-control" type="text" name="search" placeholder="Search here" value="{{$search}}">
                <div class="input-group-prepend">
                   <button class="btn btn-outline-secondary rounded-0" type="submit" >Search</button>
                </div>
              </div>
           </form>
          </div>

         <!--  <div id="div2" style="margin-right: 30px">
           <form method="POST" action="">
            @csrf
            <input type="hidden" name="search" value="{{$search}}">
             <div class="input-group mb-3">
                   <button class="btn btn-outline-secondary rounded-0" type="submit" >Download CSV</button>
              </div>
           </form>
          </div> -->
           
        </div>
 
       
        <div>
        	 <label class="label-bold" style="margin-left: 20px" >Audit Trail</label>

        	<div class="card border-white scroll tableFixHead" style="height: 600px; padding: 0px 5px 20px 20px">

                        <table class="table">
                          <thead>
                            <tr>
                              <th>Date</th>
                              <th>Time</th>
                              <th scope="col">Module</th>
                             <!--  <th scope="col">Tracker ID</th> -->
                              <th scope="col">Action</th>
                              
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($data as $key=>$value)
                            <tr>
                              <td>{{date('D', strtotime($value->created_at))}} , {{date('d M Y', strtotime($value->created_at))}}</td>
                              <td>{{date('H:i:s', strtotime($value->created_at))}}</td>
                              <td>{{$value->module}}</td>
                             <!--  <td>{{ ($value->module == 'Notice')? ('N'.$value->track_id):$value->track_id}}</td> -->
                              <td> {{ ($value->module == 'Notice')? ('N'.$value->track_id.' - '):''}} {{$value->action}}</td>
                                                            
                            </tr>
 
                            @endforeach
                          
                          </tbody>
                        </table>

                         <label>Showing {{ $data->firstItem() }} to {{ $data->lastItem() }}
                                    of {{$data->total()}} results</label>

                                {!! $data->links('pagination::bootstrap-4') !!}
                        
                    </div>
                    <!--</div>-->
                 </div>
        </div>	
    </div>

   
</div>









@endsection