@extends('layouts.appnew')

@section('page-title', '| Customer Master')

@section('content')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop


@if (session('flash_message'))
    <div class="alert alert-success">
        {{ session('flash_message') }}
    </div>
@endif

<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12 row">
            <div class="col-md-10"><h6>Service Management</h6></div>
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
                <th>Service Date</th>
                <th>Service reminder date</th>
                <th>SRN Date</th>
                <th>Actual Contract completion Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($servicemanagementmodel as $key => $service)
                <tr>

                    <td>{{$service->contractno}}</td>
                    <td>{{$service->customername}}</td>
                    <td>{{$service->serviceadate}}</td>
                    <td>{{$service->servicereminderdate}}</td>
                    <td>{{$service->srmdate}}</td>
                    <td>{{$service->actualcontractcompletiondate}}</td>

                    <td><a href="{{ URL::to('servicemanagementview/'.$service->id) }}">view</a> |
                        <a href="{{ URL::to('servicemanagementedit/'.$service->id) }}">Edit</a></td>
                </tr>

            @endforeach
            {!! Form::close() !!}

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
                "order": [[ 3, "desc" ]]
            } );
        });
    </script>
@stop