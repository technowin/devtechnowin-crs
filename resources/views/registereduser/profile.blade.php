@extends('layouts.appnew')
@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <h6 class="text-muted"><b>My Profile</b></h6>
                <hr />
                <div class="container offset-3">
                    {{ Form::open(['url' => 'settings/' .$user->id, 'class' => 'form-horizontal']) }}
                    <div class="form-group">
                        {{ Form::label('name', 'Name' ,array('class' => 'text-muted')) }}<br>
                        {{ Form::text('name', $user->name, array('class' => 'form-control','required' => 'required')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('email', 'Email' ,array('class' => 'text-muted')) }}<br>
                        {{ Form::email('email', $user->email, array('class' => 'form-control','required' => 'required')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('mobile', 'Mobile' ,array('class' => 'text-muted')) }}<br>
                        {{ Form::text('mobile', $user->mobile, array('class' => 'form-control','required' => 'required')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>

    <div class="container">
        <div class="row mt-1">
            <div class="col">
                @if(session()->has('error-message'))
                    <div class="alert alert-danger mt-3">
                        {{ session()->get('error-message') }}
                    </div>
                @endif
                @if(session()->has('success-message'))
                    <div class="alert alert-success mt-3">
                        {{ session()->get('success-message') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script-js')
    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
@stop