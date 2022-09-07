@extends('layouts.appnew')

@section('pageTitle', 'View')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Complaint</h3>
            </div>
            <div class="panel-body">
                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-5 col-form-label-sm text-muted">Ticket No</label>
                    <div class="col-sm-7">
                        {{ Form::label('', $complaints->ticketno) }}
                    </div>
                </div>
                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-5 col-form-label-sm text-muted">Complaint Description</label>
                    <div class="col-sm-7">
                        {{ Form::label('', $complaints->complaintdescription ,array('id'=>'status')) }}
                    </div>
                </div>
                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-5 col-form-label-sm text-muted">Complaint Date</label>
                    <div class="col-sm-7">
                        {{ Form::label('', $complaints->complaintdate) }}
                    </div>
                </div>
                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-5 col-form-label-sm text-muted">Complaint Status</label>
                    <div class="col-sm-7">
                        {{ Form::label('', $complaints->complaintstatus) }}
                    </div>
                </div>
                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-5 col-form-label-sm text-muted">Rejected Reason</label>
                    <div class="col-sm-7">
                        {{ Form::label('', $complaints->rejectionreason) }}
                    </div>
                </div>

                @if($assignee != null)
                    <div style="border: solid lightgray 1px; ">
                        <div style="font-size: 20px"><u>Engineer Details</u></div>
                        <div style="padding-top: 10px;"></div>
                        <div class="row" style="padding: 5px" >
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Engineer Name</label>
                            <div class="col-sm-7">
                                {{ Form::label('', $assigneedetails->assigneename) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Engineer Mobile No</label>
                            <div class="col-sm-7">
                                {{ Form::label('', $assigneedetails->mobileno) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Engineer Email</label>
                            <div class="col-sm-7">
                                {{ Form::label('', $assigneedetails->emailid) }}
                            </div>
                        </div>
                    </div>
                @endif


            </div>
        </div>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>
@endsection
@section('script-js')
@stop