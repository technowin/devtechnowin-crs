@extends('layouts.appnew')
@section('page-title', '| Add User')
@section('content')
    <div class="container col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">Create User</div>
            <div class="panel-body">
                {{ Form::open(array('action' => 'MenuController@store')) }}
                <div class="form-group">
                    <label for="name">Name</label>
                    {{ Form::text('name', '', array('class' => 'form-control','required' => 'required')) }}
                    @if ($errors->has('name'))
                        <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    {{ Form::email('email', '', array('class' => 'form-control','required' => 'required','id' => 'mobileno')) }}
                    @if ($errors->has('email'))
                        <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile</label>
                    {{ Form::number('mobile', '', array('class' => 'form-control','required' => 'required')) }}
                    @if ($errors->has('mobile'))
                        <span class="help-block"><strong>{{ $errors->first('mobile') }}</strong></span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    {{ Form::select('role', $roles, null,array('class' => 'form-control','required' => 'required','placeholder' => '-SELECT-')) }}
                    @if ($errors->has('role'))
                        <span class="help-block"><strong>{{ $errors->first('role') }}</strong></span>
                    @endif
                </div>
                {{ Form::submit('submit', array('class' => 'btn btn-info', 'style' => 'margin-top: 2.4rem;')) }}
            </div>
        </div>
    </div>
@endsection
