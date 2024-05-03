@extends('layouts.app')

@section('content')

<div class="container-body">
  <label class="label-bold">Add New Device</label>
    <div >

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
       <form method="POST" action="{{ route('save_device')}}">
        @csrf
       <!-- <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Region * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">
                 <select class="form-control form-select" name="region" required>
                  <option value="">Select Region</option>
                  <option value="East">East</option>
                  <option value="West">West</option>
                  <option value="North">North</option>
                  <option value="South">South</option>
                   
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

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="branch" required>
                </div>
            </div>   
       </div> -->

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

                  <input type="text" class="form-control" id="branch_code" name="branch_code" aria-describedby="basic-addon3" readonly>
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

                  <input type="text"  class="form-control" id="branch_name" name="branch_name" readonly>
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

                  <input type="text" class="form-control" id="area" name="area" readonly>
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

                  <input type="text" class="form-control" id="state" aria-describedby="basic-addon3" name="state" readonly>
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

                  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="device_id" maxlength="20" required>
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

                  <input type="text" class="form-control" id="basic-url" name="model" aria-describedby="basic-addon3" maxlength="200">
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

                  <input type="date" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="date_of_installation" required>
                </div>
            </div>  
            
       </div>
       <input type="hidden" name="branch_id" id="branch_id">
      
       <div id="div3" class="div-margin">
         <button class="btn btn-success" type="submit">Submit</button> 
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
             // console.log(data);
               response( data );
              
            }
          });
        },
        select: function (event, ui) {
           $('#bank').val(ui.item.value);
            $('#branch_code').val(ui.item.branch_code);
            $('#branch_name').val(ui.item.name);
            $('#area').val(ui.item.area +','+ui.item.city + ',' +ui.item.district + ','+ ui.item.pincode);
            $('#state').val(ui.item.state);
            $('#branch_id').val(ui.item.id);
           
          // console.log(address); 

        }
        
      });
  
});

</script>

    
@endsection