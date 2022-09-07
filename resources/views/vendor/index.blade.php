@extends('layouts.appnew')

@section('page-title', '| Customer Master')

@section('content')
@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection
<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12 row">
            <div class="col-md-10"><h6>OEM Complaints</h6></div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body table-responsive">
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr class="text-muted">
                {{--<th>#</th>--}}
                <th>Ticketno</th>
                <th>Customer Name	</th>
                {{--                            <th>Branch Name	</th>--}}
                <th>Product Sr No</th>
                <th>Complaint Description</th>
                <th>Caller Name</th>
                <th>Assignee Name</th>
                <th>Assignee Start Date</th>
                <th>Assignee Status</th>
                <th>Complaint Date</th>
                <th>Ticket Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($complaints as $key => $complaint)
                <tr>
                    <td>{{ $complaint->ticketno }}</td>
                    <td>{{ $complaint->customername }}</td>
                    <td>{{ $complaint->productsrno_accountno }}</td>
                    <td>{{ $complaint->complaintdescription }}</td>
                    <td>{{ $complaint->callername }}</td>
                    <td>{{ $complaint->assigneename }}</td>
                    {{--                                <td>{{ $assignedcomplaint->assigneestartdate }}</td>--}}
                    <td>{{ \Carbon\Carbon::parse($complaint->assigneestartdate)->format('d/m/Y h:i:s') }}</td>
                    <td>{{ $complaint->assigneestatus }}</td>
                    <td>{{ \Carbon\Carbon::parse($complaint->complaintdate)->format('d/m/Y h:i:s') }}</td>
                    <td>{{ $complaint->complaintstatus }}</td>
                    <td>
                            <a  href="{{ url('editvendor/'.$complaint->id) }}">edit</a> |
                            <a  href="{{ url('registration/edit/'.$complaint->assigneecode.'/'.$complaint->ticketno) }}">view</a>|
{{--                            <a  href="{{ url('registrationreassigne/edit/'.$complaint->assigneecode.'/'.$complaint->ticketno) }}">re-assign</a>|--}}
                            <a  href="{{ url('addcommentvendor/'.$complaint->ticketno) }}">comment</a> |
                            <a href="{{ url('closevendorcomplaint/'.$complaint->ticketno) }}">resolve</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{--{{ $contracts->links() }}--}}
    </div>
</div>
@endsection

@section('page-script')
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            var table = $('#example').DataTable({
            });
        });

    </script>


@stop
