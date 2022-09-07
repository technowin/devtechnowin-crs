@extends('layouts.appnew')

@section('pageTitle', 'User Lodged Complaints')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="panel panel-default">
        {{ Form::hidden('hidden', '13', array('id'=>'hiddenid')) }}
        <div class="panel-heading"><h3 class="panel-title"><span class="text-muted">All Lodged Complaints</span></h3>
        </div>
        <div class="panel-body">
{{--            <div style="padding-right: 1000px; "> <a class="btn btn-outline-secondary"  href="{{ URL::to('excel') }}" style="color:gray; float: right"> <b>PDF</b> </a>--}}
            <div style="padding-right: 1000px; "> <a class="btn btn-outline-secondary"  id="convertpdfid" style="color:gray; float: right"> <b>PDF</b></a>
            </div>
            <table id="allcomplaints" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr class="text-muted">
                    <th>#</th>
                    <th>Ticket No</th>
                    <th>Customer Name</th>
                    <th>Customer Site</th>
                    <th>Complaint Description</th>
                    <th>Complaint Date</th>
                    <th>Complaint Status</th>
                    <th>Closure Comment</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('selectize-script')

    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            debugger
            $('#allcomplaints').DataTable({
                "order": [[ 5, "desc" ]],
                "processing": true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
                "serverSide": true,
                "ajax":{
                    "url": "{{ url('/allcomplaints') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                "columns": [
                    { "data": "id", "orderable": false },
                    { "data": "ticketno",orderable:false },
                    { "data": "customercode"},
                    { "data": "branchcode"},
                    { "data": "complaintdescription",orderable:false},
                    { "data": "complaintdate"},
                    { "data": "complaintstatus",orderable:false},
                    { "data": "closurecomment",orderable:false},
                    { "data": "viewurl","render":function(data, type, row,meta ){
                            return '<a href="' + data + '">view</a>';
                        //           return '<a href="/getallstatusshowpage/view/'+data+'">view</a>';
                        }}

                ]
            });
        });
    </script>

@endsection