@extends('layouts.appnew')
@section('pageTitle', 'Close Complaint')

@section('content')
    <div class="container">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Close Complaint</h3>
            </div>
            <div class="panel-body">
                {{Form::open(array('action' => array('CustomerComplaintListController@supplyclosecomplaintupdate',$id),'method' => 'post', 'role' => 'form', 'invalidate' => 'invalidate'))}}
                {{--{{ Form::open(array('url' => 'supplycomplaints/supplyclose',$complaintDetail->id)) }}--}}
                <div class="row">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Ticket No.</label>
                    <div class="col-sm-6">
                        {{ Form::label('', $complaintDetail->ticketno) }}
                    </div>
                </div>
                <div class="row">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Complaint Status</label>
                    <div class="col-sm-6">
                        {{ Form::label('', $complaintDetail->complaintstatus) }}
                    </div>
                </div>

                <div class="row mt-2{{ $errors->has('callstartdate') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Call / Assignee Date</label>
                    <div class="col-sm-6">
                        {{ Form::date('callstartdate', isset($complaintDetail->assigneestartdate) ? date("Y-m-d",strtotime($complaintDetail->assigneestartdate)) : null, array('id' => 'callstartdate','class' => 'form-control form-control-sm', 'readonly' => true)) }}
                        @if ($errors->has('callstartdate'))
                            <span class="help-block"><strong>{{ $errors->first('callstartdate') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row mt-2{{ $errors->has('callenddate') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Estimated Assignee End Date</label>
                    <div class="col-sm-6">
                        {{ Form::date('callenddate', isset($complaintDetail->assigneeenddate) ? date("Y-m-d",strtotime($complaintDetail->assigneeenddate)) : null, array('id' => 'callenddate','class' => 'form-control form-control-sm','max'=> '2050-12-31','readonly' => true)) }}
                        @if ($errors->has('callenddate'))
                            <span class="help-block"><strong>{{ $errors->first('callenddate') }}</strong></span>
                        @endif
                    </div>
                </div>
                @if($contractno =="service")
                    <div class="row {{ $errors->has('certificatedate') ? ' has-error' : '' }} mt-2">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Certificate Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('certificatedate', $complaintDetail->certificatedate, array('id'=>'certificatedateid','required' => 'required', 'class' => 'form-control form-control-sm','onchange'=>'getcertificate();','max'=> '2050-12-31', 'readonly' => true)) }}
                            @if ($errors->has('certificatedate'))
                                <span class="help-block"><strong>{{ $errors->first('certificatedate') }}</strong></span>
                            @endif
                        </div>
                    </div>
                @endif
                <div class="row mt-2{{ $errors->has('callclosuredate') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Call End / Resolved Date</label>
                    <div class="col-sm-6">
                        {{ Form::date('resolveddate', $resolveddate, array('id' => 'resolveddateid','class' => 'form-control form-control-sm','required' => 'required' ,'max'=> '2050-12-31', 'readonly' => true)) }}
                        @if ($errors->has('callclosuredate'))
                            <span class="help-block"><strong>{{ $errors->first('callclosuredate') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row mt-2{{ $errors->has('callclosuredate') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Call Closure Date</label>
                    <div class="col-sm-6">
                        {{ Form::date('callclosuredate', $callclosuredate, array('id' => 'callclosuredate','class' => 'form-control form-control-sm','onchange' => 'getcallclosuredate(); return false;','required' => 'required' ,'max'=> '2050-12-31', 'readonly' => true)) }}
                        @if ($errors->has('callclosuredate'))
                            <span class="help-block"><strong>{{ $errors->first('callclosuredate') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row {{ $errors->has('closurecomment') ? ' has-error' : '' }} mt-2">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Closure Comment</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('closurecomment', $complaintDetail->closurecomment, array('id' => 'closurecomment','class' => 'form-control form-control-sm','rows'=>'3',)) }}
                        @if ($errors->has('closurecomment'))
                            <span class="help-block"><strong>{{ $errors->first('closurecomment') }}</strong></span>
                        @endif
                    </div>
                </div>
                <br>
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
                        </tr>
                        @foreach($filedetails as $file)
                            <tr>
                                <td>{{$file->filename}}</td>
                                <td>{{$file->fileextesion}}</td>
                                <td>{{$file->filesize}}</td>
                                <td>
                                    <a data-toggle="modal" data-target="#myModal">Attachment</a>
                                </td>
                                <div class="modal fade animated fadeIn faster" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document" style="max-width:50%;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalLabel">View File</h5>
                                            </div>
                                            <div class="modal-body" id="p1body">
                                                <img src={{asset('uploads/'.$file->filename)}} class="img-responsive" id="profile-img-tag">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="row mt-2">
                    <label for="input" class="col-sm-2 col-form-label text-muted"></label>
                    <div class="col-sm-2">
                        {{ Form::submit('save & close', array('class' => 'btn btn-primary offset-4')) }}
                    </div>
                    <div class="col-md-2"><a class="btn btn-primary offset-4" href="{{url('/complaints/reopencomplaint/'.$complaintDetail->ticketno)}}">Reopen</a></div>
                    <div class="col-md-2"> <a class="btn btn-primary" href="{{url()->previous()}}">Cancel</a></div>

                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="{{asset('custom-scripts/customdatavalidation.js')}}"></script>
    <script type="text/javascript">
        function getcertificate() {
            debugger
            if ($("#certificatedateid").val() != "") {
                var callstartdate = new Date($("#callstartdate").val());
                var certificatedate = new Date($("#certificatedateid").val());
                var year = certificatedate.getFullYear().toString().length;
                if(year == 4)
                {
                    if (callstartdate > certificatedate || callstartdate == certificatedate) {
                        alert('Certificate date should  be grater than Call end date');
                        $("#certificatedateid").val('');
                    }
                }
            }
        }

        function  getcallclosuredate() {
            if ($("#callclosuredate").val() != "") {
                var certificatedate = new Date($("#certificatedateid").val());
                var callclosuredate = new Date($("#callclosuredate").val());
                var year = callclosuredate.getFullYear().toString().length;
                if(year == 4)
                {
                    if(certificatedate > callclosuredate || certificatedate == callclosuredate )
                    {
                        alert('Call Closure date should  be grater than Certificate date');
                        $("#callclosuredate").val('');
                    }
                }
            }
        }
    </script>
    <script type="text/javascript">
        document.getElementById("callenddate").onblur = function() {ValidateDate('callenddate',2050,'there your date is not good.')};
        document.getElementById("certificatedateid").onblur = function() {ValidateDate('certificatedateid',2050,'there your date is not good.')};
        document.getElementById("callclosuredate").onblur = function() {ValidateDate('callclosuredate',2050,'there your date is not good.')};
    </script>
    <script type="text/javascript">
        function centerModal() {
            $(this).css('display', 'block');
            var $dialog = $(this).find(".modal-body");
            var offset = ($(window).height() - $dialog.height()) / 2;
            // Center modal vertically in window
            $dialog.css("margin-top", offset);
        }
    </script>
@endsection
