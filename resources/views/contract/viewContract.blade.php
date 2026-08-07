@extends('layouts.appnew')
@section('pageTitle', 'Add Contract')
@section('page-css')
    <link href="{{asset('css/tab-css.css')}}" rel="stylesheet">
    <style>
        #billingcyclestable {
    table-layout: fixed !important;
    width: 100% !important;
    word-break: break-word;
}
#billingcyclestable th,
#billingcyclestable td {
    padding: 2px 3px !important;
    font-size: 11px !important;
    overflow: hidden;
    text-overflow: ellipsis;
}
#billingcyclestable input,
#billingcyclestable select,
#billingcyclestable button {
    width: 100% !important;
    max-width: 100% !important;
    min-width: 0 !important;
    box-sizing: border-box !important;
    padding: 1px 2px !important;
    height: 22px !important;
    font-size: 10px !important;
}


        #uploaded-docs {
            display: block !important;
        }
        .table {
            width: 100%;
            display: table;
        }
    </style>
@stop
@section('content')


    <div class="container-fluid">
        <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#contract-tab" id="contract" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Contract</a>
                </li>
                <li role="presentation"><a href="#documents-tab" id="documents-tab-link" role="tab" data-toggle="tab" aria-expanded="false">Contract Documents</a></li>
                <li role="presentation" class=""><a href="#contract-site-master-tab" role="tab" id="contract-site-master" data-toggle="tab" aria-expanded="false">Contract Site Master</a></li>
                <li role="presentation" class=""><a href="#contract-site-contact-master-tab" role="tab" id="contract-site-contact-master" data-toggle="tab" aria-expanded="false">Contract Site Contact Master</a></li>
                <li role="presentation" class=""><a href="#contract-details-tab" role="tab" id="contract-details" data-toggle="tab" aria-expanded="false">Contract Details</a></li>
                <li role="presentation"><a href="#equipment-tab" role="tab" id="equipment" data-toggle="tab" aria-expanded="false">Equipment</a></li>
                <li role="presentation"><a href="#equipment-upload-tab" role="tab" id="equipment-upload" data-toggle="tab" aria-expanded="false">Equipment Upload</a></li>

                <li role="presentation"><a href="#billing-tab" role="tab" id="billing-details" data-toggle="tab" aria-expanded="false">Billing Details</a></li>
                <li role="presentation"><a href="#payment-details-tab" role="tab" id="payment-details" data-toggle="tab" aria-expanded="false">Payment Details New</a></li>
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


                            

<div class="row mt-1">
    <label for="input" class="col-sm-3 col-form-label text-muted">Project Owner Name</label>
    <div class="col-sm-6">:
        {{ $editconract->projectownername }}
    </div>
</div>

<div class="row mt-1">
    <label for="input" class="col-sm-3 col-form-label text-muted">Billing Owner Name</label>
    <div class="col-sm-6">:
        {{ $editconract->billingownername }}
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


                <!-- Documents Tab - VIEW ONLY (No Upload/Delete) -->
<div class="tab-pane fade" role="tabpanel" id="documents-tab" style="margin-left: 250px;">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Contract Documents </h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    <i class="glyphicon glyphicon-info-sign"></i> 
                    Contract documents - View only
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <!-- Uploaded Documents List - View Only -->
                                <div id="uploaded-docs" style="margin-top: 20px;">
                                    <table class="table table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th width="10%">#</th>
                                                <th>File Name</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="docs-list">
                                            <tr id="doc1-row" style="display: none;">
                                                <td>1</td>
                                                <td id="doc1-name"></td>
                                                <td id="doc1-action"></td>
                                            </tr>
                                            <tr id="doc2-row" style="display: none;">
                                                <td>2</td>
                                                <td id="doc2-name"></td>
                                                <td id="doc2-action"></td>
                                            </tr>
                                            <tr id="doc3-row" style="display: none;">
                                                <td>3</td>
                                                <td id="doc3-name"></td>
                                                <td id="doc3-action"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="no-documents" class="alert alert-warning text-center" style="display: none;">
                                    <i class="glyphicon glyphicon-info-sign"></i> No documents uploaded for this contract.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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


                <!-- EQUIPMENT UPLOAD TAB - VIEW ONLY -->
