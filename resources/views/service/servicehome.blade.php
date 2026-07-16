@extends('layouts.appnew')
@section('pageTitle', 'Home')
@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12 row">
                <div class="col-md-10"><h6>Service</h6></div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body table-responsive">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" >
                <thead>
                <tr class="text-muted">
                    <th>#</th>
                    <th>Contract No</th>
                    <th>Customer Name</th>
                    <th>Branch Name</th>
                    <th>Ticket No</th>
                    <th>Service Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($service as $key => $services)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{ $services->contractno }}</td>
                        <td>{{ $services->customername }}</td>
                        <td>{{ $services->branchname}}</td>
                        <td>{{ $services->ticketno}}</td>
                        <td>{{ $services->servicedate }}</td>
                        <td>
                            <a href="{{ URL::to('serviceview',array($services->ticketno))}}">View</a> |
                            <a href="{{ URL::to('managecomplaint/show',array($services->contractno))}}">Service Report</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
@endsection