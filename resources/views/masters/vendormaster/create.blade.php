@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')

    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Add Vendor </h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>
            <BR>
            <div class="container">
                {{ Form::open(array('url' => 'vendor')) }}
                <div class="row{{ $errors->has('vendorname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Vendor Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('vendorname', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('vendorname'))
                            <span class="help-block"><strong>{{ $errors->first('vendorname') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('vendorphoneno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Vendor Phone</label>
                    <div class="col-sm-6">
                        {{ Form::number('vendorphoneno', '', array('class' => 'form-control form-control-sm','required' => 'required','onKeyPress'=>'if(this.value.length==10) return false;' )) }}
                        @if ($errors->has('vendorphoneno'))
                            <span class="help-block"><strong>{{ $errors->first('vendorphoneno') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('vendoremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Vendor Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('vendoremail', '', array('required' => 'required','class' => 'form-control form-control-sm' )) }}
                        @if ($errors->has('vendoremail'))
                            <span class="help-block"><strong>{{ $errors->first('calleremail') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('vendorfax') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Vendor Fax</label>
                    <div class="col-sm-6">
                        {{ Form::text('vendorfax', '', array('class' => 'form-control form-control-sm','required' => 'required','onKeyPress'=>'if(this.value.length==12) return false;' )) }}
                        @if ($errors->has('vendorfax'))
                            <span class="help-block"><strong>{{ $errors->first('vendorfax') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('vendorwebsite') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Vendor Website</label>
                    <div class="col-sm-6">
                        {{ Form::text('vendorwebsite', '', array('class' => 'form-control form-control-sm','required' => 'required','onKeyPress'=>'if(this.value.length==12) return false;' )) }}
                        @if ($errors->has('vendorwebsite'))
                            <span class="help-block"><strong>{{ $errors->first('vendorwebsite') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('contactpersonno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person No</label>
                    <div class="col-sm-6">
                        {{ Form::number('contactpersonno', '', array('class' => 'form-control form-control-sm','required' => 'required','onKeyPress'=>'if(this.value.length==10) return false;','onKeyPress'=>'if(this.value.length==10) return false;' )) }}
                        @if ($errors->has('contactpersonno'))
                            <span class="help-block"><strong>{{ $errors->first('contactpersonno') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('contactpersonemail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person Email</label>
                    <div class="col-sm-6">
                        {{ Form::text('contactpersonemail', '', array('class' => 'form-control form-control-sm','required' => 'required' )) }}
                        @if ($errors->has('contactpersonemail'))
                            <span class="help-block"><strong>{{ $errors->first('contactpersonemail') }}</strong></span>
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