@extends('layouts.appnew')

@section('page-title', '| Branch Master')

@section('content')

    <div type="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Details Branch Contact</h3>
            </div>
            <div class="panel-body">
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Workorder Mo</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branches->workorderno }}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Customer Name</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branches->customercode }}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Branch Code</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branches->branchcode }}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Branch Person Name</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branches->branchname }}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Fax</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branches->fax}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Phone</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branches->phone}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Email</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branches->email}}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Created at</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branches->created_at}}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Updated at</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$branches->updated_at}}</div>
                </div>
            </div>
        </div>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>


@endsection