<div class="tab-pane fade" role="tabpanel" id="equipment-upload-tab" style="margin-left: 250px;">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Equipment Document</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    <i class="glyphicon glyphicon-info-sign"></i> 
                    Equipment document - View only
                </div>

                <div id="equipment-uploaded-doc" style="margin-top: 25px;">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th>File Name</th>
                                <th width="25%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="eqdoc1-row" style="display: none;">
                                <td>1</td>
                                <td id="eqdoc1-name"></td>
                                <td id="eqdoc1-action"></td>
                            </tr>
                            <tr id="eqdoc-empty-row">
                                <td colspan="3" class="text-center text-muted">No equipment document uploaded yet.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>







<div class="tab-pane fade" role="tabpanel" id="billing-tab" style="margin-left: 250px;">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Billing Details</h3>
            </div>
            <div class="panel-body">
                {{Form::open(array('action' => 'ContractController@addBillingDetails','method' => 'get', 'id' => 'billingDetailsForm'))}}
                {{ Form::hidden('contractno', $editconract->contractno, array('id' => 'billingcontractid')) }}

                <div class="row mt-1">
                    <label class="col-sm-1 col-form-label text-muted">Contract No.</label>
                    <div class="col-sm-2">
                        {{ Form::text('contractnodisplay', $editconract->contractno, array('class' => 'form-control form-control-sm','readonly')) }}
                    </div>
                    <label class="col-sm-1 col-form-label text-muted">Total Amount</label>
                    <div class="col-sm-2">
                        
                        <input type="text" class="form-control form-control-sm" id="totalcontractamountdisplay" readonly value="{{ $editconract->totalcost }}">
                    </div>
                    <label class="col-sm-1 col-form-label text-muted">Total Received</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="totalpaidsofardisplay" readonly value="0.00">
                    </div>
                    <label class="col-sm-1 col-form-label text-muted">Remaining</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="totalremainingdisplay" readonly value="0.00">
                    </div>
                </div>

                <br/>
                <h4>Payment Cycles</h4>
                <table class="table table-bordered" id="billingcyclestable">
                    <thead>
                        <tr>
                            <th width="5%">Cycle No</th>
                            <th width="8%">Estimated Billing Date</th>
                            <th width="8%">Actual Bill Date</th>
                            <th width="7%">Bill Number</th>
                            <th width="7%">Bill Amount</th>
                            <th width="8%">Due Date </th> <!--  Next Payment Reminder -->
                            <th width="8%">Bill Payment Date</th>
                            <th width="7%">Bill Received Amount</th>
                            <th width="7%">TDS</th>
                            <th width="7%">Difference</th>
                            <th width="7%">Remark</th>
                            <th width="7%">Running Total</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="billingcyclesbody"></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"><b>Total Received</b></td>
                            <td><span id="totalpaidamount">0.00</span></td>
                            <td colspan="4">
                                <span id="billingmatchstatus" class="label label-warning">Remaining: 0.00</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <button type="button" class="btn btn-primary btn-sm" onclick="addBillingCycleRow();">+ Add Payment Cycle</button>

                <br/><br/>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        {{ Form::submit('Save & Close', array('class' => 'btn btn-primary','id' => 'billingsubmitbtn')) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>





<div class="tab-pane fade" role="tabpanel" id="payment-details-tab" style="margin-left: 250px;">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Payment Details New</h3>
            </div>
            <div class="panel-body">

                <h5 class="text-primary">Form Fees</h5>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Amount</label>
                    <div class="col-sm-3">: <span id="v_formfeesamount"></span></div>
                    <label class="col-sm-3 col-form-label text-muted">Exemption</label>
                    <div class="col-sm-3">: <span id="v_formfeesexemption"></span></div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Date Paid</label>
                    <div class="col-sm-3">: <span id="v_formfeesdatepaid"></span></div>
                </div>

                <hr/>
                <h5 class="text-primary">EMD</h5>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Amount</label>
                    <div class="col-sm-3">: <span id="v_emdamount"></span></div>
                    <label class="col-sm-3 col-form-label text-muted">Exemption</label>
                    <div class="col-sm-3">: <span id="v_emdexemption"></span></div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Date Paid</label>
                    <div class="col-sm-3">: <span id="v_emddatepaid"></span></div>
                    <label class="col-sm-3 col-form-label text-muted">Est. Return Date</label>
                    <div class="col-sm-3">: <span id="v_emdestimatedreturndate"></span></div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Return Amount</label>
                    <div class="col-sm-3">: <span id="v_emdreturnamount"></span></div>
                    <label class="col-sm-3 col-form-label text-muted">Return Date</label>
                    <div class="col-sm-3">: <span id="v_emdreturndate"></span></div>
                </div>

                <hr/>
                <h5 class="text-primary">Security Deposit</h5>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Amount</label>
                    <div class="col-sm-3">: <span id="v_securitydepositamount"></span></div>
                    <label class="col-sm-3 col-form-label text-muted">Type</label>
                    <div class="col-sm-3">: <span id="v_securitydeposittype"></span></div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Date Paid</label>
                    <div class="col-sm-3">: <span id="v_securitydepositdatepaid"></span></div>
                    <label class="col-sm-3 col-form-label text-muted">Est. Return Date</label>
                    <div class="col-sm-3">: <span id="v_securitydepositestimatedreturndate"></span></div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Return Amount</label>
                    <div class="col-sm-3">: <span id="v_securitydepositreturnamount"></span></div>
                    <label class="col-sm-3 col-form-label text-muted">Return Date</label>
                    <div class="col-sm-3">: <span id="v_securitydepositreturndate"></span></div>
                </div>

                <hr/>
                <h5 class="text-primary">Admin Charges</h5>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Amount</label>
                    <div class="col-sm-3">: <span id="v_adminchargesamount"></span></div>
                    <label class="col-sm-3 col-form-label text-muted">Exemption</label>
                    <div class="col-sm-3">: <span id="v_adminchargesexemption"></span></div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Date Paid</label>
                    <div class="col-sm-3">: <span id="v_adminchargesdatepaid"></span></div>
                </div>

                <hr/>
                <h5 class="text-primary">Facility Charges</h5>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Amount</label>
                    <div class="col-sm-3">: <span id="v_facilitychargesamount"></span></div>
                    <label class="col-sm-3 col-form-label text-muted">Exemption</label>
                    <div class="col-sm-3">: <span id="v_facilitychargesexemption"></span></div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Date Paid</label>
                    <div class="col-sm-3">: <span id="v_facilitychargesdatepaid"></span></div>
                </div>

                <hr/>
                <h5 class="text-primary">Legal Charges</h5>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Amount</label>
                    <div class="col-sm-3">: <span id="v_legalchargesamount"></span></div>
                    <label class="col-sm-3 col-form-label text-muted">Exemption</label>
                    <div class="col-sm-3">: <span id="v_legalchargesexemption"></span></div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Date Paid</label>
                    <div class="col-sm-3">: <span id="v_legalchargesdatepaid"></span></div>
                </div>

                <hr/>
                <h5 class="text-primary">Additional Security Deposit</h5>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Amount</label>
                    <div class="col-sm-3">: <span id="v_addnlsecuritydepositamount"></span></div>
                    <label class="col-sm-3 col-form-label text-muted">Exemption</label>
                    <div class="col-sm-3">: <span id="v_addnlsecuritydepositexemption"></span></div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Date Paid</label>
                    <div class="col-sm-3">: <span id="v_addnlsecuritydepositdatepaid"></span></div>
                    <label class="col-sm-3 col-form-label text-muted">Refund Date</label>
                    <div class="col-sm-3">: <span id="v_addnlsecuritydepositrefunddate"></span></div>
                </div>

                <hr/>
                <h5 class="text-primary">Documents</h5>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Document 1</label>
                    <div class="col-sm-6" id="v_doc1"></div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Document 2</label>
                    <div class="col-sm-6" id="v_doc2"></div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Document 3</label>
                    <div class="col-sm-6" id="v_doc3"></div>
                </div>

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{asset('custom-scripts/customdatavalidation.js')}}"></script>


<script type="text/javascript">
function loadPaymentDetailsView(contractno) {
    $.ajax({
        url: '{{ url("getpaymentdetails") }}/' + contractno,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var pd = data.paymentdetails || {};

            $('#v_formfeesamount').text(pd.formfeesamount || '-');
            $('#v_formfeesexemption').text(pd.formfeesexemption || '-');
            $('#v_formfeesdatepaid').text(pd.formfeesdatepaid || '-');

            $('#v_emdamount').text(pd.emdamount || '-');
            $('#v_emdexemption').text(pd.emdexemption || '-');
            $('#v_emddatepaid').text(pd.emddatepaid || '-');
            $('#v_emdestimatedreturndate').text(pd.emdestimatedreturndate || '-');
            $('#v_emdreturnamount').text(pd.emdreturnamount || '-');
            $('#v_emdreturndate').text(pd.emdreturndate || '-');

            $('#v_securitydepositamount').text(pd.securitydepositamount || '-');
            $('#v_securitydeposittype').text(pd.securitydeposittype || '-');
            $('#v_securitydepositdatepaid').text(pd.securitydepositdatepaid || '-');
            $('#v_securitydepositestimatedreturndate').text(pd.securitydepositestimatedreturndate || '-');
            $('#v_securitydepositreturnamount').text(pd.securitydepositreturnamount || '-');
            $('#v_securitydepositreturndate').text(pd.securitydepositreturndate || '-');

            $('#v_adminchargesamount').text(pd.adminchargesamount || '-');
            $('#v_adminchargesexemption').text(pd.adminchargesexemption || '-');
            $('#v_adminchargesdatepaid').text(pd.adminchargesdatepaid || '-');

            $('#v_facilitychargesamount').text(pd.facilitychargesamount || '-');
            $('#v_facilitychargesexemption').text(pd.facilitychargesexemption || '-');
            $('#v_facilitychargesdatepaid').text(pd.facilitychargesdatepaid || '-');

            $('#v_legalchargesamount').text(pd.legalchargesamount || '-');
            $('#v_legalchargesexemption').text(pd.legalchargesexemption || '-');
            $('#v_legalchargesdatepaid').text(pd.legalchargesdatepaid || '-');

            $('#v_addnlsecuritydepositamount').text(pd.addnlsecuritydepositamount || '-');
            $('#v_addnlsecuritydepositexemption').text(pd.addnlsecuritydepositexemption || '-');
            $('#v_addnlsecuritydepositdatepaid').text(pd.addnlsecuritydepositdatepaid || '-');
            $('#v_addnlsecuritydepositrefunddate').text(pd.addnlsecuritydepositrefunddate || '-');

            $('#v_doc1').html('-');
                $('#v_doc2').html('-');
                $('#v_doc3').html('-');
                if (data.document) {
                    var doc = data.document;
                    renderPaymentDocViewOnly('v_doc1', doc.doc1, contractno, 'doc1');
                    renderPaymentDocViewOnly('v_doc2', doc.doc2, contractno, 'doc2');
                    renderPaymentDocViewOnly('v_doc3', doc.doc3, contractno, 'doc3');
                }
        }
    });
}

