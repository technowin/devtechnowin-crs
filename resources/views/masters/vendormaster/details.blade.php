@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')


    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Details Vendor </h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>
            <BR>
            <div class="container">


                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Vendor Code </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$vendor->vendorcode}}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Vendor Name </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$vendor->vendorname}}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Vendor Phone No </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$vendor->vendorphoneno}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Vendor Email </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$vendor->vendoremail}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Vendor Fax </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$vendor->vendorfax}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Vendor Website </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$vendor->vendorwebsite}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Contact Person No </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$vendor->contactpersonno}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Contact Person Email </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$vendor->contactpersonemail}}</div>
                </div>


                <br>



            </div>

        </div>
    </div>

@endsection
	