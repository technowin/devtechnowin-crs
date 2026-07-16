@extends('layouts.appnew')

@section('page-title', '| Customers')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Dispatch Sale Quantity </h3>
            </div>
            <div class="panel-body">
                <div class="container">
                    {{ Form::open(array('url'=>'/savedispatch', 'files' =>true )) }}

                    {{Form::hidden('id',$quotationdetails->id,array('id'=>'id'))}}
                    {{--{{Form::hidden('branchcode',$existingusercomplaint->branchcode,array('id'=>'branchcode'))}}--}}

                    <div class="row mt-1{{ $errors->has('ticketno') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Quotation Number</label>
                        <div class="col-sm-6">
                            {{ Form::text('quotationnumber',$quotationdetails->quotationnumber, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('ticketno') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Ticket No</label>
                        <div class="col-sm-6">
                            {{ Form::text('ticketno',$quotationdetails->ticketno, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('productsrno') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Product Sr.No</label>
                        <div class="col-sm-6">
                            {{ Form::text('productsrno',$quotationdetails->productsrno, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('customername') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('customername',$customername->customername, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('dispatchsaledate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Dispatch Sale Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('dispatchsaledate',null, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('dispatchsalequantity') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Dispatch Sale Quantity</label>
                        <div class="col-sm-6">
                            {{ Form::number('dispatchsalequantity',null, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('dispatchsaledetails') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Dispatch Sale Details (Max 500 Chars)</label>
                        <div class="col-sm-6">
                            {{ Form::textarea('dispatchsaledetails',null,array('class'=>'form-control', 'rows' => 3, 'cols' => 70,'maxlength'=>500)) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('saleamount') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Sale Amount</label>
                        <div class="col-sm-6">
                            {{ Form::number('saleamount',null, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('senttoscrap') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Sent to Scrap</label>
                        <div class="col-sm-6">
                            {{ Form::select('senttoscrap',array('YES'=>'YES','NO'=>'NO'),null, array('placeholder'=>'--Select--','class' => 'form-control','id'=>'senttoscrap','required')) }}
                        </div>
                    </div>
                    <div id="hidediv" hidden>
                    <div class="row mt-1{{ $errors->has('scrappeddate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Scrapped Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('scrappeddate',null, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('scrapdetails') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Scrap Details (Max 500 Chars)</label>
                        <div class="col-sm-6">
                            {{ Form::textarea('scrapdetails',null, array('class' => 'form-control','rows'=>3,'cols'=>50,'maxlength'=>500)) }}
                        </div>
                    </div>
                    </div>
                    <br>
                    <div align="center">
                        {{Form::submit('Save',array('class'=>'btn btn-primary'))}}
                    </div>
                    {{ Form::close() }}
            </div>
        </div>
    </div>
    </div>
 @endsection


@section('page-script')
<script type="text/javascript">
    $("#senttoscrap").change(function () {
        if($("#senttoscrap").val()=='YES'){
            $("#hidediv").show();
        }else {
            $("#hidediv").hide();
        }
    })


</script>

@stop