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
                    {{--<th>Branch code</th>--}}
                    <th>Customer Name</th>
                    <th>Branch Person Name</th>
                    <th>Phone</th>
                    <th>Fax</th>
                    <th>Email</th>
                    {{--<th>created_at</th>--}}
                    {{--<th>updated_at</th>--}}
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($branchsMasters as $key => $branchsMaster)
                    <tr>
                        {{--<th scope="row">{{$key+1}}</th>--}}
                        {{--<td>{{ $branchsMaster->branchcode }}</td>--}}
                        <td>{{ $branchsMaster->customer->customername }}</td>
                        <td>{{ $branchsMaster->branchname }}</td>
                        <td>{{ $branchsMaster->phone }}</td>
                        <td>{{ $branchsMaster->fax }}</td>
                        <td>{{ $branchsMaster->email }}</td>
                        {{--<td>{{ is_null($branchsMaster->created_at) ? '' : $branchsMaster->created_at->format('d-m-Y') }}</td>--}}
                        {{--<td>{{ is_null($branchsMaster->updated_at) ? '' : $branchsMaster->updated_at->format('d-m-Y') }}</td>--}}
                        <td>
                            <a href="{{ url('restorebranch',$branchsMaster->branchcode) }}">Restore</a>

                            {{--<a href="#" data-href="{{ route('branches.destroy', ['id' => $branchsMaster->branchcode]) }}" data-toggle="modal" data-target="#confirm-delete">delete</a>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $branchsMasters->links() }}
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