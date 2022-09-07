@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')

    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Add Product Service</h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>
            <BR>
            <div class="container">
                {{ Form::open(array('url' => 'sectors')) }}

                <div class="row{{ $errors->has('sectordescription') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Sector Name </label>
                    <div class="col-sm-6">
                        {{ Form::select('sectorscode', $sectorscode, null, array('placeholder' => 'select','required' => 'required', 'id'=>'sectorcode')) }}
                        @if ($errors->has('departmentcode'))
                            <span class="help-block"><strong>{{ $errors->first('sectordescription') }}</strong></span>
                        @endif
                    </div>
                </div>


                <div class="row{{ $errors->has('productservicename') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product Service Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('productservicename', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('productservicename'))
                            <span class="help-block"><strong>{{ $errors->first('productservicename') }}</strong></span>
                        @endif
                    </div>
                </div>


                <div class="row{{ $errors->has('productservicedescription') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product Service Description</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('productservicedescription', '', array('rows'=>3,'class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('productservicedescription'))
                            <span class="help-block"><strong>{{ $errors->first('productservicedescription') }}</strong></span>
                        @endif
                    </div>
                </div>
<br>
                <div class="row{{ $errors->has('isactive') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Is Active</label>
                    <div class="col-sm-6">
                        {{ Form::select('isactive', array('select'=>'--SELECT--','1' => 'Yes','0' => 'No'),null, array('placeholder' => 'select','required' => 'required', 'class' => 'form-control form-control-sm', 'id' => 'category', 'rel' => URL::to('/'))) }}
                        @if ($errors->has('isactive'))
                            <span class="help-block"><strong>{{ $errors->first('isactive') }}</strong></span>
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
	