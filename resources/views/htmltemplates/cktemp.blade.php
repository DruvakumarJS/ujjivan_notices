@extends('layouts.temp')

@section('content')

<style type="text/css">
  /*body {
    background-image: url('/uconnect-logo.png');
    background-repeat: no-repeat;
    background-position: center;
    background-size: 250px 250px; 
    opacity: 0.9; 
    background-attachment: fixed;
}*/
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

        @php
        $data = json_encode($template->details , TRUE);
       @endphp
     
       <div class="row">
            <div style="width: 950px">
              <div class="card text-black bg-white border border-white" style="padding: 0px 20px 20px 20px;">
               <div class="card-header text-muted text-black" style="background-color: white; border: none; display: flex; align-items: center;height: 80px;border-radius: 0;">
                  <div style="height: 30px; margin-right: auto;">
                      {!! QrCode::size(50)->generate($qrcode_data) !!}
                  </div>

                  <div style="height: 30px; margin-left: auto;">
                      <img src="{{ url('/') }}/images/mainLogo.svg" style="height: 30px;">
                  </div>
                  
              </div>

               <div id="test">
                 
              
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

                         <div class="ck-content"  id="test_{{$keys}}_{{$key1}}" dir="<?php echo ($lang_code == 'ar')?'rtl':'ltr' ?>">{!! $content->$cVal !!}</div>
                     
                         @elseif($views == 'table')
                         <!-- <textarea>{!! $content->$cVal !!}</textarea> -->
                         <div class="ck-content" id="test_{{$keys}}_{{$key1}}" dir="<?php echo ($lang_code == 'ar')?'rtl':'ltr' ?>">{!! $content->$cVal !!}</div>
                       
                       @else
                         
                         <div class="ck-content" id="test_{{$keys}}_{{$key1}}" dir="<?php echo ($lang_code == 'ar')?'rtl':'ltr' ?>">{!! $content->$cVal !!}</div>

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
                       <div class="ck-content" id="test_{{$keys}}_{{$key2}}">{!! $content->$cVal !!}</div>
                        @elseif($views2 == 'table')
                          <div class="ck-content" id="test_{{$keys}}_{{$key2}}">{!! $content->$cVal !!}</div>
                        @else
                       <div class="ck-content" id="test_{{$keys}}_{{$key2}}">{!! $content->$cVal !!}</div>
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
                        <!-- <textarea class="form-control" style="height: 200px" name="row{{$keys+1}}_{{$key3+1}}" readonly>{{$content->$cVal}}</textarea> -->
                       <div class="ck-content" id="test_{{$keys}}_{{$key3}}">{!! $content->$cVal !!}</div>
                        
                        @elseif($views3 == 'table')
                          <div class="ck-content" id="test_{{$keys}}_{{$key3}}">{!! $content->$cVal !!}</div>
                        @else
                       <div class="ck-content" id="test_{{$keys}}_{{$key3}}">{!! $content->$cVal !!}</div>
                        @endif
                      </div>
                       @endforeach
                      
                      
                    </div>

                   @endif
                  
                @endforeach
               
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