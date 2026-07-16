@extends('layouts.appnew')
@section('pageTitle', 'Complaints')
@section('content')

    <br/>
    <div class="container card col-md-9">
        <div class="col card-block">
            <div class="tab-content">
                <div class="tab-pane fade active in" role="tabpanel" id="contract-tab" style="margin-left: 250px;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Details Prospective Quotation  </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row{{ $errors->has('quotationno') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Quotation No</label>
                                <div class="col-sm-6">
                                    {{ $ProspectiveQutation->quotationno }}
                                </div>
                            </div>
                            <div class="row{{ $errors->has('quotationdate') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Quotation Date</label>
                                <div class="col-sm-6">
                                    {{ $ProspectiveQutation->quotationdate }}
                                </div>
                            </div>
                            <div class="row{{ $errors->has('organizationname') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Organisation Name</label>
                                <div class="col-sm-6">
                                    {{  $ProspectiveQutation->customers->customername }}
                                    @if ($errors->has('organizationname'))
                                        <span class="help-block"><strong>{{ $errors->first('organizationname') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('organizationaddress') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Organisation Address</label>
                                <div class="col-sm-6">
                                    {{ $ProspectiveQutation->organizationaddress }}
                                    @if ($errors->has('organizationaddress'))
                                        <span class="help-block"><strong>{{ $errors->first('organizationaddress') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('organizationaddress') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Email</label>
                                <div class="col-sm-6">
                                    {{ $ProspectiveQutation->emailid }}
                                    @if ($errors->has('organizationaddress'))
                                        <span class="help-block"><strong>{{ $errors->first('organizationaddress') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('organizationaddress') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Phone</label>
                                <div class="col-sm-6">
                                    {{ $ProspectiveQutation->phone }}
                                    @if ($errors->has('organizationaddress'))
                                        <span class="help-block"><strong>{{ $errors->first('organizationaddress') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <br>
                            @foreach($ProspectiveQutationdetails as $key => $ProspectiveQutation)
                                <div class="panel col-md-12" style="border: silver 1px solid;">
                                    <div class="row{{ $errors->has('branchname') ? ' has-error' : '' }} mt-1"
                                         style="margin-top: 20px;">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Product</label>
                                        <div class="col-sm-6">
                                            {{ $ProspectiveQutation->products->productservicename }}
                                        </div>
                                    </div>
                                    <div class="row{{ $errors->has('branchname') ? ' has-error' : '' }} mt-1"
                                         style="margin-top: 20px;">
                                        <label for="input" class="col-sm-4 col-form-label text-muted"> Category </label>
                                        <div class="col-sm-6">
                                            {{ $ProspectiveQutation->category->categoryname }}
                                        </div>
                                    </div>
                                    <div class="row{{ $errors->has('fax') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Model No</label>
                                        <div class="col-sm-6">
                                            {{ $ProspectiveQutation->modelno }}
                                        </div>
                                    </div>
                                    <div class="row{{ $errors->has('fax') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Configuration</label>
                                        <div class="col-sm-6">
                                            {{ $ProspectiveQutation->configuration }}
                                        </div>
                                    </div>
                                    <div class="row{{ $errors->has('fax') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Qty</label>
                                        <div class="col-sm-6">
                                            {{$ProspectiveQutation->qty}}
                                        </div>
                                    </div>
                                    <div class="row{{ $errors->has('fax') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Rate</label>
                                        <div class="col-sm-6">
                                            {{$ProspectiveQutation->rate}}
                                        </div>
                                    </div>
                                    <div class="row{{ $errors->has('fax') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">SGST</label>
                                        <div class="col-sm-6">
                                            {{$ProspectiveQutation->sgst}}
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('fax') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">SGST Amt</label>
                                        <div class="col-sm-6">
                                            {{$ProspectiveQutation->sgstamt}}
                                        </div>
                                    </div>
                                    <div class="row{{ $errors->has('fax') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">CGST</label>
                                        <div class="col-sm-6">
                                            {{$ProspectiveQutation->cgst}}
                                        </div>
                                    </div>
                                    <div class="row{{ $errors->has('fax') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">CGST Amt</label>
                                        <div class="col-sm-6">
                                            {{$ProspectiveQutation->cgstamt}}
                                        </div>
                                    </div>
                                    <div class="row{{ $errors->has('fax') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Tax Amt</label>
                                        <div class="col-sm-6">
                                            {{$ProspectiveQutation->amt}}
                                        </div>
                                    </div>
                                    <div class="row{{ $errors->has('total') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Total</label>
                                        <div class="col-sm-6">
                                            {{$ProspectiveQutation->total}}
                                        </div>
                                    </div>
                                    <div class="row{{ $errors->has('total') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted"> Grnad Total</label>
                                        <div class="col-sm-6">
                                            {{$ProspectiveQutation->grandamt}}
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
