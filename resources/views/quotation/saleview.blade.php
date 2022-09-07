@extends('layouts.appnew')
@section('pageTitle', 'Add Contract')
@section('page-css')
    <link href="{{asset('css/tab-css.css')}}" rel="stylesheet">
@stop
@section('content')
                    <div class="container">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Sale Quotation Details</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row" style="padding-top:5px">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Quotatio No.</label>
                                    <div class="col-sm-6">
                                        {{$saleproduct[0]->quotationnumber}}
                                    </div>
                                </div>

                                <div class="row"style="padding-top:5px;">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Ticket No.</label>
                                    <div class="col-sm-6">
                                        {{$saleproduct[0]->ticketno}}
                                    </div>
                                </div>
                                <div class="row"style="padding-top: 5px">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                                    <div class="col-sm-6">
                                        {{$saleproduct[0]->customername}}
                                    </div>
                                </div>
                                <div class="row"style="padding-top: 5px">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Site</label>
                                    <div class="col-sm-6">
                                        {{$saleproduct[0]->customersite}}
                                    </div>
                                </div>
                                <div class="row"style="padding-top: 5px">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Product Supply</label>
                                    <div class="col-sm-6">
                                        {{$saleproduct[0]->productsupply}}
                                    </div>
                                </div>


                                <div class="row"style="padding-top: 5px">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Quotation Status</label>
                                    <div class="col-sm-6">
                                        {{$saleproduct[0]->quotationstatus}}
                                    </div>
                                </div>
                                <div class="row"style="padding-top: 5px">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Quotation Date</label>
                                    <div class="col-sm-6">
                                        {{$saleproduct[0]->quotationdate}}
                                    </div>
                                </div>
                                <div class="row"style="padding-top: 5px">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Final Quotation Amount</label>
                                    <div class="col-sm-6">
                                        {{$saleproduct[0]->finalquotationamount}}
                                    </div>
                                </div>
                                <div class="row"style="padding-top: 5px">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Remarks</label>
                                    <div class="col-sm-6">
                                        {{$saleproduct[0]->remarks}}
                                    </div>
                                </div>
                                <br>
                                    <div style="border: silver 1px solid;">
                                        <table class="table-bordered">
                                            <tr>
                                                <td width="10%" style="text-align: center"><b>Product Description</b> </td>
                                                <td width="10%" style="text-align: center"><b>Rate</b></td>
                                                <td width="10%" style="text-align: center"><b>Qty.</b></td>
                                                <td width="10%" style="text-align: center"><b>GST % Extra</b></td>
                                                <td width="10%" style="text-align: center"><b>GST Value</b></td>
                                                <td width="10%" style="text-align: center">Amount</td>
                                            </tr>
                                            @foreach($saleproduct as $key=>$salepr)
                                                <tr>
                                                    <td width="10%" style="text-align: center">{{$salepr->productdescription}}</td>
                                                    <td width="10%" style="text-align: center">{{$salepr->rate}}</td>
                                                    <td width="10%" style="text-align: center">{{$salepr->requestedquantity}}</td>
                                                    <td width="10%" style="text-align: center">{{$salepr->gstrate}}</td>
                                                    <td width="10%"style="text-align: center">{{$salepr->taxvalue}}</td>
                                                    <td width="10%" style="text-align: center">{{$salepr->totalamount}}</td>
                                                </tr>
                                                @endforeach
                                        </table>
                                    </div>

                                <div class="row"style="padding-top: 7px" align="center">
                                    <label for="input" class=" col-form-label text-muted">Quotation Amount=  {{$saleproduct[0]->quotationamount}}</label>
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-default" href={{url()->previous()}}>Back</a>
                    </div>
@endsection
@section('page-script')
@endsection

