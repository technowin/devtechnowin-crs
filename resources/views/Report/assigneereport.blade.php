@extends('layouts.appnew')
@section('pageTitle', 'Reports')
@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
@stop
<style type="text/css">
    #loading {
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        position: fixed;
        display: block;
        opacity: 0.7;
        background-color: #fff;
        z-index: 99;
        text-align: center;
    }

    #loading-image {
        position: absolute;
        top: 100px;
        left: 240px;
        z-index: 100;
    }
    .float-button {
        position: fixed;

    }
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:after {
        /*left: 8px !important;*/
        right: 10px !important;
        position:static;
    }
    td,th{
        font-size: 14px;
    }
    div.dataTables_wrapper div.dataTables_length label{
        padding-left: 50px;
    }
    #filtericon{
        background-color: #2ab27b;

    }
</style>
@section('content')
    <div class="w3-sidebar" style="display:none; overflow:auto; max-width: 300px; color: #fff; width: 100%;" id="mySidebar">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Get Report</h3>
                <button onclick="w3_close()" class="w3-button fa fa-close"></button>
                <a class="btn btn-outline-secondary"  id="btnpdfid" style="color:gray; float: right"> <b>PDF</b> </a>
            </div>
            <div class="panel-body">
                <label for="input" class="col-sm-12 text-muted">From Date<br><small><em>(Select date after 01-March-2018)</em></small></label>
                <div class="col-md-12">
                    {{ Form::date('fromdate',$now, array('class'=> 'form-control','id'=>'fromdateid','required'=>'required')) }}
                </div>
                <label for="input" class="col-sm-12 text-muted">To Date</label>
                <div class="col-md-12">
                    {{ Form::date('todate', $now, array('class' => 'form-control','id'=>'todateid')) }}
                </div>
                <label for="input" class="col-sm-12 text-muted">Complaint Status</label>
                <div class="col-md-12">
                    {{ Form::select('customercode', $complaintstatuslist,null, array('placeholder' => '--SELECT--','id' => 'complaintstatusid','class' => 'selectize')) }}
                </div>
                <label for="input" class="col-sm-2 text-muted">Assignees Name</label>
                <div class="col-md-12">
                    {{ Form::text('assigneesname', $assigneesname->assigneename, array('id' => 'assigneesnameid','readonly','class' =>'form-control form-control-sm text-muted')) }}
                </div>
                {{Form::hidden('assigneeid',$assigneesname->assigneecode,array('id' => 'assigneeid'))}}
                <div class="col-md-12">
                    <label for="input" class="col-md-12"><button class="btn btn-primary" id="getDataId" onclick="GetReport();return false;" >Get Data</button></label>
                </div>
            </div>
        </div>
    </div>
    <div id="loading" style="margin-top:150px;margin-left:350px;">
        <img id="loading-image" src="{{asset('img/throbber.gif')}}" alt="Loading..." />
    </div>
    <div>
        <button class="btn btn-primary fa fa-filter" onclick="w3_open()" id="filtericon" style=" margin-left: 8px;">Filter</button>
    </div>
    <div class="panel panel-default" >
        <div class="panel-body" id="contentid">
        </div>
    </div>
