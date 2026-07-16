@extends('layouts.app')
@section('pageTitle', 'Non-Existing Customer Complaints')
@section('content')
    <div class="card">
        <div class="card-body table-responsive">
            @if(isset($nonexistingcustomercomplaints))
                <table class="table table-sm table-hover">
                    <thead>
                    <tr class="text-muted">
                        <th>#</th>
                        <th>Ticketno</th>
                        <th>Customer Name</th>
                        <th>Complaint Description</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($nonexistingcustomercomplaints as $key => $value)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$value->ticketno}}</td>
                            <td>{{$value->customercode}}</td>
                            <td>{{$value->complaintdescription}}</td>
                            <td>{{ is_null($value->created_at) ? '' : $value->created_at->format('m-d-Y') }}</td>
                            <td>
                                <a href="{{ route('users.edit', $value->ticketno) }}"
                                   style="margin-right: 3px;">view</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('js/jquery-3.1.1.js') }}"></script>
@endsection