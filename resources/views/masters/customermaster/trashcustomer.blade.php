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
                    <th>Customer Name</th>
                    <th>Customer Phone</th>
                    <th>Email </th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($customers as $key => $customer)
                    <tr>
                        {{--<th scope="row">{{$key+1}}</th>--}}
                        <td>{{ $customer->customername }}</td>
                        <td>{{ $customer->customerphone }}</td>
                        <td>{{ $customer->emailid }}</td>
                        <td>
                            <a href="{{ url('restorecustomer',$customer->customercode) }}">Restore</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $customers->links() }}
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