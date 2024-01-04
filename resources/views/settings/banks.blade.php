@extends('layouts.app')

@section('content')

<div class="container-body">
  
  <div class="container-header">
    
    <div id="div2">
      <a data-bs-toggle="modal" data-bs-target="#mymodal" ><button class="btn btn-outline-primary">Add New Bank</button></a>
    </div> 

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
      <label class="label-bold">Banks list</label>
    </div>
  </div>

  <div class="page-container div-margin">
    <div class="card">
      <table class="table table-responsive table-stripped">
        <thead>
          <tr>
            <th>Region </th>
            <th>Branch Code</th>
            <th>Bank Name</th>
            <th>Bank Code</th>
            <th>IFSC</th>
            <th>area</th>
            <th>building</th>
            <th>pincode</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          @foreach($data as $key=>$value)
          <tr>
            <td>{{$value->branch->region->name}}</td>
            <td>{{$value->branch->branch_code}}</td>
            <td>{{$value->bank_name}}</td>
            <td>{{$value->bank_code}}</td>
            <td>{{$value->ifsc}}</td>
            <td>{{$value->area}}</td>
            <td>{{$value->building}}</td>
            <td>{{$value->pincode}}</td>
            <td>
              <!-- <a href=""><button class="btn btn-sm btn-outline-primary">View More</button></a> -->
              <a id="MybtnModal_{{$key}}" ><button class="btn btn-sm btn-outline-primary">Edit</button></a>
              <a onclick="return confirm('You are deleting a Device?')" href="{{ route('delete_bank',$value->id)}}"><button class="btn btn-sm btn-outline-danger">Delete</button></a>
            </td>
          </tr>

          <div class="modal" id="mymodal_{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Bank</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            <div class="modal-body">
                 
             <div class="form-build">
              <div class="row">
                <div class="col-6">
                  <form method="post" action="{{ route('update_bank')}}" enctype="multipart/form-data" >
                    @method('PUT')
                    @csrf

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Branch*</label>
                      <div class="col-7">
                          <select class="form-control form-select" name="branch" required>
                            <option value="">Select Branch</option>
                            @foreach($branch as $key2=>$value2)
                             <option <?php echo ($value2->id == $value->branch_id)?'selected':''  ?> value="{{$value2->id}}">{{$value2->name}} - {{$value2->branch_code}}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Bank Name*</label>
                      <div class="col-7">
                          <input class="form-control" name="name" type="text" placeholder="Enter Bank Name" value="{{$value->bank_name}}" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Bank Code *</label>
                      <div class="col-7">
                          <input class="form-control" name="bank_code" type="text" placeholder="Enter Bank Code"  value="{{$value->bank_code}}" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">IFSC *</label>
                      <div class="col-7">
                          <input class="form-control" name="ifsc" type="text" placeholder="Enter Bank IFSC" minlength="11" maxlength="11" value="{{$value->ifsc}}"  required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Area *</label>
                      <div class="col-7">
                          <input class="form-control" name="area" type="text" placeholder="Enter Area Name"  value="{{$value->area}}" required>
                      </div>
                    </div>

                     <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Building *</label>
                      <div class="col-7">
                          <input class="form-control" name="building" type="text" placeholder="Enter Building" value="{{$value->building}}" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Pincode *</label>
                      <div class="col-7">
                          <input class="form-control" name="pincode" minlength="6" maxlength="6" type="text" placeholder="Enter Area Pincode" value="{{$value->pincode}}" required>
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

            $('#mymodal_{{$key}}').modal('show');
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
              <h5 class="modal-title">Add New Bank</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            <div class="modal-body">
                 
             <div class="form-build">
              <div class="row">
                <div class="col-6">
                  <form method="post" action="{{ route('save_bank')}}" enctype="multipart/form-data" >
                    @csrf

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Branch*</label>
                      <div class="col-7">
                          <select class="form-control form-select" name="branch" required>
                            <option value="">Select Branch</option>
                            @foreach($branch as $key2=>$value2)
                             <option value="{{$value2->id}}">{{$value2->name}} - {{$value2->branch_code}}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Bank Name*</label>
                      <div class="col-7">
                          <input class="form-control" name="name" type="text" placeholder="Enter Bank Name" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Bank Code *</label>
                      <div class="col-7">
                          <input class="form-control" name="bank_code" type="text" placeholder="Enter Bank Code"  required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">IFSC *</label>
                      <div class="col-7">
                          <input class="form-control" name="ifsc" type="text" placeholder="Enter Bank IFSC" minlength="11" maxlength="11"  required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Area *</label>
                      <div class="col-7">
                          <input class="form-control" name="area" type="text" placeholder="Enter Area Name"  required>
                      </div>
                    </div>

                     <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Building *</label>
                      <div class="col-7">
                          <input class="form-control" name="building" type="text" placeholder="Enter Building"  required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Pincode *</label>
                      <div class="col-7">
                          <input class="form-control" name="pincode" minlength="6" maxlength="6" type="text" placeholder="Enter Area Pincode"  required>
                      </div>
                    </div>

                    
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-outline-success">Save </button>
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

     
@endsection