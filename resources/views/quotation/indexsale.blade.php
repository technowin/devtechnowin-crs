@extends('layouts.appnew')

@section('page-title', '| sale Quotation ')

@section('content')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12 row">
            <div class="col-md-10"><h3>Sale Quotation Details </h3></div>
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
        <table id="saledatatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr class="text-muted">
                {{--<th>#</th>--}}
                <th>Ticket no</th>
                <th>Type of Call</th>
                <th>Customer Name</th>
                <th>Customer Site </th>
                <th>Sale Product</th>
                <th>Quotation No.</th>
                <th>action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($existingusercomplaint as $key=>$usercomplain)
                <tr>
                    <td>{{$usercomplain->ticketno}}</td>
                    <td>{{$usercomplain->typeofcall}}</td>
                    <td>{{$usercomplain->customername}}</td>
                    <td>{{$usercomplain->branchname}}</td>
                    <td>{{$usercomplain->productsupply}}</td>
                    <td>{{$usercomplain->quotationnumber}}</td>
                    <td>

                        @if($usercomplain->quotationnumber==null)
                            <a href="{{URL::to('genratequotation',$usercomplain->id)}}">generate Quotation </a>
                        @elseif($usercomplain->quotationstatus==null)
                            <a href="{{URL::to('editsale',$usercomplain->ticketno)}}">Edit</a>|
                            <a href="{{URL::to('salestatus',$usercomplain->ticketno)}}">Status</a>|
                            <a href="{{URL::to('salequotation',array($usercomplain->ticketno))}}">Quotation</a>
                        @else
                            <a href="{{URL::to('salequotation',array($usercomplain->ticketno))}}">Quotation</a> |
                            <a href="{{URL::to('saledetails',array($usercomplain->ticketno))}}">view</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('page-script')
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#saledatatable').DataTable({
                "order": [[ 5, "desc" ]]
            });
        });
    </script>
    <script type="text/javascript">

    </script>


@stop
