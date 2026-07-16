@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')



    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Details Complainee Department </h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>
            <BR>
            <div class="container">

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Complainee Department Code </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$complaineedepartment->complaineedepartmentmastercode }}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted"> Department Name </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$complaineedepartment->departmentcode }}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Product Service Name </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$complaineedepartment->productservicecode }}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Category Name </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$complaineedepartment->categorycode}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Sub Category Name</div>
                    <div class="col-md-8 ol-form-label text-muted">: {{$complaineedepartment->subcategorycode}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Max Days</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$complaineedepartment->maxdays}}</div>
                </div>


                <br>



            </div>

        </div>
    </div>



@endsection
	
	