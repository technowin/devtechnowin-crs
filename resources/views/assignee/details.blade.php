@extends('layouts.appnew')

@section('pageTitle', 'View')

@section('content')
<style>
    label {
        overflow:hidden;
        text-overflow:ellipsis;
        display:inline-block;
        word-wrap: break-word;
    }
</style>
    <div class="container col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Complaint</div>
            <div class="panel-body">
                <div class="container">
                    <div id="typeofcall" class="row" style="padding: 3px">
                        <label for="input" class="col-sm-3 col-form-label-sm text-muted">Type of Call</label>
                        <div class="col-sm-3">
                            {{ Form::label('', ($customer->typeofcall != null ? "0" : $customer->typeofcall) ) }}
                        </div>
                    </div>
                    <div id="complaintdescription" class="row" style="padding: 3px">
                        <label for="input" class="col-sm-3 col-form-label-sm text-muted">Complaint Description</label>
                        <div class="col-sm-3">
                            {{ Form::label('', $customer->complaintdescription) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">Complaint Feedback Status</div>
            <div class="panel-body">
                <div class="container">



                    <div class="row" style="padding: 3px">
                        <label for="input" class="col-sm-2 col-form-label-sm text-muted">Ticket No</label>
                        <div class="col-sm-4">
                            {{ Form::label('', $complaints->ticketno) }}
                        </div>
                    </div>
                    <div class="row" style="padding: 3px">
                        <label for="input" class="col-sm-2 col-form-label-sm text-muted">Complaint Status</label>
                        <div class="col-sm-4">
                            {{ Form::label('', $complaints->assigneestatus ,array('id'=>'status')) }}
                        </div>
                    </div>
                    <div id="resolvecommentdiv" class="row" style="padding: 3px">
                        <label for="input" class="col-sm-2 col-form-label-sm text-muted">Comment</label>
                        <div class="col-sm-4">
                            {{ Form::label('', $complaints->ticketresolvecomment) }}
                        </div>
                    </div>
                    <div id="unresolvecommentdiv" class="row" style="padding: 3px">
                        <label for="input" class="col-sm-2 col-form-label-sm text-muted">Un Resolve Comment</label>
                        <div class="col-sm-4">
                            {{ Form::label('', $complaints->ticketunresolvecomment) }}
                        </div>
                    </div>
                    <div id="pendingreasondiv" class="row" style="padding: 3px">
                        <label for="input" class="col-sm-2 col-form-label-sm text-muted">Pending Reason</label>
                        <div class="col-sm-4">
                            {{ Form::label('', $complaints->ticketpendingreason) }}
                        </div>
                    </div>
                    <div id="nextactionremarkdiv" class="row" style="padding: 3px">
                        <label for="input" class="col-sm-2 col-form-label-sm text-muted">Next Action Remark</label>
                        <div class="col-sm-4">
                            {{ Form::label('', $complaints->ticketnextactionremark) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">Customer Details</div>
            <div class="panel-body">
                <div class="container">
                    <div id="nextactionremarkdiv" class="row" style="padding: 3px">
                        <label for="input" class="col-md-2 col-form-label-sm text-muted">Customer Name</label>
                        <div class="col-md-4">
                            {{ Form::label('', $customerdetails->customername) }}
                        </div>
                    </div>
                    <div id="nextactionremarkdiv" class="row" style="padding: 3px">
                        <label for="input" class="col-sm-2 col-form-label-sm text-muted">Customer Phone No</label>
                        <div class="col-sm-4">
                            {{ Form::label('', $customerdetails->customerphone) }}
                        </div>
                    </div>
                    <div id="nextactionremarkdiv" class="row" style="padding: 3px">
                        <label for="input" class="col-sm-2 col-form-label-sm text-muted">Customer Address</label>
                        <div class="col-sm-4">
                            {{ Form::label('', $branch) }}
                        </div>
                    </div>
                    <div id="nextactionremarkdiv" class="row" style="padding: 3px">
                        <label for="input" class="col-sm-2 col-form-label-sm text-muted">Customer Product Service Name</label>
                        <div class="col-sm-4">
                            {{ Form::label('', $product->productservicename) }}
                        </div>
                    </div>
                    <div id="callernameid" class="row" style="padding: 3px">
                        <label for="input" class="col-sm-2 col-form-label-sm text-muted">Caller Name</label>
                        <div class="col-sm-4">
                            {{ Form::label('', $customer->callername) }}
                        </div>
                    </div>
                    <div id="callermobilenoid" class="row" style="padding: 3px">
                        <label for="input" class="col-sm-2 col-form-label-sm text-muted">Caller Mobile</label>
                        <div class="col-sm-4">
                            {{ Form::label('', $customer->mobilenumber) }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @if($customer->New_Reopen == 'REOPEN' || $customer->New_Reopen != "")
        <div class="container col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Reopen Details</h3></div>
                <div class="panel-body">
                    <div class="container">
                        <div class="row col-lg-12">
                            <label for="input" class="col-lg-2 text-muted">Complaint Status :</label>
                            <label for="input" class="col-lg-2">{{ $customer->New_Reopen}}</label>

                            <label for="input" class="col-lg-2 text-muted">Reopen Description :</label>
                            <label for="input" class="col-lg-2"><b>{{$customer->Reopen_description}}</b></label>

                            <label for="input" class="col-lg-2 text-muted">Complaint Reopened on :</label>
                            <label for="input" class="col-lg-2">{{ $customer->Reopen_date}}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     @endif
    @if($complaints->assigneestatus == 'RESOLVED'||$complaints->assigneestatus == 'NOT RESOLVED'||$complaints->assigneestatus == 'PENDING')
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
                                        <a  href="{{ url('filesAssignee/'.$file->id) }}">view</a>
{{--                                        <a data-toggle="modal" data-target="#myModal">Attachment</a>--}}
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
                </div>
            </div>
        </div>
        @endif


    {{--<div class="container card col-md-8">--}}
    {{--<div class="card-header">Complaint Feedback Status</div>--}}
    {{--<div class="card-body">--}}
    {{--<div class="row" style="padding: 3px">--}}
    {{--<label for="input" class="col-sm-5 col-form-label-sm text-muted">Ticket No</label>--}}
    {{--<div class="col-sm-7">--}}
    {{--{{ Form::label('', $complaints->ticketno) }}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="row" style="padding: 3px">--}}
    {{--<label for="input" class="col-sm-5 col-form-label-sm text-muted">Complaint Status</label>--}}
    {{--<div class="col-sm-7">--}}
    {{--{{ Form::label('', $complaints->assigneestatus ,array('id'=>'status')) }}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div id="resolvecommentdiv" class="row" style="padding: 3px">--}}
    {{--<label for="input" class="col-sm-5 col-form-label-sm text-muted">Comment</label>--}}
    {{--<div class="col-sm-7">--}}
    {{--{{ Form::label('', $complaints->ticketresolvecomment) }}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div id="unresolvecommentdiv" class="row" style="padding: 3px">--}}
    {{--<label for="input" class="col-sm-5 col-form-label-sm text-muted">Un Resolve Comment</label>--}}
    {{--<div class="col-sm-7">--}}
    {{--{{ Form::label('', $complaints->ticketunresolvecomment) }}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div id="pendingreasondiv" class="row" style="padding: 3px">--}}
    {{--<label for="input" class="col-sm-5 col-form-label-sm text-muted">Pending Reason</label>--}}
    {{--<div class="col-sm-7">--}}
    {{--{{ Form::label('', $complaints->ticketpendingreason) }}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div id="nextactionremarkdiv" class="row" style="padding: 3px">--}}
    {{--<label for="input" class="col-sm-5 col-form-label-sm text-muted">Next Action Remark</label>--}}
    {{--<div class="col-sm-7">--}}
    {{--{{ Form::label('', $complaints->ticketnextactionremark) }}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

@endsection

@section('script-js')

    <script type="text/javascript">
        $(document).ready(function () {

            var el = document.getElementById('status');
            var elText = (el.innerText || el.textContent);

            if(elText == "RESOLVED"){

                $('#resolvecommentdiv').show();

                $('#unresolvecommentdiv').hide();

                $("#pendingreasondiv").hide();

                $("#nextactionremarkdiv").hide();
            }
            if(elText == "NOT RESOLVED"){

                $('#resolvecommentdiv').hide();

                $('#unresolvecommentdiv').show();

                $("#pendingreasondiv").hide();

                $('#nextactionremarkdiv').hide();
            }
            if(elText == "PENDING"){

                $("#pendingreasondiv").show();

                $('#nextactionremarkdiv').show();

                $("#unresolvecommentdiv").hide();

                $("#resolvecommentdiv").hide();
            }
            if(elText == ""){
                $("#pendingreasondiv").hide();

                $('#nextactionremarkdiv').hide();

                $("#unresolvecommentdiv").hide();

                $("#resolvecommentdiv").hide();
            }

        });
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
@stop