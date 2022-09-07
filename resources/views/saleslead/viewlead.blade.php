@extends('layouts.app')

@section('pageTitle', 'Edit Sales Lead')

@section('content')
    <br/>
    <div class="container card col-md-9">
        <div class="col card-block">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Sales Lead Details</h5></div>
                {{--<div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>--}}
            </div>

            <div class="container">
                <br>
                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Meeting Date</label>
                    <div class="col-sm-6">
                        {{ Form::label('meetingdate', $meetingdate) }}
                    </div>
                </div>
                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Customer Name</label>
                    <div class="col-sm-6">
                        {{ Form::label('customername', $customername) }}
                    </div>
                </div>
                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Customer Address</label>
                    <div class="col-sm-6">
                        {{ Form::label('customeraddress',$customeraddress) }}
                    </div>
                </div>
                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Customer Mobile No</label>
                    <div class="col-sm-6">
                        {{ Form::label('customermobileno', $customermobileno) }}
                    </div>
                </div>
                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Customer Email Id</label>
                    <div class="col-sm-6">
                        {{ Form::label('customeremail', $customeremail) }}
                    </div>
                </div>
                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Product</label>
                    <div class="col-sm-6">
                        {{ Form::label('product', $productsname) }}
                    </div>
                </div>
                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Sales Comment</label>
                    <div class="col-sm-6">
                        {{ Form::label('salescomment',$salescomment) }}
                    </div>
                </div>
                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Future Action</label>
                    <div class="col-sm-6">
                        {{ Form::label('futureaction',$futureaction) }}
                    </div>
                </div>
                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Future Action Date</label>
                    <div class="col-sm-6">
                        {{ Form::label('futureactiondate', $futureactiondate) }}
                    </div>
                </div>
                <div class="row" style="padding: 3px">
                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Sales Order Received</label>
                    <div class="col-sm-6">
                        {{ Form::label('salesorderreceived', $salesorderreceived)}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection