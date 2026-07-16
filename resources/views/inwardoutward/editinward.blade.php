@extends('layouts.appnew')
@section('page-css')
    <link href="{{ asset('assets/Selectize/css/selectize.css') }}" rel="stylesheet">

@stop
@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div>
                    <h3 class="panel-title"><span class="text-muted">Add Inward Details</span></h3>
                </div>
            </div>
            <div class="panel-body">
                {{ Form::open(array('action' => 'InwardOutwardController@updateinward','method' => 'post', 'role' => 'form-horizontal')) }}
                {{ Form::hidden('inwardno', $editinward->inwardno, array('id' => 'inwardno')) }}
{{--                {{ Form::hidden('branchcode', $editinward->branchcode, array('id' => 'branchcode')) }}--}}
{{--                {{ Form::hidden('assigneecode', $editinward->assigneecode, array('id' => 'assigneecode')) }}--}}
                <div class="row{{ $errors->has('ticketno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Ticket No</label>
                    <div class="col-sm-6">
                        {{ Form::text('ticketno', $editinward->ticketno, array('id' => 'ticketno','class' => 'form-control form-control-sm','readonly' => true)) }}
                        @if ($errors->has('ticketno'))
                            <span class="help-block"><strong>{{ $errors->first('ticketno') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('customername') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('customername', $editinward->customers->customername, array('id' => 'customername','class' => 'form-control form-control-sm','readonly' => true)) }}
                        @if ($errors->has('customername'))
                            <span class="help-block"><strong>{{ $errors->first('customername') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('branchname') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('branchname', $editinward->branch->branchname , array('id' => 'branchname','class' => 'form-control form-control-sm','readonly' => true)) }}
                        @if ($errors->has('branchname'))
                            <span class="help-block"><strong>{{ $errors->first('branchname') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('equipmentsrno') ? ' has-error' : '' }}"  style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Equipment Sr No</label>
                    <div class="col-sm-6">
                        {{ Form::text('equipmentsrno', $editinward->equipmentsrno, array('id' => 'equipmentsrno','class' => 'form-control form-control-sm','readonly' => true)) }}
                        @if ($errors->has('equipmentsrno'))
                            <span class="help-block"><strong>{{ $errors->first('equipmentsrno') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('productsrno') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product Sr No</label>
                    <div class="col-sm-6">
                        {{ Form::text('productsrno', $editinward->productsrno, array('id' => 'productsrno','class' => 'form-control form-control-sm','readonly' => true)) }}
                        @if ($errors->has('productsrno'))
                            <span class="help-block"><strong>{{ $errors->first('productsrno') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('assignee') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Assignee</label>
                    <div class="col-sm-6">
                        {{ Form::text('assignee', $editinward->assignee->assigneename, array('id' => 'assignee','class' => 'form-control form-control-sm','readonly' => true)) }}
                        @if ($errors->has('assignee'))
                            <span class="help-block"><strong>{{ $errors->first('assignee') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('callername') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Caller Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('callername',$editinward->callerName,['class'=>'form-control','required' => 'required']) }}
                        @if ($errors->has('callername'))
                            <span class="help-block"><strong>{{ $errors->first('callername') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('details') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Inward Product Details</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('details',$editinward->inwardProductDetails,['class'=>'form-control', 'rows' => 3, 'cols' => 40, 'required' => 'required','onKeyPress' => "if(this.value.length>=500) return false;"]) }}
                        @if ($errors->has('details'))
                            <span class="help-block"><strong>{{ $errors->first('details') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('comment') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Comment</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('comment',$editinward->inwardComment,['class'=>'form-control', 'rows' => 3, 'cols' => 40, 'required' => 'required','onKeyPress' => "if(this.value.length>=500) return false;"]) }}
                        @if ($errors->has('comment'))
                            <span class="help-block"><strong>{{ $errors->first('comment') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('inwarddate') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Inward Date</label>
                    <div class="col-sm-6">
                        {{ Form::text('inwarddate',$editinward->inwardDate,array('id' => 'inwarddate','class' => 'form-control form-control-sm','readonly' => true)) }}
                        @if ($errors->has('inwarddate'))
                            <span class="help-block"><strong>{{ $errors->first('inwarddate') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row"  style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                    <div class="col-sm-2">
                        {{ Form::submit('Save',array('class' => 'btn btn-primary')) }}

                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-success offset-4" href="{{url()->previous()}}">Cancel</a>
                    </div>
                    <div class="col-sm-2"></div>
                </div>

                {{ Form::close() }}

            </div>
        </div>
    </div>
@endsection
