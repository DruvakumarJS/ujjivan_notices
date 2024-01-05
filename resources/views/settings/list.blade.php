@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm border border-primary">
                <div class="card-header bg-primary text-white"><label style="font-weight: bolder;">Region</label> </div>

                <div class="card-body">
                   <label>Total No. of Regions</label>
                   <div class="justify-content-center">
                       <label class="label-bold curved-text"></label>
                   </div>
                   <label class="label-bold curved-text">{{$region}}</label>
                   <a href="{{ route('regions')}}" class="btn btn-secondary" style="float: right">View More</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border border-primary">
                <div class="card-header bg-primary text-white"><label style="font-weight: bolder;">Branches</label></div>

                <div class="card-body">
                   <label>Total No. of Branches</label>
                   <div class="justify-content-center">
                       <label class="label-bold curved-text"></label>
                   </div>
                   <label class="label-bold curved-text">{{$branch}}</label>
                   <a href="{{ route('branches')}}" class="btn btn-secondary" style="float: right">View More</a>
                </div>
            </div>
        </div>

       <!--  <div class="col-md-3">
            <div class="card shadow-sm border border-primary">
                <div class="card-header bg-primary text-white"><label style="font-weight: bolder;">Banks</label></div>

                <div class="card-body">
                   <label>Total No. of Banks</label>
                   <div class="justify-content-center">
                       <label class="label-bold curved-text"></label>
                   </div>
                   <label class="label-bold curved-text">{{$bank}}</label>
                   <a href="{{ route('banks')}}" class="btn btn-secondary" style="float: right">View More</a>
                </div>
            </div>
        </div> -->

        

        
    </div>
</div>
@endsection
