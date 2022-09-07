@extends('layouts.appnew')

@section('page-title', '| Branch Contact Person')

@section('content')

    <div type="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Details Branch Contact</h3>
            </div>
            <div class="panel-body">
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Branch Contact Code </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branchcontactmasters->branchcontactcode }}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Branch Person Name </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branchcontactmasters->contactpersonname }}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Branch Name </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branchcontactmasters->branchcode }}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Fax </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branchcontactmasters->fax}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Phone </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branchcontactmasters->phone}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Email </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branchcontactmasters->emailid}}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Created at</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branchcontactmasters->created_at}}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Updated at</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branchcontactmasters->updated_at}}</div>
                </div>
            </div>
        </div>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>

@endsection