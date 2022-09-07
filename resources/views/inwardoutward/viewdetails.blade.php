@extends('layouts.appnew')
@section('pageTitle', 'Assigned Complaint')
@section('content')
    <style>
        label {
            overflow:hidden;
            text-overflow:ellipsis;
            display:inline-block;
            word-wrap: break-word;
        }
    </style>
    <div class="col-md-12">
        <div class="col-md-12 row">
            <div class="container col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Ticket Details</div>
                    <div class="panel-body">
                            <div class="container">
                                <br>
                                <div class="row col-lg-12">
                                    <label for="input" class="col-sm-2 text-muted">Ticket No :</label>
                                    <label for="input" class="col-sm-2">{{ $details->ticketno }}</label>

                                    <label for="input" class="col-sm-2 text-muted">Customer Name :</label>
                                    <label for="input" class="col-sm-2">{{ @is_null($details->customercode) ? '-' : $details->customers->customername }}</label>

                                    <label for="input" class="col-sm-2 text-muted">Customer Site :</label>
                                    <label for="input" class="col-sm-2">{{ @is_null($details->branchcode) ? '-' : $details->branch->branchname }}</label>
                                </div>

                                <div class="row col-lg-12">
                                    <label for="input" class="col-sm-2 text-muted">Caller Name :</label>
                                    <label for="input" class="col-sm-2">{{ $details->callerName }}</label>

                                    <label for="input" class="col-sm-2 text-muted">Equipment Sr No. :</label>
                                    <label for="input" class="col-sm-2">{{ @is_null($details->equipmentsrno) ? '-' : $details->equipmentsrno }}</label>

                                    <label for="input" class="col-sm-2 text-muted">Product Sr No. :</label>
                                    <label for="input" class="col-sm-2">{{ @is_null($details->productsrno) ? '-' : $details->productsrno }}</label>
                                </div>

                            </div>
                    </div>
                </div>
            </div>
            <div class="container col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Inward Details</div>
                    <div class="panel-body">
                        <div class="container">
                            <br>
                            <div class="row col-lg-12">
                                <label for="input" class="col-sm-3 text-muted">Inward No :</label>
                                <label for="input" class="col-sm-3">{{ $details->inwardno }}</label>

                                <label for="input" class="col-sm-3 text-muted">Inward Product Details :</label>
                                <label for="input" class="col-sm-3">{{  $details->inwardProductDetails }}</label>
                            </div>

                            <div class="row col-lg-12">
                                <label for="input" class="col-sm-3 text-muted">Inward Date :</label>
                                <label for="input" class="col-sm-3">{{ Carbon\Carbon::parse($details->inwardDate)->format('d-m-Y') }}</label>

                                <label for="input" class="col-sm-3 text-muted">Inward Comment :</label>
                                <label for="input" class="col-sm-3">{{ @is_null($details->inwardComment) ? '-' : $details->inwardComment }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Challan Details</div>
                    <div class="panel-body">
                        <div class="container">
                            <br>
                            <div class="row col-lg-12">
                                <label for="input" class="col-sm-3 text-muted">Challan No :</label>
                                <label for="input" class="col-sm-3">{{ @is_null($details->challanNo) ? '-' : $details->challanNo }}</label>

                                <label for="input" class="col-sm-3 text-muted">Challan Date :</label>
                                <label for="input" class="col-sm-3">{{ @is_null($details->challanDate) ? '-' : Carbon\Carbon::parse($details->challanDate)->format('d-m-Y') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Outward Details</div>
                    <div class="panel-body">
                        <div class="container">
                            <br>
                            <div class="row col-lg-12">
                                <label for="input" class="col-sm-3 text-muted">Outward No :</label>
                                <label for="input" class="col-sm-3">{{ @is_null($details->outwardno) ? '-' : $details->outwardno }}</label>

                                <label for="input" class="col-sm-3 text-muted">Outward Product Details :</label>
                                <label for="input" class="col-sm-3">{{ @is_null($details->outwardProductDetails) ? '-' : $details->outwardProductDetails }}</label>
                            </div>
                            <div class="row col-lg-12">
                                <label for="input" class="col-sm-3 text-muted">Outward Assignee :</label>
                                <label for="input" class="col-sm-3">{{ @is_null($details->outwardAssigneeCode) ? '-' : $details->outwardAssigneeCode }}</label>

                                <label for="input" class="col-sm-3 text-muted">Outward Date :</label>
                                <label for="input" class="col-sm-3">{{ @is_null($details->outwardDate) ? '-' : Carbon\Carbon::parse($details->outwardDate)->format('d-m-Y') }}</label>
                            </div>
                            <div class="row col-lg-12">
                                <label for="input" class="col-sm-3 text-muted">Outward Comment :</label>
                                <label for="input" class="col-sm-3">{{ @is_null($details->outwardComment) ? '-' : $details->outwardComment }}</label>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 row"><a class="btn btn-default" href="{{url()->previous()}}">Back</a></div>
@endsection
