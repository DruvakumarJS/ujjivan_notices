@extends('layouts.app')

@section('content')
<style type="text/css">
  .active {
  background-color: orange !important;
}
</style>

<div class="container-header">
    <div id="div2">
      <a data-bs-toggle="modal" data-bs-target="#importModal"  class="btn btn-light btn-outline-secondary" href=""><label id="modal">Import Branch Details</label></a>
    </div>
 
     <div id="div2" style="margin-right: 30px">
       <a data-bs-toggle="modal" data-bs-target="#mymodal" ><button class="btn btn-outline-primary">Add New Branch</button></a>
    </div> 
    
</div>

        @if(Session::has('message'))
            <p id="mydiv" class="text-danger text-center">{{ Session::get('message') }}</p>
        @endif 

<!-- Import Modal -->
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Branch Details from Excel Sheet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="{{ route('import_branches')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <div class="custom-file text-left">
                            <input type="file" name="file" class="custom-file-input" id="customFile">
                           
                        </div>
                    </div>
                    <button class="btn btn-success">Import</button>
                    
                </form>

                <div id="div2">
                       <a target="_blank" href="{{ URL::to('/') }}/Import_branches.xlsx" ><button class="btn btn-sm btn-light">Download Template</button></a>
                    </div>
              </div>
              
            </div>
          </div>
        </div>
<!--Import Modal -->

<div class="container">

    <div class="row" >
      @foreach($region as $key=>$value)
        <div class="col-md-2 div-margin">
          <button type="button" id="btnOUs_{{$key}}" class="form-control btn btn-outline-secondary" ng-click="levelOU()" style="" value="{{$value->id}}_{{$key}}"> <span style="font-weight: bolder;">{{$value->name}}</span> </button>
        </div>
      @endforeach
    </div>

    <div class="div-margin" id="div2" >
     <form method="POST" id="searchForm" >
      @csrf
       <input type="hidden" name="btn_pos" id="btn_position">
       <input type="hidden" name="region_id" id="r_id">
       <div class="input-group mb-3">
          <input class="form-control" type="text" name="search" id="search" placeholder="Search here" value="{{$search}}">
          <div class="input-group-prepend">
             <!-- <button class="btn btn-outline-secondary rounded-0" type="submit" >Search</button> -->
             <!-- <a href="#" class="btn btn-outline-secondary rounded-0" onclick="document.getElementById('searchForm').submit()">Search</a> -->
             <a href="#" class="btn btn-outline-secondary rounded-0" onclick="searchBranch()">Search</a>
          </div>
        </div>
     </form>
    </div>

    <label class="label-bold div-margin" id="branch_count">Branch</label>

    

     <div class="row">
        <div class="card border-white">

            <table class="table">
                <thead>
                 <tr>
                    <th>Branch Code</th>
                    <th>Branch Name</th>
                    <th>Region Name</th>
                    <th>Address</th>
                    <th>State</th>
                    <th>Action</th>
                    
                  </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>

        </div>
    </div>

    <!-- Add Branch -->

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

                  <hr/>
                  <label class="label-bold">Bank Contact Details</label>

                    <div class="form-group row div-margin">
                      <label for="" class="col-4 col-form-label">name *</label>
                      <div class="col-7">
                          <input class="form-control" name="ctname" type="text" placeholder="Enter Contact Name"  required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Number *</label>
                      <div class="col-7">
                          <input class="form-control" name="ctnumber" type="text" placeholder="Enter Contact Number" minlength="10" maxlength="10"  required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Email *</label>
                      <div class="col-7">
                          <input class="form-control" name="ctemail" type="text" placeholder="Enter Email ID"  required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Designation *</label>
                      <div class="col-7">
                          <input class="form-control" name="ctdesignation" type="text" placeholder="Enter Designation"   required>
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

    <!--  Add Branch -->

    
</div>