@endsection
@section('page-script')
    <script type="text/javascript" src="{{ asset('js/jquery-3.1.1.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#loading').hide();
            $('#complaintstatusid').selectize({
                maxItems: 1
            });
            // $('#assigneesnameid').selectize({
            //     maxItems: 1
            // });
        });
    </script>
    <script type="text/javascript">
        $('#fromdateid').change(function(){
            debugger
            var dateVal = '2018-03-01';
            if($("#fromdateid").val() < dateVal){
                debugger
                alert('From Date should be after 1st March 2018');
                $("#fromdateid").val('2018-03-01');
                return false;
            }
        })
    </script>
    <script type="text/javascript">
        $('#todateid').change(function(){
            debugger
            if($("#fromdateid").val() >  $('#todateid').val()){
                debugger
                alert('To Date Should not be less than From Date');
                $("#todateid").val('');
                return false;
            }
            else{
                return true;
            }
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            if($("#todateid").val() == ""){
                $("#todateid").val($("#fromdateid").val());
            }
            if($("#fromdateid").val() !="" && $('#todateid').val() !="" || $('#complaintstatusid').val() !="" && $('#assigneeid').val() !="")
            {
                debugger;
                $('#loading').show();
                $.ajax({
                    order: [[ 5, "desc" ]],
                    processing: true,
                    url: '{{ url('/getReportdates/{data}') }}/',
                    type: "GET",
                    dataType: "json",
                    language: {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
                    data: {
                        fromdateid: $("#fromdateid").val(),
                        todateid: $('#todateid').val(),
                        complaintstatusid: $('#complaintstatusid').val(),
                        assigneesname : $('#assigneeid').val()
                    },
                    success: function (data) {
                        debugger
                        if(data.idata.length > 0) {
                            var ACKNOWLEDGED = "";
                            if ($('#assigneeid').val() != "") {
                                ACKNOWLEDGED = "Received : Not Applicable";
                            } else {
                                ACKNOWLEDGED = "Received :" + data.ACKNOWLEDGEDcount + "";
                            }
                            debugger
                            var dynamicColumn;
                            if($('#complaintstatusid').val() == 'PENDING'){
                                debugger
                                dynamicColumn = 'Pending Date'
                            }
                            else if($("#complaintstatusid").val() == 'NOT RESOLVED'){

                                dynamicColumn = 'Unresolved Date'
                            }
                            else{
                                dynamicColumn = 'Resolved Date'
                            }

                            $('#contentid').empty();
                            var content = "";
                            // var N = 1;
                            content+="<table id='mytableid' class='table table-striped table-bordered' width='100%'>" +
                                "<thead>"+
                                "<tr><td colspan='2'><b>Total Record : "+data.idata.length+" </b></td><td colspan='2'><b>"+ACKNOWLEDGED+"</b></td><td colspan='2'><b>Assigned : "+data.ASSIGNEDcount+" </b></h3></td><td colspan='2'><b>Resolved : "+data.RESOLVEDcount+" </b></td><td colspan='2'><b>Closed : "+data.CLOSEDcount+" </b></td></tr>"+
                                "<tr>" +
                                // "<td><b>#</b></td>"+
                                "<td style='width:120px;'><b>Ticket No</b></td>"+
                                "<td style='width:120px;'><b>Customer Name</b></td>"+
                                "<td style=''><b>Complaint Date</b></td>"+
                                "<td style=''><b>Equipment Name</b></td>"+
                                "<td style=''><b>Equipment No</b></td>"+
                                "<td style=''><b>Description</b></td>"+
                                "<td style=''><b>Status</b></td>"+
                                "<td style=''><b>Assignee Name</b></td>"+
                                "<td style=''><b>Assigned Date</b></td>"+
                                "<td style=''><b>"+dynamicColumn+"</b></td>"+
                                "<td style=''><b>Closed Date</b></td>"+
                                "</tr>"+
                                "</thead>"+

                                "<tbody>";
                            data.idata.forEach(function (data) {
                                content +=

                                    "<tr>" +
                                    "<td style=''>" + data.ticketno + "</td>" +
                                    "<td style=''>" + data.customername + "</td>" +
                                    "<td style=''>" + data.complaintdate + "</td>" +
                                    "<td style=''>" + data.productservicename + "</td>" +
                                    "<td style=''>" + data.productsrno_accountno + "</td>" +
                                    "<td style=''>" + data.complaintdescription + "</td>" +
                                    "<td style=''>" + ((data.complaintstatus == "ACKNOWLEDGED") ? 'Received' : data.complaintstatus) + "</td>" +
                                    "<td style=''>" + data.assigneename + "</td>" +
                                    "<td style=''>" + data.callstartdate + "</td>" +
                                    "<td style=''>" + data.callenddate + "</td>" +
                                    "<td style=''>" + data.callclosuredate + "</td>" +
                                    "</tr>";

                                // N++;
                            });
                            "</tbody>";
                            content += "</table>";
                            content += "</br>";
                            $('#contentid').append(content);
                            $('#mytableid').DataTable({
                                "autoWidth": false
                                , "JQueryUI": true
                                , "ordering": true
                                , "paging": true
                                , "scrollCollapse": true
                                , "scrollX": true
                            });
                        }

                        else {
                            debugger
                            $('#contentid').empty();
                            content = "<td style='font-size: x-large; color: #FF0000; text-align: center' colspan='3' id='Data'>No Data Found!</td>";
                            $('#contentid').append(content);
                            // alert('There is No Data')
                        }
                        $('#loading').hide();
                    }
                })

            }
        })
    </script>
    <script type="text/javascript">
        debugger
        function GetReport() {
            if($("#todateid").val() == ""){
                $("#todateid").val($("#fromdateid").val());
            }
            if($("#fromdateid").val() !="" && $('#todateid').val() !="" || $('#complaintstatusid').val() !="" && $('#assigneeid').val() !="")
            {
                debugger;
                $('#loading').show();
                $.ajax({
                    order: [[ 5, "desc" ]],
                    processing: true,
                    url: '{{ url('/getReportdates/{data}') }}/',
                    type: "GET",
                    dataType: "json",
                    language: {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
                    data: {
                        fromdateid: $("#fromdateid").val(),
                        todateid: $('#todateid').val(),
                        complaintstatusid: $('#complaintstatusid').val(),
                        assigneesname : $('#assigneeid').val()
                    },
                    success: function (data) {
                        debugger
                        if(data.idata.length > 0) {
                            var ACKNOWLEDGED = "";
                            if ($('#assigneeid').val() != "") {
                                ACKNOWLEDGED = "Received : Not Applicable";
                            } else {
                                ACKNOWLEDGED = "Received :" + data.ACKNOWLEDGEDcount + "";
                            }
                            debugger
                            var dynamicColumn;
                            var dynamicData;
                            if($('#complaintstatusid').val() == 'PENDING'){
                                debugger
                                dynamicColumn = 'Pending Date'
                            }
                            else if($("#complaintstatusid").val() == 'NOT RESOLVED'){

                                dynamicColumn = 'Unresolved Date'
                            }
                            else{
                                dynamicColumn = 'Resolved Date'
                            }

                            $('#contentid').empty();
                            var content = "";
                            // var N = 1;
                            content+="<table id='mytableid' class='table table-striped table-bordered' width='100%'>" +
                                "<thead>"+
                                "<tr><td colspan='2'><b>Total Record : "+data.idata.length+" </b></td><td colspan='2'><b>"+ACKNOWLEDGED+"</b></td><td colspan='2'><b>Assigned : "+data.ASSIGNEDcount+" </b></h3></td><td colspan='2'><b>Resolved : "+data.RESOLVEDcount+" </b></td><td colspan='2'><b>Closed : "+data.CLOSEDcount+" </b></td></tr>"+
                                "<tr>" +
                                // "<td><b>#</b></td>"+
                                "<td style='width:120px;'><b>Ticket No</b></td>"+
                                "<td style='width:120px;'><b>Customer Name</b></td>"+
                                "<td style=''><b>Complaint Date</b></td>"+
                                "<td style=''><b>Equipment Name</b></td>"+
                                "<td style=''><b>Equipment No</b></td>"+
                                "<td style=''><b>Description</b></td>"+
                                "<td style=''><b>Status</b></td>"+
                                "<td style=''><b>Assignee Name</b></td>"+
                                "<td style=''><b>Assigned Date</b></td>"+
                                "<td style=''><b>"+dynamicColumn+"</b></td>"+
                                "<td style=''><b>Closed Date</b></td>"+
                                "</tr>"+
                                "</thead>"+

                                "<tbody>";
                            data.idata.forEach(function (data) {
                                content +=
                                    data.idata.forEach(function (data) {
                                        debugger;
                                        if($('#complaintstatusid').val() == "PENDING"){
                                            dynamicData = ""+data.pendingstatusdate+"";
                                        }
                                        else if($('#complaintstatusid').val()=='NOT RESOLVED'){
                                            dynamicData = ""+ data.unresolvestatusddate +"";
                                        }
                                        else{
                                            dynamicData = ""+data.callenddate+""
                                        }

                                    "<tr>" +
                                    "<td style=''>" + data.ticketno + "</td>" +
                                    "<td style=''>" + data.customername + "</td>" +
                                    "<td style=''>" + data.complaintdate + "</td>" +
                                    "<td style=''>" + data.productservicename + "</td>" +
                                    "<td style=''>" + data.productsrno_accountno + "</td>" +
                                    "<td style=''>" + data.complaintdescription + "</td>" +
                                    "<td style=''>" + ((data.complaintstatus == "ACKNOWLEDGED") ? 'Received' : data.complaintstatus) + "</td>" +
                                    "<td style=''>" + data.assigneename + "</td>" +
                                    "<td style=''>" + data.callstartdate + "</td>" +
                                    "<td style=''>" + data.callenddate + "</td>" +
                                    "<td style=''>" + data.callclosuredate + "</td>" +
                                    "</tr>";

                                // N++;
                            });
                            "</tbody>";
                            content += "</table>";
                            content += "</br>";
                            $('#contentid').append(content);
                            $('#mytableid').DataTable({
                                "autoWidth": false
                                , "JQueryUI": true
                                , "ordering": true
                                , "paging": true
                                , "scrollCollapse": true
                                , "scrollX": true
                            });
                        };

                        else {
                            debugger
                            $('#contentid').empty();
                            content = "<div style='font-size: x-large; color: #FF0000; text-align: center'>No Data Found!</div>";
                            $('#contentid').append(content);
                            // alert('There is No Data')
                        }
                        $('#loading').hide();
                    }
                })

            }
        }
    </script>
    <script>
        $(document).ready(function() {
            document.getElementById("mySidebar").style.display = "block";
        });
        function w3_open(){
            document.getElementById("mySidebar").style.display = "block";
        }
        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
        }
    </script>
    <script type="text/javascript">
        $("#btnpdfid").click(function () {
            fromdateid= $("#fromdateid").val(),
                todateid= $('#todateid').val(),
                complaintstatusid= $('#complaintstatusid').val(),
                assigneesname= $('#assigneeid').val();
            var data= [
                fromdateid,todateid,complaintstatusid,assigneesname,
            ];
            window.location.href ="{{URL::to('getreports/pdf/')}}/" + data;
        });
    </script>

@endsection