function renderPaymentDocViewOnly(targetId, filePath, contractno, docField) {
    if (!filePath) {
        $('#' + targetId).html('-');
        return;
    }

    var fileName = filePath.split('/').pop();
    var shortName = fileName.length > 35 ? fileName.substring(0, 32) + '...' : fileName;
    var fileExtension = fileName.split('.').pop().toLowerCase();
    var isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension);
    var viewUrl = '{{ url("view-payment-document") }}/' + contractno + '/' + docField;
    var downloadUrl = '{{ url("download-payment-document") }}/' + contractno + '/' + docField;

    var fileIcon = '';
    if (fileExtension === 'pdf') {
        fileIcon = '<i class="glyphicon glyphicon-file" style="color: #d9534f;"></i> ';
    } else if (isImage) {
        fileIcon = '<i class="glyphicon glyphicon-picture" style="color: #5bc0de;"></i> ';
    } else {
        fileIcon = '<i class="glyphicon glyphicon-file" style="color: #f0ad4e;"></i> ';
    }

    var html = fileIcon +
        '<a href="' + viewUrl + '" target="_blank" class="btn btn-info btn-xs" title="View">' +
        '<i class="glyphicon glyphicon-eye-open"></i> View</a> ' +
        '<a href="' + downloadUrl + '" class="btn btn-success btn-xs" title="Download">' +
        '<i class="glyphicon glyphicon-download-alt"></i> Download</a> ' +
        '<span style="margin-left:8px;">' + shortName + '</span>';

    $('#' + targetId).html(html);
}

