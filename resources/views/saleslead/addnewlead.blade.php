@extends('layouts.app')

@section('pageTitle', 'Add New Sales Lead')

@section('content')
    <link href="{{ asset('assets/Selectize/css/selectize.css') }}" rel="stylesheet">
    <br/>
    <div class="container card col-md-9">
        <div class="col card-block">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Add New Sales Lead</h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>

            <div class="container">
                <br>
                {{ Form::open(array('url' => 'saleslead/newlead','onsubmit' => 'return checkvalidation();')) }}

                <div class="row{{ $errors->has('meetingdate') ? ' has-error' : '' }}" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Meeting Date</label>
                    <div class="col-sm-6">
                        {{ Form::date('meetingdate', null, array(
                        'required' => 'required', 'class' => 'form-control form-control-sm')) }}
                        @if ($errors->has('meetingdate'))
                            <span class="help-block"><strong>{{ $errors->first('meetingdate') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('customername') ? ' has-error' : '' }}" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Customer Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('customername', null, array('placeholder' => 'Customer Name','required' => 'required', 'class' => 'form-control form-control-sm')) }}
                        @if ($errors->has('customername'))
                            <span class="help-block"><strong>{{ $errors->first('customername') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('customeraddress') ? ' has-error' : '' }}" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Customer Address</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('customeraddress',null , array('placeholder' => 'Customer Address', 'class' => 'form-control form-control-sm', 'rows' => '2')) }}
                        @if ($errors->has('customeraddress'))
                            <span class="help-block"><strong>{{ $errors->first('customeraddress') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('customermobileno') ? ' has-error' : '' }}" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Customer Mobile No</label>
                    <div class="col-sm-6">
                        {{ Form::number('customermobileno', null, array('placeholder' => 'Customer Mobile No', 'class' => 'form-control form-control-sm')) }}
                        @if ($errors->has('customermobileno'))
                            <span class="help-block"><strong>{{ $errors->first('customermobileno') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('customeremail') ? ' has-error' : '' }}" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Customer Email Id</label>
                    <div class="col-sm-6">
                        {{ Form::email('customeremail', null, array('placeholder' => 'Customer Email Id', 'class' => 'form-control form-control-sm')) }}
                        @if ($errors->has('customeremail'))
                            <span class="help-block"><strong>{{ $errors->first('customeremail') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('product') ? ' has-error' : '' }}" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Product</label>
                    <div class="col-sm-6">
                        {{ Form::select('product[]', $productservice, null, array('placeholder' => '--SELECT--', 'id' => 'productservice', 'multiple'=>'multiple')) }}
                        @if ($errors->has('product'))
                            <span class="help-block"><strong>{{ $errors->first('product') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('salescomment') ? ' has-error' : '' }}" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Sales Comment</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('salescomment',null , array('placeholder' => 'Sales Comment', 'class' => 'form-control form-control-sm', 'rows' => '2')) }}
                        @if ($errors->has('salescomment'))
                            <span class="help-block"><strong>{{ $errors->first('salescomment') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('futureaction') ? ' has-error' : '' }}" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Future Action</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('futureaction',null , array('placeholder' => 'Future Action', 'class' => 'form-control form-control-sm', 'rows' => '2')) }}
                        @if ($errors->has('futureaction'))
                            <span class="help-block"><strong>{{ $errors->first('futureaction') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('futureactiondate') ? ' has-error' : '' }}" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Future Action Date</label>
                    <div class="col-sm-6">
                        {{ Form::date('futureactiondate', null, array('class' => 'form-control form-control-sm')) }}
                        @if ($errors->has('futureactiondate'))
                            <span class="help-block"><strong>{{ $errors->first('futureactiondate') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('salesorderreceived') ? ' has-error' : '' }}" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Sales Order Received</label>
                    <div class="col-sm-6">
                        {{ Form::select('salesorderreceived', array(''=>'--SELECT--','Yes'=>'Yes', 'No'=>'No'), null, array('class' => '', 'id' => 'salesorderreceived')) }}
                        @if ($errors->has('salesorderreceived'))
                            <span class="help-block"><strong>{{ $errors->first('salesorderreceived') }}</strong></span>
                        @endif
                    </div>
                </div>
                <br>
                <div class="row">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted"></label>
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
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>

    <script>
        $('#salesorderreceived').selectize({
            maxItems: 1
        });

        $('#productservice').selectize({
            delimiter: ',',
            persist: false
        });

//        Selectize Validation
        function checkvalidation() {

            var message = '';
            if($("#productservice").val() == null){
                message = checkifempty(message, 'Atleast one product needs to be selected');
            }

            if(message != ''){
                alert(message);
//                alert(message + ' required');
                return false;
            }
            return true;
        }

        function checkifempty(message, tobeadded){
            if(message == ''){
                message = tobeadded;
            }
            else {
                message = message+', ' + tobeadded;
            }
            return message;
        }
    </script>

@endsection