@extends('layouts.appnew')

@section('page-title', '| Complaint Types')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Complaint Type Detail</h3>
            </div>
            <div class="panel-body">
                <div class="container">


                    <div class="row col-md-12">
                        <div for="input" class="col-sm-4 col-form-label text-muted">Complaint Code </div>
                        <div class="col-md-4 ol-form-label text-muted">: {{$complainttypemaster->complaintcode}}</div>
                    </div>
                    <div class="row col-md-12">
                        <div for="input" class="col-sm-4 col-form-label text-muted">Complaint Name </div>
                        <div class="col-md-4 ol-form-label text-muted">: {{$complainttypemaster->complaintname}}</div>
                    </div>

                    <div class="row col-md-12">
                        <div for="input" class="col-sm-4 col-form-label text-muted">Complaint Description</div>
                        <div class="col-md-4 ol-form-label text-muted">: {{$complainttypemaster->complaintdescription}}</div>
                    </div>

                    <div class="row col-md-12">
                        <div for="input" class="col-sm-4 col-form-label text-muted">Is Active </div>
                        @if ($complainttypemaster->isactive=='1')
                            <div class="col-md-4 ol-form-label text-muted">: Yes</div>
                        @endif

                        @if ($complainttypemaster->isactive=='0')
                            <div class="col-md-4 ol-form-label text-muted">: No}</div>
                        @endif
                    </div>
                    <br>



                </div>
            </div>
        </div>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>
@endsection