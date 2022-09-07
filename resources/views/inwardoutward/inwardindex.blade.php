@extends('layouts.appnew')

@section('page-title', '| Customer Master')
@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop
@section('content')


<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12 row">
            <div class="col-md-10"><h4>Inward Details</h4></div>
            <div class="col-md-2">
                <a class="btn btn-outline-secondary" href="{{ URL::to('/addinward') }}" style="color:gray;"><b>Add New Inward Details</b> </a>
            </div>
        </div>
    </div>
</div>

@if (session('flash_message'))
    <div class="alert alert-success">
        {{ session('flash_message') }}
    </div>
@endif
<div class="panel panel-default">
    <div class="panel-body table-responsive">
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr class="text-muted">
                <th>Inward No</th>
                <th>Ticket No</th>
                <th>Customer Name</th>
                <th>Customer Site</th>
                <th>Caller Name</th>
                <th>Equipment Sr No</th>
                <th>Product Sr No</th>
                <th>Inward Product Details</th>
                <th>Inward Date</th>
                <th>Assignee Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($inward as $key => $inwards)
                <tr>
                    <td>{{ $inwards->inwardno }}</td>
                    <td>{{ $inwards->ticketno }}</td>
                    <td>{{ $inwards->customers->customername }}</td>
                    <td>{{ $inwards->branch->branchname }}</td>
                    <td>{{ $inwards->callerName }}</td>
                    <td>{{ $inwards->equipmentsrno }}</td>
                    <td>{{ $inwards->productsrno }}</td>
                    <td>{{ $inwards->inwardProductDetails }}</td>
                    <td>{{ $inwards->inwardDate}}</td>
                    <td>{{ $inwards->assignee->assigneename }}</td>
                    <td>
                        @if($inwards->status == 'INWARD')
                            <a href="{{ url('editinward/'.$inwards->ticketno.'/'.$inwards->id)}}">edit</a>
                        @endif
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
                "order": [8,"desc"]
            });
        });

    </script>
@stop
