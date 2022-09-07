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
                    {{--<th>Category Code</th>--}}
                    {{--<th>Product Service</th>--}}
                    <th>Category Name</th>
                    <th>Category Description</th>
                    <th>Is Active</th>
                    {{--<th>created_at</th>--}}
                    {{--<th>updated_at</th>--}}
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categorys as $key => $category)
                    <tr>
                        {{--<th scope="row">{{$key+1}}</th>--}}
                        {{--<td>{{ $category->categorycode }}</td>--}}
                        {{--<td>{{ $category->productservicecode }}</td>--}}
                        <td>{{ $category->categoryname }}</td>
                        <td>{{ $category->categorydescription }}</td>
                        <td>{{ $category->isactive == 1 ? "Yes" : "No" }}</td>
                        {{--<td>{{ is_null($category->created_at) ? '' : $category->created_at->format('m-d-Y') }}</td>--}}
                        {{--<td>{{ is_null($category->updated_at) ? '' : $category->updated_at->format('m-d-Y') }}</td>--}}
                        <td>
                            {{--{{ Form::open(array('url' => 'restoredata/',$category->categorycode)) }}--}}
                            <a href="{{ url('restorecategory',$category->categorycode) }}">Restore</a>

                            {{--{{Form::open(['url' => ['restoredata', $category->categorycode]])}}--}}
                            {{--<button type="submit" class="btn">Restore</button>--}}
                            {{--{{Form::close()}}--}}
                            {{--<a href="{{ route('category.restore', ['id' => $category->categorycode]) }}">restore</a>--}}
                            {{--<a href="#" data-toggle="modal" data-target="#confirm-delete">delete</a>--}}
                            {{--{{Form::open(['method' => 'Delete', 'route' => ['category.destroy', $category->categorycode]])}}--}}
                            {{--<button type="submit" class="btn">Delete</button>--}}
                            {{--{{Form::close()}}--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $categorys->links() }}
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