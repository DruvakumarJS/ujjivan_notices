@extends('layouts.app')

@section('content')
<style type="text/css">
  .textareaElement {
 
  min-height: 200px;
  border: 1px solid #ccc;
  max-height: 1000px;
  overflow-x: hidden;
  overflow-y: auto;
}

</style>

<div class="container-body">
  <label class="label-bold">Notice Details</label>
    <div class="container-header">
        <div id="div3" class="div-margin">
         <a href="{{ route('edit_notice_datails',$id)}}"><button class="btn btn-success" type="submit">Edit</button></a> 
       </div>

       <div id="div3" class="div-margin" style="margin-right: 30px">
         <a href="{{route('notices')}}"><button class="btn btn-outline-secondary" type="submit">Go Back</button> </a>
       </div>

    </div>

    <div class="page-container">
       <hr/>
      
       <form method="POST" action="{{ route('save_notice')}}">
        @csrf

        <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Notice Tittle  </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">
                 <input class="form-control" type="text" name="tittle" value="{{ $data->name}}" readonly>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Notice Description  </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">
                 <input class="form-control" type="text" name="description" value="{{ $data->description}}" readonly>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Is PAN India Notice ?  </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">
                 <input class="form-control" type="text" name="" value="{{$data->is_pan_india}}" readonly>
                </div>
            </div>   
       </div>

       <div class="row" >
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Is Region Wise Notice ?  </span>
                  </div>
            </div> 
            <div class="col-6" >
                <div class="input-group mb-3" id="region_dropdown">
                 
                 <input class="form-control" type="text" name="" value="{{($data->is_region_wise == '1')?'Yes':'No' }}" readonly>
                </div>
            </div>   
       </div>

       <div class="row" id="region_dropdown_list" id="region_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Selected Regions  </span>
                  </div>
            </div> 
          <div class="col-6">
             <div class="input-group mb-3">
                <input class="form-control" type="text" name="" value="{{$data->regions}}" readonly>

              </div>
            </div>
       </div>


       <div class="row" id="state_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Is State wise Notice ?  </span>
                  </div>
            </div> 
            <div class="col-6" id="state_dropdown">
                <div class="input-group mb-3">
                 
                 <input class="form-control" type="text" name="" value="{{($data->is_state_wise == 'ya')?'Yes':'No' }}" readonly>
                </div>
            </div>   
       </div>

        <div class="row" id="state_dropdown_list">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Selected States  </span>
                  </div>
            </div> 
          <div class="col-6">
             <div class="input-group mb-3">
             <input class="form-control" type="text" name="" value="{{$data->states}}" readonly>
              </div>
            </div>
       </div>

       <div class="row" id="state_dropdown_list">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Available Languages</span>
                  </div>
            </div> 
          <div class="col-6">
             <div class="input-group mb-3">
             <input class="form-control" type="text" name="" value="{{$data->available_languages}}" readonly>

              </div>
            </div>
       </div>

       <div class="row" id="state_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Voice Over Needed</span>
                  </div>
            </div> 
            <div class="col-6" id="state_dropdown">
                <div class="input-group mb-3">
                 <input class="form-control" type="text" name="" value="{{($data->voiceover == 'Yes')?'Yes':'No' }}" readonly>
                </div>
            </div>   
        </div>

        <div class="row" id="state_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Notice Creator</span>
                  </div>
            </div> 
            <div class="col-6" id="state_dropdown">
                <div class="input-group mb-3">
                 <input class="form-control" type="text" name="" value="{{ $data->creator}}" readonly>
                </div>
            </div>   
        </div>

        <div class="row" id="state_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Published Date</span>
                  </div>
            </div> 
            <div class="col-6" id="state_dropdown">
                <div class="input-group mb-3">
                 <input class="form-control" type="text" name="" value="{{ $data->published_date}}" readonly>
                </div>
            </div>   
        </div>

        <div class="row" id="state_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Expiry Date</span>
                  </div>
            </div> 
            <div class="col-6" id="state_dropdown">
                <div class="input-group mb-3">
                 <input class="form-control" type="text" name="" value="{{ $data->expiry_date}}" readonly>
                </div>
            </div>   
        </div>

        <div class="row" id="state_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Status</span>
                  </div>
            </div> 
            <div class="col-6" id="state_dropdown">
                <div class="input-group mb-3">
                 <input class="form-control" type="text" name="" value="{{ $data->status}}" readonly>
                </div>
            </div>   
        </div>

        <!-- content -->

        @php
        $data = json_encode($template->details , TRUE);
       @endphp
      
     
      
       <div class="row" >
            <div class="col-8">
              <div class="card text-white bg-white border border-primary" >
                <div class="card-header text-muted text-black" style="background-color: white">Ujjivan </div>

                @foreach($arr as $keys=>$values)
                   <!-- <label style="color: black">{{ $values->coloum }}</label> -->
                   @php
                     $data = explode(',',$values->coloum);
                   @endphp
                   
                   
                   @if(sizeof($data) == 1)
                    @foreach($data as $key1=>$views)
                     @php
                      $rowval = $keys+1;
                      $colval = $key1+1;
                      $cVal = 'c'.$rowval.$colval;
                     @endphp 
                       
                       @if($views == 'textarea')

                         <textarea  class="form-control div-margin"  name="row{{$keys+1}}_{{$key1+1}}" id="textarea" input="textAreaAdjust(this)" id="cval" style="height:200px" readonly >{{$content->$cVal}}</textarea>
                     
                        <!--  <div class="textareaElement form-control div-margin" contenteditable name="row{{$keys+1}}_{{$key1+1}}">{{$content->$cVal}}</div> -->
                         @elseif($views == 'table')
                          <table class="table table-bordered div-margin" style="height: 200px">
                            <tr >
                              <th>Sl.No</th>
                              <th>Transaction / Service</th>
                              <th>Time Taken</th>
                            </tr>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>Cash payment at cash counters</td>
                                <td>Within 15 Minutes</td>
                              </tr>

                              <tr>
                                <td>2</td>
                                <td>Receipt of cash at cash counters</td>
                                <td>Within 15 Minutes</td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>Issuance of statement across counter </td>
                                <td>Within 15 Minutes</td>
                              </tr>

                              <tr>
                                <td>4</td>
                                <td>Updating of pass books</td>
                                <td>Within 15 Minutes</td>
                              </tr>
                              <tr>
                                <td>5</td>
                                <td>Issuance of demand draft / fixed deposit advice</td>
                                <td>Within 30 Minutes</td>
                              </tr>

                              <tr>
                                <td>6</td>
                                <td>Payment of fixed deposits</td>
                                <td>Within 30 Minutes</td>
                              </tr>
                               <tr>
                                <td>7</td>
                                <td>Collection of cheques (local) </td>
                                <td>Within 4 Days</td>
                              </tr>

                              <tr>
                                <td>8</td>
                                <td>Issuance of statement by post</td>
                                <td>7 days</td>
                              </tr>
                            </tbody>
                          </table>
                       
                       @else
                         <img class="card-img-top div-margin" src="..." style="height: 200px;display: block;margin-left:auto;margin-right: auto " name="row{{$keys+1}}_{{$key1+1}}">

                       @endif

                   @endforeach
                    
                   @elseif(sizeof($data) == 2)
                   
                    <div class="row div-margin">
                       @foreach($data as $key2=>$views2)
                       @php
                        $rowval = $keys+1;
                        $colval = $key2+1;
                        $cVal = 'c'.$rowval.$colval;
                       @endphp

                      <div class="col-md-6">
                        @if($views2 == 'textarea')
                        <textarea class="form-control" style="height: 200px;text-align: left" name="row{{$keys+1}}_{{$key2+1}}" readonly>{{$content->$cVal}}</textarea>
                        @elseif($views2 == 'table')
                          <table class="table table-bordered div-margin" style="height: 200px">
                            <tr >
                              <td colspan="4">Fixed Deposit</td>
                             
                            </tr>
                            <tr >
                              <th>Tenure</th>
                              <th>Interest Rate(p.a)</th>
                            
                            </tr>
                            <tbody>
                              <tr>
                                <td>7 Days to 29 Days</td>
                                <td>3.75%</td>
                              </tr>

                              <tr>
                                <td>30 Days to 89 Days</td>
                                <td>4.25%</td>
                              </tr>

                              <tr>
                                <td>90 Days to 179 Days</td>
                                <td>4.75%</td>
                              </tr>


                             <tr>
                                <td>6 Momths to 9 Months</td>
                                <td>6.50%</td>
                              </tr>

                              <tr>
                                <td>12 Months</td>
                                <td>8.25%</td>
                              </tr>
                            </tbody>
                          </table>
                        @else
                        <img class="card-img-top" src="..." style="height: 200px;display: block;margin-left:auto;margin-right: auto " name="row{{$keys+1}}_{{$key2+1}}">
                        @endif
                      </div>
                       @endforeach
                      
                      
                    </div>

                   
                   @else
                   
                    <div class="row div-margin">
                       @foreach($data as $key3=>$views3)
                       @php
                        $rowval = $keys+1;
                        $colval = $key3+1;
                        $cVal = 'c'.$rowval.$colval;
                       @endphp

                      <div class="col-md-4">
                        @if($views3 == 'textarea')
                        <textarea class="form-control" style="height: 200px" name="row{{$keys+1}}_{{$key3+1}}" readonly>{{$content->$cVal}}</textarea>
                        @elseif($views3 == 'table')
                          <table class="table table-bordered div-margin" style="height: 200px">
                            <tr >
                              <th>Sl.No</th>
                              <th>Transaction / Service</th>
                              <th>Time Taken</th>
                            </tr>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>Cash payment at cash counters</td>
                                <td>Within 15 Minutes</td>
                              </tr>

                              <tr>
                                <td>2</td>
                                <td>Receipt of cash at cash counters</td>
                                <td>Within 15 Minutes</td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>Issuance of statement across counter </td>
                                <td>Within 15 Minutes</td>
                              </tr>

                              <tr>
                                <td>4</td>
                                <td>Updating of pass books</td>
                                <td>Within 15 Minutes</td>
                              </tr>
                              <tr>
                                <td>5</td>
                                <td>Issuance of demand draft / fixed deposit advice</td>
                                <td>Within 30 Minutes</td>
                              </tr>

                              <tr>
                                <td>6</td>
                                <td>Payment of fixed deposits</td>
                                <td>Within 30 Minutes</td>
                              </tr>
                               <tr>
                                <td>7</td>
                                <td>Collection of cheques (local) </td>
                                <td>Within 4 Days</td>
                              </tr>

                              <tr>
                                <td>8</td>
                                <td>Issuance of statement by post</td>
                                <td>7 days</td>
                              </tr>
                            </tbody>
                          </table>
                        @else
                       <img class="card-img-top" src="..." style="height: 200px;width:200px;display: block;margin-left:auto;margin-right: auto " name="row{{$keys+1}}_{{$key3+1}}">
                        @endif
                      </div>
                       @endforeach
                      
                      
                    </div>

                   @endif
                  
                   
                  

                @endforeach

               
                <div class="card-footer text-muted text-black bg-white">Powered By : ujjivan.com </div>
              </div>
            </div>
       </div>


       <!-- content -->


     </form>
    </div>    
    
</div>

<script type="text/javascript">
  var mode = document.getElementById("pan").value;
  //$('#region_list').prop('disabled', true);
 // $('#region_prompt').prop('disabled', true);
  //$('#state_prompt').prop('disabled', true);

   $('select').on('change', function() {
     
       if(this.value == "No"){
          
           $('#region_prompt').prop('disabled', false);
           document.getElementById("region_prompt").required = true;
       }

       if(this.value == "Yes"){
          
           $('#region_prompt').prop('disabled', true);
           document.getElementById("region_prompt").required = false;

           $('#state_prompt').prop('disabled', true);
           document.getElementById("state_prompt").required = false;
 
       }

       if(this.value == "1"){
           $('#region_list').prop('disabled', false);
           document.getElementById("region_list").required = true;

           $('#state_prompt').prop('disabled', true);
           document.getElementById("state_prompt").required = false;
       }

       if(this.value == "0"){
           $('#region_list').prop('disabled', true);
           document.getElementById("region_list").required = false;

           $('#state_prompt').prop('disabled', false);
           document.getElementById("state_prompt").required = true;
       }

       if(this.value == "ya"){
           $('#state_list').prop('disabled', false);
           document.getElementById("state_list").required = true;

          
       }



  });

</script>



@endsection