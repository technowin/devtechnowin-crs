@extends('layouts.appnew')

@section('pageTitle', 'Complaints')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

@section('content')

{{--    @if (Session::has('flash_message'))--}}
{{--        <div class="alert alert-success">--}}
{{--            {{ Session::get('flash_message') }}--}}
{{--        </div>--}}
{{--    @endif--}}

    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading"><h3 class="panel-title"><span class="text-muted">Manage Complaints</span></h3>
        </div>
        <div class="panel-heading">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a class="pagehead-tabs-item selected" href="#newcomplaints" data-toggle="tab">New Complaints</a></li>
                <li><a class="pagehead-tabs-item selected" href="#assignedcomplaints" data-toggle="tab">Assigned Complaints</a></li>
                <li><a class="pagehead-tabs-item selected" href="#resolvedcomplaints" data-toggle="tab">Resolved Complaints</a></li>
                <li><a class="pagehead-tabs-item selected" href="#closedcomplaints" data-toggle="tab">Closed Complaints</a></li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="newcomplaints">
                    <table class="table table-sm table-hover" id="newcomplaintstable" width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th>Ticketno</th>
                            <th>Customer Name</th>
                            <th>Customer Site </th>
                            <th>Product Sr No</th>
                            <th>Complaint Description</th>
                            <th>Caller Name</th>
                            <th>Complaint Date</th>
                            <th style="display: none;"></th>
                            <th>Ticket Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($newcomplaints as $key => $newcomplaint)
                            <tr>
                                <td>{{ $newcomplaint->ticketno }}</td>
                                <td>{{ $newcomplaint->customername }}</td>
                                <td>{{ $newcomplaint->branchcode }}</td>
                                <td>{{ $newcomplaint->productsrno_accountno }}</td>
                                <td>{{ $newcomplaint->complaintdescription }}</td>
                                <td>{{ $newcomplaint->callername }}</td>
                                <td>{{ \Carbon\Carbon::parse($newcomplaint->complaintdate)->format('d/m/Y h:i:s') }}</td>
                                <td style="display: none;">{{ $newcomplaint->tcomplaintdate }}</td>
                                <td>{{ $newcomplaint->complaintstatus }}</td>
                                <td>
                                    <a href="{{ url('complaints/edit/'.$newcomplaint->id) }}">edit</a> |
                                    <a href="{{ url('complaints/view/'.$newcomplaint->id) }}">view</a> |
                                    @if($newcomplaint->ticketno != 'Temp')
                                    <a href="{{ url('registration/assigncomplaint/'.$newcomplaint->ticketno.'/'."null") }}">manage</a>|
                                    @endif
                                    <a href="{{ url('closecomplint/'.$newcomplaint->ticketno) }}">close</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="assignedcomplaints">
                    <table class="table table-sm table-hover" id="assignedcomplaintstable" width="100%">
                        <thead>
                        <tr class="text-muted">
                            {{--<th>#</th>--}}
                            <th>Ticketno</th>
                            <th>Customer Name	</th>
{{--                            <th>Branch Name	</th>--}}
                            <th>Product Sr No</th>
                            <th>Complaint Description</th>
                            <th>Caller Name</th>
                            <th>Assignee Name</th>
                            <th>Assignee Start Date</th>
                            <th style="display: none;"></th>
                            <th style="display: none;"></th>
                            <th>Assignee Status</th>
                            <th>Complaint Date</th>
                            <th>Ticket Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        @foreach($assignedcomplaints as $key => $assignedcomplaint)
                            <tr>
                                @if($assignedcomplaint->New_Reopen != "")
                                <td>{{ $assignedcomplaint->ticketno.' R'}}</td>
                                @else
                                <td>{{ $assignedcomplaint->ticketno }}</td>
                                @endif
                                <td>{{ $assignedcomplaint->customername }}</td>
                                <td>{{ $assignedcomplaint->productsrno_accountno }}</td>
                                <td>{{ $assignedcomplaint->complaintdescription }}</td>
                                <td>{{ $assignedcomplaint->callername }}</td>
                                <td>{{ $assignedcomplaint->assigneename }}</td>
{{--                                <td>{{ $assignedcomplaint->assigneestartdate }}</td>--}}
                                <td>{{ \Carbon\Carbon::parse($assignedcomplaint->assigneestartdate)->format('d/m/Y h:i:s') }}</td>
                                <td style="display: none;">{{ $assignedcomplaint->tassigneestartdate }}</td>
                                <td style="display: none;">{{ $assignedcomplaint->order_by }}</td>
                                <td>{{ $assignedcomplaint->assigneestatus }}</td>
                                <td>{{ \Carbon\Carbon::parse($assignedcomplaint->complaintdate)->format('d/m/Y h:i:s') }}</td>
                                <td>{{ $assignedcomplaint->complaintstatus }}</td>
                                <td>
                                    @if($assignedcomplaint->assigneestatus =='ASSIGNED' || $assignedcomplaint->assigneestatus =="REASSIGNED")
                                        <a  href="{{ url('getproductsrno/'.$assignedcomplaint->id) }}">edit</a> |
                                        <a  href="{{ url('registration/edit/'.$assignedcomplaint->assigneecode.'/'.$assignedcomplaint->ticketno) }}">view</a>|
                                        <a  href="{{ url('registrationreassigne/edit/'.$assignedcomplaint->assigneecode.'/'.$assignedcomplaint->ticketno) }}">re-assign</a>|
                                        <a  href="{{ url('addcomments/'.$assignedcomplaint->ticketno) }}">comment</a>
                                    @elseif($assignedcomplaint->assigneestatus !='Allocated')
                                        <a  href="{{ url('getproductsrno/'.$assignedcomplaint->id) }}">edit</a> |
                                        <a  href="{{ url('registration/edit/'.$assignedcomplaint->assigneecode.'/'.$assignedcomplaint->ticketno) }}">view</a>|
                                        <a  href="{{ url('registrationcomplaintsclose/edit/'.$assignedcomplaint->assigneecode.'/'.$assignedcomplaint->ticketno) }}">close</a>|
                                        <a  href="{{ url('registrationreassigne/edit/'.$assignedcomplaint->assigneecode.'/'.$assignedcomplaint->ticketno) }}">re-assign</a>|
                                        <a  href="{{ url('addcomments/'.$assignedcomplaint->ticketno) }}">comment</a>
                                    @else
                                        <a  href="{{ url('getproductsrno/'.$assignedcomplaint->id) }}">edit</a> |
                                        <a  href="{{ url('registration/edit/'.$assignedcomplaint->assigneecode.'/'.$assignedcomplaint->ticketno) }}">view</a>|
                                        <a  href="{{ url('addcomments/'.$assignedcomplaint->ticketno) }}">comment</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="tab-pane fade" id="resolvedcomplaints">
                    <table class="table table-sm table-hover" id="resolvedcomplaintstable" width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th>Ticketno</th>
                            <th>Customer Name</th>
                            <th>Product Sr No</th>
                            <th>Complaint Description</th>
                            <th>Complaint Date</th>
                            <th>Ticket Status</th>
                            <th>Resolved Date</th>
                            <th style="display: none;"></th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        @foreach($resolvedcomplaints as $key => $resolvedcomplaint)
                            <tr>
                                <td>{{ $resolvedcomplaint->ticketno }}</td>
                                <td>{{ $resolvedcomplaint->customername }}</td>
                                <td>{{ $resolvedcomplaint->productsrno_accountno }}</td>
                                <td>{{ $resolvedcomplaint->complaintdescription }}</td>
                                <td>{{ \Carbon\Carbon::parse($resolvedcomplaint->complaintdate)->format('d/m/Y h:i:s') }}</td>
                                <td>{{ $resolvedcomplaint->complaintstatus }}</td>
                                <td>{{ \Carbon\Carbon::parse($resolvedcomplaint->callenddate)->format('d/m/Y h:i:s') }}</td>
{{--                                <td>{{ $resolvedcomplaint->callenddate }}</td>--}}
                                <td style="display: none;">{{ $resolvedcomplaint->tcallenddate }}</td>
                                <td>
                                    <a  href="{{ url('complaints/view/'.$resolvedcomplaint->id) }}">view</a> |
                                    <a  href="{{ url('complaints/close/'.$resolvedcomplaint->ticketno) }}">close</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="tab-pane fade" id="closedcomplaints">
                    <table class="table table-sm table-hover" id="closedcomplainttable" width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th>Ticketno</th>
                            <th>Customer Name</th>
                            <th>Product Sr No</th>
                            <th>Complaint Description</th>
                            <th>Complaint Date</th>
                            <th>Ticket Status</th>
                            <th>Call Closed Date</th>
                            <th style="display: none;"></th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        @foreach($closedcomplaints as $key => $closedcomplaint)
                            <tr>
                                <td>{{ $closedcomplaint->ticketno }}</td>
                                <td>{{ $closedcomplaint->customername }}</td>
                                <td>{{ $closedcomplaint->productsrno_accountno }}</td>
                                <td>{{ $closedcomplaint->complaintdescription }}</td>
                                <td>{{ \Carbon\Carbon::parse($closedcomplaint->complaintdate)->format('d/m/Y h:i:s') }}</td>
{{--                                <td>{{ $closedcomplaint->complaintdate }}</td>--}}
                                <td>{{ $closedcomplaint->complaintstatus }}</td>
{{--                                <td>{{ $closedcomplaint->callclosuredate }}</td>--}}
                                <td>{{ \Carbon\Carbon::parse($closedcomplaint->callclosuredate)->format('d/m/Y h:i:s') }}</td>
                                <td style="display: none;">{{ $closedcomplaint->tcallenddate }}</td>
                                <td>
                                    <a  href="{{ url('complaints/view/'.$closedcomplaint->id) }}">view</a>|
                                    <a  href="{{ url('complaints/reopencomplaint/'.$closedcomplaint->ticketno) }}">Reopen</a>
                                </td>
                            </tr>
                        @endforeach
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
            $('#newcomplaintstable').DataTable({
                  "order": [[ 7, "desc" ]]
            });

        });
        $(document).ready(function () {
            $('#assignedcomplaintstable').DataTable({
                // "order": [[ 7, "desc" ]]
                 "order": [],
                "columnDefs" : [{ "type":"date-euro"}],
                // 'columnDefs': [ {
                //    'sort': 'timestamp'
                //    "sType": "date-uk"
                //    type: 'date-euro', targets: 0
                //    'orderable': false /* true or false */
                //  }]
            });

        });
        $(document).ready(function () {
            $('#resolvedcomplaintstable').DataTable({
                 "order": [[ 7, "desc" ]]
            });
        });
        $(document).ready(function () {
            $('#closedcomplainttable').DataTable({
                "order": [[ 7, "desc" ]]
            });
        });
    </script>
@endsection