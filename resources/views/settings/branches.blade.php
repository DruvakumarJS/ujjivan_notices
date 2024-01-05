@extends('layouts.app')

@section('content')

<div class="container-body">
  
  <div class="container-header">
    
    <div id="div2">
      <a data-bs-toggle="modal" data-bs-target="#mymodal" ><button class="btn btn-outline-primary">Add New Branch</button></a>
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
      <label class="label-bold">Branch list</label>
    </div>
  </div>

  <div class="page-container div-margin">
    <div class="card">
      <table class="table table-responsive table-stripped">
        <thead>
          <tr>
            <th>Branch Name</th>
            <th>Branch Code</th>
            <th>Region Name</th>
            <th>Region Code</th>
            <th>IFSC</th>
            <th>Area</th>
            <th>City</th>
            <th>District</th>
            <th>State</th>
            <th>Pincode</th>
            <th>Action</th>
            
          </tr>
        </thead>

        <tbody>
          @foreach($data as $key=>$value)
          <tr>
            <td>{{$value->name}}</td>
            <td>{{$value->branch_code}}</td>
            <td>{{$value->region->name}}</td>
            <td>{{$value->region->region_code}}</td>
            <td>{{$value->ifsc}}</td>
            <td>{{$value->area}}</td>
            <td>{{$value->city}}</td>
            <td>{{$value->district}}</td>
            <td>{{$value->state}}</td>
            <td>{{$value->pincode}}</td>
            <td>
              <!-- <a href=""><button class="btn btn-sm btn-outline-primary">View More</button></a> -->
              <a  id="MybtnModal_{{$key}}" ><button class="btn btn-sm btn-outline-primary">Edit</button></a>
              <a onclick="return confirm('You are deleting a Device?')" href="{{ route('delete_branch',$value->id)}}"><button class="btn btn-sm btn-outline-danger">Delete</button></a>
            </td>
          </tr>

          <!-- Edit modal -->

          <div class="modal" id="modal_{{$key}}" >
           <div class="modal-dialog modal-xl" role="document">
           <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Branch</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            <div class="modal-body">
                 
             <div class="form-build">
              <div class="row">
                <div class="col-6">
                  <form method="post" action="{{ route('update_branch')}}" enctype="multipart/form-data" >
                    @method('PUT')
                    @csrf

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Region*</label>
                      <div class="col-7">
                          <select class="form-control form-select" name="region" required>
                            <option value="">Select Region</option>
                            @foreach($region as $key2=>$value2)
                             <option <?php echo ($value2->id == $value->region_id)?'selected':''  ?> value="{{$value2->id}}">{{$value2->name}} - {{$value2->region_code}}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Branch Name*</label>
                      <div class="col-7">
                          <input class="form-control" name="name" type="text" placeholder="Enter Branch Name" required value="{{$value->name}}">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Branch Code *</label>
                      <div class="col-7">
                          <input class="form-control" name="branch_code" type="text" placeholder="Enter Branch Code" value="{{$value->branch_code}}"  required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">IFSC *</label>
                      <div class="col-7">
                          <input class="form-control" name="city" type="text" placeholder="Enter IFSC Code" value="{{$value->ifsc}}" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Area *</label>
                      <div class="col-7">
                          <input class="form-control" name="area" type="text" placeholder="Enter City Name" value="{{$value->area}}" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">City *</label>
                      <div class="col-7">
                          <input class="form-control" name="city" type="text" placeholder="Enter City Name" value="{{$value->city}}" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">District *</label>
                      <div class="col-7">
                          <input class="form-control" name="district" type="text" placeholder="Enter District Name"  value="{{$value->district}}" required>
                      </div>
                    </div>


                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">State *</label>
                      <div class="col-7">
                          <input class="form-control" name="state" type="text" placeholder="Enter State Name"  value="{{$value->state}}" required>
                      </div>
                    </div>

                     <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Pincode *</label>
                      <div class="col-7">
                          <input class="form-control" name="pincode" type="text" placeholder="Enter PinCode" minlength="6" maxlength="6" value="{{$value->pincode}}"  required>
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
              <h5 class="modal-title">Add New Branch</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            <div class="modal-body">
                 
             <div class="form-build">
              <div class="row">
                <div class="col-6">
                  <form method="post" action="{{ route('save_branch')}}" enctype="multipart/form-data" >
                    @csrf

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Region*</label>
                      <div class="col-7">
                          <select class="form-control form-select" name="region" required>
                            <option value="">Select Region</option>
                            @foreach($region as $key2=>$value2)
                             <option value="{{$value2->id}}">{{$value2->name}} - {{$value2->region_code}}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Branch Name*</label>
                      <div class="col-7">
                          <input class="form-control" name="name" type="text" placeholder="Enter Branch Name" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Branch Code *</label>
                      <div class="col-7">
                          <input class="form-control" name="branch_code" type="text" placeholder="Enter Branch Code"  required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">IFSC *</label>
                      <div class="col-7">
                          <input class="form-control" name="ifsc" type="text" placeholder="Enter IFSC Code " minlength="11" maxlength="11" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Area *</label>
                      <div class="col-7">
                          <input class="form-control" name="area" type="text" placeholder="Enter Area Name"  required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">City *</label>
                      <div class="col-7">
                          <input class="form-control" name="city" type="text" placeholder="Enter City Name"  required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">District *</label>
                      <div class="col-7">
                          <input class="form-control" name="district" type="text" placeholder="Enter District Name"  required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">State *</label>
                      <div class="col-7">
                          <input class="form-control" name="state" type="text" placeholder="Enter State Name"  required>
                      </div>
                    </div>

                     <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Pincode *</label>
                      <div class="col-7">
                          <input class="form-control" name="pincode" type="text" placeholder="Enter PinCode" minlength="6" maxlength="6"  required>
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

<script>
  $(document).ready(function(){
    $('#updateModal').click(function(){

      $('#updatemodal').modal('show');
    });
  });  
</script>      
@endsection