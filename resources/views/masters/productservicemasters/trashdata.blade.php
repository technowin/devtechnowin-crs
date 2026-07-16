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
                    {{--<th>Product Service Code</th>--}}
                    <th>Sector Name</th>
                    <th>Product Service Name</th>
                    <th>Product Service Description</th>
                    <th>Is Active</th>
                    {{--<th>created_at</th>--}}
                    {{--<th>updated_at</th>--}}
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($productservices as $key => $productservice)
                    <tr>
                        {{--<th scope="row">{{$key+1}}</th>--}}
                        {{--<td>{{ $productservice->productservicecode }}</td>--}}
                        <td>{{ $productservice->sectorcode }}</td>
                        <td>{{ $productservice->productservicename }}</td>
                        <td>{{ $productservice->productservicedescription }}</td>
                        <td>{{ $productservice->isactive == 1 ? "Yes" : "No" }}</td>
                        {{--<td>{{ is_null($productservice->created_at) ? '' : $productservice->created_at->format('m-d-Y') }}</td>--}}
                        {{--<td>{{ is_null($productservice->updated_at) ? '' : $productservice->updated_at->format('m-d-Y') }}</td>--}}
                        <td>
                            <a href="{{ url('restoreproductservice',$productservice->productservicecode) }}">Restore</a>
                            {{--<a href="#"--}}
                            {{--data-href="{{ route('productservice.destroy', ['id' => $productservice->productservicecode]) }}"--}}
                            {{--data-toggle="modal" data-target="#confirm-delete">delete</a>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $productservices->links() }}
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