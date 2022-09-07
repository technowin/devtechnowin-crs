@extends('layouts.appnew')

@section('pageTitle', 'Add Contract')
@section('head-css')
    <link href="{{ asset('assets/Selectize/css/selectize.css') }}" rel="stylesheet">
@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="container">
                <div class="col-md-12 row">
                    {{--Vertical Tabs--}}
                    <div class="nav flex-column nav-pills col-md-2" id="v-pills-tab" role="tablist">
                        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-contract" role="tab"
                           aria-controls="v-pills-contract" aria-expanded="true" style="color: white">Contract</a>
                        <a class="nav-link" id="v-pills-contractdetails-tab" data-toggle="pill" href="#v-pills-contractdetails"
                           role="tab" aria-controls="v-pills-profile" aria-expanded="true" style="color: white">Contract Details</a>
                        <a class="nav-link" id="v-pills-paymentterms-tab" data-toggle="pill" href="#v-pills-paymentterms" role="tab"
                           aria-controls="v-pills-messages" aria-expanded="true" style="color: white">Payment Terms</a>
                        <a class="nav-link" id="v-pills-paymentschedules-tab" data-toggle="pill" href="#v-pills-paymentschedules"
                           role="tab"
                           aria-controls="v-pills-messages" aria-expanded="true" style="color: white">Payment Schedules</a>
                        <a class="nav-link" id="v-pills-payables-tab" data-toggle="pill" href="#v-pills-payables" role="tab"
                           aria-controls="v-pills-settings" aria-expanded="true" style="color: white">Payables</a>
                    </div>

                    {{--Vertical Tabs Data--}}
                    <div class="tab-content col-md-10" id="v-pills-tabContent">

                        {{--Contract Tab--}}
                        <div class="tab-pane fade show active" id="v-pills-contract" role="tabpanel"
                             aria-labelledby="v-pills-home-tab">
                            <div class="container card col-md-12">
                                <div class="col card-body">
                                    <div class="row" style="border-bottom: 1px solid darkgray">
                                        <div class="col-md-6"><h5 class="card-title text-muted">New Contract</h5></div>
                                        <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40"
                                                                   height="40"
                                                                   style="float: right; margin-top: -15px"/></div>
                                    </div>

                                    <div class="col-md-12">
                                        {{--{{ Form::open(array('url' => 'appadmin/addcontractmasterdata')) }}--}}
                                        {{ Form::open(array('action' => 'ContractController@addNewContract','method' => 'get', 'id' => 'contractmasterform')) }}
                                        {{ Form::hidden('contractsaved', $contractsaved) }}
                                        {{ Form::hidden('contractsavedid', '0', array('id' => 'contractsavedid')) }}
                                        <div class="row {{ $errors->has('contractno') ? ' has-error' : '' }} mt-2">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Contract No</label>
                                            <div class="col-sm-6">
                                                {{ Form::text('contractno', null, array('class' => 'form-control form-control-sm contract', 'readonly', 'id'=>'contractno')) }}
                                                @if ($errors->has('contractno'))
                                                    <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('customers') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Customer Name</label>
                                            <div class="col-sm-6">
                                                {{ Form::select('customers', $customers, null, array('placeholder' => '--SELECT--','id' => 'customers', 'required' => 'required')) }}
                                                @if ($errors->has('customers'))
                                                    <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('customersite') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Customer Site</label>
                                            <div class="col-sm-6">
                                                {{ Form::select('customersite',array(null => '--SELECT--'),null, array('id' => 'customersite')) }}
                                                @if ($errors->has('customersite'))
                                                    <span class="help-block"><strong>{{ $errors->first('customersite') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('tenderno') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Tender No</label>
                                            <div class="col-sm-6">
                                                {{ Form::select('tenderno',$tenders,null, array('placeholder' => '--SELECT--','id' => 'tenderno')) }}
                                                @if ($errors->has('tenderno'))
                                                    <span class="help-block"><strong>{{ $errors->first('tenderno') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row {{ $errors->has('tenderopendate') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Tender Open Date</label>
                                            <div class="col-sm-6">
                                                {{ Form::date('tenderopendate', null, array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('tenderopendate'))
                                                    <span class="help-block"><strong>{{ $errors->first('tenderopendate') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('workordertype') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Work Order Type</label>
                                            <div class="col-sm-6">
                                                {{ Form::select('workordertype',array('None'=>'None','AMC'=>'AMC', 'Warranty'=>'Warranty'),null, array('placeholder' => '--SELECT--','id' => 'workordertype', 'required' => 'required')) }}
                                                @if ($errors->has('workordertype'))
                                                    <span class="help-block"><strong>{{ $errors->first('workordertype') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('workorderno') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Work Order No</label>
                                            <div class="col-sm-6">
                                                {{ Form::select('workorderno', array('' => '--SELECT--'), null, array('id' => 'workorderno', 'required' => 'required')) }}
                                                @if ($errors->has('workorderno'))
                                                    <span class="help-block"><strong>{{ $errors->first('workorderno') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('workorderdescription') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Work Order
                                                Description</label>
                                            <div class="col-sm-6">
                                                {{ Form::textarea('workorderdescription',null,['class'=>'form-control form-control-sm', 'rows' => 3, 'cols' => 40,'onKeyPress' => "if(this.value.length==500) return false;"]) }}
                                                @if ($errors->has('workorderdescription'))
                                                    <span class="help-block"><strong>{{ $errors->first('workorderdescription') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row {{ $errors->has('workorderdate') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Work Order Date</label>
                                            <div class="col-sm-6">
                                                {{ Form::date('workorderdate', null, array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('workorderdate'))
                                                    <span class="help-block"><strong>{{ $errors->first('workorderdate') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row {{ $errors->has('contractfromdate') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Contract From Date</label>
                                            <div class="col-sm-6">
                                                {{ Form::date('contractfromdate', null, array('class' => 'form-control form-control-sm','id'=>'contractfromdateid')) }}
                                                @if ($errors->has('contractfromdate'))
                                                    <span class="help-block"><strong>{{ $errors->first('contractfromdate') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row {{ $errors->has('contracttodate') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Contract To Date</label>
                                            <div class="col-sm-6">
                                                {{--{{ Form::date('contracttodate', null, array('class' => 'form-control form-control-sm', 'id'=>'contracttodateid','onchange' => 'calculatemonths(); return false;')) }}--}}
                                                {{ Form::date('contracttodate', null, array('class' => 'form-control form-control-sm', 'id'=>'contracttodateid')) }}
                                                @if ($errors->has('contracttodate'))
                                                    <span class="help-block"><strong>{{ $errors->first('contracttodate') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('contractperiod') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Contract Period (In
                                                Years)</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('contractperiod', '', array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('contractperiod'))
                                                    <span class="help-block"><strong>{{ $errors->first('contractperiod') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('purchaseorderno') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Purchase Order No</label>
                                            <div class="col-sm-6">
                                                {{ Form::text('purchaseorderno', '', array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('purchaseorderno'))
                                                    <span class="help-block"><strong>{{ $errors->first('purchaseorderno') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row {{ $errors->has('purchaseorderdate') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Purchase Order
                                                Date</label>
                                            <div class="col-sm-6">
                                                {{ Form::date('purchaseorderdate', null, array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('purchaseorderdate'))
                                                    <span class="help-block"><strong>{{ $errors->first('purchaseorderdate') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('amendmentno') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Amendment No</label>
                                            <div class="col-sm-6">
                                                {{ Form::text('amendmentno', '', array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('amendmentno'))
                                                    <span class="help-block"><strong>{{ $errors->first('amendmentno') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('amendmentdescription') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Amendment
                                                Description</label>
                                            <div class="col-sm-6">
                                                {{ Form::textarea('amendmentdescription',null,['class'=>'form-control form-control-sm', 'rows' => 3, 'cols' => 40,'onKeyPress' => "if(this.value.length==500) return false;"]) }}
                                                @if ($errors->has('amendmentdescription'))
                                                    <span class="help-block"><strong>{{ $errors->first('amendmentdescription') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('renewalperiod') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Renewal Period</label>
                                            <div class="col-sm-6">
                                                {{ Form::text('renewalperiod', '', array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('renewalperiod'))
                                                    <span class="help-block"><strong>{{ $errors->first('renewalperiod') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('totalcost') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Total Cost</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('totalcost', '', array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('totalcost'))
                                                    <span class="help-block"><strong>{{ $errors->first('totalcost') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <label for="input" class="col-sm-3 col-form-label-sm text-muted"></label>
                                            <div class="col-sm-6">
                                                {{--<button id="contractSubmit" value="Submit" onclick="addnewcontract()"--}}
                                                {{--class="btn btn-primary">Submit--}}
                                                {{--</button>--}}
                                                {{ Form::submit('Save & Close', array('class' => 'btn btn-primary')) }}
                                            </div>
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--Contract Details Tab--}}
                        <div class="tab-pane fade" id="v-pills-contractdetails" role="tabpanel"
                             aria-labelledby="v-pills-profile-tab">
                            <div class="container card col-md-12">
                                <div class="col card-body">
                                    <div class="row" style="border-bottom: 1px solid darkgray">
                                        <div class="col-md-6"><h5 class="card-title text-muted">Contract Details</h5></div>
                                        <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40"
                                                                   height="40"
                                                                   style="float: right; margin-top: -15px"/></div>
                                    </div>
                                    {{Form::open(array('action' => 'ContractController@addContractDetails','method' => 'get', 'id' => 'contractdetailsform'))}}
                                    {{ Form::hidden('contractdetailssaved', '', array('id' => 'contractdetailssaved')) }}
                                    <div class="col-md-12">
                                        {{ Form::hidden('contractdetailsid[]', '0') }}
                                        <div class="row {{ $errors->has('contractno') ? ' has-error' : '' }} mt-2">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Contract No</label>
                                            <div class="col-sm-6">
                                                {{ Form::text('contractno', null, array('class' => 'form-control form-control-sm contract','readonly')) }}
                                                @if ($errors->has('contractno'))
                                                    <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card col-md-12">
                                        <div class="row{{ $errors->has('productservice') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Equipment</label>
                                            <div class="col-sm-6">
                                                {{ Form::select('productservice[]', $productservice, null, array('placeholder' => '--SELECT--', 'id' => 'productservice')) }}
                                                @if ($errors->has('productservice'))
                                                    <span class="help-block"><strong>{{ $errors->first('productservice') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Quantity</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('quantity[]', null, array('class' => 'form-control form-control-sm', 'id' => 'quantity', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#tax").val(),$("#warranty_amc_period").val(), $("#grossrate"))')) }}
                                                <span class="help-block"><strong>{{ $errors->first('quantity') }}</strong></span>
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('rate') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Rate</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('rate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'rate', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#tax").val(),$("#warranty_amc_period").val(), $("#grossrate"))')) }}
                                                @if ($errors->has('rate'))
                                                    <span class="help-block"><strong>{{ $errors->first('rate') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('tax') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Tax</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('tax[]', null, array('class' => 'form-control form-control-sm', 'id'=>'tax', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#tax").val(),$("#warranty_amc_period").val(), $("#grossrate"))')) }}
                                                @if ($errors->has('tax'))
                                                    <span class="help-block"><strong>{{ $errors->first('tax') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('warranty_amc_period') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Warranty / AMC Period (in
                                                months)</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('warranty_amc_period[]', null, array('class' => 'form-control form-control-sm', 'id'=>'warranty_amc_period', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#tax").val(),$("#warranty_amc_period").val(), $("#grossrate"))')) }}
                                                @if ($errors->has('warranty_amc_period'))
                                                    <span class="help-block"><strong>{{ $errors->first('warranty_amc_period') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('grossrate') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Gross Rate (Rs.)</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('grossrate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'grossrate', 'readonly')) }}
                                                @if ($errors->has('grossrate'))
                                                    <span class="help-block"><strong>{{ $errors->first('grossrate') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('sgstrate') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">SGST Rate</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('sgstrate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'sgstrate')) }}
                                                @if ($errors->has('grossrate'))
                                                    <span class="help-block"><strong>{{ $errors->first('grossrate') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('sgstamt') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">SGST Amt</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('sgstamt[]', null, array('class' => 'form-control form-control-sm', 'id'=>'sgstamt')) }}
                                                @if ($errors->has('grossrate'))
                                                    <span class="help-block"><strong>{{ $errors->first('grossrate') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('cgstrate') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">CGST Rate</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('cgstrate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'cgstrate')) }}
                                                @if ($errors->has('grossrate'))
                                                    <span class="help-block"><strong>{{ $errors->first('grossrate') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('cgstamt') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">CGST Amt</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('cgstamt[]', null, array('class' => 'form-control form-control-sm', 'id'=>'cgstamt')) }}
                                                @if ($errors->has('grossrate'))
                                                    <span class="help-block"><strong>{{ $errors->first('grossrate') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('taxrate') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Tax Rate</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('taxrate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'taxrateid', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#tax").val(),$("#warranty_amc_period").val(), $("#grossrate"))')) }}
                                                @if ($errors->has('tax'))
                                                    <span class="help-block"><strong>{{ $errors->first('tax') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="contractdetailsrowcount" value="1">
                                    <div id="add">

                                    </div>
                                    <br/>
                                    <button class="btn btn-default" onclick="addequipmentdiv(); return false;">Add Equipment
                                    </button>

                                    <div class="row">
                                        <label for="input" class="col-sm-4 col-form-label-sm text-muted"></label>
                                        <div class="col-sm-6">
                                            {{ Form::submit('Save & Close', array('class' => 'btn btn-primary')) }}
                                            {{--                                {{ Form::button('Save & Close', array('class' => 'btn btn-primary', 'onclick' => 'addnewcontractdetails()')) }}--}}
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>

                        {{--Payment Terms--}}
                        <div class="tab-pane fade" id="v-pills-paymentterms" role="tabpanel"
                             aria-labelledby="v-pills-messages-tab">
                            <div class="container card col-md-12">
                                <div class="col card-body">
                                    <div class="row" style="border-bottom: 1px solid darkgray">
                                        <div class="col-md-6"><h5 class="card-title text-muted">Payment Terms</h5></div>
                                        <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40"
                                                                   height="40"
                                                                   style="float: right; margin-top: -15px"/></div>
                                    </div>
                                    {{ Form::hidden('paymenttermsid', '0') }}
                                    <div class="col-md-12">
                                        {{Form::open(array('action' => 'ContractController@addPaymentTerms','method' => 'post', 'id'=>'paymenttermsform'))}}
                                        <div class="row {{ $errors->has('contractno') ? ' has-error' : '' }} mt-2">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Contract No</label>
                                            <div class="col-sm-6">
                                                {{ Form::text('contractno', null, array('class' => 'form-control form-control-sm contract', 'readonly')) }}
                                                @if ($errors->has('contractno'))
                                                    <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('securitydeposit') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Security Deposit
                                                (SD)</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('securitydeposit', null, array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('securitydeposit'))
                                                    <span class="help-block"><strong>{{ $errors->first('text') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('sbpaymentperiod') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">SD Payment Period
                                                (days)</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('sbpaymentperiod', null, array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('sbpaymentperiod'))
                                                    <span class="help-block"><strong>{{ $errors->first('sbpaymentperiod') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('admincharges') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Admin Charges (BG)</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('admincharges', null, array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('admincharges'))
                                                    <span class="help-block"><strong>{{ $errors->first('admincharges') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('facilitycharges') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Facility
                                                Charges</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('facilitycharges', null, array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('facilitycharges'))
                                                    <span class="help-block"><strong>{{ $errors->first('facilitycharges') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div id="amcdiv">
                                            <div class="row{{ $errors->has('paymentintervalforamc') ? ' has-error' : '' }}">
                                                <label for="input" class="col-sm-3 col-form-label text-muted">Payment Interval
                                                    For
                                                    AMC</label>
                                                <div class="col-sm-6">
                                                    {{ Form::select('paymentintervalforamc',array('1'=>'Monthly','2'=>'Bimonthly','3'=>'Quaterly', '6'=>'Half Yearly', '12'=>'Yearly'),null, array('placeholder' => '--SELECT--','class' => 'selectize')) }}
                                                    @if ($errors->has('paymentintervalforamc'))
                                                        <span class="help-block"><strong>{{ $errors->first('paymentintervalforamc') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div id="salesdiv">
                                            <div class="row{{ $errors->has('firstpaymentpercent') ? ' has-error' : '' }}">
                                                <label for="input" class="col-sm-3 col-form-label text-muted">First Payment
                                                    Percent</label>
                                                <div class="col-sm-6">
                                                    {{ Form::number('firstpaymentpercent', null, array('class' => 'form-control form-control-sm')) }}
                                                    @if ($errors->has('firstpaymentpercent'))
                                                        <span class="help-block"><strong>{{ $errors->first('firstpaymentpercent') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row{{ $errors->has('firstpaymentcriteria') ? ' has-error' : '' }}">
                                                <label for="input" class="col-sm-3 col-form-label text-muted">First Payment
                                                    Criteria</label>
                                                <div class="col-sm-6">
                                                    {{ Form::select('firstpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),null, array('placeholder' => '--SELECT--','class' => 'selectize')) }}
                                                    @if ($errors->has('firstpaymentcriteria'))
                                                        <span class="help-block"><strong>{{ $errors->first('firstpaymentcriteria') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row{{ $errors->has('secondpaymentpercent') ? ' has-error' : '' }}">
                                                <label for="input" class="col-sm-3 col-form-label text-muted">Second Payment
                                                    Percent</label>
                                                <div class="col-sm-6">
                                                    {{ Form::number('secondpaymentpercent', null, array('class' => 'form-control form-control-sm')) }}
                                                    @if ($errors->has('secondpaymentpercent'))
                                                        <span class="help-block"><strong>{{ $errors->first('secondpaymentpercent') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row{{ $errors->has('secondpaymentcriteria') ? ' has-error' : '' }}">
                                                <label for="input" class="col-sm-3 col-form-label text-muted">Second Payment
                                                    Criteria</label>
                                                <div class="col-sm-6">
                                                    {{ Form::select('secondpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),null, array('placeholder' => '--SELECT--','class' => 'selectize')) }}
                                                    @if ($errors->has('secondpaymentcriteria'))
                                                        <span class="help-block"><strong>{{ $errors->first('secondpaymentcriteria') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row{{ $errors->has('thirdpaymentpercent') ? ' has-error' : '' }}">
                                                <label for="input" class="col-sm-3 col-form-label text-muted">Third Payment
                                                    Percent</label>
                                                <div class="col-sm-6">
                                                    {{ Form::number('thirdpaymentpercent', null, array('class' => 'form-control form-control-sm')) }}
                                                    @if ($errors->has('thirdpaymentpercent'))
                                                        <span class="help-block"><strong>{{ $errors->first('thirdpaymentpercent') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row{{ $errors->has('thirdpaymentcriteria') ? ' has-error' : '' }}">
                                                <label for="input" class="col-sm-3 col-form-label text-muted">Third Payment
                                                    Criteria</label>
                                                <div class="col-sm-6">
                                                    {{ Form::select('thirdpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),null, array('placeholder' => '--SELECT--','class' => 'selectize')) }}
                                                    @if ($errors->has('thirdpaymentcriteria'))
                                                        <span class="help-block"><strong>{{ $errors->first('thirdpaymentcriteria') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row{{ $errors->has('fourthpaymentpercent') ? ' has-error' : '' }}">
                                                <label for="input" class="col-sm-3 col-form-label text-muted">Fourth Payment
                                                    Percent</label>
                                                <div class="col-sm-6">
                                                    {{ Form::number('fourthpaymentpercent', null, array('class' => 'form-control form-control-sm')) }}
                                                    @if ($errors->has('fourthpaymentpercent'))
                                                        <span class="help-block"><strong>{{ $errors->first('fourthpaymentpercent') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row{{ $errors->has('fourthpaymentcriteria') ? ' has-error' : '' }}">
                                                <label for="input" class="col-sm-3 col-form-label text-muted">Fourth Payment
                                                    Criteria</label>
                                                <div class="col-sm-6">
                                                    {{ Form::select('fourthpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),null, array('placeholder' => '--SELECT--','class' => 'selectize')) }}
                                                    @if ($errors->has('fourthpaymentcriteria'))
                                                        <span class="help-block"><strong>{{ $errors->first('fourthpaymentcriteria') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row{{ $errors->has('fifthpaymentpercent') ? ' has-error' : '' }}">
                                                <label for="input" class="col-sm-3 col-form-label text-muted">Fifth Payment
                                                    Percent</label>
                                                <div class="col-sm-6">
                                                    {{ Form::number('fifthpaymentpercent', null, array('class' => 'form-control form-control-sm')) }}
                                                    @if ($errors->has('fifthpaymentpercent'))
                                                        <span class="help-block"><strong>{{ $errors->first('fifthpaymentpercent') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row{{ $errors->has('fifthpaymentcriteria') ? ' has-error' : '' }}">
                                                <label for="input" class="col-sm-3 col-form-label text-muted">Fifth Payment
                                                    Criteria</label>
                                                <div class="col-sm-6">
                                                    {{ Form::select('fifthpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),null, array('placeholder' => '--SELECT--','class' => 'selectize')) }}
                                                    @if ($errors->has('fifthpaymentcriteria'))
                                                        <span class="help-block"><strong>{{ $errors->first('fifthpaymentcriteria') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('leaddaysforpayment') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Lead Days For
                                                Payment</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('leaddaysforpayment', null, array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('leaddaysforpayment'))
                                                    <span class="help-block"><strong>{{ $errors->first('leaddaysforpayment') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <label for="input" class="col-sm-3 col-form-label-sm text-muted"></label>
                                            <div class="col-sm-6">
                                                {{ Form::submit('Save & Close', array('class' => 'btn btn-primary')) }}
                                                {{--{{ Form::button('Save & Close', array('class' => 'btn btn-primary', 'onclick' => 'addpaymentterms()')) }}--}}
                                            </div>
                                        </div>
                                        {{ Form::close() }}
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{--Payables--}}
                        <div class="tab-pane fade" id="v-pills-payables" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <div class="container card col-md-12">
                                <div class="col card-body">
                                    <div class="row" style="border-bottom: 1px solid darkgray">
                                        <div class="col-md-6"><h5 class="card-title text-muted">Payables</h5></div>
                                        <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40"
                                                                   height="40" style="float: right; margin-top: -15px"/></div>
                                    </div>
                                    <div class="col-md-12">
                                        {{Form::open(array('action' => 'ContractController@addPayables','method' => 'post'))}}
                                        <div class="row {{ $errors->has('contractno') ? ' has-error' : '' }} mt-2">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Contract No</label>
                                            <div class="col-sm-6">
                                                {{ Form::text('contractno', null, array('class' => 'form-control form-control-sm contract', 'readonly')) }}
                                                @if ($errors->has('contractno'))
                                                    <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row {{ $errors->has('sdpaymentdate') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">SD Payment
                                                Date</label>
                                            <div class="col-sm-6">
                                                {{ Form::date('sdpaymentdate', null, array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('sdpaymentdate'))
                                                    <span class="help-block"><strong>{{ $errors->first('sdpaymentdate') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('totalsecuritydepositpaid') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Total SD Paid</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('totalsecuritydepositpaid', null, array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('totalsecuritydepositpaid'))
                                                    <span class="help-block"><strong>{{ $errors->first('totalsecuritydepositpaid') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('sdpaymentmode') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">SD Payment
                                                Mode</label>
                                            <div class="col-sm-6">
                                                {{ Form::select('sdpaymentmode',array('Cash'=>'Cash','Cheque'=>'Cheque','Bank Guarantee'=>'Bank Guarantee'),null, array('placeholder' => '--SELECT--','class' => 'selectize')) }}
                                                @if ($errors->has('sdpaymentmode'))
                                                    <span class="help-block"><strong>{{ $errors->first('sdpaymentmode') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('adminchargespaymentdate') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Admin Charges Payment
                                                Date</label>
                                            <div class="col-sm-6">
                                                {{ Form::date('adminchargespaymentdate', null, array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('adminchargespaymentdate'))
                                                    <span class="help-block"><strong>{{ $errors->first('adminchargespaymentdate') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('adminchargespaid') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Admin Charges
                                                Paid</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('adminchargespaid', null, array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('adminchargespaid'))
                                                    <span class="help-block"><strong>{{ $errors->first('adminchargespaid') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('facilitychargespaymentdate') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Facility Charges
                                                Payment
                                                Date</label>
                                            <div class="col-sm-6">
                                                {{ Form::date('facilitychargespaymentdate', null, array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('facilitychargespaymentdate'))
                                                    <span class="help-block"><strong>{{ $errors->first('facilitychargespaymentdate') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('facilitychargespaid') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-3 col-form-label text-muted">Facility Charges
                                                Paid</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('facilitychargespaid', null, array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('facilitychargespaid'))
                                                    <span class="help-block"><strong>{{ $errors->first('facilitychargespaid') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <label for="input" class="col-sm-3 col-form-label-sm text-muted"></label>
                                            <div class="col-sm-6">
                                                {{ Form::submit('Save & Close', array('class' => 'btn btn-primary')) }}
                                            </div>
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-paymentschedules" role="tabpanel"
                             aria-labelledby="v-pills-settings-tab">
                            <div class="container card col-md-12">
                                <div class="col card-body">
                                    <div class="row" style="border-bottom: 1px solid darkgray">
                                        <div class="col-md-6"><h5 class="card-title text-muted">Payment Schedules And
                                                Receivables</h5></div>
                                        <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40"
                                                                   height="40" style="float: right; margin-top: -15px"/></div>
                                    </div>
                                    <div class="col-md-12" id="paymenttermsdiv">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('page-script')
    <script>
        $(document).ready(function () {
            $('#workorderno').selectize({
                maxItems: 1
            });

            $('#productserialno').selectize({
                maxItems: 1
            });

            $('#productservice').selectize({
                maxItems: 1
            });

            $('#category').selectize({
                maxItems: 1
            });

            $('#tenderno').selectize({
                maxItems: 1
            });

            $('#workordertype').selectize({
                maxItems: 1
            });

            $('#customers').selectize({
                maxItems: 1
            });

            $('#customersite').selectize({
                maxItems: 1
            });

            $('.selectize').selectize({
                maxItems: 1
            });

            $("#amcdiv").hide();
            $("#salesdiv").hide();

            $("#customers").change(function () {
                var branchlist = [];

                if ($('#customers').val() != "") {
                    $.ajax({
                        url: '{{ URL::to('registration/branch') }}/' + $('#customers').val(),
                        //url: '/registration/branch/' + $('#customers').val(),
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $.each(data, function (key, value) {
                                branchlist.push({
                                    text: value['branchname'],
                                    value: value['branchcode'],
                                })
                            });

                            $('#customersite').selectize()[0].selectize.destroy();

                            if (branchlist.length > 0) {
                                $('#customersite').selectize({
                                    maxItems: 1,
                                    valueField: 'value',
                                    labelField: 'text',
                                    searchField: 'text',
                                    create: false,
                                    sortField: {
                                        field: 'text',
                                        direction: 'asc'
                                    },
                                    options: branchlist,
                                });
                            }
                            else {
                                $('#customersite').selectize({
                                    options: null
                                });
                            }
                        }
                    });

                    var workorderlist = [];
                    $.ajax({
                        url: '{{ URL::to('appadmin/workorders') }}/' + $('#customers').val(),
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $.each(data, function (key, value) {
                                workorderlist.push({
                                    text: value['workorderno'],
                                    value: value['workorderno'],
                                })
                            });

                            $('#workorderno').selectize()[0].selectize.destroy();

                            if (workorderlist.length > 0) {
                                $('#workorderno').selectize({
                                    maxItems: 1,
                                    valueField: 'value',
                                    labelField: 'text',
                                    searchField: 'text',
                                    create: false,
                                    sortField: {
                                        field: 'text',
                                        direction: 'asc'
                                    },
                                    options: workorderlist,
                                });
                            }
                            else {
                                $('#workorderno').selectize({
                                    options: null
                                });
                            }
                        }
                    });
                }
                else {

                    $('#customersite').selectize()[0].selectize.destroy();
                    $('#customersite').selectize({
                        options: null
                    });
                }
            });

//            Generate Contract No
            $('#workorderno').change(function () {

                if ($('#workordertype').val() != "" && $('#workorderno').val() != "") {
                    if ($('#workordertype').val() == "None") {

                        var contractno = 'NEW-' + $('#workorderno').val();
                        populateContractNo(contractno);
                    }
                    else {
                        var contractno = $('#workordertype').val().substring(0, 3).toUpperCase() + '-' + $('#workorderno').val();
                        populateContractNo(contractno);
                    }
                }
                else {
                    populateContractNo('');
                }
            });

//            Generate Contract No and show hide areas for the work order type selected
            $('#workordertype').change(function () {

                if ($('#workordertype').val() == "AMC") {
                    $("#amcdiv").show();
                    $("#salesdiv").hide();
                }
                else if ($('#workordertype').val() == "Warranty") {
                    $("#amcdiv").hide();
                    $("#salesdiv").show();
                }
                else {
                    $("#amcdiv").hide();
                    $("#salesdiv").hide();
                }

                if ($('#workordertype').val() != "" && $('#workorderno').val() != "") {
                    if ($('#workordertype').val() == "None") {
                        var contractno = 'NEW-' + $('#workorderno').val();
                        populateContractNo(contractno);
                    }
                    else {
                        var contractno = $('#workordertype').val().substring(0, 3).toUpperCase() + '-' + $('#workorderno').val();
                        populateContractNo(contractno);
                    }
                }
                else {
                    populateContractNo('');
                }
            });
        });

        function checkifcontractnoisavailable() {
            $contractno = document.getElementById('contractno');
            if ($contractno.value == "") {
                event.preventDefault();
                alert("Contract No not available!");
                return false;
            }
            return true;
        }

        function checkifcontractissaved() {
            $contractsaveid = document.getElementById('contractsavedid');
            if ($contractsaveid.value == "") {
                event.preventDefault();
                alert("Save Contract Data to Proceed!!!");
                return false;
            }
            return true;
        }

        function checkifcontractdetailssaved() {
            $contractdetailssaved = document.getElementById('contractdetailssaved');
            if ($contractdetailssaved.value == "") {
                event.preventDefault();
                alert("Save Contract Details Data to Proceed!!!");
                return false;
            }
            return true;
        }

        function populateContractNo(contractno) {
            $abc = document.getElementsByClassName('contract');
            $.each($abc, function (contract, value) {
                var abc = value;
                abc.value = contractno;
            });
        }

        function calculategross(quantity, rate, tax, period, grossrate) {
            if (quantity != "" && rate != "" && tax != "" && period != "") {

                var calculatedtax = rate * tax / 100;
                var rateplustax = parseFloat(rate) + parseFloat(calculatedtax);
                var grossratecalculated = parseFloat(rateplustax) * parseFloat(quantity) * parseFloat(period);
//                $('#grossrate').val(grossrate);
                grossrate.val(grossratecalculated);
            }
            else {
                grossrate.val('0');
            }
        }

        function addequipmentdiv() {
            var count = $('#contractdetailsrowcount').val();

            var quantity = "$('#quantity%count%').val()".replace("%count%", count);
            var rate = "$('#rate%count%').val()".replace("%count%", count);
            var tax = "$('#tax%count%').val()".replace("%count%", count);
            var period = "$('#warranty_amc_period%count%').val()".replace("%count%", count);
            var grossrate = "$('#grossrate%count%')".replace("%count%", count);

            var appendtags = '<br/><div class="card col-md-12">{{ Form::hidden('contractdetailsid[]', '0') }} <div class="row mt-1"> ' +
                '<label for="input" class="col-sm-4 col-form-label text-muted">Equipment</label> <div class="col-sm-6"> ' +
                '{{ Form::select('productservice[]', $productservice, null, array('placeholder' => '--SELECT--', 'id' => 'productservice%count%')) }} </div> </div> '.replace('%count%', count) +
                '<div class="row"> <label for="input" class="col-sm-4 col-form-label text-muted">Quantity</label> <div class="col-sm-6"> ' +
                '{{ Form::number('quantity[]', null, array('class' => 'form-control form-control-sm', 'id' => 'quantity%count%', 'onkeyup')) }} </div> </div> '.replace('%count%', count).replace('onkeyup', "onkeyup = calculategross(" + quantity + "," + rate + "," + tax + "," + period + "," + grossrate + "); return false;") +
                '<div class="row"> <label for="input" class="col-sm-4 col-form-label text-muted">Rate</label> <div class="col-sm-6"> ' +
                '{{ Form::number('rate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'rate%count%', 'onkeyup')) }}</div> </div>'.replace('%count%', count).replace('onkeyup', "onkeyup = calculategross(" + quantity + "," + rate + "," + tax + "," + period + "," + grossrate + "); return false;") +
                ' <div class="row"> <label for="input" class="col-sm-4 col-form-label text-muted">Tax</label> <div class="col-sm-6">' +
                ' {{ Form::number('tax[]', null, array('class' => 'form-control form-control-sm', 'id'=>'tax%count%', 'onkeyup')) }} </div> </div>'.replace('%count%', count).replace('onkeyup', "onkeyup = calculategross(" + quantity + "," + rate + "," + tax + "," + period + "," + grossrate + "); return false;") +
                ' <div class="row"> <label for="input" class="col-sm-4 col-form-label text-muted">Warranty / AMC Period (in years)</label> <div class="col-sm-6">' +
                ' {{ Form::number('warranty_amc_period[]', null, array('class' => 'form-control form-control-sm', 'id'=>'warranty_amc_period%count%', 'onkeyup')) }}</div> </div>'.replace('%count%', count).replace('onkeyup', "onkeyup = calculategross(" + quantity + "," + rate + "," + tax + "," + period + "," + grossrate + "); return false;") +
                ' <div class="row"> <label for="input" class="col-sm-4 col-form-label text-muted">Gross Rate (Rs.)</label> <div class="col-sm-6"> ' +
                '{{ Form::number('grossrate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'grossrate%count%', 'readonly')) }} </div> </div> </div>'.replace('%count%', count);

            $('#add').append(appendtags);
            $('#productservice' + count).selectize({
                maxItems: 1
            });

            count = parseInt(count) + 1;
            $('#contractdetailsrowcount').val(count);
        }

        function getarray(data) {
            var array = [];

            $.each(data, function (index, value) {
                array.push(value.value);
            });

            return array;
        }

    </script>

    <script>

        $("#contractmasterform").submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                contentType: "application/json",
                url: "{{URL::to('appadmin/addcontractmasterdata')}}",
                data: $("#contractmasterform").serialize(),
                success: function (response) {
                    debugger
                    if (response != "Error") {
                        document.getElementById('contractsavedid').value = response;
                        $('#v-pills-contractdetails-tab').click();
                    }
                    else {
                        alert('Try Again!!!!');
                    }
                }
            });
        });

        $("#contractdetailsform").submit(function (e) {
            debugger
            e.preventDefault();
            var acb = $("#contractdetailsform").serialize();
            $.ajax({
                type: "GET",
                contentType: "application/json",
                url: "{{URL::to('appadmin/addnewcontractdetails')}}",
                data: $("#contractdetailsform").serialize(),
                success: function (response) {
                    debugger
                    if (response != "Error") {

                        document.getElementById('contractdetailssaved').value = 'yes';
                        var data = JSON.parse(response);
                        for (i = 0; i < data.length; i++) {
                            document.getElementsByName('contractdetailsid[]')[i].value = data[i];
                        }
                        $('#v-pills-paymentterms-tab').click();
                    }
                    else {
                        alert('Try Again!!!!');
                    }
                }
            });
        });

        $("#paymenttermsform").submit(function (e) {
            e.preventDefault();
            $.ajax({
                contentType: "application/json",
                url: "{{URL::to('appadmin/addnewequipmentdetails')}}",
                type: "GET",
                data: $("#paymenttermsform").serialize(),
                dataType: "json",
                success: function (response) {
                    debugger
                    if (response != "Error") {
                        document.getElementsByName('paymenttermsid')[0].value = response;

                        $.ajax({
                            contentType: "application/json",

                            url: "{{URL::to('appadmin/showpaymentschedule')}}/" + contractno,
                            type: "GET",
                            success: function (generatedhtml) {
                                debugger
                                $("#paymenttermsdiv").html(generatedhtml);
                                $('#v-pills-paymentschedules-tab').click();
                            }
                        });
                    }
                    else {
                        alert('Try Again!!!!');
                    }
                }
            });
        });
    </script>
@endsection