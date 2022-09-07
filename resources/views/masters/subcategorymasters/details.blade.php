@extends('layouts.appnew')

@section('page-title', '| Sub-Category')

@section('content')


    <div type="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Sub-Category Details</h3>
            </div>
            <div class="panel-body">

                {{--<div class="row col-md-12">--}}
                {{--<div for="input" class="col-sm-4 col-form-label text-muted">Sub Category Code</div>--}}
                {{--<div class="col-md-4 ol-form-label text-muted">: {{$subcategory->subcategorycode}}</div>--}}
                {{--</div>--}}


                {{--                @for($i=0; $i<$count; $i++)--}}
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Sub Category Name</div>
                    <div class="col-md-8 ol-form-label text-muted">: {{$subcategory->subcategoryname }}</div>
                </div>
                <br>


                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Sub Category Description</div>
                    <div class="col-md-8 ol-form-label text-muted">: {{$subcategory->subcategorydescription}}</div>
                </div>


                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Product Services</div>
                    <div class="col-md-8 ol-form-label text-muted">: {{ $subcategorys->productservicename or 'NA' }}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Category Name</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{ @is_null($subcategory->categorycode) ? '-' : $subcategory->categorycode }}</div>
                </div>


                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Is Active</div>
                    @if ($subcategory->isactive=='1')
                        <div class="col-md-4 ol-form-label text-muted">: Yes</div>
                    @endif
                    @if ($subcategory->isactive=='0')
                        <div class="col-md-4 ol-form-label text-muted">: No</div>
                    @endif
                </div>

                {{--<div class="row col-md-12">--}}
                {{--<div for="input" class="col-sm-4 col-form-label text-muted">Created at</div>--}}
                {{--<div class="col-md-4 ol-form-label text-muted">: {{$subcategory->created_at}}</div>--}}
                {{--</div>--}}
                {{----}}
                {{--<div class="row col-md-12">--}}
                {{--<div for="input" class="col-sm-4 col-form-label text-muted">Updated at</div>--}}
                {{--<div class="col-md-4 ol-form-label text-muted">: {{$subcategory->updated_at}}</div>--}}
                {{--</div>--}}
                {{--                @endfor--}}

            </div>
        </div>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>

@endsection
