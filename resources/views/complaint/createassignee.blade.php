@extends('layouts.app')
@section('pageTitle', 'Create Assignee')
@section('head-css')
    <link href="{{ asset('assets/Selectize/css/selectize.css') }}" rel="stylesheet">
@stop
@section('content')
    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Assigned Complaint</h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>
            <div class="row mt-1">
                <div class="col">
                    @if(session()->has('error-message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session()->get('error-message') }}
                        </div>
                    @endif
                    @if(session()->has('success-message'))
                        <div class="alert alert-success mt-3" role="alert">
                            {{ session()->get('success-message') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="container">
                <br>
                {{Form::open(array('id' => 'assignee','action' => 'ComplaintHandlingController@store','method' => 'post', 'role' => 'form', 'invalidate' => 'invalidate', 'files'=>true))}}

                <div class="row{{ $errors->has('ticketnumber') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Ticket No.</label>
                    <div class="col-sm-6">
                        {{ Form::text('ticketnumber', $ticketnumber, array('class' => 'form-control form-control-sm','required' => 'required','readonly' => true,'style'=>'background-color:white;')) }}
                    </div>
                </div>
                <div class="row{{ $errors->has('assignees') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Assignee Name</label>
                    <div class="col-sm-6">
                        {{ Form::select('assignees', $assignees, null, array('placeholder' => '--SELECT--','required' => 'required', 'id' => 'assignees', 'rel' => URL::to('/'),'required' => 'required')) }}
                        @if ($errors->has('assignees'))
                            <span class="help-block"><strong>{{ $errors->first('assignees') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('assigneestatus') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Assignee Status</label>
                    <div class="col-sm-6">
                        {{ Form::select('assigneestatus', $assigneestatus, null, array('placeholder' => '--SELECT--','required' => 'required', 'id' => 'assigneestatus', 'rel' => URL::to('/'),'required' => 'required')) }}
                        @if ($errors->has('assigneestatus'))
                            <span class="help-block"><strong>{{ $errors->first('assigneestatus') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('resolvecomment') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Resolve Comment</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('resolvecomment', '', array('class' => 'form-control form-control-sm','required' => 'required','rows'=>'3')) }}
                        @if ($errors->has('resolvecomment'))
                            <span class="help-block"><strong>{{ $errors->first('resolvecomment') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('startdate') ? ' has-error' : '' }} mt-2">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Start Date</label>
                    <div class="col-sm-6">
                        {{ Form::date('startdate', null, array('required' => 'required', 'class' => 'form-control form-control-sm','required' => 'required','id'=>'startdate')) }}
                        @if ($errors->has('startdate'))
                            <span class="help-block"><strong>{{ $errors->first('startdate') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('enddate') ? ' has-error' : '' }} mt-1">
                    <label for="input" class="col-sm-4 col-form-label text-muted">End Date</label>
                    <div class="col-sm-6">
                        {{ Form::date('enddate', null, array('required' => 'required', 'class' => 'form-control form-control-sm','required' => 'required','id'=>'enddate')) }}
                        @if ($errors->has('enddate'))
                            <span class="help-block"><strong>{{ $errors->first('enddate') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('pendingreason') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Pending Reason</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('pendingreason', null, array('required' => 'required', 'class' => 'form-control form-control-sm','required' => 'required','id'=>'pendingreason','rows'=>'3')) }}
                        @if ($errors->has('pendingreason'))
                            <span class="help-block"><strong>{{ $errors->first('pendingreason') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('nextactionremark') ? ' has-error' : '' }} mt-2">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Next Action Remark</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('nextactionremark', null, array('required' => 'required', 'class' => 'form-control form-control-sm','required' => 'required','id'=>'nextactionremark','rows'=>'3')) }}
                        @if ($errors->has('nextactionremark'))
                            <span class="help-block"><strong>{{ $errors->first('nextactionremark') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                    <div class="col-sm-6">
                        {{ Form::submit('save & close', array('class' => 'btn btn-primary offset-4')) }}
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
    <script type="text/javascript">
        $(document).ready(function () {

            $('#assignees').selectize({
                maxItems: 1,
            });
            $('#assigneestatus').selectize({
                maxItems: 1,
            });
        });
    </script>
@stop