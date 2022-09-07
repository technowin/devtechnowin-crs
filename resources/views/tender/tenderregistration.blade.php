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
                            <h3 class="panel-title">Add Tender Registration</h3>
                        </div>
                        <div class="panel-body">
                            {{ Form::open(array('url' => 'newtenderregistration','files' => true)) }}
                            <div class="row{{ $errors->has('tenderno') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Tender No</label>
                                <div class="col-sm-6">
                                    {{ Form::text('tenderno', null, array('placeholder' => 'Tender No','required' => 'required', 'class' => 'form-control form-control-sm','required' => 'required', 'onKeyUp' => 'checktenderno();return false;', 'id' => 'tenderno')) }}
                                    <div id="showtendermessage">
                                        <font color="red"><h6>Tender No. already exists.</h6></font>
                                    </div>
                                    @if ($errors->has('tenderno'))
                                        <span class="help-block"><strong>{{ $errors->first('tenderno') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('tenderdate') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Tender Date</label>
                                <div class="col-sm-6">
                                    {{ Form::input('date','tenderdate',null,  array('class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('tenderdate'))
                                        <span class="help-block"><strong>{{ $errors->first('tenderdate') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('organisationname') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Organisation Name</label>
                                <div class="col-sm-6">
                                    {{--{{ Form::text('organisationname', null, array('placeholder' => 'Organisation Name','required' => 'required', 'class' => 'form-control form-control-sm','required' => 'required')) }}--}}
                                    {{Form::select('organisationname',$organisationname,null,array('placeholder' => '--SELECT--','id'=>'organisationnameid') )}}
                                    @if ($errors->has('organisationname'))
                                        <span class="help-block"><strong>{{ $errors->first('organisationname') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('organisationaddress') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Organisation Address</label>
                                <div class="col-sm-6">
                                    {{ Form::textarea('organisationaddress',null , array('placeholder' => 'Organisation Address', 'class' => 'form-control form-control-sm', 'rows' => '2')) }}
                                    @if ($errors->has('organisationaddress'))
                                        <span class="help-block"><strong>{{ $errors->first('organisationaddress') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('department') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Department</label>
                                <div class="col-sm-6">
{{--                                    {{ Form::text('department', null, array('placeholder' => 'Department','required' => 'required', 'class' => 'form-control form-control-sm')) }}--}}
                                    {{Form::select('department',$department,null,array('placeholder' => '--SELECT--','id'=>'departmentid') )}}
                                    @if ($errors->has('department'))
                                        <span class="help-block"><strong>{{ $errors->first('department') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('subject') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Subject</label>
                                <div class="col-sm-6">
                                    {{ Form::text('subject', null, array('placeholder' => 'Subject','required' => 'required', 'class' => 'form-control form-control-sm','required' => 'required')) }}
                                    @if ($errors->has('subject'))
                                        <span class="help-block"><strong>{{ $errors->first('subject') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('contactpersonname') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Contact Person Name</label>
                                <div class="col-sm-6">
                                    {{ Form::text('contactpersonname', null, array('placeholder' => 'Contact Person Name', 'class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('contactpersonname'))
                                        <span class="help-block"><strong>{{ $errors->first('contactpersonname') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('contactpersonmobileno') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Contact Person Mobile No</label>
                                <div class="col-sm-6">
                                    {{ Form::number('contactpersonmobileno', null, array('placeholder' => 'Contact Person Mobile No', 'class' => 'form-control form-control-sm','onchange'=>'checkmobileno()')) }}
                                    @if ($errors->has('contactpersonmobileno'))
                                        <span class="help-block"><strong>{{ $errors->first('contactpersonmobileno') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('contactpersonmobile2') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Contact No 2</label>
                                <div class="col-sm-6">
                                    {{ Form::number('contactpersonmobile2', null, array('placeholder' => 'Contact No 2', 'class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('contactpersonmobile2'))
                                        <span class="help-block"><strong>{{ $errors->first('contactpersonmobile2') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('contactpersonmobile3') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Contact No 3</label>
                                <div class="col-sm-6">
                                    {{ Form::number('contactpersonmobile3', null, array('placeholder' => 'Contact No 3', 'class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('contactpersonmobile3'))
                                        <span class="help-block"><strong>{{ $errors->first('contactpersonmobile3') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('contactpersonemailid') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Contact Person Email Id</label>
                                <div class="col-sm-6">
                                    {{ Form::email('contactpersonemailid', null, array('placeholder' => 'Contact Person Email Id', 'class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('contactpersonemailid'))
                                        <span class="help-block"><strong>{{ $errors->first('contactpersonemailid') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('paymentmode') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Mode of bid Submited </label>
                                <div class="col-sm-6">
                                    {{ Form::select('paymentmode', array(''=>'--SELECT--','DD'=>'DD', 'Cash'=>'Cash', 'Online'=>'Online','NFT'=>'NFT'), null, array('id'=>'modeofbidsubmitedid')) }}
                                    @if ($errors->has('paymentmode'))
                                        <span class="help-block"><strong>{{ $errors->first('paymentmode') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('queryenddate') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Query End Date</label>
                                <div class="col-sm-6">
                                    {{ Form::input('dateTime-local','queryenddate',null,  array('class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('queryenddate'))
                                        <span class="help-block"><strong>{{ $errors->first('queryenddate') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('prebidmeetingdate') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Pre Bid Meeting Date</label>
                                <div class="col-sm-6">
                                    {{ Form::input('dateTime-local','prebidmeetingdate',null,  array('class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('prebidmeetingdate'))
                                        <span class="help-block"><strong>{{ $errors->first('prebidmeetingdate') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('documentfee') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Document Fee</label>
                                <div class="col-sm-6">
                                    {{ Form::number('documentfee', null, array('placeholder' => 'Document Fee', 'class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('documentfee'))
                                        <span class="help-block"><strong>{{ $errors->first('documentfee') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('earnestmoneydeposit') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Earnest Money Deposit</label>
                                <div class="col-sm-6">
                                    {{ Form::number('earnestmoneydeposit', null, array('placeholder' => 'Earnest Money Deposit', 'class' => 'form-control form-control-sm','max' => '9999999999.99', 'min' => '0')) }}
                                    @if ($errors->has('earnestmoneydeposit'))
                                        <span class="help-block"><strong>{{ $errors->first('earnestmoneydeposit') }}</strong></span>
                                    @endif
                                </div>
                            </div>
{{--                            Added By Maaviya--}}
                            <div class="row{{ $errors->has('ms_me') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">MS/ME</label>
                                <div class="col-sm-6">
                                    {{ Form::select('ms_me', array(''=>'--SELECT--','YES'=>'YES', 'NO'=>'NO'), null, array('class' => 'form-control form-control-sm', 'id' => 'ms_me')) }}
                                    @if ($errors->has('ms_me'))
                                        <span class="help-block"><strong>{{ $errors->first('ms_me') }}</strong></span>
                                    @endif
                                </div>
                            </div>
{{--                            --               --}}
                            <div class="row{{ $errors->has('bidsubmissiondate') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Bid Submission Date</label>
                                <div class="col-sm-6">
                                    {{ Form::input('dateTime-local','bidsubmissiondate',null,  array('class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('bidsubmissiondate'))
                                        <span class="help-block"><strong>{{ $errors->first('bidsubmissiondate') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('technicalbidopendate') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Technical Bid Open Date</label>
                                <div class="col-sm-6">
                                    {{ Form::input('dateTime-local','technicalbidopendate',null,  array('class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('technicalbidopendate'))
                                        <span class="help-block"><strong>{{ $errors->first('technicalbidopendate') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('commercialbidopendate') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Commercial Bid Open Date</label>
                                <div class="col-sm-6">
                                    {{ Form::input('dateTime-local','commercialbidopendate',null,  array('class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('commercialbidopendate'))
                                        <span class="help-block"><strong>{{ $errors->first('commercialbidopendate') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('empanelledwithvendor') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Empanelled With Vendor</label>
                                <div class="col-sm-6">
                                    {{ Form::select('empanelledwithvendor', array(''=>'--SELECT--','Yes'=>'Yes', 'No'=>'No'), null, array('class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('empanelledwithvendor'))
                                        <span class="help-block"><strong>{{ $errors->first('empanelledwithvendor') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <div class="row{{ $errors->has('bidtobesubmited') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Bid To Be Submited</label>
                                <div class="col-sm-6">
                                    {{ Form::select('bidtobesubmited', array(''=>'--SELECT--','YES'=>'YES', 'NO'=>'NO'), null, array('class' => 'form-control form-control-sm', 'id' => 'bidtobesubmittedid','onchange'=>'bidsubmittedysandno(); return false')) }}
                                    @if ($errors->has('bidtobesubmited'))
                                        <span class="help-block"><strong>{{ $errors->first('bidtobesubmited') }}</strong></span>
                                    @endif
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
                                    {{ Form::submit('Register', array('class' => 'btn btn-primary')) }}
                                </div>
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
    {{--<script type="text/javascript" src="{{ asset('js/jquery-3.1.1.js') }}"></script>--}}


    <script>
        $(document).ready(function () {
            debugger
            $('#showtendermessage').hide();

            $('#modeofbidsubmitedid').selectize({
                maxItems: 1
            });
            $('#organisationnameid').selectize({

                delimiter: ',',
                persist: false,
                create: function(input) {
                    return {
                        value: input,
                        text: input
                    }
                }
            });

            $('#departmentid').selectize({
                delimiter: ',',
                persist: false,
                create: function(input) {
                    return {
                        value: input,
                        text: input
                    }
                }
            });

        })
        function checktenderno() {
            debugger
            $.ajax({
                url: '{{ url('checktenderno') }}',
                type: "GET",
                data: { id : encodeURIComponent($('#tenderno').val())},
                dataType: "json",
                success: function (data) {
                    debugger
                    if(data == true){
                        $('#showtendermessage').show();
//                        $('#tenderno').val('');

                    }
                    else {
                        $('#showtendermessage').hide();
                    }
                }
            });
        }
    </script>
@endsection