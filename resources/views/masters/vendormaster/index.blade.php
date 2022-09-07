@extends('layouts.app')

@section('pageTitle', 'Sectors')

@section('content')

    <link href="{{ asset('css/dataTable.css') }}" rel="stylesheet">

    <div class="card">
        <div class="card-block">
            <div class="col-md-12 row">
                <div class="col-md-6"><h3 class="card-subtitle text-muted mt-2">Vendor Master</h3></div>

                <div class="col-md-2">

                </div>
                <div class="col-md-2">

                </div>
                <div class="col-md-2">
                    <a class="btn btn-outline-secondary" href="{{ route('vendor.create') }}" style="color:gray;"> <b>Add
                            New Vendor</b> </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-2 table-responsive">
        <div class="card-block">
            <div class="col-md-12">
                <table class="table table-sm table-hover" id="sectors">
                    <thead>
                    <th width="5%">#</th>
                    <th width="10%">Vendor Code</th>
                    <th>Vendor Name</th>
                    <th>Vendor Phone No</th>
                    <th>Vendor Email</th>
                    <th>Vendor Fax</th>
                    <th width="10%">Action</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@section('script-js')
    <script type="text/javascript" src="{{ asset('js/jquery-1.12.4.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#sectors').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ url('/allvendor') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                "columns": [
                    { "data": "id" },
                    { "data": "vendorcode" },
                    { "data": "vendorname" },
                    { "data": "vendorphoneno" },
                    { "data": "vendoremail" },
                    { "data": "vendorfax" },
                    { "data": "options",orderable:false}
                ]
            });
        });
    </script>


@endsection
@endsection