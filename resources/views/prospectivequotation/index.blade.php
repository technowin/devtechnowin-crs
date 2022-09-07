@extends('layouts.appnew')

@section('page-title', '| Customer Master')

@section('content')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12 row">
            <div class="col-md-10"><h4>Quotation</h4></div>
            <div class="col-md-2">
                <a class="btn btn-outline-secondary" href="{{ URL::to('/prospectivequotation') }}" style="color:gray;">
                    <b>Add Prospective Quotation</b> </a>
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
                <th>Quotation No</th>
                <th>Organization Name</th>
                <th>Email ID</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($ProspectiveQutation as $key => $Prospective)
                <tr>
                    <td>{{ $Prospective->quotationno }}</td>
                    <td>{{ $Prospective->customers->customername }}</td>
                    <td>{{ $Prospective->emailid }}</td>
                    <td>{{ $Prospective->phone }}</td>
                    <td>
                        <a target="_blank" href="{{ URL::to('showprospectivequotation',array($Prospective->id))}}">view</a> |
                        <a target="_blank" href="{{ URL::to('prospectivequotationedit',array($Prospective->id))}}">edit</a> |
                        <a target="_blank" href="{{ URL::to('genratequtationreport',array($Prospective->id))}}">genrate qutation</a>
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
            });
        });

        function doalert(obj) {
            debugger
            var id =  obj.getAttribute("href");
            window.location.href = '{{URL::to('prospectivequotationedit')}}/'+id;
        }
    </script>


@stop
