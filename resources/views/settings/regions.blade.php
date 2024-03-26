@extends('layouts.app')

@section('content')

<div class="container-body">
  
  <div class="container-header">
    
    <div id="div2">
      <a data-bs-toggle="modal" data-bs-target="#mymodal" ><button class="btn btn-outline-primary">Add New Region</button></a>
    </div>

     @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      
                  @endforeach
                  <li>{{ $error }}</li>
              </ul>
          </div>
        @endif   

    <div id="div2" style="margin-right: 30px">
           <form method="POST" action="{{route('search_device')}}">
            @csrf
             <div class="input-group mb-3">
                <input class="form-control" type="text" name="search" placeholder="Search here" value="">
                <div class="input-group-prepend">
                   <button class="btn btn-outline-secondary rounded-0" type="submit" >Search</button>
                </div>
              </div>
           </form>
          </div>
    <div id="div1">
      <label class="label-bold">Regions list</label>
    </div>
  </div>

  <div class="page-container div-margin">
    <div class="card">
      <table class="table table-responsive table-stripped">
        <thead>
          <tr>
            <th>Region Name</th>
            <th>Region Code</th>
            <th>Action</th>
            
          </tr>
        </thead>

        <tbody>
          @foreach($data as $key=>$value)
          <tr>
            <td>{{$value->name}}</td>
            <td>{{$value->region_code}}</td>
            <td>
              <a id="MybtnModal_{{$key}}" ><button class="btn btn-sm btn-outline-primary">Edit</button></a>
              <a onclick="return confirm('You are deleting a Device?')" href="{{route('delete_region',$value->id)}}"><button class="btn btn-sm btn-outline-danger">Delete</button></a>
            </td>
          </tr>

          <!-- Edit modal -->

          <div class="modal" id="modal_{{$key}}"  >
        <div class="modal-dialog modal-xl" >
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Region</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            <div class="modal-body">
                 
             <div class="form-build">
              <div class="row">
                <div class="col-6">
                  <form method="post" action="{{ route('update_region')}}" enctype="multipart/form-data" >
                    @method('PUT')
                    @csrf
                    
                    <div class="form-group row">
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
                    
                    <input type="hidden" name="id" value="{{$value->id}}">
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-outline-success">Update </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"data-bs-dismiss="modal" aria-label="Close">Close</button>
                      </div>
                  </form>
                  
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

            {!! $data->links('pagination::bootstrap-4') !!}
      
    </div>
    
  </div>
  
</div>


<div class="modal" id="mymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add New Region</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            <div class="modal-body">
                 
             <div class="form-build">
              <div class="row">
                <div class="col-6">
                  <form method="post" action="{{ route('save_region')}}" enctype="multipart/form-data" >
                    @csrf
                    
                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Region Name*</label>
                      <div class="col-7">
                          <input class="form-control" name="name" type="text" placeholder="Enter Region Name" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Region Code *</label>
                      <div class="col-7">
                          <input class="form-control" name="branch_code" type="text" placeholder="Enter Region Code"  required>
                      </div>
                    </div>

                    
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-outline-success">Save </button>
                        <button type="button" class="btn btn-sm btn-outline-primary"data-bs-dismiss="modal" aria-label="Close">Close</button>
                      </div>
                  </form>
                  
                </div>
                
              </div>
               
             </div>

            </div>

           
          </div>
        </div>
      </div>

   
@endsection