$(document).ready(function () {
    var contractno = '{{ $editconract->contractno }}';
    $('#payment-details').click(function () {
        loadPaymentDetailsView(contractno);
    });
});
</script>



<script type="text/javascript">


function addBillingCycleRow() {
    var newRow = '<tr class="billing-cycle-row">' +
        '<td class="cycle-no"></td>' +
        '<td><input type="date" name="estimatedbillingdate[]" class="form-control form-control-sm" max="2050-12-31"></td>' +
        '<td><input type="date" name="actualbilldate[]" class="form-control form-control-sm" max="2050-12-31"></td>' +
        '<td><input type="text" name="billnumber[]" class="form-control form-control-sm"></td>' +
        '<td><input type="text" name="billamount[]" class="form-control form-control-sm bill-amount" onkeyup="calculateDifference(this);"></td>' +
        '<td><input type="date" name="nextreminderdate[]" class="form-control form-control-sm" max="2050-12-31"></td>' +
        '<td><input type="date" name="billpaymentdate[]" class="form-control form-control-sm" max="2050-12-31"></td>' +
        '<td><input type="text" name="billpaidamount[]" class="form-control form-control-sm bill-paid-amount" onkeyup="validateBillTotal(); calculateDifference(this);"></td>' +
        '<td><input type="text" name="tds[]" class="form-control form-control-sm bill-tds" onkeyup="validateBillTotal();"></td>' +
        '<td class="row-difference">0.00</td>' +
        '<td><input type="text" name="remark[]" class="form-control form-control-sm" placeholder="Remark"></td>' +
        '<td class="row-running-total">0.00</td>' +
        '<td><button type="button" class="btn btn-danger btn-xs" onclick="removeBillingCycleRow(this);">Remove</button></td>' +
        '</tr>';

    $('#billingcyclesbody').append(newRow);
    renumberBillingRows();
    validateBillTotal();
}

