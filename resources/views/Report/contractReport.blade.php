@extends('layouts.appnew')

@section('pageTitle', 'Complaints')

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
    #getDataId{
        margin-top: 20px;
        margin-left: 40px;
    }
    /*.float-button {*/
    /*    position: fixed;*/

    /*}*/
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:after {
        right: 10px !important;
        position:static;
    }
    td,th{
        font-size: 14px;
    }


</style>
@section('content')
    <div class="w3-sidebar" style="display:none; overflow:auto; max-width: 300px; color: #fff; width: 100%;" id="mySidebar">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Get Report</h3>
                <button onclick="w3_close()" class="w3-button fa fa-close"></button>
                <a class="btn btn-outline-secondary"  onclick="excel()" id="btnexcelid" style="color:gray; float: right"><i class="fa fa-file-excel-o"><b> Excel</b></i></a>
            </div>
            <div class="panel-body">
                <label for="input" class="col-sm-12 text-muted">Customer</label>
                <div class="col-md-12">
                    {{ Form::select('customers', $customers, null, array('placeholder' => '--SELECT--', 'id' => 'customers', 'onchange' => 'getBranch()')) }}
                    @if ($errors->has('customers'))
                        <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                    @endif
                </div>
                <label for="input" class="col-sm-12 text-muted">Department</label>
                <div class="col-md-12">
                    {{ Form::select('department',array(null => '--SELECT--'),null, array('id' => 'departmentid')) }}
                    @if ($errors->has('department'))
                        <span class="help-block"><strong>{{ $errors->first('department') }}</strong></span>
                    @endif
                </div>
                <label for="input" class="col-sm-12 text-muted">Category</label>
                <div class="col-md-12">
                    {{ Form::select('productservicecode', $productlist,null, array('placeholder' => '--SELECT--','id' => 'equipmentid','class' => 'selectize')) }}
                </div>
                <label for="input" class="col-sm-12 text-muted">Work Order Type</label>
                <div class="col-md-12">
                    {{ Form::select('workordertype',array(''=>'--SELECT--','Software development'=>'Software development','Hardware AMC'=>'Hardware AMC','Software Maintenance'=>'Software Maintenance & Suppprt','Hardware Warranty'=>'Hardware Warranty','Hardware Supply'=>'Hardware Supply','Scanning'=>'Scanning','Data Entry'=>'Data Entry','Manpower Supply'=>'Manpower Supply'),null, array('' => '--SELECT--','id' => 'workordertypeid')) }}
                    @if ($errors->has('workordertype'))
                        <span class="help-block"><strong>{{ $errors->first('workordertype') }}</strong></span>
                    @endif
                </div>
                <label for="input" class="col-sm-12 text-muted">From Date</label>
                <div class="col-md-12">
                    {{ Form::date('fromdate',null, array('class'=> 'form-control','id'=>'fromdateid')) }}
                </div>
                <label for="input" class="col-sm-12 text-muted">To Date</label>
                <div class="col-md-12">
                    {{ Form::date('todate', null, array('class' => 'form-control','id'=>'todateid')) }}
                </div>
                <div class="col-md-12">
                    <label for="input" class="col-md-12"><button class="btn btn-primary" id="getDataId" onclick="GetReport();return false;" onmouseup="w3_close()" onmousedown="checkDate()">Get Data</button></label>
                </div>
            </div>
        </div>
    </div>
    <div id="loading" style="margin-top:150px;margin-left:350px;">
        <img id="loading-image" src="{{asset('img/throbber.gif')}}" alt="Loading..." />
    </div>
    <div>
        <button class="btn btn-primary btn-sm fa fa-filter" onclick="w3_open()" id="filtericon"  style=" margin-left: 8px;">Filter</button>
    </div>
    <div class="panel panel-default" >
        <div class="panel-body" id="contentid">
        </div>
    </div>
