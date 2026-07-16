@extends('layouts.appnew')

@section('page-title', '| Assignee Details')

@section('content')

    <div type="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Details Service </h3>
            </div>
            <div class="panel-body">

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Contract No </div>

                    <div class="col-md-4 ol-form-label text-muted">: {{$servicemanagementmodel->contractno }}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Customer Name</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$servicemanagementmodel->customername }}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Service Date</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$servicemanagementmodel->serviceadate }}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Service reminder date</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$servicemanagementmodel->servicereminderdate}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">SRN Date</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$servicemanagementmodel->srmdate}}</div>
                </div>

                {{--<div class="row col-md-12">--}}
                    {{--<div for="input" class="col-sm-4 col-form-label text-muted">Service certificate date</div>--}}
                    {{--<div class="col-md-4 ol-form-label text-muted">: {{$servicemanagementmodel->servicecertificatedate}}</div>--}}
                {{--</div>--}}

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Actual Contract completion Date</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$servicemanagementmodel->actualcontractcompletiondate}}</div>
                </div>




                <br>

            </div>
        </div>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>

@endsection
	
	