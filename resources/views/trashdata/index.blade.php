@extends('layouts.appnew')

@section('pageTitle', 'Complaints')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

@section('content')

    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading">
            <ul class="nav nav-tabs">
                <li class="active"><a class="pagehead-tabs-item selected" href="#treshcategory" data-toggle="tab">Trash Category</a></li>
                <li><a class="pagehead-tabs-item selected" href="#treshsubcategory" data-toggle="tab">Trash Sub-Category</a></li>
                {{--<li><a class="pagehead-tabs-item selected" href="#resolvedcomplaints" data-toggle="tab">Resolved Complaints</a></li>--}}
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="treshcategory">
                    <table class="table table-sm table-hover" id="newcomplaintstable" width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th>#</th>
                            <th>Ticketno</th>
                            <th>Customer Type</th>
                            <th>Customer Name	</th>
                            <th>Complaint Description</th>
                            <th>Complaint Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($newcomplaints as $key => $newcomplaint)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{ $newcomplaint->ticketno }}</td>
                                <td>{{ $newcomplaint->customers->customername }}</td>
                                <td>{{ $newcomplaint->customers->customername }}</td>
                                <td>{{ $newcomplaint->complaintdescription }}</td>
                                <td>{{ $newcomplaint->created_at }}</td>
                                <td>
                                    <a href="{{ url('complaints/view/'.$newcomplaint->id) }}">view</a> |
                                    <a href="{{ url('registration/assigncomplaint/'.$newcomplaint->id) }}">manage</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="treshsubcategory">
                    <table class="table table-sm table-hover" id="assignedcomplaintstable" width="100%">
                        <thead>
                        <tr class="text-muted">
                            <th>#</th>
                            <th>Ticketno</th>
                            <th>Customer Type</th>
                            <th>Customer Name	</th>
                            <th>Complaint Description</th>
                            <th>Complaint Date</th>
                            <th>Assignee Name</th>
                            <th>Action</th>

                        </tr>
                        </thead>
                        @foreach($assignedcomplaints as $key => $assignedcomplaint)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{ $assignedcomplaint->ticketno }}</td>
                                <td>{{ $assignedcomplaint->customers->customername }}</td>
                                <td>{{ $assignedcomplaint->customers->customername }}</td>
                                <td>{{ $assignedcomplaint->complaintdescription }}</td>
                                <td>{{ $assignedcomplaint->created_at }}</td>
                                <td>{{ $assignedcomplaint->assigneename }}</td>
                                <td>
                                    <a href="{{ url('registration/edit/'.$assignedcomplaint->ticketno) }}">view</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                {{--<div class="tab-pane fade" id="resolvedcomplaints">--}}
                    {{--<table class="table table-sm table-hover" id="resolvedcomplaintstable" width="100%">--}}
                        {{--<thead>--}}
                        {{--<tr class="text-muted">--}}
                            {{--<th>#</th>--}}
                            {{--<th>Ticketno</th>--}}
                            {{--<th>Customer Type</th>--}}
                            {{--<th>Customer Name</th>--}}
                            {{--<th>Complaint Description</th>--}}
                            {{--<th>Complaint Date</th>--}}
                            {{--<th>Action</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--@foreach($resolvedcomplaints as $key => $resolvedcomplaint)--}}
                            {{--<tr>--}}
                                {{--<th scope="row">{{$key+1}}</th>--}}
                                {{--<td>{{ $resolvedcomplaint->ticketno }}</td>--}}
                                {{--<td>{{ $resolvedcomplaint->customers->customername or 'NA' }}</td>--}}
                                {{--<td>{{ $resolvedcomplaint->customers->customername or 'NA' }}</td>--}}
                                {{--<td>{{ $resolvedcomplaint->complaintdescription }}</td>--}}
                                {{--<td>{{ $resolvedcomplaint->created_at }}</td>--}}
                                {{--<td>--}}
                                    {{--<a href="{{ url('complaints/view/'.$resolvedcomplaint->id) }}">view</a> |--}}
                                    {{--<a href="{{ url('complaints/close/'.$resolvedcomplaint->id) }}">close</a>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                    {{--</table>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
@endsection


@section('selectize-script')
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>

@endsection