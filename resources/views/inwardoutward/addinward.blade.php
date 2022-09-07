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
            {{ Form::open(array('action' => 'InwardOutwardController@saveinward','method' => 'post', 'role' => 'form-horizontal')) }}
            {{ Form::hidden('customercode', '', array('id' => 'customercode')) }}
            {{ Form::hidden('branchcode', '', array('id' => 'branchcode')) }}
            {{ Form::hidden('assigneecode', '', array('id' => 'assigneecode')) }}
            <div class="row{{ $errors->has('ticketno') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-4 col-form-label text-muted">Ticket No</label>
                <div class="col-sm-6">
                    {{ Form::select('ticketno', $tickets, null, array('placeholder' => '--SELECT--', 'id' => 'ticketno')) }}
                    @if ($errors->has('ticketno'))
                        <span class="help-block"><strong>{{ $errors->first('ticketno') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('customername') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                <div class="col-sm-6">
                    {{ Form::text('customername', null, array('id' => 'customername','class' => 'form-control form-control-sm','readonly' => true,'style'=>'background-color:white;')) }}
                    @if ($errors->has('customername'))
                        <span class="help-block"><strong>{{ $errors->first('customername') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('branchname') ? ' has-error' : '' }}" style="padding-top: 5px;">
                <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name</label>
                <div class="col-sm-6">
                    {{ Form::text('branchname', null, array('id' => 'branchname','class' => 'form-control form-control-sm','readonly' => true,'style'=>'background-color:white;')) }}
                    @if ($errors->has('branchname'))
                        <span class="help-block"><strong>{{ $errors->first('branchname') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('equipmentsrno') ? ' has-error' : '' }}"  style="padding-top: 5px;">
                <label for="input" class="col-sm-4 col-form-label text-muted">Equipment Sr No</label>
                <div class="col-sm-6">
                    {{ Form::text('equipmentsrno', null, array('id' => 'equipmentsrno','class' => 'form-control form-control-sm','readonly' => true,'style'=>'background-color:white;')) }}
                    @if ($errors->has('equipmentsrno'))
                        <span class="help-block"><strong>{{ $errors->first('equipmentsrno') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('productsrno') ? ' has-error' : '' }}" style="padding-top: 5px;">
                <label for="input" class="col-sm-4 col-form-label text-muted">Product Sr No</label>
                <div class="col-sm-6">
                    {{ Form::text('productsrno', null, array('id' => 'productsrno','class' => 'form-control form-control-sm','readonly' => true,'style'=>'background-color:white;')) }}
                    @if ($errors->has('productsrno'))
                        <span class="help-block"><strong>{{ $errors->first('productsrno') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('assignee') ? ' has-error' : '' }}" style="padding-top: 5px;">
                <label for="input" class="col-sm-4 col-form-label text-muted">Assignee</label>
                <div class="col-sm-6">
                    {{ Form::text('assignee', null, array('id' => 'assignee','class' => 'form-control form-control-sm','readonly' => true,'style'=>'background-color:white;')) }}
                    @if ($errors->has('assignee'))
                        <span class="help-block"><strong>{{ $errors->first('assignee') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('callername') ? ' has-error' : '' }}" style="padding-top: 5px;">
                <label for="input" class="col-sm-4 col-form-label text-muted">Caller Name</label>
                <div class="col-sm-6">
                    {{ Form::text('callername',null,['class'=>'form-control','required' => 'required']) }}
                    @if ($errors->has('callername'))
                        <span class="help-block"><strong>{{ $errors->first('callername') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('details') ? ' has-error' : '' }}" style="padding-top: 5px;">
                <label for="input" class="col-sm-4 col-form-label text-muted">Inward Product Details</label>
                <div class="col-sm-6">
                    {{ Form::textarea('details',null,['class'=>'form-control', 'rows' => 3, 'cols' => 40, 'required' => 'required','onKeyPress' => "if(this.value.length>=500) return false;"]) }}
                    @if ($errors->has('details'))
                        <span class="help-block"><strong>{{ $errors->first('details') }}</strong></span>
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
            <div class="row{{ $errors->has('inwarddate') ? ' has-error' : '' }}" style="padding-top: 5px;">
                <label for="input" class="col-sm-4 col-form-label text-muted">Inward Date</label>
                <div class="col-sm-6">
                    {{ Form::text('inwarddate',null,array('id' => 'inwarddate','class' => 'form-control form-control-sm','readonly' => true,'style'=>'background-color:white;')) }}
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
@section('selectize-script')
    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script>
        $(document).ready(function()
        {
            $('#ticketno').selectize({
                maxItems: 1
            });
        });
    </script>
    <script>
        $('#ticketno').change(function () {
            var ticket = $('#ticketno').val();
            $.ajax({
                url:"{{URL::to('getticketdetails')}}/"+ ticket,
                type: "GET",
                data: {'ticket': ticket},
                dataType:"json",
                success: function(data){
                    if(data.ticketno != null)
                    {
                        var today = new Date();
                        var dd = String(today.getDate()).padStart(2, '0');
                        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                        var yyyy = today.getFullYear();
                        today = mm + '/' + dd + '/' + yyyy;
                        $('#customername').val(data.customername);
                        $('#customercode').val(data.ticketno.customercode);
                        $('#branchname').val(data.branchname);
                        $('#branchcode').val(data.ticketno.branchcode);
                        $('#assignee').val(data.assignee);
                        $('#assigneecode').val(data.assigneecode.assigneecode);
                        $('#equipmentsrno').val(data.ticketno.productsrno_accountno);
                        $('#productsrno').val(data.ticketno.productsrno);
                        $('#inwarddate').val(today);
                    }
                    else{
                        alert('There some Error in Processing the data.');
                    }
                }
            })
        })
    </script>
@endsection