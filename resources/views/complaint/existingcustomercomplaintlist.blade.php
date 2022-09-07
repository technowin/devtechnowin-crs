@extends('layouts.app')
@section('pageTitle', 'Existing Customer Complaints')
@section('content')
    @if (session('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif
    @if (session('error-message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{session('error-message')}}
        </div>
    @endif
    <div class="card">
        <div class="card-body table-responsive">
            @if(isset($complaints))
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
                    @foreach($complaints as $key => $value)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$value->ticketno}}</td>
                            <td>{{$value->customercode}}</td>
                            <td>{{$value->complaintdescription}}</td>
                            <td>{{ is_null($value->created_at) ? '' : $value->created_at->format('m-d-Y') }}</td>
                            <td>
                                <a href="{{ URL::to('adminaccess/registration/existingcustomercomplaintview/' . $value->ticketno) }}" style="margin-right: 3px;">view</a> |
                                <a href="{{ URL::to('adminaccess/registration/assigncomplaint/' . $value->ticketno) }}" style="margin-right: 3px;">manage</a> |
                                <a href="{{ URL::to('adminaccess/registration/edit/' . $value->ticketno) }}" style="margin-right: 3px;">edit</a>
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