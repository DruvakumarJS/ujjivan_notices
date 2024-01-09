<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Summernote Text Editor CRUD and Image Upload in Laravel</title>
  <!-- bootstrap -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
  
    
    <div class="page-container">
       <hr/>
      
       <form method="POST" action="{{ route('save_notice')}}">
        @csrf

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
                          <div id="editor"></div>
                          <div id="displayTableData"></div>

                         <script>
                            ClassicEditor
                                .create(document.querySelector('#editor'))
                                .then(editor => {
                                    editor.model.document.on('change', () => {
                                        const tableData = editor.getData();
                                        
                                        // Create a figure tag dynamically
                                        const figureElement = document.createElement('figure');
                                        figureElement.innerHTML = tableData;

                                        // Append the figure tag to the specified div
                                        document.querySelector('#displayFigure').innerHTML = ''; // Clear previous content
                                        document.querySelector('#displayFigure').appendChild(figureElement);
                                    });
                                })
                                .catch(error => {
                                    console.error(error);
                                });
                        </script>


    <script>
        // Set initial content if data is available
        document.querySelector('#editor').innerHTML = `{!! $content->$cVal !!}`;
    </script>

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
</body>
</html>
