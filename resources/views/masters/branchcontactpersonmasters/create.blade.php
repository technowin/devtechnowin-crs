@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')

    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Add Branch Contact</h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>
            <BR>
            <div class="container">
                {{ Form::open(array('url' => 'branches')) }}
                <div class="row{{ $errors->has('contactpersonname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Branch Person Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('contactpersonname', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('contactpersonname'))
                            <span class="help-block"><strong>{{ $errors->first('contactpersonname') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('branchmastercode') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name</label>
                    <div class="col-sm-6">
                        {{ Form::select('branchmastercode', $branchmastercode, null, array('placeholder' => 'select','required' => 'required','id'=>'branchmastercode')) }}
                        @if ($errors->has('branchmastercode'))
                            <span class="help-block"><strong>{{ $errors->first('branchmastercode') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('fax') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Fax</label>
                    <div class="col-sm-6">
                        {{ Form::text('fax', '', array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==12) return false;')) }}
                        @if ($errors->has('fax'))
                            <span class="help-block"><strong>{{ $errors->first('fax') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Phone</label>
                    <div class="col-sm-6">
                        {{ Form::number('phone', '', array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==10) return false;')) }}
                        @if ($errors->has('emailid'))
                            <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('emailid') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('emailid', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('emailid'))
                            <span class="help-block"><strong>{{ $errors->first('emailid') }}</strong></span>
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
            $('#branchmastercode').selectize({
                maxItems: 1
            });


        });


    </script>

@stop