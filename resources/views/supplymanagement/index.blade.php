@extends('layouts.appnew')

@section('page-title', '| Add User')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12 row">
                <div class="col-md-10"><h4>Pending Supply</h4></div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body table-responsive">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr class="text-muted">
                    <th>#</th>
                    <th>Contract No</th>
                    <th>Workorder No</th>
                    <th>Customer Name</th>
                    <th>Supply Reminder Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pendingsupply as $key => $supply)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{ $supply->contractno }}</td>
                        <td>{{ $supply->workorderno }}</td>
                        <td>{{ $supply->customername}}</td>
                        <td>{{ $supply->preventivemaintenancereminderdate }}</td>
                        <td>
                            <a target="_blank" href="{{ URL::to('show',array($supply->contractno))}}">view</a> |
                            @if($supply->flagkey != '1')
                                <a target="_blank" href="{{ URL::to('manage',array($supply->contractno))}}">manage</a>
                                @else
                                <a target="_blank" href="{{ URL::to('supply/assignee',array($supply->contractno))}}">assignee</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{--{{ $pendingservice->links() }}--}}
        </div>
    </div>

@endsection
@section('page-script')
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>


@stop
