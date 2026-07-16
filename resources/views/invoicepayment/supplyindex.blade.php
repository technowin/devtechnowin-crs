@extends('layouts.appnew')

@section('page-title', '| Customer Master')

@section('content')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12 row">
            <div class="col-md-10"><h3>Supply Invoice </h3></div>
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
                {{--<th>#</th>--}}
                <th>Contract No</th>
                <th>Customer Name</th>
                <th>Payment Type</th>
                {{--<th>Payment due date</th>--}}
                <th>Payment cycle </th>
                <th>Invoice No</th>
                <th>action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoicesupply as $key => $invoice)
                <tr>
                    <td>{{ $invoice->contractno }}</td>
                    <td>{{$invoice->customername}}</td>
                    <td>{{ $invoice->paymentype }}</td>
{{--                    <td>{{ $invoice->paymentduedate }}</td>--}}
                    <td>{{ $invoice->paymentcycleno }}</td>
                    <td>{{ $invoice->invoicebillno }}</td>
                    <td>
                         @if($invoice->invoicebillno==null)
                            <a href="{{ URL::to('supplyinvoice',array($invoice->contractno,$invoice->paymentcycleno))}}">Generate Invoice</a>
                             @elseif($invoice->invoicesentdate==null)
                            <a href="{{ URL::to('supplyedit',array($invoice->contractno,$invoice->paymentcycleno))}}">Edit</a> |
                            <a href="{{URL::to('sendinvoice',array($invoice->contractno,$invoice->paymentcycleno))}}">Send Invoice</a>|
                            <a href="{{ URL::to('invoicereport',array($invoice->contractno,$invoice->paymentcycleno))}}">Invoice Report</a>
                             @else
                            <a href="{{ URL::to('invoicereport',array($invoice->contractno,$invoice->paymentcycleno))}}">Invoice Report</a>
                        @endif
{{--                            <a href="{{ URL::to('invoiceedit',array($invoice->contractno,$invoice->paymentcycleno))}}">Edit</a> |--}}


                        {{--<a href="{{ URL::to('editcontract',array($invoice->contractno))}}">edit</a>--}}
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
            $('#example').DataTable({
                "order": [[ 5, "desc" ]]
            });
        });
    </script>
    <script type="text/javascript">

    </script>


@stop
