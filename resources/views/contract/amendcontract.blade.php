@extends('layouts.appnew')

@section('pageTitle', 'Add Contract')

{{--@section('head-css')--}}
{{--<link href="{{ asset('assets/Selectize/css/selectize.css') }}" rel="stylesheet">--}}
{{--@stop--}}

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-12 row text-center">
                    <h3> Amendment For Contract No. <font color="red"> {{ $id }}</font></h3>
                    <br/>
                    <h3> Customer Name : <font color="red"> {{ $customername }}</font></h3>
                    <hr/>
                </div>
                {{ Form::open(['action' => ['ContractController@amendcontractcreatenewcontract', $id]]) }}
                <div class="row{{ $errors->has('contractfromdate') ? ' has-error' : '' }} mt-1">
                    <div class="col-sm-1"></div>
                    <label for="input" class="col-sm-3 col-form-label text-muted">Contract From
                        Date</label>
                    <div class="col-sm-6">
                        {{ Form::date('contractfromdate', null, array('id'=>'contractfromdateid','class' => 'form-control','required' => 'required','onchange'=>'getservicedate()','max'=> '2050-12-31')) }}
                        @if ($errors->has('contractfromdate'))
                            <span class="help-block"><strong>{{ $errors->first('contractfromdate') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row {{ $errors->has('contracttodate') ? ' has-error' : '' }} mt-1">
                    <div class="col-sm-1"></div>
                    <label for="input" class="col-sm-3 col-form-label text-muted">Contract To
                        Date</label>
                    <div class="col-sm-6">
                        {{ Form::date('contracttodate', null, array('id'=>'contracttodateid','class' => 'form-control','required' => 'required','onchange' => 'getyear()','max'=> '2050-12-31')) }}
                        @if ($errors->has('contracttodate'))
                            <span class="help-block"><strong>{{ $errors->first('contracttodate') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('amendmentno') ? ' has-error' : '' }} mt-1">
                    <div class="col-sm-1"></div>
                    <label for="input" class="col-sm-3 col-form-label text-muted">Amendment No</label>
                    <div class="col-sm-6">
                        {{ Form::text('amendmentno', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('amendmentno'))
                            <span class="help-block"><strong>{{ $errors->first('amendmentno') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('amendmentdescription') ? ' has-error' : '' }} mt-1">
                    <div class="col-sm-1"></div>
                    <label for="input" class="col-sm-3 col-form-label text-muted">Amendment Description</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('amendmentdescription',null,['class'=>'form-control form-control-sm','required' => 'required', 'rows' => 3, 'cols' => 40,'onKeyPress' => "if(this.value.length==500) return false;"]) }}
                        @if ($errors->has('amendmentdescription'))
                            <span class="help-block"><strong>{{ $errors->first('amendmentdescription') }}</strong></span>
                        @endif
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-sm-1"></div>
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