@extends('layouts.appnew')

@section('page-title', '| Category Master')

@section('content')

    <div type="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> Category Details </h3>
            </div>
            <div class="panel-body">
                {{----}}
                {{--<div class="row col-md-12">--}}
                    {{--<div for="input" class="col-sm-4 col-form-label text-muted">Category Code</div>--}}
                    {{--<div class="col-md-4 ol-form-label text-muted">: {{$category->categorycode }}</div>--}}
                {{--</div>--}}

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Category Name</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$category->categoryname }}</div>
                </div>




                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Category Description</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$category->categorydescription}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Product Service Name</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$category->productservicecode }}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Is Active</div>
                    @if ($category->isactive=='1')
                        <div class="col-md-4 ol-form-label text-muted">: Yes</div>
                    @endif

                    @if ($category->isactive=='0')
                        <div class="col-md-4 ol-form-label text-muted">: No</div>
                    @endif
                </div>

                {{--<div class="row col-md-12">--}}
                    {{--<div for="input" class="col-sm-4 col-form-label text-muted">Created at</div>--}}
                    {{--<div class="col-md-4 ol-form-label text-muted">: {{$category->created_at}}</div>--}}
                {{--</div>--}}
                {{--<div class="row col-md-12">--}}
                    {{--<div for="input" class="col-sm-4 col-form-label text-muted">Updated at</div>--}}
                    {{--<div class="col-md-4 ol-form-label text-muted">: {{$category->updated_at}}</div>--}}
                {{--</div>--}}

            </div>
        </div>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>

@endsection
	