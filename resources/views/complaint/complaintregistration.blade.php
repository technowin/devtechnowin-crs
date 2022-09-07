@extends('layouts.app')

@section('pageTitle', 'New Complaint')

@section('content')

    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Lodge New Complaint </h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>

            <div class="container">
                <br>
                {{ Form::open(array('url' => 'newcomplaint/register')) }}

                <div class="row{{ $errors->has('customertype') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Type</label>
                    <div class="col-sm-6">
                        {{ Form::select('customertype', array('' => '--SELECT--','Existing' => 'Existing','New' => 'New'), null, array('placeholder' => 'select','required' => 'required', 'class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('customertype'))
                            <span class="help-block"><strong>{{ $errors->first('customertype') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('customername') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('customername', null,array('class' => 'form-control form-control-sm', 'placeholder'=>'Customer / Company Name','required' => 'required')) }}
                        @if ($errors->has('customername'))
                            <span class="help-block"><strong>{{ $errors->first('customername') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('branchname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('branchname', null, array('class' => 'form-control form-control-sm', 'placeholder'=>'Branch Name','required' => 'required')) }}
                        @if ($errors->has('branchname'))
                            <span class="help-block"><strong>{{ $errors->first('branchname') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('productservice') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product & Service</label>
                    <div class="col-sm-6">
                        {{ Form::select('productservice', $productservice, null, array('placeholder' => 'select','required' => 'required', 'class' => 'form-control form-control-sm', 'id' => 'productservice', 'rel' => URL::to('/'),'required' => 'required')) }}
                        @if ($errors->has('productservice'))
                            <span class="help-block"><strong>{{ $errors->first('productservice') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('category') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Category</label>
                    <div class="col-sm-6">
                        {{ Form::select('category',array(null => 'select'),null, array('placeholder' => 'select','required' => 'required', 'class' => 'form-control form-control-sm', 'id' => 'category', 'rel' => URL::to('/'))) }}
                        @if ($errors->has('productservice'))
                            <span class="help-block"><strong>{{ $errors->first('category') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('subcategory') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Sub-Category</label>
                    <div class="col-sm-6">
                        {{ Form::select('subcategory', array('' => 'select'), null, array('placeholder' => 'select','required' => 'required', 'class' => 'form-control form-control-sm', 'id' => 'subcategory', 'rel' => URL::to('/'))) }}
                        @if ($errors->has('subcategory'))
                            <span class="help-block"><strong>{{ $errors->first('subcategory') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product Serial No</label>
                    <div class="col-sm-6">
                        {{ Form::text('productsrno_accountno', null,array('class' => 'form-control form-control-sm', 'placeholder'=>'Product Serial No.')) }}
                    </div>
                </div>

                <div class="row{{ $errors->has('complaintdescription') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Complaint Description (Max 500 Chars)</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('complaintdescription',null,['class'=>'form-control form-control-sm', 'rows' => 3, 'cols' => 40, 'required' => 'required']) }}
                        @if ($errors->has('complaintdescription'))
                            <span class="help-block"><strong>{{ $errors->first('complaintdescription') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('yourname') ? ' has-error' : '' }} mt-2">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Your Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('yourname', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('yourname'))
                            <span class="help-block"><strong>{{ $errors->first('yourname') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('mobileno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Mobile No</label>
                    <div class="col-sm-6">
                        {{ Form::number('mobileno', '', array('class' => 'form-control form-control-sm','required' => 'required', 'max'=>'9999999999', 'min'=> '7000000000','required' => 'required')) }}
                        @if ($errors->has('mobileno'))
                            <span class="help-block"><strong>{{ $errors->first('mobileno') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Email ID </label>
                    <div class="col-sm-6">
                        {{ Form::email('email', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('email'))
                            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                    <div class="col-sm-6">
                        {{ Form::submit('Submit', array('class' => 'btn btn-primary offset-4')) }}
                    </div>
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection

<script src="{{ asset('js/jquery-3.1.1.js') }}"></script>
<script src="{{ asset('js/complaintlodging.js') }}"></script>