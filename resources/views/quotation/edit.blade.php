@extends('layouts.appnew')

@section('page-title', '| Customers')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Quotation </h3>
            </div>
            <div class="panel-body">
                <div class="container">
                    {{ Form::open(array('url'=>'/update', 'files' =>true )) }}
                    {{Form::hidden('id',$quotationdetails->id,array('id'=>'id'))}}
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
                    <div class="row mt-1{{ $errors->has('product') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Product</label>
                        <div class="col-sm-6">
                            {{ Form::text('product',$quotationdetails->product, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('category') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Category</label>
                        <div class="col-sm-6">
                            {{ Form::text('category',$quotationdetails->category, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('subcategory') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Subcategory</label>
                        <div class="col-sm-6">
                            {{ Form::text('subcategory',$quotationdetails->subcategory, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('requestedenquiryrepairrequestdate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Requested Enquiry repair Request Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('requestedenquiryrepairrequestdate',$quotationdetails->requested_enquiry_repairrequestdate, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('requestedquantity') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Requested Quantity</label>
                        <div class="col-sm-6">
                            {{ Form::number('requestedquantity',$quotationdetails->requestedquantity, array('class' => 'form-control','id'=>'requestedquantity','onblur'=>'taxcalculate()')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('rate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Rate</label>
                        <div class="col-sm-6">
                            {{ Form::number('rate',$quotationdetails->rate, array('class' => 'form-control','id'=>'rate','onblur'=>'taxcalculate()')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('gstrate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Tax Rate(GST)</label>
                        <div class="col-sm-6">
                            {{ Form::number('gstrate',$quotationdetails->gstrate, array('class' => 'form-control','id'=>'gstrate','onblur'=>'taxcalculate()')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('taxvalue') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Tax Value(GSTIN Extra)</label>
                        <div class="col-sm-6">
                            {{ Form::number('taxvalue',$quotationdetails->taxvalue, array('class' => 'form-control','id'=>'taxvalue','readonly'=>'true')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('quotationamount') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Quotation Amount</label>
                        <div class="col-sm-6">
                            {{ Form::number('quotationamount',$quotationdetails->quotationamount, array('class' => 'form-control','id'=>'quotationamount','readonly'=>'true')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('quotationdate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Quotation Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('quotationdate',$quotationdetails->quotationdate, array('class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('subcategory') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Subject</label>
                        <div class="col-sm-6">
                            {{ Form::text('subject',$quotationdetails->subject, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('subcategory') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Description</label>
                        <div class="col-sm-6">
                            {{ Form::textarea('description',$quotationdetails->description, array('class' => 'form-control','rows'=>'2')) }}
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
        function taxcalculate() {
            debugger
            var qty=$("#requestedquantity").val();
            var rateamt=$("#rate").val();
            var gst=$("#gstrate").val();
            var taxamt=qty*(rateamt*gst/100);
            var qtyamt=qty*rateamt+taxamt;
            document.getElementById('taxvalue').value=taxamt;
            document.getElementById('quotationamount').value=qtyamt;
        }
    </script>

@stop