function calculateDifference(el) {
    var row = $(el).closest('tr');
    var billAmt = parseFloat(row.find('.bill-amount').val()) || 0;
    var paidAmt = parseFloat(row.find('.bill-paid-amount').val()) || 0;
    row.find('.row-difference').text((billAmt - paidAmt).toFixed(2));
}

function removeBillingCycleRow(el) {
    $(el).closest('tr').remove();
    renumberBillingRows();
    validateBillTotal();
}

function renumberBillingRows() {
    $('#billingcyclesbody .billing-cycle-row').each(function (i) {
        $(this).find('.cycle-no').text(i + 1);
    });
}

function validateBillTotal() {
    var totalContractAmount = parseFloat($('#totalcontractamountdisplay').val()) || 0;
    var totalPaid = 0;
    var totalTds = 0;

    $('.billing-cycle-row').each(function () {
        var paidVal = parseFloat($(this).find('.bill-paid-amount').val()) || 0;
        var tdsVal = parseFloat($(this).find('.bill-tds').val()) || 0;
        totalPaid += paidVal;
        totalTds += tdsVal;
        $(this).find('.row-running-total').text((totalPaid + totalTds).toFixed(2));
    });

    var totalReceived = totalPaid + totalTds;

    $('#totalpaidamount').text(totalReceived.toFixed(2));
    $('#totalpaidsofardisplay').val(totalReceived.toFixed(2));

    var remaining = totalContractAmount - totalReceived;
    $('#totalremainingdisplay').val(remaining.toFixed(2));

    if (totalContractAmount > 0 && remaining <= 0) {
        $('#billingmatchstatus').removeClass('label-warning label-danger').addClass('label-success')
            .text(remaining === 0 ? 'Fully Paid ✓' : 'Overpaid by ' + Math.abs(remaining).toFixed(2));
    } else {
        $('#billingmatchstatus').removeClass('label-success label-danger').addClass('label-warning')
            .text('Remaining: ' + remaining.toFixed(2));
    }
}

