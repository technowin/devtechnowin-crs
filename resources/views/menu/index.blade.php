@extends('layouts.appnew')

@section('title', '| Menus')
@section('page-css')
    <link href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@stop
@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12 row">
                <div class="col-md-10"><h6>Available Menus</h6></div>
                <div class="col-md-2">
                    <a class="btn btn-blue" href="{{url('createmenu')}}"> <b>Add New Menu</b> </a>
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
        <div class="panel-body">

            <table class="table table-sm table-hover" id="example" cellspacing="0" width="100%">
                <thead>
                <tr class="text-muted">
                    <th>#</th>
                    <th>Menu Name</th>
                    <th>menu_url</th>
                    <th>action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($examplemenu as $key => $menu)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{ $menu->menuname }}</td>
                        <td>{{ $menu->redirecturl }}</td>
                        <td>
                            <a href="{{ url('viewmenu/'.$menu->menuid) }}">view</a> |
                            <a href="{{ url('editmenu/'.$menu->menuid) }}">edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{--<table class="table table-sm table-hover" id="example" cellspacing="0" width="100%">--}}
                {{--<thead>--}}
                {{--<tr class="text-muted">--}}
                    {{--<th>#</th>--}}
                    {{--<th>Menu Name</th>--}}
                    {{--<th>menu_url</th>--}}
                    {{--<th>created_at</th>--}}
                    {{--<th>updated_at</th>--}}
                    {{--<th>action</th>--}}
                {{--</tr>--}}
                {{--</thead>--}}
                {{--<tbody>--}}
                {{--@foreach($menus as $key => $menu)--}}
                    {{--<tr>--}}
                        {{--<th scope="row">{{$key+1}}</th>--}}
                        {{--<td>{{ $menu->menu_name }}</td>--}}
                        {{--<td>{{ $menu->url }}</td>--}}
                        {{--<td>{{ is_null($menu->created_at) ? '' : $menu->created_at->format('m-d-Y') }}</td>--}}
                        {{--<td>{{ is_null($menu->updated_at) ? '' : $menu->updated_at->format('m-d-Y') }}</td>--}}
                        {{--<td>--}}
                            {{--<a href="{{ url('viewmenu/'.$menu->id) }}">view</a> |--}}
                            {{--<a href="{{ url('editmenu/'.$menu->id) }}">edit</a> |--}}
                            {{--<a href="#" data-href="{{ url('deletemenu/'.$menu->id) }}" data-toggle="modal"--}}
                               {{--data-target="#confirm-delete">delete</a>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                {{--@endforeach--}}
                {{--</tbody>--}}
            {{--</table>--}}
        </div>
    </div>

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>

                <div class="modal-body">
                    <p>You are about to delete one track, this procedure is irreversible.</p>
                    <p>Do you want to proceed?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Delete</a>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('page-script')
    <script>
        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>

    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>

@stop
