@extends('layouts.app')

@section('content')

<div class="container-body">
  <label class="label-bold">Edit Device Details</label>
    <div class="container-header">
        
    </div>

    <div class="page-container">
       <hr/>
       <h4>Bank Details</h4>
       <form method="POST" action="{{ route('update_device_datails',$id)}}">
        @method('put')
        @csrf
       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Region * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">
                 <select class="form-control form-select" name="region" required>
                  <option value="">Select Region</option>
                  <option value="East" <?php echo ($data->region == 'East')?'selected':'' ?>>East</option>
                  <option value="West" <?php echo ($data->region == 'West')?'selected':'' ?> >West</option>
                  <option value="North" <?php echo ($data->region == 'North')?'selected':'' ?> >North</option>
                  <option value="South" <?php echo ($data->region == 'South')?'selected':'' ?> >South</option>
                   
                 </select>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Branch * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="branch" value="{{$data->branch}}" required >
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Branch Code * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" name="branch_code" aria-describedby="basic-addon3" value="{{$data->branch_code}}" required>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">IFSC * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" minlength="11" maxlength="11" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="ifsc" value="{{$data->ifsc}}" required>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Area * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="area" value="{{$data->area}}" required>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">City * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" name="city" aria-describedby="basic-addon3" value="{{$data->city}}" required>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">State * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="state" value="{{$data->state}}" required>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">PINCODE * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" name="pincode" value="{{$data->pincode}}" aria-describedby="basic-addon3" required>
                </div>
            </div>   
       </div>

       <hr/>
       <h4>Contact Details</h4>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Name * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="name" value="{{$data->name}}" required>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Mobile * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input  type="number" minlength="10" maxlength="10" class="form-control" id="basic-url" name="mobile" aria-describedby="basic-addon3" value="{{$data->mobile}}" required>
                </div>
            </div>   
       </div>
       
       <hr/>
       <h4>Device Details</h4>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Device ID * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="device_id" value="{{$data->device_id}}" required>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Model * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" name="model" value="{{$data->model}}" aria-describedby="basic-addon3">
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Date of Installation * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="date" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="date_of_installation" value="{{$data->date_of_install}}" required>
                </div>
            </div>  
            
       </div>

      
       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Last Updated Date </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="last_updated_date" value="{{$data->last_updated_date}}" readonly>
                </div>
            </div>  
            
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Current APK version </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="apk_version" value="{{$data->apk_version}}" readonly>
                </div>
            </div>  
            
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Remote ID</span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="remote_id" value="{{$data->remote_id}}">
                </div>
            </div>  
            
       </div>

        <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Device Status</span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <select class="form-control form-select" name="status">
                    <option value="Active" <?php echo ($data->status == 'East')?'selected':'' ?> >Active</option>
                    <option value="Under-Maintanance" <?php echo ($data->status == 'Under-Maintanance')?'selected':'' ?> >Under-Maintanance</option>
                    <option value="In-Active" <?php echo ($data->status == 'In-Active')?'selected':'' ?> >In-Active</option>
                  </select>
                </div>
            </div>  
            
       </div>

       <div id="div3" class="div-margin">
         <button class="btn btn-success" type="submit">Update</button> 
       </div>

     </form>
    </div>    
    
</div>

    
@endsection