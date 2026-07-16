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
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Customer Wise Report </h3>

        </div>
        <div id="loading" style="margin-top:150px;margin-left:350px;">
            <img id="loading-image" src="{{asset('img/throbber.gif')}}" alt="Loading..." />
        </div>
    <div class="panel panel-default" >
        <div class="panel-body" id="contentid">
        </div>
    </div>
    </div>
@endsection
<script type="text/javascript" src="{{ asset('js/jquery-3.1.1.js') }}"></script>
<script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
<script src="{{asset('datatable/js/jquery.dataTables.min.js')}}" defer></script>
<script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}" defer></script>
<script type="text/javascript">
    $(document).ready(function(){
            $('#loading').show();
            debugger
            $.ajax({
                order: [[ 10, "desc" ]],
                processing: true,
                url: '{{ url('/getcustomerwisedata/') }}/',
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
                            "<td style=''><b>No. of PC</b></td>"+
                            "<td style=''><b>No. of Printer</b></td>"+
                            "<td style=''><b>No. of Scanner</b></td>"+
                            "<td style=''><b>No. of Server</b></td>"+
                            "</tr>"+
                            "</thead>"+

                            "<tbody>";
                        data.idata.forEach(function (data) {
                            content +=

                                "<tr>" +
                                "<td style=''>" + data.contractno + "</td>" +
                                "<td style=''>" + data.customername + "</td>" +
                                "<td style=''>" + ((data.pcCount == null) ? '-' : data.pcCount) + "</td>" +
                                "<td style=''>" + ((data.printerCount == null) ? '-' : data.printerCount) + "</td>" +
                                "<td style=''>" + ((data.scannerCount == null) ? '-' : data.scannerCount) + "</td>" +
                                "<td style=''>" + ((data.serverCount == null) ? '-' : data.serverCount) + "</td>" +
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