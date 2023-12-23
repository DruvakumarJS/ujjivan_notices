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
                    <span class="" id="basic-addon3">Search </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="typeahead form-control" id="bank" placeholder="Search by bank name / bank code / ifsc" required>
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
                    <span class="" id="basic-addon3">Bank Name *</span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text"  class="form-control" id="bank_name" name="bank_name" value="{{$data->bank->bank_name}}" readonly>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Bank Code * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text"class="form-control" id="bank_code" name="bank_code" value="{{$data->bank->bank_code}}" readonly>
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

                  <input type="text" minlength="11" maxlength="11" class="form-control" id="ifsc" name="ifsc" value="{{$data->bank->ifsc}}" readonly>
                </div>
            </div>   
       </div>

        <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Building * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="building" name="building" value="{{$data->bank->building}}" readonly>
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

                  <input type="text" class="form-control" id="area" name="area" value="{{$data->bank->area}}" readonly>
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

                  <input type="text" class="form-control" id="city" name="city" value="{{$data->bank->branch->city}}" readonly>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">District * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">

                  <input type="text" class="form-control" id="dist" name="city" value="{{$data->bank->branch->district}}"  readonly>
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

                  <input type="text" class="form-control" id="state" aria-describedby="basic-addon3" name="state" value="{{$data->bank->branch->state}}"readonly>
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

                  <input type="text" class="form-control" id="pincode" name="pincode" aria-describedby="basic-addon3" value="{{$data->bank->pincode}}" readonly>
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

                  <select class="form-control form-select" name="status" disabled>
                    <option value="Online" <?php echo ($data->status == 'Online')?'selected':'' ?> >Online</option>
                    <option value="Offline" <?php echo ($data->status == 'Offline')?'selected':'' ?> >Offline</option>
                    <option value="Dead" <?php echo ($data->status == 'Dead')?'selected':'' ?> >Dead</option>
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
            $('#bank_name').val(ui.item.bank_name);
            $('#ifsc').val(ui.item.ifsc);
            $('#bank_code').val(ui.item.bank_code);
            $('#building').val(ui.item.building);
            $('#area').val(ui.item.area);
            $('#city').val(ui.item.city);
            $('#dist').val(ui.item.district);
            $('#bank_code').val(ui.item.bank_code);
            $('#pincode').val(ui.item.pincode);
            $('#state').val(ui.item.state);
            $('#branch_id').val(ui.item.id);
            $('#bank_id').val(ui.item.bankid);
           
           console.log(address); 

        }
        
      });
  
});

</script>

    
@endsection