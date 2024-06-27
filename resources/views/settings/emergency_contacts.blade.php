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
            <a data-bs-toggle="modal" data-bs-target="#emergencyModal"  class="btn btn-light btn-outline-secondary" href=""><label id="modal">Import Emergency Contact</label></a>
          </div>
           
            <div id="div2" style="margin-right: 30px">
           <form method="GET" action="{{route('search_emergency_conatcts',$lang)}}">
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

        <!-- Emergency Modal -->

        <div class="modal fade" id="emergencyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Emergency Contact Details from Excel Sheet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="{{ route('import_branch_emergency_contacts')}}" method="POST" enctype="multipart/form-data">
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

<!-- Emergency Model -->
        @if(Session::has('message'))
            <p id="mydiv" class="text-danger text-center">{{ Session::get('message') }}</p>
        @endif 
 
       
        <div>
        	 <label class="label-bold" style="margin-left: 20px" >Emergency Contact Details</label>

        	<div class="card border-white scroll tableFixHead " style="height: 600px; padding: 0px 5px 20px 20px">

                        <table class="table">
                            <thead>
                            <tr>
                              <th class="col">View</th>
                              <th class="col">BranchID</th>
                              <th class="col">Address</th>
                              <th class="col">Police Station</th>
                              <th class="col">Medical Support</th>
                              <th class="col">Ambulance</th>
                              <th class="col">Fire Station</th>
                              <th class="col">Branch Manager</th>
                              <th class="col">RNO</th>
                              <th class="col">PNO</th>
                              <th class="col">Contact Center</th>
                              <th class="col">Cyber Dost</th>
                              
                            </tr>
                         </thead>
                          <tbody>
                            @foreach($data as $key=>$value)
                            
                            <tr>
                             <td>
                              <a id="MyviewModal_{{$key}}"><button class="btn btn-sm btn-outline-secondary">View</button></a>
                              <a id="MyeditModal_{{$key}}"><button class="btn btn-sm btn-outline-success">Edit</button></a>
                            </td>
                              <td>{{$value->branch_id}}</td>
                              <td title="{{$value->branch->area}}">{{$value->branch->area}}</td>
                              <td title="{{$value->police}} - {{$value->police_contact}}">{{$value->police}} <br/> {{$value->police_contact}}</td>
                              <td title="{{$value->medical}} - {{$value->medical_contact}}">{{$value->medical}} <br/> {{$value->medical_contact}}</td>
                              <td title="{{$value->ambulance}} - {{$value->ambulance_contact}}">{{$value->ambulance}} <br/> {{$value->ambulance_contact}}</td>
                              <td title="{{$value->fire}} -{{$value->fire_contact}}">{{$value->fire}} <br/> {{$value->fire_contact}}</td>
                              <td title="{{$value->manager}} - {{$value->manager_contact}}">{{$value->manager}} <br/> {{$value->manager_contact}}</td>
                              <td title="{{$value->rno}} - {{$value->rno_contact}}">{{$value->rno}} <br/> {{$value->rno_contact}}</td>
                              <td title="{{$value->pno}} - {{$value->pno_contact}}">{{$value->pno}} <br/> {{$value->pno_contact}}</td>
                              <td title="{{$value->contact_center}} - {{$value->contact_center_number}}">{{$value->contact_center}} <br/> {{$value->contact_center_number}}</td>
                              <td title="{{$value->cyber_dost}} - {{$value->cyber_dost_number}}">{{$value->cyber_dost}} <br/> {{$value->cyber_dost_number}}</td>
                             
                            </tr>

                            <div class="modal" id="view_modal{{$key}}"  >
                              <div class="modal-dialog modal-xl" >
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title"> {{$value->branch_id}} - {{$value->branch->area}}</h5>
                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                     
                                  </div>
                                  <div class="modal-body">
                                       
                                   <div class="form-build">
                                    
                                    <div class="row">
                                      <div class="col">
                                        <label>Police Station address</label>
                                        <input type="input" class="form-control" name="" value="{{$value->police}}" readonly>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Police Station Contact</label>
                                        <input type="input" class="form-control" name="" value="{{$value->police_contact}}" readonly>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Medical Support address</label>
                                        <input type="input" class="form-control" name="" value="{{$value->medical}}" readonly>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Medical Support Contact</label>
                                        <input type="input" class="form-control" name="" value="{{$value->medical_contact}}" readonly>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Ambulance </label>
                                        <input type="input" class="form-control" name="" value="{{$value->ambulance}}" readonly>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Ambulance Contact</label>
                                        <input type="input" class="form-control" name="" value="{{$value->ambulance_contact}}" readonly>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Fire Station address</label>
                                        <input type="input" class="form-control" name="" value="{{$value->fire}}" readonly>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Fire Station Contact</label>
                                        <input type="input" class="form-control" name="" value="{{$value->fire_contact}}" readonly>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Branch Manager</label>
                                        <input type="input" class="form-control" name="" value="{{$value->manager}}" readonly>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Branch Manager Contact</label>
                                        <input type="input" class="form-control" name="" value="{{$value->manager_contact}}" readonly>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>RNO</label>
                                        <input type="input" class="form-control" name="" value="{{$value->rno}}" readonly>
                                        
                                      </div>
                                       <div class="col">
                                        <label>RNO Contact</label>
                                        <input type="input" class="form-control" name="" value="{{$value->rno_contact}}" readonly>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>PNO address</label>
                                        <input type="input" class="form-control" name="" value="{{$value->pno}}" readonly>
                                        
                                      </div>
                                       <div class="col">
                                        <label>PNO Contact</label>
                                        <input type="input" class="form-control" name="" value="{{$value->pno_contact}}" readonly>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Conatct  Center</label>
                                        <input type="input" class="form-control" name="" value="{{$value->contact_center}}" readonly>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Conatct Center Contact</label>
                                        <input type="input" class="form-control" name="" value="{{$value->contact_center_number}}" readonly>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Cyber Dost</label>
                                        <input type="input" class="form-control" name="" value="{{$value->cyber_dost}}" readonly>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Cyber Dost Contact</label>
                                        <input type="input" class="form-control" name="" value="{{$value->cyber_dost_number}}" readonly>
                                        
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
                                    <h5 class="modal-title"> {{$value->branch_id}} - {{$value->branch->area}}</h5>
                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                     
                                  </div>
                                  <div class="modal-body">
                                       
                                   <div class="form-build">

                                    <form method="POST" action="{{ route('update_emergency_contacts')}}">
                                    @csrf
                                    <div class="row">
                                      <div class="col">
                                        <label>Police Station address</label>
                                        <input type="input" class="form-control" name="police" value="{{$value->police}}" required>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Police Station Contact</label>
                                        <input type="input" class="form-control" name="police_contact" value="{{$value->police_contact}}" required>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Medical Support address</label>
                                        <input type="input" class="form-control" name="medical" value="{{$value->medical}}" required>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Medical Support Contact</label>
                                        <input type="input" class="form-control" name="medical_contact" value="{{$value->medical_contact}}" required>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Ambulance </label>
                                        <input type="input" class="form-control" name="ambulance" value="{{$value->ambulance}}" required>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Ambulance Contact</label>
                                        <input type="input" class="form-control" name="ambulance_contact" value="{{$value->ambulance_contact}}" required>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Fire Station address</label>
                                        <input type="input" class="form-control" name="fire" value="{{$value->fire}}" required>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Fire Station Contact</label>
                                        <input type="input" class="form-control" name="fire_contact" value="{{$value->fire_contact}}" required>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Branch Manager</label>
                                        <input type="input" class="form-control" name="manager" value="{{$value->manager}}" required>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Branch Manager Contact</label>
                                        <input type="input" class="form-control" name="manager_contact" value="{{$value->manager_contact}}" required>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>RNO</label>
                                        <input type="input" class="form-control" name="rno" value="{{$value->rno}}" required>
                                        
                                      </div>
                                       <div class="col">
                                        <label>RNO Contact</label>
                                        <input type="input" class="form-control" name="rno_contact" value="{{$value->rno_contact}}" required>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>PNO address</label>
                                        <input type="input" class="form-control" name="pno" value="{{$value->pno}}" required>
                                        
                                      </div>
                                       <div class="col">
                                        <label>PNO Contact</label>
                                        <input type="input" class="form-control" name="pno_contact" value="{{$value->pno_contact}}" required>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Conatct  Center</label>
                                        <input type="input" class="form-control" name="contact_center" value="{{$value->contact_center}}" required>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Conatct Center Contact</label>
                                        <input type="input" class="form-control" name="contact_center_number" value="{{$value->contact_center_number}}" required>
                                        
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col">
                                        <label>Cyber Dost</label>
                                        <input type="input" class="form-control" name="cyber_dost" value="{{$value->cyber_dost}}" required>
                                        
                                      </div>
                                       <div class="col">
                                        <label>Cyber Dost Contact</label>
                                        <input type="input" class="form-control" name="cyber_dost_number" value="{{$value->cyber_dost_number}}" required>
                                        
                                      </div>
                                    </div>
                                    <input type="hidden" name="branch_id" value="{{$value->branch_id}}">
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
    
     var href = window.location.origin + '/emergency-contacts-details/' + edit_id ;
    // alert(href);

     window.location=href;
})
</script>

@endsection