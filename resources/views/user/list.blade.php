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
        <div class="container-header d-flex">
          <div class="ms-auto">
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal">
           Add User</button>
          </div>
        </div>
        <div>
        	 <label class="label-bold" style="margin-left: 20px" >Users</label>

           @if(Session::has('message'))
            <p id="mydiv" class="text-danger text-center label-bold">{{ Session::get('message') }}</p>
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

        	<div class="card" >

            <table class="table table-responsive table-striped table-bordered border-dark">
              <thead class="table-dark border-warning">
                <tr>
                  <th>User Name</th>
                  <th>Email Id</th>
                  <th>Role</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $key=>$value)

                @php
                 $role = $value->role;
                 if($role == 'superadmin') $role='Super Admin';
                 if($role == 'content_admin') $role='Content Admin';
                 if($role == 'device_admin') $role='Device Admin';
                 if($role == 'readonly') $role='Read-Only User';
                @endphp
                <tr>
                  <td>{{$value->name}}</td>
                  <td>{{$value->email}}</td>
                  <td>{{$role}}</td>
                  <td>
                    <a id="MyapprovalModal_{{$key}}"><button class="btn btn-sm btn-secondary">Edit</button></td></a>
                  </td>
                                                
                </tr>


                <div class="modal fade" id="approvalstatusModal_{{$key}}" tabindex="-1" aria-labelledby="MyapprovalModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="MyapprovalModalLabel">Edit User Details</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form method="POST" action="{{ route('save_user')}}">
                      @csrf
                      <div class="modal-body">
                         <div class="form-group">
                          <label for="recipient-name" class="col-form-label">User Name</label>
                          <input type="text" class="form-control" name="name" value="{{ $value->name}}" required>
                        </div>
                        <div class="form-group">
                          <label for="message-text" class="col-form-label">Email Id</label>
                          <input type="text" class="form-control"name="email" value="{{ $value->email}}" required> 
                        </div>
                        <div class="form-group">
                          <label for="message-text" class="col-form-label">Role</label>
                          <select class="form-control form-select" name="role">
                            <option value="">Select Role</option>
                            <option {{ ($value->role == 'superadmin')? 'selected':''}}  value="superadmin">Super Admin</option>
                            <option {{ ($value->role == 'content_admin')? 'selected':''}}  value="content_admin">Content Admin</option>
                            <option {{ ($value->role == 'device_admin')? 'selected':''}}  value="device_admin">Device Admin</option>
                            <option {{ ($value->role == 'readonly')?'selected':''}}  value="readonly">ReadOnly User</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="message-text" class="col-form-label">Password</label>
                          <input type="password" class="form-control" name="password" value="{{ old('name')}}" >
                        </div>

                        <div class="form-group">
                          <label for="message-text" class="col-form-label">Confirm Password</label>
                          <input type="password" class="form-control" name="confirm_password" >
                        </div>
                      </div>
                      <input type="hidden" name="userid" value="{{$value->id}}">
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div>
                    </form>
                   </div> 
                    
                  </div>
                </div>    
              </div>

             <script type="text/javascript" nonce="wUDPhZ1Z60CsrpnMCukimCi">
               $(document).ready(function(){
                          $('#MyapprovalModal_{{$key}}').click(function(){

                            $('#approvalstatusModal_{{$key}}').modal('show');
                          });
                        });
             </script>

                @endforeach
              
              </tbody>
            </table>

            
            
        </div>
        <!--</div>-->
     </div>
    </div>	
    </div>

   
</div>



<!-- Add Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="label-bold" id="exampleModalLabel">Add New User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{ route('save_user')}}">
        @csrf
        <div class="modal-body">
           <div class="form-group">
            <label for="recipient-name" class="col-form-label">User Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name')}}" required>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Email Id</label>
            <input type="text" class="form-control"name="email" value="{{ old('email')}}" required> 
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Role</label>
            <select class="form-control form-select" name="role">
              <option value="">Select Role</option>
              <option  value="superadmin">Super Admin</option>
              <option value="content_admin">Content Admin</option>
              <option  value="device_admin">Device Admin</option>
              <option  value="readonly">ReadOnly User</option>
            </select>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Password</label>
            <input type="text" class="form-control" name="password" value="{{ old('name')}}" required>
          </div>

          <div class="form-group">
            <label for="message-text" class="col-form-label">Confirm Password</label>
            <input type="text" class="form-control" name="confirm_password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>





@endsection