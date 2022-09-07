@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')


    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Details Sector </h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>
            <BR>
            <div class="container">
                {{ Form::model($sectors, array('route' => array('sectors.update', $sectors->sectorcode), 'method' => 'PUT')) }}

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Sector Code </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$sectors->sectorcode}}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Sector Name </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$sectors->sectorname}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Sector Description </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$sectors->sectordescription}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Is Active </div>
                    @if ($sectors->isactive=='1')
                        <div class="col-md-4 ol-form-label text-muted">: Yes</div>
                    @endif

                    @if ($sectors->isactive=='0')
                        <div class="col-md-4 ol-form-label text-muted">: No}</div>
                    @endif
                </div>
  <br>

                {{ Form::close() }}

            </div>

        </div>
    </div>


    {{--<div class="card">--}}
        {{--<h3 class="card-header">Sector Details</h3>--}}
        {{--<div class="card-block">--}}
            {{--<div class="row">--}}
                {{--<div class="col-2">--}}
                    {{--<h6 class="card-title">Sector Code</h6>--}}
                {{--</div>--}}

                {{--<div class="col-4">--}}
                    {{--<h6 class="card-title"> : {{$sectors->sectorcode}}</h6>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="row">--}}
                {{--<div class="col-2">--}}
                    {{--<h6 class="card-title">Sector Name</h6>--}}
                {{--</div>--}}

                {{--<div class="col-4">--}}
                    {{--<h6 class="card-title"> : {{$sectors->sectorname}}</h6>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="row">--}}
                {{--<div class="col-2">--}}
                    {{--<h6 class="card-title">Sector Description</h6>--}}
                {{--</div>--}}

                {{--<div class="col-4">--}}
                    {{--<h6 class="card-title"> : {{$sectors->sectordescription}}</h6>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="row">--}}
                {{--<div class="col-2">--}}
                    {{--<h6 class="card-title">Is Active</h6>--}}
                {{--</div>--}}

                {{--<div class="col-4">--}}
                    {{--@if ($sectors->isactive=='1')--}}
                            {{--<h6 class="card-title"> : Yes</h6>--}}
                    {{--@endif--}}

                    {{--@if ($sectors->isactive=='0')--}}
                        {{--<h6 class="card-title"> : No</h6>--}}
                    {{--@endif--}}


                {{--</div>--}}
            {{--</div>--}}




        {{--</div>--}}
    {{--</div>--}}



@endsection
	