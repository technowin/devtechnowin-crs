@extends('layouts.app_tender')

@section('pageTitle', 'View Tender')

@section('content')

    <br/>
    <div class="container card col-md-9">
        <div class="col card-block">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Tender Details</h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>

            <div class="container">
                <br>

                <div class="col-md-12 row">
                    <div class="col-md-6">
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Tender No</label>
                            <div class="col-sm-7">
                                {{ Form::label('tenderno', $tenderno) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Tender Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('tenderdate', $tenderdate) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Organisation Name</label>
                            <div class="col-sm-7">
                                {{ Form::label('organisation', $organisation) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Department</label>
                            <div class="col-sm-7">
                                {{ Form::label('department', $department) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Subject</label>
                            <div class="col-sm-7">
                                {{ Form::label('subject', $subject) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Query End Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('queryenddate', $queryenddate) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Query</label>
                            <div class="col-sm-7">
                                {{ Form::label('query', $query) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Pre Bid Meeting Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('prebidmeetingdate', $prebidmeetingdate) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Pre Bid Meeting</label>
                            <div class="col-sm-7">
                                {{ Form::label('prebidmeeting', $prebidmeeting) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Document Fee</label>
                            <div class="col-sm-7">
                                {{ Form::label('documentfee', $documentfee) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Earnest Money Deposit</label>
                            <div class="col-sm-7">
                                {{ Form::label('earnestmoneydeposit', $earnestmoneydeposit) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Emd Status</label>
                            <div class="col-sm-7">
                                {{ Form::label('emdstatus', $emdstatus) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Bid Submission Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('bidsubmissiondate', $bidsubmissiondate) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Document Read And Reviewed</label>
                            <div class="col-sm-7">
                                {{ Form::label('documentreadandreviewed' ,$documentreadandreviewed) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Query To Customer</label>
                            <div class="col-sm-7">
                                {{ Form::label('querytocustomer', $querytocustomer) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Customer Response</label>
                            <div class="col-sm-7">
                                {{ Form::label('customerresponse', $customerresponse) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Internal Query</label>
                            <div class="col-sm-7">
                                {{ Form::label('internalquery', $internalquery) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Internal Response</label>
                            <div class="col-sm-7">
                                {{ Form::label('internalresponse', $internalresponse) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Bid Submission Status</label>
                            <div class="col-sm-7">
                                {{ Form::label('bidsubmissionstatus', $bidsubmissionstatus) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Reason For Bid Not Submitted</label>
                            <div class="col-sm-7">
                                {{ Form::label('reasonfornotsubmitted', $reasonforbidnotsubmitted) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Corrigendum Number</label>
                            <div class="col-sm-7">
                                {{ Form::label('corrigendumnumber', $corrigendumnumber) }}
                            </div>
                        </div>
                            <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Reason For Corrigendum</label>
                            <div class="col-sm-7">
                                {{ Form::label('reasonforcorrigendum', $reasonforcorrigendum) }}
                            </div>
                        </div>
                            <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Extended Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('extendeddate', $extendeddate) }}
                            </div>
                        </div>
                            <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Technical Bid Open Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('technicalbidopendate', $technicalbidopendate) }}
                            </div>
                        </div>
                            <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Technical Bid Status</label>
                            <div class="col-sm-7">
                                {{ Form::label('technicalbidstatus',$technicalbidstatus) }}
                            </div>
                        </div>
                            <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Reason For Rejection In Technical Bid</label>
                            <div class="col-sm-7">
                                {{ Form::label('technicalbidrejectionreason', $reasonforrejectiontb) }}
                            </div>
                        </div>
                            <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">New Technical Bid Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('newtechnicalbiddate', $newtechnicalbiddate) }}
                            </div>
                        </div>
                            <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Commercial Bid Open Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('commercialbidopendate', $commercialbidopendate) }}
                            </div>
                        </div>
                            <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Commercial Bid Status</label>
                            <div class="col-sm-7">
                                {{ Form::label('commercialbidstatus', $commercialbidstatus) }}
                            </div>
                        </div>
                            <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Reason For Rejection In Commercial Bid</label>
                            <div class="col-sm-7">
                                {{ Form::label('reasonforrejectionincommercialbid', $reasonforrejectioncb) }}
                            </div>
                        </div>
                            <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">New Commercial Bid Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('newcommercialbiddate', $newcommercialbiddate) }}
                            </div>
                        </div>
                            <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">EMD Return Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('emdreturndate', $emdreturndate) }}
                            </div>
                        </div>
                            <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Work Order Number</label>
                            <div class="col-sm-7">
                                {{ Form::label('workordernumber', $workordernumber) }}
                            </div>
                        </div>
                            <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Work Order Start Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('workorderstartdate', $workorderstartdate) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('script-js')
    <script>
        $(document).ready(function () {

//        Hide the divs on page load
            if($('#bidsubmissionstatus').val() != 'Not Submitted'){
                $('#divreasonfornotsubmitted').hide();
            }
            if($('#corrigendumnumber').val() == ''){
                $('#divreasonforcorrigendum').hide();
            }
            if($('#workordernumber').val() == ''){
                $('#divworkorderstartdate').hide();
            }
            if($('#technicalbidstatus').val() != 'Rejected'){
                $('#divtechnicalbidrejectionreason').hide();
            }
            if($('#commercialbidstatus').val() != 'Rejected'){
                $('#divreasonforrejectionincommercialbid').hide();
            }
            if($('#commercialbidstatus').val() != 'Selected'){
                $('#divworkordernumber').hide();
            }

//        Show/Hide reason for not submitted bid on bid submission status change
            $('#bidsubmissionstatus').change(function () {
                if($('#bidsubmissionstatus').val() == 'Not Submitted'){
                    $('#divreasonfornotsubmitted').show();
                }
                else {
                    $('#divreasonfornotsubmitted').hide();
                }
            });
//        Show/Hide technical bid rejection reason on technical bid status change
            $('#technicalbidstatus').change(function () {
                if($('#technicalbidstatus').val() == 'Rejected'){
                    $('#divtechnicalbidrejectionreason').show();
                }
                else {
                    $('#divtechnicalbidrejectionreason').hide();
                }
            });
//        Show/Hide commercial bid rejection reason on commercial bid status change
            $('#commercialbidstatus').change(function () {
                if($('#commercialbidstatus').val() == 'Rejected'){
                    $('#divreasonforrejectionincommercialbid').show();
                    $('#divworkordernumber').hide();
                }
                else if(($('#commercialbidstatus').val() == 'Selected')){
                    $('#divreasonforrejectionincommercialbid').hide();
                    $('#divworkordernumber').show();
                }
                else {
                    $('#divreasonforrejectionincommercialbid').hide();
                    $('#divworkordernumber').hide();
                }
            });
        });

        //    Show/Hide Reason for corrigendum on corrigendernumber change
        function showcorrigendumdiv() {
            var edValue = document.getElementById("corrigendumnumber");
            var s = edValue.value;

            if(s != ''){
                $('#divreasonforcorrigendum').show();
            }
            else {
                $('#divreasonforcorrigendum').hide();
            }
        }
        //    Show/Hide Reason for workordernumber on workorderstartdate
        function showworkorderdatediv() {
            var edValue = document.getElementById("workordernumber");
            var s = edValue.value;

            if(s != ''){
                $('#divworkorderstartdate').show();
            }
            else {
                $('#divworkorderstartdate').hide();
            }
        }
    </script>
@endsection