@endsection
<script type="text/javascript" src="{{ asset('js/jquery-3.1.1.js') }}"></script>
<script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
<script src="{{asset('datatable/js/jquery.dataTables.min.js')}}" defer></script>
<script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}" defer></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#loading').hide();
        $('#customers').selectize({
            maxItems: 1
        });
        $('#departmentid').selectize({
            maxItems: 1
        });
        $('#equipmentid').selectize({
            maxItems: 1
        });
        $('#workordertypeid').selectize({
            maxItems: 1
        });
    });
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
    $(document).ready(function(){
            $('#loading').show();
            debugger
            $.ajax({
                order: [[ 10, "desc" ]],
                processing: true,
                url: '{{ url('/getcontractdata/') }}/',
                type: "GET",
                dataType: "json",
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
                success: function (data) {
                    debugger
                    if(data.idata.length > 0) {
                        $('#contentid').empty();
                        var content = "";
                        // var N = 1;
                        content+="<table id='mytableid' class='table table-striped table-bordered' width='100%'>" +
                            "<thead>"+
                            "<tr>" +
                            // "<td><b>#</b></td>"+
                            "<td style=''><b>Contract No</b></td>"+
                            "<td style=''><b>Customer Name</b></td>"+
                            "<td style=''><b>Department</b></td>"+
                            "<td style=''><b>No. of PC</b></td>"+
                            "<td style=''><b>No. of Printer</b></td>"+
                            "<td style=''><b>No. of Scanner</b></td>"+
                            "<td style=''><b>No. of Server</b></td>"+
                            "<td style=''><b>Workorder No</b></td>"+
                            "<td style=''><b>Workorder Type</b></td>"+
                            "<td style=''><b>Contract From Date</b></td>"+
                            "<td style=''><b>Contract To Date</b></td>"+
                            "<td style=''><b>Year Value</b></td>"+
                            "<td style=''><b>Month Value</b></td>"+
                            "<td style=''><b>Total Cost</b></td>"+
                            "<td style=''><b>Contract Period</b></td>"+
                            "</tr>"+
                            "</thead>"+

                            "<tbody>";
                        data.idata.forEach(function (data) {
                            content +=

                                "<tr>" +
                                "<td style=''>" + data.contractno + "</td>" +
                                "<td style=''>" + data.customername + "</td>" +
                                "<td style=''>" + ((data.branchname == null) ? '-' : data.branchname) + "</td>" +
                                "<td style=''>" + ((data.pcCount == null) ? '-' : data.pcCount) + "</td>" +
                                "<td style=''>" + ((data.printerCount == null) ? '-' : data.printerCount) + "</td>" +
                                "<td style=''>" + ((data.scannerCount == null) ? '-' : data.scannerCount) + "</td>" +
                                "<td style=''>" + ((data.serverCount == null) ? '-' : data.serverCount) + "</td>" +
                                "<td style=''>" + data.workorderno + "</td>" +
                                "<td style=''>" + data.workordertype + "</td>" +
                                "<td style=''>" + data.contractfromdate + "</td>" +
                                "<td style=''>" + data.contracttodate + "</td>" +
                                "<td style=''>" + ((data.yearsvalue == null) ? '-' : data.yearsvalue) + "</td>" +
                                "<td style=''>" + ((data.monthvalue == null) ? '-' : data.monthvalue) + "</td>" +
                                "<td style=''>" + ((data.totalcost == null) ? '-' : data.totalcost)+ "</td>" +
                                "<td style=''>" + ((data.contractperiod == null ) ? '-' : data.contractperiod) + "</td>" +
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
                        content = "<div style='font-size: x-large; color: #FF0000; text-align: center'>No Data Found!</div>";
                        $('#contentid').append(content);
                        // alert('There is No Data')
                    }
                    $('#loading').hide();
                }
            })

        }
    )
</script>
<script type="text/javascript">
    function checkDate(){
        var todate = $('#todateid').val();
        if($('#fromdateid').val() != "" && $('#todateid').val() == ""){
            alert('Select To Date');
            return false;
        }
        else{
            return true;
        }
    }
</script>
<script type="text/javascript">
    $('#todateid').change(function(){
        if($("#fromdateid").val() >  $('#todateid').val()){
            alert('To Date Should not be less than From Date');
            $("#todateid").val('');
            return false;
        }
        else{
            return true;
        }
    });
</script>
<script type="text/javascript">
    function getBranch(){
        var branchlist = [];
        if ($('#customers').val() !== "") {
            $.ajax({
                url: "{{URL::to('getbranchscustomerwise/')}}/" + $('#customers').val(),
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $.each(data, function (key, value) {
                        branchlist.push({
                            text: value['branchname'],
                            value: value['branchcode'],
                        })
                    });
                    $('#departmentid').selectize()[0].selectize.destroy();
                    if (branchlist.length > 0) {
                        $('#departmentid').selectize({
                            maxItems: 1,
                            valueField: 'value',
                            labelField: 'text',
                            searchField: 'text',
                            create: false,
                            sortField: {
                                field: 'text',
                                direction: 'asc'
                            },
                            options: branchlist,

                        });
                    } else {
                        $('#departmentid').selectize({
                            options: null
                        });

                    }
                }
            });
        }
        else {

            $('#departmentid').selectize()[0].selectize.destroy();
            $('#departmentid').selectize({
                options: null
            });
        }
    }
</script>
<script type="text/javascript">
    function GetReport() {
        debugger
        var customers = $('#customers').val();
        var departmentid = $('#departmentid').val();
        var equipment = $('#equipmentid').val();
        var fromdateid = $('#fromdateid').val();
        var equipment = $('#equipmentid').val();
        var todateid = $('#todateid').val();
        if ($('#customers').val() != "" || $('#departmentid').val() != "" || $('#equipmentid').val() != "" || $('#workordertypeid').val() != "" || $('#fromdateid').val() != "" || $('#todateid').val() != "") {
            $('#loading').show();
            debugger
            $.ajax({
                processing: true,
                url: '{{ url('/getcontractfilters/{data}') }}/',
                type: "GET",
                dataType: "json",
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                },
                data: {
                    customers: $('#customers').val(),
                    departmentid: $('#departmentid').val(),
                    equipmentid: $('#equipmentid').val(),
                    workordertypeid: $('#workordertypeid').val(),
                    fromdateid: $("#fromdateid").val(),
                    todateid: $('#todateid').val(),
                },
                success: function (data) {
                    debugger;
                    if (data.idata.length > 0) {
                        $('#contentid').empty();
                        var content = "";
                        // var N = 1;
                        content += "<table id='mytableid' class='table table-striped table-bordered' width='100%'>" +
                            "<thead>" +
                            "<tr>" +
                            // "<td><b>#</b></td>"+
                            "<td style=''><b>Contract No</b></td>" +
                            "<td style=''><b>Customer Name</b></td>" +
                            "<td style=''><b>Department</b></td>" +
                            "<td style=''><b>No. of PC</b></td>" +
                            "<td style=''><b>No. of Printer</b></td>" +
                            "<td style=''><b>No. of Scanner</b></td>" +
                            "<td style=''><b>No. of Server</b></td>" +
                            "<td style=''><b>Workorder No</b></td>" +
                            "<td style=''><b>Workorder Type</b></td>" +
                            "<td style=''><b>Contract From Date</b></td>" +
                            "<td style=''><b>Contract To Date</b></td>" +
                            "<td style=''><b>Year Value</b></td>"+
                            "<td style=''><b>Month Value</b></td>"+
                            "<td style=''><b>Total Cost</b></td>"+
                            "<td style=''><b>Contract Period</b></td>"+
                            "</tr>" +
                            "</thead>" +

                            "<tbody>";
                        data.idata.forEach(function (data) {
                            content +=

                                "<tr>" +
                                "<td style=''>" + data.contractno + "</td>" +
                                "<td style=''>" + data.customername + "</td>" +
                                "<td style=''>" + ((data.branchname == null) ? '-' : data.branchname) + "</td>" +
                                "<td style=''>" + ((data.pcCount == null) ? '-' : data.pcCount) + "</td>" +
                                "<td style=''>" + ((data.printerCount == null) ? '-' : data.printerCount) + "</td>" +
                                "<td style=''>" + ((data.scannerCount == null) ? '-' : data.scannerCount) + "</td>" +
                                "<td style=''>" + ((data.serverCount == null) ? '-' : data.serverCount) + "</td>" +
                                "<td style=''>" + data.workorderno + "</td>" +
                                "<td style=''>" + data.workordertype + "</td>" +
                                "<td style=''>" + data.contractfromdate + "</td>" +
                                "<td style=''>" + data.contracttodate + "</td>" +
                                "<td style=''>" + ((data.yearsvalue == null) ? '-' : data.yearsvalue) + "</td>" +
                                "<td style=''>" + ((data.monthvalue == null) ? '-' : data.monthvalue) + "</td>" +
                                "<td style=''>" + ((data.totalcost == null) ? '-' : data.totalcost)+ "</td>" +
                                "<td style=''>" + ((data.contractperiod == null ) ? '-' : data.contractperiod) + "</td>" +
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
                    } else {
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
<script type="text/javascript">
    function excel() {
        debugger
        customers= $('#customers').val(),
            departmentid= $('#departmentid').val(),
            equipmentid= $('#equipmentid').val(),
            workordertypeid= $('#workordertypeid').val(),
            fromdateid= $("#fromdateid").val(),
            todateid= $('#todateid').val();
        var data= [
            customers,departmentid,equipmentid,workordertypeid,fromdateid,todateid,
        ];
        window.location.href ="{{URL::to('contractreport/excel/')}}/" + data;
    }
</script>

