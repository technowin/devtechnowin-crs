@extends('layouts.app')

@section('content')

    <div class="container card">
        <div class="col card-body">
            {{--<h6 class="text-muted"><b>Create New Complaint</b></h6>--}}
            <div class="row">
                <div class="col-md-6"><h5 class="card-title text-muted">Create New Complaint </h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="50" height="50" style="float: right;"/>  </div>
            </div>
            <hr />
            <div class="container">
                {{ Form::open(array('url' => 'users')) }}

                <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-2 col-form-label">Customer Type</label>
                    <div class="col-sm-10">
                        {{ Form::text('name', '', array('class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-2 col-form-label">Customer Type</label>
                    <div class="col-sm-10">
                        {{ Form::text('name', '', array('class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-2 col-form-label">Customer Type</label>
                    <div class="col-sm-10">
                        {{ Form::text('name', '', array('class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-2 col-form-label">Customer Type</label>
                    <div class="col-sm-10">
                        {{ Form::text('name', '', array('class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-2 col-form-label">Customer Type</label>
                    <div class="col-sm-10">
                        {{ Form::text('name', '', array('class' => 'form-control','required' => 'required')) }}
                        @if ($errors->has('name'))
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row col-md-4">
                    <div class="col">
                        <div class="form-group">
                            {{ Form::submit('Add User', array('class' => 'btn btn-primary')) }}
                        </div>
                    </div>
                </div>

                {{ Form::close() }}

            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('js/jquery-3.1.1.js') }}"></script>

@endsection
