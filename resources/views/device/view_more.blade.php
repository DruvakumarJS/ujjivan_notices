@extends('layouts.app')

@section('content')

<div class="container-body">
  <label class="label-bold">Device Details</label>
    <div class="container-header">
       <div id="div3" class="div-margin">
         <a href="{{ route('edit_device_datails',$id)}}"><button class="btn btn-sm btn-success" type="submit">Edit</button></a> 
       </div>

       <div id="div3" class="div-margin" style="margin-right: 30px">
         <a href="{{route('devices')}}"><button class="btn btn-sm btn-outline-light" type="submit">Go Back</button> </a>
       </div>

    </div>

    <div class="page-container">
       <hr/>
       <h4>Bank Details</h4>
      
       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Region * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">
                 <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="branch" value="{{$data->region}}" readonly >
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

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="branch" value="{{$data->branch}}" readonly >
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

                  <input type="text" class="form-control" id="basic-url" name="branch_code" aria-describedby="basic-addon3" value="{{$data->branch_code}}" readonly>
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

                  <input type="text" minlength="11" maxlength="11" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="ifsc" value="{{$data->ifsc}}" readonly>
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

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="area" value="{{$data->area}}" readonly>
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

                  <input type="text" class="form-control" id="basic-url" name="city" aria-describedby="basic-addon3" value="{{$data->city}}" readonly>
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

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="state" value="{{$data->state}}" readonly>
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

                  <input type="text" class="form-control" id="basic-url" name="pincode" value="{{$data->pincode}}" aria-describedby="basic-addon3" readonly="">
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

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="name" value="{{$data->name}}" readonly>
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

                  <input  type="number" minlength="10" maxlength="10" class="form-control" id="basic-url" name="mobile" aria-describedby="basic-addon3" value="{{$data->mobile}}" readonly>
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

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="device_id" value="{{$data->device_id}}" readonly>
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

                  <input type="text" class="form-control" id="basic-url" name="model" value="{{$data->model}}" aria-describedby="basic-addon3" readonly>
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

                  <input type="date" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="date_of_installation" value="{{$data->date_of_install}}" readonly>
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

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="date_of_installation" value="{{$data->last_updated_date}}" readonly>
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

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="date_of_installation" value="{{$data->apk_version}}" readonly>
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

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="date_of_installation" value="{{$data->remote_id}}" readonly>
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

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3"  value="{{$data->status}}" readonly>
                </div>
            </div>  
            
       </div>

      
    
    </div>    
    
</div>

    
@endsection