function loadBillingDetailsEditable(contractno) {
    $.ajax({
        url: '{{ url("getbillingdetails") }}/' + contractno,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#billingcyclesbody').empty();
            if (data.cycleslist && data.cycleslist.length > 0) {
                $.each(data.cycleslist, function (i, cycle) {
                    var billAmt = parseFloat(cycle.billamount) || 0;
                    var paidAmt = parseFloat(cycle.billpaidamount) || 0;
                    var diff = (billAmt - paidAmt).toFixed(2);

                    var row = '<tr class="billing-cycle-row">' +
                        '<td class="cycle-no"></td>' +
                        '<td><input type="date" name="estimatedbillingdate[]" class="form-control form-control-sm" value="' + (cycle.estimatedbillingdate || '') + '" max="2050-12-31"></td>' +
                        '<td><input type="date" name="actualbilldate[]" class="form-control form-control-sm" value="' + (cycle.actualbilldate || '') + '" max="2050-12-31"></td>' +
                        '<td><input type="text" name="billnumber[]" class="form-control form-control-sm" value="' + (cycle.billnumber || '') + '"></td>' +
                        '<td><input type="text" name="billamount[]" class="form-control form-control-sm bill-amount" value="' + (cycle.billamount || '') + '" onkeyup="calculateDifference(this);"></td>' +
                        '<td><input type="date" name="nextreminderdate[]" class="form-control form-control-sm" value="' + (cycle.nextreminderdate || '') + '" max="2050-12-31"></td>' +
                        '<td><input type="date" name="billpaymentdate[]" class="form-control form-control-sm" value="' + (cycle.billpaymentdate || '') + '" max="2050-12-31"></td>' +
                        '<td><input type="text" name="billpaidamount[]" class="form-control form-control-sm bill-paid-amount" value="' + (cycle.billpaidamount || '') + '" onkeyup="validateBillTotal(); calculateDifference(this);"></td>' +
                        '<td><input type="text" name="tds[]" class="form-control form-control-sm bill-tds" value="' + (cycle.tds || '') + '" onkeyup="validateBillTotal();"></td>' +
                        '<td class="row-difference">' + diff + '</td>' +
                        '<td><input type="text" name="remark[]" class="form-control form-control-sm" value="' + (cycle.remark || '') + '" placeholder="Remark"></td>' +
                        '<td class="row-running-total">0.00</td>' +
                        '<td><button type="button" class="btn btn-danger btn-xs" onclick="removeBillingCycleRow(this);">Remove</button></td>' +
                        '</tr>';
                    $('#billingcyclesbody').append(row);
                });
                renumberBillingRows();
            } else {
                addBillingCycleRow();
            }
            validateBillTotal();
        },
        error: function () {
            $('#billingcyclesbody').empty();
            addBillingCycleRow();
        }
    });
}

