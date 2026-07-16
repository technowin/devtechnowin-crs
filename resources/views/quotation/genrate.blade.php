@extends('layouts.appnew')

@section('page-title', '| Customers')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Request Quotation Details</h3>
            </div>
            <div class="panel-body">
                <div class="container">
                    {{ Form::open(array('url'=>'savequotation', 'files' =>true )) }}

                    {{Form::hidden('customercode',$existingusercomplaint->customercode,array('id'=>'customercode'))}}
                    {{Form::hidden('branchcode',$existingusercomplaint->branchcode,array('id'=>'branchcode'))}}
                    {{Form::hidden('typeofcall',$existingusercomplaint->typeofcall)}}
                    <div class="row mt-1{{ $errors->has('ticketno') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Ticket No</label>
                        <div class="col-sm-6">
                            {{ Form::text('ticketno',$existingusercomplaint->ticketno, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('productsrno') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Product Sr.No</label>
                        <div class="col-sm-6">
                            {{ Form::text('productsrno',$existingusercomplaint->productsrno_accountno, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('customername') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('customername',$customername->customername, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('product') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Product</label>
                        <div class="col-sm-6">
                            {{ Form::text('product',$productservicename->productservicename, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('category') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Category</label>
                        <div class="col-sm-6">
                            {{ Form::text('category',$categoryname->categoryname, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('subcategory') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Subcategory</label>
                        <div class="col-sm-6">
                            {{ Form::text('subcategory',$subcategoryname->subcategoryname, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('requestedenquiryrepairrequestdate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Requested Enquiry repair Request Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('requestedenquiryrepairrequestdate',null, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('requestedquantity') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Requested Quantity</label>
                        <div class="col-sm-6">
                            {{ Form::number('requestedquantity',null, array('class' => 'form-control','id'=>'requestedquantity','onblur'=>'taxcalculate()')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('rate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Rate</label>
                        <div class="col-sm-6">
                            {{ Form::number('rate',null, array('class' => 'form-control','id'=>'rate','onblur'=>'taxcalculate()')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('gstrate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Tax Rate(GST)</label>
                        <div class="col-sm-6">
                            {{ Form::number('gstrate',null, array('class' => 'form-control','id'=>'gstrate','onblur'=>'taxcalculate()')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('taxvalue') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Tax Value(GSTIN@ Extra)</label>
                        <div class="col-sm-6">
                            {{ Form::number('taxvalue',null, array('class' => 'form-control','id'=>'taxvalue','readonly'=>'true')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('quotationamount') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Quotation Amount</label>
                        <div class="col-sm-6">
                            {{ Form::number('quotationamount',null, array('class' => 'form-control','id'=>'quotationamount','readonly'=>'true')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('quotationdate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Quotation Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('quotationdate',null, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('subcategory') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Subject</label>
                        <div class="col-sm-6">
                            {{ Form::text('subject',null, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('subcategory') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Description</label>
                        <div class="col-sm-6">
                            {{ Form::textarea('description',null, array('class' => 'form-control','rows'=>'2')) }}
                        </div>
                    </div>


                    {{--<div class="row mt-1{{ $errors->has('quotationstatus') ? ' has-error' : '' }}">--}}
                    {{--<label for="input" class="col-sm-4 col-form-label text-muted">Quotation Status</label>--}}
                    {{--<div class="col-sm-6">--}}
                    {{--{{ Form::select('quotationstatus', array('Approved'=>'Approved','Not approved'=>'Not approved'),null,array('placeholder'=>'--SELECT--','class'=>'form-control')) }}--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <br>
                    <div align="center">
                        @if($quotationdetails==""||$quotationdetails==null)
                            {{Form::submit('Save',array('class'=>'btn btn-primary'))}}
                        @else
                            <a class="btn btn-primary" href="{{ URL::to('quotationreport',array($existingusercomplaint->ticketno))}}">Generate Quotation </a>
                        @endif
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection


@section('page-script')
    <script type="text/javascript">
        function taxcalculate() {
            debugger
            var qty=$("#requestedquantity").val();
            var rateamt=$("#rate").val();
            var gstrate=$("#gstrate").val();
            var taxamt=qty*(rateamt*gstrate/100);
            var qtyamt=qty*rateamt+taxamt;
            document.getElementById('taxvalue').value=taxamt;
            document.getElementById('quotationamount').value=qtyamt;
        }
    </script>

@stop