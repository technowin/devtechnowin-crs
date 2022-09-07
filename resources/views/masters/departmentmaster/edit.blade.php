@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')

    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted"> Edit Department</h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>
            <BR>
            <div class="container">
                {{ Form::model($departmentmaster , array('route' => array('department.update', $departmentmaster->departmentcode), 'method' => 'PUT')) }}

                <div class="row{{ $errors->has('sectorname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Sector Name</label>
                    <div class="col-sm-6">
                        {{ Form::select('department', $department, $sectorcode, array('placeholder' => 'select','required' => 'required','id'=>'sectorcode' )) }}
                    </div>

                </div>

                <div class="row{{ $errors->has('departmentname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Department Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('departmentname', null, array('class' => 'form-control form-control-sm')) }}
                    </div>

                </div>

                <div class="row{{ $errors->has('departmentdescription') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Department Description</label>
                    <div class="col-sm-6">
                        {{ Form::text('departmentdescription', null, array('rows'=>3,'class' => 'form-control form-control-sm')) }}
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
            $('#sectorcode').selectize({
                maxItems: 1
            });
        });
    </script>

@stop
	