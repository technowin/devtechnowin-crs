@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')
    <link href="{{ asset('css/dataTable.css') }}" rel="stylesheet">
    <div class="card">
        <div class="card-block">
            <div class="col-md-12 row">
                <div class="col-md-6"><h3 class="card-subtitle text-muted mt-2">Department Master</h3></div>

                <div class="col-md-2">

                </div>
                <div class="col-md-2">

                </div>
                <div class="col-md-2">
                    <a class="btn btn-outline-secondary" href="{{ route('department.create') }}" style="color:gray;"> <b>Add
                            New Deparment</b> </a>
                </div>

            </div>

        </div>
    </div>


    <div class="card mt-2 table-responsive">
        <div class="card-block">
            <div class="col-md-12">
                <table class="table table-sm table-hover" id="department">
                    <thead>
                    <th>#</th>
                    <th>Department Code</th>
                    <th>Sector Name</th>
                    <th>Department Name</th>
                    <th>Department Description</th>
                    {{--<th>Created At</th>--}}
                    {{--<th>Updated At</th>--}}
                    <th>Action</th>
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
            $('#department').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ url('appadmin/alldepartment') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                "columns": [
                    { "data": "id" },
                    { "data": "departmentcode" },
                    { "data": "sectorname" },
                    { "data": "departmentname" },
                    { "data": "departmentdescription",orderable:false },
                    { "data": "options",orderable:false }
                ]
            });
        });
    </script>



@endsection
	