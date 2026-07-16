@extends('layouts.appnew')
@section('pageTitle', 'Assigned Complaint')
@section('content')
    <div class="col-md-12">
        <div class="col-md-12 row" >
            <div class="panel panel-default">
                        <div class="panel-heading">Close Complaint</div>
                        <div class="panel-body" style="padding-left: 50px;">
                            <div class="container">
                                {{ Form::open(array('url' => 'closecomplaint','files' => true)) }}
                                {{ Form::hidden('id',$id) }}
                                <div class="row mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Assignee Name</label>
                                    <div class="col-sm-6">
                                        {{ Form::text('assigneename', $assigneename, array('class' => 'form-control form-control-sm','required' => 'required','readonly' => true,'style'=>'background-color:white;')) }}
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Ticket No.</label>
                                    <div class="col-sm-6">
                                        {{ Form::text('ticketnumber', $ticketno, array('class' => 'form-control form-control-sm','required' => 'required','readonly' => true,'style'=>'background-color:white;')) }}
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Reason Close Complaint </label>
                                    <div class="col-sm-6">
                                        {{ Form::textarea('reasonclosecomplaint', '', array('class' => 'form-control form-control-sm','required' => 'required','style'=>'background-color:white;')) }}
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <label for="input" class="col-sm-2 col-form-label text-muted"></label>
                                    <div class="col-sm-6">
                                        {{ Form::submit('save & close', array('class' => 'btn btn-primary offset-4')) }}
                                    </div>
                                </div>

                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script type="text/javascript">

        $(document).ready(function () {
            $('#assignees').selectize({
//                maxItems: 1,
            });
        });
    </script>
@stop