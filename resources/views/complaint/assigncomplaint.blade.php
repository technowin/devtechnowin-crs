@extends('layouts.appnew')
@section('pageTitle', 'Create Assignee')
@section('page-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css"/>
@stop
@section('content')

    @if (session('flash_message'))
        <div class="alert alert-danger">
            {{ session('flash_message') }}
        </div>
    @endif

    <div class="container" style="padding-left: 100px;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5 class="panel-title text-muted">Assign Complaint</h5>
            </div>
            <div class="panel-body">
                <div class="container">
                    <br>
                    {{Form::open(array('id' => 'assignee','action' => 'ComplaintHandlingController@storesuppy','method' => 'post', 'role' => 'form', 'invalidate' => 'invalidate', 'files'=>true, 'onsubmit' => 'return chkdropvalues();'))}}
                    {{ Form::hidden('serviceId',$serviceId,array('id'=>'serviceId')) }}
                    <div class="row{{ $errors->has('ticketnumber') ? ' has-error' : '' }} mt-1">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Ticket No.</label>
                        <div class="col-sm-6">
                            {{ Form::text('ticketnumber', $ticketnumber, array('class' => 'form-control','readonly' => true,'style'=>'background-color:white;')) }}
                        </div>
                    </div>
                    <div class="row{{ $errors->has('assignees') ? ' has-error' : '' }} mt-1">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Assignee Name</label>
                        <div class="col-sm-6">
                            {{ Form::select('assignees',$assignees,null,array('placeholder'=>'--Select--','id' => 'assigneesid')) }}
                            @if ($errors->has('assignees'))
                                <span class="help-block"><strong>{{ $errors->first('assignees') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="row{{ $errors->has('startdate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Start Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('startdate', $assigneestartdate, array('required' => 'required', 'class' => 'form-control','required' => 'required','id'=>'startdateid' ,'onchange'=>'Setstartdate();return false;')) }}
                            @if ($errors->has('startdate'))
                                <span class="help-block"><strong>{{ $errors->first('startdate') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="row{{ $errors->has('enddate') ? ' has-error' : '' }} mt-1">
                        <label for="input" class="col-sm-4 col-form-label text-muted">End Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('enddate', null, array('required' => 'required', 'class' => 'form-control','required' => 'required','id'=>'enddateid','onchange'=>'Setenddate();return false;')) }}
                            @if ($errors->has('enddate'))
                                <span class="help-block"><strong>{{ $errors->first('enddate') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <br>

                    <div class="row mt-2">
                        <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                        <div class="col-sm-6">
                            <br/>
{{--                            {{ Form::submit('Submit', array('class' => 'btn btn-primary offset-4','id'=>'btnsubmitid')) }}--}}
                            {{ Form::submit('Submit', array( 'id'=>'btnsubmitid','class' => 'btn btn-primary offset-4')) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>
    <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Assignee Assigne Ticket</h4>
                </div>
                <div class="modal-body">
                <div id="contenetid"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#assigneesid').selectize({
            });
            $('#assigneestatus').selectize({
                maxItems: 0,
            });
        });

    </script>
    <script type="text/javascript">
        function Setstartdate() {
            debugger
            var currentdate = new Date();
            currentdate.setDate(currentdate.getDate());
            var month = currentdate.getMonth() + 1;
            var year = currentdate.getFullYear();
            var day = currentdate.getDate();
            var value =   month  > 9  ? "" : "0"+month;
            var contractfromdate = year+'-'+ value +'-'+day;
            var assigneestartdate  = new Date($("#startdateid").val());
            var countyear = assigneestartdate.getFullYear().toString().length;
            if(countyear == 4)
            {
                if(currentdate >= assigneestartdate){
                    alert('start date greater than ' + contractfromdate);
                    $("#startdateid").val(contractfromdate);
                }
            }
        }
        function Setenddate()
        {
            var startdate = new Date($("#startdateid").val());
            var enddate = new Date($("#enddateid").val());
            var year = enddate.getFullYear().toString().length;
            if(year == 4)
            {
                if(startdate  > enddate) {
                    alert('end date greater than ' + $("#startdateid").val());
                    $("#enddateid").val($("#startdateid").val());
                }
            }
        }
    </script>
    <script type="text/javascript">
        $("#assigneesid").change(function () {
            $.ajax({
                url: "{{URL::to('getassigneeassigneddata/')}}/" + $('#assigneesid').val(),
                type: "GET",
                dataType: "json",
                success: function (data) {
                    var content = "";
                    content +="<table id='mytableid' class='table table-striped table-bordered' width='100%'>" +
                        "<tr><th style='width: 100px;'>Ticket No</th><th style='width: 100px;'>Customer name</th><th style='width: 100px;'>Branch</th><th style='width: 100px;'>Assigned Date</th><th>Complaint Description</th></tr>";
                    debugger
                    $("#contenetid").empty();
                    data.forEach(function (value) {
                        debugger
                        content+="<tr>" +
                            "<td style=''>"+value.ticketno+"</td>"+
                            "<td style=''>"+value.customername+"</td>"+
                            "<td style=''>"+value.branchname+"</td>"+
                            "<td style=''>"+value.assigneestartdate+"</td>"+
                            "<td style=''>"+value.complaintdescription+"</td>"+
                        "</tr>"
                    });
                    $("#contenetid").append(content);
                    if(data.length > 0) {
                        $('#confirm').modal('show');
                    }
                    else {
                        content = " <h1>No Complaints have been assigned.</h1>";
                        $("#contenetid").append(content);
                        $('#confirm').modal('show');
                    }
                    content += "</table>";
                }
            });
        });
    </script>
    <script type="text/javascript">
        function chkdropvalues() {
            $("#btnsubmitid").attr("disabled", true);
            if($('#assigneesid').val() != ""){

            }
            else {
                alert('Select Assignees Name');
                $("#btnsubmitid").attr("disabled", false);
                return false;
            }
            return true;
        }
    </script>
@stop
