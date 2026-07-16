{{--@extends('layouts.appnew')--}}
{{--@section('pageTitle', 'Add Tender Bid Details')--}}
{{--@section('page-css')--}}
{{--    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">--}}
{{--@stop--}}
{{--@section('content')--}}
{{--    <h1>Hello</h1>--}}
{{--    <div class="panel panel-default">--}}
{{--        <div class="panel-heading"><h3 class="panel-title"><span class="text-muted">All Lodged Complaints</span></h3>--}}
{{--        </div>--}}
{{--        <div class="panel-body">--}}

<style>
    th,td{
        font-size: 14px;
    }
</style>
            <table border="1" width="50%px">
                <thead>
                <tr><td colspan='3'><b>Total Record : {{count($idata)}} </b></td><td colspan='2'><b>RECEIVED : {{$ACKNOWLEDGEDcount}}</b></td><td colspan='2'><b>ASSIGNED : {{$ASSIGNEDcount}} </b></td><td colspan='2'><b>RESOLVED : {{$RESOLVEDcount}} </b></td><td colspan='2'><b>CLOSED : {{$CLOSEDcount}} </b></td></tr>
                <tr class="text-muted">
                    <th style=''><b>Ticket No</b></th>
                    <th style=''><b>Customer Name</b></th>
                    <th style=''><b>Complaint Date</b></th>
                    <th style=''><b>Equipment Name</b></th>
                    <th style=''><b>Equipment No</b></th>
                    <th style=''><b>Description</b></th>
                    <th style=''><b>Status</b></th>
                    <th style=''><b>Assignee Name</b></th>
                    <th style=''><b>Assignee Date</b></th>
                    <th style=''><b>Resolved Date</b></th>
                    <th style=''><b>Closed Date</b></th>
                </tr>
                </thead>
                <tbody>
                @foreach($idata as $idatas)
                    <tr>
                        <td>{{ $idatas->ticketno }}</td>
                        <td>{{ $idatas->customername }}</td>
                        <td>{{ $idatas->complaintdate }}</td>
                        <td>{{ $idatas->productservicename }}</td>
                        <td>{{ $idatas->productsrno_accountno }}</td>
                        <td>{{ $idatas->complaintdescription }}</td>
                        <td>{{ $idatas->complaintstatus}}</td>
{{--                        <td>{{ (($idatas->complaintstatus == "ACKNOWLEDGED") ? 'Received' : $idata->complaintstatus)}}</td>--}}
                        <td>{{ $idatas->assigneename }}</td>
                        <td>{{ $idatas->callstartdate }}</td>
                        <td>{{ $idatas->callenddate }}</td>
                        <td>{{ $idatas->callclosuredate }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
{{--@section('page-script')--}}
{{--@endsection--}}

