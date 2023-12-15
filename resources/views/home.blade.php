@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card shadow-sm border border-primary">
                <div class="card-header bg-primary text-white">Branches</div>

                <div class="card-body">
                   <label>Total No. of Branches</label>
                   <div class="justify-content-center">
                       <label class="label-bold curved-text">{{$branch}}</label>
                   </div>
                   
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border border-primary">
                <div class="card-header bg-primary text-white">Banks</div>

                <div class="card-body">
                    <label>Total No. of Banks</label>
                   <div class="justify-content-center">
                       <label class="label-bold curved-text">{{$bank}}</label>
                   </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border border-primary">
                <div class="card-header bg-primary text-white">Active Devices</div>

                <div class="card-body">
                    <label>Total Active devices</label>
                  <div class="justify-content-center">
                       <label class="label-bold curved-text">{{$active}}</label>
                   </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border border-primary" style="border-color: #088672">
                <div class="card-header bg-primary text-white">In-Active Devices</div>

                <div class="card-body">
                    <label>Total In-Active devices</label>
                  <div class="justify-content-center">
                       <label class="label-bold curved-text">{{$inactive}}</label>
                   </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-md-3">
            <div class="card shadow-sm border border-primary">
                <div class="card-header bg-primary text-white ">Under Maintainance Devices</div>

                <div class="card-body">
                    <label>Under-Maintainance Devices</label>
                   <div class="justify-content-center">
                       <label class="label-bold curved-text">{{$maintainace}}</label>
                   </div>
                </div>
            </div>  
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border border-primary">
                <div class="card-header bg-primary text-white ">Notices</div>

                <div class="card-body">
                    <label>Total No. of Notices</label>
                   <div class="justify-content-center">
                       <label class="label-bold curved-text">{{$notice}}</label>
                   </div>
                </div>
            </div>
        </div>

        
    </div>
</div>
@endsection
