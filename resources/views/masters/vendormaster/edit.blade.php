@extends('layouts.app')

@section('page-title', '| Add User')

@section('content')

    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted"> Edit Vendor</h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>
            <BR>
            <div class="container">
                {{ Form::model($vendor, array('route' => array('vendor.update', $vendor->vendorcode), 'method' => 'PUT')) }}

                <div class="row{{ $errors->has('vendorname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Vendor Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('vendorname', null, array('class' => 'form-control form-control-sm','required' => 'required')) }}
                    </div>
                </div>

                <div class="row{{ $errors->has('vendorphoneno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Vendor Phone</label>
                    <div class="col-sm-6">
                        {{ Form::number('vendorphoneno', null, array('class' => 'form-control form-control-sm','required' => 'required','onKeyPress'=>'if(this.value.length==10) return false;' )) }}
                    </div>
                </div>


                <div class="row{{ $errors->has('vendoremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Vendor Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('vendoremail', null, array('required' => 'required','class' => 'form-control form-control-sm' )) }}
                    </div>
                </div>

                <div class="row{{ $errors->has('vendorfax') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Vendor Fax</label>
                    <div class="col-sm-6">
                        {{ Form::text('vendorfax', null, array('class' => 'form-control form-control-sm','required' => 'required','onKeyPress'=>'if(this.value.length==12) return false;' )) }}
                    </div>
                </div>

                <div class="row{{ $errors->has('vendorwebsite') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Vendor Website</label>
                    <div class="col-sm-6">
                        {{ Form::text('vendorwebsite', null, array('class' => 'form-control form-control-sm','required' => 'required' )) }}
                    </div>
                </div>

                <div class="row{{ $errors->has('contactpersonno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person No</label>
                    <div class="col-sm-6">
                        {{ Form::number('contactpersonno', null, array('class' => 'form-control form-control-sm','required' => 'required','onKeyPress'=>'if(this.value.length==10) return false;' )) }}
                    </div>
                </div>

                <div class="row{{ $errors->has('contactpersonemail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Contact Person Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('contactpersonemail', null, array('class' => 'form-control form-control-sm','required' => 'required')) }}
                    </div>
                </div>
                <br>


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
	