@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')
    <link href="{{ asset('css/dataTable.css') }}" rel="stylesheet">
    <div class="card">
        <div class="card-block">
            <div class="col-md-12 row">
                <div class="col-md-6"><h3 class="card-subtitle text-muted mt-2">Complainee Department Master</h3></div>

                <div class="col-md-2">

                </div>

                <div class="col-md-4">
                    <a class="btn btn-outline-secondary" href="{{ route('complaineedepartment.create') }}" style="color:gray;"> <b>Add
                            New Complainee Department</b> </a>
                </div>

            </div>

        </div>
    </div>



    <div class="card mt-2 table-responsive">
        <div class="card-block">
            <div class="col-md-12">
                <table class="table table-sm table-hover" id="complaineedepartment">
                    <thead>
                    <th>#</th>
                    <th>complainee Code</th>
                    <th>Product Service Name</th>
                    <th>Category Name</th>
                    <th>Subcategory Name</th>
                    <th>Department Name</th>
                    <th>Maxdays</th>

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
            $('#complaineedepartment').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": "{{ url('appadmin/allcomplaineedepartment') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                "columns": [
                    { "data": "id" },
                    { "data": "complaineedepartmentmastercode" },
                    { "data": "productservicename" },
                    { "data": "categoryname" },
                    { "data": "subcategoryname" },
                    { "data": "departmentname" },
                    { "data": "maxdays",orderable:false },
                    { "data": "options",orderable:false }
                ]
            });
        });
    </script>



    {{--<div class="card mt-2 table-responsive">--}}
        {{--<div class="card-block">--}}
            {{--<div class="col-md-12 row">--}}
                {{--<table class="table table-sm table-hover">--}}
                    {{--<thead>--}}
                    {{--<tr class="text-muted">--}}
                        {{--<th>#</th>--}}
                        {{--<th>Complainee Department Code</th>--}}
                        {{--<th>Product Service Name</th>--}}
                        {{--<th>Category Name</th>--}}
                        {{--<th>Subcategory Name</th>--}}
                        {{--<th>Maxdays</th>--}}
                        {{--<th>Department Name</th>--}}
                        {{--<th>Created At</th>--}}
                        {{--<th>Updated At</th>--}}
                        {{--<th>Action</th>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}
                    {{--@foreach($complaineedepartment as $key => $complaineedepartment)--}}
                        {{--<tr>--}}
                            {{--<th scope="row">{{$key+1}}</th>--}}
                            {{--<td>{{ $complaineedepartment->complaineedepartmentmastercode }}</td>--}}
                            {{--<td>{{ $complaineedepartment->productservicecode }}</td>--}}
                            {{--<td>{{ $complaineedepartment->categorycode }}</td>--}}
                            {{--<td>{{ $complaineedepartment->subcategorycode }}</td>--}}
                            {{--<td>{{ $complaineedepartment->maxdays }}</td>--}}
                            {{--<td>{{ $complaineedepartment->departmentcode }}</td>--}}
                            {{--<td>{{ is_null($complaineedepartment->created_at) ? '' : $complaineedepartment->created_at->format('d-m-Y') }}</td>--}}
                            {{--<td>{{ is_null($complaineedepartment->updated_at) ? '' : $complaineedepartment->updated_at->format('d-m-Y') }}</td>--}}
                            {{--<td>--}}
                                {{--<a href="{{ route('complaineedepartment.show', $complaineedepartment->complaineedepartmentmastercode) }}" style="margin-right: 3px;">view</a>--}}
                                {{--<a href="{{ route('complaineedepartment.edit', $complaineedepartment->complaineedepartmentmastercode) }}" style="margin-right: 3px;">edit</a> |--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                    {{--@endforeach--}}
                    {{--</tbody>--}}
                {{--</table>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}


@endsection
	
	