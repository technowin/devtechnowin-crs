@extends('layouts.appnew')
@section('pageTitle', 'Add Contract')
@section('page-css')
    <link href="{{asset('css/tab-css.css')}}" rel="stylesheet">
@stop
@section('content')

    <div class="container-fluid">
        <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#contract-tab" id="contract" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Contract</a>
                </li>
                <li role="presentation" class=""><a href="#contract-site-master-tab" role="tab" id="contract-site-master" data-toggle="tab" aria-expanded="false">Contract Site Master</a></li>
                <li role="presentation" class=""><a href="#contract-site-contact-master-tab" role="tab" id="contract-site-contact-master" data-toggle="tab" aria-expanded="false">Contract Site Contact Master</a></li>
                <li role="presentation" class=""><a href="#contract-details-tab" role="tab" id="contract-details" data-toggle="tab" aria-expanded="false">Contract Details</a></li>
                <li role="presentation"><a href="#equipment-tab" role="tab" id="equipment" data-toggle="tab" aria-expanded="false">Equipment</a></li>
                <li role="presentation"><a href="#payment-term-tab" role="tab" id="paymentterms" data-toggle="tab" aria-expanded="false">Payment Terms</a></li>
            </ul>
            <br>
            <div class="tab-content">
                <div class="tab-pane fade active in" role="tabpanel" id="contract-tab" style="margin-left: 250px;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">New Contract</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row{{ $errors->has('contractno') ? ' has-error' : '' }}"
                                 style="padding-top:5px;">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Contract No.</label>
                                <div class="col-sm-6">:
                                    {{$editconract->contractno }}
                                </div>
                            </div>
                            <div class="row{{ $errors->has('customers') ? ' has-error' : '' }}"
                                 style="padding-top:5px;">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Customer Name</label>
                                <div class="col-sm-6">:
                                    {{$editconract->customers->customername }}
                                </div>
                            </div>
                            <div class="row{{ $errors->has('tenderno') ? ' has-error' : '' }}">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Tender No/Quotation No</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->tenderno }}
                                </div>
                            </div>
                            <div class="row {{ $errors->has('tenderopendate') ? ' has-error' : '' }}">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Tender Open
                                    Date</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->tenderopendate }}
                                </div>
                            </div>
                            <div class="row{{ $errors->has('workordertype') ? ' has-error' : '' }}">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Work Order
                                    Type</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->workordertype }}
                                </div>
                            </div>
                            <div class="row{{ $errors->has('workordertype') ? ' has-error' : '' }}">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Comprehensive Type</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->comprehensivetype }}
                                </div>
                            </div>
                            <div class="row{{ $errors->has('workorderno') ? ' has-error' : '' }} ">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Work Order No</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->workorderno }}
                                </div>
                            </div>
                            <div class="row{{ $errors->has('workorderdescription') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Work Order
                                    Description</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->workorderdescription }}
                                </div>
                            </div>
                            <div class="row {{ $errors->has('workorderdate') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Work Order
                                    Date</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->workorderdate }}
                                </div>
                            </div>
                            <div class="row {{ $errors->has('contractfromdate') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Contract From
                                    Date</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->contractfromdate }}
                                </div>
                            </div>
                            <div class="row {{ $errors->has('contracttodate') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Contract To
                                    Date</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->contracttodate }}
                                </div>
                            </div>
                            @if($editconract->workordertype == 'AMC' || $editconract->workordertype == 'Warranty' || $editconract->workordertype == 'Hardware AMC' || $editconract->workordertype == 'Hardware Warranty' )
                            <div class="row{{ $errors->has('servicefrequency') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Service
                                    Frequency</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->servicefrequency }}
                                </div>
                            </div>
                            @endif
                            <div class="row{{ $errors->has('contractperiod') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Contract Period (In
                                    Years)</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->contractperiod }}
                                </div>
                            </div>
                            <div class="row{{ $errors->has('purchaseorderno') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Purchase Order
                                    No</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->purchaseorderno }}
                                </div>
                            </div>
                            <div class="row {{ $errors->has('purchaseorderdate') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Purchase Order
                                    Date</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->purchaseorderdate }}
                                </div>
                            </div>
                            <div class="row{{ $errors->has('amendmentno') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Amendment No</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->amendmentno }}
                                </div>
                            </div>
                            <div class="row{{ $errors->has('amendmentdescription') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Amendment
                                    Description</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->amendmentdescription }}
                                </div>
                            </div>
                            <div class="row{{ $errors->has('renewalperiod') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Renewal Period</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->renewalperiod }}
                                </div>
                            </div>
                            <div class="row{{ $errors->has('totalcost') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Total Cost</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->totalcost }}
                                </div>
                            </div>

                            <div class="row {{ $errors->has('closerdate') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Closure Date</label>
                                <div class="col-sm-6">:
                                    {{ $editconract->closuredate }}
                                </div>
                            </div>

                            <br/>
                            {{ Form::close() }}
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" role="tabpanel" id="contract-site-master-tab" aria-labelledby="contract-site-master" style="margin-left: 250px;">
                    <div class="container">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">New Contract Site Master</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row{{ $errors->has('contractno') ? ' has-error' : '' }}">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Contract No.</label>
                                    <div class="col-sm-6">:
                                        {{$editconract->contractno }}
                                    </div>
                                </div>

                                <br>
                                <input type="hidden" id="contractsitemaster" value="1">
                                @foreach($editcontractsitemaster as $contractsitemaster)
                                    <div class="panel col-md-12" style="border: silver 1px solid;">
                                        <div class="row{{ $errors->has('branchname') ? ' has-error' : '' }} mt-1"
                                             style="margin-top: 20px;">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Branch
                                                Name</label>
                                            <div class="col-sm-6">:
                                                {{$contractsitemaster->branchname }}
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('fax') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Fax</label>
                                            <div class="col-sm-6">:
                                                {{$contractsitemaster->fax }}
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('phone') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Phone</label>
                                            <div class="col-sm-6">:
                                                {{$contractsitemaster->phone }}
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('email') ? ' has-error' : '' }} mt-1"
                                             style="margin-bottom: 20px;">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Email</label>
                                            <div class="col-sm-6">:
                                                {{$contractsitemaster->email }}
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                                <br/>
                                {{ Form::close() }}

                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" role="tabpanel" id="contract-site-contact-master-tab" aria-labelledby="contract-site-contact-master">
                    <div class="container">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">New Contract Site Contact Master</h3>
                            </div>
                            <div class="panel-body">
                                {{Form::open(array('action' => 'ContractController@updatecontractsitecontactmaster','method' => 'get', 'id' => 'contractsitecontactmasterid'))}}
                                <div class="row{{ $errors->has('contractno') ? ' has-error' : '' }}">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Contract No.</label>
                                    <div class="col-sm-6">:
                                        {{$editconract->contractno }}
                                    </div>
                                </div>

                                @foreach($editcontractsitecontactmaster as $contractsitecontactmaster)

                                    <div class="panel col-md-12" style="border: silver 1px solid;">

                                        <div class="row{{ $errors->has('branchcode') ? ' has-error' : '' }} mt-1"
                                             style="margin-top: 20px;">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Branch
                                                Name</label>
                                            <div class="col-sm-6">:
                                                {{$contractsitecontactmaster->Branach->branchname }}
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('contactpersonname') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Branch Person
                                                Name</label>
                                            <div class="col-sm-6">:
                                                {{$contractsitecontactmaster->contactpersonname }}
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('fax') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Fax</label>
                                            <div class="col-sm-6">:
                                                {{$contractsitecontactmaster->fax }}
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('phone') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Phone</label>
                                            <div class="col-sm-6">:
                                                {{$contractsitecontactmaster->phone }}
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('emailid') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Email</label>
                                            <div class="col-sm-6">:
                                                {{$contractsitecontactmaster->emailid }}

                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                @endforeach

                                <br/>

                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" role="tabpanel" id="contract-details-tab" aria-labelledby="contract-detailsr">
                    <div class="container">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Contract Details</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row {{ $errors->has('contractno') ? ' has-error' : '' }} mt-2">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Contract No</label>
                                    <div class="col-sm-6">:
                                        {{$editconract->contractno }}
                                    </div>
                                </div>
                                @foreach($editcontractdetails as $editcontract)

                                    {{ Form::hidden('contractdetailsid[]', $editcontract->id),array('id'=>'contractdetailsid', 'class' => 'contractdetailsid') }}
                                    <div class="card col-md-12" style="border: silver 1px solid; margin-top: 25px;">
                                        <div class="row{{ $errors->has('productservice') ? ' has-error' : '' }} mt-1">
                                            <label for="input"
                                                   class="col-sm-4 col-form-label text-muted">Equipment</label>
                                            <div class="col-sm-4">
                                                {{ $editcontract->product->productservicename or 'NA' }}
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('quantity') ? ' has-error' : '' }} mt-1">
                                            <label for="input"
                                                   class="col-sm-4 col-form-label text-muted">Quantity (A)</label>
                                            <div class="col-sm-4">:
                                                {{$editcontract->quantity }}
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('rate') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Rate
                                                (B)</label>
                                            <div class="col-sm-4">:
                                                {{$editcontract->rate }}
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('warranty_amc_period') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Warranty / AMC
                                                Period (C)</label>
                                            <div class="col-sm-4">:
                                                {{$editcontract->warranty_amcperiod }}
                                            </div>

                                        </div>


                                        <div class="row{{ $errors->has('taxrate') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Tax
                                                Rate</label>
                                            <div class="col-sm-4">:
                                                {{$editcontract->taxrate }}
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('taxamt') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Tax
                                                Amt</label>
                                            <div class="col-sm-4">:
                                                {{$editcontract->taxamt }}
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('sgstrate') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">SGST
                                                Rate</label>
                                            <div class="col-sm-4">:
                                                {{$editcontract->sgstrate }}
                                            </div>

                                        </div>

                                        <div class="row{{ $errors->has('sgstamt') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">SGST
                                                Amt</label>
                                            <div class="col-sm-4">:
                                                {{$editcontract->sgstamt }}
                                            </div>

                                        </div>

                                        <div class="row{{ $errors->has('cgstrate') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">CGST
                                                Rate</label>
                                            <div class="col-sm-4">:
                                                {{$editcontract->cgstrate }}
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('cgstamt') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">CGST
                                                Amt</label>
                                            <div class="col-sm-4">:
                                                {{$editcontract->cgstamt }}
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('totaltax') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Total Tax
                                                (D)</label>
                                            <div class="col-sm-4">:
                                                {{$editcontract->totaltax }}
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('totalcontractcost') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Total
                                                Cost</label>
                                            <div class="col-sm-4">:
                                                {{$editcontract->totalcontractcost }}
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" role="tabpanel" id="equipment-tab" aria-labelledby="equipment">
                    <div class="container">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Add Equipment Details</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row{{ $errors->has('contractno') ? ' has-error' : '' }}">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Contract No.</label>
                                    <div class="col-sm-6">:
                                        {{$editconract->contractno }}
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('contracttype') ? ' has-error' : '' }}"
                                     style="padding-top:5px;">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Contract Type</label>
                                    <div class="col-sm-6">:
                                        {{$editconract->workordertype }}
                                    </div>
                                </div>
                                <br>
                                <input type="hidden" id="equipmentcount" value="1">
                                <div id="addrow">
                                    <div style="border: silver 1px solid;">
                                        <table class="table-bordered">
                                            <thead>
                                            <tr>
                                                <td width="10%" style="text-align: center"><b>Branch Name</b> </td>
                                                <td width="10%" style="text-align: center"><b>Product Name</b></td>
                                                <td width="10%" style="text-align: center"><b>Category Name</b></td>
                                                <td width="10%" style="text-align: center"><b>Equipment Sr No</b></td>
                                                <td width="10%" style="text-align: center"><b>Product Sr No</b></td>
                                                <td width="10%" style="text-align: center"><b>Specification</b></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($editcontractequipment as  $key => $equipment)
                                                <tr>
                                                    <td width="10%" style="text-align: center">{{$equipment->branch->branchname or 'NA' }}</td>
                                                    <td width="10%" style="text-align: center">{{$equipment->products->productservicename or 'NA' }}</td>
                                                    <td width="10%" style="text-align: center">{{$equipment->category->categoryname or 'NA' }}</td>
                                                    <td width="10%" style="text-align: center">{{$equipment->equipmentsrno }}</td>
                                                    <td width="10%" style="text-align: center">{{$equipment->productsrno }}</td>
                                                    <td width="10%"style="text-align: center">{{$equipment->specification }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" role="tabpanel" id="payment-term-tab" aria-labelledby="paymentterms">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Payment Terms</h3>
                        </div>
                        <div class="panel-body">

                            <div class="row {{ $errors->has('contractno') ? ' has-error' : '' }}">
                                <label for="input" class="col-sm-4 col-form-label text-muted">Contract No</label>
                                <div class="col-sm-6">:
                                    {{$editconract->contractno }}
                                </div>
                            </div>
                            {{Form::open(array('action' => 'ContractController@showContract','method' => 'get'))}}
                            <div class="row{{ $errors->has('securitydeposit') ? ' has-error' : '' }}">
                                <label for="input"
                                       class="col-sm-4 col-form-label text-muted">securitydeposit</label>
                                <div class="col-sm-4">:
                                    @if($paymentterms!="")
                                        {{$paymentterms->securitydeposit}}
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('sbpaymentperiod') ? ' has-error' : '' }} ">
                                <label for="input" class="col-sm-4 col-form-label text-muted">SD Payment Period (days)</label>
                                <div class="col-sm-4">:
                                    @if($paymentterms!="")
                                        {{$paymentterms->sbpaymentperiod }}
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('admincharges') ? ' has-error' : '' }} ">
                                <label for="input" class="col-sm-4 col-form-label text-muted">Admin Charges (BG)</label>
                                <div class="col-sm-4">:
                                    @if($paymentterms!="")
                                        {{$paymentterms->admincharges }}
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('facilitycharges') ? ' has-error' : '' }} ">
                                <label for="input" class="col-sm-4 col-form-label text-muted">Facility Charges</label>
                                <div class="col-sm-4">:
                                    @if($paymentterms!="")
                                        {{$paymentterms->facilitycharges }}
                                    @endif
                                </div>
                            </div>

                            <div class="row{{ $errors->has('paymentintervalforamc') ? ' has-error' : '' }} ">
                                <label for="input" class="col-sm-4 col-form-label text-muted">Payment Interval For AMC</label>
                                <div class="col-sm-4">:
                                    @if($paymentterms!="")
                                        {{$paymentterms->paymentintervalforamc }}
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('leaddaysforpayment') ? ' has-error' : '' }} ">
                                <label for="input" class="col-sm-4 col-form-label text-muted">Lead Days For Payment</label>
                                <div class="col-sm-4">:
                                    @if($paymentterms!="")
                                        {{$paymentterms->leaddaysforpayment }}
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('customeriniatedbilling') ? ' has-error' : '' }} ">
                                <label for="input" class="col-sm-4 col-form-label text-muted">Customer Iniated Billing</label>
                                <div class="col-sm-4">:
                                    @if($paymentterms!="")
                                        {{$paymentterms->customeriniatedbilling }}
                                    @endif
                                </div>
                            </div>
                            @if($editconract->workordertype!="Software Maintenance")

                                <div class="row{{ $errors->has('firstpaymentpercent') ? ' has-error' : '' }} ">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">First payment percent</label>
                                    <div class="col-sm-4">:
                                        @if($paymentterms!="")
                                            {{$paymentterms->firstpaymentpercent }}
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('firstpaymentcriteria') ? ' has-error' : '' }} ">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">First Payment Criteria</label>
                                    <div class="col-sm-4">:
                                        @if($paymentterms!="")
                                            {{$paymentterms->firstpaymentcriteria }}
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('secondpaymentpercent') ? ' has-error' : '' }} ">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Second Payment Percent</label>
                                    <div class="col-sm-4">:
                                        @if($paymentterms!="")
                                            {{$paymentterms->secondpaymentpercent }}
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('secondpaymentcriteria') ? ' has-error' : '' }} ">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Second Payment Criteria</label>
                                    <div class="col-sm-4">:
                                        @if($paymentterms!="")
                                            {{$paymentterms->secondpaymentcriteria }}
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('thirdpaymentpercent') ? ' has-error' : '' }} ">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Third Payment Percent</label>
                                    <div class="col-sm-4">:
                                        @if($paymentterms!="")
                                            {{$paymentterms->thirdpaymentpercent }}
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('thirdpaymentcriteria') ? ' has-error' : '' }} ">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Third Payment Criteria</label>
                                    <div class="col-sm-4">:
                                        @if($paymentterms!="")
                                            {{$paymentterms->thirdpaymentcriteria }}
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('fourthpaymentpercent') ? ' has-error' : '' }} ">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Fourth Payment Percent</label>
                                    <div class="col-sm-4">:
                                        @if($paymentterms!="")
                                            {{$paymentterms->fourthpaymentpercent }}
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('fourthpaymentcriteria') ? ' has-error' : '' }} ">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Fourth Payment Criteria</label>
                                    <div class="col-sm-4">:
                                        @if($paymentterms!="")
                                            {{$paymentterms->fourthpaymentcriteria }}
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('fifthpaymentpercent') ? ' has-error' : '' }} ">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Fith Payment Percent</label>
                                    <div class="col-sm-4">:
                                        @if($paymentterms!="")
                                            {{$paymentterms->fifthpaymentpercent }}
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('fifthpaymentcriteria') ? ' has-error' : '' }} ">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Fith Payment Criteria</label>
                                    <div class="col-sm-4">:
                                        @if($paymentterms!="")
                                            {{$paymentterms->fifthpaymentcriteria }}
                                        @endif
                                    </div>
                                </div>
                            @endif
                            {{Form::close()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
@section('page-script')
@endsection