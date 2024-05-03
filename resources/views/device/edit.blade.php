@extends('layouts.app')

@section('content')

<div class="container-header">
  <div id="div3" class="div-margin" style="margin-right: 30px">
         <a href="{{route('devices')}}"><button class="btn btn-outline-secondary" type="submit">Go Back</button> </a>
  </div>

</div>

<div class="container-body">
  <label class="label-bold">Edit Device Details</label>

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

    <div class="page-container">
       <hr/>
       <h4>Bank Details</h4>
       <form method="POST" action="{{ route('update_device_datails',$id)}}">
        @method('put')
        @csrf

         <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Search </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="typeahead form-control" id="bank" placeholder="Search by bank name / bank code / ifsc" >
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

                  <input type="text" class="form-control" id="branch_code" name="branch_code" aria-describedby="basic-addon3" value="{{$data->branch->branch_code}}" readonly>
                </div>
            </div>   
       </div>


       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Branch Name *</span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text"  class="form-control" id="branch_name" name="branch_name" value="{{$data->branch->name}}" readonly>
                </div>
            </div>   
       </div>
    
      <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Address * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="area" name="area" value="{{$data->branch->area}} , {{$data->branch->city}} , {{$data->branch->district}} ,{{$data->branch->pincode}}" readonly>
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

                  <input type="text" class="form-control" id="state" aria-describedby="basic-addon3" name="state" value="{{$data->branch->state}}" readonly>
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

                  <input type="text" class="form-control" id="pincode" name="pincode" aria-describedby="basic-addon3" value="{{$data->branch->pincode}}" readonly>
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

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="device_id" value="{{$data->mac_id}}" >
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Hardware details * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" name="model" value="{{$data->device_details}}" aria-describedby="basic-addon3" >
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

                  <input type="date" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="date_of_installation" value="{{$data->date_of_install}}" >
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

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="date_of_installation" value="{{$data->remote_id}}" >
                </div>
            </div>  
            
       </div>
            
       </div>
        <input type="hidden" name="branch_id" id="branch_id" value="{{$data->branch_id}}">
      

       <div id="div3" class="div-margin">
         <button class="btn btn-success" type="submit">Update</button> 
       </div>

     </form>
    </div>    
    
</div>

<script type="text/javascript">

$( document ).ready(function() {
  var path = "{{ route('get_bank_details') }}";
   let text = "";
    $( "#bank" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
            //  console.log(data);
               response( data );
              
            }
          });
        },
        select: function (event, ui) {
           $('#bank').val(ui.item.value);
            $('#branch_code').val(ui.item.branch_code);
            $('#branch_name').val(ui.item.name);
            $('#ifsc').val(ui.item.ifsc);
            $('#area').val(ui.item.area);
            $('#city').val(ui.item.city);
            $('#dist').val(ui.item.district);
            $('#pincode').val(ui.item.pincode);
            $('#state').val(ui.item.state);
            $('#branch_id').val(ui.item.id);
           
           console.log(address); 

        }
        
      });
  
});

</script>

    
@endsection