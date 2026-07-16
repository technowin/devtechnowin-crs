@extends('layouts.app')
@section('title', '| Customer Complaint List')
@section('content')

    <div class="card">
        <div class="card-block table-responsive">
            @if(isset($tblusercomplaintlodging))
                <table class="table table-sm table-hover">
                    <thead>
                    <tr class="text-muted">
                        <th>#</th>
                        <th>ticketno</th>
                        <th>customertype</th>
                        <th>customername</th>
                        <th>complaintdescription</th>
                        <th>created_at</th>
                        <th>action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tblusercomplaintlodging as $key => $value)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$value->ticketno}}</td>
                            <td>{{$value->customertype}}</td>
                            <td>{{$value->customername}}</td>
                            <td>{{$value->complaintdescription}}</td>
                            <td>{{$value->created_at->format('F d, Y h:ia') }}</td>
                            <td>
                                <a href="{{ route('users.edit', $value->usercomplaintlodgingid) }}" style="margin-right: 3px;">view</a> |
                                <a href="{{ route('users.edit', $value->usercomplaintlodgingid) }}" style="margin-right: 3px;">edit</a> |
                                <a href="{{ route('users.edit', $value->usercomplaintlodgingid) }}" style="margin-right: 3px;">delete</a>
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