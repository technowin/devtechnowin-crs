@extends('layouts.appnew')

@section('pageTitle', 'User Lodged Complaints')

@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop

<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-md-12 row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <a class="btn btn-outline-secondary" href="{{ URL::to('shiftedequipment') }}" style="color:gray; float: right"> <b>Customer Site Shift </b> </a>
                {{--<a  class="btn btn-blue" data-toggle="modal" data-target=".bs-example-modal-lg"> <b>Customer Site Shift </b></a>--}}
            </div>
        </div>
    </div>
</div>
@section('content')

    @if (session('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif


    <div class="panel panel-default">
        <div class="panel-body">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr class="text-muted">
                    <th>Customer Name</th>
                    <th>Equipment Sr No</th>
                    <th>Product Service</th>
                    <th>Category Name</th>
                    {{--<th>Action</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($model as $key => $modelindex)
                    <tr>
                        <td>{{ $modelindex->customercode }}</td>
                        <td>{{ $modelindex->equipmentsrno }}</td>
                        <td>{{ $modelindex->productservicecode }}</td>
                        <td>{{ $modelindex->categorycode }}</td>
                        {{--<td>--}}
                            {{--<a target="_blank" href="{{ route('category.show', ['id' => $category->categorycode]) }}">view</a> |--}}
                            {{--<a target="_blank" href="{{ route('category.edit', ['id' => $category->categorycode]) }}">edit</a>--}}
                        {{--</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
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

    <script type="text/javascript">
        $(document).ready(function () {
            $('#productservicecode').selectize({
                maxItems: 1
            });
            $('#isactive').selectize({
                maxItems: 1
            });
        });
    </script>
@endsection