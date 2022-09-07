@extends('layouts.appnew')
@section('title', '| Roles')
@section('content')
    {{ Form::open(array('action' => 'RoleController@store')) }}
    <div class="panel panel-default">
        <div class="panel-heading">Create Role &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ Form::submit('submit', array('class' => 'btn btn-info col-md-offset-9')) }}</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="input" class="col-form-label text-muted">Role Name</label>
                    {{ Form::text('name', '', array('class' => 'form-control','required' => 'required')) }}
                    @if ($errors->has('name'))
                        <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
    @if (Session::has('flash_message'))
        <div class="alert alert-info">{{ Session::get('flash_message') }}</div>
    @endif
@endsection