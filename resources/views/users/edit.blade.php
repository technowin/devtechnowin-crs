@extends('layouts.appnew')
@section('title', '| Edit User')
@section('content')
    <div class="container">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Edit User</div>
                <div class="panel-body">
                    {{ Form::open(['action' => ['UserController@update', $user->id]]) }}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Name</label>
                        {{ Form::text('name', $user->name, array('class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Email</label>
                        {{ Form::email('email', $user->email, array('class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('email'))
                            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                        <label for="mobile">Mobile</label>
                        {{ Form::number('mobile', $user->mobile, array('class' => 'form-control','required' => 'required','onKeyPress' => "if(this.value.length==10) return false;")) }}
                        @if ($errors->has('mobile'))
                            <span class="help-block"><strong>{{ $errors->first('mobile') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
                        <label for="roles">Role</label>
                        {{ Form::select('roles', $roles, $user->roles->first()->id ,array('class' => 'form-control','required' => 'required','placeholder' => '-SELECT-')) }}
                        @if ($errors->has('roles'))
                            <span class="help-block"><strong>{{ $errors->first('roles') }}</strong></span>
                        @endif
                    </div>
                    {{ Form::submit('submit', array('class' => 'btn btn-primary', 'style' => 'margin-top: 2.4rem;')) }}
                </div>
            </div>
            <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
        </div>
        <div class="col-md-2"></div>
    </div>
@endsection
