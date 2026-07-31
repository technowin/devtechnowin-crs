@extends('layouts.appnew')
@section('pageTitle', 'Add Contract')
@section('page-css')
    <link href="{{asset('css/tab-css.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('content')

@php
    $is_amendment = isset($is_amendment) ? $is_amendment : false;
@endphp

    <div class="container-fluid">
        <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#contract-tab" id="contract" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Contract</a></li>
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
                <div class="tab-pane fade active in" role="tabpanel" id="contract-tab" aria-labelledby="contract-master" style="margin-left: 250px;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Edit Contract</h3>
                        </div>
                        <div class="panel-body">
                            {{Form::open(array('action' => 'ContractController@addNewContract','method' => 'get', 'id' => 'contractmasterform'))}}
                            {{ Form::hidden('contractsavedid', $editconract->contractno, array('id' => 'contractsavedid')) }}
                            {{ Form::hidden('hdcompresinvetype', $editconract->workordertype, array('id' => 'hdcompresinvetypeid')) }}
                            {{ Form::hidden('customers', $editconract->customercode, array('id' => 'customerhdid')) }}
                            {{ Form::hidden('contractnositid', '', array('id' => 'contractnositid')) }}
                            {{ Form::hidden('serviceChangeId', $serviceChangeId, array('id' => 'serviceChangeId')) }}

                            <div class="row{{ $errors->has('contractno') ? ' has-error' : '' }}" style="padding-top:5px;">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Contract No.</label>
                                <div class="col-sm-6">
                                    {{--{{ Form::select('customers', $customers, $customerscode, array('required' => 'required', 'id'=>'customers' )) }}--}}
                                    {{ Form::text('contractno',$editconract->contractno,['class'=>'form-control form-control-sm','readonly']) }}
                                    @if ($errors->has('contractno'))
                                        <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('customers') ? ' has-error' : '' }}" style="padding-top:5px;">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Customer Name</label>
                                <div class="col-sm-6">
                                    {{--{{ Form::select('customers', $customers, $customerscode, array('required' => 'required', 'id'=>'customers' )) }}--}}
                                    {{ Form::text('name',$customername,['class'=>'form-control form-control-sm','readonly']) }}
                                    @if ($errors->has('customers'))
                                        <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('tenderno') ? ' has-error' : '' }}">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Tender No/Quotation No</label>
                                <div class="col-sm-6">
                                    {{ Form::select('tenders', $tenders, $tenderscode, array('placeholder'=>'--select--','id'=>'tenderno' ,'onchange'=>'gettenderopendate();')) }}
                                    @if ($errors->has('tenderno'))
                                        <span class="help-block"><strong>{{ $errors->first('tenderno') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row {{ $errors->has('tenderopendate') ? ' has-error' : '' }}">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Tender Open
                                    Date</label>
                                <div class="col-sm-6">
                                    {{ Form::date('tenderopendate', $editconract->tenderopendate, array('id' => 'tenderopendateid','class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('tenderopendate'))
                                        <span class="help-block"><strong>{{ $errors->first('tenderopendate') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('workordertype') ? ' has-error' : '' }}">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Work Order
                                    Type</label>
                                <div class="col-sm-6">
                                    {{--{{ Form::select('workordertype',array('Software development'=>'Software development','Hardware AMC'=>'Hardware AMC','Software Maintenance'=>'Software Maintenance & Suppprt','Hardware Warranty'=>'Hardware Warranty','AMC'=>'AMC', 'Warranty'=>'Warranty'),$editconract->workordertype, array('placeholder' => '--SELECT--','id' => 'workordertypeid', 'required' => 'required')) }}--}}
                                    {{ Form::text('workordertype',$editconract->workordertype,['class'=>'form-control form-control-sm','readonly']) }}
                                    @if ($errors->has('workordertype'))
                                        <span class="help-block"><strong>{{ $errors->first('workordertype') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            {{--@if($editconract->workordertype == "Hardware AMC")--}}
                            <div id="customername"
                                 class="row{{ $errors->has('workordertype') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Comprehensive
                                    Type</label>
                                <div class="col-sm-6">
                                    {{ Form::select('comprehensivetype',array('comprehensive'=>'Comprehensive','noncomprehensive'=>'Non Comprehensive'),$editconract->comprehensivetype, array('placeholder' => '--SELECT--','id' => 'comprehensiveid')) }}
                                    @if ($errors->has('workordertype'))
                                        <span class="help-block"><strong>{{ $errors->first('workordertype') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            {{--@endif--}}

                            <div class="row{{ $errors->has('workorderno') ? ' has-error' : '' }} ">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Work Order No</label>
                                <div class="col-sm-6">
                                    {{--{{ Form::select('workorderno', array('' => '--SELECT--'), null, array('id' => 'workorderno', 'required' => 'required')) }}--}}
                                    {{ Form::text('workorderno',$editconract->workorderno,['class'=>'form-control form-control-sm']) }}
                                    @if ($errors->has('workorderno'))
                                        <span class="help-block"><strong>{{ $errors->first('workorderno') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('workorderdescription') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Work Order
                                    Description</label>
                                <div class="col-sm-6">
                                    {{ Form::textarea('workorderdescription',$editconract->workorderdescription,['class'=>'form-control form-control-sm', 'rows' => 3, 'cols' => 40,'onKeyPress' => "if(this.value.length==500) return false;"]) }}
                                    @if ($errors->has('workorderdescription'))
                                        <span class="help-block"><strong>{{ $errors->first('workorderdescription') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row {{ $errors->has('workorderdate') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Work Order
                                    Date</label>
                                <div class="col-sm-6">
                                    {{ Form::date('workorderdate', $editconract->workorderdate, array('id'=>'workorderdateid','class' => 'form-control form-control-sm','required' => 'required','max'=> '2050-12-31')) }}
                                    @if ($errors->has('workorderdate'))
                                        <span class="help-block"><strong>{{ $errors->first('workorderdate') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row {{ $errors->has('contractfromdate') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Contract From
                                    Date</label>
                                <div class="col-sm-6">
                                    {{ Form::date('contractfromdate', $editconract->contractfromdate, array('class' => 'form-control form-control-sm','id'=>'contractfromdateid','required' => 'required','max'=> '2050-12-31')) }}
                                    @if ($errors->has('contractfromdate'))
                                        <span class="help-block"><strong>{{ $errors->first('contractfromdate') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row {{ $errors->has('contracttodate') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Contract To
                                    Date</label>
                                <div class="col-sm-6">
                                    {{--{{ Form::date('contracttodate', null, array('class' => 'form-control form-control-sm', 'id'=>'contracttodateid','onchange' => 'calculatemonths(); return false;')) }}--}}
                                    {{ Form::date('contracttodate', $editconract->contracttodate, array('class' => 'form-control form-control-sm', 'id'=>'contracttodateid','required' => 'required','onchange' => 'getyear()','max'=> '2050-12-31')) }}
                                    @if ($errors->has('contracttodate'))
                                        <span class="help-block"><strong>{{ $errors->first('contracttodate') }}</strong></span>
                                    @endif
                                </div>
                            </div>
{{--                            @if($editconract->workordertype == "Hardware AMC" || $editconract->workordertype == "Hardware Warranty" || $editconract->workordertype == "AMC" || $editconract->workordertype == "Software development" || $editconract->workordertype == "Warranty")--}}
                            <div class="row{{ $errors->has('servicefrequency') ? ' has-error' : '' }} mt-1" id="servicedivid">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Service Frequency</label>
                                <div class="col-sm-6">
                                    {{ Form::select('serviceParameterscode',$serviceParameterscode,$editconract->servicefrequency, array('placeholder' => '--SELECT--','id'=>'servicefrequencyid')) }}
                                    @if ($errors->has('servicefrequency'))
                                        <span class="help-block"><strong>{{ $errors->first('servicefrequency') }}</strong></span>
                                    @endif
                                </div>
                            </div>
{{--                            @endif--}}
                            <div class="row{{ $errors->has('contractperiod') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Contract Period (In
                                    Years)</label>
                                <div class="col-sm-6">
                                    {{ Form::number('contractperiod',$contractperiod, array('class' => 'form-control form-control-sm','id'=>'contractperiodid','readonly')) }}
                                    @if ($errors->has('contractperiod'))
                                        <span class="help-block"><strong>{{ $errors->first('contractperiod') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('purchaseorderno') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Purchase Order
                                    No</label>
                                <div class="col-sm-6">
                                    {{ Form::text('purchaseorderno', $editconract->purchaseorderno, array('class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('purchaseorderno'))
                                        <span class="help-block"><strong>{{ $errors->first('purchaseorderno') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row {{ $errors->has('purchaseorderdate') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Purchase Order
                                    Date</label>
                                <div class="col-sm-6">
                                    {{ Form::date('purchaseorderdate', $editconract->purchaseorderdate, array('id'=>'purchaseorderdateid','class' => 'form-control form-control-sm','max'=> '2050-12-31')) }}
                                    @if ($errors->has('purchaseorderdate'))
                                        <span class="help-block"><strong>{{ $errors->first('purchaseorderdate') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('amendmentno') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Amendment No</label>
                                <div class="col-sm-6">
                                    {{ Form::text('amendmentno', $editconract->amendmentno, array('class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('amendmentno'))
                                        <span class="help-block"><strong>{{ $errors->first('amendmentno') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('amendmentdescription') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Amendment
                                    Description</label>
                                <div class="col-sm-6">
                                    {{ Form::textarea('amendmentdescription',$editconract->amendmentdescription,['class'=>'form-control form-control-sm', 'rows' => 3, 'cols' => 40,'onKeyPress' => "if(this.value.length==500) return false;"]) }}
                                    @if ($errors->has('amendmentdescription'))
                                        <span class="help-block"><strong>{{ $errors->first('amendmentdescription') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('renewalperiod') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Renewal Period</label>
                                <div class="col-sm-6">
                                    {{ Form::text('renewalperiod', $editconract->renewalperiod, array('class' => 'form-control form-control-sm','id'=>'renewalperiodid','readonly')) }}
                                    @if ($errors->has('renewalperiod'))
                                        <span class="help-block"><strong>{{ $errors->first('renewalperiod') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('totalcost') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Total Cost</label>
                                <div class="col-sm-6">
                                    
                                    {{ Form::number('totalcost', $totalcost, array('id' => 'totalcost', 'class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('totalcost'))
                                        <span class="help-block"><strong>{{ $errors->first('totalcost') }}</strong></span>
                                    @endif
                                </div>
                            </div>


                            

<div class="row mt-1">
    <label class="col-sm-3 col-form-label text-muted">Project Owner Name</label>
    <div class="col-sm-6">
        {{ Form::text('projectownername', $editconract->projectownername, array('class' => 'form-control form-control-sm', 'id' => 'projectownernameid')) }}
    </div>
</div>

<div class="row mt-1">
    <label class="col-sm-3 col-form-label text-muted">Billing Owner Name</label>
    <div class="col-sm-6">
        {{ Form::text('billingownername', $editconract->billingownername, array('class' => 'form-control form-control-sm', 'id' => 'billingownernameid')) }}
    </div>
</div>





                            <div class="row {{ $errors->has('closerdate') ? ' has-error' : '' }} mt-1">
                                <label for="input" class="col-sm-3 col-form-label text-muted">Closure Date</label>
                                <div class="col-sm-6">
                                    {{ Form::date('closerdate', $editconract->closuredate, array('id'=>'closerdateid','class' => 'form-control form-control-sm','max'=> '2050-12-31')) }}
                                    {{--{{ Form::date('closerdate', $editconract->closerdate, array('class' => 'form-control form-control-sm', 'id'=>'closerdate')) }}--}}
                                    @if ($errors->has('closerdate'))
                                        <span class="help-block"><strong>{{ $errors->first('closerdate') }}</strong></span>
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
                                    {{ Form::submit('Save & Close', array('class' => 'btn btn-primary', 'id' => 'contractformbtn')) }}
                                    <a class="btn btn-primary" href="{{url()->previous()}}">Cancel</a>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>

                    </div>
                </div>






                <!-- NEW DOCUMENTS TAB - Add this after Contract tab -->
<div class="tab-pane fade" role="tabpanel" id="documents-tab" style="margin-left: 250px;">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Contract Documents</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    <i class="glyphicon glyphicon-info-sign"></i> 
                    Upload contract documents (PDF, JPG, JPEG, PNG). Max file size: 10MB each. Max 3 files.
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3 text-center">
                                        <input type="file" id="multi-files" multiple accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                        <button type="button" class="btn btn-primary" onclick="$('#multi-files').click();">
                                            <i class="glyphicon glyphicon-upload"></i> Select Files (Max 3)
                                        </button>
                                        <div id="upload-status" style="margin-top: 10px;"></div>
                                        <div class="progress" id="upload-progress" style="display:none; margin-top: 10px;">
                                            <div class="progress-bar progress-bar-success" role="progressbar" style="width: 0%">0%</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Uploaded Documents List -->
                                <div id="uploaded-docs" style="margin-top: 20px;">
                                    <table class="table table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th width="10%">#</th>
                                                <th>File Name</th>
                                                <th width="30%">Actions</th>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





                <div class="tab-pane fade" role="tabpanel" id="contract-site-master-tab"  aria-labelledby="contract-site-master" style="margin-left: 250px;">
                    <div class="container">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">New Contract Site Master</h3>
                            </div>
                            <div class="panel-body">
                                {{Form::open(array('action' => 'ContractController@addnewcontractsitemaster','method' => 'get', 'id' => 'contractsitemaster'))}}
                                {{ Form::hidden('customercode',$editconract->customercode, array('id' => 'contractsitecustomerid')) }}
                                {{ Form::hidden('contractnositcontactid', '', array('id' => 'contractnositcontactid')) }}
                                <div class="row{{ $errors->has('contractno') ? ' has-error' : '' }}">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Contract No.</label>
                                    <div class="col-sm-6">
                                        {{ Form::text('contractno',$editconract->contractno, array('class' => 'form-control form-control-sm contract','readonly','id'=>'contractnositid')) }}
                                        @if ($errors->has('contractno'))
                                            <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <br>
                                <input type="hidden" id="contractsitecontactmastercount" value="1">
                                @foreach($editcontractsitemaster as $contractsitemaster)
                                    {{ Form::hidden('contractsitemasterid[]', $contractsitemaster->branchcode),array('id'=>'contractsitemasterid', 'class'=>'contractsitemasterclass') }}
                                    <div class="panel col-md-12" style="border: silver 1px solid;">
                                        <div class="row{{ $errors->has('branchname') ? ' has-error' : '' }} mt-1"
                                             style="margin-top: 20px;">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Branch
                                                Name</label>
                                            <div class="col-sm-6">
                                                {{ Form::text('branchname[]',$contractsitemaster->branchname, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==12) return false;','readonly')) }}
                                                @if ($errors->has('branchname'))
                                                    <span class="help-block"><strong>{{ $errors->first('branchname') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('fax') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Fax</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('fax[]',$contractsitemaster->fax, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==11) return false;')) }}
                                                @if ($errors->has('fax'))
                                                    <span class="help-block"><strong>{{ $errors->first('fax') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('phone') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Phone</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('phone[]', $contractsitemaster->phone, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==11) return false;')) }}
                                                @if ($errors->has('phone'))
                                                    <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('email') ? ' has-error' : '' }} mt-1"
                                             style="margin-bottom: 20px;">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Email</label>
                                            <div class="col-sm-6">
                                                {{ Form::email('email[]', $contractsitemaster->email, array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('email'))
                                                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                                <br/>
                                <div id="addcontractsitemaster">
                                </div>
                                <input href="javascript:void(0);" type="image" src="{{asset('img/plus.jpg')}}"
                                       style="height: 20px; width: 20px;"
                                       onclick="addcontractsitemastersdiv(); return false;"></input>
                                <div class="row">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted"></label>
                                    <div class="col-sm-6">
                                        {{ Form::submit('Save & Close', array('class' => 'btn btn-primary', 'id' => 'branchform')) }}
                                        <a class="btn btn-primary" href="{{url()->previous()}}">Cancel</a>
                                    </div>
                                </div>
                                {{ Form::close() }}

                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" role="tabpanel" id="contract-site-contact-master-tab" aria-labelledby="contract-site-contact-master">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">New Contract Site Contact Master</h3>
                        </div>
                        <div class="container">
                            <div class="panel-body">
                                {{Form::open(array('action' => 'ContractController@updatecontractsitecontactmaster','method' => 'get', 'id' => 'contractsitecontactmasterid'))}}
                                {{ Form::hidden('contractdetailscontractid', '', array('id' => 'contractdetailscontractid')) }}
                                <div class="row{{ $errors->has('contractno') ? ' has-error' : '' }}">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Contract No.</label>
                                    <div class="col-sm-6">
                                        {{ Form::text('contractno', $editconract->contractno, array('class' => 'form-control form-control-sm contract','readonly','id'=>'contractnositcontactid')) }}
                                        @if ($errors->has('contractno'))
                                            <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                @foreach($editcontractsitecontactmaster as  $contractsitecontactmaster)
                                    {{ Form::hidden('contractsitecontactsaveid[]', $contractsitecontactmaster->branchcontactcode),array('class' => 'contractsitecontactsaveclassid') }}
                                    <div class="panel col-md-12" style="border: silver 1px solid;">

                                        <div class="row{{ $errors->has('branchcode') ? ' has-error' : '' }} mt-1" style="margin-top: 20px;">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name</label>
                                            <div class="col-sm-6">
                                                {{ Form::select('branchcode[]', $eqipmentbranch, $contractsitecontactmaster->branchcode, array('id'=>'contractbrachcontactmasterid','class'=>'contractbrachcontactmasterclass','placeholder' => 'select','required' => 'required')) }}
                                                @if ($errors->has('branchcode'))
                                                    <span class="help-block"><strong>{{ $errors->first('branchcode') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('contactpersonname') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Branch Person Name</label>
                                            <div class="col-sm-6">
                                                {{ Form::text('contactpersonname[]', $contractsitecontactmaster->contactpersonname, array('class' => 'form-control form-control-sm','required' => 'required','readonly')) }}
                                                @if ($errors->has('contactpersonname'))
                                                    <span class="help-block"><strong>{{ $errors->first('contactpersonname') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('fax') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Fax</label>
                                            <div class="col-sm-6">
                                                {{ Form::text('fax[]', $contractsitecontactmaster->fax, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==12) return false;')) }}
                                                @if ($errors->has('fax'))
                                                    <span class="help-block"><strong>{{ $errors->first('fax') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('phone') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Phone</label>
                                            <div class="col-sm-6">
                                                {{ Form::number('phone[]', $contractsitecontactmaster->phone, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==11) return false;')) }}
                                                @if ($errors->has('emailid'))
                                                    <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row{{ $errors->has('emailid') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Email</label>
                                            <div class="col-sm-6">
                                                {{ Form::email('emailid[]', $contractsitecontactmaster->emailid, array('class' => 'form-control form-control-sm')) }}
                                                @if ($errors->has('emailid'))
                                                    <span class="help-block"><strong>{{ $errors->first('emailid') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                @endforeach

                                <br/>

                                <input type="hidden" id="contractsitecontactmasterdivcount" value="1">
                                <div id="addcontractsitecontactmaster">
                                </div>
                                <input href="javascript:void(0);" type="image" src="{{asset('img/plus.jpg')}}"
                                       style="height: 20px; width: 20px;"
                                       onclick="addcontractsitcontactemastersdiv(); return false;"></input>
                                <div class="row">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted"></label>
                                    <div class="col-sm-6">
                                        {{ Form::submit('Save & Close', array('class' => 'btn btn-primary', 'id' => 'contactbranchform')) }}
                                        <a class="btn btn-primary" href="{{url()->previous()}}">Cancel</a>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" role="tabpanel" id="contract-details-tab" aria-labelledby="contract-detailsr">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Contract Details</h3>
                        </div>
                        <div class="container">
                            <div class="panel-body">
                                {{Form::open(array('action' => 'ContractController@addContractDetails','method' => 'get', 'id' => 'contractdetailsform'))}}
                                {{ Form::hidden('contractdetailscontractid', '', array('id' => 'contractdetailscontractid')) }}
                                <div class="row {{ $errors->has('contractno') ? ' has-error' : '' }} mt-2">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Contract No</label>
                                    <div class="col-sm-6">
                                        {{ Form::text('contractno', $editconract->contractno, array('class' => 'form-control form-control-sm contract','readonly','id'=>'contractdetailscontractid')) }}
                                        @if ($errors->has('contractno'))
                                            <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                @foreach($editcontractdetails as $key => $editcontract)
                                    {{ Form::hidden('contractdetailsaveid[]', $editcontract->id),array('id'=>'contractdetailsid', 'class' => 'contractdetailssaveidclass') }}
                                    {{ Form::hidden('eqipment[]', $editcontract->product->productservicecode) }}
                                    <div class="card col-md-12" style="border: silver 1px solid; margin-top: 25px;">
                                        <div class="row{{ $errors->has('productservice') ? ' has-error' : '' }} mt-1">
                                            <label for="input"
                                                   class="col-sm-4 col-form-label text-muted">Equipment</label>
                                            <div class="col-sm-4">
                                                {{ Form::text( 'eqipment0[]',$editcontract->product->productservicename, array('class'=>'form-control form-control-sm','readonly' )) }}
                                                @if ($errors->has('productservice'))
                                                    <span class="help-block"><strong>{{ $errors->first('productservice') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('quantity') ? ' has-error' : '' }} mt-1">
                                            <label for="input"
                                                   class="col-sm-4 col-form-label text-muted">Quantity (A)</label>
                                            <div class="col-sm-4">
                                                {{--{{ Form::text('quantity[]', $editcontract->quantity, array('required' => 'required','class' => 'form-control form-control-sm', 'id' => 'quantity', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totalcontractcostid"))')) }}--}}
                                                <input type="text" class="form-control" name="quantity[]"
                                                       value="{{$editcontract->quantity}}" id="quantityid_{{$key+1}}"
                                                       onkeyup="calculate({{$key+1}}); return false;">
                                                <span class="help-block"><strong>{{ $errors->first('quantity') }}</strong></span>
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('rate') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Rates
                                                (B)</label>
                                            <div class="col-sm-4">
                                                {{--{{ Form::text('rate[]', $editcontract->rate, array('required' => 'required','class' => 'form-control form-control-sm', 'id'=>'rate', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totalcontractcostid"))')) }}--}}
                                                <input type="text" class="form-control" name="rate[]"
                                                       value="{{$editcontract->rate}}" id="rateid_{{$key+1}}"
                                                       onkeyup="calculate({{$key+1}}); return false;">
                                                @if ($errors->has('rate'))
                                                    <span class="help-block"><strong>{{ $errors->first('rate') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('hsncode') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">HSN
                                                Code </label>
                                            <div class="col-sm-4">
                                                {{ Form::text('hsncode[]', $editcontract->hsncode, array('class' => 'form-control form-control-sm', 'id'=>'rate', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totalcontractcostid"))')) }}
                                                @if ($errors->has('hsncode'))
                                                    <span class="help-block"><strong>{{ $errors->first('hsncode') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('warranty_amc_period') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Warranty / AMC
                                                Period (C)</label>
                                            <div class="col-sm-4">
                                                {{--{{ Form::text('warranty_amc_period[]', $editcontract->warranty_amcperiod, array('required' => 'required','class' => 'form-control form-control-sm', 'id'=>'warranty_amc_period', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totalcontractcostid"))')) }}--}}
                                                <input type="text" class="form-control" name="warranty_amc_period[]"
                                                       value="{{$editcontract->warranty_amcperiod}}"
                                                       id="warrantyamcperiodid_{{$key+1}}"
                                                       onkeyup="calculate({{$key+1}}); return false;">
                                                @if ($errors->has('warranty_amc_period'))
                                                    <span class="help-block"><strong>{{ $errors->first('warranty_amc_period') }}</strong></span>
                                                @endif
                                            </div>
                                            <div class="col-sm-2">Months</div>
                                        </div>


                                        <div class="row{{ $errors->has('taxrate') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Tax
                                                Rate</label>
                                            <div class="col-sm-4">
                                                {{--{{ Form::text('taxrate[]', $editcontract->taxrate, array('required' => 'required','class' => 'form-control form-control-sm', 'id'=>'taxrate', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totalcontractcostid"))')) }}--}}
                                                <input type="text" class="form-control" name="taxrate[]"
                                                       value="{{$editcontract->taxrate}}" id="taxrateid_{{$key+1}}"
                                                       onkeyup="calculate({{$key+1}}); return false;">
                                                @if ($errors->has('taxrate'))
                                                    <span class="help-block"><strong>{{ $errors->first('taxrate') }}</strong></span>
                                                @endif
                                            </div>
                                            <div class="col-sm-2">%</div>
                                        </div>

                                        <div class="row{{ $errors->has('taxamt') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Tax
                                                Amt</label>
                                            <div class="col-sm-4">
                                                {{--{{ Form::text('taxamt[]', $editcontract->taxamt, array('readonly'=>true,'class' => 'form-control form-control-sm', 'id'=>'taxamt', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totalcontractcostid"))'))}}--}}
                                                <input type="text" class="form-control" name="taxamt[]"
                                                       value="{{$editcontract->taxamt}}" id="taxamtid_{{$key+1}}"
                                                       onkeyup="calculate({{$key+1}}); return false;" readonly>
                                                @if ($errors->has('taxamt'))
                                                    <span class="help-block"><strong>{{ $errors->first('taxamt') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('sgstrate') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">SGST
                                                Rate</label>
                                            <div class="col-sm-4">
                                                {{--{{ Form::text('sgstrate[]', $editcontract->sgstrate, array('required' => 'required','class' => 'form-control form-control-sm', 'id'=>'sgstrate', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totalcontractcostid"))')) }}--}}
                                                <input type="text" class="form-control" name="sgstrate[]"
                                                       value="{{$editcontract->sgstrate}}" id="sgstrateid_{{$key+1}}"
                                                       onkeyup="calculate({{$key+1}}); return false;">
                                                @if ($errors->has('sgstrate'))
                                                    <span class="help-block"><strong>{{ $errors->first('sgstrate') }}</strong></span>
                                                @endif
                                            </div>
                                            <div class="col-sm-2">%</div>
                                        </div>

                                        <div class="row{{ $errors->has('sgstamt') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">SGST
                                                Amt</label>
                                            <div class="col-sm-4">
                                                {{--{{ Form::text('sgstamt[]', $editcontract->sgstamt, array('readonly','class' => 'form-control form-control-sm', 'id'=>'sgstamt','onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totalcontractcostid"))')) }}--}}
                                                <input type="text" class="form-control" name="sgstamt[]"
                                                       value="{{$editcontract->sgstamt}}" id="sgstamtid_{{$key+1}}"
                                                       onkeyup="calculate({{$key+1}}); return false;" readonly>
                                                @if ($errors->has('sgstamt'))
                                                    <span class="help-block"><strong>{{ $errors->first('sgstamt') }}</strong></span>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="row{{ $errors->has('cgstrate') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">CGST
                                                Rate</label>
                                            <div class="col-sm-4">
                                                {{--{{ Form::text('cgstrate[]', $editcontract->cgstrate, array('required' => 'required','class' => 'form-control form-control-sm', 'id'=>'cgstrate','onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totalcontractcostid"))')) }}--}}
                                                <input type="text" class="form-control" name="cgstrate[]"
                                                       value="{{$editcontract->cgstrate}}" id="cgstrateid_{{$key+1}}"
                                                       onkeyup="calculate({{$key+1}}); return false;">
                                                @if ($errors->has('cgstrate'))
                                                    <span class="help-block"><strong>{{ $errors->first('cgstrate') }}</strong></span>
                                                @endif
                                            </div>
                                            <div class="col-sm-2">%</div>
                                        </div>

                                        <div class="row{{ $errors->has('cgstamt') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">CGST
                                                Amt</label>
                                            <div class="col-sm-4">
                                                {{--{{ Form::text('cgstamt[]', $editcontract->cgstamt, array('readonly'=>true,'class' => 'form-control form-control-sm', 'id'=>'cgstamt','onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totalcontractcostid"))')) }}--}}
                                                <input type="text" class="form-control" name="cgstamt[]"
                                                       value="{{$editcontract->cgstamt}}" id="cgstamtid_{{$key+1}}"
                                                       onkeyup="calculate({{$key+1}}); return false;" readonly>
                                                @if ($errors->has('cgstamt'))
                                                    <span class="help-block"><strong>{{ $errors->first('cgstamt') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('totaltax') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Total Tax
                                                (D)</label>
                                            <div class="col-sm-4">
                                                {{--{{ Form::text('totaltax[]', $editcontract->totaltax, array('class' => 'form-control form-control-sm', 'id'=>'grossrate', 'readonly')) }}--}}
                                                <input type="text" class="form-control" name="totaltax[]"
                                                       value="{{$editcontract->totaltax}}" id="totaltaxid_{{$key+1}}"
                                                       readonly>
                                                @if ($errors->has('totaltax'))
                                                    <span class="help-block"><strong>{{ $errors->first('totaltax') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row{{ $errors->has('totalcontractcost') ? ' has-error' : '' }} mt-1">
                                            <label for="input" class="col-sm-4 col-form-label text-muted">Total
                                                Cost</label>
                                            <div class="col-sm-4">
                                                {{--{{ Form::text('totalcontractcost[]', $editcontract->totalcontractcost, array('class' => 'form-control form-control-sm', 'id'=>'totalcontractcostid', 'readonly')) }}--}}
                                                <input type="text" class="form-control" name="totalcontractcost[]"
                                                       value="{{$editcontract->totalcontractcost}}"
                                                       id="totalcontractcostid_{{$key+1}}" readonly>
                                                @if ($errors->has('totalcontractcost'))
                                                    <span class="help-block"><strong>{{ $errors->first('totalcontractcost') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                                <input type="hidden" id="contractdetailsrowcount" value="1">
                                <div id="add">
                                </div>
                                <br/>
                                <input href="javascript:void(0);" type="image" src="{{asset('img/plus.jpg')}}"
                                       style="height: 20px; width: 20px; margin-top: 15px;"
                                       onclick="addequipmentdiv(); return false;"></input>

                                <div class="row">
                                    <label for="input" class="col-sm-4 col-form-label-sm text-muted"></label>
                                    <div class="col-sm-2">
                                        {{ Form::submit('Save & Close', array('class' => 'btn btn-primary','id' => 'contractdetailsformbtn')) }}
                                    </div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-primary" href="{{url()->previous()}}">Cancel</a>
                                    </div>
                                    <div class="col-sm-2"></div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" role="tabpanel" id="equipment-tab" aria-labelledby="equipment">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Add Equipment Details</h3>
                        </div>

                        <div class="panel-body">
                            {{--{{ Form::open(array('url' => 'equipment')) }}--}}
                            {{Form::open(array('action' => 'ContractController@addequipmentDetails','method' => 'Post', 'id' => 'equipmentDetailsform', 'role' =>'form'))}}

                            {{ Form::hidden('equipmentdetailsupdateid[]', $editconract->contractno, array('id' => 'equipmentdetailsupdateid')) }}
                            {{ Form::hidden('equipmentcustomercodeid', $editconract->customercode, array('id' => 'equipmentcustomercodeid')) }}
                            {{--{{ Form::hidden('contractequipmentid', '', array('id' => 'contractequipmentid')) }}--}}
                            <div class="row{{ $errors->has('contractno') ? ' has-error' : '' }}">
                                <label for="input" class="col-sm-4 col-form-label text-muted">Contract No.</label>
                                <div class="col-sm-6">
                                    {{ Form::text('contractno', $editconract->contractno, array('class' => 'form-control form-control-sm contract','readonly','id'=>'contractequipmentid')) }}
                                    @if ($errors->has('contractno'))
                                        <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('contracttype') ? ' has-error' : '' }}"
                                 style="padding-top:5px;">
                                <label for="input" class="col-sm-4 col-form-label text-muted">Contract Type</label>
                                <div class="col-sm-6">
                                    {{ Form::text('contracttype', $editconract->workordertype, array('class' => 'form-control form-control-sm contract','readonly','id'=>'contracttypeid','readonly')) }}
                                    @if ($errors->has('contracttype'))
                                        <span class="help-block"><strong>{{ $errors->first('contracttype') }}</strong></span>
                                    @endif
                                </div>
{{--                                Excel Buttuon--}}
{{--                                <div class="col-sm-2" style="padding-left:10px;">--}}
{{--                                    <a class="btn btn-blue" data-toggle="modal" data-target=".bs-example-modal-lg" onclick="excelDiv()" style="background-color: transparent; outline:none; border: none;"><i class="fa fa-file-excel-o" style='font-size:24px'></i></a>--}}
{{--                                </div>--}}
                            </div>
                            <div id="loading" style="alignment: center;padding-left: 650px;">
                            <img id="loading-image" src="{{asset('img/throbber.gif')}}" alt="Loading..." />
                            </div>
                            <div id="addRowExcelUpload" class="row col-md-12"  >
                                <div style="border: silver 1px solid;">
                                    <table class="table-bordered">
                                        <thead>
                                        <tr>
                                            <td width="5%" style="text-align: center"><b>Branch Name</b> </td>
                                            <td width="5%" style="text-align: center"><b>Product Name</b></td>
                                            <td width="5%" style="text-align: center"><b>Category Name</b></td>
                                            <td width="5%" style="text-align: center"><b>Equipment Sr No</b></td>
                                            <td width="5%" style="text-align: center"><b>Product Sr No</b></td>
                                            <td width="5%" style="text-align: center"><b>Specification</b></td>
                                        </tr>
                                        </thead>
                                        <tbody id="tableData">

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <input type="hidden" id="equipmentcount" value="1">
                            <div id="addrow">
                                <div style="border: silver 1px solid;">
                                    <div class="row col-lg-12">
                                        <div class="col-sm-2" style="width:250px;"><label>Branch Name</label></div>
                                        <div class="col-sm-2" style="width:200px;"><label>Product Name</label></div>
                                        <div class="col-sm-2" style="width:200px;"><label>Category Name</label></div>
                                        <div class="col-sm-2" style="width:250px;"><label>Equipment Sr No</label></div>
                                        <div class="col-sm-2" style="width:250px;"><label>Product Sr No</label></div>
                                        <div class="col-sm-2" style="width:175px;"><label>Specification</label></div>
                                        <div><label>Action</label></div>
                                    </div>
                                    @foreach($editcontractequipment as  $key => $equipment)
                                        {{--{{ Form::hidden('contractquipmentid[]', $equipment->equipmentsrno),array('id'=>'contractquipmentid', 'class' => 'equipmentsrnohdclassid') }}--}}
{{--                                        {{ Form::hidden('contractquipmentid[]', $equipment->equipmentsrno, array('class' => 'equipmentsrnohdclassid')) }}--}}
{{--                                        {{ Form::hidden('eqipmentproductservice[]', $equipment->products->productservicecode) }}--}}
{{--                                        {{ Form::hidden('eqipmentbranch[]', $equipment->branch->branchcode) }}--}}
{{--                                        {{ Form::hidden('categorycode[]', $equipment->category->categorycode )}}--}}

                                        <div class="row col-md-12" style="padding-bottom: 10px;">
                                            <div class="col-md-2"
                                                 style="width:200px;">{{ Form::text($eqipmentbranch, $equipment->branch->branchname, array('class'=>'form-control','required' => 'required','id' => 'branchequipementid','readonly')) }}</div>
                                            <div class="col-md-2"
                                                 style="width:200px;">{{ Form::text($eqipmentproductservice,$equipment->products->productservicename, array('class'=>' form-control','required' => 'required', 'id' => 'productid_0','onchange' => 'getcategory($i); return false;','readonly')) }}</div>
                                            <div class="col-md-2"
                                                 style="width:200px;"> {{ Form::text($eqipmentcategory,$equipment->category->categoryname, array('class'=>'form-control','required' => 'required', 'id' => 'categoryid_0','readonly')) }}</div>
                                            <div class="col-md-2"
                                                 style="width:250px;">{{ Form::text('equipmentsrno1[]', $equipment->equipmentsrno, array('class' => 'form-control equipmentsrnoclass','required' => 'required','readonly')) }}</div>
                                            <div class="col-md-2"
                                                 style="width:250px;">{{ Form::text('productsrno1[]', $equipment->productsrno, array('class' => 'form-control productsrnoclass','required' => 'required','readonly')) }}</div>
                                            <div class="col-md-2"
                                                 style="width:200px;"> {{ Form::text('specification1[]', $equipment->specification, array('class' => 'form-control','required' => 'required','readonly')) }}</div>
                                            <div class="col-md-2" style="width:15px;"><a href="#" data-value="{{$equipment->equipmentsrno}}" onclick="deletequipments(this); return false;"  id="deletequipmentsrnoid">delete</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div id="addrow">

                            </div>
                            <br>
                            <br>

                            <div class="row mt-12" style="padding-top: 65px;">
                                <div class="col-md-6"><input href="javascript:void(0);" type="image"
                                                             src="{{asset('img/plus.jpg')}}"
                                                             style="height: 20px; width: 20px;"
                                                             onclick="addequipmentwisediv(); return false;"></input>
                                </div>
                                <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                                <br>
                                <br>
                                <div class="row col-md-12" style="margin-left:600px; ">
                                    <div class="col-sm-8">
                                        {{ Form::submit('Add', array('id'=>'btnaddid','class' => 'btn btn-primary offset-1')) }}
                                        {{ Form::submit('Save & Close', array('id'=>'btnsavecloseid','class' => 'btn btn-primary offset-1')) }}
                                    </div>
                                </div>

                                <div class="col-sm-2"></div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
{{--                Excel Modal--}}
                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
                    <div class="modal-dialog" role="document">
                        {{ Form::open(array('method' => 'post','enctype'=>'multipart/form-data','files' => true,'url' => 'uploadexcelpost','id' => 'excelUploadFormId')) }}
                        {{ Form::hidden('customerupload',null, array('id' => 'customeruploadid')) }}
                        {{ Form::hidden('contractnoupload',null, array('id' => 'contractnouploadid')) }}
                        {{ Form::hidden('contracttypeupload',null, array('id' => 'contracttypeuploadid')) }}
                        {{ Form::hidden('workorderupload',null, array('id' => 'workorderuploadid')) }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="gridSystemModalLabel">Upload Excel File</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container offset-1">
                                    <div class="form-group" ><label for="inputEmail4">Branch Name</label>
                                        {{ Form::select('branchcodeupload',array('placeholder' => '---SELECT---'),null, array('class' => 'form-control form-control-md','required' => 'required','id' => 'branchcodeuploadid')) }}
                                    </div>
                                    <div class="form-group" ><label for="inputPassword4">Product Name</label>
                                        {{ Form::select('eqipmentproductserviceupload',array('placeholder' => '---SELECT---'),null, array('class' => 'form-control form-control-md','required' => 'required', 'id' => 'productiduploadid')) }}
                                    </div>
                                    <div class="form-group" ><label for="inputPassword4">Category Name</label>
                                        {{ Form::select('categorycodeupload',array('placeholder' => '---SELECT---'),null, array('class' => 'form-control form-control-md', 'required' => 'required','id' => 'categoryuploadid')) }}
                                    </div>
                                    <div class="form-group" ><label for="inputPassword4">Upload Excel File</label>
                                        {{ Form::file('file',array('class'=>'form-control form-control-sm uplaodfileclass','multiple'=>false, 'id' => 'file')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                {{ Form::submit('Upload', array('class' => 'btn btn-primary col-md-offset-9')) }}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
{{--                --   --}}
                



            <!-- EQUIPMENT UPLOAD TAB -->
<div class="tab-pane fade" role="tabpanel" id="equipment-upload-tab" style="margin-left: 250px;">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Equipment Document Upload</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    <i class="glyphicon glyphicon-info-sign"></i>
                    Upload equipment document (Excel, PDF, or Image). Max file size: 10MB.
                </div>

                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center">
                        <input type="file" id="equipment-file-input" accept=".pdf,.jpg,.jpeg,.png,.xls,.xlsx" style="display: none;">
                        <button type="button" class="btn btn-primary btn-lg" onclick="$('#equipment-file-input').click();">
                            <i class="glyphicon glyphicon-upload"></i> Select File (Excel / PDF / Image)
                        </button>
                        <div id="equipment-upload-status" style="margin-top: 15px;"></div>
                        <div class="progress" id="equipment-upload-progress" style="display:none; margin-top: 10px;">
                            <div class="progress-bar progress-bar-success" role="progressbar" style="width: 0%">0%</div>
                        </div>
                    </div>
                </div>

                <div id="equipment-uploaded-doc" style="margin-top: 25px;">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th>File Name</th>
                                <th width="35%">Actions</th>
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
                        {{ Form::text('contractnodisplay', $editconract->contractno, array('class' => 'form-control form-control-sm contract','readonly','id'=>'billingcontractdisplayid')) }}
                    </div>
                    <label class="col-sm-1 col-form-label text-muted">Total Amount</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="totalcontractamountdisplay" readonly>
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
                             <th width="6%">Cycle No</th>
                            <th width="10%">Estimated Billing Date</th>
                            <th width="10%">Actual Bill Date</th>
                            <th width="9%">Bill Number</th>
                            <th width="9%">Bill Amount</th>
                            <th width="10%">Next Payment Reminder</th>
                            <th width="10%">Bill Payment Date</th>
                            <th width="9%">Bill Received Amount</th>
                            <th width="9%">Difference</th>
                            <th width="9%">Running Total</th>
                            <th width="9%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="billingcyclesbody">
                        <!-- Rows are added dynamically via JS -->
                    </tbody>
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

                <button type="button" class="btn btn-primary btn-sm" id="addcyclebtn" onclick="addBillingCycleRow();">+ Add Payment Cycle</button>

                <br/><br/>
                <div class="row">
                    <label class="col-sm-3 col-form-label-sm text-muted"></label>
                    <div class="col-sm-6">
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
                {{Form::open(array('action' => 'ContractController@addPaymentDetails','method' => 'post', 'id' => 'paymentDetailsForm', 'files' => true))}}
                {{ Form::hidden('contractno', $editconract->contractno, array('id' => 'paymentdetailscontractid')) }}

                <h5 class="text-primary">Form Fees</h5>
                <div class="row mt-1">
                    <label class="col-sm-2 col-form-label text-muted">Amount</label>
                    <div class="col-sm-2">{{ Form::text('formfeesamount', null, array('class' => 'form-control form-control-sm')) }}</div>
                    <label class="col-sm-2 col-form-label text-muted">Exemption</label>
                    <div class="col-sm-2" style="padding-top:8px;">
                        {{ Form::radio('formfeesexemption', 'Y', false, array('id'=>'e_formfeesexemptionY')) }} <label for="e_formfeesexemptionY">Y</label>
                        &nbsp;&nbsp;
                        {{ Form::radio('formfeesexemption', 'N', false, array('id'=>'e_formfeesexemptionN')) }} <label for="e_formfeesexemptionN">N</label>
                    </div>
                    <label class="col-sm-2 col-form-label text-muted">Date Paid</label>
                    <div class="col-sm-2">{{ Form::date('formfeesdatepaid', null, array('class' => 'form-control form-control-sm','max'=>'2050-12-31')) }}</div>
                </div>

                <hr/>
                <h5 class="text-primary">EMD</h5>
                <div class="row mt-1">
                    <label class="col-sm-2 col-form-label text-muted">Amount</label>
                    <div class="col-sm-2">{{ Form::text('emdamount', null, array('class' => 'form-control form-control-sm')) }}</div>
                    <label class="col-sm-2 col-form-label text-muted">Exemption</label>
                    <div class="col-sm-2" style="padding-top:8px;">
                        {{ Form::radio('emdexemption', 'Y', false, array('id'=>'e_emdexemptionY')) }} <label for="e_emdexemptionY">Y</label>
                        &nbsp;&nbsp;
                        {{ Form::radio('emdexemption', 'N', false, array('id'=>'e_emdexemptionN')) }} <label for="e_emdexemptionN">N</label>
                    </div>
                    <label class="col-sm-2 col-form-label text-muted">Date Paid</label>
                    <div class="col-sm-2">{{ Form::date('emddatepaid', null, array('class' => 'form-control form-control-sm','max'=>'2050-12-31')) }}</div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-2 col-form-label text-muted">Estimated Return Date</label>
                    <div class="col-sm-2">{{ Form::date('emdestimatedreturndate', null, array('class' => 'form-control form-control-sm','max'=>'2050-12-31')) }}</div>
                    <label class="col-sm-2 col-form-label text-muted">Return Amount</label>
                    <div class="col-sm-2">{{ Form::text('emdreturnamount', null, array('class' => 'form-control form-control-sm')) }}</div>
                    <label class="col-sm-2 col-form-label text-muted">Return Date</label>
                    <div class="col-sm-2">{{ Form::date('emdreturndate', null, array('class' => 'form-control form-control-sm','max'=>'2050-12-31')) }}</div>
                </div>

                <hr/>
                <h5 class="text-primary">Security Deposit</h5>
                <div class="row mt-1">
                    <label class="col-sm-2 col-form-label text-muted">Amount</label>
                    <div class="col-sm-2">{{ Form::text('securitydepositamount', null, array('class' => 'form-control form-control-sm')) }}</div>
                    <label class="col-sm-2 col-form-label text-muted">Type</label>
                    <div class="col-sm-2">
                        {{ Form::select('securitydeposittype', ['' => '--','Bank Guarantee'=>'Bank Guarantee','EMD'=>'EMD','Deposit'=>'Deposit'], null, array('class' => 'form-control form-control-sm')) }}
                    </div>
                    <label class="col-sm-2 col-form-label text-muted">Date Paid</label>
                    <div class="col-sm-2">{{ Form::date('securitydepositdatepaid', null, array('class' => 'form-control form-control-sm','max'=>'2050-12-31')) }}</div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-2 col-form-label text-muted">Estimated Return Date</label>
                    <div class="col-sm-2">{{ Form::date('securitydepositestimatedreturndate', null, array('class' => 'form-control form-control-sm','max'=>'2050-12-31')) }}</div>
                    <label class="col-sm-2 col-form-label text-muted">Return Amount</label>
                    <div class="col-sm-2">{{ Form::text('securitydepositreturnamount', null, array('class' => 'form-control form-control-sm')) }}</div>
                    <label class="col-sm-2 col-form-label text-muted">Return Date</label>
                    <div class="col-sm-2">{{ Form::date('securitydepositreturndate', null, array('class' => 'form-control form-control-sm','max'=>'2050-12-31')) }}</div>
                </div>

                <hr/>
                <h5 class="text-primary">Admin Charges</h5>
                <div class="row mt-1">
                    <label class="col-sm-2 col-form-label text-muted">Amount</label>
                    <div class="col-sm-2">{{ Form::text('adminchargesamount', null, array('class' => 'form-control form-control-sm')) }}</div>
                    <label class="col-sm-2 col-form-label text-muted">Exemption</label>
                    <div class="col-sm-2" style="padding-top:8px;">
                        {{ Form::radio('adminchargesexemption', 'Y', false, array('id'=>'e_adminchargesexemptionY')) }} <label for="e_adminchargesexemptionY">Y</label>
                        &nbsp;&nbsp;
                        {{ Form::radio('adminchargesexemption', 'N', false, array('id'=>'e_adminchargesexemptionN')) }} <label for="e_adminchargesexemptionN">N</label>
                    </div>
                    <label class="col-sm-2 col-form-label text-muted">Date Paid</label>
                    <div class="col-sm-2">{{ Form::date('adminchargesdatepaid', null, array('class' => 'form-control form-control-sm','max'=>'2050-12-31')) }}</div>
                </div>

                <hr/>
                <h5 class="text-primary">Facility Charges</h5>
                <div class="row mt-1">
                    <label class="col-sm-2 col-form-label text-muted">Amount</label>
                    <div class="col-sm-2">{{ Form::text('facilitychargesamount', null, array('class' => 'form-control form-control-sm')) }}</div>
                    <label class="col-sm-2 col-form-label text-muted">Exemption</label>
                    <div class="col-sm-2" style="padding-top:8px;">
                        {{ Form::radio('facilitychargesexemption', 'Y', false, array('id'=>'e_facilitychargesexemptionY')) }} <label for="e_facilitychargesexemptionY">Y</label>
                        &nbsp;&nbsp;
                        {{ Form::radio('facilitychargesexemption', 'N', false, array('id'=>'e_facilitychargesexemptionN')) }} <label for="e_facilitychargesexemptionN">N</label>
                    </div>
                    <label class="col-sm-2 col-form-label text-muted">Date Paid</label>
                    <div class="col-sm-2">{{ Form::date('facilitychargesdatepaid', null, array('class' => 'form-control form-control-sm','max'=>'2050-12-31')) }}</div>
                </div>

                <hr/>
                <h5 class="text-primary">Legal Charges</h5>
                <div class="row mt-1">
                    <label class="col-sm-2 col-form-label text-muted">Amount</label>
                    <div class="col-sm-2">{{ Form::text('legalchargesamount', null, array('class' => 'form-control form-control-sm')) }}</div>
                    <label class="col-sm-2 col-form-label text-muted">Exemption</label>
                    <div class="col-sm-2" style="padding-top:8px;">
                        {{ Form::radio('legalchargesexemption', 'Y', false, array('id'=>'e_legalchargesexemptionY')) }} <label for="e_legalchargesexemptionY">Y</label>
                        &nbsp;&nbsp;
                        {{ Form::radio('legalchargesexemption', 'N', false, array('id'=>'e_legalchargesexemptionN')) }} <label for="e_legalchargesexemptionN">N</label>
                    </div>
                    <label class="col-sm-2 col-form-label text-muted">Date Paid</label>
                    <div class="col-sm-2">{{ Form::date('legalchargesdatepaid', null, array('class' => 'form-control form-control-sm','max'=>'2050-12-31')) }}</div>
                </div>

                <hr/>
                <h5 class="text-primary">Additional Security Deposit</h5>
                <div class="row mt-1">
                    <label class="col-sm-2 col-form-label text-muted">Amount</label>
                    <div class="col-sm-2">{{ Form::text('addnlsecuritydepositamount', null, array('class' => 'form-control form-control-sm')) }}</div>
                    <label class="col-sm-2 col-form-label text-muted">Exemption</label>
                    <div class="col-sm-2" style="padding-top:8px;">
                        {{ Form::radio('addnlsecuritydepositexemption', 'Y', false, array('id'=>'e_addnlsecuritydepositexemptionY')) }} <label for="e_addnlsecuritydepositexemptionY">Y</label>
                        &nbsp;&nbsp;
                        {{ Form::radio('addnlsecuritydepositexemption', 'N', false, array('id'=>'e_addnlsecuritydepositexemptionN')) }} <label for="e_addnlsecuritydepositexemptionN">N</label>
                    </div>
                    <label class="col-sm-2 col-form-label text-muted">Date Paid</label>
                    <div class="col-sm-2">{{ Form::date('addnlsecuritydepositdatepaid', null, array('class' => 'form-control form-control-sm','max'=>'2050-12-31')) }}</div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-2 col-form-label text-muted">Refund Date</label>
                    <div class="col-sm-2">{{ Form::date('addnlsecuritydepositrefunddate', null, array('class' => 'form-control form-control-sm','max'=>'2050-12-31')) }}</div>
                </div>

                <hr/>
                <h5 class="text-primary">Documents</h5>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Document 1 (e.g. Acceptance Letter)</label>
                    <div class="col-sm-6">
                        <input type="file" name="doc1" id="e_doc1id" class="form-control form-control-sm">
                        <div id="e_doc1existing"></div>
                    </div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Document 2</label>
                    <div class="col-sm-6">
                        <input type="file" name="doc2" id="e_doc2id" class="form-control form-control-sm">
                        <div id="e_doc2existing"></div>
                    </div>
                </div>
                <div class="row mt-1">
                    <label class="col-sm-3 col-form-label text-muted">Document 3</label>
                    <div class="col-sm-6">
                        <input type="file" name="doc3" id="e_doc3id" class="form-control form-control-sm">
                        <div id="e_doc3existing"></div>
                    </div>
                </div>

                <br/>
                <div class="row">
                    <label class="col-sm-3 col-form-label-sm text-muted"></label>
                    <div class="col-sm-6">
                        {{ Form::submit('Save & Close', array('class' => 'btn btn-primary','id' => 'paymentdetailssubmitbtn')) }}
                        <a class="btn btn-primary" href="{{url()->previous()}}">Cancel</a>
                    </div>
                </div>
                {{ Form::close() }}
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
                            {{Form::open(array('action' => 'ContractController@addPaymentTerms','method' => 'get','id'=>'paymentdetailstermsform'))}}
                            <div class="row {{ $errors->has('contractno') ? ' has-error' : '' }} mt-2">
                                <label for="input" class="col-sm-4 col-form-label text-muted">Contract No</label>
                                <div class="col-sm-4">
                                    {{ Form::text('contractno', $editconract->contractno, array('class' => 'form-control form-control-sm ','readonly','id'=>'paymentcontractno')) }}
                                    @if ($errors->has('contractno'))
                                        <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            {{ Form::hidden('workordertype', $editconract->workordertype),array('id'=>'workordertype', 'class' => 'contractdetailssaveidclass') }}
                            <div class="card col-md-12" style="border: silver 1px solid; margin-top: 25px;">

                                <div class="row{{ $errors->has('securitydeposit') ? ' has-error' : '' }} mt-1">
                                    <label for="input"
                                           class="col-sm-4 col-form-label text-muted">Security Deposit (SD)</label>
                                    <div class="col-sm-4">
                                        @if($paymentterms=="")
                                            {{ Form::number('securitydeposit',null, array('id'=>'securitydeposit','class' => 'form-control form-control-sm')) }}
                                        @else
                                            {{ Form::number('securitydeposit',$paymentterms->securitydeposit, array('id'=>'securitydeposit','class' => 'form-control form-control-sm')) }}
                                        @endif
                                        <span class="help-block"><strong>{{ $errors->first('securitydeposit') }}</strong></span>
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('sbpaymentperiod') ? ' has-error' : '' }} mt-1">
                                    <label for="input"
                                           class="col-sm-4 col-form-label text-muted">SD Payment Period (days)</label>
                                    <div class="col-sm-4">
                                        @if($paymentterms=="")
                                            {{ Form::number('sbpaymentperiod',null, array('class' => 'form-control form-control-sm')) }}
                                        @else
                                            {{ Form::number('sbpaymentperiod', $paymentterms->sbpaymentperiod, array('class' => 'form-control form-control-sm')) }}
                                        @endif
                                        <span class="help-block"><strong>{{ $errors->first('securitydeposit') }}</strong></span>
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('admincharges') ? ' has-error' : '' }} mt-1">
                                    <label for="input"
                                           class="col-sm-4 col-form-label text-muted">Admin Charges (BG)</label>
                                    <div class="col-sm-4">
                                        @if($paymentterms=="")
                                            {{ Form::number('admincharges',null, array('class' => 'form-control form-control-sm')) }}
                                        @else
                                            {{ Form::number('admincharges', $paymentterms->admincharges, array('class' => 'form-control form-control-sm')) }}
                                        @endif
                                        <span class="help-block"><strong>{{ $errors->first('admincharges') }}</strong></span>
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('facilitycharges') ? ' has-error' : '' }} mt-1">
                                    <label for="input"
                                           class="col-sm-4 col-form-label text-muted">Facility Charges</label>
                                    <div class="col-sm-4">
                                        @if($paymentterms=="")
                                            {{ Form::number('facilitycharges',null, array('class' => 'form-control form-control-sm')) }}
                                        @else
                                            {{ Form::number('facilitycharges', $paymentterms->facilitycharges, array('class' => 'form-control form-control-sm')) }}
                                        @endif
                                        <span class="help-block"><strong>{{ $errors->first('facilitycharges') }}</strong></span>
                                    </div>
                                </div>
                                @if($editconract->workordertype == 'Hardware Warranty' || $editconract->workordertype == 'Hardware AMC' || $editconract->workordertype == 'AMC' || $editconract->workordertype == 'Software development' || $editconract->workordertype == 'Warranty')
                                <div class="row{{ $errors->has('paymentintervalforamc') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Payment Interval For AMC </label>
                                    <div class="col-sm-4">
                                        @if($paymentterms=="" && $paymentintervalamc!= "")
                                            {{ Form::select('paymentintervalforamc',$paymentintervalamc,null, array('class'=>'form-control form-control-sm')) }}
                                        @else
                                            {{ Form::select('paymentintervalforamc',$paymentintervalamc,$paymentterms->paymentintervalforamc, array('class'=>'selectize ')) }}
                                        @endif
                                        @if ($errors->has('paymentintervalforamc'))
                                            <span class="help-block"><strong>{{ $errors->first('paymentintervalforamc') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                <div class="row{{ $errors->has('customeriniatedbilling') ? ' has-error' : '' }} mt-1">
                                    <label for="input"
                                           class="col-sm-4 col-form-label text-muted">Customer Initiated Billing </label>
                                    <div class="col-sm-4">
                                        @if($paymentterms=="")
                                            {{ Form::select('customeriniatedbilling',array('YES'=>'YES','NO'=>'NO'),null, array('class'=>'selectize')) }}
                                        @else
                                            {{ Form::select('customeriniatedbilling',array('YES'=>'YES','NO'=>'NO'),$paymentterms->customeriniatedbilling, array('class'=>'selectize')) }}
                                        @endif
                                        @if ($errors->has('customeriniatedbilling'))
                                            <span class="help-block"><strong>{{ $errors->first('customeriniatedbilling') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                {{--supply--}}
                                <div id="hiddensuppledivid">
                                    <div class="row{{ $errors->has('firstpaymentpercent') ? ' has-error' : '' }} mt-1">
                                        <label for="input"
                                               class="col-sm-4 col-form-label text-muted">First payment percent</label>
                                        <div class="col-sm-4">
                                            @if($paymentterms=="")
                                                {{ Form::number('firstpaymentpercent',null, array('class' => 'form-control form-control-sm')) }}
                                            @else
                                                {{ Form::number('firstpaymentpercent', $paymentterms->firstpaymentpercent, array('class' => 'form-control form-control-sm')) }}
                                            @endif
                                            <span class="help-block"><strong>{{ $errors->first('firstpaymentpercent') }}</strong></span>
                                        </div>
                                        <div class="col-sm-2">%</div>
                                    </div>

                                    <div class="row{{ $errors->has('firstpaymentcriteria') ? ' has-error' : '' }} mt-1">
                                        <label for="input"
                                               class="col-sm-4 col-form-label text-muted">First Payment
                                            Criteria </label>
                                        <div class="col-sm-4">
                                            @if($paymentterms=="")
                                                {{ Form::select('firstpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),null,array('placeholder'=>'--select--','class'=>'selectize')) }}
                                            @else
                                                {{ Form::select('firstpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),$paymentterms->firstpaymentcriteria, array('class' => 'selectize')) }}
                                            @endif
                                            @if ($errors->has('firstpaymentcriteria'))
                                                <span class="help-block"><strong>{{ $errors->first('firstpaymentcriteria') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('secondpaymentpercent') ? ' has-error' : '' }} mt-1">
                                        <label for="input"
                                               class="col-sm-4 col-form-label text-muted">Second Payment Percent</label>
                                        <div class="col-sm-4">
                                            @if($paymentterms=="")
                                                {{ Form::number('secondpaymentpercent',null, array('class' => 'form-control form-control-sm')) }}
                                            @else
                                                {{ Form::number('secondpaymentpercent', $paymentterms->secondpaymentpercent, array('class' => 'form-control form-control-sm')) }}
                                            @endif
                                            <span class="help-block"><strong>{{ $errors->first('secondpaymentpercent') }}</strong></span>
                                        </div>
                                        <div class="col-sm-2">%</div>
                                    </div>
                                    <div class="row{{ $errors->has('secondpaymentcriteria') ? ' has-error' : '' }} mt-1">
                                        <label for="input"
                                               class="col-sm-4 col-form-label text-muted">Second Payment
                                            Criteria </label>
                                        <div class="col-sm-4">
                                            @if($paymentterms=="")
                                                {{ Form::select('secondpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),null,array('placeholder'=>'--select--','class'=>'selectize')) }}
                                            @else
                                                {{ Form::select('secondpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),$paymentterms->secondpaymentcriteria, array('class' => 'selectize')) }}
                                            @endif
                                            @if ($errors->has('secondpaymentcriteria'))
                                                <span class="help-block"><strong>{{ $errors->first('secondpaymentcriteria') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('thirdpaymentpercent') ? ' has-error' : '' }} mt-1">
                                        <label for="input"
                                               class="col-sm-4 col-form-label text-muted">Third Payment Percent</label>
                                        <div class="col-sm-4">
                                            @if($paymentterms=="")
                                                {{ Form::number('thirdpaymentpercent',null, array('class' => 'form-control form-control-sm')) }}
                                            @else
                                                {{ Form::number('thirdpaymentpercent', $paymentterms->thirdpaymentpercent, array('class' => 'form-control form-control-sm')) }}
                                            @endif
                                            <span class="help-block"><strong>{{ $errors->first('thirdpaymentpercent') }}</strong></span>
                                        </div>
                                        <div class="col-sm-2">%</div>
                                    </div>

                                    <div class="row{{ $errors->has('thirdpaymentcriteria') ? ' has-error' : '' }} mt-1">
                                        <label for="input"
                                               class="col-sm-4 col-form-label text-muted">Third Payment Criteria</label>
                                        <div class="col-sm-4">
                                            @if($paymentterms=="")
                                                {{ Form::select('thirdpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),null,array('placeholder'=>'--select--','class'=>'selectize')) }}
                                            @else
                                                {{ Form::select('thirdpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),$paymentterms->thirdpaymentcriteria, array('class' => 'selectize')) }}
                                            @endif
                                            @if ($errors->has('thirdpaymentcriteria'))
                                                <span class="help-block"><strong>{{ $errors->first('thirdpaymentcriteria') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('fourthpaymentpercent') ? ' has-error' : '' }} mt-1">
                                        <label for="input"
                                               class="col-sm-4 col-form-label text-muted">Fourth Payment Percent</label>
                                        <div class="col-sm-4">
                                            @if($paymentterms=="")
                                                {{ Form::number('fourthpaymentpercent',null, array('class' => 'form-control form-control-sm')) }}
                                            @else
                                                {{ Form::number('fourthpaymentpercent', $paymentterms->fourthpaymentpercent, array('class' => 'form-control form-control-sm')) }}
                                            @endif
                                            <span class="help-block"><strong>{{ $errors->first('fourthpaymentpercent') }}</strong></span>
                                        </div>
                                        <div class="col-sm-2">%</div>
                                    </div>

                                    <div class="row{{ $errors->has('fourthpaymentcriteria') ? ' has-error' : '' }} mt-1">
                                        <label for="input"
                                               class="col-sm-4 col-form-label text-muted">Fourth Payment
                                            Criteria</label>
                                        <div class="col-sm-4">
                                            @if($paymentterms=="")
                                                {{ Form::select('fourthpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),null,array('placeholder'=>'--select--','class'=>'selectize')) }}
                                            @else
                                                {{ Form::select('fourthpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),$paymentterms->fourthpaymentcriteria, array('class' => 'selectize')) }}
                                            @endif
                                            @if ($errors->has('fourthpaymentcriteria'))
                                                <span class="help-block"><strong>{{ $errors->first('fourthpaymentcriteria') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('fifthpaymentpercent') ? ' has-error' : '' }} mt-1">
                                        <label for="input"
                                               class="col-sm-4 col-form-label text-muted">Fith Payment Percent</label>
                                        <div class="col-sm-4">
                                            @if($paymentterms=="")
                                                {{ Form::number('fifthpaymentpercent',null, array('class' => 'form-control form-control-sm')) }}
                                            @else
                                                {{ Form::number('fifthpaymentpercent', $paymentterms->fifthpaymentpercent, array('class' => 'form-control form-control-sm')) }}
                                            @endif
                                            @if ($errors->has('fifthpaymentpercent'))
                                                <span class="help-block"><strong>{{ $errors->first('fifthpaymentpercent') }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="col-sm-2">%</div>
                                    </div>

                                    <div class="row{{ $errors->has('fifthpaymentcriteria') ? ' has-error' : '' }} mt-1">
                                        <label for="input"
                                               class="col-sm-4 col-form-label text-muted">Fith Payment Criteria</label>
                                        <div class="col-sm-4">
                                            @if($paymentterms=="")
                                                {{ Form::select('fifthpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),null,array('placeholder'=>'--select--','class'=>'selectize')) }}
                                            @else
                                                {{ Form::select('fifthpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),$paymentterms->fifthpaymentcriteria, array('class' => 'selectize')) }}
                                            @endif
                                            @if ($errors->has('fifthpaymentcriteria'))
                                                <span class="help-block"><strong>{{ $errors->first('fifthpaymentcriteria') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('leaddaysforpayment') ? ' has-error' : '' }} mt-1">
                                    <label for="input"
                                           class="col-sm-4 col-form-label text-muted">Lead Days For Payment</label>
                                    <div class="col-sm-4">
                                        @if($paymentterms=="")
                                            {{ Form::number('leaddaysforpayment',null, array('class' => 'form-control form-control-sm')) }}
                                        @else
                                            {{ Form::number('leaddaysforpayment', $paymentterms->leaddaysforpayment, array('class' => 'form-control form-control-sm')) }}
                                        @endif
                                        <span class="help-block"><strong>{{ $errors->first('leaddaysforpayment') }}</strong></span>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <br/>

                            <div class="row">
                                <label for="input" class="col-sm-4 col-form-label-sm text-muted"></label>
                                <div class="col-sm-2">
                                    {{ Form::submit('Save & Close', array('class' => 'btn btn-primary', 'id' => 'paymentbtn' )) }}
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-primary" href="{{url()->previous()}}">Cancel</a>
                                </div>
                                <div class="col-sm-2"></div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('page-script')
    <script src="{{asset('custom-scripts/customdatavalidation.js')}}"></script>

<script type="text/javascript">
function updatePaymentDocDisplay(docField, filePath, contractno, targetSelector) {
    if (!filePath) {
        $(targetSelector).empty();
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

    var html = '<small>' + fileIcon +
        '<a href="' + viewUrl + '" target="_blank">' + shortName + '</a> ' +
        '<a href="' + downloadUrl + '" class="btn btn-success btn-xs" title="Download">' +
        '<i class="glyphicon glyphicon-download-alt"></i></a> ' +
        '<button type="button" class="btn btn-danger btn-xs" onclick="deletePaymentDocument(\'' + docField + '\', \'' + contractno + '\', \'' + targetSelector + '\')" title="Delete">' +
        '<i class="glyphicon glyphicon-trash"></i></button></small>';

    $(targetSelector).html(html);
}

function deletePaymentDocument(docField, contractno, targetSelector) {
    if (!confirm('Are you sure you want to remove this document?')) return;

    $.ajax({
        url: '{{ url("delete-payment-document") }}',
        type: 'POST',
        data: {
            contractno: contractno,
            doc_field: docField,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                $(targetSelector).empty();
            } else {
                alert('Failed to remove document: ' + response.message);
            }
        },
        error: function() {
            alert('Error removing document');
        }
    });
}
</script>

    <script type="text/javascript">
function loadPaymentDetailsEdit(contractno) {
    $.ajax({
        url: '{{ url("getpaymentdetails") }}/' + contractno,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.paymentdetails) {
                var pd = data.paymentdetails;
                $('#paymentDetailsForm [name="formfeesamount"]').val(pd.formfeesamount);
                $('#paymentDetailsForm input[name="formfeesexemption"][value="' + pd.formfeesexemption + '"]').prop('checked', true);
                $('#paymentDetailsForm [name="formfeesdatepaid"]').val(pd.formfeesdatepaid);

                $('#paymentDetailsForm [name="emdamount"]').val(pd.emdamount);
                $('#paymentDetailsForm input[name="emdexemption"][value="' + pd.emdexemption + '"]').prop('checked', true);
                $('#paymentDetailsForm [name="emddatepaid"]').val(pd.emddatepaid);
                $('#paymentDetailsForm [name="emdestimatedreturndate"]').val(pd.emdestimatedreturndate);
                $('#paymentDetailsForm [name="emdreturnamount"]').val(pd.emdreturnamount);
                $('#paymentDetailsForm [name="emdreturndate"]').val(pd.emdreturndate);

                $('#paymentDetailsForm [name="securitydepositamount"]').val(pd.securitydepositamount);
                $('#paymentDetailsForm [name="securitydeposittype"]').val(pd.securitydeposittype);
                $('#paymentDetailsForm [name="securitydepositdatepaid"]').val(pd.securitydepositdatepaid);
                $('#paymentDetailsForm [name="securitydepositestimatedreturndate"]').val(pd.securitydepositestimatedreturndate);
                $('#paymentDetailsForm [name="securitydepositreturnamount"]').val(pd.securitydepositreturnamount);
                $('#paymentDetailsForm [name="securitydepositreturndate"]').val(pd.securitydepositreturndate);

                $('#paymentDetailsForm [name="adminchargesamount"]').val(pd.adminchargesamount);
                $('#paymentDetailsForm input[name="adminchargesexemption"][value="' + pd.adminchargesexemption + '"]').prop('checked', true);
                $('#paymentDetailsForm [name="adminchargesdatepaid"]').val(pd.adminchargesdatepaid);

                $('#paymentDetailsForm [name="facilitychargesamount"]').val(pd.facilitychargesamount);
                $('#paymentDetailsForm input[name="facilitychargesexemption"][value="' + pd.facilitychargesexemption + '"]').prop('checked', true);
                $('#paymentDetailsForm [name="facilitychargesdatepaid"]').val(pd.facilitychargesdatepaid);

                $('#paymentDetailsForm [name="legalchargesamount"]').val(pd.legalchargesamount);
                $('#paymentDetailsForm input[name="legalchargesexemption"][value="' + pd.legalchargesexemption + '"]').prop('checked', true);
                $('#paymentDetailsForm [name="legalchargesdatepaid"]').val(pd.legalchargesdatepaid);

                $('#paymentDetailsForm [name="addnlsecuritydepositamount"]').val(pd.addnlsecuritydepositamount);
                $('#paymentDetailsForm input[name="addnlsecuritydepositexemption"][value="' + pd.addnlsecuritydepositexemption + '"]').prop('checked', true);
                $('#paymentDetailsForm [name="addnlsecuritydepositdatepaid"]').val(pd.addnlsecuritydepositdatepaid);
                $('#paymentDetailsForm [name="addnlsecuritydepositrefunddate"]').val(pd.addnlsecuritydepositrefunddate);
            }

            $('#e_doc1existing').empty();
            $('#e_doc2existing').empty();
            $('#e_doc3existing').empty();

            if (data.document) {
                var doc = data.document;
                updatePaymentDocDisplay('doc1', doc.doc1, contractno, '#e_doc1existing');
                updatePaymentDocDisplay('doc2', doc.doc2, contractno, '#e_doc2existing');
                updatePaymentDocDisplay('doc3', doc.doc3, contractno, '#e_doc3existing');
            }
        }
    });
}

$(document).ready(function () {
    var pdContractNo = $('#paymentdetailscontractid').val();

    $('#payment-details').click(function () {
        if (pdContractNo && pdContractNo != '0' && pdContractNo != '') {
            loadPaymentDetailsEdit(pdContractNo);
        }
    });

    // preload since contract already exists on edit screen
    if (pdContractNo && pdContractNo != '0' && pdContractNo != '') {
        loadPaymentDetailsEdit(pdContractNo);
    }

    $("#paymentDetailsForm").submit(function (e) {
        e.preventDefault();
        $("#paymentdetailssubmitbtn").attr("disabled", true);

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "{{URL::to('addpaymentdetails')}}",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (data) {
                $("#paymentdetailssubmitbtn").attr("disabled", false);
                if (data.error) {
                    alert(data.error);
                } else if (data.exception) {
                    alert(data.exception);
                } else {
                    $('#paymentterms').click();
                }
            },
            error: function () {
                $("#paymentdetailssubmitbtn").attr("disabled", false);
                alert('Something went wrong. Try Again.');
            }
        });
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
        '<td><input type="date" name="nextreminderdate[]" class="form-control form-control-sm next-reminder-date" max="2050-12-31"></td>' +
        '<td><input type="date" name="billpaymentdate[]" class="form-control form-control-sm bill-payment-date" max="2050-12-31"></td>' +
        '<td><input type="text" name="billpaidamount[]" class="form-control form-control-sm bill-paid-amount" onkeyup="validateBillTotal(); calculateDifference(this);"></td>' +
        '<td class="row-difference">0.00</td>' +
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
    var diff = billAmt - paidAmt;
    row.find('.row-difference').text(diff.toFixed(2));
}

function removeBillingCycleRow(el) {
    $(el).closest('tr').remove();
    renumberBillingRows();
    validateBillTotal();
}

function renumberBillingRows() {
    $('#billingcyclesbody .billing-cycle-row').each(function (index) {
        $(this).find('.cycle-no').text(index + 1);
    });
}

function populateTotalContractAmount() {
    var totalCost = $('#totalcost').val() || $('input[name="totalcost"]').val() || 0;
    $('#totalcontractamountdisplay').val(parseFloat(totalCost).toFixed(2));
    validateBillTotal();
}

function validateBillTotal() {
    var totalContractAmount = parseFloat($('#totalcontractamountdisplay').val()) || 0;
    var totalPaid = 0;

    $('.billing-cycle-row').each(function () {
        var paidVal = parseFloat($(this).find('.bill-paid-amount').val()) || 0;
        totalPaid += paidVal;
        $(this).find('.row-running-total').text(totalPaid.toFixed(2));
    });

    $('#totalpaidamount').text(totalPaid.toFixed(2));
    $('#totalpaidsofardisplay').val(totalPaid.toFixed(2));

    var remaining = totalContractAmount - totalPaid;
    $('#totalremainingdisplay').val(remaining.toFixed(2));

    if (totalContractAmount > 0 && remaining <= 0) {
        $('#billingmatchstatus').removeClass('label-warning label-danger')
            .addClass('label-success')
            .text(remaining === 0 ? 'Fully Paid ✓' : 'Overpaid by ' + Math.abs(remaining).toFixed(2));
    } else {
        $('#billingmatchstatus').removeClass('label-success label-danger')
            .addClass('label-warning')
            .text('Remaining: ' + remaining.toFixed(2));
    }
}

function loadBillingDetails(contractno) {
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
                        '<td><input type="date" name="nextreminderdate[]" class="form-control form-control-sm next-reminder-date" value="' + (cycle.nextreminderdate || '') + '" max="2050-12-31"></td>' +
                        '<td><input type="date" name="billpaymentdate[]" class="form-control form-control-sm bill-payment-date" value="' + (cycle.billpaymentdate || '') + '" max="2050-12-31"></td>' +
                        '<td><input type="text" name="billpaidamount[]" class="form-control form-control-sm bill-paid-amount" value="' + (cycle.billpaidamount || '') + '" onkeyup="validateBillTotal(); calculateDifference(this);"></td>' +
                        '<td class="row-difference">' + diff + '</td>' +
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
    $('#billing-details').click(function () {
        var contractno = $('#contractsavedid').val();
        if (contractno && contractno != '0') {
            populateTotalContractAmount();
            loadBillingDetails(contractno);
        }
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
                } else if (data.exception) {
                    alert('Try Again!!!!');
                } else {
                    $('#payment-details').click();
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

        $(document).ready(function () {
            $('#loading').hide();
            $('#tenderno').selectize({
                delimiter: ',',
                persist: false,
                create: function(input) {
                    return {
                        value: input,
                        text: input
                    }
                }
            });
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

            // $('#tenderno').selectize({
            //     maxItems: 1
            // });

            $('#workordertype').selectize({
                maxItems: 1
            });

            $('#customers').selectize({
                maxItems: 1
            });

            $('#customersite').selectize({
                maxItems: 1
            });
            $('#equipmentbranchcode').selectize({
                maxItems: 1
            });
            $('#equipmentcustomers').selectize({
                maxItems: 1
            });
            $('#productid').selectize({
                maxItems: 1
            });
            $('#categoryid').selectize({
                maxItems: 1
            });
            $('#workordernoid').selectize({
                maxItems: 1
            });

            $('#servicefrequencyid').selectize({
                maxItems: 1
            });

            $('#contractsitecustomercode').selectize({
                maxItems: 1
            });
            $('#contractsiteid').selectize({
                maxItems: 1
            });

            $('#branchid').selectize({
                maxItems: 1
            });
            $('#contractsitecontactbranchnameid').selectize({
                maxItems: 1
            });
//            $('#contractbrachcontactmasterid').selectize({
//                maxItems: 1
//            });
            $('#comprehensiveid').selectize({
                maxItems: 1
            });

            $('#workordertypeid').selectize({
                maxItems: 1
            });

            $('.selectize').selectize({
//                maxItems: 1
                create: false
            });
            if($('#hdcompresinvetypeid').val() == "Hardware AMC" || $('#hdcompresinvetypeid').val() == "Hardware Warranty" || $('#hdcompresinvetypeid').val() == "AMC" || $('#hdcompresinvetypeid').val() == "Warranty" || $('#hdcompresinvetypeid').val() == "Software development")
            {
                $('#servicedivid').show();
            }
            else{
                $('#servicedivid').hide();
            }
            $(".contractbrachcontactmasterclass").selectize();
            $(".eqipmentbranchclass").selectize();
            $(".eqipmentbranchclassid").selectize();
            $(".eqipmentproductserviceclass").selectize();

            $('#contract').click(function(event){
                $("#contractformbtn").attr("disabled",false);
            });
            $('#contract-site-master').click(function (event) {
                $("#branchform").attr("disabled", false);
                if (!checkifcontractnoisavailable())
                    return false;
            });
            $('#contract-site-contact-master').click(function (event) {
                $("#contactbranchform").attr("disabled",false);
                if (!checkifcontractsiteissaved())
                    return false;
            });
            $('#contract-details').click(function (event) {
                $("#contractdetailsformbtn").attr("disabled",false);
                if (!checkifcontractsiteissaved())
                    return false;
            });
            $('#equipment').click(function (event) {
                $("#btnsavecloseid").attr("disabled",false);
                if (!checkifcontractequipmentissaved())
                    return false;
            });
            $('#paymentterms').click(function (event) {
                $("#paymentbtn").attr("disabled",false);
                if (!checkifcontractequipmentissaved())
                    return false;
            });


            function checkifcontractnoisavailable() {
                $contractno = document.getElementById('contractnositid');
                if ($contractno.value == "") {
                    event.preventDefault();
                    alert("Contract No not available!");
                    return false;
                }
                return true;
            }

            function checkifcontractsiteissaved() {
                $contractno = document.getElementById('contractnositcontactid');
                if ($contractno.value == "") {
                    event.preventDefault();
                    alert("Contract No not available!");
                    return false;
                }
                return true;
            }

            function checkifcontractdetailssaved() {
                $contractdetailssaved = document.getElementById('contractdetailscontractid');
                if ($contractdetailssaved.value == "") {
                    event.preventDefault();
                    alert("Contract No not available!");
                    return false;
                }
                return true;
            }

            function checkifcontractequipmentissaved() {
                $contractno = document.getElementById('contractequipmentid');
                if ($contractno.value == "") {
                    event.preventDefault();
                    alert("Contract No not available!");
                    return false;
                }
                return true;
            }


            $("#amcdiv").hide();
            $("#salesdiv").hide();
            $("#addRowExcelUpload").hide();

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

                            $('#customersite')[0].selectize.destroy();
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
                        url: '{{ URL::to('workorders') }}/' + $('#customers').val(),
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
            $("#equipmentcustomers").change(function () {

                var branchlist = [];
                if ($('#equipmentcustomers').val() != "") {
                    $.ajax({
                        url: '{{ URL::to('registration/branch') }}/' + $('#equipmentcustomers').val(),
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

                            $('#equipmentbranchcode').selectize()[0].selectize.destroy();
                            if (branchlist.length > 0) {
                                $('#equipmentbranchcode').selectize({
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
                                $('#equipmentbranchcode').selectize({
                                    options: null
                                });
                            }
                        }
                    });

                    var workorderlist = [];
                    $.ajax({
                        url: '{{ URL::to('workorders') }}/' + $('#customers').val(),
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
            $("#equipmentcustomers").change(function () {
                var branchlist = [];
                if ($('#equipmentcustomers').val() != "") {
                    $.ajax({
                        url: '{{ URL::to('registration/branch') }}/' + $('#equipmentcustomers').val(),
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

                            $('#equipmentbranchcode')[0].selectize.destroy();
                            if (branchlist.length > 0) {
                                $('#equipmentbranchcode').selectize({
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
                                $('#equipmentbranchcode').selectize({
                                    options: null
                                });
                            }
                        }
                    });

                    var workorderlist = [];
                    $.ajax({
                        url: '{{ URL::to('workorders') }}/' + $('#customers').val(),
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $.each(data, function (key, value) {
                                workorderlist.push({
                                    text: value['workorderno'],
                                    value: value['workorderno'],
                                })
                            });

                            $('#workorderno')[0].selectize.destroy();

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

                    $('#customersite')[0].selectize.destroy();
                    $('#customersite').selectize({
                        options: null
                    });
                }
            });

        });
        function getcategory(id) {
            var mainid = id;
            var test = $('#productid_' + mainid).val();
            var categorylist = [];
            if (test != "") {
                $.ajax({
                    url: '{{ url('/registration/category') }}/' + test,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            categorylist.push({
                                text: value['categoryname'],
                                value: value['categorycode'],
                            })
                        });
                        $('#categoryid_' + mainid).selectize()[0].selectize.destroy();
                        $('#categoryid_' + mainid).selectize({
                            maxItems: 1,
                            valueField: 'value',
                            labelField: 'text',
                            searchField: 'text',
                            create: false,
                            sortField: {
                                field: 'text',
                                direction: 'asc'
                            },
                            options: categorylist,
                        });
                    }
                });
            }
            else {

                $('#categoryid_').selectize()[0].selectize.destroy();
                $('#categoryid_').selectize({
                    options: null
                });
            }
        }
        function populateContractNo(contractno) {
            $abc = document.getElementsByClassName('contract');
            $.each($abc, function (contract, value) {
                var abc = value;
                abc.value = contractno;
            });
        }
        function calculategross(quantity, rate, period, sgstrate, sgstamt, cstrate, cgstamt, taxrate, taxamt, grossrate, totaltaxamt, totalcontractcost, count) {
            if (quantity != "") {
                var calculatedtax = rate * taxrate / 100;
                var rateplustax = parseFloat(rate) + parseFloat(calculatedtax);
                var tax = rate * taxrate / 100;
                tax = tax.toFixed(2);
                var calsgstamt = rate * sgstrate / 100;
                var calcgstamt = rate * cstrate / 100;
                var totaltax = parseFloat(calsgstamt) + parseFloat(calcgstamt) + parseFloat(tax);
                totaltax = totaltax.toFixed(2);
                var calgrossrate = parseFloat(rate) + parseFloat(totaltax);
                var test = parseFloat(quantity) * calgrossrate;
                var year = period / 12;
                var caltotalcost = test * year;
                caltotalcost = caltotalcost.toFixed(2);
                if (taxrate != 0) {
                    grossrate.val(totaltax);
                }
                else {
                    grossrate.val(totaltax);
                }
                taxamt.val(tax);
                sgstamt.val(calsgstamt);
                cgstamt.val(calcgstamt);
                totaltaxamt.val(caltotalcost);
                // totalcontractcost.val(test);

            }
            else {
                grossrate.val('0');
                taxamt.val('0');
                sgstamt.val('0');
                cgstamt.val('0');
                totaltaxamt.val('0');
                // grossrate.val('0');
                // taxamt.val('0');
                // sgstamt.val('0');
                // cgstamt.val('0');
                // totaltaxamt.val('0');
                // //totalcontractcost.val('0');
                // taxrate.val('0');
                // sgstrate.val('0');

            }
            if (taxrate == "") {
                $("#sgstrate").val("0");
                $("#cgstrate").val("0");
                $("#taxrate").val("0");
            }

            if (taxrate + count == "") {
                $("#sgstrate" + count).val("0");
                $("#cgstrate" + count).val("0");
                $("#taxrate" + count).val("0");

            }
        }
        function addequipmentwisediv() {
            var wrapper = $('#addrow');
            var addButton = $('#addequipmentwisediv');
            var count = $('#equipmentcount').val();
            var id = $('#equipmentcount').val();
            $('#productcount').val(count);
            var appendtagsequipement = '<div><a  href="javascript:void(0);" class="remove_button" title="Remove field"><img src="{{asset('img/cancel-512.png')}}" style="height: 20px; width: 20px; margin-left:910px;"/></a><div style="border: silver 1px solid;" class="form-row">' +
                '{{ Form::hidden('contractquipmentid[]','0', array('class'=>'equipmentsrnohdclassid')) }}'+
                '<div class="form-group col-md-2"><label for="inputEmail4">Branch Name</label>{{ Form::select('eqipmentbranch[]',$eqipmentbranch,null, array('class'=>'contracteqipmentbranch','placeholder' => 'select','required' => 'required','id' => 'branchcodeid_%count%')) }}</div>'.replace('%count%', count) +
                '<div class="form-group col-md-2"><label for="inputEmail4">Product Name</label>{{ Form::select('eqipmentproductservice[]',$eqipmentproductservice,null, array('class'=>'eqipmentproductserviceclass','placeholder' => '---SELECT---','required' => 'required','id' => 'productid_%count%','onchange' => 'getcategory(%id%); return false;')) }}</div>'.replace('%count%', count).replace('%id%', id) +
                '<div class="form-group col-md-2"><label for="inputtext">Category Name</label>{{ Form::select('categorycode[]',array('placeholder' => '---SELECT---'),null, array('class'=>'categoryclassid','required' => 'required', 'id' => 'categoryid_%id%')) }}</div>'.replace('%id%', id) +
                '<div class="form-group col-md-2" style="height:10px;" ><label for="inputPassword4">Equipment Sr No</label>{{ Form::text('equipmentsrno[]', null, array('placeholder'=>'equipmentsrno','class' => 'form-control equipmentsrnoclass','required' => 'required','id'=>'equipmentsrnoid')) }}</div>' +
                '<div class="form-group col-md-2" style="height:10px;" ><label for="inputPassword4">Product Sr No</label>{{ Form::text('productsrno[]', null, array('placeholder'=>'productsrno','class' => 'form-control productsrnoclass','required' => 'required','id'=>'productsrnoid')) }}</div>' +
                '<div class="form-group col-md-2"><label for="inputPassword4">Specification</label>{{ Form::text('specification[]', null, array('placeholder'=>'Specification','class' => 'form-control form-control-sm specification','required' => 'required', 'id' => 'specification_%count%')) }}</div>'.replace('%count%', count) +
                '</div></div>';

            $('#addrow').append(appendtagsequipement);

            $('#categoryid_' + count).selectize({
                maxItems: 1
            });

            $(addButton).click(function () { //Once add button is clicked
                $(wrapper).append(appendtagsequipement); // Add field html
            });

            $(wrapper).on('click', '.remove_button', function (e) { //Once remove button is clicked
//                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
//                x--; //Decrement field counter
            });

            if ($("#contractequipmentid").val() != "") {
                $.ajax({
                    url: '{{ URL::to('getbranchpluseequipmen') }}/' + $('#contractequipmentid').val(),
                    type: "GET",
                    dataType: "json",
                    data: $("#contractequipmentid").serialize(),
                    success: function (data) {
                        for (var i = 0; i < data.branchlist.length; i++) {
                            if (data.branchlist[i] != undefined) {
                                $("#branchcodeid_" + count).append($("<option>" + "  " + +"</option>" + "<option value=" + data.branchlist[i].branchcode + ">" + " " + data.branchlist[i].branchname + "</option>"));
                            }
                        }
                        for (var i = 0; i < data.equipmentlist.length; i++) {
                            if (data.equipmentlist[i] != undefined) {
                                $("#productid_" + count).append($("<option>" + "  " + +"</option>" + "<option value=" + data.equipmentlist[i].productservicecode + ">" + " " + data.equipmentlist[i].productservicename + "</option>"));
                            }
                        }
                        $("#productid_" + count).selectize();
                        $("#branchcodeid_" + count).selectize();

                        count = parseInt(count) + 1;
                        $('#equipmentcount').val(count);
                    }
                });
            }
        }

        function myFunction(id) {
            document.getElementById("myTable_"+id).deleteRow(0);
        }
        function addcontractsitemastersdiv() {
            var wrapper = $('#addcontractsitemaster');
            var addButton = $('#addcontractsitemastersdiv');
            var count = $('#contractsitecontactmastercount').val();
            var id = $('#contractsitecontactmastercount').val();
            var appendtags = '<div><a  href="javascript:void(0);" class="remove_button" title="Remove field"><img src="{{asset('img/cancel-512.png')}}" style="height: 20px; width: 20px; margin-left:910px;"/></a><div class="panel col-md-12" style="border: silver 1px solid;"><div class="panel-body">{{ Form::hidden('contractsitemasterid[]', '0',array('class'=>'contractsitemasterclass')) }} <div class="row mt-1"> ' +
                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name</label> <div class="col-sm-6"> ' +
                '{{ Form::text('branchname[]', null, array('class' => 'form-control form-control-sm', 'id' => 'branchid','required' => 'required')) }} </div> </div> ' +
                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Fax</label> <div class="col-sm-6"> ' +
                '{{ Form::number('fax[]', null, array('class' => 'form-control form-control-sm', 'id'=>'faxid','onKeyPress'=>'if(this.value.length==11) return false;')) }}</div></div>' +

                ' <div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Phone</label> <div class="col-sm-6">' +
                ' {{ Form::number('phone[]', null, array('class' => 'form-control form-control-sm', 'id'=>'phoneid','required' => 'required','onKeyPress'=>'if(this.value.length==11) return false;')) }}</div></div>' +

                ' <div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">email</label> <div class="col-sm-6">' +
                ' {{ Form::email('email[]', null, array('class' => 'form-control form-control-sm', 'id'=>'emailid_%id%','required' => 'required','onchange'=>'validemail(%count%);')) }} </div></div></div></div>'.replace('%id%', id).replace('%count%', count);

            $(addButton).click(function () { //Once add button is clicked
                $(wrapper).append(appendtags); // Add field html
            });

            $(wrapper).on('click', '.remove_button', function (e) { //Once remove button is clicked
//                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
//                x--; //Decrement field counter
            });

            $('#addcontractsitemaster').append(appendtags);
            count = parseInt(count) + 1;
            $('#contractsitecontactmastercount').val(count);
        }
        function addcontractsitcontactemastersdiv() {
            var wrapper = $('#addcontractsitecontactmaster');
            var addButton = $('#addcontractsitcontactemastersdiv');
            var count = $('#contractsitecontactmasterdivcount').val();
            var id = $('#contractsitecontactmasterdivcount').val();
            var appendtags = '<div><a   href="javascript:void(0);" class="remove_button" title="Remove field"><img src="{{asset('img/cancel-512.png')}}" style="height: 20px; width: 20px; margin-left:910px; margin-top: 15px;"/></a><div class="panel col-md-12" style="border: silver 1px solid;"><div class="panel-body">{{ Form::hidden('contractsitecontactsaveid[]', '0',array('class'=>'contractsitecontactsaveclassid')) }} <div class="row mt-1"> ' +
                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name</label> <div class="col-sm-6"> ' +
                '{{ Form::select('branchcode[]',array('placeholder' => '---SELECT---'),null, array('required' => 'required', 'id' => 'partialbranchid_%count%')) }} </div> </div>'.replace('%count%', count) +
                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Branch Person Name</label> <div class="col-sm-6"> ' +
                '{{ Form::text('contactpersonname[]', null, array('class' => 'form-control form-control-sm','required' => 'required')) }} </div> </div> ' +
                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Fax</label> <div class="col-sm-6"> ' +
                '{{ Form::text('fax[]', null, array('class' => 'form-control form-control-sm', 'id'=>'faxid','onKeyPress'=>'if(this.value.length==12) return false;')) }}</div></div>' +
                ' <div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Phone</label> <div class="col-sm-6">' +
                ' {{ Form::number('phone[]', null, array('class' => 'form-control form-control-sm', 'id'=>'phoneid','onKeyPress'=>'if(this.value.length==11) return false;')) }}</div></div>' +
                ' <div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">email</label> <div class="col-sm-6">' +
                ' {{ Form::email('emailid[]', null, array('class' => 'form-control form-control-sm', 'id'=>'emailid_%id%','onchange'=>'validmastercontactemail(%count%);')) }} </div></div></div></div>'.replace('%id%', id).replace('%count%', count);
            $('#addcontractsitecontactmaster').append(appendtags);

            $(addButton).click(function () { //Once add button is clicked
                $(wrapper).append(appendtags); // Add field html
            });

            $(wrapper).on('click', '.remove_button', function (e) { //Once remove button is clicked
//                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
//                x--; //Decrement field counter
            });

            if ($("#contractnositcontactid").val() != "") {
                $.ajax({
                    url: '{{ URL::to('getbranch') }}/' + $('#contractnositcontactid').val(),
                    type: "GET",
                    dataType: "json",
                    data: $("#contractnositcontactid").serialize(),
                    success: function (data) {
                        for (var i = 0; i < data.branchlist.length; i++) {
                            if (data.branchlist[i] != undefined) {
                                $("#partialbranchid_" + count).append($("<option>" + "  " + +"</option>" + "<option value=" + data.branchlist[i].branchcode + ">" + " " + data.branchlist[i].branchname + "</option>"));
                            }
                        }
                        $("#partialbranchid_" + count).selectize();

                        count = parseInt(count) + 1;
                        $('#contractsitecontactmasterdivcount').val(count);
                    }
                });
            }

        }
        function addequipmentdiv() {
            var wrapper = $('#add');
            var addButton = $('#addcontractsitcontactemastersdiv');
            var count = $('#contractdetailsrowcount').val();
            var quantity = "$('#quantity%count%').val()".replace("%count%", count);
            var rate = "$('#rate%count%').val()".replace("%count%", count);
            var period = "$('#warranty_amc_period%count%').val()".replace("%count%", count);
            var sgstrate = "$('#sgstrate%count%').val()".replace("%count%", count);
            var sgstamt = "$('#sgstamt%count%')".replace("%count%", count);
            var cgstrate = "$('#cgstrate%count%').val()".replace("%count%", count);
            var cgstamt = "$('#cgstamt%count%')".replace("%count%", count);
            var taxrate = "$('#taxrate%count%').val()".replace("%count%", count);
            var taxamt = "$('#taxamt%count%')".replace("%count%", count);
            var totaltax = "$('#totalcontractcost%count%')".replace("%count%", count);
            var grossrate = "$('#totaltaxamt%count%')".replace("%count%", count);

            var appendtags = '<div><a  href="javascript:void(0);" class="remove_button" title="Remove field"><img src="{{asset('img/cancel-512.png')}}" style="height: 20px; width: 20px; margin-left:910px;"/></a><div class="panel col-md-12" style="border: silver 1px solid;"><div class="panel-body">{{ Form::hidden('contractdetailsaveid[]', '0' , array('class'=> 'contractdetailssaveidclass')) }} <div class="row mt-1"> ' +
                '<label for="input" class="col-sm-4 col-form-label text-muted">Equipment</label> <div class="col-sm-4"> ' +
                '{{ Form::select('eqipment[]', $eqipment,null, array('required' => 'required','placeholder' => '--SELECT--', 'id' => 'productservice%count%')) }} </div> </div> '.replace('%count%', count) +

                '<div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Quantity (A)</label> <div class="col-sm-4"> ' +
                '{{ Form::text('quantity[]', null, array('required' => 'required','class' => 'form-control form-control-sm', 'id' => 'quantity%count%', 'onkeyup')) }}</div> </div> '.replace('%count%', count).replace('onkeyup', "onkeyup = calculategross(" + quantity + "," + rate + "," + period + "," + sgstrate + "," + sgstamt + "," + cgstrate + "," + cgstamt + "," + taxrate + "," + taxamt + "," + grossrate + "," + totaltax + "); return false;") +

                '<div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Rate (B)</label> <div class="col-sm-4"> ' +
                '{{ Form::text('rate[]', null, array('required' => 'required','class' => 'form-control form-control-sm', 'id'=>'rate%count%', 'onkeyup')) }}</div> </div>'.replace('%count%', count).replace('onkeyup', "onkeyup = calculategross(" + quantity + "," + rate + "," + period + "," + sgstrate + "," + sgstamt + "," + cgstrate + "," + cgstamt + "," + taxrate + "," + taxamt + "," + grossrate + "," + totaltax + "); return false;") +

                ' <div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">HSN Code </label> <div class="col-sm-4">' +
                ' {{ Form::text('hsncode[]', null, array('class' => 'form-control form-control-sm', 'id'=>'hsncode%count%')) }} </div> </div>'.replace('%count%', count) +

                ' <div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Warranty / AMC Period (C)</label> <div class="col-sm-4">' +
                ' {{ Form::text('warranty_amc_period[]', null, array('required' => 'required','class' => 'form-control form-control-sm', 'id'=>'warranty_amc_period%count%', 'onkeyup')) }}</div><div class="col-md-2">Months</div></div>'.replace('%count%', count).replace('onkeyup', "onkeyup = calculategross(" + quantity + "," + rate + "," + period + "," + sgstrate + "," + sgstamt + "," + cgstrate + "," + cgstamt + "," + taxrate + "," + taxamt + "," + grossrate + "," + totaltax + "); return false;") +

                ' <div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">tax Rate</label> <div class="col-sm-4">' +
                ' {{ Form::text('taxrate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'taxrate%count%', 'onkeyup','onchange'=>'chkvalidation(%count%);')) }} </div><div class="col-md-2">%</div></div>'.replace('%count%', count).replace('onkeyup', "onkeyup = calculategross(" + quantity + "," + rate + "," + period + "," + sgstrate + "," + sgstamt + "," + cgstrate + "," + cgstamt + "," + taxrate + "," + taxamt + "," + grossrate + "," + totaltax + "); return false;") +

                ' <div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Tax Amt</label> <div class="col-sm-4">' +
                ' {{ Form::text('taxamt[]', null, array('class' => 'form-control form-control-sm', 'id'=>'taxamt%count%', 'readonly')) }} </div> </div>'.replace('%count%', count) +

                ' <div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">SGST Rate</label> <div class="col-sm-4">' +
                ' {{ Form::text('sgstrate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'sgstrate%count%', 'onkeyup')) }} </div><div class="col-md-2">%</div></div>'.replace('%count%', count).replace('onkeyup', "onkeyup = calculategross(" + quantity + "," + rate + "," + period + "," + sgstrate + "," + sgstamt + "," + cgstrate + "," + cgstamt + "," + taxrate + "," + taxamt + "," + grossrate + "," + totaltax + "); return false;") +

                ' <div class="row" style="margin-top:3px;"><label for="input" class="col-sm-4 col-form-label text-muted">SGST Amt</label> <div class="col-sm-4"> ' +
                '{{ Form::text('sgstamt[]', null, array('class' => 'form-control form-control-sm', 'id'=>'sgstamt%count%', 'readonly')) }} </div> </div>'.replace('%count%', count) +

                ' <div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">CGST Rate</label> <div class="col-sm-4">' +
                ' {{ Form::text('cgstrate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'cgstrate%count%', 'onkeyup')) }} </div><div class="col-md-2">%</div></div>'.replace('%count%', count).replace('onkeyup', "onkeyup = calculategross(" + quantity + "," + rate + "," + period + "," + sgstrate + "," + sgstamt + "," + cgstrate + "," + cgstamt + "," + taxrate + "," + taxamt + "," + grossrate + "," + totaltax + "); return false;") +
                ' <div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">CGST Amt</label> <div class="col-sm-4">' +
                ' {{ Form::text('cgstamt[]', null, array('class' => 'form-control form-control-sm', 'id'=>'cgstamt%count%', 'readonly')) }} </div> </div>'.replace('%count%', count) +

                ' <div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Total Tax (D)</label> <div class="col-sm-4">' +
                ' {{ Form::text('totaltax[]', null, array('class' => 'form-control form-control-sm', 'id'=>'totaltaxamt%count%', 'readonly')) }} </div> </div>'.replace('%count%', count) +

                ' <div class="row" style="margin-top:3px;"><label for="input" class="col-sm-4 col-form-label text-muted">Total Cost (E = A * (B + D))</label> <div class="col-sm-4"> ' +
                '{{ Form::text('totalcontractcost[]', null, array('class' => 'form-control form-control-sm', 'id'=>'totalcontractcost%count%', 'readonly')) }} </div> </div> </div></div></div>'.replace('%count%', count);

            $('#add').append(appendtags);
            $('#productservice' + count).selectize({
                maxItems: 1
            });

            $(addButton).click(function () { //Once add button is clicked
                $(wrapper).append(appendtags); // Add field html
            });

            $(wrapper).on('click', '.remove_button', function (e) { //Once remove button is clicked
//                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
//                x--; //Decrement field counter
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
    <script type="text/javascript">
        function excelDiv(){
            if($('#contractequipmentid').val() != "") {
                $.ajax({
                    url: "{{URL::to('getbranchpluseequipmen/')}}/" + $('#contractequipmentid').val(),
                    type: "GET",
                    dataType: "json",
                    data: $("#contractequipmentid").serialize(),
                    success: function (data) {
                        $('#categoryuploadid').val('');
                        $('#file').val('');
                        $('#branchcodeuploadid').selectize()[0].selectize.destroy();
                        $("#branchcodeuploadid").empty();
                        $('#branchcodeuploadid').append('<option value="" selected disabled>--SELECT--</option>');

                        $('#productiduploadid').selectize()[0].selectize.destroy();
                        $("#productiduploadid").empty();
                        $('#productiduploadid').append('<option value="" selected disabled>--SELECT--</option>');

                        for (var i = 0; i < data.branchlist.length; i++) {
                            if (data.branchlist[i] != undefined) {
                                $("#branchcodeuploadid").append($( "<option value=" + data.branchlist[i].branchcode + ">" + " " + data.branchlist[i].branchname + "</option>"));
                            }
                        }
                        for (var i = 0; i < data.equipmentlist.length; i++) {
                            if (data.equipmentlist[i] != undefined) {
                                $("#productiduploadid").append($( "<option value=" + data.equipmentlist[i].productservicecode + ">" + " " + data.equipmentlist[i].productservicename + "</option>"));
                            }
                        }

                    }
                });
            }
        }
        $("#productiduploadid").change(function(){
            if($('#contractequipmentid').val() != "") {
                $.ajax({
                    url: '{{ url('/equipmentforexcel') }}/' + $("#productiduploadid").val() + '/' + $('#contractequipmentid').val() + '/' + $('#branchcodeuploadid').val(),
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#categoryuploadid').selectize()[0].selectize.destroy();
                        $("#categoryuploadid").empty();
                        $('#categoryuploadid').append('<option value="" selected disabled>--SELECT--</option>');
                        for (var i = 0; i < data.category.length; i++) {
                            if (data.category[i] != undefined) {
                                $("#categoryuploadid").append($( "<option value=" + data.category[i].categorycode + ">" + " " + data.category[i].categoryname + "</option>"));
                            }
                        }
                        $('#contractnouploadid').val(data.contractmaster[0].contractno);
                        $('#contracttypeuploadid').val(data.contractmaster[0].workordertype);
                        $('#customeruploadid').val(data.contractmaster[0].customercode);
                        $('#workorderuploadid').val(data.contractmaster[0].workorderno);
                    }
                });
            }
            else {

                $('#categoryuploadid').selectize()[0].selectize.destroy();
                $("#categoryuploadid").empty();
                $('#categoryuploadid').selectize({
                    options: null
                });
            }

        });
        $("#excelUploadFormId").submit(function (e){
            e.preventDefault();
            $('#loading').show();
            $('#close').click();
            var formData = new FormData(this);
            $.ajax({
                type:"POST",
                processData: false,
                cache:false,
                contentType: false,
                url: "{{URL::to('edituploadexcel')}}",
                data: formData,
                language: {processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
                dataType:"json",
                success: function (data){
                    if(data.equipments.length > 0){
                        $('#addRowExcelUpload').hide();
                        $('#tableData').html("");
                        // alert('File has been uploaded successfully');
                        for (var i = 0; i < data.equipments.length; i++) {
                            var appendtagsequipement = '<tr>' +
                                '<td width="5%" style="text-align: center">' + data.branchname[i] + '</td>' +
                                '<td width="5%" style="text-align: center">' + data.productname[i] + '</td>' +
                                '<td width="5%" style="text-align: center">' + data.category[i] + '</td>' +
                                '<td width="5%" style="text-align: center">' + data.equipments[i].equipmentsrno + '</td>' +
                                '<td width="5%" style="text-align: center">' + data.equipments[i].productsrno + '</td>' +
                                '<td width="5%" style="text-align: center">' + data.equipments[i].specification + '</td>' +
                                '</tr>';
                            $('#tableData').append(appendtagsequipement);
                        }
                        $('#addRowExcelUpload').show();
                        $('#loading').hide();

                    }
                    else{
                        $('#loading').hide();
                        alert('Unable to process your request.');
                    }
                }

            });
        });
    </script>
    <script type="text/javascript">

        $("#contractmasterform").submit(function (e) {
            e.preventDefault();
            $("#contractformbtn").attr("disabled",true);
            $.ajax({
                type: "Get",
                contentType: "application/json",
                url: "{{ URL::to('updatecontractmasterdata') }}",
                data: $("#contractmasterform").serializeArray(),
                dataType: "json",
                success: function (response) {
                    if (response != "Error") {
                        // document.getElementById('contractsavedid').value = response;
                        $('#contractsavedid').val(response.contractno);
                        var contractno = (response.contractno);
                        var customercode = (response.customercode);
                        $('#contractnositid').val(contractno.replace(/"/g, ""));
                        $('#contractsitecustomerid').val(customercode.replace(/"/g, ""));
                        $('#equipmentcustomercodeid').val(customercode.replace(/"/g, ""));
                        //$('#contract-site-master').click();
                        $('#documents-tab-link').click();
                    }
                    else {
                        alert('Try Again!!!!');
                    }
                }
            });
        });
        $("#contractsitemaster").submit(function (e) {
            e.preventDefault();
            $("#branchform").attr("disabled", true);
            $.ajax({
                type: "Get",
                contentType: "application/json",
                url: "{{URL::to('updatecontractsitemaster')}}",
                data: $("#contractsitemaster").serialize(),
                dataType: "json",
                success: function (data) {
                    if (data != "Error") {
                        var test = data.contractcode;
                        $('#contractnositcontactid').val(test.replace(/"/g, ""));
                        $('#contract-site-contact-master').click();

                        var values = [];
                        for (var j = 0; j < $(".contractbrachcontactmasterclass").length; j++) {
                            values.push($(".contractbrachcontactmasterclass")[j].value);
                            $(".contractbrachcontactmasterclass")[j].selectize.destroy();
                        }

                        $(".contractbrachcontactmasterclass").find('option').remove();
                        $(".contractbrachcontactmasterclass").append($("<option>" + "  " + +"</option>"));
                        for (var i = 0; i < data.branchlist.length; i++) {
                            if (data.branchlist[i] != undefined) {
                                $(".contractbrachcontactmasterclass").append($("<option value=" + data.branchlist[i].branchcode + ">" + " " + data.branchlist[i].branchname + "</option>"));
                            }
                        }
                        for (var j = 0; j < $(".contractbrachcontactmasterclass").length; j++) {
                            if (values[j] == undefined) {
                                $(".contractbrachcontactmasterclass")[j].value = '';
                            }
                            else {
                                $(".contractbrachcontactmasterclass")[j].value = values[j];
                            }
                        }
                        $(".contractbrachcontactmasterclass").selectize();

                        for (var i = 0; i < data.branchlist.length; i++) {
                            if (data.branchlist[i] != undefined) {
                                $('.contractsitemasterclass').val(data.branchlist[i].branchcode);
                            }
                        }

                    }
                    else {
                        alert('Try Again!!!!');
                    }
                }
            });
        });
        $("#contractsitecontactmasterid").submit(function (e) {
            e.preventDefault();
            $("#contactbranchform").attr("disabled",true);
            $.ajax({
                type: "Get",
                contentType: "application/json",
                url: "{{URL::to('updatecontractsitecontactmaster')}}",
                data: $("#contractsitecontactmasterid").serialize(),
                dataType: "json",
                success: function (data) {
                    if (data != "Error") {
//                        document.getElementById('contractsitsavedid').value = response;
                        var test = (data.contractcode);
                        $('#contractdetailscontractid').val(test.replace(/"/g, ""));
                        $('#contract-details').click();

                        for (var i = 0; i < data.brachcontactlist.length; i++) {
                            if (data.brachcontactlist[i] != undefined) {
                                $('.contractsitecontactsaveclassid').val(data.brachcontactlist[i].branchcontactcode);
                            }
                        }
                    }
                    else {
                        alert('Try Again!!!!');
                    }
                }
            });
        });
        $("#contractdetailsform").submit(function (e) {
            e.preventDefault();
            $("#contractdetailsformbtn").attr("disabled",true);
            var acb = $("#contractdetailsform").serialize();
            console.log(acb);
            $.ajax({
                type: "Get",
                contentType: "application/json",
                url: "{{URL::to('updateContractDetails')}}",
                data: $("#contractdetailsform").serialize(),
                dataType: "json",
                success: function (response) {
                    if (response != "Error") {
                        var test = (response.contractno);
                        $('#contractequipmentid').val(test.replace(/"/g, ""));
                        $('#equipment').click();

                        var values = [];
                        for (var k = 0; k < $(".eqipmentbranchclass").length; k++) {
                            values.push($(".eqipmentbranchclass")[k].value);
                            $(".eqipmentbranchclass")[k].selectize.destroy();
                        }

                        $(".eqipmentbranchclass").find('option').remove();
                        $(".eqipmentbranchclass").append($("<option>" + "  " + +"</option>"));
                        for (var n = 0; n < response.branchlist.length; n++) {
//                            if (response.branchlist.length[n] != undefined) {
                            $(".eqipmentbranchclass").append($("<option value=" + response.branchlist[n].branchcode + ">" + " " + response.branchlist[n].branchname + "</option>"));
//                            }
                        }
                        for (var m = 0; m < $(".eqipmentbranchclass").length; m++) {
                            if (values[m] == undefined) {
                                $(".eqipmentbranchclass")[m].value = '';
                            }
                            else {
                                $(".eqipmentbranchclass")[m].value = values[m];
                            }
                        }
                        $(".eqipmentbranchclass").selectize();

//                        for (var o = 0; o < response.equipmentlist.length; o++) {
//                            if (response.equipmentlist[o] != undefined) {
//                                $(".eqipmentproductserviceclassid").append($("<option>" + "  " + +"</option>" + "<option value=" + response.equipmentlist[o].productservicecode + ">" + " " + response.equipmentlist[o].productservicename + "</option>"));
//                            }
//                        }
//                        $('.eqipmentproductserviceclass').selectize();

                        var productvalues = [];
                        for (var q = 0; q < $(".eqipmentproductserviceclass").length; q++) {
                            productvalues.push($(".eqipmentproductserviceclass")[q].value);
                            $(".eqipmentproductserviceclass")[q].selectize.destroy();
                        }

                        $(".eqipmentproductserviceclass").find('option').remove();
                        $(".eqipmentproductserviceclass").append($("<option>" + "  " + +"</option>"));
                        for (var s = 0; s < response.equipmentlist.length; s++) {
//                            if (response.branchlist.length[n] != undefined) {
                            $(".eqipmentproductserviceclass").append($("<option>" + "  " + +"</option>" + "<option value=" + response.equipmentlist[s].productservicecode + ">" + " " + response.equipmentlist[s].productservicename + "</option>"));
//                            }
                        }
                        for (var r = 0; r < $(".eqipmentproductserviceclass").length; r++) {
                            if (productvalues[r] == undefined) {
                                $(".eqipmentproductserviceclass")[r].value = '';
                            }
                            else {
                                $(".eqipmentproductserviceclass")[r].value = productvalues[r];
                            }
                        }
                        $(".eqipmentproductserviceclass").selectize();


                        for (var p = 0; p < response.contractdetailsid.length; p++) {
                            $('.contractdetailssaveidclass').val(response.contractdetailsid[p].id);
                        }

                    }
                    else {
                        alert('Try Again!!!!');
                    }
                }
            });
        });
        //        $("#equipmentDetailsform").click(function (e) {

        $("#btnaddid").click(function (e) {
            e.preventDefault();
            console.log($("#equipmentDetailsform").serialize());
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ URL::to('updateequipmentdetails') }}",
                dataType: 'JSON',
                data : $("#equipmentDetailsform").serialize(),
                success: function (response) {
                    if (response.errorInfo != undefined) {
                        alert(response.errorInfo[2]);
                    }
                    else {
                        for (var i = 0; i < response.equipmentsrnolist.length; i++) {
                            $('.equipmentsrnohdclassid').val(response.equipmentsrnolist[i].equipmentsrno);
                        }
                        alert('Record Added');
                    }
                }
            });
        });
        $("#btnsavecloseid").click(function (e) {
            e.preventDefault();
            $("#btnsavecloseid").attr("disabled",true);
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ URL::to('updateequipmentdetails') }}",
                dataType: 'JSON',
                data : $("#equipmentDetailsform").serialize(),
                success: function (response) {
                    if (response.errorInfo != undefined) {
                        alert(response.errorInfo[2]);
                    }
                    else {
                        for (var i = 0; i < response.equipmentsrnolist.length; i++) {
                            $('.equipmentsrnohdclassid').val(response.equipmentsrnolist[i].equipmentsrno);
                        }
                        //$('#paymentterms').click();
                        $('#equipment-upload').click();
                    }
                }
            });
        });
        $("#paymentdetailstermsform").submit(function (e) {
            e.preventDefault();
            $("#paymentbtn").attr("disabled",true);
            $.ajax({
                type: "GET",
                contentType: "application/json",
                url: "{{URL::to('updatepaymenterms')}}",
                data: $("#paymentdetailstermsform").serialize(),
                dataType: "json",
                success: function (data) {

                    window.location.href = '{{URL::to('contracts')}}';
                }
            });
        });

        window.onload = function () {
            if ($('#contracttypeid').val() == "Software Maintenance") {

                $('#hiddensuppledivid').hide();
            }
            else {
                $('#hiddensuppledivid').show();
            }
        };

        function deletequipments(event, element) {
            var id = event.dataset.valueOf();
            if ($("#deletequipmentsrnoid").data('equipmentsrno') != "") {
                $.ajax({
                    url: '{{ URL::to('deletequipment') }}/',
                    type: "GET",
                    dataType: "json",
                    data: {
                        equipmentsrid: id,
                        contractno: $('#equipmentdetailsupdateid').val()
                    },
                    success: function (data) {
                        window.location.href = '{{URL::to('editcontract')}}/' + data;
                    }
                });
            }
        }

        function getyear() {
            if ($("#contracttodateid").val() != "") {
                $.ajax({
                    url: '{{ url('/getyear/{data}') }}/',
                    {{--url: '{{ URL::to('/getyear/{data}') }}/',--}}
                            {{--url: '{{ url('getyear') }}//' + $("#productid").val()',--}}
                    type: "GET",
                    dataType: "json",
                    data: {
                        fromdate: $('#contractfromdateid').val(),
                        todate: $('#contracttodateid').val()
                    },
                    success: function (data) {

                        $('#contractperiodid').val(data);
                        $('#renewalperiodid').val(data);
                    }
                });
            }
        }
        function gettenderopendate() {
            if ($("#tenderno").val() != "") {
                $.ajax({
                    url: '{{ URL::to('gettenderdate') }}/' ,
                    type: "GET",
                    dataType: "json",
                    data: {
                        tenderno: $('#tenderno').val()
                    },
                    success: function (data) {
                        if(data != ""){
                            $('#tenderopendateid').val(data);
                        }
                        else{
                            $("#tenderopendateid").val('');
                        }

                    }
                });
            }
            else {
                $('#tenderopendateid').val();
            }
        }
        $("#workordertypeid").change(function () {
            if ($('#workordertypeid').val() == "Hardware AMC") {
                $("#customername").show();
            }
            else {
                $("#customername").hide();
            }
        });
        $(document).ready(function () {
            if ($('#hdcompresinvetypeid').val() == "Hardware AMC") {
                $("#customername").show();
            }
            else {
                $("#customername").hide();
            }
        });

    </script>
    <script type="text/javascript">
        document.getElementById("workorderdateid").onblur = function () {
            ValidateDate('workorderdateid', 2050, 'hi there your date is not good.')
        };
        document.getElementById("closerdateid").onblur = function () {
            ValidateDate('closerdateid', 2050, 'hi there your date is not good.')
        };
        document.getElementById("purchaseorderdateid").onblur = function () {
            ValidateDate('purchaseorderdateid', 2050, 'hi there your date is not good.')
        };
        document.getElementById("contracttodateid").onblur = function () {
            ValidateDate('contracttodateid', 2050, 'hi there your date is not good.')
        };
        document.getElementById("contractfromdateid").onblur = function () {
            ValidateDate('contractfromdateid', 2050, 'hi there your date is not good.')
        };
    </script>
    <script type="text/javascript">
        function validemail(id) {
            var email = $('#emailid_' + id).val();
            var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
            if (!email.match(reEmail)) {
                alert('Invalid Email Address');
                $('#emailid_' + id).val('');
                return false;
            }
            return true;
        }

        function validmastercontactemail(id) {
            var email = $('#emailid_' + id).val();
            var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
            if (!email.match(reEmail)) {
                alert('Invalid Email Address');
                $('#emailid_' + id).val('');
                return false;
            }
            return true;
        }

        function chkvalidation() {
            if ($('#taxrate').val() != undefined || $('#sgstrate').val() != undefined) {
//                alert($('#workorderid').val() == ""  ? "select Workorder No" : 'select purchase order No');

                return true;
            } else {
                alert('please insert the value between taxrate and sgstrate && cgstrat');
                return false;
            }


//            if( $('#taxrate').val() != "")
//            {
//                alert('please insert the value between taxrate and sgstrate && cgstrat');
//                return  false;
//            }
//            else
//            {
//                if( $('#sgstrate').val() != "" && $('#cgstrate').val() != "")
//                {
//
//                }else {
//                    alert('please insert the value between taxrate and sgstrate && cgstrat');
//                    return  false;
//                }
//
//            }

        }
    </script>
    <script src="{{asset('datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatable/js/dataTables.bootstrap.min.js')}}"></script>
<script>
    var deleteUrl = "{{ url('delete-contract-document') }}";
</script>

    <script type="text/javascript">
// Document Upload Functions for Edit Screen
$(document).ready(function() {
    $('#multi-files').on('change', function(e) {
        var files = this.files;
        
        if (files.length > 3) {
            alert('You can only upload maximum 3 files at a time.');
            $(this).val('');
            return false;
        }
        
        if (files.length > 0) {
            uploadMultipleDocuments(files);
        }
    });
    
    // Load existing documents when Documents tab is clicked
    $('#documents-tab-link').click(function() {
        var contractno = $('#contractsavedid').val();

        

        if (contractno && contractno != '0' && contractno != '') {
            loadDocuments(contractno);
        }
    });
    
    // Load documents on page load if contract exists
    var contractno = $('#contractsavedid').val();
    if (contractno && contractno != '0' && contractno != '') {
        loadDocuments(contractno);
    }
});

function uploadMultipleDocuments(files) {
    //var contractno = $('#contractsavedid').val();
    var contractno = window.location.pathname.split('/').pop();
    
    if (!contractno || contractno == '0') {
        alert('Contract number not found.');
        $('#multi-files').val('');
        return false;
    }

    var subtype = '{{ isset($is_amendment) && $is_amendment ? "amend" : "new_contract" }}';
    
    var allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
    for (var i = 0; i < files.length; i++) {
        if (!allowedTypes.includes(files[i].type)) {
            alert('File "' + files[i].name + '" is not allowed. Only PDF, JPG, JPEG, PNG files.');
            $('#multi-files').val('');
            return false;
        }
        if (files[i].size > 10 * 1024 * 1024) {
            alert('File "' + files[i].name + '" exceeds 10MB limit.');
            $('#multi-files').val('');
            return false;
        }
    }
    
    $('#upload-progress').show();
    updateProgress(0);
    
    var formData = new FormData();
    for (var i = 0; i < files.length; i++) {
        formData.append('documents[]', files[i]);
    }
    formData.append('contractno', contractno);
    formData.append('subtype', subtype);
    formData.append('_token', '{{ csrf_token() }}');
    
    $.ajax({
        url: '{{ url("upload-multiple-documents") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percent = (evt.loaded / evt.total) * 100;
                    updateProgress(percent);
                }
            }, false);
            return xhr;
        },
        success: function(response) {
            if (response.success) {
                $('#upload-status').html('<div class="alert alert-success">' + response.message + '</div>');
                
                // Use fresh data returned from server directly (no second request needed)
                if (response.documents) {
                    var docs = response.documents;
                    updateDocDisplay('doc1', docs.doc1, contractno);
                    updateDocDisplay('doc2', docs.doc2, contractno);
                    updateDocDisplay('doc3', docs.doc3, contractno);
                } else {
                    loadDocuments(contractno); // fallback
                }

                $('#multi-files').val('');
                setTimeout(function() {
                    $('#upload-status').fadeOut();
                    $('#upload-progress').fadeOut();
                }, 3000);
            } else {
                $('#upload-status').html('<div class="alert alert-danger">' + response.message + '</div>');
                setTimeout(function() {
                    $('#upload-progress').fadeOut();
                }, 3000);
            }
        },
        error: function(xhr) {
            var errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Upload failed. Please try again.';
            $('#upload-status').html('<div class="alert alert-danger">' + errorMsg + '</div>');
            setTimeout(function() {
                $('#upload-progress').fadeOut();
            }, 3000);
        }
    });
}




function loadDocuments(contractno) {
    if (!contractno || contractno === '[object Object]' || typeof contractno !== 'string') {
        console.log('Invalid contractno, skipping loadDocuments:', contractno);
        return;
    }
    
    var timestamp = new Date().getTime();
    var subtype = '{{ isset($is_amendment) && $is_amendment ? "amend" : "new_contract" }}';
    
    console.log('Loading documents for:', contractno);

    
    var timestamp = new Date().getTime();
    var subtype = '{{ isset($is_amendment) && $is_amendment ? "amend" : "new_contract" }}';
    
    console.log('Loading documents for:', contractno);
    console.log('Subtype:', subtype);
    
    $.ajax({
        url: '{{ url("get-contract-documents") }}/' + contractno + '?_=' + timestamp,
        type: 'GET',
        cache: false,
        success: function(response) {
            console.log('Response:', response);
            if (response.success && response.documents) {
                // First try to get documents for current subtype
                var docs = response.documents[subtype];
                
                // If no docs found and we're looking for new_contract, also check if docs exist directly
                if (!docs && subtype === 'new_contract') {
                    // Some old records might be stored directly without subtype nesting
                    docs = response.documents;
                }
                
                console.log('Docs found:', docs);
                if (docs && (docs.doc1 || docs.doc2 || docs.doc3)) {
                    updateDocDisplay('doc1', docs.doc1, contractno);
                    updateDocDisplay('doc2', docs.doc2, contractno);
                    updateDocDisplay('doc3', docs.doc3, contractno);
                } else {
                    $('#doc1-row').hide();
                    $('#doc2-row').hide();
                    $('#doc3-row').hide();
                }
            }
        },
        error: function(xhr) {
            console.log('Load error:', xhr);
        }
    });
}

function updateDocDisplay(docField, filePath, contractno) {
    if (filePath) {
        var fileName = filePath.split('/').pop();
        var shortName = fileName.length > 35 ? fileName.substring(0, 32) + '...' : fileName;
        var fileExtension = fileName.split('.').pop().toLowerCase();
        var isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension);
        var viewUrl = '{{ url("view-contract-document") }}/' + contractno + '/' + docField;
        var downloadUrl = '{{ url("download-contract-document") }}/' + contractno + '/' + docField;
        
        var actions = '';
        actions += '<a href="' + viewUrl + '" target="_blank" class="btn btn-info btn-xs" title="View"><i class="glyphicon glyphicon-eye-open"></i> View</a> ';
        actions += '<a href="' + downloadUrl + '" class="btn btn-success btn-xs" title="Download"><i class="glyphicon glyphicon-download-alt"></i> Download</a> ';
        actions += '<button class="btn btn-danger btn-xs" onclick="deleteDocument(\'' + docField + '\')" title="Delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
        
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

function deleteDocument(docField) {
    if (!confirm('Are you sure you want to remove this document?')) return;

    //var contractno = $('#contractsavedid').val();
    //var contractno = document.getElementById('contractsavedid').value;
    var contractno = window.location.pathname.split('/').pop();
    
    

    console.log("contractno value444:", contractno);
console.log("type:", typeof contractno);

    $.ajax({
        url: deleteUrl,
        type: 'POST',
        data: {
            contractno: contractno,
            doc_field: docField
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                loadDocuments(contractno);
                $('#upload-status').html('<div class="alert alert-success">Document removed successfully</div>');
            } else {
                // alert('Failed: ' + response.message);
                //alert(JSON.stringify(response));
                alert(response.message);
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            alert(xhr.responseText);
        }
    });
}


function updateProgress(percent) {
    $('#upload-progress .progress-bar').css('width', percent + '%').text(Math.round(percent) + '%');
}
</script>



    <script>
        $('#example').DataTable({
            "paging": false,
            "ordering": false,
            "info": false
        });
    </script>
    <script type="text/javascript">
        function calculate(id) {
            var quantity = $('#quantityid_' + id).val();
            var rate = $('#rateid_' + id).val();
            var period = $('#warrantyamcperiodid_' + id).val();
            var taxrate = $('#taxrateid_' + id).val();
            var sgstrate = $('#sgstrateid_' + id).val();
            var cstrate = $('#cgstrateid_' + id).val();


            // var calculatedtax = rate * taxrate / 100;
            // var rateplustax = parseFloat(rate) + parseFloat(calculatedtax);
            // var tax = rate * taxrate / 100;
            // tax = tax.toFixed(2);
            // var calsgstamt = rate * sgstrate / 100;
            // var calcgstamt = rate * cstrate / 100;
            // var totaltax = parseFloat(calsgstamt) + parseFloat(calcgstamt) + parseFloat(tax);
            // totaltax = totaltax.toFixed(2);
            // var calgrossrate = parseFloat(rate) + parseFloat(totaltax);
            // var test = parseFloat(quantity) * calgrossrate;
            // var year = period / 12;
            // var caltotalcost = test * year;
            // caltotalcost = caltotalcost.toFixed(2);

            // var calculatedtax = rate * taxrate / 100;
            // var rateplustax = parseFloat(rate) + parseFloat(calculatedtax);

            var baseAmount = parseFloat(rate) * parseFloat(quantity);
            var tax = baseAmount * taxrate / 100;
            var calsgstamt = baseAmount * sgstrate / 100;
            var calcgstamt = baseAmount * cstrate / 100;

            tax = tax.toFixed(2);

            var totaltax = parseFloat(calsgstamt) + parseFloat(calcgstamt) + parseFloat(tax);
            totaltax = totaltax.toFixed(2);

            var year = period / 12;
            var caltotalcost = (baseAmount + parseFloat(totaltax)) * year;  // ✅ use baseAmount
            caltotalcost = caltotalcost.toFixed(2);


            


            $('#totalcontractcostid_' + id).val(caltotalcost);
            $('#totaltaxid_' + id).val(totaltax);
            $('#taxamtid_' + id).val(tax);
            $('#sgstamtid_' + id).val(calsgstamt);
            $('#cgstamtid_' + id).val(calcgstamt);
        }
        

    </script>
    <script type="text/javascript">
        $('#servicefrequencyid').change(function(){
            var value = $('#servicefrequencyid').val();
            $('#serviceChangeId').val(value);
        });
    </script>





    <script>
    // Equipment Upload Functions for Edit Screen
$(document).ready(function() {
    $('#equipment-file-input').on('change', function(e) {
        var file = this.files[0];
        if (file) {
            uploadEquipmentDocument(file);
        }
    });

    // Load equipment doc when tab is clicked
    $('#equipment-upload').click(function() {
        var contractno = $('#contractequipmentid').val();
        if (contractno && contractno != '0' && contractno != '') {
            loadEquipmentDocument(contractno);
        }
    });
    
    // Also load on page load if equipment tab has contract
    var contractno = $('#contractequipmentid').val();
    if (contractno && contractno != '0' && contractno != '') {
        loadEquipmentDocument(contractno);
    }
});

function uploadEquipmentDocument(file) {
    var contractno = $('#contractequipmentid').val();

    if (!contractno || contractno == '0' || contractno == '') {
        alert('Contract number not found.');
        $('#equipment-file-input').val('');
        return false;
    }
    var subtype = '{{ isset($is_amendment) && $is_amendment ? "amend_equipment" : "equipment" }}';

    var allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'xls', 'xlsx'];
    var fileExtension = file.name.split('.').pop().toLowerCase();

    if (!allowedExtensions.includes(fileExtension)) {
        alert('File type not allowed. Please upload Excel, PDF, or Image files only.');
        $('#equipment-file-input').val('');
        return false;
    }

    if (file.size > 10 * 1024 * 1024) {
        alert('File size exceeds 10MB limit.');
        $('#equipment-file-input').val('');
        return false;
    }

    $('#equipment-upload-progress').show();
    updateEquipmentProgress(0);

    var formData = new FormData();
    formData.append('document', file);
    formData.append('contractno', contractno);
    formData.append('subtype', subtype);
    formData.append('_token', '{{ csrf_token() }}');

    $.ajax({
        url: '{{ url("upload-equipment-document") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percent = (evt.loaded / evt.total) * 100;
                    updateEquipmentProgress(percent);
                }
            }, false);
            return xhr;
        },
        success: function(response) {
            if (response.success) {
                $('#equipment-upload-status').html('<div class="alert alert-success">' + response.message + '</div>');
                loadEquipmentDocument(contractno);
                $('#equipment-file-input').val('');
                setTimeout(function() {
                    $('#equipment-upload-status').fadeOut();
                    $('#equipment-upload-progress').fadeOut();
                }, 3000);
            } else {
                $('#equipment-upload-status').html('<div class="alert alert-danger">' + response.message + '</div>');
                setTimeout(function() { $('#equipment-upload-progress').fadeOut(); }, 3000);
            }
        },
        error: function(xhr) {
            var errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Upload failed. Please try again.';
            $('#equipment-upload-status').html('<div class="alert alert-danger">' + errorMsg + '</div>');
            setTimeout(function() { $('#equipment-upload-progress').fadeOut(); }, 3000);
        }
    });
}



function loadEquipmentDocument(contractno) {
    var subtype = '{{ isset($is_amendment) && $is_amendment ? "amend_equipment" : "equipment" }}';
    
    console.log('Loading equipment for:', contractno);
    console.log('Equipment subtype:', subtype);
    
    $.ajax({
        url: '{{ url("get-equipment-document") }}/' + contractno,
        type: 'GET',
        cache: false,
        success: function(response) {
            console.log('Equipment response:', response);
            if (response.success && response.document) {
                var docs = response.document[subtype];
                console.log('Equipment docs:', docs);
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
    if (filePath) {
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
        actions += '<a href="' + downloadUrl + '" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-download-alt"></i> Download</a> ';
        actions += '<button class="btn btn-danger btn-xs" onclick="deleteEquipmentDocument()"><i class="glyphicon glyphicon-trash"></i> Delete</button>';

        $('#eqdoc1-name').html(fileIcon + '<a href="' + viewUrl + '" target="_blank">' + shortName + '</a>');
        $('#eqdoc1-action').html(actions);
        $('#eqdoc1-row').show();
        $('#eqdoc-empty-row').hide();
    } else {
        $('#eqdoc1-row').hide();
        $('#eqdoc-empty-row').show();
    }
}

function deleteEquipmentDocument() {
    if (!confirm('Are you sure you want to delete this equipment document?')) return;

    var contractno = $('#contractequipmentid').val();

    $.ajax({
        url: '{{ url("delete-equipment-document") }}',
        type: 'POST',
        data: {
            contractno: contractno,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                $('#eqdoc1-row').hide();
                $('#eqdoc-empty-row').show();
                $('#equipment-upload-status').show().html('<div class="alert alert-success">Document deleted successfully.</div>');
                setTimeout(function() { $('#equipment-upload-status').fadeOut(); }, 2000);
            } else {
                alert('Failed to delete: ' + response.message);
            }
        },
        error: function() {
            alert('Error deleting document.');
        }
    });
}

function updateEquipmentProgress(percent) {
    $('#equipment-upload-progress .progress-bar').css('width', percent + '%').text(Math.round(percent) + '%');
}
    </script>

@endsection

