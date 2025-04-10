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

       
        </div>
 
       
        <div>
        	 <label class="label-bold" style="margin-left: 20px" >Audit Trail</label>

        	<div class="card" >

            <table class="table table-responsive table-striped table-bordered border-dark">
              <thead class="table-dark border-warning">
                <tr>
                  <th>Date</th>
                  <th>Time</th>
                  <th>User</th>
                  <th>Module</th>
                 <!--  <th scope="col">Tracker ID</th> -->
                  <th >Action</th>
                  <th >Pan India</th>
                  <th >Regions</th>
                  <th >States</th>
                  <th >Branch</th>
                  
                </tr>
              </thead>
              <tbody>
                @foreach($data as $key=>$value)
                <tr>
                  <td>{{date('D', strtotime($value->created_at))}} , {{date('d M Y', strtotime($value->created_at))}}</td>
                  <td>{{date('H:i:s', strtotime($value->created_at))}}</td>
                  <td>{{$value->user->name}}</td>
                  <td>{{$value->module}}</td>
                 <!--  <td>{{ ($value->module == 'Notice')? ('N'.$value->track_id):$value->track_id}}</td> -->
                  <td style="max-width: 250px;" class="scrollable-cell"  data-toggle="tooltip" data-placement="top" title="{{ ($value->module == 'Notice')? ($value->track_id.' - '):''}} {{$value->action}}"> {{ ($value->module == 'Notice')? ($value->track_id.' - '):''}} {{$value->action}}</td>
                  <td>{{$value->pan_india}}</td>
                  <td style="max-width: 150px;" class="scrollable-cell"  data-toggle="tooltip" data-placement="top" title="{{$value->regions}}">{{$value->regions}}</td>
                  <td style="max-width: 150px;" class="scrollable-cell"  data-toggle="tooltip" data-placement="top" title="{{$value->states}}">{{$value->states}}</td>
                  <td style="max-width: 150px;" class="scrollable-cell"  data-toggle="tooltip" data-placement="top" title="{{$value->branch}}">{{$value->branch}}</td>
                                                
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