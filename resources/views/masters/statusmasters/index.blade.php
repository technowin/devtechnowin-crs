@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')

    <div class="card">
        <div class="card-block">
            <div class="col-md-12 row">
                <div class="col-md-6"><h3 class="card-subtitle text-muted mt-2">Status Master</h3></div>

                <div class="col-md-2">

                </div>
                <div class="col-md-2">

                </div>
                <div class="col-md-2">
                    <a class="btn btn-outline-secondary" href="{{ route('complaintypes.create') }}" style="color:gray;"> <b>Add
                            New Status Type</b> </a>
                </div>

            </div>

        </div>
    </div>

    <div class="card mt-2 table-responsive">
        <div class="card-block">
            <div class="col-md-12 row">
                <table class="table table-sm table-hover">
                    <thead>
                    <tr class="text-muted">
                        <th>#</th>
                        <th>Status Code</th>
                        <th>Status Name</th>
                        <th>Status Description</th>
                        <th>Status For</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($complaintypes as $key => $complaintypes)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{ $complaintypes->complaintcode }}</td>
                            <td>{{ $complaintypes->complaintname }}</td>
                            <td>{{ $complaintypes->complaintdescription }}</td>
                            <td>
                                @if ($complaintypes->isactive=='1')
                                    <h6 class="card-title">Yes</h6>

                                @endif

                                @if ($complaintypes->isactive=='0')
                                    <h6 class="card-title">No</h6>
                                @endif
                            </td>
                            <td>{{ is_null($complaintypes->created_at) ? '' : $complaintypes->created_at->format('m-d-Y') }}</td>
                            <td>{{ is_null($complaintypes->updated_at) ? '' : $complaintypes->updated_at->format('m-d-Y') }}</td>
                            <td>
                                <a href="{{ route('complaintypes.show', $complaintypes->complaintcode) }}" style="margin-right: 3px;">view</a>|
                                <a href="{{ route('complaintypes.edit', $complaintypes->complaintcode) }}" style="margin-right: 3px;">edit</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection