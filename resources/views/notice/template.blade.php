@extends('layouts.app')

@section('content')
<style type="text/css">
	.table-condensed{
  font-size: 10px;
}

tr {
   line-height: 10px;
   min-height: 10px;
   height: 10px;
}
</style>

<div class="container-body">
	<label class="label-bold">Templates</label>
	<div class="container-header">
		
	</div>

	<div class="page-container">

		<div class="row">
			@foreach($data as $key=>$value)
				<div class="col-md-2">
				  <div class="card border border-primary" style="height: 400px">
				  	<span>{{ $value->name}}</span>

				  	@php
                     $details = $value->details ;
                     $arr = json_decode($details);
				  	@endphp

				  	@foreach($arr as $keys=>$values)
                   <!-- <label style="color: black">{{ $values->coloum }}</label> -->
                   @php
                     $data = explode(',',$values->coloum);
                   @endphp
                   
                   
                   @if(sizeof($data) == 1)
                    @foreach($data as $views)
                       
                       @if($views == 'textarea')
                         <!-- <textarea class="form-control div-margin" style="height: 250px"></textarea> -->
                         <div class="textareaElement form-control div-margin" contenteditable></div>
                          @elseif($views == 'table')
                          <input type="button"class="btn btn-dark div-margin" value="Table">

                       @else
                         <img class="div-margin" src="{{ url('/')}}/placeholder.jpg" style="height: 50px;display: block;margin-left:auto;margin-right: auto ">
                       @endif

                   @endforeach
                    
                   @elseif(sizeof($data) == 2)
                   
                    <div class="row div-margin">
                       @foreach($data as $views2)
                      <div class="col-md-6">
                        @if($views2 == 'textarea')
                        <textarea class="form-control" style="height: 50px"></textarea>
                        @elseif($views2 == 'table')
                          <input type="button"class="btn btn-dark " value="Table">

                        @else
                        <img src="{{ url('/')}}/placeholder.jpg" style="height: 50px;display: block;margin-left:auto;margin-right: auto ">
                        @endif
                      </div>
                       @endforeach
                      
                      
                    </div>

                   
                   @else
                   
                    <div class="row div-margin">
                       @foreach($data as $views3)
                      <div class="col-md-4">
                        @if($views3 == 'textarea')
                        <textarea class="form-control" style="height: 50px"></textarea>
                        @elseif($views3 == 'table')
                          <input type="button"class="btn btn-dark " value="Table">

                        @else
                       <img  src="{{ url('/')}}/placeholder.jpg" style="height: 50px;width:40px;display: block;margin-left:auto;margin-right: auto ">
                        @endif
                      </div>
                       @endforeach
                      
                      
                    </div>

                   @endif
                  
                   
                  

                @endforeach
				  </div>
				</div>
			@endforeach
			
		</div>
		
		<!-- <div class="row" >
			<div class="col-md-2">
				<div class="card border border-primary" style="height: 300px" >
					<span>Template 1</span>
					<textarea class="form-control h-100" placeholder="Enter text here"></textarea>

				</div>
			</div>

			<div class="col-md-2">
				<div class="card border border-primary" style="height: 300px">
					<span>Template 2</span>
					<textarea class="form-control" style="height: 80px"></textarea>
					<span style="height: 50px">img</span>
					<textarea class="form-control" style="height: 90px"></textarea>
				
				</div>
			</div>

			<div class="col-md-2">
				<div class="card border border-primary" style="height: 300px">
					<span>Template 3</span>
					<textarea class="form-control" style="height: 90px"></textarea>
					<div class="row " style="height: 50px">
						<div class="col-md-4" >
							<span>img</span>
						</div>

						<div class="col-md-4">
							<span>img</span>
						</div>

						<div class="col-md-4">
							<span>img</span>
						</div>

					</div>

					<textarea class="form-control" style="height: 90px"></textarea>
					
				</div>
			</div>

			<div class="col-md-2">
				<div class="card border border-primary" style="height: 300px">
					<span>Template 4</span>
					<textarea class="form-control" style="height: 90px"></textarea>
					<div class="row " >
						<div class="col-md-4" >
							<span style="height: 50px">img</span>
						</div>

						<div class="col-md-8" >
							<textarea class="form-control" style="height: 50px"></textarea>
						</div>

						

					</div>

					<textarea class="form-control" style="height: 90px"></textarea>
					
				</div>
			</div>

			<div class="col-md-2">
				<div class="card border border-primary" style="height: 300px">
					<span>Template 5</span>
					<textarea class="form-control" style="height: 90px"></textarea>
					<div class="row " >
						<div class="col-md-8" >
							<textarea class="form-control" style="height: 50px"></textarea>
						</div>

						<div class="col-md-4" >
							<span style="height: 50px">img</span>
						</div>
					</div>

					<textarea class="form-control" style="height: 90px"></textarea>
					
				</div>
			</div>

			<div class="col-md-2">
				<div class="card border border-primary" style="height: 300px">
					<span>Template 6</span>
					<textarea class="form-control" style="height: 90px"></textarea>
					<div class="row">
						<div class="col-md-4" >
							<textarea class="form-control" style="height: 50px"></textarea>
						</div>

						<div class="col-md-4" >
							<span style="height: 50px">img</span>
						</div>

						<div class="col-md-4" >
							<textarea class="form-control" style="height: 50px"></textarea>
						</div>

					</div>

					<textarea class="form-control" style="height: 90px"></textarea>
					
				</div>
			</div>
		</div>
	</div> -->
	
</div>

@endsection