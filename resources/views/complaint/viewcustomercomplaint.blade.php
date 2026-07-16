@extends('layouts.appnew')

@section('content')
    <style>
        th{
            font-size: medium;
        }
        label {
            overflow:hidden;
            text-overflow:ellipsis;
            display:inline-block;
            word-wrap: break-word;
        }
    </style>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">View Complaint</h3>
            </div>
            <div class="panel-body">
                <div class="container">
                    <br>
                    {{ Form::model($ticketnumber) }}
                    <div class="row col-lg-12">
                        <label for="input" class="col-sm-3 col-form-label text-muted">Ticket No :</label>
                        <div class="col-sm-3">
                            {{ Form::label('ticketno',$ticketnumber->ticketno) }}
                        </div>
                        <label for="input" class="col-sm-3 col-form-label text-muted">Customer Name :</label>
                        <div class="col-sm-3">
                            {{ Form::label('customername',$ticketnumber->customername) }}
                        </div>
                    </div>

                    <div class="row col-lg-12">
                        <label for="input" class="col-sm-3 col-form-label text-muted">Customer Site :</label>
                        <div class="col-sm-3">
                            @if($ticketnumber->branchcode != null)
                                {{ Form::label('customersite', $ticketnumber->branchname) }}
                            @else
                                {{ Form::label('customersite',"-") }}
                            @endif
                        </div>
                        <label for="input" class="col-sm-3 col-form-label text-muted">Product & Service :</label>
                        <div class="col-sm-3">
                            {{ Form::label('productservice', $ticketnumber->productservicename) }}
                        </div>
                    </div>

                    <div class="row col-lg-12">
                        <label for="input" class="col-sm-3 col-form-label text-muted">Category :</label>
                        <div class="col-sm-3">
                            {{ Form::label('category', $ticketnumber->categoryname) }}
                        </div>
                        <label for="input" class="col-sm-3 col-form-label text-muted">Sub-Category :</label>
                        <div class="col-sm-3">
                            @if($ticketnumber->subcategoryname != null)
                                {{ Form::label('category', $ticketnumber->subcategoryname) }}
                            @else
                                {{ Form::label('category',"-") }}
                            @endif
                        </div>
                    </div>

                    <div class="row col-lg-12">
                        <label for="input" class="col-sm-3 col-form-label text-muted">Equipment Serial No :</label>
                        <div class="col-sm-3">
                            {{ Form::label('productserialno', $ticketnumber->productsrno_accountno )  }}
                        </div>
                        <label for="input" class="col-sm-3 col-form-label text-muted">Product Serial No :</label>
                        <div class="col-sm-3">
                            @if($ticketnumber->productsrno != null)
                                {{ Form::label('productsrno', $ticketnumber->productsrno ) }}
                            @else
                                {{ Form::label('productsrno',"-") }}
                            @endif
                        </div>

                    </div>

                    <div class="row col-lg-12">
                        <label for="input" class="col-sm-3 col-form-label text-muted">Complaint Description :</label>
                        <div class="col-md-3">
                            {{ Form::label('complaintdescription', $ticketnumber->complaintdescription) }}
                        </div>

                        <label for="input" class="col-sm-3 col-form-label text-muted">Caller Name :</label>
                        <div class="col-sm-3">
                            {{ Form::label('callername', $ticketnumber->callername) }}
                        </div>
                    </div>

                    <div class="row col-lg-12">
                        <label for="input" class="col-sm-3 col-form-label text-muted">Caller Mobile :</label>
                        <div class="col-sm-3">
                            {{ Form::label('callermobile', $ticketnumber->mobilenumber) }}
                        </div>

                        <label for="input" class="col-sm-3 col-form-label text-muted">Caller Email :</label>
                        <div class="col-sm-3">
                            {{ Form::label('calleremail', $ticketnumber->emailid) }}
                        </div>
                    </div>

                    <div class="row col-lg-12">
                        <label for="input" class="col-sm-3 col-form-label text-muted">Priority :</label>
                        <div class="col-sm-3">
                            @if($ticketnumber->priority != null)
                                <b>{{ $ticketnumber->priority }}</b>
                            @else
                                {{ Form::label('priority',"-") }}
                            @endif
                        </div>

                        <label for="input" class="col-sm-3 col-form-label text-muted">Complaint Date :</label>
                        <div class="col-sm-3">
                            <b>{{ \Carbon\Carbon::parse($ticketnumber->complaintdate)->format('d/m/Y') }}</b>
                        </div>
                    </div>

                    <div class="row col-lg-12">
                        <label for="input" class="col-sm-3 col-form-label text-muted">Complaint Status :</label>
                        <div class="col-sm-3">
                            {{ Form::label('complaintstatus', $ticketnumber->complaintstatus) }}
                        </div>

                        <label for="input" class="col-sm-3 col-form-label text-muted">Certificate Date :</label>
                        <div class="col-sm-3">
                            @if($ticketnumber->certificatedate != null)
                                <b>{{ \Carbon\Carbon::parse($ticketnumber->certificatedate)->format('d/m/Y') }}</b>
                            @else
                                {{ Form::label('certificatedate',"-") }}
                            @endif
                        </div>
                    </div>

                    <div class="row col-lg-12">
                        <label for="input" class="col-sm-3 col-form-label text-muted">Call Start Date :</label>
                        <div class="col-sm-3">
                            @if($ticketnumber->callstartdate != null)
                                <b>{{ \Carbon\Carbon::parse($ticketnumber->callstartdate)->format('d/m/Y') }}</b>
                            @else
                                {{ Form::label('callstartdate',"-") }}
                            @endif
                        </div>

                        <label for="input" class="col-sm-3 col-form-label text-muted">Call End Date :</label>
                        <div class="col-sm-3">
                            @if($ticketnumber->callenddate != null)
                                <b>{{ \Carbon\Carbon::parse($ticketnumber->callenddate)->format('d/m/Y')}}</b>
                            @else
                                {{ Form::label('callenddate',"-") }}
                            @endif
                        </div>
                    </div>

                    <div class="row col-lg-12">
                        <label for="input" class="col-sm-3 col-form-label text-muted">Charged Complaint :</label>
                        <div class="col-sm-3">
                            @if($ticketnumber->chargedcomplaint != null)
                                <b>{{ Form::label('chargedcomplaint', $ticketnumber->chargedcomplaint) }}</b>
                            @else
                                {{ Form::label('chargedcomplaint',"-") }}
                            @endif
                        </div>

                        <label for="input" class="col-sm-3 col-form-label text-muted">Call Closure Date :</label>
                        <div class="col-sm-3">
                            @if($ticketnumber->callclosuredate != null)
                                <b>{{ \Carbon\Carbon::parse($ticketnumber->callclosuredate)->format('d/m/Y') }}</b>
                            @else
                                {{ Form::label('callclosuredate',"-") }}
                            @endif
                        </div>
                    </div>

                    <div class="row col-lg-12">
                        <label for="input" class="col-sm-3 col-form-label text-muted">Closure Comment :</label>
                        <div class="col-sm-3">
                            @if($ticketnumber->closurecomment != null)
                                {{ Form::label('closurecomment', $ticketnumber->closurecomment) }}
                            @else
                                {{ Form::label('closurecomment',"-") }}
                            @endif
                        </div>

                        <label for="input" class="col-sm-3 col-form-label text-muted">Type of Call :</label>
                        <div class="col-sm-3">
                            @if($ticketnumber->typeofcall != null)
                                <b>{{ Form::label('typeofcall', $ticketnumber->typeofcall) }}</b>
                            @else
                                {{ Form::label('typeofcall',"-") }}
                            @endif
                        </div>
                    </div>


                    <div class="row col-lg-12">
                        <label for="input" class="col-sm-3 col-form-label text-muted">Comprehensive(Yes/No) :</label>
                        <div class="col-sm-3">
                            @if($ticketnumber->comersivetype != null)
                                {{ Form::label('comprehensive', $ticketnumber->comprehensive) }}
                            @else
                                {{ Form::label('comprehensive',"-") }}
                            @endif
                        </div>

                        <label for="input" class="col-sm-3 col-form-label text-muted">Created By :</label>
                        <div class="col-sm-3">
                            {{ Form::label('created_by',$user->name) }}
                        </div>
                    </div>

                    <div class="row col-lg-12">
                        <label for="input" class="col-sm-3 col-form-label text-muted">Created At :</label>
                        <div class="col-sm-3">
                            <b>{{ \Carbon\Carbon::parse($ticketnumber->created_at)->format('d/m/Y') }}</b>
                        </div>

                        <label for="input" class="col-sm-3 col-form-label text-muted">Updated At :</label>
                        <div class="col-sm-3">
                            @if($ticketnumber->updated_at != null)
                                <b>{{ \Carbon\Carbon::parse($ticketnumber->updated_at)->format('d/m/Y') }}</b>
                            @else
                                {{ Form::label('updated_at',"-") }}
                            @endif
                        </div>
                    </div>
                    <div class="row col-lg-12">
                        <label for="input" class="col-sm-3 col-form-label text-muted">Updated By</label>
                        <div class="col-sm-3">
                            @if($ticketnumber->updated_by != null)
                                {{ Form::label('updated_by', $userupdated->name) }}
                            @else
                                {{ Form::label('updated_by',"-") }}
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @if($ticketnumber->New_Reopen == 'REOPEN' || $ticketnumber->New_Reopen != "")
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">View Complaint</h3>
                </div>
                <div class="panel-body">
                    <div class="container">
                        <br>
                        <div class="row col-lg-12">
                            <label for="input" class="col-lg-2 text-muted">Complaint Status :</label>
                            <label for="input" class="col-lg-2">{{ $ticketnumber->New_Reopen}}</label>

                            <label for="input" class="col-lg-2 text-muted">Reopen Description :</label>
                            <label for="input" class="col-lg-2"><b>{{$ticketnumber->Reopen_description}}</b></label>

                            <label for="input" class="col-lg-2 text-muted">Complaint Reopened on :</label>
                            <label for="input" class="col-lg-2">{{ $ticketnumber->Reopen_date}}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($status != "ACKNOWLEDGED")
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Assignee Details</h3></div>
                <div class="panel-body">
{{--                    <div class="container">--}}
                    <table>
{{--                        <thead>--}}
                        <tr>
                        <th class="col-md-2">Assignee Name</th>
                        <th class="col-md-2">Status</th>
                        <th class="col-md-2">Start Date</th>
                        <th class="col-md-2">End Date</th>
                        <th class="col-md-2">Created At</th>
                        <th class="col-md-2">Comment</th>
                        </tr>
{{--                        </thead>--}}
                    <tbody>
                    @foreach($previouslyassignedto as $data)
                        <tr>
                            <td class="col-md-2">
                                <label for="input">{{ $data->assignee->assigneename }}</label>
                            </td>
                            <td class="col-md-2">
                                <label for="input">{{ $data->assigneestatus }}</label>
                            </td>
                            <td class="col-md-2">
                                <label for="input">{{ @is_null($data->assigneestartdate) ? '-' : Carbon\Carbon::parse($data->assigneestartdate)->format('d-m-Y') }}</label>
                            </td>
                            <td class="col-md-2">
                                <label for="input">{{ @is_null($data->assigneeenddate) ? '-' : Carbon\Carbon::parse($data->assigneeenddate)->format('d-m-Y') }}</label>
                            </td>
                            <td class="col-md-2">
                                <label for="input">{{ @is_null($data->created_at) ? '-' : Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}</label>
                            </td>
                            <td class="col-md-2">
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
{{--                    @foreach($previouslyassignedto as  $value)--}}

{{--                            <br>--}}
{{--                            <div class="row">--}}
{{--                                <label for="input" class="col-sm-2 text-muted">Assignee Name :</label>--}}
{{--                                <label for="input" class="col-sm-2">{{ $value->assignee->assigneename }}</label>--}}

{{--                                <label for="input" class="col-sm-2 text-muted">Start Date :</label>--}}
{{--                                <label for="input"--}}
{{--                                       class="col-sm-2">{{ @is_null($value->assigneestartdate) ? '-' : Carbon\Carbon::parse($value->assigneestartdate)->format('d-m-Y') }}</label>--}}

{{--                                <label for="input" class="col-sm-2 text-muted">End Date :</label>--}}
{{--                                <label for="input"--}}
{{--                                       class="col-sm-2">{{ @is_null($value->assigneeenddate) ? '-' : Carbon\Carbon::parse($value->assigneeenddate)->format('d-m-Y') }}</label>--}}
{{--                            </div>--}}

{{--                            <div class="row">--}}
{{--                                <label for="input" class="col-sm-2 text-muted">Status :</label>--}}
{{--                                <label for="input" class="col-sm-2">{{ $value->assigneestatus }}</label>--}}

{{--                                <label for="input" class="col-sm-2 text-muted">Resolve Comment :</label>--}}
{{--                                <label for="input" class="col-sm-2">{{ $value->ticketresolvecomment }}</label>--}}

{{--                                <label for="input" class="col-sm-2 text-muted">Non-Resolved Comment :</label>--}}
{{--                                <label for="input" class="col-sm-2">{{ $value->ticketunresolvecomment }}</label>--}}
{{--                            </div>--}}

{{--                            <div class="row">--}}
{{--                                <label for="input" class="col-sm-2 text-muted">Pending Reason :</label>--}}
{{--                                <label for="input" class="col-sm-2">{{ $value->ticketpendingreason }}</label>--}}

{{--                                <label for="input" class="col-sm-2 text-muted">Next Action Remark:</label>--}}
{{--                                <label for="input" class="col-sm-2">{{ $value->ticketnextactionremark }}</label>--}}

{{--                                <label for="input" class="col-sm-2 text-muted">Call Details :</label>--}}
{{--                                <label for="input" class="col-sm-2">{{ $value->calldetails }}</label>--}}
{{--                            </div>--}}

{{--                            <div class="row">--}}

{{--                                <label for="input" class="col-sm-2 text-muted">Created At :</label>--}}
{{--                                <label for="input" class="col-sm-2">{{ @is_null($value->created_at) ? '-' : Carbon\Carbon::parse($value->created_at)->format('d-m-Y') }}</label>--}}

{{--                                <label for="input" class="col-sm-2 text-muted">Created By :</label>--}}
{{--                                <label for="input" class="col-sm-2">{{ $user->name }}</label>--}}

{{--                                <label for="input" class="col-sm-2 text-muted">Updated At :</label>--}}
{{--                                <label for="input" class="col-sm-2">{{ @is_null($value->updated_at) ? '-' : Carbon\Carbon::parse($value->updated_at)->format('d-m-Y') }}</label>--}}
{{--                            </div>--}}

{{--                            <div class="row">--}}
{{--                                <label for="input" class="col-sm-2 text-muted">Updated By :</label>--}}
{{--                                <label for="input" class="col-sm-2">{{ $value->updated_by }}</label>--}}
{{--                            </div>--}}

{{--                    @endforeach--}}
                    </tbody>
                    </table>
{{--                    </div>--}}

                </div>
            </div>
        </div>
    @endif
    @if($status== 'RESOLVED'||$status == 'NOT RESOLVED'||$status== 'PENDING')
        <div class="container col-md-12">
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
{{--                                        <a data-toggle="modal" data-target="#myModal">Attachment</a>--}}
{{--                                        <a href="{{asset('uploads/'.$file->filename)}}" target="_blank" class="img-responsive" >Attachment</a>--}}
                                    </td>
{{--                                    <div class="modal fade animated fadeIn faster" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
{{--                                        <div class="modal-dialog" role="document" style="max-width:50%;">--}}
{{--                                            <div class="modal-content">--}}
{{--                                                <div class="modal-header">--}}
{{--                                                    <h5 class="modal-title" id="ModalLabel">View File</h5>--}}
{{--                                                </div>--}}
{{--                                                <div class="modal-body" id="p1body">--}}
{{--                                                    <img src={{asset('uploads/'.$file->filename)}} class="img-responsive" id="profile-img-tag">--}}
{{--                                                </div>--}}
{{--                                                <div class="modal-footer">--}}
{{--                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div>
        <a class="btn btn-default" href="{{url()->previous()}}">Back</a>
    </div>


@endsection
@section('selectize-script')
    <script type="text/javascript">
        function centerModal() {
            $(this).css('display', 'block');
            var $dialog = $(this).find(".modal-body");
            var offset = ($(window).height() - $dialog.height()) / 2;
            // Center modal vertically in window
            $dialog.css("margin-top", offset);
        }
    </script>
@stop