@extends('layouts.appnew')
@section('pageTitle', 'Assigned Complaint')
@section('content')
    <style>
        label {
            overflow:hidden;
            text-overflow:ellipsis;
            display:inline-block;
            word-wrap: break-word;
        }
    </style>
    <div class="col-md-12">
        <div class="col-md-12 row">
            <div class="container col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Ticket No. {{ $ticketnumber }} {{ $status=='NOT RESOLVED' ? 'is' : 'was' }} assigned to </div>
                    <div class="panel-body">
                        @foreach($previouslyassignedto as  $value)
                            <div class="container">
                                <br>
                                <div class="row col-lg-12">
                                    <label for="input" class="col-sm-2 text-muted">Assignee Name :</label>
                                    <label for="input" class="col-sm-2">{{ $value->assignee->assigneename }}</label>

                                    <label for="input" class="col-sm-2 text-muted">Start Date :</label>
                                    <label for="input" class="col-sm-2">{{ @is_null($value->assigneestartdate) ? '-' : Carbon\Carbon::parse($value->assigneestartdate)->format('d-m-Y') }}</label>

                                    <label for="input" class="col-sm-2 text-muted">End Date :</label>
                                    <label for="input" class="col-sm-2">{{ @is_null($value->assigneeenddate) ? '-' : Carbon\Carbon::parse($value->assigneeenddate)->format('d-m-Y') }}</label>
                                </div>

                                <div class="row col-lg-12">
                                    <label for="input" class="col-sm-2 text-muted">Status :</label>
                                    <label for="input" class="col-sm-2">{{ $value->assigneestatus }}</label>

                                    <label for="input" class="col-sm-2 text-muted">Resolve Comment :</label>
                                    <label for="input" class="col-sm-2">{{ $value->ticketresolvecomment }}</label>

                                    <label for="input" class="col-sm-2 text-muted">Non-Resolved Comment :</label>
                                    <label for="input" class="col-sm-2">{{ $value->ticketunresolvecomment }}</label>
                                </div>

                                <div class="row col-lg-12">
                                    <label for="input" class="col-sm-2 text-muted">Pending Reason :</label>
                                    <label for="input" class="col-sm-2">{{ $value->ticketpendingreason }}</label>

                                    <label for="input" class="col-sm-2 text-muted">Next Action Remark:</label>
                                    <label for="input" class="col-sm-2">{{ $value->ticketnextactionremark }}</label>

                                    <label for="input" class="col-sm-2 text-muted">Call Details :</label>
                                    <label for="input" class="col-sm-2">{{ $value->calldetails }}</label>
                                </div>

                                <div class="row col-lg-12">

                                    <label for="input" class="col-sm-2 text-muted">Created At :</label>
                                    <label for="input" class="col-sm-2">{{ @is_null($value->created_at) ? '-' : Carbon\Carbon::parse($value->created_at)->format('d-m-Y') }}</label>

                                    <label for="input" class="col-sm-2 text-muted">Created By :</label>
                                    <label for="input" class="col-sm-2">{{ $user->name }}</label>

                                    <label for="input" class="col-sm-2 text-muted">Updated At :</label>
                                    <label for="input" class="col-sm-2">{{ @is_null($value->updated_at) ? '-' : Carbon\Carbon::parse($value->updated_at)->format('d-m-Y') }}</label>
                                </div>

                                <div class="row col-lg-12">
                                    <label for="input" class="col-sm-2 text-muted">Updated By :</label>
                                    <label for="input" class="col-sm-2">{{ $value->updated_by }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="container col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Admin's Comment</h3></div>
                    <div class="panel-body">
                        <table class="col-lg-12">
                            <tr>
                                <th class="col-sm-6 text-muted">Comment:</th>
                                <th class="col-sm-6 text-muted">Comment Date:</th>
                            </tr>
                            <tbody>
                            @foreach($comments as $data)
                                <tr>
                                    <td class="col-sm-6">
                                        <label for="input">{{ $data->comment }}</label>
                                    </td>
                                    <td class="col-sm-6">
                                        <label for="input">{{ @is_null($data->commentdate) ? '-' : Carbon\Carbon::parse($data->commentdate)->format('d-m-Y') }}</label>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if($complaintdetails != null)

                <div class="container col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Complaint Details</div>
                        <div class="panel-body">

                            <div class="container">
                                <br>
                                <div class="row col-lg-12">
                                    <label for="input" class="col-sm-2 text-muted">Customer Name :</label>
                                    <label for="input" class="col-sm-2">{{ $complaintdetails->customername }}</label>

                                    <label for="input" class="col-sm-2 text-muted">Customer Site :</label>
                                    <div class="col-sm-2">
                                        @if($complaintdetails->branchname != null)
                                            {{ Form::label('customersite', $complaintdetails->branchname) }}
                                        @else
                                            {{ Form::label('customersite',"-") }}
                                        @endif
                                    </div>

                                    <label for="input" class="col-sm-2 text-muted">Product & Services :</label>
                                    <label for="input" class="col-sm-2">{{ $complaintdetails->productservicename }}</label>
                                </div>

                                <div class="row col-lg-12">
                                    <label for="input" class="col-sm-2 text-muted">Category :</label>
                                    <label for="input" class="col-sm-2">{{ $complaintdetails->categoryname}}</label>

                                    <label for="input" class="col-sm-2 text-muted">Sub-Category :</label>
                                    <label for="input" class="col-sm-2">{{ $complaintdetails->subcategoryname}}</label>

                                    <label for="input" class="col-sm-2 text-muted">Equipment Sr No. :</label>
                                    <label for="input" class="col-sm-2">{{ $complaintdetails->productsrno_accountno}}</label>

                                </div>

                                <div class="row col-lg-12">
                                    <label for="input" class="col-sm-2 text-muted">Product Sr No. :</label>
                                    <label for="input" class="col-sm-2">{{ $complaintdetails->productsrno}}</label>

                                    <label for="input" class="col-sm-2 text-muted">Complaint Description :</label>
                                    <label for="input" class="col-sm-2">{{ $complaintdetails->complaintdescription}}</label>

                                    <label for="input" class="col-sm-2 text-muted">Caller Name :</label>
                                    <label for="input" class="col-sm-2">{{ $complaintdetails->callername}}</label>
                                </div>

                                <div class="row col-lg-12">
                                    <label for="input" class="col-sm-2 text-muted">Caller Mobile :</label>
                                    <label for="input" class="col-sm-2">{{ $complaintdetails->mobilenumber}}</label>

                                    <label for="input" class="col-sm-2 text-muted">Caller Email :</label>
                                    <label for="input" class="col-sm-2">{{ $complaintdetails->emailid}}</label>

                                    <label for="input" class="col-sm-2 text-muted">Priority :</label>
                                    <label for="input" class="col-sm-2">{{ $complaintdetails->priority}}</label>
                                </div>

                                <div class="row col-lg-12">
                                    <label for="input" class="col-sm-2 text-muted">Complaint Date :</label>
                                    <label for="input" class="col-sm-2"><b>{{ \Carbon\Carbon::parse($complaintdetails->complaintdate)->format('d/m/Y') }}</b></label>

                                    <label for="input" class="col-sm-2 text-muted">Complaint Status :</label>
                                    <label for="input" class="col-sm-2">{{ $complaintdetails->complaintstatus}}</label>

                                    <label for="input" class="col-sm-2 text-muted">Certificate Date :</label>
                                    <label for="input" class="col-sm-2"><b>{{ \Carbon\Carbon::parse($complaintdetails->certificatedate)->format('d/m/Y') }}</b></label>
                                </div>

                                <div class="row col-lg-12">
                                    <label for="input" class="col-sm-2 text-muted">Call Start Date :</label>
                                    <label for="input" class="col-sm-2"><b>{{ \Carbon\Carbon::parse($complaintdetails->callstartdate)->format('d/m/Y') }}</b></label>

                                    <label for="input" class="col-sm-2 text-muted">Charged Complaint :</label>
                                    <label for="input" class="col-sm-2">{{ $complaintdetails->chargedcomplaint}}</label>

                                    <label for="input" class="col-sm-2 text-muted">Call Closure Date :</label>
                                    <label for="input" class="col-sm-2"><b>{{ \Carbon\Carbon::parse($complaintdetails->callclosuredate)->format('d/m/Y') }}</b></label>
                                </div>

                                <div class="row col-lg-12">
                                    <label for="input" class="col-sm-2 text-muted">Closure Comment :</label>
                                    <label for="input" class="col-sm-2">{{ @is_null($complaintdetails->closurecomment) ? '-':$complaintdetails->closurecomment}}</label>

                                    <label for="input" class="col-sm-2 text-muted">Type of Call :</label>
                                    <label for="input" class="col-sm-2">{{ $complaintdetails->typeofcall}}</label>

                                    <label for="input" class="col-sm-2 text-muted">Comprehensive(Yes/No) :</label>
                                    <label for="input" class="col-sm-2">{{ @is_null($complaintdetails->comprehensive) ? '-':$complaintdetails->comprehensive}}</label>
                                </div>

                                <div class="row col-lg-12">
                                    <label for="input" class="col-sm-2 text-muted">Created By :</label>
                                    <label for="input" class="col-sm-2">{{ $user->name}}</label>

                                    <label for="input" class="col-sm-2 text-muted">Created At :</label>
                                    <label for="input" class="col-sm-2"><b>{{ \Carbon\Carbon::parse($complaintdetails->created_at)->format('d/m/Y') }}</b></label>

                                    <label for="input" class="col-sm-2 text-muted">Updated By :</label>
                                    <label for="input" class="col-sm-2">{{ $complaintdetails->updated_by}}</label>
                                </div>

                                <div class="row-lg-12">
                                    <label for="input" class="col-sm-2 text-muted">Updated At :</label>
                                    <label for="input" class="col-sm-2"><b>{{ \Carbon\Carbon::parse($complaintdetails->updated_at)->format('d/m/Y') }}</b></label>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if($complaintdetails->New_Reopen == 'REOPEN' || $complaintdetails->New_Reopen != "")
                        <div class="container col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h3 class="panel-title">Reopen Details</h3></div>
                                <div class="panel-body">
                                    <div class="container">
                                        <div class="row col-lg-12">
                                            <label for="input" class="col-sm-2 text-muted">Complaint Status :</label>
                                            <label for="input" class="col-sm-2">{{ $complaintdetails->New_Reopen}}</label>

                                            <label for="input" class="col-sm-2 text-muted">Reopen Description :</label>
                                            <label for="input" class="col-sm-2"><b>{{$complaintdetails->Reopen_description}}</b></label>

                                            <label for="input" class="col-sm-2 text-muted">Complaint Reopened on :</label>
                                            <label for="input" class="col-sm-2">{{ $complaintdetails->Reopen_date}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="container col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Assignee Details</h3></div>
                            <div class="panel-body">
                                <table class="col-lg-12">
                                    <tr>
                                        <th class="col-lg-2 text-muted">Assignee Name</th>
                                        <th class="col-lg-2 text-muted">Status</th>
                                        <th class="col-lg-2 text-muted">Start Date</th>
                                        <th class="col-lg-2 text-muted">End Date</th>
                                        <th class="col-lg-2 text-muted">Created At</th>
                                        <th class="col-lg-2 text-muted">Comment</th>
                                    </tr>
                                    <tbody>
                                    @foreach($historyDetails as $data)
                                        <tr>
                                            <td class="col-lg-2">
                                                <label for="input">{{ $data->assignee->assigneename }}</label>
                                            </td>
                                            <td class="col-lg-2">
                                                <label for="input">{{ $data->assigneestatus }}</label>
                                            </td>
                                            <td class="col-lg-2">
                                                <label for="input">{{ @is_null($data->assigneestartdate) ? '-' : Carbon\Carbon::parse($data->assigneestartdate)->format('d-m-Y') }}</label>
                                            </td>
                                            <td class="col-lg-2">
                                                <label for="input">{{ @is_null($data->assigneeenddate) ? '-' : Carbon\Carbon::parse($data->assigneeenddate)->format('d-m-Y') }}</label>
                                            </td>
                                            <td class="col-lg-2">
                                                <label for="input">{{ @is_null($data->created_at) ? '-' : Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}</label>
                                            </td>
                                            <td class="col-lg-2">
                                                @if($data->assigneestatus == "PENDING")
                                                    <label for="input">{{ $data->ticketpendingreason }}</label>
                                                @endif
                                                @if($data->assigneestatus == "NOT RESOLVED")
                                                    <label for="input">{{ $data->ticketunresolvecomment }}</label>
                                                @endif
                                                @if($data->assigneestatus == "RESOLVED")
                                                    <label for="input">{{ $data->ticketresolvecomment }}</label>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if($status== 'RESOLVED'||$status == 'NOT RESOLVED'||$status== 'PENDING')
                        <div class="container col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h3 class="panel-title">Attached File</h3></div>
                                <div class="panel-body">
                                    <div class="container">
                                        <table width="100%">
                                            <tr>
                                                <th width="10px">File Name</th>
                                                <th width="10px">File Extension</th>
                                                <th width="10px">File Size</th>
                                                <th width="10px">Attachment</th>
                                            </tr>
                                            @foreach($filedetails as $file)
                                                <tr>
                                                    <td>{{$file->filename}}</td>
                                                    <td>{{$file->fileextesion}}</td>
                                                    <td>{{$file->filesize}}</td>
                                                    <td>
                                                        <a  href="{{ url('file/'.$file->id) }}">view</a>
{{--                                                        <a data-toggle="modal" data-target="#myModal">Attachment</a>--}}
                                                    </td>
{{--                                                    <div class="modal fade animated fadeIn faster" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
{{--                                                        <div class="modal-dialog" role="document" style="max-width:50%;">--}}
{{--                                                            <div class="modal-content">--}}
{{--                                                                <div class="modal-header">--}}
{{--                                                                    <h5 class="modal-title" id="ModalLabel">View File</h5>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="modal-body" id="p1body">--}}
{{--                                                                    <img src={{asset('uploads/'.$file->filename)}} class="img-responsive" id="profile-img-tag">--}}
{{--                                                                </div>--}}
{{--                                                                <div class="modal-footer">--}}
{{--                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <a class="btn btn-default" href="{{url()->previous()}}">Back</a>

                    {{--            @if($status == 'NOT RESOLVED')--}}
                    {{--                <div class="col-md-6">--}}

                    {{--                    <div class="panel panel-default">--}}
                    {{--                        <div class="panel-heading">Re-Assign Complaint</div>--}}
                    {{--                        <div class="panel-body">--}}
                    {{--                            <div class="container">--}}
                    {{--                                {{Form::open(array('action' => array('ComplaintHandlingController@update', $compactData[0]),'method' => 'post', 'role' => 'form', 'invalidate' => 'invalidate', 'files'=>true))}}--}}
                    {{--                                {{ Form::hidden('id',$id) }}--}}
                    {{--                                <div class="row mt-1">--}}
                    {{--                                    <label for="input" class="col-sm-2 col-form-label text-muted">Ticket No.</label>--}}
                    {{--                                    <div class="col-sm-4">--}}
                    {{--                                        {{ Form::text('ticketnumber', $compactData[2], array('class' => 'form-control form-control-sm','required' => 'required','readonly' => true,'style'=>'background-color:white;')) }}--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="row" style="padding-top: 05px;">--}}
                    {{--                                    <label for="input" class="col-sm-2 col-form-label text-muted">Assignee Name</label>--}}
                    {{--                                    <div class="col-sm-4">--}}
                    {{--                                        {{ Form::select('assignees[]', $compactData[3], null, array('placeholder' => '--SELECT--','required' => 'required', 'id' => 'assignees','multiple'=>true)) }}--}}
                    {{--                                        @if ($errors->has('assignees'))--}}
                    {{--                                            <span class="help-block"><strong>{{ $errors->first('assignees') }}</strong></span>--}}
                    {{--                                        @endif--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="row">--}}
                    {{--                                    <label for="input" class="col-sm-2 col-form-label text-muted">Start Date</label>--}}
                    {{--                                    <div class="col-sm-4">--}}
                    {{--                                        {{ Form::date('startdate', null, array('required' => 'required', 'class' => 'form-control form-control-sm','id'=>'startdate')) }}--}}
                    {{--                                        @if ($errors->has('startdate'))--}}
                    {{--                                            <span class="help-block"><strong>{{ $errors->first('startdate') }}</strong></span>--}}
                    {{--                                        @endif--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="row mt-1">--}}
                    {{--                                    <label for="input" class="col-sm-2 col-form-label text-muted">End Date</label>--}}
                    {{--                                    <div class="col-sm-4">--}}
                    {{--                                        {{ Form::date('enddate', null, array('required' => 'required', 'class' => 'form-control form-control-sm','id'=>'enddate')) }}--}}
                    {{--                                        @if ($errors->has('enddate'))--}}
                    {{--                                            <span class="help-block"><strong>{{ $errors->first('enddate') }}</strong></span>--}}
                    {{--                                        @endif--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                                <div class="row mt-2">--}}
                    {{--                                    <label for="input" class="col-sm-2 col-form-label text-muted"></label>--}}
                    {{--                                    <div class="col-sm-6">--}}
                    {{--                                        {{ Form::submit('save & close', array('class' => 'btn btn-primary offset-4')) }}--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}

                    {{--                                {{ Form::close() }}--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}

                    {{--                </div>--}}
                    {{--             --}}{{--@elseif($status == 'Pending')--}}
                    {{--                --}}{{--<div class="col-md-6">--}}

                    {{--                    --}}{{--<div class="panel panel-default">--}}
                    {{--                        --}}{{--<div class="panel-heading">Close Complaint</div>--}}
                    {{--                        --}}{{--<div class="panel-body">--}}
                    {{--                            --}}{{--<div class="container">--}}
                    {{--                                --}}{{--{{ Form::open(array('url' => 'closecomplaint','files' => true)) }}--}}
                    {{--                                --}}{{--{{ Form::hidden('id',$id) }}--}}
                    {{--                                --}}{{--<div class="row mt-1">--}}
                    {{--                                    --}}{{--<label for="input" class="col-sm-2 col-form-label text-muted">Ticket No.</label>--}}
                    {{--                                    --}}{{--<div class="col-sm-4">--}}
                    {{--                                        --}}{{--{{ Form::text('ticketnumber', $ticketnumber, array('class' => 'form-control form-control-sm','required' => 'required','readonly' => true,'style'=>'background-color:white;')) }}--}}
                    {{--                                    --}}{{--</div>--}}
                    {{--                                --}}{{--</div>--}}
                    {{--                                --}}{{--<div class="row mt-1">--}}
                    {{--                                    --}}{{--<label for="input" class="col-sm-2 col-form-label text-muted">Reason Close Complaint </label>--}}
                    {{--                                    --}}{{--<div class="col-sm-4">--}}
                    {{--                                        --}}{{--{{ Form::textarea('reasonclosecomplaint', '', array('class' => 'form-control form-control-sm','required' => 'required','style'=>'background-color:white;')) }}--}}
                    {{--                                    --}}{{--</div>--}}
                    {{--                                --}}{{--</div>--}}
                    {{--                                --}}{{--<div class="row mt-2">--}}
                    {{--                                    --}}{{--<label for="input" class="col-sm-2 col-form-label text-muted"></label>--}}
                    {{--                                    --}}{{--<div class="col-sm-6">--}}
                    {{--                                        --}}{{--{{ Form::submit('save & close', array('class' => 'btn btn-primary offset-4')) }}--}}
                    {{--                                    --}}{{--</div>--}}
                    {{--                                --}}{{--</div>--}}

                    {{--                                --}}{{--{{ Form::close() }}--}}
                    {{--                            --}}{{--</div>--}}
                    {{--                        --}}{{--</div>--}}
                    {{--                    --}}{{--</div>--}}

                    {{--                --}}{{--</div>--}}
                    {{--            @endif--}}
                </div>
        </div>
    </div>





@endsection
@section('page-script')
    <script type="text/javascript">

        $(document).ready(function () {
            $('#assignees').selectize({
//                maxItems: 1,
            });
        });
    </script>
@stop