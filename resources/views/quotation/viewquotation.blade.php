@extends('layouts.appnew')

@section('page-title', '| Assignee Details')

@section('content')

    <div type="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> Quotation Details</h3>
            </div>
            <div class="panel-body">

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Quotation number </div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->quotationnumber}} </div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Ticket no</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->ticketno}} </div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Type of Call</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->typeofcall}} </div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Customer ID</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->customerid}} </div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Customer Site</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->customersite}} </div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">product sr no</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->productsrno}} </div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">product</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->product}} </div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Category</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->category}} </div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">subcategory</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->subcategory}} </div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Requested Enquiry repairrequest Date</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->requested_enquiry_repairrequestdate}} </div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Quotation Date</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->quotationdate}} </div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Requested Quantity</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->requestedquantity}}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Rate</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->rate}} </div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Tax Value</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->taxvalue}} </div>
                </div>

                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Quotation Amount</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->quotationamount}} </div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Quotation Status</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->quotationstatus}} </div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Dispatch Date</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->dispatchsaledate}}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Dispatch  Quantity</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->dispatchsalequantity}}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Dispatch details</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->dispatchsaledetails}}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Sale Amount</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->saleamount}}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Sent to Scrap</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->senttoscrap}} </div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Scrap Details</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->scrapdetails}}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Final Quotation amount</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->finalquotationamount}}</div>
                </div>
                <div class="row col-md-12">
                    <div for="input" class="col-sm-4 col-form-label text-muted">Remarks</div>
                    <div class="col-md-4 ol-form-label text-muted">: {{$quotationdetails->remarks}}</div>
                </div>

                <br>
            </div>
        </div>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>

@endsection
	
	