$(document).ready(function () {
    var contractno = '{{ $editconract->contractno }}';

    $('#billing-details').click(function () {
        loadBillingDetailsEditable(contractno);
    });

    $("#billingDetailsForm").submit(function (e) {
        e.preventDefault();
        $("#billingsubmitbtn").attr("disabled", true);
        $.ajax({
            type: "GET",
            contentType: "application/json",
            url: "{{URL::to('addbillingdetails')}}",
            data: $("#billingDetailsForm").serialize(),
            dataType: "json",
            success: function (data) {
                $("#billingsubmitbtn").attr("disabled", false);
                if (data.error) {
                    alert(data.error);
                } else {
                    alert('Billing details saved.');
                    loadBillingDetailsEditable(contractno);
                }
            },
            error: function () {
                $("#billingsubmitbtn").attr("disabled", false);
                alert('Something went wrong. Try Again.');
            }
        });
    });
});

</script>

<script type="text/javascript">
// Document View Functions for View Screen (Read Only)
$(document).ready(function() {
    console.log('View Screen - Document ready');
    
    var contractno = '{{ $editconract->contractno }}';
    console.log('Contract No:', contractno);
    
    // Documents tab click
    $('#documents-tab-link').click(function() {
        console.log('Documents tab clicked');
        if (contractno && contractno != '0' && contractno != '') {
            loadDocuments(contractno);
        } else {
            $('#no-documents').show();
            $('#uploaded-docs').hide();
        }
    });

    // Equipment Upload tab click
    $('#equipment-upload').click(function() {
        if (contractno && contractno != '0' && contractno != '') {
            loadEquipmentDocument(contractno);
        }
    });
    
    // Load on page load
    if (contractno && contractno != '0' && contractno != '') {
        loadDocuments(contractno);
        loadEquipmentDocument(contractno);
    } else {
        $('#no-documents').show();
        $('#uploaded-docs').hide();
    }
});

function loadDocuments(contractno) {
    console.log('loadDocuments called for:', contractno);
    var timestamp = new Date().getTime();
    
    $.ajax({
        url: '{{ url("get-contract-documents") }}/' + contractno + '?_=' + timestamp,
        type: 'GET',
        cache: false,
        success: function(response) {
            console.log('Response:', response);
            if (response.success && response.documents) {
                // Get the appropriate document set based on amendment status
                var isAmendment = {{ isset($editconract->amendmentno) && $editconract->amendmentno !== null && $editconract->amendmentno !== '' && $editconract->amendmentno !== '0' ? 'true' : 'false' }};
                var docs = isAmendment ? response.documents.amend : response.documents.new_contract;
                
                console.log('Using docs:', docs);
                console.log('Is amendment:', isAmendment);
                
                updateDocDisplay('doc1', docs ? docs.doc1 : null, contractno);
                updateDocDisplay('doc2', docs ? docs.doc2 : null, contractno);
                updateDocDisplay('doc3', docs ? docs.doc3 : null, contractno);
                
                if (!docs || (!docs.doc1 && !docs.doc2 && !docs.doc3)) {
                    $('#uploaded-docs').hide();
                    $('#no-documents').show();
                } else {
                    $('#uploaded-docs').show();
                    $('#no-documents').hide();
                }
            } else {
                $('#uploaded-docs').hide();
                $('#no-documents').show();
            }
        },
        error: function(xhr) {
            console.log('Error:', xhr);
            $('#uploaded-docs').hide();
            $('#no-documents').show();
        }
    });
}

