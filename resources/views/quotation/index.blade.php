@extends('layouts.appnew')

@section('page-title', '| Customer Master')

@section('content')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12 row">
            <div class="col-md-10"><h3> Quotation Details </h3></div>
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
                <th>Ticket no</th>
                <th>Type of Call</th>
                <th>Product sr.No</th>
                <th>Customer Name</th>
                <th>Customer Site </th>
                <th>Product</th>
                <th>Category</th>
                <th>subcategory</th>
                <th>Quotation No.</th>
                <th>action</th>
            </tr>
            </thead>
            <tbody>
               @foreach($existingusercomplaint as $key=>$usercomplain)
                   <tr>
                       <td>{{$usercomplain->Ticket}}</td>
                       <td>{{$usercomplain->CallType}}</td>
                       <td>{{$usercomplain->productsrno_accountno}}</td>
                       <td>{{$usercomplain->customername}}</td>
                       <td>{{$usercomplain->branchname}}</td>
                       <td>{{$usercomplain->productservicename}}</td>
                       <td>{{$usercomplain->categoryname}}</td>
                       <td>{{$usercomplain->subcategoryname}}</td>
                       <td>{{$usercomplain->quotationnumber}}</td>
                       <td>
                           @if($usercomplain->quotationnumber==null)
                           <a href="{{URL::to('genratequotation',$usercomplain->tableid)}}">Generate Quotation </a>
                               @elseif($usercomplain->quotationstatus==null)
                               <a href="{{URL::to('edit',$usercomplain->Ticket)}}">Edit</a>|
                               <a href="{{URL::to('quotationstatus',$usercomplain->Ticket)}}">Status</a>|
                               <a href="{{URL::to('quotationreport',array($usercomplain->Ticket))}}">Quotation</a>
                           @elseif($usercomplain->invoiceno==null)
                               <a href="{{URL::to('dispatch',$usercomplain->Ticket)}}">Dispatch</a>|
                               <a href="{{URL::to('quotationreport',array($usercomplain->Ticket))}}">Quotation</a>
                               @else
                               <a href="{{URL::to('quotationreport',array($usercomplain->Ticket))}}">Quotation</a> |
                               <a href="{{URL::to('details',array($usercomplain->Ticket))}}">view</a>
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
            $('#example').DataTable({
                "order": [[ 5, "desc" ]]
            });
        });
    </script>
    <script type="text/javascript">

    </script>


@stop
