@extends('layouts.appnew')

@section('pageTitle', 'User Lodged Complaints')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

@section('content')

    @if (session('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif

    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title"><span class="text-muted">All Lodged Complaints</span></h3>
        </div>
        <div class="panel-body">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr class="text-muted">
                    {{--<th>#</th>--}}
                    {{--<th>Assignee Code</th>--}}
                    <th>Assignee Name</th>
                    <th>Department Name</th>
                    <th>Employee Name</th>
                    <th>Mobile No</th>
                    <th>Email</th>
                    {{--<th>Labour Cost</th>--}}
                    <th>Is Active</th>
                    {{--<th>created_at</th>--}}
                    {{--<th>updated_at</th>--}}
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($assignees as $key => $assignee)
                    <tr>
                        {{--<th scope="row">{{$key+1}}</th>--}}
                        {{--<td>{{ $assignee->assigneecode }}</td>--}}
                        <td>{{ $assignee->assigneename }}</td>
                        <td>{{ $assignee->department->departmentname }}</td>
                        <td>{{ $assignee->employee->employeename or "NA" }}</td>
                        <td>{{ $assignee->mobileno }}</td>
                        <td>{{ $assignee->emailid }}</td>
                        {{--<td>{{ $assignee->labourcost }}</td>--}}
                        <td>{{ $assignee->isactive == 1 ? "Yes" : "No" }}</td>
                        {{--<td>{{ is_null($assignee->created_at) ? '' : $assignee->created_at->format('m-d-Y') }}</td>--}}
                        {{--<td>{{ is_null($assignee->updated_at) ? '' : $assignee->updated_at->format('m-d-Y') }}</td>--}}
                        <td>
                            <a href="{{ url('restoreassignee',$assignee->assigneecode) }}">Restore</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $assignees->links() }}
        </div>
    </div>
@endsection

@section('selectize-script')
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
@endsection