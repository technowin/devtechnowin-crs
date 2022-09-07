@extends('layouts.appnew')
@section('pageTitle', 'Assigned Complaint')
@section('content')
    <div class="col-md-12">
        <div class="col-md-12 row">
            {{--@if($status == 'NOT RESOLVED')--}}
                {{--<div class="col-md-6">--}}
                    <div class="panel panel-default">
                        <div class="panel-heading">Re-Assign Complaint</div>
                        <div class="panel-body">
                            <div class="container" style="padding-left: 50px;">
                                {{Form::open(array('action' => array('ComplaintHandlingController@update', $ticketno),'method' => 'post', 'role' => 'form', 'invalidate' => 'invalidate', 'files'=>true,'id'=>'reassigncomplaintform', 'onsubmit' => 'return chkdropvalues();'))}}
                                {{ Form::hidden('id',$id) }}
                                {{ Form::hidden('employeeid',null,array('id' => 'employeeid')) }}
                                <div class="row mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Ticket No.</label>
                                    <div class="col-sm-6">
                                        {{ Form::text('ticketnumber', $ticketno, array('class' => 'form-control form-control-sm','readonly' => true,'style'=>'background-color:white;')) }}
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 05px;">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Assignee Name</label>
                                    <div class="col-sm-6">
                                        {{ Form::select('assignees', $assignees, null, array('class'=>'assigneesname','placeholder' => '--SELECT--', 'id' => 'assigneesid')) }}
                                        @if ($errors->has('assignees'))
                                            <span class="help-block"><strong>{{ $errors->first('assignees') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row" id="vendorTicketDiv">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">OEM's Ticket No.</label>
                                    <div class="col-sm-6">
                                        {{Form::text('vendorTicketNo',null,array('class' => 'form-control form-control-sm','id' => 'vendorTicketNo'))}}
                                        @if($errors->has('vendorTicketNo'))
                                            <span class="help-block"><strong>{{$errors->first('vendorTicketNo')}}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row" id="vendorCommentDiv" style="padding-top: 5px;">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Comments</label>
                                    <div class="col-sm-6">
                                        {{Form::textarea('vendorComment',null,array('class' => 'form-control form-control-sm','id' => 'vendorComment'))}}
                                        @if($errors->has('vendorComment'))
                                            <span class="help-block"><strong>{{($errors->first('vendorComment'))}}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 05px;">
                                    <label for="input" class="col-sm-3 col-form-label text-muted" >Start Date</label>
                                    <div class="col-sm-6">
                                        {{ Form::date('startdate', $assigneestartdate, array('required' => 'required', 'class' => 'form-control form-control-sm','id'=>'startdateid','onchange'=>'Setstartdate();return false;')) }}
                                        @if ($errors->has('startdate'))
                                            <span class="help-block"><strong>{{ $errors->first('startdate') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">End Date</label>
                                    <div class="col-sm-6">
                                        {{ Form::date('enddate', null, array('required' => 'required', 'class' => 'form-control form-control-sm','id'=>'enddateid','onchange'=>'Setenddate();return false;')) }}
                                        @if ($errors->has('enddate'))
                                            <span class="help-block"><strong>{{ $errors->first('enddate') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <label for="input" class="col-sm-2 col-form-label text-muted"></label>
                                    <div class="col-sm-6">
{{--                                        {{ Form::submit('save & close', array('class' => 'btn btn-primary offset-4')) }}--}}
                                        {{ Form::submit('Submit', array( 'id'=>'btnsubmitid','class' => 'btn btn-primary offset-4')) }}
                                    </div>
                                </div>

                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                {{--</div>--}}
            {{--@endif--}}
        </div>
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#assigneesid').selectize({
            });
            $('#vendorTicketDiv').hide();
            $('#vendorCommentDiv').hide();
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
            var value =   month  > 9  ? "" : "0"+month
            var contractfromdate = year+'-'+ value +'-'+day;
            var assigneestartdate  = new Date($("#startdateid").val());
            var countyear = assigneestartdate.getFullYear().toString().length;
            if(countyear == 4)
            {
                if(currentdate >= assigneestartdate){
                    alert('start date greater than ' + contractfromdate)
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
                    $("#contenetid").empty();
                    data.forEach(function (value) {
                        content +="<tr>" +
                            "<td style=''>"+value.ticketno+"</td>"+
                            "<td style=''>"+value.customername+"</td>"+
                            "<td style=''>"+value.branchname+"</td>"+
                            "<td style=''>"+value.assigneestartdate+"</td>"+
                            "<td style=''>"+value.complaintdescription+"</td>"+
                            "</tr>"
                    });
                    debugger;
                    $("#contenetid").append(content);
                    $("#employeeid").val(data[0].employeeid);
                    if(data.length > 0) {
                        $('#confirm').modal('show');
                        if(data[0].employeeid === null)
                        {
                            $("#vendorTicketDiv").show();
                            $("#vendorCommentDiv").show();
                        }
                        else{
                            $("#vendorTicketDiv").hide();
                            $("#vendorCommentDiv").hide();
                        }
                    }
                    else {
                        content = " <h1>There is not data found!</h1>";
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
            debugger;
            $("#btnsubmitid").attr("disabled", true);
            if($('#assigneesid').val() != ""){
                console.log($("#employeeid").val());
                if($("#employeeid").val() === '' && $("#vendorTicketNo").val() === '')
                {
                    alert("Enter Vendor's Ticket No.");
                    $("#btnsubmitid").attr("disabled", false);
                    return false;
                }
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