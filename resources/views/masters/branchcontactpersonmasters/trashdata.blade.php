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
                    <th>Branch Contact Name</th>
                    <th>Branch Name</th>
                    {{--<th>contact Person </th>--}}
                    <th>Phone </th>
                    <th>Fax</th>
                    <th>Email</th>
                    <th>Desingnation</th>
                    {{--<th>created_at</th>--}}
                    {{--<th>updated_at</th>--}}
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($branches as $key => $branch)
                    <tr>
                        {{--<th scope="row">{{$key+1}}</th>--}}
                        <td>{{ $branch->contactpersonname }}</td>
                        <td>{{ $branch->Branach->branchname }}</td>
                        {{--<td>{{ $branch->contactpersonname }}</td>--}}
                        <td>{{ $branch->phone }}</td>
                        <td>{{ $branch->fax }}</td>
                        <td>{{ $branch->emailid }}</td>
                        <td>{{ $branch->designation }}</td>
                        {{--<td>{{ is_null($branch->created_at) ? '' : $branch->created_at->format('m-d-Y') }}</td>--}}
                        {{--<td>{{ is_null($branch->updated_at) ? '' : $branch->updated_at->format('m-d-Y') }}</td>--}}
                        <td>
                            <a href="{{ url('restorebranchcontact',$branch->branchcontactcode) }}">Restore</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $branches->links() }}
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