@extends('layouts.appnew')
@section('pageTitle', 'Complaints')
@section('content')
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading"><strong>Details</strong></div>
            <div class="panel-body">
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
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Organisation
                                Name</label>
                            <div class="col-sm-7">
                                {{ Form::label('organisation', $organisation) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Organisation
                                Address</label>
                            <div class="col-sm-7">
                                {{ Form::label('organisationaddress', $organisationaddress) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Empanelled With
                                Vendor</label>
                            <div class="col-sm-7">
                                {{ Form::label('empanelledwithvendor', $empanelledwithvendor) }}
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
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Contact Person
                                Name</label>
                            <div class="col-sm-7">
                                {{ Form::label('contactpersonname', $contactpersonname) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Contact Person
                                Mobile No</label>
                            <div class="col-sm-7">
                                {{ Form::label('contactpersonmobileno', $contactpersonmobileno) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Contact No 2</label>
                            <div class="col-sm-7">
                                {{ Form::label('contactpersonmobile2', $contactpersonmobile2) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Contact No 3</label>
                            <div class="col-sm-7">
                                {{ Form::label('contactpersonmobile3', $contactpersonmobile3) }}
                            </div>
                        </div>

                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Contact Person
                                Email Id</label>
                            <div class="col-sm-7">
                                {{ Form::label('contactpersonemailid', $contactpersonemailid) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Query End
                                Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('queryenddate', $queryenddate) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Query</label>
                            <div class="col-sm-7">
                                {{ Form::label('quary', $quary) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Pre Bid Meeting
                                Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('prebidmeetingdate', $prebidmeetingdate) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Pre Bid
                                Meeting</label>
                            <div class="col-sm-7">
                                {{ Form::label('prebidmeeting', $prebidmeeting) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Document
                                Fee</label>
                            <div class="col-sm-7">
                                {{ Form::label('documentfee', $documentfee) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Earnest Money
                                Deposit</label>
                            <div class="col-sm-7">
                                {{ Form::label('earnestmoneydeposit', $earnestmoneydeposit) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">MS/ME</label>
                            <div class="col-sm-7">
                                {{ Form::label('ms_me', $ms_me) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Emd Status</label>
                            <div class="col-sm-7">
                                {{ Form::label('emdstatus', $emdstatus) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Bid Submission
                                Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('bidsubmissiondate', $bidsubmissiondate) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Document Read And
                                Reviewed</label>
                            <div class="col-sm-7">
                                {{ Form::label('documentreadandreviewed' ,$documentreadandreviewed) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Query To
                                Customer</label>
                            <div class="col-sm-7">
                                {{ Form::label('querytocustomer', $querytocustomer) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Customer
                                Response</label>
                            <div class="col-sm-7">
                                {{ Form::label('customerresponse', $customerresponse) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Internal
                                Query</label>
                            <div class="col-sm-7">
                                {{ Form::label('internalquery', $internalquery) }}
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Internal
                                Response</label>
                            <div class="col-sm-7">
                                {{ Form::label('internalresponse', $internalresponse) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Bid Submission
                                Status</label>
                            <div class="col-sm-7">
                                {{ Form::label('bidsubmissionstatus', $bidsubmissionstatus) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Reason For Bid Not
                                Submitted</label>
                            <div class="col-sm-7">
                                {{ Form::label('reasonfornotsubmitted', $reasonforbidnotsubmitted) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Corrigendum
                                Number</label>
                            <div class="col-sm-7">
                                {{ Form::label('corrigendumnumber', $corrigendumnumber) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Reason For
                                Corrigendum</label>
                            <div class="col-sm-7">
                                {{ Form::label('reasonforcorrigendum', $reasonforcorrigendum) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Extended
                                Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('extendeddate', $extendeddate) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Technical Bid Open
                                Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('technicalbidopendate', $technicalbidopendate) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Technical Bid
                                Status</label>
                            <div class="col-sm-7">
                                {{ Form::label('technicalbidstatus',$technicalbidstatus) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Reason For
                                Rejection In Technical Bid</label>
                            <div class="col-sm-7">
                                {{ Form::label('technicalbidrejectionreason', $reasonforrejectiontb) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">New Technical Bid
                                Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('newtechnicalbiddate', $newtechnicalbiddate) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Commercial Bid Open
                                Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('commercialbidopendate', $commercialbidopendate) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Commercial Bid
                                Status</label>
                            <div class="col-sm-7">
                                {{ Form::label('commercialbidstatus', $commercialbidstatus) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Reason For
                                Rejection In Commercial Bid</label>
                            <div class="col-sm-7">
                                {{ Form::label('reasonforrejectionincommercialbid', $reasonforrejectioncb) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">New Commercial Bid
                                Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('newcommercialbiddate', $newcommercialbiddate) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">EMD Return
                                Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('emdreturndate', $emdreturndate) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Work Order
                                Number</label>
                            <div class="col-sm-7">
                                {{ Form::label('workordernumber', $workordernumber) }}
                            </div>
                        </div>
                        <div class="row" style="padding: 3px">
                            <label for="input" class="col-sm-5 col-form-label-sm text-muted">Work Order Start
                                Date</label>
                            <div class="col-sm-7">
                                {{ Form::label('workorderstartdate', $workorderstartdate) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Tender Files</div>
                    <div class="panel-body">
                        @if(isset($filedetails))
                            <table class="table table-sm table-hover">
                                <thead>
                                <tr class="text-muted">
                                    {{--<th>#</th>--}}
                                    <th>File Name</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($filedetails as $key => $value)
                                    <tr>
                                        <td>{{$value['filename']}}</td>
                                        <td>
                                            <a onclick="showfile({{ $value->id }}); return false;"><i
                                                        class="fa fa-eye fa-lg text-muted" style="color: black;"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">File Frame : <label id="showfilename"></label></div>
                    <div class="panel-body">
                        <iframe id="iframe" width="100%" height="500px" style="border-radius: 10px; border: 1px solid darkgray"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script type="text/javascript">
        function showfile(id) {
            $.ajax({
                url: "{{URL::to('/tender/getfile')}}/" + id,
                type: "GET",
                dataType: "json",
                success: function   (data) {
                    var fileurl = '{{ URL::asset('uploads') }}';
                    document.getElementById('showfilename').innerText = data['filename'];
                    document.getElementById('iframe').src = fileurl + '/' + data['filename'];
                }
            });
        }
    </script>
@endsection