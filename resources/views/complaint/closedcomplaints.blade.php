@extends('layouts.appnew')

@section('pageTitle', 'Closed Complaints')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="col-md-12 card">
        <div class="card-body table-responsive">
            <h4 class="text-muted">Closed Complaints</h4>
            <hr/>
            <table class="table table-sm table-hover" id="closedcomplaintstable" width="100%">
                <thead>
                <tr class="text-muted">
                    <th>#</th>
                    <th>Ticketno</th>
                    <th>Customer Type</th>
                    <th>Customer Name</th>
                    <th>Complaint Description</th>
                    <th>Complaint Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                @foreach($closedcomplaints as $key => $closedcomplaint)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{ $closedcomplaint->ticketno }}</td>
                        <td>{{ $closedcomplaint->customercode }}</td>
                        <td>{{ $closedcomplaint->customercode }}</td>
                        <td>{{ $closedcomplaint->complaintdescription }}</td>
                        <td>{{ $closedcomplaint->created_at }}</td>
                        <td>
                            <a href="{{ url('/complaints/view/'.$closedcomplaint->id) }}">view</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
@section('selectize-script')
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#closedcomplaintstable').DataTable();
        });
    </script>
@endsection