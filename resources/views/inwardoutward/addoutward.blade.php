@extends('layouts.appnew')
@section('page-css')
    <link href="{{ asset('assets/Selectize/css/selectize.css') }}" rel="stylesheet">

@stop
@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div>
                    <h3 class="panel-title"><span class="text-muted">Add Outward Details</span></h3>
                </div>
            </div>
            <div class="panel-body">
                {{ Form::open(array('action' => 'InwardOutwardController@saveoutward','method' => 'post', 'role' => 'form-horizontal')) }}
                {{ Form::hidden('id',$outward->id, array('id' => 'id'))}}

                <div class="row{{ $errors->has('ticketno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Ticket No</label>
                    <div class="col-sm-6">
                        {{ Form::text('ticketno', $outward->ticketno, array('id' => 'ticketno','class' => 'form-control form-control-sm','readonly' => true)) }}
                        @if ($errors->has('ticketno'))
                            <span class="help-block"><strong>{{ $errors->first('ticketno') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('customername') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('customername', $outward->customers->customername, array('id' => 'customername','class' => 'form-control form-control-sm','readonly' => true)) }}
                        @if ($errors->has('customername'))
                            <span class="help-block"><strong>{{ $errors->first('customername') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('branchname') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('branchname', $outward->branch->branchname , array('id' => 'branchname','class' => 'form-control form-control-sm','readonly' => true)) }}
                        @if ($errors->has('branchname'))
                            <span class="help-block"><strong>{{ $errors->first('branchname') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('equipmentsrno') ? ' has-error' : '' }}"  style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Equipment Sr No</label>
                    <div class="col-sm-6">
                        {{ Form::text('equipmentsrno', $outward->equipmentsrno, array('id' => 'equipmentsrno','class' => 'form-control form-control-sm','readonly' => true)) }}
                        @if ($errors->has('equipmentsrno'))
                            <span class="help-block"><strong>{{ $errors->first('equipmentsrno') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('productsrno') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product Sr No</label>
                    <div class="col-sm-6">
                        {{ Form::text('productsrno', $outward->productsrno, array('id' => 'productsrno','class' => 'form-control form-control-sm','readonly' => true)) }}
                        @if ($errors->has('productsrno'))
                            <span class="help-block"><strong>{{ $errors->first('productsrno') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('callername') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Caller Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('callername', $outward->callerName, array('id' => 'callername','class' => 'form-control form-control-sm','readonly' => true)) }}
                        @if ($errors->has('callername'))
                            <span class="help-block"><strong>{{ $errors->first('callername') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('inwardno') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Inward No</label>
                    <div class="col-sm-6">
                        {{ Form::text('inwardno', $outward->inwardno, array('id' => 'inwardno','class' => 'form-control form-control-sm','readonly' => true)) }}
                        @if ($errors->has('inwardno'))
                            <span class="help-block"><strong>{{ $errors->first('inwardno') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('inwarddate') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Inward Date</label>
                        <div class="col-sm-6">
                        {{ Form::text('inwarddate', $outward->inwardDate, array('id' => 'inwarddate','class' => 'form-control form-control-sm','readonly' => true)) }}
                        @if ($errors->has('inwarddate'))
                            <span class="help-block"><strong>{{ $errors->first('inwarddate') }}</strong></span>
                        @endif
                    </div>
                </div>
{{--                <div class="row{{ $errors->has('challanno') ? ' has-error' : '' }}" style="padding-top: 5px;">--}}
{{--                    <label for="input" class="col-sm-4 col-form-label text-muted">Challan No</label>--}}
{{--                    <div class="col-sm-6">--}}
{{--                        {{ Form::text('challanno', $outward->challanNo, array('id' => 'challanno','class' => 'form-control form-control-sm','readonly' => true)) }}--}}
{{--                        @if ($errors->has('challanno'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('challanno') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="row{{ $errors->has('challandate') ? ' has-error' : '' }}" style="padding-top: 5px;">--}}
{{--                    <label for="input" class="col-sm-4 col-form-label text-muted">Challan Date</label>--}}
{{--                    <div class="col-sm-6">--}}
{{--                        {{ Form::text('challandate', $outward->challanDate, array('id' => 'challandate','class' => 'form-control form-control-sm','readonly' => true)) }}--}}
{{--                        @if ($errors->has('challandate'))--}}
{{--                            <span class="help-block"><strong>{{ $errors->first('challandate') }}</strong></span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="row{{ $errors->has('assignee') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Assignee</label>
                    <div class="col-sm-6">
                        {{ Form::select('assignee', $assigneelist,$outward->assigneecode, array('id' => 'assignee')) }}
                        @if ($errors->has('assignee'))
                            <span class="help-block"><strong>{{ $errors->first('assignee') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('details') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Outward Product Details</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('details',null,['class'=>'form-control', 'rows' => 3, 'cols' => 40, 'required' => 'required','onKeyPress' => "if(this.value.length>=500) return false;"]) }}
                        @if ($errors->has('details'))
                            <span class="help-block"><strong>{{ $errors->first('details') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('quantity') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Quantity</label>
                    <div class="col-sm-6">
                        {{ Form::number('quantity',null,array('id' => 'quantity','class' => 'form-control form-control-sm')) }}
                        @if ($errors->has('quantity'))
                            <span class="help-block"><strong>{{ $errors->first('quantity') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('comment') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Comment</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('comment',null,['class'=>'form-control', 'rows' => 3, 'cols' => 40, 'required' => 'required','onKeyPress' => "if(this.value.length>=500) return false;"]) }}
                        @if ($errors->has('comment'))
                            <span class="help-block"><strong>{{ $errors->first('comment') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('outwarddate') ? ' has-error' : '' }}" style="padding-top: 5px;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Outward Date</label>
                    <div class="col-sm-6">
                        {{ Form::text('outwarddate',null,array('id' => 'outwarddate','class' => 'form-control form-control-sm','readonly' => true,'style'=>'background-color:white;')) }}
                        @if ($errors->has('outwarddate'))
                            <span class="help-block"><strong>{{ $errors->first('outwarddate') }}</strong></span>
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
@section('selectize-script')
    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#assignee').selectize({
                maxItems: 1
            });

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            today = mm + '/' + dd + '/' + yyyy;
            $('#outwarddate').val(today);
        })

    </script>
@endsection