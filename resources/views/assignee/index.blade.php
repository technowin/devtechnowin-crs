@extends('layouts.appnew')

@section('pageTitle', 'Assignee')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
@stop

@section('content')

    @if (session('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif
    @if (session('error-message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{session('error-message')}}
        </div>
    @endif
    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a class="pagehead-tabs-item selected" href="#newcomplaints" data-toggle="tab">New Complaints</a></li>
                <li><a class="pagehead-tabs-item selected" href="#pendingcomplaints" data-toggle="tab">Pending Complaints</a></li>
                <li><a class="pagehead-tabs-item selected" href="#notresolvedcomplaints" data-toggle="tab">Not-Resolved Complaint</a></li>
                <li><a class="pagehead-tabs-item selected" href="#example" data-toggle="tab">Resolved Complaints</a></li>
                <li><a class="pagehead-tabs-item selected" href="#closedcomplaints" data-toggle="tab">Closed Complaints</a></li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="newcomplaints">
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="newcomplaintsid" width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th><b>Ticketno</b></th>
                            <th><b>Equipment Sr No </b></th>
                            <th><b>Product Sr No </b></th>
                            <th><b>Status</b></th>
                            <th><b>Start Date</b></th>
                            <th><b>End Date</b></th>
                            <th><b>Action</b></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($assigneenewcomplaints as $key => $assigneenewcomplaint)
                            <tr>
                                <td>{{ $assigneenewcomplaint->ticketno }}</td>
                                <td>{{ $assigneenewcomplaint->productsrno_accountno}}</td>
                                <td>{{ $assigneenewcomplaint->productsrno}}</td>
                                <td>{{ $assigneenewcomplaint->assigneestatus}}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$assigneenewcomplaint->assigneestartdate )->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$assigneenewcomplaint->assigneeenddate )->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ url('assigneecomplaintsview/'.$assigneenewcomplaint->id) }}">view</a> |
                                    <a href="{{ url('manageassigneecomplaint/'.$assigneenewcomplaint->id) }}">manage</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="pendingcomplaints">
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="pendingcomplaintsid" width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th>Ticketno</th>
                            <th>Equipment Sr No </th>
                            <th>Product Sr No </th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        @foreach($pendingsstatus as $key => $pending)
                            <tr>
                                <td>{{ $pending->ticketno }}</td>
                                <td>{{ $pending->productsrno_accountno}}</td>
                                <td>{{ $pending->productsrno}}</td>
                                <td>{{ $pending->assigneestatus}}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$pending->assigneestartdate )->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$pending->assigneeenddate )->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ url('assigneecomplaintsview/'.$pending->id) }}">view</a> |
                                    <a href="{{ url('manageassigneecomplaint/'.$pending->id) }}">edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="tab-pane fade" id="notresolvedcomplaints">
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="notresolvedcomplaintsid" width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th>Ticketno</th>
                            <th>Equipment Sr No </th>
                            <th>Product Sr No </th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        @foreach($notresolvedcomplaints as $key => $notresolvedcomplaint)
                            <tr>
                                <td>{{ $notresolvedcomplaint->ticketno }}</td>
                                <td>{{ $notresolvedcomplaint->productsrno_accountno}}</td>
                                <td>{{ $notresolvedcomplaint->productsrno}}</td>
                                <td>{{ $notresolvedcomplaint->assigneestatus}}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$notresolvedcomplaint->assigneestartdate )->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$notresolvedcomplaint->assigneeenddate )->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ url('assigneecomplaintsview/'.$notresolvedcomplaint->id) }}">view</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="tab-pane fade" id="example">
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="exampletableid" width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th>Ticketno</th>
                            <th>Equipment Sr No </th>
                            <th>Product Sr No </th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        @foreach($resolvedcomplaints as $key => $resolvedcomplaint)
                            <tr>
                                <td>{{ $resolvedcomplaint->ticketno }}</td>
                                <td>{{ $resolvedcomplaint->productsrno_accountno}}</td>
                                <td>{{ $resolvedcomplaint->productsrno}}</td>
                                <td>{{ $resolvedcomplaint->assigneestatus}}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$resolvedcomplaint->assigneestartdate )->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$resolvedcomplaint->assigneeenddate )->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ url('assigneecomplaintsview/'.$resolvedcomplaint->id) }}">view</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="tab-pane fade" id="closedcomplaints">
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="closedcomplaintsid" width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th><b>Ticketno</b></th>
                            <th><b>Equipment Sr No </b></th>
                            <th><b>Product Sr No </b></th>
                            <th><b>Status</b></th>
                            <th><b>Start Date</b></th>
                            <th><b>End Date</b></th>
                            <th><b>Action</b></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($closedComplaints as $key => $closedComplaints)
                            <tr>
                                <td>{{ $closedComplaints->ticketno }}</td>
                                <td>{{ $closedComplaints->productsrno_accountno}}</td>
                                <td>{{ $closedComplaints->productsrno}}</td>
                                <td>{{ $closedComplaints->assigneestatus}}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$closedComplaints->assigneestartdate )->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$closedComplaints->assigneeenddate )->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ url('assigneecomplaintsview/'.$closedComplaints->id) }}">view</a>
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
    {{--<script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>--}}
    {{--<script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>--}}
    <script  src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script  src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script  src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script  src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script  src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function(){
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if(activeTab){
                $('#myTab a[href="' + activeTab + '"]').tab('show');
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#newcomplaintsid').DataTable();
        });
        $(document).ready(function () {
            $('#pendingcomplaintsid').DataTable();
        });
        $(document).ready(function () {
            $('#notresolvedcomplaintsid').DataTable();
        });
        $(document).ready(function () {
            $('#exampletableid').DataTable();
        });
        $(document).ready(function () {
            $('#closedcomplaintsid').DataTable();
        });
    </script>
@endsection