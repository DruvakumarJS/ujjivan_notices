@extends('layouts.temp')

@section('content')

<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/super-build/ckeditor.js"></script>

<div class="container-body">
  
        <!-- content -->

        @php
        $data = json_encode($template->details , TRUE);
       @endphp
     
       <div class="row">
            <div style="width: 1000px">
              <div class="card text-black bg-white border border-white" >
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

                         <div class="ck-content" >{!! $content->$cVal !!}</div>
                     
                         @elseif($views == 'table')
                         <!-- <textarea>{!! $content->$cVal !!}</textarea> -->
                         <div class="ck-content">{!! $content->$cVal !!}</div>
                       
                       @else
                         
                         <div class="ck-content">{!! $content->$cVal !!}</div>

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
                       <div class="ck-content">{!! $content->$cVal !!}</div>
                        @elseif($views2 == 'table')
                          <div class="ck-content">{!! $content->$cVal !!}</div>
                        @else
                       <div class="ck-content">{!! $content->$cVal !!}</div>
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
                       <div class="ck-content">{!! $content->$cVal !!}</div>
                        
                        @elseif($views3 == 'table')
                          <div class="ck-content">{!! $content->$cVal !!}</div>
                        @else
                       <div class="ck-content">{!! $content->$cVal !!}</div>
                        @endif
                      </div>
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
     
       

  
  
</div>

    
@endsection