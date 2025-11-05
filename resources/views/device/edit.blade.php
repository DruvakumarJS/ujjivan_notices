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

                  <input type="text" class="form-control" id="area" name="area" value="{{$data->branch->area}}" readonly>
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
                    <span class="" id="basic-addon3">Default Notice Language * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <select class="form-control form-select" name="lang" required>
                    <option>Select Language</option>
                    @foreach($langauge as $key=>$val)
                      <option {{ ($data->default_lang == $val->code)?'selected':''}} value="{{ $val->code}}">{{$val->lang}}</option>
                    @endforeach
                  </select>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Device Serial Number (ID generated by Super Admin)  * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="serial_no" placeholder="Enter Serial Number " value="{{$data->deviceID}}"  required>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Authorization ID ( ID generated in application )* </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="device_id" maxlength="20" placeholder="Enter Authorization ID (Shown in application) " value="{{($data->mac_id)}}" required>
                </div>
            </div>   
       </div>
   
       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Display Serial Number * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" name="tv" aria-describedby="basic-addon3" maxlength="200" value="{{$data->tv_serial_no}}" placeholder="Enter Display Serial Number">
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Android Box Serial Number * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" name="model" aria-describedby="basic-addon3" maxlength="200" value="{{$data->device_details}}" placeholder="Enter Android Box Serial Number">
                </div>
            </div>   
       </div>


       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">GSM Router Serial Number * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" name="router" aria-describedby="basic-addon3" maxlength="200" value="{{$data->router_serial_number}}" placeholder="Enter GSM Router Serial Number ">
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Sim Card Number * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" name="sim" aria-describedby="basic-addon3" maxlength="200" placeholder="Enter Sim Card Number" value="{{$data->sim_card_number}}">
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Sim Card Connection Number * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="basic-url" name="sim_connection" aria-describedby="basic-addon3" maxlength="200" placeholder="Enter Sim Card Connection Number" value="{{$data->sim_connection_number}}">
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