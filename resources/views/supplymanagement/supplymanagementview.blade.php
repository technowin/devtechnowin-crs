@extends('layouts.appnew')

@section('page-title', '| Assignee Details')

@section('content')

    <div type="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Details Supply </h3>
            </div>
            <div class="panel-body">

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Contract No </div>

                    <div class="col-md-4 ol-form-label text-muted">: {{$supplymanagementModel->contractno }}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Customer Name</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$supplymanagementModel->customername }}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Installation date</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$supplymanagementModel->installationdate }}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Inspection Date</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$supplymanagementModel->inspectiondate}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Preventive maintenance Date</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$supplymanagementModel->preventivemaintenancedate}}</div>
                </div>

                <div class="row col-md-12">
                <div for="input" class="col-sm-4 col-form-label text-muted">Preventive maintenance reminder date</div>
                <div class="col-md-4 ol-form-label text-muted">: {{$supplymanagementModel->preventivemaintenancereminderdate}}</div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Preventive maintenance certificate date</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$supplymanagementModel->preventivemaintenancecertificatedate}}</div>
                </div>

                 <div class="row col-md-12">
                     <div for="input" class="col-sm-4 col-form-label text-muted">Actual Contract completion Date</div>
                     <div class="col-md-4 ol-form-label text-muted">:{{$supplymanagementModel->actualcontractcompletiondate}}</div>
                 </div>


                <br>

            </div>
        </div>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>

@endsection
	
	