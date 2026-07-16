@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')

    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row" style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Add Complaint Type </h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>
            <br/>
            <div class="container">
                {{ Form::open(array('url' => 'complainttypes')) }}
                <div class="row{{ $errors->has('branchname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Complaint Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('complaintname', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('complaintname'))
                            <span class="help-block"><strong>{{ $errors->first('complaintname') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('complaintdescription') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Complaint Description</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('complaintdescription', '', array('rows'=>3,'required' => 'required', 'class' => 'form-control form-control-sm',  'rel' => URL::to('/'),'required' => 'required')) }}
                        @if ($errors->has('complaintdescription'))
                            <span class="help-block"><strong>{{ $errors->first('complaintdescription') }}</strong></span>
                        @endif
                    </div>
                </div>
                <br>
                <div class="row{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Is Active</label>
                    <div class="col-sm-6">
                        {{ Form::select('isactive', array('select'=>'--SELECT--','1' => 'Yes','0' => 'No'),null, array('placeholder' => 'select','required' => 'required', 'id' => 'isactive')) }}
                        @if ($errors->has('calleremail'))
                            <span class="help-block"><strong>{{ $errors->first('calleremail') }}</strong></span>
                        @endif
                    </div>
                </div>
                <br>
                <div class="row{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                    <div class="col-sm-6">
                        {{ Form::submit('Save & Close', array('class' => 'btn btn-primary')) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection

@section('script-js')
    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script>

        $(document).ready(function () {
            $('#isactive').selectize({
                maxItems: 1
            });
        });
    </script>
@stop