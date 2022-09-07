@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')

    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted"> Edit Sector</h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>
            <BR>
            <div class="container">
                {{ Form::model($sectors, array('route' => array('sectors.update', $sectors->sectorcode), 'method' => 'PUT')) }}

                <div class="row{{ $errors->has('sectorname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Sector Name</label>
                    <div class="col-sm-6">
                       {{ Form::text('sectorname', null, array('class' => 'form-control form-control-sm')) }}
                    </div>

                </div>

                <div class="row{{ $errors->has('sectordescription') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Sector Description</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('sectordescription', null, array('rows'=>3,'class' => 'form-control form-control-sm')) }}
                    </div>

                </div>
<br>

                <div class="row{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Is Active</label>
                    <div class="col-sm-6">
                        {{ Form::select('isactive', array('select'=>'--SELECT--','1' => 'Yes','0' => 'No'),null, array('placeholder' => 'select','required' => 'required', 'class' => 'form-control form-control-sm', 'id' => 'category', 'rel' => URL::to('/'))) }}
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
	