<script type="text/javascript">
   $(document).ready(function() {

    var btn_pos = '<?php echo $btn_position?>';
    var search = '<?php echo $search?>';
   
    if(search == ''){
      $('#btnOUs_'+btn_pos).click();
      var data = $('#btnOUs_0').val();
      var spl = data.split("_");
      var regionId = spl[0];
     
      document.getElementById('btn_position').value = '0';
      document.getElementById('r_id').value = regionId;


     // getbranches(regionId);
    }
    else{
      $('#btnOUs_'+btn_pos).addClass("active");
      var data = $('#btnOUs_'+btn_pos).val();
      var spl = data.split("_");
      var regionId = spl[0];
      document.getElementById('btn_position').value = btn_pos;
      document.getElementById('r_id').value = regionId;
     

    }
      
   });

  $("button").click(function(){

    $("button").removeClass("active");
    $(this).addClass("active");
    $('#search').val('');
    var data = $(this).val();
   // alert("idis "+regionId);
   var spl = data.split("_");
   var regionId = spl[0];
   
   var pos = spl[1];

  // $('#btn_position').val(spl[1]);
   document.getElementById('btn_position').value = spl[1];
   document.getElementById('r_id').value = regionId;
  
    getbranches(regionId , pos);
  });

  function getbranches(regionId , pos){
    //alert(regionId);
      var _token = $('input[name="_token"]').val();

      $.ajax({
           url:"{{ route('get_branches') }}",
           method:"GET",
           data:{regionId:regionId, _token:_token },
           dataType:"json",
           success:function(data)
           {
            //alert(data);
            console.log(data);

            var output = '';
            var btn_pos = pos;

            $('#branch_count').text('Branch ('+data.length+')');

            for(var count = 0; count < data.length; count++){
              var branch_id = data[count].branch_id;
               var noticehref = window.location.origin + '/branch-notices/en/'+ branch_id ;
               var edithref = window.location.origin + '/edit-branch/'+ branch_id ;
               var deletehref = window.location.origin + '/delete-branch/'+ branch_id ;
             
               output += '<tr>';
               output += '<td>' + data[count].branch_code + '</td>';
               output += '<td>' + data[count].name + '</td>';
               output += '<td>' + data[count].region_name + '</td>';
               output += '<td>' + data[count].address + '</td>';
               output += '<td>' + data[count].state + '</td>';
             output += '<td>' +
                      '<a href="' + noticehref + '"><button class="btn btn-sm btn-outline-secondary">View Notices</button></a>' +' ' +
                      '<a href="' + edithref + '"><button class="btn btn-sm btn-outline-success">Edit</button></a>' +' ' +
                      '<a onclick="return confirm(\'You are deleting a Branch?\')" href="' + deletehref + '"><button class="btn btn-sm btn-outline-danger">Delete</button></a>' +
                      '</td>';

               output += '</tr>';
  
            }

             $('tbody').html(output);


           }

          });

     
  }

   function searchBranch(){
        
        var _token = $('input[name="_token"]').val();
        var regionId = $('#r_id').val();
        var btn_pos = $('#btn_position').val();
        var search = $('#search').val();

        if(search == ''){
          alert('Please enter search key');
        }
        else{


      $.ajax({
           url:"{{ route('search_branch') }}",
           method:"POST",
           data:{regionId:regionId, _token:_token ,btn_pos:btn_pos , search:search},
           dataType:"json",
           success:function(data)
           {
           // alert(data);
            console.log(data);

            var output = '';

            $('#branch_count').text('Branch ('+data.length+')');

            for(var count = 0; count < data.length; count++){
              var branch_id = data[count].branch_id;
               var noticehref = window.location.origin + '/branch-notices/en/'+ branch_id ;
               var edithref = window.location.origin + '/edit-branch/'+ branch_id ;
               var deletehref = window.location.origin + '/delete-branch/'+ branch_id ;

               output += '<tr>';
               output += '<td>' + data[count].branch_code + '</td>';
               output += '<td>' + data[count].name + '</td>';
               output += '<td>' + data[count].region_name + '</td>';
               output += '<td>' + data[count].address + '</td>';
               output += '<td>' + data[count].state + '</td>';
             output += '<td>' +
                      '<a href="' + noticehref + '"><button class="btn btn-sm btn-outline-secondary">View Notices</button></a>' +' ' +
                      '<a href="' + edithref + '"><button class="btn btn-sm btn-outline-success">Edit</button></a>' +' ' +
                      '<a onclick="return confirm(\'You are deleting a Branch?\')" href="' + deletehref + '"><button class="btn btn-sm btn-outline-danger">Delete</button></a>' +
                      '</td>';

               output += '</tr>';
  
            }

             $('tbody').html(output);


           }

          });

        }

      }

    
 

</script>


@endsection
