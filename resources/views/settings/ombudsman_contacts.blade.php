@extends('layouts.app')

@section('content')

<style type="text/css">
   td{
    max-width: 150px;
    overflow: hidden;
    text-overflow: clip;
    white-space: nowrap;
    }

      ::-webkit-scrollbar {
      height: 4px;              
      width: 4px;    
      }

   .scrollable-cell {
     
      overflow-x: auto;/* Display ellipsis (...) for overflowed content */
  }  

</style>
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="container-header">

           <div id="div2" style="margin-right: 30px">
            <a data-bs-toggle="modal" data-bs-target="#importOmbudsmentModal"  class="btn btn-light btn-outline-secondary" href=""><label id="modal">Import Banking Ombudsman Details</label></a>
          </div>
           
            <div id="div2" style="margin-right: 30px">
           <form method="GET" action="{{route('search_ombudsman_conatcts',$lang)}}">
            @csrf
            <div class="input-group mb-3">
                <input class="form-control" type="text" name="search" placeholder="Search here" value="{{$search}}">
                <div class="input-group-prepend">
                   <button class="btn btn-outline-secondary rounded-0" type="submit" >Search</button>
                </div>
              </div>
           </form>
          </div>

          <div id="div2" style="margin-right: 30px">
           
             <div class="input-group mb-3">
                <select class="form-control form-select" id="languages" name="lang" >
                 <option value="all" >All Languages</option>  
                @foreach($languages as $key=>$value)
                <option {{ ( $value->code == $lang )?'selected':'' }} value="{{$value->code}}">{{$value->lang}} - {{$value->name}}</option>

                @endforeach
                
              </select>

              </div>
          
        </div>

        </div>

       <!-- Import Ombudsment Modal -->
        <div class="modal fade" id="importOmbudsmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Banking Ombudsment Details from Excel Sheet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="{{ route('import_banking_ombudsment')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <div class="custom-file text-left">
                            <input type="file" name="file" class="custom-file-input" id="customFile">
                           
                        </div>
                    </div>
                    <button class="btn btn-success">Import</button>
                    
                </form>

                <div id="div2">
                       <a target="_blank" href="{{ URL::to('/') }}/N9_ombudsman.xlsx" ><button class="btn btn-sm btn-light">Download Template</button></a>
                    </div>
              </div>
              
            </div>
          </div>
        </div>
<!--Import Ombudsment Modal -->
        @if(Session::has('message'))
            <p id="mydiv" class="text-danger text-center">{{ Session::get('message') }}</p>
        @endif 
 
       
        <div>
        	 <label class="label-bold" style="margin-left: 20px" >Banking Ombudsman</label>

        	<div class="card border-white scroll tableFixHead " style="height: 600px; padding: 0px 5px 20px 20px">

                        <table class="table">
                            <thead>
                            <tr>
                              <th class="col">View</th>
                              <th class="col">State</th>
                              <th class="col">Ombudsman Name</th>
                              <th class="col">Center</th>
                              <th class="col">Area</th>
                              <th class="col">Addrees</th>
                              <th class="col">Telephone</th>
                              <th class="col">Fax</th>
                              <th class="col">Email</th>
                              <th class="col">Toll-Free Number</th>
                              
                            </tr>
                         </thead>
                          <tbody>
                            @foreach($data as $key=>$value)
                            
                            <tr>
                             <td>
                              <a id="MyviewModal_{{$key}}"><button class="btn btn-sm btn-outline-secondary">View</button></a>
                              <a id="MyeditModal_{{$key}}"><button class="btn btn-sm btn-outline-success">Edit</button></a>
                            </td>
                              <td title="{{$value->state}}">{{$value->state}}</td>
                              <td title="{{$value->banking_ombudsment_name}}">{{$value->banking_ombudsment_name}}</td>
                              <td title="{{$value->center_name}} ">{{$value->center_name}} </td>
                              <td title="{{$value->area_name}}">{{$value->area_name}} </td>
                              <td title="{{$value->full_address}}">{{$value->full_address}} 
                              <td title="{{$value->tel_number}}">{{$value->tel_number}} </td>
                              <td title="{{$value->fax_number}}">{{$value->fax_number}} </td>
                              <td title="{{$value->email_id}}">{{$value->email_id}} </td>
                              <td title="{{$value->toll_free_number}}">{{$value->toll_free_number}} </td>
                              
                            </tr>

                            <div class="modal" id="view_modal{{$key}}"  >
                              <div class="modal-dialog modal-xl" >
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title"> Banking Ombudsman Details - {{$value->state}}</h5>
                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                     
                                  </div>
                                   <div class="modal-body">
                                       
                                   <div class="form-build">
                                    
                                    <div class="row">
                                      <div class="col">
                                        <label>Ombudsman Name</label>
                                        <input type="input" class="form-control" name="" value="{{$value->banking_ombudsment_name }}" readonly>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Center</label>
                                        <input type="input" class="form-control" name="" value="{{$value->center_name}}" readonly>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Area</label>
                                        <input type="input" class="form-control" name="" value="{{$value->area_name}}" readonly>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Addrees</label>
                                        <input type="input" class="form-control" name="" value="{{$value->full_address}}" readonly>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Telephone </label>
                                        <input type="input" class="form-control" name="" value="{{$value->tel_number}}" readonly>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Fax</label>
                                        <input type="input" class="form-control" name="" value="{{$value->fax_number}}" readonly>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Email</label>
                                        <input type="input" class="form-control" name="" value="{{$value->email_id}}" readonly>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Toll-Free Number</label>
                                        <input type="input" class="form-control" name="" value="{{$value->toll_free_number}}" readonly>
                                        
                                      </div>
                                    </div>

                                    
                                     
                                   </div>

                                  </div>
                                 
                                </div>
                              </div>
                            </div>
                                            

                             <script>
                              $(document).ready(function(){
                                $('#MyviewModal_{{$key}}').click(function(){
                                  $('#view_modal{{$key}}').modal('show');
                                
                                });
                              });  
                              </script>


                              <div class="modal" id="edit_modal{{$key}}"  >
                              <div class="modal-dialog modal-xl" >
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title"> Edit Banking Ombudsman Details - {{$value->state}} </h5>
                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                     
                                  </div>
                                  
                                  <div class="modal-body">
                                       
                                   <div class="form-build">

                                    <form method="POST" action="{{ route('update_ombudsman_contacts')}}">
                                    @csrf
                                    <div class="form-build">
                                    
                                    <div class="row">
                                      <div class="col">
                                        <label>Ombudsman Name</label>
                                        <input type="input" class="form-control" name="banking_ombudsment_name" value="{{$value->banking_ombudsment_name }}" >
                                        
                                      </div>
                                       <div class="col">
                                        <label>Center</label>
                                        <input type="input" class="form-control" name="center_name" value="{{$value->center_name}}" >
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Area</label>
                                        <input type="input" class="form-control" name="area_name" value="{{$value->area_name}}" >
                                        
                                      </div>
                                       <div class="col">
                                        <label>Addrees</label>
                                        <input type="input" class="form-control" name="full_address" value="{{$value->full_address}}" >
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Telephone </label>
                                        <input type="input" class="form-control" name="tel_number" value="{{$value->tel_number}}" >
                                        
                                      </div>
                                       <div class="col">
                                        <label>Fax</label>
                                        <input type="input" class="form-control" name="fax_number" value="{{$value->fax_number}}" >
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Email</label>
                                        <input type="input" class="form-control" name="email_id" value="{{$value->email_id}}" >
                                        
                                      </div>
                                       <div class="col">
                                        <label>Toll-Free Number</label>
                                        <input type="input" class="form-control" name="toll_free_number" value="{{$value->toll_free_number}}" >
                                        
                                      </div>
                                    </div>

                                     
                                   </div>
                                    <input type="hidden" name="state" value="{{$value->state}}">
                                    <input type="hidden" name="lang_code" value="{{$value->lang_code}}">

                                    <div class="py-4">
                                      <button class="btn btn-sm btn-success">Update</button>
                                    </div>

                                    </form>
                                     
                                   </div>

                                  </div>

                                 
                                </div>
                              </div>
                            </div>

                              <script>
                              $(document).ready(function(){
                                $('#MyeditModal_{{$key}}').click(function(){
                                  $('#edit_modal{{$key}}').modal('show');
                                
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

   
</div>

<script type="text/javascript">
  $("[name='lang']").on("change", function (e) {
    //alert( window.location.origin);
     let edit_id = $(this).val();
    
     var href = window.location.origin + '/Banking-Ombudsman-contacts-details/' + edit_id ;
    // alert(href);

     window.location=href;
})
</script>

@endsection