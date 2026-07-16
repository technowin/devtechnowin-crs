@extends('layouts.appnew')
@section('pageTitle', 'Add Contract')
@section('page-css')
    <link href="{{asset('css/tab-css.css')}}" rel="stylesheet">
@stop
@section('content')

    <div class="container-fluid">
        <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#contract-tab" id="contract" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Contract</a></li>
                <li role="presentation"><a href="#documents-tab" id="documents-tab-link" role="tab" data-toggle="tab" aria-expanded="false">Contract Documents</a></li>
                <li role="presentation" class=""><a href="#contract-site-master-tab"  role="tab" id="contract-site-master" data-toggle="tab" aria-expanded="false">Contract Site Master</a></li>
                <li role="presentation" class=""><a href="#contract-site-contact-master-tab" role="tab" id="contract-site-contact-master" data-toggle="tab" aria-expanded="false">Contract Site Contact Master</a></li>
                <li role="presentation" class=""><a href="#contract-details-tab" role="tab" id="contract-details" data-toggle="tab" aria-expanded="false">Contract Details</a></li>
                <li role="presentation" ><a href="#equipment-tab" role="tab" id="equipment" data-toggle="tab" aria-expanded="false">Equipment</a></li>
                <li role="presentation"><a href="#equipment-upload-tab" role="tab" id="equipment-upload" data-toggle="tab" aria-expanded="false">Equipment Upload</a></li>
                <li role="presentation"><a href="#billing-tab" role="tab" id="billing-details" data-toggle="tab" aria-expanded="false">Billing Details</a></li>


                <li role="presentation" ><a href="#payment-term-tab" role="tab" id="paymentterms" data-toggle="tab" aria-expanded="false">Payment Terms</a></li>
            </ul>
            <br>
            <div class="tab-content">

                <div class="tab-pane fade active in" role="tabpanel" id="contract-tab" style="margin-left: 250px;">
                    <div class="container">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">New Contract </h3>
                            </div>
                            <div class="panel-body">
                                {{Form::open(array('action' => 'ContractController@addNewContract','method' => 'get', 'id' => 'contractmasterform', 'class'=>'form-horizontal'))}}
                                {{ Form::hidden('contractsaved', $contractsaved) }}
                                {{ Form::hidden('contractsaved', '0', array('id' => 'contractsavedid')) }}
                                {{ Form::hidden('servicedate',null, array('id' => 'servicedateid')) }}
                                {{ Form::hidden('servicereminderdate',null, array('id' => 'servicereminderdateid')) }}

                                <div class="row{{ $errors->has('customers') ? ' has-error' : '' }}"
                                     style="padding-top:5px;">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Customer Name</label>
                                    <div class="col-sm-6">
                                        {{ Form::select('customers', $customers, null, array('placeholder' => '--SELECT--','id' => 'customers')) }}
                                        @if ($errors->has('customers'))
                                            <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                                        @endif
                                    </div>
                                </div>


                                <div class="row {{ $errors->has('tenderno') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Tender No/Quotation No</label>
                                    <div class="col-sm-6">
                                        {{ Form::select('tenderno',$tenders,null, array('placeholder' => '--SELECT--','id' => 'tenderno','onchange'=>'gettenderopendate();')) }}
                                        @if ($errors->has('tenderno'))
                                            <span class="help-block"><strong>{{ $errors->first('tenderno') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row {{ $errors->has('tenderopendate') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Tender Open
                                        Date</label>
                                    <div class="col-sm-6">
                                        {{ Form::date('tenderopendate', null, array('class' => 'form-control form-control-sm','id'=>'tenderopendateid')) }}
                                        @if ($errors->has('tenderopendate'))
                                            <span class="help-block"><strong>{{ $errors->first('tenderopendate') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('workordertype') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Work Order
                                        Type</label>
                                    <div class="col-sm-6">
                                        {{ Form::select('workordertype',array(''=>'--Select--','Software development'=>'Software development','Hardware AMC'=>'Hardware AMC','Software Maintenance'=>'Software Maintenance & Suppprt','Hardware Warranty'=>'Hardware Warranty','Hardware Supply'=>'Hardware Supply','Scanning'=>'Scanning','Data Entry'=>'Data Entry','Manpower Supply'=>'Manpower Supply'),null, array('' => '--SELECT--','id' => 'workordertypeid')) }}
                                        @if ($errors->has('workordertype'))
                                            <span class="help-block"><strong>{{ $errors->first('workordertype') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div id="customername" ,
                                     class="row{{ $errors->has('workordertype') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Comprehensive
                                        Type</label>
                                    <div class="col-sm-6">
                                        {{ Form::select('comprehensivetype',array(''=>'--select--','Comprehensive'=>'Comprehensive','noncomprehensive'=>'Non Comprehensive'),null, array('id' => 'comprehensiveid')) }}
                                        @if ($errors->has('workordertype'))
                                            <span class="help-block"><strong>{{ $errors->first('workordertype') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('workorderno') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Work Order No</label>
                                    <div class="col-sm-6">
                                        {{ Form::text('workorderno',null,['id'=>'workorderid','class'=>'form-control form-control-sm']) }}
                                        @if ($errors->has('workorderno'))
                                            <span class="help-block"><strong>{{ $errors->first('workorderno') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('workorderdescription') ? ' has-error' : '' }} mt-1">
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
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Work Order
                                        Date</label>
                                    <div class="col-sm-6">
                                        {{ Form::date('workorderdate', null, array('id'=>'workorderdate','class' => 'form-control','required' => 'required','max'=> '2050-12-31')) }}
                                        @if ($errors->has('workorderdate'))
                                            <span class="help-block"><strong>{{ $errors->first('workorderdate') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('servicefrequency') ? ' has-error' : '' }} mt-1" id="serviceid">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Service Frequency</label>
                                    <div class="col-sm-6">
                                        {{ Form::select('serviceParameterscode',$serviceParameterscode,null, array('placeholder' => '--SELECT--','id'=>'servicefrequencyid')) }}
                                        @if ($errors->has('servicefrequency'))
                                            <span class="help-block"><strong>{{ $errors->first('servicefrequency') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('contractfromdate') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Contract From
                                        Date</label>
                                    <div class="col-sm-6">
                                        {{ Form::date('contractfromdate', null, array('id'=>'contractfromdateid','class' => 'form-control form-control-sm','required' => 'required','onchange'=>'getservicedate()','max'=> '2050-12-31')) }}
                                        @if ($errors->has('contractfromdate'))
                                            <span class="help-block"><strong>{{ $errors->first('contractfromdate') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row {{ $errors->has('contracttodate') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Contract To
                                        Date</label>
                                    <div class="col-sm-6">
                                        {{ Form::date('contracttodate', null, array('id'=>'contracttodateid','class' => 'form-control form-control-sm', 'id'=>'contracttodateid','required' => 'required','onchange' => 'getyear()','max'=> '2050-12-31')) }}
                                        @if ($errors->has('contracttodate'))
                                            <span class="help-block"><strong>{{ $errors->first('contracttodate') }}</strong></span>
                                        @endif
                                    </div>
                                </div>


                                <div class="row{{ $errors->has('contractperiod') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Contract Period (In
                                        Years)</label>
                                    <div class="col-sm-6">
                                        {{ Form::number('contractperiod', '', array('class' => 'form-control form-control-sm','id'=>'contractperiodid','readonly')) }}
                                        @if ($errors->has('contractperiod'))
                                            <span class="help-block"><strong>{{ $errors->first('contractperiod') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('purchaseorderno') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Purchase Order
                                        No</label>
                                    <div class="col-sm-6">
                                        {{ Form::text('purchaseorderno', '', array('id'=>'purchaseorderid','class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('purchaseorderno'))
                                            <span class="help-block"><strong>{{ $errors->first('purchaseorderno') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row {{ $errors->has('purchaseorderdate') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Purchase Order
                                        Date</label>
                                    <div class="col-sm-6">
                                        {{ Form::date('purchaseorderdate', null, array('id'=>'purchaseorderdateid','class' => 'form-control form-control-sm','max'=> '2050-12-31')) }}
                                        @if ($errors->has('purchaseorderdate'))
                                            <span class="help-block"><strong>{{ $errors->first('purchaseorderdate') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('amendmentno') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Amendment No</label>
                                    <div class="col-sm-6">
                                        {{ Form::text('amendmentno', '', array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('amendmentno'))
                                            <span class="help-block"><strong>{{ $errors->first('amendmentno') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('amendmentdescription') ? ' has-error' : '' }} mt-1">
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
                                        {{ Form::text('renewalperiod', '', array('class' => 'form-control form-control-sm','id'=>'renewalperiodid','readonly')) }}
                                        @if ($errors->has('renewalperiod'))
                                            <span class="help-block"><strong>{{ $errors->first('renewalperiod') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('totalcost') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Total Cost</label>
                                    <div class="col-sm-6">
                                        {{ Form::number('totalcost', '', array('id' => 'totalcost','class' => 'form-control form-control-sm','required' => 'required')) }}
                                        @if ($errors->has('totalcost'))
                                            <span class="help-block"><strong>{{ $errors->first('totalcost') }}</strong></span>
                                        @endif
                                    </div>
                                </div>


                                
                                <div class="row mt-1">
    <label class="col-sm-3 col-form-label text-muted">Project Owner Name</label>
    <div class="col-sm-6">
        {{ Form::text('projectownername', null, array('class' => 'form-control form-control-sm', 'id' => 'projectownernameid')) }}
    </div>
</div>

<div class="row mt-1">
    <label class="col-sm-3 col-form-label text-muted">Billing Owner Name</label>
    <div class="col-sm-6">
        {{ Form::text('billingownername', null, array('class' => 'form-control form-control-sm', 'id' => 'billingownernameid')) }}
    </div>
</div>




                                <div class="row {{ $errors->has('closerdate') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-3 col-form-label text-muted">Closure Date</label>
                                    <div class="col-sm-6">
                                        {{ Form::date('closerdate', null, array('id'=>'closerdateid','class' => 'form-control','onchange'=>'getclosuredate();','max'=> '2050-12-31')) }}
                                        @if ($errors->has('closerdate'))
                                            <span class="help-block"><strong>{{ $errors->first('closerdate') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

</br>
                                
                                <div class="row">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted"></label>
                                    <div class="col-sm-6">
                                        {{ Form::submit('Save & Close', array('class' => 'btn btn-primary','onclick'=>'return checkEmail();','id' => 'contractbtn')) }}
                                        <a class="btn btn-primary" href="{{url()->previous()}}">Cancel</a>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>

                        </div>
                    </div>
                </div>

<!-- NEW DOCUMENTS TAB -->
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

                <div class="tab-pane fade" role="tabpanel" id="contract-site-master-tab" aria-labelledby="contract-site-master" style="margin-left: 250px;">
                    <div class="container">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">New Contract Site Master</h3>
                            </div>
                            <div class="panel-body">
                                {{Form::open(array('action' => 'ContractController@addnewcontractsitemaster','method' => 'get', 'id' => 'contractsitemaster'))}}
                                {{ Form::hidden('contractsaved', $contractsaved) }}
                                {{ Form::hidden('customercode',null, array('id' => 'contractsitecustomerid')) }}
                                {{ Form::hidden('contractsitemaster[]','0', array('id' => 'contractsitemasterid','class'=>'contractsitemasterclass')) }}

                                <div class="row{{ $errors->has('contractno') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Contract No.</label>
                                    <div class="col-sm-6">
                                        {{ Form::text('contractno', null, array('class' => 'form-control form-control-sm contract','readonly','id'=>'contractnositid')) }}
                                        @if ($errors->has('contractno'))
                                            <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('branchname') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name</label>
                                    <div class="col-sm-6">
                                        {{ Form::text('branchname[]', null, array('class' => 'form-control form-control-sm','required' => 'required')) }}
                                        @if ($errors->has('branchname'))
                                            <span class="help-block"><strong>{{ $errors->first('branchname') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('fax') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Fax</label>
                                    <div class="col-sm-6">
                                        {{ Form::number('fax[]', null, array('id'=>'contractfaxid','class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==11) return false;')) }}
                                        @if ($errors->has('fax'))
                                            <span class="help-block"><strong>{{ $errors->first('fax') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('phone') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Phone</label>
                                    <div class="col-sm-6">
                                        {{ Form::number('phone[]', null, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==10) return false;','required' => 'required')) }}
                                        @if ($errors->has('phone'))
                                            <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('email[]') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Email</label>
                                    <div class="col-sm-6">
                                        {{--                                        {{ Form::email('email[]', null, array('class' => 'form-control','required' => 'required')) }}--}}
                                        {{ Form::email('email[]', null, ['id'=>'branchemailid_0','class' => 'form-control','required' => 'required','onchange'=>'validemail(0);']) }}
                                        @if ($errors->has('email[]'))
                                            <span class="help-block"><strong>{{ $errors->first('email[]') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <br/>
                                <input type="hidden" id="contractsitemastercount" value="1">
                                <div id="addcontractsitemaster">
                                </div>
                                <input href="javascript:void(0);" type="image" src="{{asset('img/plus.jpg')}}"
                                       style="height: 20px; width: 20px;"
                                       onclick="addcontractsitemastersdiv(); return false;"></input>
                                <div class="row">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted"></label>
                                    <div class="col-sm-6">
                                        {{ Form::submit('Save & Close', array('class' => 'btn btn-primary','id' => 'branchformbtn')) }}
                                        <a class="btn btn-primary" href="{{url()->previous()}}">Cancel</a>
                                    </div>

                                </div>
                                {{ Form::close() }}
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" role="tabpanel" id="contract-site-contact-master-tab" aria-labelledby="contract-site-contact-master" style="margin-left: 250px;">
                    <div class="container">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">New Contract Site Contact Master</h3>
                            </div>
                            <div class="panel-body">
                                {{Form::open(array('action' => 'ContractController@addnewcontractsitecontactmaster','method' => 'get', 'id' => 'contractsitecontactmaster'))}}
                                {{ Form::hidden('contractsaved', $contractsaved) }}
                                {{ Form::hidden('contractsitecontact[]', '0', array('class'=>'contractsitecontactclass')) }}

                                <div class="row{{ $errors->has('contractno') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Contract No.</label>
                                    <div class="col-sm-6">
                                        {{ Form::text('contractno', null, array('class' => 'form-control form-control-sm contract','readonly','id'=>'contractnositcontactid')) }}
                                        @if ($errors->has('contractno'))
                                            <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('contactpersonname') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name</label>
                                    <div class="col-sm-6">
                                        {{ Form::select('branchcode[]',array('placeholder' => '---SELECT---'),null, array('id' => 'contractsitecontactbranchid','required' => 'required','class'=>'contractsitecontactbranchcode')) }}
                                        @if ($errors->has('contactpersonname'))
                                            <span class="help-block"><strong>{{ $errors->first('contactpersonname') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('contactpersonname') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Branch Person
                                        Name</label>
                                    <div class="col-sm-6">
                                        {{ Form::text('contactpersonname[]', null, array('class' => 'form-control form-control-sm','required' => 'required')) }}
                                        @if ($errors->has('contactpersonname'))
                                            <span class="help-block"><strong>{{ $errors->first('contactpersonname') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('fax') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Fax</label>
                                    <div class="col-sm-6">
                                        {{ Form::number('fax[]', null, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==11) return false;')) }}
                                        @if ($errors->has('fax'))
                                            <span class="help-block"><strong>{{ $errors->first('fax') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('phone') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Phone</label>
                                    <div class="col-sm-6">
                                        {{ Form::number('phone[]', null, array('class' => 'form-control form-control-sm','onKeyPress'=>'if(this.value.length==10) return false;','required' => 'required')) }}
                                        @if ($errors->has('emailid'))
                                            <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('emailid') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Email</label>
                                    <div class="col-sm-6">
                                        {{ Form::email('emailid[]', null, array('id'=>'contactbranchid_0','class' => 'form-control form-control-sm','required' => 'required','onchange'=>'validebranchcontactmail(0);')) }}
                                        @if ($errors->has('emailid'))
                                            <span class="help-block"><strong>{{ $errors->first('emailid') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <input type="hidden" id="contractsitecontactmasterdivcount" value="1">
                                <div id="addcontractsitecontactmaster">
                                </div>
                                <input href="javascript:void(0);" type="image" src="{{asset('img/plus.jpg')}}"
                                       style="height: 20px; width: 20px;"
                                       onclick="addcontractsitcontactemastersdiv(); return false;"></input>
                                {{--<button class="btn btn-default" onclick="addcontractsitcontactemastersdiv(); return false;">Add Contract Site Contact Masters--}}
                                {{--</button>--}}
                                <br>
                                <div class="row">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted"></label>
                                    <div class="col-sm-6">
                                        {{ Form::submit('Save & Close', array('class' => 'btn btn-primary','id' => 'sitecontactbtn')) }}
                                        <a class="btn btn-primary" href="{{url()->previous()}}">Cancel</a>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" role="tabpanel" id="contract-details-tab" aria-labelledby="contract-details" style="margin-left: 250px;">
                    <div class="container">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Contract Details</h3>
                            </div>
                            <div class="panel-body">
                                {{Form::open(array('action' => 'ContractController@addContractDetails','method' => 'get', 'id' => 'contractdetailsform'))}}
                                {{ Form::hidden('contractdetailssaved', '', array('id' => 'contractdetailssaved')) }}
                                {{ Form::hidden('countid', '0', array('id' => 'countid')) }}
                                {{ Form::hidden('contractdetailssaveid[]', '0', array('class'=>'cotractdetailssaveidclass')) }}

                                <div class="col-md-12">
                                    <div class="row {{ $errors->has('contractno') ? ' has-error' : '' }} mt-2">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Contract No</label>
                                        <div class="col-sm-4">
                                            {{ Form::text('contractno', null, array('class' => 'form-control form-control-sm contract','readonly','id'=>'contractdetailscontractid')) }}
                                            @if ($errors->has('contractno'))
                                                <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="card col-md-12">
                                    <div class="row{{ $errors->has('productservice') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Equipment Type</label>
                                        <div class="col-sm-4">
                                            {{ Form::select('productservice[]', $productservice, null, array('placeholder' => '--SELECT--', 'id' => 'productservice')) }}
                                            @if ($errors->has('productservice'))
                                                <span class="help-block"><strong>{{ $errors->first('productservice') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Quantity (A)</label>
                                        <div class="col-sm-4">
                                            {{ Form::text('quantity[]', null, array('required' => 'required','class' => 'form-control form-control-sm', 'id' => 'quantity', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totaltaxamt"))')) }}
                                            <span class="help-block"><strong>{{ $errors->first('quantity') }}</strong></span>
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('rate') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Rate (B)</label>
                                        <div class="col-sm-4">
                                            {{ Form::text('rate[]', null, array('required' => 'required','class' => 'form-control form-control-sm', 'id'=>'rate', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totaltaxamt"))')) }}
                                            @if ($errors->has('rate'))
                                                <span class="help-block"><strong>{{ $errors->first('rate') }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="col-sm-2" style="padding-right: 50px; "></div>
                                    </div>
                                    <div class="row{{ $errors->has('hsncode[]') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">HSN Code</label>
                                        <div class="col-sm-4">
                                            {{ Form::text('hsncode[]', null, array('class' => 'form-control form-control-sm', 'id'=>'rate' )) }}
                                            @if ($errors->has('hsncode[]'))
                                                <span class="help-block"><strong>{{ $errors->first('hsncode[]') }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="col-sm-2" style="padding-right: 50px; "></div>
                                    </div>

                                    <div class="row{{ $errors->has('warranty_amc_period') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Warranty / AMC
                                            Period (C)</label>
                                        <div class="col-sm-4">
                                            {{ Form::text('warranty_amc_period[]', null, array('required' => 'required','class' => 'form-control form-control-sm', 'id'=>'warranty_amc_period', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totaltaxamt"))')) }}

                                            @if ($errors->has('warranty_amc_period'))
                                                <span class="help-block"><strong>{{ $errors->first('warranty_amc_period') }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="col-sm-2" style="padding-right: 50px; ">Months</div>
                                    </div>


                                    <div class="row{{ $errors->has('taxrate') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Tax Rate</label>
                                        <div class="col-sm-4">
                                            {{ Form::text('taxrate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'taxrate', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totaltaxamt"))')) }}
                                            @if ($errors->has('taxrate'))
                                                <span class="help-block"><strong>{{ $errors->first('taxrate') }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="col-sm-2">%</div>
                                    </div>

                                    <div class="row{{ $errors->has('taxamt') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Tax Amt</label>
                                        <div class="col-sm-4">
                                            {{ Form::text('taxamt[]', null, array('readonly'=>true,'class' => 'form-control form-control-sm', 'id'=>'taxamt', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totaltaxamt"))'))}}
                                            @if ($errors->has('taxamt'))
                                                <span class="help-block"><strong>{{ $errors->first('taxamt') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('sgstrate') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">SGST Rate</label>
                                        <div class="col-sm-4">
                                            {{ Form::text('sgstrate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'sgstrate', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totaltaxamt"))')) }}
                                            @if ($errors->has('sgstrate'))
                                                <span class="help-block"><strong>{{ $errors->first('sgstrate') }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="col-sm-2" style="padding-right: 50px; ">%</div>
                                    </div>

                                    <div class="row{{ $errors->has('sgstamt') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">SGST Amt</label>
                                        <div class="col-sm-4">
                                            {{ Form::text('sgstamt[]', null, array('readonly','class' => 'form-control form-control-sm', 'id'=>'sgstamt','onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totaltaxamt"))')) }}
                                            @if ($errors->has('sgstamt'))
                                                <span class="help-block"><strong>{{ $errors->first('sgstamt') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="row{{ $errors->has('cgstrate') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">CGST Rate</label>
                                        <div class="col-sm-4">
                                            {{ Form::text('cgstrate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'cgstrate','onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totaltaxamt"))')) }}
                                            @if ($errors->has('cgstrate'))
                                                <span class="help-block"><strong>{{ $errors->first('cgstrate') }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="col-sm-2">%</div>
                                    </div>
                                    <div class="row{{ $errors->has('cgstamt') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">CGST Amt</label>
                                        <div class="col-sm-4">
                                            {{ Form::text('cgstamt[]', null, array('readonly'=>true,'class' => 'form-control form-control-sm', 'id'=>'cgstamt','onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#warranty_amc_period").val(),$("#sgstrate").val(),$("#sgstamt"),$("#cgstrate").val(),$("#cgstamt"),$("#taxrate").val(),$("#taxamt"),$("#grossrate"),$("#totaltaxamt"))')) }}
                                            @if ($errors->has('cgstamt'))
                                                <span class="help-block"><strong>{{ $errors->first('cgstamt') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('grossrate') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted"> Total Tax
                                            (D)</label>
                                        <div class="col-sm-4">
                                            {{ Form::text('taxtotalamt[]', null, array('class' => 'form-control form-control-sm', 'id'=>'totaltaxamt', 'readonly','required' => 'required')) }}
                                            @if ($errors->has('taxtotalamt'))
                                                <span class="help-block"><strong>{{ $errors->first('taxtotalamt') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('grossrate') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Total Cost6 (E = A
                                            *(B + D))</label>
                                        <div class="col-sm-4">
                                            {{ Form::text('totalcontractcost[]', null, array('class' => 'form-control form-control-sm', 'id'=>'grossrate', 'readonly')) }}
                                            @if ($errors->has('grossrate'))
                                                <span class="help-block"><strong>{{ $errors->first('grossrate') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>


                                </div>

                                <input type="hidden" id="contractdetailsrowcount" value="1">
                                <div id="add">
                                </div>
                                <br/>
                                <input href="javascript:void(0);" type="image" src="{{asset('img/plus.jpg')}}"
                                       style="height: 20px; width: 20px;"
                                       onclick="addequipmentdiv(); return false;">

                                <div class="row">
                                    <label for="input" class="col-sm-4 col-form-label-sm text-muted"></label>
                                    <div class="col-sm-6">
                                        {{ Form::submit('Save & Close', array('class' => 'btn btn-primary','onclick'=>'return chkvalidation();','id' => 'contractdetailsbtn')) }}
                                        <a class="btn btn-primary" href="{{url()->previous()}}">Cancel</a>
                                    </div>
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
                            {{Form::open(array('action' => 'ContractController@addequipmentDetails','method' => 'get', 'id' => 'equipmentDetailsform'))}}
                            {{ Form::hidden('equipmentdetailssavedid[]', '0', array('id' => 'equipmentdetailssaved','class'=>'contractequipmentclass')) }}
                            {{ Form::hidden('equipmentcustomercode',null, array('id' => 'contractequipmentcustomerid')) }}

                            <div class="row{{ $errors->has('contractno') ? ' has-error' : '' }}">
                                <label for="input" class="col-sm-4 col-form-label text-muted">Contract No.</label>
                                <div class="col-sm-6">
                                    {{ Form::text('contractno', null, array('class' => 'form-control form-control-sm contract','readonly','id'=>'contractequipmentid')) }}
                                    @if ($errors->has('contractno'))
                                        <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <div class="row{{ $errors->has('contracttype') ? ' has-error' : '' }}"
                                 style="padding-top:5px;">
                                <label for="input" class="col-sm-4 col-form-label text-muted">Contract Type</label>
                                <div class="col-sm-6">
                                    {{ Form::text('contracttype', null, array('id'=>'contracttypeid','placeholder'=>'AMC/Short-Term','class' => 'form-control form-control-sm','readonly')) }}
                                    @if ($errors->has('contracttype'))
                                        <span class="help-block"><strong>{{ $errors->first('contracttype') }}</strong></span>
                                    @endif
                                </div>
{{--                                <div class="col-sm-2" style="padding-left:10px;">--}}
{{--                                    <a class="btn btn-blue" data-toggle="modal" data-target=".bs-example-modal-lg" onclick="excelDiv()" style="background-color: transparent; outline:none; border: none;"> <i class="fa fa-file-excel-o" style='font-size:24px'></i></a>--}}
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
                            <div id="addrow" class="row col-md-12">
                                <div class="form-group col-md-2" ><label for="inputEmail4">Branch Name</label>
                                    {{ Form::select('branchcode[]',array('placeholder' => '---SELECT---'),null, array('required' => 'required', 'id' => 'equipementbranchid','style'=>'width:200')) }}
                                </div>
                                <div class="form-group col-md-2" style="padding-left:15px;"><label for="inputPassword4">Product Name</label>
                                    {{ Form::select('eqipmentproductservice[]',array('placeholder' => '---SELECT---'),null, array('required' => 'required', 'id' => 'productid_0','onchange' => 'getcategory(0); return false;','style'=>'width:200')) }}
                                </div>
                                <div class="form-group col-md-2" ><label for="inputPassword4">Category Name</label>
                                    {{ Form::select('categorycode[]',array('placeholder' => '---SELECT---'),null, array('required' => 'required', 'id' => 'categoryid_0','style'=>'width:200')) }}
                                </div>
                                <div class="form-group col-md-2" ><label for="inputPassword4">Equipment Sr
                                        No</label>{{ Form::text('equipmentsrno[]', null, array('placeholder'=>'equipmentsrno','class' => 'form-control form-control-sm','required' => 'required','id'=>'equipmentsrnoid','style'=>'width:250')) }}
                                </div>
{{--                                added--}}
                                <div class="form-group col-md-2" ><label for="inputPassword4">Product Sr
                                        No</label>{{ Form::text('productsrno[]', null, array('placeholder'=>'productsrno','class' => 'form-control form-control-sm','required' => 'required','id'=>'productsrnoid','style'=>'width:250')) }}
                                </div>
                                <div class="form-group col-md-2" ><label for="inputPassword4">Specification</label>{{ Form::text('specification[]', null, array('placeholder'=>'specification','class' => 'form-control form-control-sm','required' => 'required','specificationid','style'=>'width:200')) }}
                                </div>
                            </div>
                            <br/>
                            <div id="addrow" class="row col-md-12">
                            </div>
                            <div class="row mt-12" style="padding-top: 65px;">
                                <div class="col-md-2">  <input href="javascript:void(0);" type="image" src="{{asset('img/plus.jpg')}}"
                                                               style="height: 20px; width: 20px;"
                                                               onclick="addequipmentwisediv(); return false;"></input></div>
                                <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                                <br>
                                <br>

                                <div class="row col-md-12" style="margin-left:600px;">
                                    <div class="col-md-2">
                                        {{ Form::submit('Add', array('id'=>'btnaddid','class' => 'btn btn-primary offset-4')) }}
                                    </div>
                                    <div class="col-md-2">
                                        {{ Form::submit('Submit', array('id'=>'btnsavecloseid','class' => 'btn btn-primary offset-4')) }}
                                    </div>
                                </div>
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
                                        {{ Form::select('eqipmentproductserviceupload',array('placeholder' => '---SELECT---'),null, array('class' => 'form-control form-control-md','required' => 'required', 'id' => 'productiduploadid','onchange' => 'getcategory(0); return false;')) }}
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
{{--                --    --}}




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
                {{ Form::hidden('contractno', null, array('id' => 'billingcontractid')) }}

                <div class="row mt-1">
                    <label class="col-sm-1 col-form-label text-muted">Contract No.</label>
                    <div class="col-sm-2">
                        {{ Form::text('contractnodisplay', null, array('class' => 'form-control form-control-sm contract','readonly','id'=>'billingcontractdisplayid')) }}
                    </div>
                    <label class="col-sm-1 col-form-label text-muted">Total Amount</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control form-control-sm" id="totalcontractamountdisplay" readonly>
                    </div>
                    <label class="col-sm-1 col-form-label text-muted">Total Paid</label>
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
                            <th width="12%">Estimated Billing Date</th>
                            <th width="12%">Actual Bill Date</th>
                            <th width="10%">Bill Number</th>
                            <th width="12%">Bill Paid Amount</th>
                            <th width="12%">Bill Payment Date</th>
                            <th width="12%">Next Payment Reminder</th>
                            <th width="12%">Running Total</th>
                            <th width="12%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="billingcyclesbody">
                        <!-- Rows are added dynamically via JS. Table starts empty. -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"><b>Total Paid</b></td>
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
                






                


                <div class="tab-pane fade" role="tabpanel" id="payment-term-tab" aria-labelledby="paymentterms" style="margin-left: 250px;">
                    <div class="container">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Payment Terms</h3>
                            </div>
                            <div class="panel-body">
                                {{Form::open(array('action' => 'ContractController@addPaymentTerms','method' => 'get', 'id' => 'paymentdetailstermsform'))}}
                                {{ Form::hidden('paymentworkorder',null, array('id' => 'paymentworkorderid')) }}
                                <div class="row{{ $errors->has('contractno') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Contract No.</label>
                                    <div class="col-sm-6">
                                        {{ Form::text('contractno', null, array('class' => 'form-control form-control-sm contract','readonly','id'=>'paymentcontractid')) }}
                                        @if ($errors->has('contractno'))
                                            <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('securitydeposit') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Security Deposit (SD)</label>
                                    <div class="col-sm-6">
                                        {{ Form::number('securitydeposit', null, array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('securitydeposit'))
                                            <span class="help-block"><strong>{{ $errors->first('securitydeposit') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('sbpaymentperiod') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">SD Payment Period (days)</label>
                                    <div class="col-sm-6">
                                        {{ Form::number('sbpaymentperiod', null, array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('sbpaymentperiod'))
                                            <span class="help-block"><strong>{{ $errors->first('sbpaymentperiod') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('admincharges') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Admin Charges (BG)</label>
                                    <div class="col-sm-6">
                                        {{ Form::number('admincharges', null, array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('admincharges'))
                                            <span class="help-block"><strong>{{ $errors->first('admincharges') }}</strong></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('facilitycharges') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Facility Charges</label>
                                    <div class="col-sm-6">
                                        {{ Form::number('facilitycharges', null, array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('facilitycharges'))
                                            <span class="help-block"><strong>{{ $errors->first('facilitycharges') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('paymentintervalforamc') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Payment Interval For AMC </label>
                                    <div class="col-sm-6">
                                        {{ Form::select('paymentintervalforamc',array(null => '--SELECT--'),null, array( 'id' => 'paymentintervalforamcid', 'rel' => URL::to('/'))) }}
                                        @if ($errors->has('paymentintervalforamc'))
                                            <span class="help-block"><strong>{{ $errors->first('paymentintervalforamc') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('customeriniatedbilling') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Iniated Billing </label>
                                    <div class="col-sm-6">
                                        {{ Form::select('customeriniatedbilling',array('YES'=>'YES','NO'=>'NO'),null, array('class'=>'form-control form-control-sm','placeholder' => '--SELECT--')) }}
                                        @if ($errors->has('customeriniatedbilling'))
                                            <span class="help-block"><strong>{{ $errors->first('customeriniatedbilling') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div id="hiddensuppledivid">

                                    <div class="row{{ $errors->has('firstpaymentpercent') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">First payment percent</label>
                                        <div class="col-sm-6">
                                            {{ Form::number('firstpaymentpercent', null, array('class' => 'form-control form-control-sm')) }}
                                            @if ($errors->has('firstpaymentpercent'))
                                                <span class="help-block"><strong>{{ $errors->first('firstpaymentpercent') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('firstpaymentcriteria') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">First Payment Criteria</label>
                                        <div class="col-sm-6">

                                            {{ Form::select('firstpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),null, array('placeholder' => '--SELECT--','class' => 'selectize')) }}
{{--                                            {{ Form::number('firstpaymentcriteria', null, array('class' => 'form-control form-control-sm')) }}--}}
                                            @if ($errors->has('firstpaymentcriteria'))
                                                <span class="help-block"><strong>{{ $errors->first('firstpaymentcriteria') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('secondpaymentpercent') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Second Payment Percent</label>
                                        <div class="col-sm-6">
                                            {{ Form::number('secondpaymentpercent', null, array('class' => 'form-control form-control-sm')) }}
                                            @if ($errors->has('secondpaymentpercent'))
                                                <span class="help-block"><strong>{{ $errors->first('secondpaymentpercent') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('secondpaymentcriteria') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Second Payment Criteria</label>
                                        <div class="col-sm-6">
{{--                                            {{ Form::number('secondpaymentpercent', null, array('class' => 'form-control form-control-sm')) }}--}}
                                            {{ Form::select('secondpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),null, array('placeholder' => '--SELECT--','class' => 'selectize')) }}
                                            @if ($errors->has('secondpaymentcriteria'))
                                                <span class="help-block"><strong>{{ $errors->first('secondpaymentcriteria') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('thirdpaymentpercent') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Third Payment Percent</label>
                                        <div class="col-sm-6">
                                            {{ Form::number('thirdpaymentpercent', null, array('class' => 'form-control form-control-sm')) }}
                                            @if ($errors->has('thirdpaymentpercent'))
                                                <span class="help-block"><strong>{{ $errors->first('thirdpaymentpercent') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('thirdpaymentcriteria') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Third Payment Criteria</label>
                                        <div class="col-sm-6">
                                            {{ Form::select('thirdpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),null, array('placeholder' => '--SELECT--','class' => 'selectize')) }}
                                            @if ($errors->has('thirdpaymentcriteria'))
                                                <span class="help-block"><strong>{{ $errors->first('thirdpaymentcriteria') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('fourthpaymentpercent') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Fourth Payment Percent</label>
                                        <div class="col-sm-6">
                                            {{ Form::number('fourthpaymentpercent', null, array('class' => 'form-control form-control-sm')) }}
                                            @if ($errors->has('fourthpaymentpercent'))
                                                <span class="help-block"><strong>{{ $errors->first('fourthpaymentpercent') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('fourthpaymentcriteria') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Fourth Payment Criteria</label>
                                        <div class="col-sm-6">
                                            {{ Form::select('fourthpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),null, array('placeholder' => '--SELECT--','class' => 'selectize')) }}
                                            @if ($errors->has('fourthpaymentcriteria'))
                                                <span class="help-block"><strong>{{ $errors->first('fourthpaymentcriteria') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('fifthpaymentpercent') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Fith Payment Percent</label>
                                        <div class="col-sm-6">
                                            {{ Form::number('fifthpaymentpercent', null, array('class' => 'form-control form-control-sm')) }}
                                            @if ($errors->has('fifthpaymentpercent'))
                                                <span class="help-block"><strong>{{ $errors->first('fifthpaymentpercent') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row{{ $errors->has('fifthpaymentcriteria') ? ' has-error' : '' }} mt-1">
                                        <label for="input" class="col-sm-4 col-form-label text-muted">Fith Payment Criteria</label>
                                        <div class="col-sm-6">
                                            {{ Form::select('fifthpaymentcriteria',array('Installation Date'=>'Installation Date','Commisioning Date'=>'Commisioning Date','Contract Expiry Date'=>'Contract Expiry Date'),null, array('placeholder' => '--SELECT--','class' => 'selectize')) }}
                                            @if ($errors->has('fifthpaymentcriteria'))
                                                <span class="help-block"><strong>{{ $errors->first('fifthpaymentcriteria') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <div class="row{{ $errors->has('leaddaysforpayment') ? ' has-error' : '' }} mt-1">
                                    <label for="input" class="col-sm-4 col-form-label text-muted">Lead Days For Payment</label>
                                    <div class="col-sm-6">
                                        {{ Form::number('leaddaysforpayment', null, array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('leaddaysforpayment'))
                                            <span class="help-block"><strong>{{ $errors->first('leaddaysforpayment') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <label for="input" class="col-sm-4 col-form-label-sm text-muted"></label>
                                    <div class="col-sm-6">
                                        {{ Form::submit('Save & Close', array('class' => 'btn btn-primary','id'=>'paymentsubmitid')) }}
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>

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
function addBillingCycleRow() {
    var newRow = '<tr class="billing-cycle-row">' +
        '<td class="cycle-no"></td>' +
        '<td><input type="date" name="estimatedbillingdate[]" class="form-control form-control-sm" max="2050-12-31"></td>' +
        '<td><input type="date" name="actualbilldate[]" class="form-control form-control-sm" max="2050-12-31"></td>' +
        '<td><input type="text" name="billnumber[]" class="form-control form-control-sm"></td>' +
        '<td><input type="text" name="billpaidamount[]" class="form-control form-control-sm bill-paid-amount" onkeyup="validateBillTotal();"></td>' +
        '<td><input type="date" name="billpaymentdate[]" class="form-control form-control-sm bill-payment-date" max="2050-12-31"></td>' +
        '<td><input type="date" name="nextreminderdate[]" class="form-control form-control-sm next-reminder-date" max="2050-12-31"></td>' +
        '<td class="row-running-total">0.00</td>' +
        '<td><button type="button" class="btn btn-danger btn-xs" onclick="removeBillingCycleRow(this);">Remove</button></td>' +
        '</tr>';

    $('#billingcyclesbody').append(newRow);
    renumberBillingRows();
    validateBillTotal();
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
                    var row = '<tr class="billing-cycle-row">' +
                        '<td class="cycle-no"></td>' +
                        '<td><input type="date" name="estimatedbillingdate[]" class="form-control form-control-sm" value="' + (cycle.estimatedbillingdate || '') + '" max="2050-12-31"></td>' +
                        '<td><input type="date" name="actualbilldate[]" class="form-control form-control-sm" value="' + (cycle.actualbilldate || '') + '" max="2050-12-31"></td>' +
                        '<td><input type="text" name="billnumber[]" class="form-control form-control-sm" value="' + (cycle.billnumber || '') + '"></td>' +
                        '<td><input type="text" name="billpaidamount[]" class="form-control form-control-sm bill-paid-amount" value="' + (cycle.billpaidamount || '') + '" onkeyup="validateBillTotal();"></td>' +
                        '<td><input type="date" name="billpaymentdate[]" class="form-control form-control-sm bill-payment-date" value="' + (cycle.billpaymentdate || '') + '" max="2050-12-31"></td>' +
                        '<td><input type="date" name="nextreminderdate[]" class="form-control form-control-sm next-reminder-date" value="' + (cycle.nextreminderdate || '') + '" max="2050-12-31"></td>' +
                        '<td class="row-running-total">0.00</td>' +
                        '<td><button type="button" class="btn btn-danger btn-xs" onclick="removeBillingCycleRow(this);">Remove</button></td>' +
                        '</tr>';
                    $('#billingcyclesbody').append(row);
                });
                renumberBillingRows();
            } else {
                addBillingCycleRow(); // start with one blank row if nothing saved yet
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
            $('#billingcontractid').val(contractno);
            $('#billingcontractdisplayid').val(contractno);
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
                    $('#paymentterms').click();
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
    
    // Load existing documents if contract exists
    var contractno = $('#contractsavedid').val();
    if (contractno && contractno != '0') {
        loadDocuments(contractno);
    }
});

function uploadMultipleDocuments(files) {
    var contractno = $('#contractsavedid').val();
    
    if (!contractno || contractno == '0') {
        alert('Please save the contract first before uploading documents.');
        $('#multi-files').val('');
        return false;
    }
    var subtype = 'new_contract';
    
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
                loadDocuments(contractno);
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

// function loadDocuments(contractno) {
//     $.ajax({
//         url: '{{ url("get-contract-documents") }}/' + contractno,
//         type: 'GET',
//         success: function(response) {
//             if (response.success && response.documents) {
//                 var docs = response.documents;
//                 updateDocDisplay('doc1', docs.doc1, contractno);
//                 updateDocDisplay('doc2', docs.doc2, contractno);
//                 updateDocDisplay('doc3', docs.doc3, contractno);
//             }
//         }
//     });
// }


function loadDocuments(contractno) {
    $.ajax({
        url: '{{ url("get-contract-documents") }}/' + contractno,
        type: 'GET',
        cache: false,
        success: function(response) {
            if (response.success && response.documents) {
                // Get the new_contract subtype documents
                var docs = response.documents.new_contract;
                if (docs) {
                    updateDocDisplay('doc1', docs.doc1, contractno);
                    updateDocDisplay('doc2', docs.doc2, contractno);
                    updateDocDisplay('doc3', docs.doc3, contractno);
                } else {
                    // Hide all rows if no documents
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
        
        // View button - opens in new tab
        actions += '<a href="' + viewUrl + '" target="_blank" class="btn btn-info btn-xs" title="View">';
        actions += '<i class="glyphicon glyphicon-eye-open"></i> View</a> ';
        
        // Download button
        actions += '<a href="' + downloadUrl + '" class="btn btn-success btn-xs" title="Download">';
        actions += '<i class="glyphicon glyphicon-download-alt"></i> Download</a> ';
        
        // Delete button
        actions += '<button class="btn btn-danger btn-xs" onclick="deleteDocument(\'' + docField + '\')" title="Delete">';
        actions += '<i class="glyphicon glyphicon-trash"></i> Delete</button>';
        
        // Show file type icon
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
    
    var contractno = $('#contractsavedid').val();
    
    $.ajax({
        url: '{{ url("delete-contract-document") }}',
        type: 'POST',
        data: {
            contractno: contractno,
            doc_field: docField,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                $('#' + docField + '-row').hide();
                $('#upload-status').html('<div class="alert alert-success">Document removed successfully</div>');
                setTimeout(function() {
                    $('#upload-status').fadeOut();
                }, 2000);
            } else {
                alert('Failed to remove document: ' + response.message);
            }
        },
        error: function() {
            alert('Error removing document');
        }
    });
}

function updateProgress(percent) {
    $('#upload-progress .progress-bar').css('width', percent + '%').text(Math.round(percent) + '%');
}
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
            $('#branchequipement').selectize({
                maxItems: 1
            });
            $('#productquipement').selectize({
                maxItems: 1
            });
            $('#workordertypeid').selectize({
                maxItems: 1
            });
            $('#comprehensiveid').selectize({
                maxItems: 1
            });

            $('.selectize').selectize({
                maxItems: 1
            });

            $('#contract').click(function (event) {
                $("#contractbtn").attr("disabled",false);
            });
            $('#contract-site-master').click(function (event) {
                $("#branchformbtn").attr("disabled",false);
                if (!checkifcontractnoisavailable())
                    return false;
            });
            $('#contract-site-contact-master').click(function (event) {
                $("#sitecontactbtn").attr("disabled",false);
                if (!checkifcontractsiteissaved())
                    return false;
            });
            $('#contract-details').click(function (event) {
                $("#contractdetailsbtn").attr("disabled",false);
                if (!checkifcontractsiteissaved())
                    return false;
                else{
                    var contractno = $('#contractnositid').val();
                    $('#contractdetailscontractid').val(contractno);
                }
            });
            $('#equipment').click(function (event) {
                $("#btnsavecloseid").attr("disabled",false);
                if (!checkifcontractequipmentissaved())
                    return false;
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#paymentterms').click(function (event) {
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

                $('#categoryid_0').selectize()[0].selectize.destroy();
                $('#categoryid_0').selectize({
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
        function calculategross(quantity, rate, period, sgstrate, sgstamt, cstrate, cgstamt, taxrate, taxamt, grossrate, totaltaxamt, count) {
            if (quantity != "") {

                // var calculatedtax = rate * taxrate / 100;
                // var rateplustax = parseFloat(rate) + parseFloat(calculatedtax);
                // var tax = rate * taxrate / 100;
                // tax = tax.toFixed(2);
                // var calsgstamt = rate * sgstrate / 100;
                // var calcgstamt = rate * cstrate / 100;
                // var totaltax =  parseFloat(calsgstamt) + parseFloat(calcgstamt) + parseFloat(tax);
                // totaltax = totaltax.toFixed(2);
                // var calgrossrate = parseFloat(rate) + parseFloat(totaltax);
                // var test = parseFloat(quantity) * calgrossrate;
                // var year = period / 12;
                // var caltotalcost = test * year;
                // caltotalcost = caltotalcost.toFixed(2);



                var calculatedtax = rate * taxrate / 100;
                var rateplustax = parseFloat(rate) + parseFloat(calculatedtax);

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


                if (taxrate != 0) {
                    grossrate.val(caltotalcost);
                }
                else {
                    grossrate.val(caltotalcost);
                }

                taxamt.val(tax);
                sgstamt.val(calsgstamt);
                cgstamt.val(calcgstamt);
                totaltaxamt.val(totaltax);

            }
            else {
                grossrate.val('0');
                taxamt.val('0');
                sgstamt.val('0');
                cgstamt.val('0');
                totaltaxamt.val('0');

            }

        }
        function getarray(data) {
            var array = [];

            $.each(data, function (index, value) {
                array.push(value.value);
            });

            return array;
        }
        function addcontractsitemastersdiv() {
            var count = $('#contractsitemastercount').val();
            var id = $('#contractsitemastercount').val();

            var wrapper = $('#addcontractsitemaster');
            var addButton = $('#addcontractsitemastersdiv');
            var appendtags = '<div><a  href="javascript:void(0);" class="remove_button" title="Remove field"><img src="{{asset('img/cancel-512.png')}}" style="height: 20px; width: 20px; margin-left:910px;"/></a><div class="panel col-md-12" style="border: silver 1px solid;"><div class="panel-body">{{ Form::hidden('contractsitemaster[]', '0',array('class'=>'contractsitemasterclass')) }} <div class="row mt-1">' +
                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name</label> <div class="col-sm-6"> ' +
                '{{ Form::text('branchname[]', null, array('class' => 'form-control form-control-sm', 'id' => 'branchid','required' => 'required')) }} </div> </div> ' +
                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Fax</label> <div class="col-sm-6"> ' +
                '{{ Form::number('fax[]', null, array('class' => 'form-control form-control-sm', 'id'=>'faxid','onKeyPress'=>'if(this.value.length==11) return false;')) }}</div></div>' +

                ' <div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Phone</label> <div class="col-sm-6">' +
                ' {{ Form::number('phone[]', null, array('class' => 'form-control form-control-sm', 'id'=>'phoneid','onKeyPress'=>'if(this.value.length==11) return false;','required' => 'required')) }}</div></div>' +

                ' <div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">email</label> <div class="col-sm-6">' +
                ' {{ Form::email('email[]', null, array('class' => 'form-control form-control-sm', 'id'=>'branchemailid_%id%','required' => 'required','onchange'=>'validemail(%count%);return false;')) }} </div></div>'.replace('%id%', id).replace('%count%', count) +
                '</div></div>';

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
            $('#contractsitemastercount').val(count);

        }
        function addcontractsitcontactemastersdiv() {
            var count = $('#contractsitecontactmasterdivcount').val();
            var id = $('#contractsitecontactmasterdivcount').val();
            var wrapper = $('#addcontractsitecontactmaster');
            var addButton = $('#addcontractsitcontactemastersdiv');
            var appendtags = '<div><a  href="javascript:void(0);" class="remove_button" title="Remove field"><img src="{{asset('img/cancel-512.png')}}" style="height: 20px; width: 20px; margin-left:910px;"/></a><div class="panel col-md-12" style="border: silver 1px solid;"><div class="panel-body">{{ Form::hidden('contractsitecontact[]', '0',array('class'=>'contractsitecontactclass')) }} <div class="row mt-1"> ' +
                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name</label> <div class="col-sm-6"> ' +
                '{{ Form::select('branchcode[]',array('placeholder' => '---SELECT---'),null, array('required' => 'required', 'id' => 'partialbranchid_%count%')) }} </div> </div>'.replace('%count%', count) +
                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Branch Person Name</label> <div class="col-sm-6"> ' +
                '{{ Form::text('contactpersonname[]', null, array('class' => 'form-control form-control-sm','required' => 'required')) }} </div> </div> ' +
                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Fax</label> <div class="col-sm-6"> ' +
                '{{ Form::number('fax[]', null, array('class' => 'form-control form-control-sm', 'id'=>'faxid','onKeyPress'=>'if(this.value.length==11) return false;')) }}</div></div>' +
                ' <div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Phone</label> <div class="col-sm-6">' +
                ' {{ Form::number('phone[]', null, array('class' => 'form-control form-control-sm', 'id'=>'phoneid','onKeyPress'=>'if(this.value.length==11) return false;','required' => 'required')) }}</div></div>' +
                ' <div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">email</label> <div class="col-sm-6">' +
                ' {{ Form::email('emailid[]', null, array('class' => 'form-control form-control-sm', 'id'=>'contactbranchid_%count%','required' => 'required','onchange'=>'validebranchcontactmail(%id%);')) }} </div></div>'.replace('%count%', count).replace('%id%', id) +
                '</div></div>';

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
            var addButton = $('#addequipmentdiv');
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
            var totaltax = "$('#totaltaxamt%count%')".replace("%count%", count);
            var grossrate = "$('#totalcontractcost%count%')".replace("%count%", count);

            var appendtags = '<br/><div><a  href="javascript:void(0);" class="remove_button" title="Remove field"><img src="{{asset('img/cancel-512.png')}}" style="height: 20px; width: 20px; margin-left:910px;"/></a><div class="panel col-md-12" style="border: silver 1px solid;"><div class="panel-body">{{ Form::hidden('contractdetailssaveid[]', '0',array('class'=>'cotractdetailssaveidclass')) }} <div class="row mt-1"> ' +
                '<label for="input" class="col-sm-4 col-form-label text-muted">Equipment Type</label> <div class="col-sm-4"> ' +
                '{{ Form::select('productservice[]', $productservice, null, array('required' => 'required','placeholder' => '--SELECT--', 'id' => 'productservice%count%')) }} </div> </div> '.replace('%count%', count) +
                '<div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Quantity (A)</label> <div class="col-sm-4"> ' +
                '{{ Form::text('quantity[]', null, array('required' => 'required','class' => 'form-control form-control-sm', 'id' => 'quantity%count%', 'onkeyup')) }} </div> </div> '.replace('%count%', count).replace('onkeyup', "onkeyup = calculategross(" + quantity + "," + rate + "," + period + "," + sgstrate + "," + sgstamt + "," + cgstrate + "," + cgstamt + "," + taxrate + "," + taxamt + "," + grossrate + "," + totaltax + "); return false;") +
                '<div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Rate (B)</label> <div class="col-sm-4"> ' +
                '{{ Form::text('rate[]', null, array('required' => 'required','class' => 'form-control form-control-sm', 'id'=>'rate%count%', 'onkeyup')) }}</div></div>'.replace('%count%', count).replace('onkeyup', "onkeyup = calculategross(" + quantity + "," + rate + "," + period + "," + sgstrate + "," + sgstamt + "," + cgstrate + "," + cgstamt + "," + taxrate + "," + taxamt + "," + grossrate + "," + totaltax + "); return false;") +

                ' <div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">HSN Code </label> <div class="col-sm-4">' +
                ' {{ Form::text('hsncode[]', null, array('class' => 'form-control form-control-sm', 'id'=>'hsncode%count%')) }} </div> </div>'.replace('%count%', count) +

                ' <div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Warranty / AMC Period (C)</label> <div class="col-sm-4">' +
                ' {{ Form::text('warranty_amc_period[]', null, array('required' => 'required','class' => 'form-control form-control-sm', 'id'=>'warranty_amc_period%count%', 'onkeyup')) }}</div><div class="col-md-2">Months</div> </div>'.replace('%count%', count).replace('onkeyup', "onkeyup = calculategross(" + quantity + "," + rate + "," + period + "," + sgstrate + "," + sgstamt + "," + cgstrate + "," + cgstamt + "," + taxrate + "," + taxamt + "," + grossrate + "," + totaltax + "); return false;") +

                ' <div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Tax Rate</label> <div class="col-sm-4">' +
                ' {{ Form::text('taxrate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'taxrate%count%', 'onkeyup')) }} </div><div class="col-md-2">%</div> </div>'.replace('%count%', count).replace('onkeyup', "onkeyup = calculategross(" + quantity + "," + rate + "," + period + "," + sgstrate + "," + sgstamt + "," + cgstrate + "," + cgstamt + "," + taxrate + "," + taxamt + "," + grossrate + "," + totaltax + "); return false;") +

                ' <div class="row"> <label for="input" class="col-sm-4 col-form-label text-muted">Tax Amt</label> <div class="col-sm-4">' +
                ' {{ Form::text('taxamt[]', null, array('class' => 'form-control form-control-sm', 'id'=>'taxamt%count%', 'readonly')) }} </div></div>'.replace('%count%', count) +

                ' <div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">SGST Rate</label> <div class="col-sm-4">' +
                ' {{ Form::text('sgstrate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'sgstrate%count%', 'onkeyup')) }} </div><div class="col-md-2">%</div>  </div>'.replace('%count%', count).replace('onkeyup', "onkeyup = calculategross(" + quantity + "," + rate + "," + period + "," + sgstrate + "," + sgstamt + "," + cgstrate + "," + cgstamt + "," + taxrate + "," + taxamt + "," + grossrate + "," + totaltax + "); return false;") +

                ' <div class="row" style="margin-top:3px;"><label for="input" class="col-sm-4 col-form-label text-muted">SGST Amt</label> <div class="col-sm-4"> ' +
                '{{ Form::text('sgstamt[]', null, array('class' => 'form-control form-control-sm', 'id'=>'sgstamt%count%', 'readonly')) }} </div> </div>'.replace('%count%', count) +

                ' <div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">CGST Rate</label> <div class="col-sm-4">' +
                ' {{ Form::text('cgstrate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'cgstrate%count%', 'onkeyup')) }} </div><div class="col-md-2">%</div> </div>'.replace('%count%', count).replace('onkeyup', "onkeyup = calculategross(" + quantity + "," + rate + "," + period + "," + sgstrate + "," + sgstamt + "," + cgstrate + "," + cgstamt + "," + taxrate + "," + taxamt + "," + grossrate + "," + totaltax + "); return false;") +
                ' <div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">CGST Amt</label> <div class="col-sm-4">' +
                ' {{ Form::text('cgstamt[]', null, array('class' => 'form-control form-control-sm', 'id'=>'cgstamt%count%', 'readonly')) }} </div> </div>'.replace('%count%', count) +

                ' <div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Total Tax (D)</label> <div class="col-sm-4">' +
                ' {{ Form::text('taxtotalamt[]', null, array('class' => 'form-control form-control-sm', 'id'=>'totaltaxamt%count%', 'readonly')) }} </div> </div>'.replace('%count%', count) +

                ' <div class="row" style="margin-top:3px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Total Cost (E = A * (B + D))</label> <div class="col-sm-4">' +
                ' {{ Form::text('totalcontractcost[]', null, array('class' => 'form-control form-control-sm', 'id'=>'totalcontractcost%count%', 'readonly')) }} </div> </div></div></div></div>'.replace('%count%', count);

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
        function addequipmentwisediv() {
            var count = $('#equipmentcount').val();
            var id = $('#equipmentcount').val();
            var wrapper = $('#addrow');
            var addButton = $('#addequipmentwisediv');
            var appendtagsequipement = '<div><a  href="javascript:void(0);" class="remove_button" title="Remove field"><img src="{{asset('img/cancel-512.png')}}" style="height: 20px; width: 20px; margin-left:910px;"/></a><div class="form-row"  style="border: silver 1px solid;">' +
                '{{ Form::hidden('equipmentdetailssavedid[]', '0' ,array('id'=>'countid','class'=>'contractequipmentclass')) }}' +
                '{{ Form::hidden('productcount','%count%',array('id'=>'productcount')) }}'.replace('%count%', count) +
                '<div class="form-group col-md-2" ><label for="inputEmail4">Branch Name</label>{{ Form::select('branchcode[]',array('placeholder' => '---SELECT---'),null, array('required' => 'required', 'id' => 'branchcodeid_%count%')) }}</div>'.replace('%count%', count) +
                '<div class="form-group col-md-2" style="padding-left:15px"><label for="inputPassword4">Product Name</label>{{ Form::select('eqipmentproductservice[]',array('placeholder' => '---SELECT---'),null, array('required' => 'required', 'id' => 'productid_%count%','onchange' => 'getcategory(%id%); return false;')) }}</div>'.replace('%count%', count).replace('%id%', id) +
                '<div class="form-group col-md-2" ><label for="inputPassword4">Category Name</label>{{ Form::select('categorycode[]',array('placeholder' => '---SELECT---'),null, array('required' => 'required', 'id' => 'categoryid_%id%')) }}</div>'.replace('%id%', id) +
                '<div class="form-group col-md-2" ><label for="inputPassword4">Equipment Sr No</label>{{ Form::text('equipmentsrno[]', null, array('placeholder'=>'equipmentsrno','class' => 'form-control form-control-sm','required' => 'required','id'=>'equipmentsrnoid')) }}</div>' +
                '<div class="form-group col-md-2" ><label for="inputPassword4">Product Sr No</label>{{ Form::text('productsrno[]', null, array('placeholder'=>'productsrno','class' => 'form-control form-control-sm','required' => 'required','id'=>'productsrnoid')) }}</div>' +
                '<div class="form-group col-md-2" ><label for="inputPassword4">Specification</label>{{ Form::text('specification[]', null, array('placeholder'=>'specification','class' => 'form-control form-control-sm','required' => 'required','specificationid')) }}</div>' +
                ' </div></div>';
            $('#addrow').append(appendtagsequipement);

            $(addButton).click(function () { //Once add button is clicked
                $(wrapper).append(appendtags); // Add field html
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
                url: "{{URL::to('uploadexcelpost')}}",
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
            $("#contractbtn").attr("disabled",true);
            $.ajax({
                type: "get",
                contentType: "application/json",
                url: "{{URL::to('addcontractmasterdata')}}",
                data: $("#contractmasterform").serialize(),
                dataType: "json",
                success: function (data) {
                    if (data != "Error") {
//                        document.getElementById('contractsavedid').value = data;
                        var contractno = data.code;
                        var customercode = data.customercode;
                        var contractperiod = data.contractperiod;
                        $('#contractnositid').val(contractno.replace(/"/g, ""));
                        $('#contractsitecustomerid').val(customercode.replace(/"/g, ""));
                        $('#contractequipmentcustomerid').val(customercode.replace(/"/g, ""));
                        $('#contractsavedid').val(contractno.replace(/"/g, ""));
                        for(var i=0; i < data.serviceparameter.length; i++)
                        {
                            if (data.serviceparameter[i] != undefined) {

                                $("#paymentintervalforamcid").append($("<option>" + "  " + +"</option>" + "<option value=" + data.serviceparameter[i].name + ">" + " " + data.serviceparameter[i].name + "</option>"));
                            }
                        }
                        $("#paymentintervalforamcid").selectize();


                        // $('#contract-site-master').click();
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
            $("#branchformbtn").attr("disabled",true);
            $.ajax({
                type: "get",
                contentType: "application/json",
                url: "{{URL::to('addnewcontractsitemaster')}}",
                data: $("#contractsitemaster").serialize(),
                dataType: "json",
                success: function (data) {
                    if (data != "Error") {
                        var test = data.contractcode;
                        $('#contractnositcontactid').val(test.replace(/"/g, ""));
                        $('#contract-site-contact-master').click();
                        $("#contractsitecontactbranchid").selectize();
                        $('#contractsitecontactbranchid')[0].selectize.destroy();
                        for (var i = 0; i < data.branchlist.length; i++) {
                            if (data.branchlist[i] != undefined) {
                                $("#contractsitecontactbranchid").append($("<option>" + "  " + +"</option>" + "<option value=" + data.branchlist[i].branchcode + ">" + " " + data.branchlist[i].branchname + "</option>"));
                                $('.contractsitemasterclass').val(data.branchlist[i].branchcode);
                            }
                        }
                        $("#contractsitecontactbranchid").selectize();
                        var abc = $("#contractsitecontactbranchid")[0].selectize;
                        abc.clear();
                    }
                    else {
                        alert('Try Again!!!!');
                    }
                }
            });
        });
        $("#contractsitecontactmaster").submit(function (e) {
            e.preventDefault();
            $("#sitecontactbtn").attr("disabled",true);
            $.ajax({
                type: "get",
                contentType: "application/json",
                url: "{{URL::to('addnewcontractsitecontactmaster')}}",
                data: $("#contractsitecontactmaster").serialize(),
                dataType: "json",
                success: function (data) {
                    if (data != "Error") {
                        var test = (data.contractcode);
                        $('#contractdetailscontractid').val(test.replace(/"/g, ""));
                        $('#contract-details').click();
                        for (var i = 0; i < data.contactbranchlist.length; i++) {
                            if (data.contactbranchlist[i] != undefined) {
//                                $('.contractsitecontactclass')[i].value = data.contactbranchlist[i].branchcontactcode;
                                $('.contractsitecontactclass').val(data.contactbranchlist[i].branchcontactcode);
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
            $("#contractdetailsbtn").attr("disabled",true);
            var acb = $("#contractdetailsform").serialize();
            $.ajax({
                type: "GET",
                contentType: "application/json",
                url: "{{URL::to('addnewcontractdetails')}}",
                data: $("#contractdetailsform").serialize(),
                dataType: "json",
                success: function (data) {
                    if (data != "Error") {

                        for (var i = 0; i < data.contractlist.length; i++) {

//                            $('.cotractdetailssaveidclass')[i].value = data.contractlist[i].contractno;
                            $('.cotractdetailssaveidclass').val(data.contractlist[i].contractno);
                        }

                        document.getElementById('contractdetailssaved').value = 'yes';
                        var test = data.contractcode;
                        var contracttype = data.contracttype.workordertype;
                        $('#contractequipmentid').val(test.replace(/"/g, ""));
                        $('#contracttypeid').val(contracttype.replace(/"/g, ""));
                        $('#paymentcontractid').val(test.replace(/"/g, ""));
                        $('#paymentworkorderid').val(contracttype.replace(/"/g, ""));
                        $('#equipment').click();
                        $("#equipementbranchid").selectize();
                        $('#equipementbranchid')[0].selectize.destroy();
                        for (var i = 0; i < data.branchlist.length; i++) {
                            if (data.branchlist[i] != undefined) {
                                $("#equipementbranchid").append($("<option>" + "  " + +"</option>" + "<option value=" + data.branchlist[i].branchcode + ">" + " " + data.branchlist[i].branchname + "</option>"));
                            }
                        }
                        $("#equipementbranchid").selectize();
                        var equipementbranchid = $("#equipementbranchid")[0].selectize;
                        equipementbranchid.clear();

                        if($('#contracttypeid').val() == "Software Maintenance")
                        {

                            $('#hiddensuppledivid').hide();
                        }
                        else
                        {
                            $('#hiddensuppledivid').show();
                        }

                        $("#productid_0").selectize();
                        $('#productid_0')[0].selectize.destroy();
                        for (var i = 0; i < data.equipment.length; i++) {
                            if (data.equipment[i] != undefined) {
                                $("#productid_0").append($("<option>" + "  " + +"</option>" + "<option value=" + data.equipment[i].productservicecode + ">" + " " + data.equipment[i].productservicename + "</option>"));
                            }
                        }
                        $("#productid_0").selectize();
                        var productid = $("#productid_0")[0].selectize;
                        productid.clear();
                    }
                    else {
                        alert('Try Again!!!!');
                    }
                }
            });
        });
        $("#btnaddid").click(function (e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                contentType: "application/json",
                url: "{{URL::to('addequipmentdetails')}}",
                data: $("#equipmentDetailsform").serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.errorInfo != undefined) {
                        alert(response.errorInfo[2]);
                    }
                    else {
                        for (var i = 0; i < response.equipmentslist.length; i++) {
                                $('.contractequipmentclass').val(response.equipmentslist[i].equipmentsrno);
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
                type: "GET",
                contentType: "application/json",
                url: "{{URL::to('addequipmentdetails')}}",
                data: $("#equipmentDetailsform").serialize(),
                dataType: "json",
                success: function (response) {
                    for (var i = 0; i < response.equipmentslist.length; i++) {
                            $('.contractequipmentclass').val(response.equipmentslist[i].equipmentsrno);
                    }
                    //$('#paymentterms').click();
                    $('#equipment-upload').click();
                }

            });
        });
        $("#paymentdetailstermsform").submit(function (e) {
            e.preventDefault();
            $("#paymentsubmitid").attr("disabled",true);
            $.ajax({
                type: "GET",
                contentType: "application/json",
                url: "{{URL::to('addnewpaymentterms')}}",
                data: $("#paymentdetailstermsform").serialize(),
                dataType: "json",
                success: function (data) {
                    if (data.errorInfo != undefined) {
                        alert(response.errorInfo[2]);
                    }
                    else
                    {
                        window.location.href = '{{URL::to('contracts')}}';
                    }

                }
            });
        });

        function getservicedate() {

            if ($("#contractfromdateid").val() != "") {
                $.ajax({
                    url: '{{ url('/getservicedate/{data}') }}/',
                    type: "GET",
                    dataType: "json",
                    data: {
                        contractfromdate: $("#contractfromdateid").val(),
                        servicefrequency: $('#servicefrequencyid').val(),
                    },
                    success: function (data) {

                        $('#servicedateid').val(data[0]['servicedate']);
                        $('#servicereminderdateid').val(data[0]['servicereminderdate']);
                    }
                });
            }

        }
        function getyear() {
            if ($("#contracttodateid").val() != "") {

                var tomorrow = new Date($('#contracttodateid').val());
                tomorrow.setDate(tomorrow.getDate() + 1);
                var month = tomorrow.getMonth() + 1;
                var year = tomorrow.getFullYear();
                var day = tomorrow.getDate();
                var contractfromdate = year+'-'+ month + '-' + day;
                $.ajax({
                    url: '{{ url('/getyear/{data}') }}/',
                    type: "GET",
                    dataType: "json",
                    data: {
                        fromdate: $('#contractfromdateid').val(),
                        todate: contractfromdate
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
        }
        function getclosuredate() {

            if ($("#closerdate").val() != "") {
                if ($("#contracttodateid").val() >= $("#closerdate").val()) {
                    alert('Closer date should  be greater than Contract To Date');
                    $("#closerdate").val('');
                }
            }
        }
        $("#workordertypeid").change(function () {
            if ($('#workordertypeid').val() == "Hardware AMC" ){

                    $("#customername").show();
                    $('#serviceid').show();

            }
            else if($('#workordertypeid').val() == "Hardware Warranty")
            {
                $('#serviceid').show();
                $("#customername").hide();
            }
            else
             {
                $("#customername").hide();
                $('#serviceid').hide();
             }
        });
        $(document).ready(function () {
            $("#customername").hide();

        });
    </script>
    <script type="text/javascript">

        document.getElementById("workorderdate").onblur = function () {
            ValidateDate('workorderdate', 2050, 'hi there your date is not good.')
        };
        document.getElementById("contractfromdateid").onblur = function () {
            ValidateDate('contractfromdateid', 2050, 'hi there your date is not good.')
        };
        document.getElementById("contracttodateid").onblur = function () {
            ValidateDate('contracttodateid', 2050, 'hi there your date is not good.')
        };
        document.getElementById("closerdateid").onblur = function () {
            ValidateDate('closerdateid', 2050, 'hi there your date is not good.')
        };
        document.getElementById("purchaseorderdateid").onblur = function () {
            ValidateDate('purchaseorderdateid', 2050, 'hi there your date is not good.')
        };


    </script>
    <script type="text/javascript">

        function checkEmail() {
            if ($('#customers').val() == "") {
                alert('Select Customer');
                return false;
            }
            if ($('#workordertypeid').val() == "") {
                alert('Select Workorder Type');
                return false;
            }
            if (($('#workordertypeid').val() == "Hardware AMC" || $('#workordertypeid').val() == "Hardware Warranty") && $('#servicefrequencyid').val() == "") {
                alert('Select Service Frequency');
                return false;
            }

            if ($('#workorderid').val() != "" || $('#purchaseorderid').val() != "") {
//                alert($('#workorderid').val() == ""  ? "select Workorder No" : 'select purchase order No');

                return true;
            } else {
                alert('All details of either Work Order or Purchase Order should be entered');
                return false;
            }


        }

        function validemail(id) {
            var email = $('#branchemailid_' + id).val();
            var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
            if (!email.match(reEmail)) {
                alert('Invalid Email Address');
                $('#branchemailid_' + id).val('');
                return false;
            }
            return true;
        }

        function validebranchcontactmail(id) {
            var email = $('#contactbranchid_' + id).val();
            var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
            if (!email.match(reEmail)) {
                alert('Invalid Email Address');
                $('#contactbranchid_' + id).val('');
                return false;
            }
            return true;
        }


        function chkvalidation() {
            if($('#productservice').val() != "")
            {
                if ($('#taxrate').val() != "" || $('#sgstrate').val() != "") {
//                alert($('#workorderid').val() == ""  ? "select Workorder No" : 'select purchase order No');
                    return true;
                } else {
                    alert('please insert the value between taxrate and sgstrate && cgstrat');
                    return false;
                }
            }
            else
            {
                alert('Select Equipment Type');
                return false;
            }
        }

    </script>




<script type="text/javascript">
// Equipment Upload Tab
$(document).ready(function() {
    $('#equipment-file-input').on('change', function(e) {
        var file = this.files[0];
        if (file) {
            uploadEquipmentDocument(file);
        }
    });

    // Load equipment doc when tab is clicked
    $('#equipment-upload').click(function() {
        var contractno = $('#contractsavedid').val();
        if (contractno && contractno != '0' && contractno != '') {
            loadEquipmentDocument(contractno);
        }
    });
});

function uploadEquipmentDocument(file) {
    var contractno = $('#contractsavedid').val();

    if (!contractno || contractno == '0' || contractno == '') {
        alert('Please save the contract first before uploading.');
        $('#equipment-file-input').val('');
        return false;
    }
    var subtype = 'equipment';

    var allowedTypes = [
        'application/pdf',
        'image/jpeg', 'image/jpg', 'image/png',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];
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
    formData.append('subtype', subtype);
    formData.append('contractno', contractno);
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

// function loadEquipmentDocument(contractno) {
//     $.ajax({
//         url: '{{ url("get-equipment-document") }}/' + contractno,
//         type: 'GET',
//         cache: false,
//         success: function(response) {
//             if (response.success && response.document && response.document.doc1) {
//                 updateEquipmentDocDisplay(response.document.doc1, contractno);
//             } else {
//                 $('#eqdoc1-row').hide();
//                 $('#eqdoc-empty-row').show();
//             }
//         }
//     });
// }


function loadEquipmentDocument(contractno) {
    $.ajax({
        url: '{{ url("get-equipment-document") }}/' + contractno,
        type: 'GET',
        cache: false,
        success: function(response) {
            if (response.success && response.document) {
                // Get the equipment subtype documents
                var docs = response.document.equipment;
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

    var contractno = $('#contractsavedid').val();

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