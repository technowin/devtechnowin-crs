@extends('layouts.app')

@section('pageTitle', 'Modules')

@section('content')
    @if (session('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif
    <br/>

    <div class="card">
        <div class="card-body table-responsive">
            <div class="col-md-12 row">
                <div class="col-md-10"><h5 class="card-subtitle text-muted mt-2"><b>Module</b></h5></div>
                <div class="col-md-2">
                    <a class="btn btn-outline-secondary" href="{{ route('modules.create') }}" style="color:gray; float: right"> <b>Add
                            Module</b> </a>
                </div>
            </div>
            <br/>
            @if(isset($modules))
                <table class="table table-sm table-hover">
                    <thead>
                    <tr class="text-muted">
                        <th width="5%">#</th>
                        <th>Module Name</th>
                        <th>Module Description</th>
                        <th width="5%">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($modules as $key => $value)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$value->modulename}}</td>
                            <td>{{$value->moduledescription}}</td>
                            <td>
{{--                                <a href="{{ URL::to('adminaccess/modules/'.$value->id) }}" style="margin-right: 3px;"><i class="fa fa-eye fa-lg text-muted" style="color: black;"></i></a> |--}}
                                <a href="{{ URL::to('adminaccess/modules/'.$value->id.'/edit/') }}" style="margin-right: 3px;"><i class="fa fa-pencil fa-lg text-muted" style="color: black;"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('js/jquery-3.1.1.js') }}"></script>
@endsection