function updateDocDisplay(docField, filePath, contractno) {
    if (filePath && filePath != null) {
        var fileName = filePath.split('/').pop();
        var shortName = fileName.length > 35 ? fileName.substring(0, 32) + '...' : fileName;
        var fileExtension = fileName.split('.').pop().toLowerCase();
        var isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension);
        var viewUrl = '{{ url("view-contract-document") }}/' + contractno + '/' + docField;
        var downloadUrl = '{{ url("download-contract-document") }}/' + contractno + '/' + docField;
        
        var actions = '';
        actions += '<a href="' + viewUrl + '" target="_blank" class="btn btn-info btn-xs" title="View">';
        actions += '<i class="glyphicon glyphicon-eye-open"></i> View</a> ';
        actions += '<a href="' + downloadUrl + '" class="btn btn-success btn-xs" title="Download">';
        actions += '<i class="glyphicon glyphicon-download-alt"></i> Download</a>';
        
        var fileIcon = '';
        if (fileExtension === 'pdf') {
            fileIcon = '<i class="glyphicon glyphicon-file" style="color: #d9534f;"></i> ';
        } else if (isImage) {
            fileIcon = '<i class="glyphicon glyphicon-picture" style="color: #5bc0de;"></i> ';
        } else {
            fileIcon = '<i class="glyphicon glyphicon-file" style="color: #f0ad4e;"></i> ';
        }
        
        $('#' + docField + '-name').html(fileIcon + '<a href="' + viewUrl + '" target="_blank">' + shortName + '</a>');
        $('#' + docField + '-action').html(actions);
        $('#' + docField + '-row').show();
    } else {
        $('#' + docField + '-row').hide();
    }
}
</script>

<script>

    // Equipment Document Functions for View Screen
function loadEquipmentDocument(contractno) {
    var isAmendment = {{ isset($editconract->amendmentno) && $editconract->amendmentno !== null && $editconract->amendmentno !== '' && $editconract->amendmentno !== '0' ? 'true' : 'false' }};
    
    $.ajax({
        url: '{{ url("get-equipment-document") }}/' + contractno,
        type: 'GET',
        cache: false,
        success: function(response) {
            if (response.success && response.document) {
                var docs = isAmendment ? response.document.amend_equipment : response.document.equipment;
                if (docs && docs.doc1) {
                    updateEquipmentDocDisplay(docs.doc1, contractno);
                } else {
                    $('#eqdoc1-row').hide();
                    $('#eqdoc-empty-row').show();
                }
            } else {
                $('#eqdoc1-row').hide();
                $('#eqdoc-empty-row').show();
            }
        },
        error: function() {
            $('#eqdoc1-row').hide();
            $('#eqdoc-empty-row').show();
        }
    });
}

function updateEquipmentDocDisplay(filePath, contractno) {
    if (filePath && filePath != null) {
        var fileName = filePath.split('/').pop();
        var shortName = fileName.length > 40 ? fileName.substring(0, 37) + '...' : fileName;
        var fileExtension = fileName.split('.').pop().toLowerCase();

        var viewUrl = '{{ url("view-equipment-document") }}/' + contractno;
        var downloadUrl = '{{ url("download-equipment-document") }}/' + contractno;

        var fileIcon = '';
        if (fileExtension === 'pdf') {
            fileIcon = '<i class="glyphicon glyphicon-file" style="color:#d9534f;"></i> ';
        } else if (['xls','xlsx'].includes(fileExtension)) {
            fileIcon = '<i class="glyphicon glyphicon-th" style="color:#5cb85c;"></i> ';
        } else {
            fileIcon = '<i class="glyphicon glyphicon-picture" style="color:#5bc0de;"></i> ';
        }

        var actions = '';
        actions += '<a href="' + viewUrl + '" target="_blank" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> View</a> ';
        actions += '<a href="' + downloadUrl + '" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-download-alt"></i> Download</a>';

        $('#eqdoc1-name').html(fileIcon + '<a href="' + viewUrl + '" target="_blank">' + shortName + '</a>');
        $('#eqdoc1-action').html(actions);
        $('#eqdoc1-row').show();
        $('#eqdoc-empty-row').hide();
    } else {
        $('#eqdoc1-row').hide();
        $('#eqdoc-empty-row').show();
    }
}


    </script>
@endsection