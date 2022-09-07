@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')


    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Details Department </h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>
            <BR>
            <div class="container">

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Department  Code </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$departmentmasters->departmentcode }}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Sector Name </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$departmentmasters->sectorcode}}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Department Name </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$departmentmasters->departmentname}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Department Description </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$departmentmasters->departmentdescription}}</div>
                </div>

                <br>



            </div>

        </div>
    </div>

    {{--<div class="card">--}}
        {{--<h3 class="card-header">Department Details</h3>--}}
        {{--<div class="card-block">--}}

            {{--<div class="row">--}}
                {{--<div class="col-2">--}}
                    {{--<h6 class="card-title">Department Code</h6>--}}
                {{--</div>--}}

                {{--<div class="col-4">--}}
                    {{--<h6 class="card-title"> : {{$departmentmasters->departmentcode}}</h6>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="row">--}}
                {{--<div class="col-2">--}}
                    {{--<h6 class="card-title">Sector Name</h6>--}}
                {{--</div>--}}

                {{--<div class="col-4">--}}
                    {{--<h6 class="card-title"> : {{$departmentmasters->sectorcode}}</h6>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="row">--}}
                {{--<div class="col-2">--}}
                    {{--<h6 class="card-title">Department Name</h6>--}}
                {{--</div>--}}

                {{--<div class="col-4">--}}
                    {{--<h6 class="card-title"> : {{$departmentmasters->departmentname}}</h6>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="row">--}}
                {{--<div class="col-2">--}}
                    {{--<h6 class="card-title">Department Description</h6>--}}
                {{--</div>--}}

                {{--<div class="col-4">--}}
                    {{--<h6 class="card-title"> : {{$departmentmasters->departmentdescription}}</h6>--}}
                {{--</div>--}}
            {{--</div>--}}

        {{--</div>--}}
    {{--</div>--}}

@endsection
	