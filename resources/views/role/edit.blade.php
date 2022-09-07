@extends('layouts.appnew')
@section('title', '| Roles')
@section('content')
    <div class="container">
        {{ Form::open(['action' => ['RoleController@update', $role->id]]) }}
        <div class="panel panel-default">
            <div class="panel-heading">Edit Role</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="input" class="col-form-label text-muted">Role Name</label>
                        {{ Form::text('name', $role->name, array('class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>
                {{ Form::submit('submit', array('class' => 'btn btn-primary','style'=> 'margin-top:1.5rem;')) }}
            </div>
        </div>
        {{ Form::close() }}
        @if (Session::has('flash_message'))
            <div class="alert alert-info">{{ Session::get('flash_message') }}</div>
        @endif
        <a href="{{ url()->previous() }}" class="btn btn-default">Back</a>
    </div>
@endsection