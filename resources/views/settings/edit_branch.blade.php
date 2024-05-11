@extends('layouts.app')

@section('content')

<div class="container-header">
 
</div>

<div class="container-body">
  <label class="label-bold">Edit Branch Details</label>

    <div>
         @if(Session::has('message'))
            <p id="mydiv" class="text-danger text-center">{{ Session::get('message') }}</p>
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
    </div>

    <div class="page-container div-margin">
      <form method="post" action="{{ route('update_branch')}}" enctype="multipart/form-data" >
        @method('PUT')
        @csrf

        <div class="form-group row">
          <label for="" class="col-2 col-form-label">Region*</label>
          <div class="col-6">
              <select class="form-control form-select" name="region" required>
                <option value="">Select Region</option>
                @foreach($region as $key2=>$value2)
                 <option <?php echo ($value2->id == $value->region_id)?'selected':''  ?> value="{{$value2->id}}">{{$value2->name}} - {{$value2->region_code}}</option>
                @endforeach
              </select>
          </div>
        </div>
        
        <div class="form-group row div-margin">
          <label for="" class="col-2 col-form-label">Branch Name*</label>
          <div class="col-6">
              <input class="form-control" name="name" type="text" placeholder="Enter Branch Name" required value="{{$value->name}}">
          </div>
        </div>

        <div class="form-group row div-margin">
          <label for="" class="col-2 col-form-label">Branch Code *</label>
          <div class="col-6">
              <input class="form-control" name="branch_code" type="text" placeholder="Enter Branch Code" value="{{$value->branch_code}}"  required>
          </div>
        </div>

        <div class="form-group row div-margin">
          <label for="" class="col-2 col-form-label">IFSC *</label>
          <div class="col-6">
              <input class="form-control" name="ifsc" type="text" placeholder="Enter IFSC Code" value="{{$value->ifsc}}" required>
          </div>
        </div>

        <div class="form-group row div-margin">
          <label for="" class="col-2 col-form-label">Area *</label>
          <div class="col-6">
              <input class="form-control" name="area" type="text" placeholder="Enter City Name" value="{{$value->area}}" required>
          </div>
        </div>

        <div class="form-group row div-margin">
          <label for="" class="col-2 col-form-label">City *</label>
          <div class="col-6">
              <input class="form-control" name="city" type="text" placeholder="Enter City Name" value="{{$value->city}}" required>
          </div>
        </div>

        <div class="form-group row div-margin">
          <label for="" class="col-2 col-form-label">District *</label>
          <div class="col-6">
              <input class="form-control" name="district" type="text" placeholder="Enter District Name"  value="{{$value->district}}" required>
          </div>
        </div>


        <div class="form-group row div-margin">
          <label for="" class="col-2 col-form-label">State *</label>
          <div class="col-6">
              <input class="form-control" name="state" type="text" placeholder="Enter State Name"  value="{{$value->state}}" required>
          </div>
        </div>

         <div class="form-group row div-margin">
          <label for="" class="col-2 col-form-label">Pincode *</label>
          <div class="col-6">
              <input class="form-control" name="pincode" type="text" placeholder="Enter PinCode" minlength="6" maxlength="6" value="{{$value->pincode}}"  required>
          </div>
        </div>

        <hr/>
        <label class="label-bold">Bank Contact Details</label>

          <div class="form-group row div-margin">
            <label for="" class="col-2 col-form-label">name *</label>
            <div class="col-6">
                <input class="form-control" name="cname" type="text" placeholder="Enter Contact Name" value="{{$value->ct_name}}"  required>
            </div>
          </div>

          <div class="form-group row div-margin">
            <label for="" class="col-2 col-form-label">Number *</label>
            <div class="col-6">
                <input class="form-control" name="cnumber" type="text" placeholder="Enter Contact Number" minlength="10" maxlength="10" value="{{$value->ct_mobile}}" required>
            </div>
          </div>

          <div class="form-group row div-margin">
            <label for="" class="col-2 col-form-label">Email *</label>
            <div class="col-6">
                <input class="form-control" name="cemail" type="text" placeholder="Enter Email ID" value="{{$value->ct_email}}" required>
            </div>
          </div>

          <div class="form-group row div-margin">
            <label for="" class="col-2 col-form-label">Designation *</label>
            <div class="col-6">
                <input class="form-control" name="cdesignation" type="text" placeholder="Enter Designation" value="{{$value->ct_designation}}" required>
            </div>
          </div>
        <input type="hidden" name="id" value="{{$value->id}}">

        
         <div class="div-margin" >
        
            <button type="submit" class="btn btn-sm btn-outline-success">Update </button>
            
          </div>
      </form>
            
  
    </div>    
    
</div>
  
@endsection