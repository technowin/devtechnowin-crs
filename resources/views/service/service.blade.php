@extends('layouts.appnew')

@section('page-title', '| Add User')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading"><h3 class="panel-title"><span class="text-muted">Service</span></h3>
        </div>
        <div class="panel-heading">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a class="pagehead-tabs-item selected" href="#manageservice" data-toggle="tab">Manage Services</a></li>
                <li><a class="pagehead-tabs-item selected" href="#assignservice" data-toggle="tab">Assign Services</a></li>
                <li><a class="pagehead-tabs-item selected" href="#servicestatus" data-toggle="tab">Service Status</a></li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="manageservice">
                    <table class="table table-sm table-hover" id="manageservicetable" width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th>#</th>
                            <th>Contract No</th>
                            <th>Workorder No</th>
                            <th>Customer Name</th>
                            <th>Service Frequency</th>
                            <th>Service Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($manageservice as $key => $service)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{ $service->contractno }}</td>
                                <td>{{ $service->workorderno }}</td>
                                <td>{{ $service->customername}}</td>
                                <td>{{ $service->servicefrequency}}</td>
                                <td>{{ $service->serviceadate }}</td>
                                <td>
                                    <a href="{{ URL::to('managecomplaint/show',array($service->contractno))}}">view</a> |
                                    <a href="{{ URL::to('managecomplaint/manage',array($service->id))}}">manage</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="assignservice">
                    <table class="table table-sm table-hover" id="assignservicetable" width="100%">
                    <thead>
                        <tr class="text-muted">
                            <th>#</th>
                            <th>Contract No</th>
                            <th>Workorder No</th>
                            <th>Customer Name</th>
                            <th>Service Frequency</th>
                            <th>Service Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($assignservices as $key => $service)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{ $service->contractno }}</td>
                            <td>{{ $service->workorderno }}</td>
                            <td>{{ $service->customername}}</td>
                            <td>{{ $service->servicefrequency}}</td>
                            <td>{{ $service->serviceadate }}</td>
                            <td>
                                <a href="{{ URL::to('managecomplaint/show',array($service->contractno))}}">view</a> |
                                <a href="{{ URL::to('managecomplaint/assignee',array($service->contractno,$service->id))}}">assignee</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="servicestatus">
                    <table class="table table-sm table-hover" id="servicestatustable" width="100%">
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
                        @foreach($servicestatus as $key => $services)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{ $services->contractno }}</td>
                                <td>{{ $services->customername }}</td>
                                <td>{{ $services->branchname}}</td>
                                <td>{{ $services->ticketno}}</td>
                                <td>{{ $services->servicedate }}</td>
                                <td>
                                    <a href="{{ URL::to('serviceview',array($services->ticketno))}}">view</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('selectize-script')
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#manageservicetable').DataTable();
            $('#assignservicetable').DataTable();
            $('#servicestatustable').DataTable();
        });
    </script>


@stop
