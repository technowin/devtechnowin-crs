@extends('layouts.appnew')

@section('page-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
@stop
@section('content')
    <div class="container">
        {{ Form::open(array('url' => $urlpath,'method' => 'post' )) }}
        <div class="panel panel-default">
            <div class="panel-heading text-muted">Change Password</div>
            <div class="panel-body">
                <div class="row{{ $errors->has('old') ? 'has-error' : '' }}">
                    <div class="col-md-4">
                        <label for="input" class="col-form-label text-muted">Old Password</label>
                        {{ Form::password('old', array('class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('old'))
                            <span class="help-block"><strong>{{ $errors->first('old') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('password') ? 'has-error' : '' }}" style="margin-top:1.5rem;">
                    <div class="col-md-4">
                        <label for="input" class="col-form-label text-muted">New Password</label>
                        {{ Form::password('password', array('class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('password'))
                            <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('password_confirmation') ? 'has-error' : '' }}" style="margin-top:1.5rem;">
                    <div class="col-md-4">
                        <label for="input" class="col-form-label text-muted">Confirm Password</label>
                        {{ Form::password('password_confirmation', array('class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
                        @endif
                    </div>
                </div>
                {{ Form::submit('Change Password', array('class' => 'btn btn-primary','style'=> 'margin-top:1.5rem;')) }}
            </div>
        </div>
        {{ Form::close() }}
        @if (Session::has('flash_message'))
            <div class="alert alert-success">{{ Session::get('flash_message') }}</div>
        @endif
        @if (Session::has('alert_message'))
            <div class="alert alert-danger">{{ Session::get('alert_message') }}</div>
        @endif
    </div>
@endsection
