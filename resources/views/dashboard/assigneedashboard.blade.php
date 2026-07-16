@extends('layouts.appnew')
@section('content')
    <style>
        th, td {
            padding: 5px;
            text-align: center;
        }
    </style>
    <table class="table-bordered table-striped col-lg-12" id="table">
        <thead>
        <th>New Complaint</th>
        <th>Pending Complaint</th>
        <th>Not-Resolved Complaint</th>
        <th>Resolved Complaint</th>
        <th>Closed Complaint</th>
        </thead>
        <tbody>
        <td>{{ Form::label($newComplaint) }}</td>
        <td>{{ Form::label($pendingComplaint) }}</td>
        <td>{{ Form::label($notResolvedComplaint) }}</td>
        <td>{{ Form::label($resolvedComplaint) }}</td>
        <td>{{ Form::label($closedComplaints) }}</td>
        </tbody>
    </table>

@endsection

@section('page-script')

    <script type="text/javascript">
        $(document).ready(function () {
            window.setTimeout(function () {
                $(".alert").fadeTo(1500, 0).slideUp(500, function () {
                    $(this).remove();
                });
            }, 5000);
        });
    </script>
@stop
