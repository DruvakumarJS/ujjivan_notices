@extends('layouts.offlinetemp')

@section('content')

<style type="text/css">
  
.card-header {
  background-color: #f0f0f0;
  font-weight: bold;
  position: sticky;
  top: 0; 
  z-index: 1;
  display: flex;
  align-items: center;
}


.qr-code, .logo {
    height: 30px;
    margin-right: 10px; /* Adjust margin as needed */
}

.text-between-images {
    margin-top: 10px;
    text-align: center; /* Align text in the center */
}



</style>

<div class="container-body">
  
      <!-- content -->

       <div class="row">
            <div style="width: 950px">
              <div class="card text-black bg-white border border-white" style="padding: 0px 20px 20px 20px;">
               <div class="card-header text-muted text-black" style="background-color: white; border: none; display: flex; align-items: center;height: 80px;border-radius: 0;">
                 
                  <div style="height: 30px; margin-left: auto;">
                      <img src="./Ujjivan_files/mainLogo.svg" style="height: 30px;">
                  </div>
                  
              </div>

              @php
                $info = json_decode($data->c11);

              @endphp
              

              <div class="card-body" id="test">
                <div class="text-center">
                  <h4 style="font-weight: bold;">{{ (isset($name))? $name:'' }}</h4>
                </div>
                <div class="text-start">
                  <lable>{{ (isset($description))? $description:'' }}</lable>
                </div>
                
                <table  class="table table-responsive py-4 table-bordered" id="dynamicAddRemove">
 
                <tbody>
                  @foreach($info as $key=>$value)
                  <tr>

                      <td width="50%"><span class="text-end">{{ (isset($OmbudsmanDetail->$key))? $OmbudsmanDetail->$key:'' }}</span></td>
                      <td width="50%">{{ (isset($OmbudsmanDetail->$value))? $OmbudsmanDetail->$value:'' }}</td>
                    
                  </tr>
                   @endforeach
                   </tbody>
                </table>
              </div>

              <div class="card-footer text-muted text-black bg-white footer" style="border: none;">
                 <label style="color: black">Version {{$version}}</label>
                <div id="div3">
                   <label  style="color: black">Published on {{$published}}</label>
                </div>
              </div>
                
              </div>
            </div>
       </div>
     
      
  
</div>


    
@endsection