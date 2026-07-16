@extends('layouts.appnew')

@section('page-title', '| Customer Master')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop
@section('content')

@if (session('flash_message'))
    <div class="alert alert-success">
        {{ session('flash_message') }}
    </div>
@endif
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12 row">
            <div class="col-md-10"><h6>Supply Management</h6></div>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body table-responsive">
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr class="text-muted">
                <th>Contract No</th>
                <th>Customer Name</th>
                <th>Installation date</th>
                <th>Inspection Date</th>
                <th>Preventive maintenance Date</th>
                <th>Preventive maintenance reminder date</th>
                <th>Preventive maintenance certificate date</th>
                <th>Actual Contract completion Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($supplymanagementModel as $key => $supply)
                <tr>

                    <td>{{$supply->contractno}}</td>
                    <td>{{$supply->customername}}</td>
                    <td>{{$supply->installationdate}}</td>
                    <td>{{$supply->inspectiondate}}</td>
                    <td>{{$supply->preventivemaintenancedate}}</td>
                    <td>{{$supply->preventivemaintenancereminderdate}}</td>
                    <td>{{$supply->preventivemaintenancecertificatedate}}</td>
                    <td>{{$supply->actualcontractcompletiondate}}</td>
                    <td><a href="{{ URL::to('supplymanagementview/'.$supply->id) }}">view</a> |
                        <a href="{{ URL::to('supplymanagementedit/'.$supply->id) }}">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <br>

    </div>
</div>

@endsection

@section('page-script')
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable( {
                "savestate": true,
                "order": [[ 4, "desc" ]]
            } );
        });
    </script>
@stop
