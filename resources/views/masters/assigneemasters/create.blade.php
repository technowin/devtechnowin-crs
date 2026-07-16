@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')

    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row" style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Add Assignee</h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40"
                                           style="float: right; margin-top: -15px"/></div>
            </div>
            <br>
            @if (session('flash_message'))
                <div class="alert alert-danger">
                    {{ session('flash_message') }}
                </div>
            @endif
            <div class="container">
                {{ Form::open(array('url' => 'appadmin/assignee', 'id' => 'assigneeaddform')) }}

                <div class="row">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Assignee Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('assigneename', '', array('class' => 'form-control form-control-sm')) }}
                        @if ($errors->has('assigneename'))
                            <span class="help-block"><strong>{{ $errors->first('assigneename') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Department Name</label>
                    <div class="col-sm-6">
                        {{ Form::select('departmentcode', $departmentcode, null, array('placeholder' => 'select','required' => 'required','id' => 'departmentcode')) }}
                        @if ($errors->has('departmentcode'))
                            <span class="help-block"><strong>{{ $errors->first('departmentcode') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('mobileno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Mobile No</label>
                    <div class="col-sm-6">
                        {{ Form::number('mobileno', '', array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==10) return false;')) }}
                        @if ($errors->has('mobileno'))
                            <span class="help-block"><strong>{{ $errors->first('mobileno') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('mobileno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('emailid', '', array('class' => 'form-control form-control-sm')) }}
                        @if ($errors->has('emailid'))
                            <span class="help-block"><strong>{{ $errors->first('emailid') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('labourcost') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Labour Cost</label>
                    <div class="col-sm-6">
                        {{ Form::number('labourcost', '', array('class' => 'form-control form-control-sm')) }}
                        @if ($errors->has('labourcost'))
                            <span class="help-block"><strong>{{ $errors->first('labourcost') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Employee Name</label>
                    <div class="col-sm-6">
                        {{ Form::select('emplyeescode', $emplyeescode, null, array('placeholder' => 'select','id' => 'emplyeescode' )) }}

                    </div>
                </div>

                <div class="row{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Is Active</label>
                    <div class="col-sm-6">
                        {{ Form::select('isactive', array('1' => 'Yes','0' => 'No'),null, array('placeholder' => 'select', 'id' => 'isactive')) }}
                        @if ($errors->has('calleremail'))
                            <span class="help-block"><strong>{{ $errors->first('calleremail') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Password</label>
                    <div class="col-sm-6">
                        {{ Form::password('password', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('password'))
                            <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Confirm Password</label>
                    <div class="col-sm-6">
                        {{ Form::password('password_confirmation', array('id'=>'confirmpasswordid','class' => 'form-control form-control-sm','required' => 'required')) }}
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

            $('#emplyeescode').selectize({
                maxItems: 1
            });
            $('#departmentcode').selectize({
                maxItems: 1

            });
            $('#isactive').selectize({
                maxItems: 1
            });

        });
    </script>




@stop