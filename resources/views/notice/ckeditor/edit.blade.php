@extends('layouts.app')

@section('content')
<style type="text/css">
  #myFileInput {
    display:none;
}
#over img,output {
  margin-left: auto;
  margin-right: auto;
  display: block;
  height: 200px;
  width: auto;
  align-items: center;
}
#over2 img,output {
  margin-left: auto;
  margin-right: auto;
  display: block;
  width: 80%;
  max-height: 200px;
  align-items: center;
}

#over3 img,output {
  margin-left: auto;
  margin-right: auto;
  display: block;
  width: 100%;
  max-height: 200px;
  align-items: center;

}

</style>

<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>


<div class="container-body">
  <label class="label-bold">Edit Notice</label>
    <div class="container-header">
        
    </div>

    <div class="page-container">
       <hr/>
      
       <form method="POST" action="{{ route('save_notice')}}">
        @csrf

        <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Notice Tittle * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">
                 <input class="form-control" type="text" name="tittle" value="{{$data->name}}" required>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Notice Description * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">
                 <input class="form-control" type="text" name="description" value="{{$data->description}}" required>
                </div>
            </div>   
       </div>

       <div class="row">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Is PAN India Notice ? * </span>
                  </div>
            </div> 
            <div class="col-6">
                <div class="input-group mb-3">
                 <select class="form-control form-select" name="is_pan_india" id="pan" required>
                  <option value="">Select</option>
                  <option <?php echo($data->is_pan_india == 'Yes')?'selected':'' ?> value="Yes">Yes</option>
                  <option <?php echo($data->is_pan_india == 'No')?'selected':'' ?> value="No">No</option>
                 </select>
                </div>
            </div>   
       </div>

       <div class="row" >
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Is Region Wise Notice ? * </span>
                  </div>
            </div> 
            <div class="col-6" >
                <div class="input-group mb-3" id="region_dropdown">
                 <select class="form-control form-select" name="is_region_wise" id="region_prompt" >
                  <option value="">Select</option>
                  <option <?php echo($data->is_region_wise == '1')?'selected':'' ?> value="1">Yes</option>
                  <option <?php echo($data->is_region_wise == '0')?'selected':'' ?> value="0">No</option>
                 </select>
                </div>
            </div>   
       </div>

       <div class="row" id="region_dropdown_list" id="region_div">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Select Regions  </span>
                  </div>
            </div> 
          <div class="col-6">
             <div class="input-group mb-3">
             <select class="form-control selectpicker" multiple name="regions[]" id="region_list" >
               @php $region_list = explode(',',$data->regions); @endphp
                <option <?php echo(in_array('East',$region_list))?'selected':''  ?> value="East">East</option>
                <option <?php echo(in_array('West',$region_list))?'selected':''  ?> value="West">West</option>
                <option <?php echo(in_array('North',$region_list))?'selected':''  ?> value="North">north</option>
                <option <?php echo(in_array('South',$region_list))?'selected':''  ?> value="South">south</option>
              </select>

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
                 <select class="form-control form-select" name="is_state_wise" id="state_prompt" >
                  <option value="">Select</option>
                  <option <?php echo($data->is_state_wise == 'ya')?'selected':'' ?> value="ya">Yes</option>
                  <option <?php echo($data->is_state_wise == 'na')?'selected':'' ?> value="na">No</option>
                 </select>
                </div>
            </div>   
       </div>

        <div class="row" id="state_dropdown_list">
            <div class="col-2">
                  <div class="text-sm-end" >
                    <span class="" id="basic-addon3">Select States  </span>
                  </div>
            </div> 
          <div class="col-6">
             <div class="input-group mb-3">
             <select class="form-control selectpicker" multiple search="true" name="states[]" id="state_list" >
                
                @php $state_list = explode(',',$data->states); @endphp
                <option <?php echo(in_array('Karnataka',$state_list))?'selected':''  ?> value="Karnataka">Karnataka</option>
                <option <?php echo(in_array('Tamil Nadu',$state_list))?'selected':''  ?> value="Tamil Nadu">Tamil Nadu</option>
                <option <?php echo(in_array('Kerala',$state_list))?'selected':''  ?> value="Kerala">Kerala</option>
                <option <?php echo(in_array('Telangana',$state_list))?'selected':''  ?> value="Telangana">Telangana</option>
              </select>

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
             <select class="form-control selectpicker" multiple search="true" name="lang[]" required="" >
                @php $lang_list = explode(',',$data->available_languages); @endphp
                <option <?php echo(in_array('Kannada',$lang_list))?'selected':''  ?> value="Kannada">Kannada</option>
                <option <?php echo(in_array('English',$lang_list))?'selected':''  ?> value="English">English</option>
                <option <?php echo(in_array('Hindi',$lang_list))?'selected':''  ?> value="Hindi">Hindi</option>
                <option <?php echo(in_array('Urdu',$lang_list))?'selected':''  ?> value="Urdu">Urdu</option>
              </select>

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
                 <select class="form-control form-select" name="voice_over" required>
                  <option value="">Select</option>
                  <option <?php echo($data->voiceover == 'Y')?'selected':'' ?> value="Y">Yes</option>
                  <option <?php echo($data->voiceover == 'N')?'selected':'' ?> value="N">No</option>
                 </select>
                </div>
            </div>   
       </div>

       <!-- content -->

        @php
        $data = json_encode($template->details , TRUE);
       @endphp
      
     
      
       <div class="row" >
            <div class="col-8">
              <div class="card text-black bg-white border border-primary" >
                <div class="card-header text-muted text-black"  style="background-color: white"><img src="{{ url('/')}}/images/mainLogo.svg" style="height: 30px;float: right;"> </div>

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
                       <div class="div-margin">
                         <textarea class="form-control" id="content_{{$keys+1}}_{{$key1+1}}"  name="row{{$keys+1}}_{{$key1+1}}" >{{$content->$cVal}}</textarea>
                        <!--  <div class="textareaElement form-control div-margin" contenteditable name="row{{$keys+1}}_{{$key1+1}}"></div> -->
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
                         <!-- <img class="card-img-top div-margin" src="..." style="height: 200px;display: block;margin-left:auto;margin-right: auto " name="row{{$keys+1}}_{{$key1+1}}">
 -->

                          <div id="over" class="card-img-top div-margin" onclick="document.getElementById('myFileInput_{{$keys+1}}{{$key1+1}}').click()" value="Select a File" style="height: 200px;align-items: center;">

                           <input type="file" id="myFileInput_{{$keys+1}}{{$key1+1}}" name="row{{$keys+1}}_{{$key1+1}}" style="display: none" />
         
                           <img src="{{url('/')}}/noticeimages/{{$content->$cVal}}" id="placeholder_{{$keys+1}}_{{$key1+1}}">

                            <output id="result_{{$keys+1}}{{$key1+1}}" name="row{{$keys+1}}_{{$key1+1}}" />

                          </div>
                        </div>

                       
                       @endif

                       <script>
                          ClassicEditor.create( document.querySelector( '#content_{{$keys+1}}_{{$key1+1}}' ) )
                        .catch( error => {
                            console.error( error );
                        } );
                      </script>

                      <script type="text/javascript">
                        
                         var filesInput = document.getElementById('myFileInput_{{$keys+1}}{{$key1+1}}');
                          
                          filesInput.addEventListener('change', function(e) {
                           var imagesArray = [];
                            var output = document.getElementById('result_{{$keys+1}}{{$key1+1}}');
                             document.getElementById('placeholder_{{$keys+1}}_{{$key1+1}}').style.display= "none" ;
                            var files = e.target.files; //FileList object
                            
                            for (var i = 0; i < files.length; i++) {
                              var currFile = files[i];
                           // alert(files[i]);
                             imagesArray.push(files[i]);

                              displayImages();
                       
                            }

                             function displayImages() {
                              
                              let images = ""
                              imagesArray.forEach((image, index) => {
                           
                                images += `<div class="image">
                                      <img  src="${URL.createObjectURL(image)}" alt="image">
                                      
                                    </div>` 
                                 })
                               
                              output.innerHTML = images

                             }

                          });
                      </script>

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
                        <textarea class="form-control div-margin" id="content_{{$keys+1}}_{{$key2+1}}"  name="row{{$keys+1}}_{{$key2+1}}" >{{$content->$cVal}}</textarea>
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
                        <!-- <img class="card-img-top" src="..." style="height: 200px;display: block;margin-left:auto;margin-right: auto " name="row{{$keys+1}}_{{$key2+1}}"> -->

                         <div id="over2" class="card-img-top div-margin" onclick="document.getElementById('myFileInput_{{$keys+1}}{{$key2+1}}').click()" value="Select a File" style="height: 200px;align-items: center;">

                           <input type="file" id="myFileInput_{{$keys+1}}{{$key2+1}}" name="row{{$keys+1}}_{{$key2+1}}" style="display: none" />
         
                          <img src="{{url('/')}}/noticeimages/{{$content->$cVal}}" id="placeholder_{{$keys+1}}_{{$key2+1}}">

                            <output id="result_{{$keys+1}}{{$key2+1}}" name="row{{$keys+1}}_{{$key2+1}}"/>

                         </div>
                         
                         </div>
        
                      
                        @endif
                      </div>

                      <script>
                          ClassicEditor.create( document.querySelector( '#content_{{$keys+1}}_{{$key2+1}}' ) )
                        .catch( error => {
                            console.error( error );
                        } );

                      </script>
                      <style type="text/css">
                        .ck-editor__editable {
                            min-height: 200px;
                             max-height: 200px;
                          }
                      </style>

                      <script type="text/javascript">
                       
                         var filesInput2 = document.getElementById('myFileInput_{{$keys+1}}{{$key2+1}}');
                          
                          filesInput2.addEventListener('change', function(e) {
                            var imagesArray2 = [];
                            var output2 = document.getElementById('result_{{$keys+1}}{{$key2+1}}');
                             document.getElementById('placeholder_{{$keys+1}}_{{$key2+1}}').style.display= "none" ;
                            var files2 = e.target.files; //FileList object
                            
                            for (var i = 0; i < files2.length; i++) {
                              var currFile = files2[i];
                           
                             imagesArray2.push(files2[i]);

                              displayImages2();
                       
                            }

                             function displayImages2() {

                              let images = ""
                              imagesArray2.forEach((image, index) => {
                           
                                images += `<div class="image">
                                      <img  src="${URL.createObjectURL(image)}" alt="image">
                                      
                                    </div>` 
                                 })
                               
                              output2.innerHTML = images

                             }

                          });
                      </script>

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
                      <div class="col-md-4 div-margin">
                        @if($views3 == 'textarea')
                        <textarea class="form-control div-margin" id="content_{{$keys+1}}_{{$key3+1}}"  name="row{{$keys+1}}_{{$key3+1}}" style="height: 200px">{{$content->$cVal}}</textarea>
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
                       <!-- <img class="card-img-top" src="..." style="height: 200px;width:200px;display: block;margin-left:auto;margin-right: auto " name="row{{$keys+1}}_{{$key3+1}}"> -->

                       <div id="over3" class="card-img-top div-margin" onclick="document.getElementById('myFileInput_{{$keys+1}}{{$key3+1}}').click()" value="Select a File" style="height: 200px;align-items: center;">

                           <input type="file" id="myFileInput_{{$keys+1}}{{$key3+1}}" name="row{{$keys+1}}_{{$key3+1}}" style="display: none" />
         
                           <img src="{{url('/')}}/noticeimages/{{$content->$cVal}}" id="placeholder_{{$keys+1}}_{{$key3+1}}">

                            <output id="result_{{$keys+1}}{{$key3+1}}" name="row{{$keys+1}}_{{$key3+1}}"/>

                         </div>

                        @endif
                      </div>

                      <script>
                          ClassicEditor.create( document.querySelector( '#content_{{$keys+1}}_{{$key3+1}}' ) )
                        .catch( error => {
                            console.error( error );
                        } );
                      </script>

                      <script type="text/javascript">
                        
                         var filesInput3 = document.getElementById('myFileInput_{{$keys+1}}{{$key3+1}}');
                          
                          filesInput3.addEventListener('change', function(e) {
                           var imagesArray3 = [];
                            var output3 = document.getElementById('result_{{$keys+1}}{{$key3+1}}');
                             document.getElementById('placeholder_{{$keys+1}}_{{$key3+1}}').style.display= "none" ;
                            var files3 = e.target.files; //FileList object
                            
                            for (var i = 0; i < files3.length; i++) {
                              var currFile = files3[i];
                           
                             imagesArray3.push(files3[i]);

                              displayImages3();
                       
                            }

                             function displayImages3() {

                              let images = ""
                              imagesArray3.forEach((image, index) => {
                           
                                images += `<div class="image">
                                      <img  src="${URL.createObjectURL(image)}" alt="image">
                                      
                                    </div>` 
                                 })
                               
                              output3.innerHTML = images

                             }

                          });
                      </script>
                       @endforeach
                      
                      
                    </div>

                   @endif
                  
                  
                   
                  

                @endforeach

               
                <div class="card-footer text-muted text-black bg-white">
                  <label style="color: black">Version 1</label>
                  <div id="div3">
                    <label  style="color: black">{{date('d M Y')}}</label>
                  </div>
                </div>

              </div>
            </div>
       </div>


       <!-- content -->

    
       
       <div id="div3" class="div-margin">
         <button class="btn btn-success" type="submit">Submit</button> 
       </div>

     </form>
    </div>    
    
