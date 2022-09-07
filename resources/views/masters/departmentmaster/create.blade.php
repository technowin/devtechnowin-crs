@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')



    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Add Department</h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>
            <BR>
            <div class="container">
                {{ Form::open(array('url' => 'sectors')) }}

                <div class="row{{ $errors->has('sectordescription') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Sector Name </label>
                    <div class="col-sm-6">
                        {{ Form::select('sectorscode', $sectorscode, null, array('placeholder' => 'select','required' => 'required','id'=>'sectorcode')) }}
                        @if ($errors->has('departmentcode'))
                            <span class="help-block"><strong>{{ $errors->first('sectordescription') }}</strong></span>
                        @endif
                    </div>
                </div>


                <div class="row{{ $errors->has('sectorcode') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Department Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('sectorcode', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('sectorcode'))
                            <span class="help-block"><strong>{{ $errors->first('sectorcode') }}</strong></span>
                        @endif
                    </div>
                </div>


                <div class="row{{ $errors->has('departmentdescription') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Department Description</label>
                    <div class="col-sm-6">
                        {{ Form::text('departmentdescription', '', array('rows'=>3,'class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('departmentdescription'))
                            <span class="help-block"><strong>{{ $errors->first('departmentdescription') }}</strong></span>
                        @endif
                    </div>
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


@endsection


@section('script-js')
    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script>

        $(document).ready(function () {
            $('#sectorcode').selectize({
                maxItems: 1
            });
        });
    </script>

@stop
	