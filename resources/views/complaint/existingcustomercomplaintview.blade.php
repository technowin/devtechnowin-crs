@extends('layouts.app')
@section('pageTitle', 'Existing Customer Complaints')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Ticket No. : {{ $ticketnumber }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Assignee Name</td>
                        <td> : {{$assigneesvalue}}</td>
                    </tr>
                    <tr>
                        <td>Assignee Status</td>
                        <td> : {{$assigneestatusvalue}}</td>
                    </tr>
                    <tr>
                        <td>Resolve Comment</td>
                        <td> : {{$resolvecomment}}</td>
                    </tr>
                    <tr>
                        <td>Start Date</td>
                        <td> : {{$startdate}}</td>
                    </tr>
                    <tr>
                        <td>End Date</td>
                        <td> : {{$enddate}}</td>
                    </tr>
                    <tr>
                        <td>Pending Reason</td>
                        <td> : {{$pendingreason}}</td>
                    </tr>
                    <tr>
                        <td>Next Action Remark</td>
                        <td> : {{$nextactionremark}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection