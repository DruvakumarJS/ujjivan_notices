@extends('layouts.login')

@section('content')

<div class="container-body">
  
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
                         
                         <div class="textareaElement form-control div-margin" contenteditable name="row{{$keys+1}}_{{$key1+1}}">{{$content->$cVal}}</div>
                       
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
                        <textarea class="form-control" style="height: 200px" name="row{{$keys+1}}_{{$key2+1}}">
                          {{$content->$cVal}}
                        </textarea>
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
                        <textarea class="form-control" style="height: 200px" name="row{{$keys+1}}_{{$key3+1}}">
                          {{$content->$cVal}}
                        </textarea>
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

	
	
</div>

    
@endsection