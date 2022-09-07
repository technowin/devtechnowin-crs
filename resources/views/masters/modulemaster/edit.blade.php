@extends('layouts.app')

@section('pageTitle', 'Add Module')

@section('content')

    <div class="container card col-md-9">
        <div class="col card-block">
            <div class="row" style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Edit Module</h5></div>
            </div>

            <div class="container">
                <br>
                {{ Form::model($module, array('route' => array('modules.update', $module->id), 'method' => 'PUT')) }}

                <div class="row{{ $errors->has('modulename') ? ' has-error' : '' }}" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label text-muted">Module Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('modulename', null, array('placeholder' => 'Module Name','required' => 'required', 'class' => 'form-control')) }}
                        @if ($errors->has('modulename'))
                            <span class="help-block"><strong>{{ $errors->first('modulename') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('moduledescription') ? ' has-error' : '' }}" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label text-muted">Module Description</label>
                    <div class="col-sm-6">
                        {{ Form::text('moduledescription', null, array('placeholder' => 'Module Description','required' => 'required', 'class' => 'form-control')) }}
                        @if ($errors->has('moduledescription'))
                            <span class="help-block"><strong>{{ $errors->first('moduledescription') }}</strong></span>
                        @endif
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {{ Form::submit('Submit', array('class' => 'btn btn-primary offset-4')) }}
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
