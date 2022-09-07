@extends('layouts.appnew')

@section('page-title', '| Add User')

@section('content')


    <div class="panel panel-default">
        <div class="panel-heading">Details Product Service</div>
        <div class="panel-body">


                {{--<div class="row col-md-12">--}}
                    {{--<div for="input" class="col-sm-4 col-form-label text-muted">Product Code </div>--}}
                    {{--<div class="col-md-4 ol-form-label text-muted">: {{$productservices->productservicecode}}</div>--}}
                {{--</div>--}}

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Product Service Name </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$productservices->productservicename}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Product Service Description </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$productservices->productservicedescription}}</div>
                </div>

            <div class="row col-md-12">
                <div for="input" class="col-sm-4 col-form-label text-muted">Sector Name </div>
                <div class="col-md-4 ol-form-label text-muted">: {{$productservices->sectorcode}}</div>
            </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Is Active </div>
                    @if ($productservices->isactive=='1')
                        <div class="col-md-4 ol-form-label text-muted">: Yes</div>
                    @endif

                    @if ($productservices->isactive=='0')
                        <div class="col-md-4 ol-form-label text-muted">: No</div>
                    @endif
                </div>

                {{--<div class="row col-md-12">--}}
                    {{--<div for="input" class="col-sm-4 col-form-label text-muted">Created at</div>--}}
                    {{--<div class="col-md-4 ol-form-label text-muted">: {{$productservices->created_at}}</div>--}}
                {{--</div>--}}
                {{--<div class="row col-md-12">--}}
                    {{--<div for="input" class="col-sm-4 col-form-label text-muted">Updated at</div>--}}
                    {{--<div class="col-md-4 ol-form-label text-muted">: {{$productservices->updated_at}}</div>--}}
                {{--</div>--}}

            <br>


        </div>

    </div>
    <a class="btn btn-default" href="{{url()->previous()}}">Back</a>


@endsection
	