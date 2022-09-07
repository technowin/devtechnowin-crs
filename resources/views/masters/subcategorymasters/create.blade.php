@extends('layouts.appnew')
@section('page-title', '| Add User')
@section('content')
    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Add Sub Category</h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>
            <BR>
            <div class="container">
                {{ Form::open(array('url' => 'appadmin/subcategory')) }}
                <div class="row{{ $errors->has('subategoryname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Sub Category Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('subategoryname', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('Categorycode'))
                            <span class="help-block"><strong>{{ $errors->first('subategoryname') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('subcategoryname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Category Name</label>
                    <div class="col-sm-6">
                        {{ Form::select('Categorycode', $Categorycode, null, array('placeholder' => 'select','required' => 'required', 'id' => 'productservice')) }}
                        @if ($errors->has('sectordescription'))
                            <span class="help-block"><strong>{{ $errors->first('subcategoryname') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('subcategorydescription') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Sub Category Description</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('subcategorydescription', '', array('rows'=>3,'class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('subcategorydescription'))
                            <span class="help-block"><strong>{{ $errors->first('subcategorydescription') }}</strong></span>
                        @endif
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


@section('script-js')
    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#productservice').selectize({
                maxItems: 1
            });
        });
    </script>
@stop
