@extends('layouts.appnew')

@section('pageTitle', 'User Lodged Complaints')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12 row">
            <div class="col-md-10"><h6>Customer Master</h6></div>
            <div class="col-md-2">
                {{--<a class="btn btn-blue" data-toggle="modal" data-target=".bs-example-modal-lg"><b>Add New--}}
                {{--Customer</b></a>--}}
                <a class="btn btn-outline-secondary" href="{{ URL::to('saleslead/addnewlead') }}" style="color:gray;"> <b>Add
                        New Lead</b> </a>
            </div>
        </div>
    </div>
</div>
    {{--<div class="card">--}}
        {{--<div class="card-block">--}}
            {{--<div class="col-md-12 row">--}}
                {{--<div class="col-md-6"><h3 class="card-subtitle text-muted mt-2">Sales Leads</h3></div>--}}

                {{--<div class="col-md-2">--}}

                {{--</div>--}}
                {{--<div class="col-md-2">--}}

                {{--</div>--}}
                {{--<div class="col-md-2">--}}
                    {{--<a class="btn btn-outline-secondary" href="{{ URL::to('saleslead/addnewlead') }}" style="color:gray;"> <b>Add--}}
                            {{--New Lead</b> </a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="card mt-2 table-responsive">--}}
        {{--<div class="card-block">--}}
            {{--<div class="col-md-12">--}}
                {{--<table class="table table-sm table-hover" id="sectors">--}}
                    {{--<thead>--}}
                    {{--<th width="5%">#</th>--}}
                    {{--<th width="10%">Customer Name</th>--}}
                    {{--<th>Customer Mobile No.</th>--}}
                    {{--<th>Customer Email</th>--}}
                    {{--<th>Meeting Date</th>--}}
                    {{--<th class="no-sort">Order Received</th>--}}
                    {{--<th width="10%">Action</th>--}}
                    {{--</thead>--}}
                {{--</table>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <table id="allcomplaints" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr class="text-muted">
                    <th>#</th>
                    <th width="10%">Customer Name</th>
                    <th>Customer Mobile No.</th>
                    <th>Customer Email</th>
                    <th>Meeting Date</th>
                    <th class="no-sort">Order Received</th>
                    <th width="10%">Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script-js')
    <script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#sectors').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ url('/allsaleslead') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                "columns": [
                    { "data": "id", "orderable": false },
                    { "data": "customername" },
                    { "data": "customermobileno" },
                    { "data": "customeremail" },
                    { "data": "meetingdate" },
                    { "data": "orderreceived" , "orderable": false },
                    { "data": "options" , "orderable": false }
                ]
            });
        });
    </script>
@endsection