</div>

<script type="text/javascript">
 
  //$('#region_list').prop('disabled', true);
  //$('#region_prompt').prop('disabled', true);
 // $('#state_prompt').prop('disabled', true);

  var pan = document.getElementById('pan').value;
  var region = document.getElementById('region_prompt').value;
  //alert(region);

    if(pan == 'Yes'){
     
         $('#region_prompt').prop('disabled', true);
         document.getElementById("region_prompt").required = false;

         $('#state_prompt').prop('disabled', true);
         document.getElementById("state_prompt").required = false;
    }

    else if(pan == 'No'){
      $('#region_prompt').prop('disabled', false);
         document.getElementById("region_prompt").required = true;

    }

    else if(region == 1){
     // alert(region);
         
         $('#state_prompt').prop('disabled', true);
         document.getElementById("state_prompt").required = false;
    }
    else if(region == '0'){
      alert('ll');
        $('#state_prompt').prop('disabled', false);
         document.getElementById("state_prompt").required = true;
    }



   $('select').on('change', function() {
    //alert(this.value);
     
       if(this.value == "No"){
          
           $('#region_prompt').prop('disabled', false);
           document.getElementById("region_prompt").required = true;
       }

       if(this.value == "Yes"){
          
           $("#region_prompt").val("0");
           $("#state_prompt").val("na");

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

   function auto_grow(element) {
  element.style.height = "250px";
  element.style.height = (element.scrollHeight) + "px";
}
 
</script>




@endsection