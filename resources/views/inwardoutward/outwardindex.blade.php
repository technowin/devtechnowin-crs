@extends('layouts.appnew')

@section('page-title', '| Customer Master')
@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12 row">
                <div class="col-md-10"><h4>Outward Details</h4></div>
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
                    <th>Inward Date</th>
                    <th>Ticket No</th>
                    <th>Customer Name</th>
                    <th>Branch Name</th>
                    <th>Challan No</th>
                    <th>Challan Date</th>
                    <th>Outward No</th>
                    <th>Outward Date</th>
                    <th>Outward Product Details</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($outward as $key => $outwards)
                    <tr>
                        <td>{{ $outwards->inwardno }}</td>
                        <td>{{ $outwards->inwardDate}}</td>
                        <td>{{ $outwards->ticketno }}</td>
                        <td>{{ $outwards->customers->customername }}</td>
                        <td>{{ $outwards->branch->branchname }}</td>
                        <td>{{ $outwards->challanNo }}</td>
                        <td>{{ $outwards->challanDate }}</td>
                        <td>{{ $outwards->outwardno }}</td>
                        <td>{{ $outwards->outwardDate}}</td>
                        <td>{{ $outwards->outwardProductDetails }}</td>
                        <td>
                            @if($outwards->status == 'INWARD')
                                <a href="{{ url('addoutward/'.$outwards->ticketno.'/'.$outwards->id)}}">Outward</a> |
                            @elseif($outwards->status == 'OUTWARD' and $outwards->challanNo == null)
                                <a href="{{ url('generatechallan/'.$outwards->ticketno.'/'.$outwards->id)}}">Generate Challan</a> |
                             @endif
                             <a href="{{ url('viewdetails/'.$outwards->ticketno.'/'.$outwards->id)}}">View</a>
                            @if($outwards->challanNo != null)
                                | <a href="{{url('challandetails/'.$outwards->ticketno.'/'.$outwards->id)}}">View Challan</a>
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
                "order": [1,"desc"]
            });
        });

    </script>
@stop
