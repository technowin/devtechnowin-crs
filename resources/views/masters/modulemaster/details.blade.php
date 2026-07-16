@extends('layouts.app')

@section('pageTitle', 'View Module')

@section('content')

    <div class="container card col-md-9">
        <div class="col card-block">
            <div class="row" style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">View Module</h5></div>
            </div>

            <div class="container">
                <br>
                {{ Form::model($module) }}

                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label text-muted">Module Name</label>
                    <div class="col-sm-6">
                        : {{ Form::label('modulename', $module->modulename, array('class'=> 'col-sm-6 col-form-label')) }}
                    </div>
                </div>

                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label text-muted">Module Description</label>
                    <div class="col-sm-6">
                        : {{ Form::label('moduledescription', $module->moduledescription, array('class'=> 'col-sm-6 col-form-label')) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
