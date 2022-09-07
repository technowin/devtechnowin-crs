@extends('layouts.appnew')

@section('page-title', '| Add User')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12 row">
                <div class="col-md-10"><h6>Pending Installation Service</h6></div>
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
                    <th>Installation Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pendinginstallationsupply as $key => $pendinginstallation)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{ $pendinginstallation->contractno }}</td>
                        <td>{{ $pendinginstallation->workorderno }}</td>
                        <td>{{ $pendinginstallation->customername}}</td>
                        <td>{{ $pendinginstallation->installationdate }}</td>
                        <td>
                            <a href="{{ URL::to('show',array($pendinginstallation->contractno))}}">view</a> |
                            @if($pendinginstallation->flagkey != '1')
                                <a href="{{ URL::to('manage',array($pendinginstallation->contractno))}}">manage</a>
                                @else
                                <a href="{{ URL::to('supply/assignee',array($pendinginstallation->contractno))}}">assignee</a>
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
