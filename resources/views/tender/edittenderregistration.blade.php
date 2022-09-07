@extends('layouts.appnew')

@section('pageTitle', 'Complaints')
@section('content')
    <div class="container card col-md-9">
        <div class="col card-block">
            <div class="tab-content">
                <div class="tab-pane fade active in" role="tabpanel" id="contract-tab" style="margin-left: 250px;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Edit Tender Registration</h3>
                        </div>
                        <div class="panel-body">
                            {{ Form::open(array('url' => 'edittenderregistration/'.$id,'files' => true)) }}

                            <div class="row{{ $errors->has('tenderno') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Tender No</label>
                                <div class="col-sm-6">
                                    {{ Form::text('tenderno', $tenderno, array('placeholder' => 'Tender No','required' => 'required', 'class' => 'form-control form-control-sm', 'readonly' => 'readonly')) }}
                                    @if ($errors->has('tenderno'))
                                        <span class="help-block"><strong>{{ $errors->first('tenderno') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('tenderdate') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Tender Date</label>
                                <div class="col-sm-6">
                                    {{ Form::date('tenderdate', $tenderdate, array('class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('tenderdate'))
                                        <span class="help-block"><strong>{{ $errors->first('tenderdate') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('organisationname') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Organisation Name</label>
                                <div class="col-sm-6">
                                    {{ Form::text('organisationname', $organisationname, array('class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('organisation'))
                                        <span class="help-block"><strong>{{ $errors->first('organisation') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('organisation') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Organisation Address</label>
                                <div class="col-sm-6">
                                    {{ Form::textarea('organisationaddress', $organisationaddress, array('placeholder' => 'Organisation Name', 'class' => 'form-control form-control-sm','rows'=>2)) }}
                                    @if ($errors->has('organisation'))
                                        <span class="help-block"><strong>{{ $errors->first('organisation') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('department') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Department</label>
                                <div class="col-sm-6">
                                    {{ Form::text('department', $department, array('placeholder' => 'Department','required' => 'required', 'class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('department'))
                                        <span class="help-block"><strong>{{ $errors->first('department') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('subject') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Subject</label>
                                <div class="col-sm-6">
                                    {{ Form::text('subject', $subject, array('placeholder' => 'Subject', 'class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('subject'))
                                        <span class="help-block"><strong>{{ $errors->first('subject') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('contactpersonname') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Contact Person Name</label>
                                <div class="col-sm-6">
                                    {{ Form::text('contactpersonname', $contactpersonname, array('placeholder' => 'Contact Person Name', 'class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('contactpersonname'))
                                        <span class="help-block"><strong>{{ $errors->first('contactpersonname') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('contactpersonmobileno') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Contact Person Mobile No</label>
                                <div class="col-sm-6">
                                    {{ Form::number('contactpersonmobileno', $contactpersonmobileno, array('placeholder' => 'Contact Person Mobile No', 'class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('contactpersonmobileno'))
                                        <span class="help-block"><strong>{{ $errors->first('contactpersonmobileno') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('contactpersonmobile2') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Contact No 2</label>
                                <div class="col-sm-6">
                                    {{ Form::number('contactpersonmobile2', $contactpersonmobile2, array('placeholder' => 'Contact Person Mobile No', 'class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('contactpersonmobile2'))
                                        <span class="help-block"><strong>{{ $errors->first('contactpersonmobile2') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('contactpersonmobile3') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Contact No 3</label>
                                <div class="col-sm-6">
                                    {{ Form::number('contactpersonmobile3', $contactpersonmobile3, array('placeholder' => 'Contact Person Mobile No', 'class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('contactpersonmobile3'))
                                        <span class="help-block"><strong>{{ $errors->first('contactpersonmobile3') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('contactpersonemailid') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Contact Person Email Id</label>
                                <div class="col-sm-6">
                                    {{ Form::email('contactpersonemailid', $contactpersonemailid, array('placeholder' => 'Contact Person Email Id', 'class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('contactpersonemailid'))
                                        <span class="help-block"><strong>{{ $errors->first('contactpersonemailid') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('paymentmode') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Mode of bid Submited </label>
                                <div class="col-sm-6">
                                    {{ Form::select('modeofbidsubmitted', array(''=>'--SELECT--','DD'=>'DD', 'Cash'=>'Cash', 'Online'=>'Online','NFT'=>'NFT' ), $modeofbidsubmitted, array('class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('paymentmode'))
                                        <span class="help-block"><strong>{{ $errors->first('paymentmode') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('empanelledwithvendor') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Empanelled With Vendor</label>
                                <div class="col-sm-6">
                                    {{ Form::select('empanelledwithvendor', array(''=>'--SELECT--','Yes'=>'Yes', 'No'=>'No'), $empanelledwithvendor, array('class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('empanelledwithvendor'))
                                        <span class="help-block"><strong>{{ $errors->first('empanelledwithvendor') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('bidtobesubmited') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Bid To Be Submited</label>
                                <div class="col-sm-6">
                                    {{ Form::select('bidtobesubmited', array(''=>'--SELECT--','YES'=>'YES', 'NO'=>'NO'), $bidtobesubmited, array('class' => 'form-control form-control-sm', 'id' => 'bidtobesubmittedid','onchange'=>'bidsubmittedysandno(); return false')) }}
                                    @if ($errors->has('bidtobesubmited'))
                                        <span class="help-block"><strong>{{ $errors->first('bidtobesubmited') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div id="maindiv">

                                <div class="row{{ $errors->has('documentreadandreviewed') ? ' has-error' : '' }}"
                                     style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Document Read And
                                        Reviewed</label>
                                    <div class="col-sm-6">
                                        {{ Form::select('documentreadandreviewed', array(''=>'--SELECT--','Yes'=>'Yes', 'No'=>'No'), $documentreadandreviewed, array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('documentreadandreviewed'))
                                            <span class="help-block"><strong>{{ $errors->first('documentreadandreviewed') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('queryenddate') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Query End Date</label>
                                    <div class="col-sm-6">
                                        {{ Form::datetimeLocal('queryenddate', $queryenddate, array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('queryenddate'))
                                            <span class="help-block"><strong>{{ $errors->first('queryenddate') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('querytocustomer') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Query To Customer</label>
                                    <div class="col-sm-6">
                                        {{ Form::textarea('querytocustomer', $querytocustomer, array('placeholder' => 'Query To Customer','class' => 'form-control form-control-sm', 'rows' => '2')) }}
                                        @if ($errors->has('querytocustomer'))
                                            <span class="help-block"><strong>{{ $errors->first('querytocustomer') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('customerresponse') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Customer Response</label>
                                    <div class="col-sm-6">
                                        {{ Form::textarea('customerresponse', $customerresponse, array('placeholder' => 'Customer Response','class' => 'form-control form-control-sm','rows' => '2')) }}
                                        @if ($errors->has('customerresponse'))
                                            <span class="help-block"><strong>{{ $errors->first('customerresponse') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('internalquery') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Internal Query</label>
                                    <div class="col-sm-6">
                                        {{ Form::textarea('internalquery', $internalquery, array('placeholder' => 'Internal Query','class' => 'form-control form-control-sm', 'rows' => '2')) }}
                                        @if ($errors->has('internalquery'))
                                            <span class="help-block"><strong>{{ $errors->first('internalquery') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('internalresponse') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Internal Response</label>
                                    <div class="col-sm-6">
                                        {{ Form::textarea('internalresponse', $internalresponse, array('placeholder' => 'Internal Response','class' => 'form-control form-control-sm', 'rows' => '2')) }}
                                        @if ($errors->has('internalresponse'))
                                            <span class="help-block"><strong>{{ $errors->first('internalresponse') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('prebidmeetingdate') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Pre Bid Meeting Date</label>
                                    <div class="col-sm-6">
                                        {{ Form::datetimeLocal('prebidmeetingdate', $prebidmeetingdate, array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('prebidmeetingdate'))
                                            <span class="help-block"><strong>{{ $errors->first('prebidmeetingdate') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('bidsubmissionstatus') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Pre Bid Meeting Attende</label>
                                    <div class="col-sm-6">
                                        {{ Form::select('premeetingattended', array(''=>'--SELECT--','YES'=>'YES', 'NO'=>'NO', 'Not Applicable'=>'Not Applicable'), $premeetingattended, array('class' => 'form-control form-control-sm', 'id' => 'bidsubmissionstatus')) }}
                                        @if ($errors->has('bidsubmissionstatus'))
                                            <span class="help-block"><strong>{{ $errors->first('bidsubmissionstatus') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('documentfee') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Document Fee</label>
                                    <div class="col-sm-6">
                                        {{ Form::number('documentfee', $documentfee, array('placeholder' => 'Document Fee', 'class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('documentfee'))
                                            <span class="help-block"><strong>{{ $errors->first('documentfee') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('earnestmoneydeposit') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Earnest Money Deposit</label>
                                    <div class="col-sm-6">
                                        {{ Form::number('earnestmoneydeposit', $earnestmoneydeposit, array('placeholder' => 'Earnest Money Deposit', 'class' => 'form-control form-control-sm','max' => '9999999999.99', 'min' => '0')) }}
                                        @if ($errors->has('earnestmoneydeposit'))
                                            <span class="help-block"><strong>{{ $errors->first('earnestmoneydeposit') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('ms_me') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">MS/ME</label>
                                    <div class="col-sm-6">
                                        {{ Form::select('ms_me', array(''=>'--SELECT--','YES'=>'YES', 'NO'=>'NO'), $ms_me, array('class' => 'form-control form-control-sm', 'id' => 'ms_me')) }}
                                        @if ($errors->has('ms_me'))
                                            <span class="help-block"><strong>{{ $errors->first('ms_me') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('bidsubmissionstatus') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Bid Submited Date</label>
                                    <div class="col-sm-6">
                                        {{ Form::datetimeLocal('bidsubmissiondate', $bidsubmissiondate , array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('bidsubmissionstatus'))
                                            <span class="help-block"><strong>{{ $errors->first('bidsubmissionstatus') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('bidsubmissionstatus') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Bid Submited Status</label>
                                    <div class="col-sm-6">
                                        {{ Form::select('bidsubmissionstatus', array(''=>'--SELECT--','In Progress'=>'In Progress', 'Submitted'=>'Submitted', 'Not Submitted'=>'Not Submitted'), $bidsubmissionstatus, array('class' => 'form-control form-control-sm', 'id' => 'bidsubmitedstatusid','onchange'=>'Corrigendumdiv(); return false;')) }}
                                        @if ($errors->has('bidsubmissionstatus'))
                                            <span class="help-block"><strong>{{ $errors->first('bidsubmissionstatus') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div id="divcorrigendumid">
                                    <div class="row{{ $errors->has('corrigendumnumber') ? ' has-error' : '' }}"
                                         style="padding: 3px">
                                        <label for="input" class="col-sm-3 col-form-label-sm text-muted">Corrigendum Number</label>
                                        <div class="col-sm-6">
                                            {{ Form::text('corrigendumnumber', $corrigendumnumber, array('placeholder' => 'Corrigendum Number', 'class' => 'form-control form-control-sm', 'id' => 'corrigendumnumber', 'onKeyPress' => 'showcorrigendumdiv()', 'onKeyUp' => 'showcorrigendumdiv()')) }}
                                            @if ($errors->has('corrigendumnumber'))
                                                <span class="help-block"><strong>{{ $errors->first('corrigendumnumber') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row{{ $errors->has('reasonforcorrigendum') ? ' has-error' : '' }}"
                                         style="padding: 3px"
                                         id="divreasonforcorrigendum">
                                        <label for="input" class="col-sm-3 col-form-label-sm text-muted">Reason For
                                            Corrigendum</label>
                                        <div class="col-sm-6">
                                            {{ Form::textarea('reasonforcorrigendum', $reasonforcorrigendum, array('placeholder' => 'Reason For Corrigendum', 'class' => 'form-control form-control-sm', 'rows' => '2')) }}
                                            @if ($errors->has('reasonforcorrigendum'))
                                                <span class="help-block"><strong>{{ $errors->first('reasonforcorrigendum') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row{{ $errors->has('extendeddate') ? ' has-error' : '' }}" style="padding: 3px">
                                        <label for="input" class="col-sm-3 col-form-label-sm text-muted">Extended Date</label>
                                        <div class="col-sm-6">
                                            {{ Form::datetimeLocal('extendeddate', $extendeddate, array('class' => 'form-control form-control-sm')) }}
                                            @if ($errors->has('extendeddate'))
                                                <span class="help-block"><strong>{{ $errors->first('extendeddate') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row{{ $errors->has('technicalbidopendate') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Technical Bid Open Date</label>
                                    <div class="col-sm-6">
                                        {{ Form::datetimeLocal('technicalbidopendate', $technicalbidopendate, array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('technicalbidopendate'))
                                            <span class="help-block"><strong>{{ $errors->first('technicalbidopendate') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('technicalbidstatus') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Technical Bid Status</label>
                                    <div class="col-sm-6">
                                        {{ Form::select('technicalbidstatus', array(''=>'--SELECT--','Selected'=>'Selected', 'Rejected'=>'Rejected', 'Postponed'=>'Postponed','Scrape'=>'Scrape'), $technicalbidstatus, array('class' => 'form-control form-control-sm', 'id' => 'technicalreasonid','onchange'=>'technicalreasondiv(); return false;')) }}
                                        @if ($errors->has('technicalbidstatus'))
                                            <span class="help-block"><strong>{{ $errors->first('technicalbidstatus') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('technicalbidrejectionreason') ? ' has-error' : '' }}"
                                     style="padding: 3px" id="divtechnicalbidrejectionreason">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Reason For Rejection In
                                        Technical
                                        Bid</label>
                                    <div class="col-sm-6">
                                        {{ Form::textarea('technicalbidrejectionreason', $reasonforrejectiontb, array('placeholder' => 'Reason For Rejection Of Technical Bid', 'class' => 'form-control form-control-sm', 'rows' => '2')) }}
                                        @if ($errors->has('technicalbidrejectionreason'))
                                            <span class="help-block"><strong>{{ $errors->first('technicalbidrejectionreason') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('newtechnicalbiddate') ? ' has-error' : '' }}" style="padding: 3px"
                                     id="newtechnicaldatediv">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">New Techical bid date</label>
                                    <div class="col-sm-6">
                                        {{ Form::datetimeLocal('newtechnicalbiddate', $newtechnicalbiddate, array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('technicalbidrejectionreason'))
                                            <span class="help-block"><strong>{{ $errors->first('technicalbidrejectionreason') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('commercialbidopendate') ? ' has-error' : '' }}"
                                     style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Commercial Bid Open
                                        Date</label>
                                    <div class="col-sm-6">
                                        {{ Form::datetimeLocal('commercialbidopendate', $commercialbidopendate, array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('commercialbidopendate'))
                                            <span class="help-block"><strong>{{ $errors->first('commercialbidopendate') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('commercialbidstatus') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Commercial Bid Status</label>
                                    <div class="col-sm-6">
                                        {{ Form::select('commercialbidstatus', array(''=>'--SELECT--','Selected'=>'Selected', 'Rejected'=>'Rejected', 'Postponed'=>'Postponed','Scrape'=>'Scrape'), $commercialbidstatus, array('class' => 'form-control form-control-sm', 'id' => 'commercialbidstatusid','onchange'=>'commercialbidstatusdiv(); return false;')) }}
                                        @if ($errors->has('commercialbidstatus'))
                                            <span class="help-block"><strong>{{ $errors->first('commercialbidstatus') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('newcommercialbiddate') ? ' has-error' : '' }}" style="padding: 3px"
                                     id="divnewcommercialbiddate">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">New Commercial Bid Date</label>
                                    <div class="col-sm-6">
                                        {{ Form::datetimeLocal('newcommercialbiddate', $newcommercialbiddate, array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('newcommercialbiddate'))
                                            <span class="help-block"><strong>{{ $errors->first('newcommercialbiddate') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('reasonforrejectionincommercialbid') ? ' has-error' : '' }}"
                                     style="padding: 3px" id="divreasonforrejectionincommercialbid">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Reason For Rejection In
                                        Commercial
                                        Bid</label>
                                    <div class="col-sm-6">
                                        {{ Form::textarea('reasonforrejectionincommercialbid', $reasonforrejectioncb, array('placeholder' => 'Reason For Commercial Of Technical Bid', 'class' => 'form-control form-control-sm', 'rows' => '2')) }}
                                        @if ($errors->has('reasonforrejectionincommercialbid'))
                                            <span class="help-block"><strong>{{ $errors->first('reasonforrejectionincommercialbid') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('workorderstartdate') ? ' has-error' : '' }}" style="padding: 3px"
                                     id="divworkorderstartdate">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Work Order Start Date</label>
                                    <div class="col-sm-6">
                                        {{ Form::datetimeLocal('workorderstartdate', $workorderstartdate, array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('workorderstartdate'))
                                            <span class="help-block"><strong>{{ $errors->first('workorderstartdate') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('workordernumber') ? ' has-error' : '' }}" style="padding: 3px"
                                     id="divworkordernumber">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">Work Order Number</label>
                                    <div class="col-sm-6">
                                        {{ Form::text('workordernumber', $workordernumber, array('placeholder' => 'Work Order Number', 'class' => 'form-control form-control-sm','id' => 'workordernumber', 'onKeyPress' => 'showworkorderdatediv()', 'onKeyUp' => 'showworkorderdatediv()')) }}
                                        @if ($errors->has('workordernumber'))
                                            <span class="help-block"><strong>{{ $errors->first('workordernumber') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('emdcollected') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">EMD Return Status</label>
                                    <div class="col-sm-6">
                                        {{ Form::select('emdstatus', array(''=>'--SELECT--','Yes'=>'Yes', 'No'=>'No'), $emdstatus, array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('emdcollected'))
                                            <span class="help-block"><strong>{{ $errors->first('emdcollected') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('emdreturndate') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">EMD Return Date</label>
                                    <div class="col-sm-6">
                                        {{ Form::datetimeLocal('emdreturndate', $emdreturndate, array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('emdreturndate'))
                                            <span class="help-block"><strong>{{ $errors->first('emdreturndate') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row{{ $errors->has('emdmode') ? ' has-error' : '' }}" style="padding: 3px">
                                    <label for="input" class="col-sm-3 col-form-label-sm text-muted">EMD Payment Mode</label>
                                    <div class="col-sm-6">
                                        {{ Form::select('emdmode', array(''=>'--SELECT--','DD'=>'DD', 'Cash'=>'Cash','Online'=>'Online','FD'=>'FD'), $emdmode, array('class' => 'form-control form-control-sm')) }}
                                        @if ($errors->has('emdmode'))
                                            <span class="help-block"><strong>{{ $errors->first('emdmode') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row{{ $errors->has('file') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Upload Tender Files</label>
                                <div class="col-sm-6">
                                    {{ Form::file('file[]',array('class'=>'form-control form-control-sm','multiple'=>true,'id'=>'uplodedfileid')) }}
                                </div>
                            </div>
                            <div class="row">
                                <label for="input" class="col-sm-3 col-form-label text-muted"></label>
                                <div class="col-sm-6">
                                    <br/>
                                    {{ Form::submit('Save & Close', array('class' => 'btn btn-primary')) }}
                                </div>
                            </div>

                            {{ Form::close() }}

                        </div>

                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Attached File</h3>
                        </div>
                        <table width="100%">
                            <tr>
                                <th width="10px">File Name</th>
                                <th width="10px">File Extesion</th>
                                <th width="10px">File Size</th>
                                <th width="10px">Attachment</th>
                                <th width="10px">Action</th>
                            </tr>
                            @foreach($filedetails as $file)
                                <tr>
                                    <td>{{$file->filename}}</td>
                                    <td>{{$file->fileextesion}}</td>
                                    <td>{{$file->filesize}}</td>
                                    <td> <a target="_blank" href={{asset('uploads/'.$file->filename)}}>Attachment</a></td>
                                    <td>
                                        <button type="button" class="btn btn" data-toggle="modal" data-target="#exampleModal" data-id="{{$file->id}}">Edit</button>
                                        {{--<a href="#" data-toggle="modal"  data-target=".bs-example-modal-lg"><b>Edit</b></a>--}}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="exampleModal">
        <div class="modal-dialog" role="document">
            {{ Form::open(array('url' => 'updatefileuploaded/'.$id,'files' => true)) }}
            <input type="hidden" name="hdid" id="_fileinputid">
            <input type="hidden" name="tenderno" value="{{$tenderno}}" >

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Edit File</h4>
                </div>
                <div class="modal-body">
                    <div class="row mt-1{{ $errors->has('subcategoryname') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">File Upload</label>
                        <div class="col-sm-6">
                            <input type="file" name="gallery"  id="image">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {{ Form::submit('submit', array('class' => 'btn btn-primary col-md-offset-9')) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>

@endsection
@section('page-script')
    <script>
        $(document).ready(function () {

//        Hide the divs on page load
            if ($('#bidtobesubmittedid').val() != 'YES') {

                $('#maindiv').hide();
            }

            if ($('#bidsubmitedstatusid').val() != 'Not Submitted') {

                $('#divcorrigendumid').hide();
            }
            if ($('#technicalreasonid').val() != 'Rejected') {
                $('#divtechnicalbidrejectionreason').hide();
            }
            if ($('#technicalreasonid').val() != 'Delayed') {
                $('#newtechnicaldatediv').hide();
            }
            if ($('#commercialbidstatusid').val() != 'Rejected') {
                $('#divreasonforrejectionincommercialbid').hide();
            }
            if ($('#commercialbidstatusid').val() != 'Delayed') {
                $('#divnewcommercialbiddate').hide();
            }


        });
        function Corrigendumdiv() {

            if ($('#bidsubmitedstatusid').val() == 'Not Submitted') {
                $('#divcorrigendumid').show();
            }
            else {
                $('#divcorrigendumid').hide();
            }
        }
        function technicalreasondiv() {

            if ($('#technicalreasonid').val() == 'Rejected') {
                $('#divtechnicalbidrejectionreason').show();
                $('#newtechnicaldatediv').hide();
            }
            else if($('#technicalreasonid').val() == 'Delayed')
            {
                $('#newtechnicaldatediv').show();
                $('#divtechnicalbidrejectionreason').hide();
            }
            else {
                $('#divtechnicalbidrejectionreason').hide();
                $('#newtechnicaldatediv').hide();
            }
        }
        function commercialbidstatusdiv() {
            if ($('#commercialbidstatusid').val() == 'Rejected') {
                $('#divreasonforrejectionincommercialbid').show();
                $('#divnewcommercialbiddate').hide();
            }
            else if ($('#commercialbidstatusid').val() == 'Delayed') {
                $('#divnewcommercialbiddate').show();
                $('#divreasonforrejectionincommercialbid').hide();
            }
            else
            {
                $('#divnewcommercialbiddate').hide();
                $('#divreasonforrejectionincommercialbid').hide();
            }

        }
        function bidsubmittedysandno() {

            if($('#bidtobesubmittedid').val()== "YES")
            {
                $('#maindiv').show();
            }
            else
            {
                $('#maindiv').hide();
            }
        }


    </script>
    <script type="text/javascript">
        $('#exampleModal').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes
            $('#_fileinputid').val(id);
        })
    </script>


    {{--<script type="text/javascript">--}}
        {{--$("#uplodedfileid").change(function () {--}}
            {{--debugger--}}
            {{--var filesize = this.files[0].size // On older browsers this can return NULL.--}}
            {{--var filesizeMB = (filesize / (1024*1024)).toFixed(2);--}}
            {{--if(filesizeMB <= 6) {--}}
                {{--return true;--}}
                {{--// Allow the form to be submitted here.--}}
            {{--} else {--}}
                {{--alert('file size max 6 mb');--}}
                {{--$("#uplodedfileid").val('');--}}
                {{--// Don't allow submission of the form here.--}}
            {{--}--}}
        {{--});--}}



    {{--</script>--}}
@endsection
