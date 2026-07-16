@extends('layouts.appnew')

@section('pageTitle', 'User Lodged Complaints')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title"><span class="text-muted">User Lodged Complaints</span></h3>
        </div>
        <div class="panel-body">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr class="text-muted">
                    {{--<th>#</th>--}}
                    <th>Ticket No</th>
                    <th>Complaint Description</th>
                    <th>Complaint Date</th>
                    <th>Complaint Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($complaints as $key => $complaint)
                    <tr>
                        {{--<th scope="row">{{$key+1}}</th>--}}
                        <td>{{ $complaint->ticketno }}</td>
                        <td>{{ $complaint->complaintdescription }}</td>
                        <td>{{ $complaint->complaintdate }}</td>
                        <td>{{ $complaint->complaintstatus }}</td>
                        <td>
                            <a href="{{ url('/registration/manageusernewcomplaint/'.$complaint->ticketno) }}">manage</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('selectize-script')
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "order": [[ 2, "desc" ]],
            });
        });
    </script>
@endsection