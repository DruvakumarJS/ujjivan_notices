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
        
          <label class="label-bold">Display Standiee Disclaimer </label>

          <div class="form-group row div-margin">
            <label for="" class="col-2 col-form-label">Disclaimer 1 (Top)*</label>
            <div class="col-6">
                <textarea class="form-control" name="disclaimer1" readonly>Branch Name : {{$value->name}}  |  Branch Code : {{$value->branch_code}}  |  Manager Name : {{$value->branchinfo->bm_name}}  |  Manager Contact : {{$value->branchinfo->bm_number}}</textarea>
            </div>
          </div>

          <div class="form-group row div-margin">
            <label for="" class="col-2 col-form-label">Disclaimer 2 (Bottom)*</label>
            <div class="col-6">
                <textarea class="form-control" name="disclaimer2" onkeyup="textAreaAdjust(this)" style="overflow:hidden" required>{{$value->branchinfo->disclaimer2}}</textarea>
            </div>
          </div>  

          <hr/>
          <label class="label-bold">Display Standiee Poster </label>
          <p>A full screen image wil be displayed in display standiee when it is set to active for the provided interval .Later the application will rollouts automatically to show notices . </p>

          <div class="form-group row div-margin">
            <label for="" class="col-2 col-form-label">Advertisement </label>
            <div class="col-6">
                <select class="form-control form-select" name="announcement">
                  <option value="">Select</option>
                  <option value="1" {{ ($value->branchinfo->announcement == '1')?'selected':''}}>Active</option>
                  <option value="0" {{ ($value->branchinfo->announcement == '0')?'selected':''}}>Inactive</option>
                </select>
            </div>
          </div>

          <div class="form-group row div-margin">
            <label for="" class="col-2 col-form-label">Start Date and Time </label>
            <div class="col-6">
                <input class="form-control" type="datetime-local" name="start" id="start" value="{{$value->branchinfo->start_time}}">
            </div>
          </div>

          <div class="form-group row div-margin">
            <label for="" class="col-2 col-form-label">End Date and Time </label>
            <div class="col-6">
                <input class="form-control" type="datetime-local" name="end" id="end" value="{{$value->branchinfo->end_time}}">
            </div>
          </div>

          <div class="form-group row div-margin">
            <label for="" class="col-2 col-form-label">File </label>
            <div class="col-6">
                <input class="form-control" type="file" name="announcement_file" id="announcement_file" accept="image/*">
            </div>
          </div>
  
        <input type="hidden" name="id" value="{{$value->id}}">

        
         <div class="div-margin" >
        
            <button type="submit" class="btn btn-sm btn-outline-success">Update </button>
            
          </div>
      </form>
            
  
    </div>    
    
</div>

<script type="text/javascript">
  function textAreaAdjust(element) {
  element.style.height = "1px";
  element.style.height = (25+element.scrollHeight)+"px";
}
</script>
  
@endsection