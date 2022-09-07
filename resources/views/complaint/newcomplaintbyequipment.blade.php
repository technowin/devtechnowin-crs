@extends('layouts.appnew')
@section('page-css')
    <link href="{{ asset('assets/Selectize/css/selectize.css') }}" rel="stylesheet">

@stop
@section('content')

    @if (Session::has('flash_message'))
        <div class="alert alert-success">
            {{ Session::get('flash_message') }}
        </div>
    @endif

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div>
                    <h3 class="panel-title"><span class="text-muted">Lodge New Complaint By Equipment <small> ( admin access )</small></span>
                    </h3>
                </div>
                <div id="contractdetailsid" style="display: none;">
                <a  href="#" data-toggle="modal" data-target=".bs-example-modal-lg"> <b>Contract Details</b></a>
                </div>
            </div>
            <div class="panel-body">
                {{ Form::open(array('action' => 'AppAdminController@storecomplaintbyequipment','method' => 'post', 'role' => 'form-horizontal', 'invalidate' => 'invalidate','class'=>'onSave', 'onsubmit' => 'return chkdropvalues();')) }}
                {{ Form::hidden('contractno', '', array('id' => 'contractnoid')) }}
                <div class="row{{ $errors->has('customers') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name </label>
                    <div class="col-sm-6">
                        {{ Form::select('customers', $customers, null, array('placeholder' => '--SELECT--', 'id' => 'customers')) }}
                        @if ($errors->has('customers'))
                            <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('productserialno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Equipment Serial No</label>
                    <div class="col-sm-6">
                        {{ Form::select('productserialno',array(null => '--SELECT--'),null, array('id' => 'productserialno')) }}
                        @if ($errors->has('productserialno'))
                            <span class="help-block"><strong>{{ $errors->first('productserialno') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('productsrno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product Serial No</label>
                    <div class="col-sm-6">
                        {{ Form::select('productsrno',array(null => '--SELECT--'),null, array('id' => 'productsrno')) }}
                        @if ($errors->has('productsrno'))
                            <span class="help-block"><strong>{{ $errors->first('productsrno') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('workorderno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Workorder No </label>
                    <div class="col-sm-6">
                        {{ Form::select('workorderno',array(null => '--SELECT--'),null, array('id' => 'workordernoid')) }}
                        @if ($errors->has('workorderno'))
                            <span class="help-block"><strong>{{ $errors->first('workorderno') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('customersite') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Site </label>
                    <div class="col-sm-6">
                        {{ Form::select('customersite',array(null => '--SELECT--'),null, array('id' => 'customersite')) }}
                        @if ($errors->has('customersite'))
                            <span class="help-block"><strong>{{ $errors->first('customersite') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('productservice') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product & Service </label>
                    <div class="col-sm-6">
                        {{ Form::select('productservice',array(null => '--SELECT--'),null, array('id' => 'productservice')) }}
                        @if ($errors->has('productservice'))
                            <span class="help-block"><strong>{{ $errors->first('productservice') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('category') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Category</label>
                    <div class="col-sm-6">
                        {{ Form::select('category',array(null => '--SELECT--'),null, array('id' => 'category')) }}
                        @if ($errors->has('productservice'))
                            <span class="help-block"><strong>{{ $errors->first('category') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('sub-category') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Sub-Category</label>
                    <div class="col-sm-6">
                        {{ Form::select('subcategory', array('' => '--SELECT--'), null, array('id' => 'subcategory', 'rel' => URL::to('/'))) }}
                        @if ($errors->has('subcategory'))
                            <span class="help-block"><strong>{{ $errors->first('subcategory') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('complaintdescription') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Complaint Description <br/>(Max 500
                        Chars)</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('complaintdescription',null,['class'=>'form-control', 'rows' => 3, 'cols' => 40, 'required' => 'required','onKeyPress' => "if(this.value.length==500) return false;"]) }}
                        @if ($errors->has('complaintdescription'))
                            <span class="help-block"><strong>{{ $errors->first('complaintdescription') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('callername') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Caller Name</label>
                    <div class="col-sm-6">
                        {{--{{ Form::text('callername', '', array('class' => 'form-control','required' => 'required')) }}--}}
                        {{ Form::select('callername',array(null => '--SELECT--'),null, array('id' => 'callernameidd')) }}
                        @if ($errors->has('callername'))
                            <span class="help-block"><strong>{{ $errors->first('callername') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('callermobile') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Caller Mobile</label>
                    <div class="col-sm-6">
                        {{ Form::number('callermobile', '', array('class' => 'form-control','required' => 'required','min' => 0,'onKeyPress' => "if(this.value.length==10) return false;",'id'=>'callermobilenoid' )) }}
                        @if ($errors->has('callermobile'))
                            <span class="help-block"><strong>{{ $errors->first('callermobile') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('calleremail') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Caller Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('calleremail', '', array('class' => 'form-control','required' => 'required','id'=>'calleremailid')) }}
                        @if ($errors->has('calleremail'))
                            <span class="help-block"><strong>{{ $errors->first('calleremail') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row mt-2 {{ $errors->has('priority') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Priority</label>
                    <div class="col-sm-6">
                        {{ Form::select('priority', array('High' => 'High','Low' => 'Low','Medium' => 'Medium'), null, array('placeholder' => '--SELECT--', 'id' => 'priority')) }}
                        @if ($errors->has('priority'))
                            <span class="help-block"><strong>{{ $errors->first('priority') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row mt-2 {{ $errors->has('chargedcomplaint') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Charged Complaint</label>
                    <div class="col-sm-6">
                        {{Form::hidden('chargedcomplaint',0)}}
                        {{Form::checkbox('chargedcomplaint',1,0,array('id'=>'chargedcomplaintid','onchange'=>'chargedcomplaintype()'))}}
                        @if ($errors->has('chargedcomplaint'))
                            <span class="help-block"><strong>{{ $errors->first('chargedcomplaint') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div  id="typeofcalldiv"  class="row mt-2 {{ $errors->has('typeofcall') ? ' has-error' : '' }}" style="margin-top: 0.5rem;"}}>
                    <label for="input" class="col-sm-4 col-form-label text-muted">Type of Call</label>
                    <div class="col-sm-6">
                        {{ Form::select('typeofcall', $complainttype, null, array('class'=>'form-control','placeholder' => '--SELECT--', 'id' => 'customers')) }}
                    </div>
                </div>
                <br>
                <div class="row">
                    <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                    <div class="col-sm-2">
                        {{ Form::submit('Save & Close', array( 'id'=>'btnsubmitid','class' => 'btn btn-primary offset-4')) }}

                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-primary offset-4" href="{{url()->previous()}}">Cancel</a>
                    </div>
                    <div class="col-sm-2"></div>
                </div>

                {{ Form::close() }}

                </div>
            </div>
        </div>


    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Contract Details</h4>
                </div>
                <div class="modal-body">
                    <div class="row{{ $errors->has('productservicename') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                        <label for="input" class="col-sm-4 col-form-label text-muted">From Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('fromdate', null, array('class' => 'form-control form-control-sm','id'=>'fromdateid','readonly')) }}
                        </div>
                    </div>
                    <div class="row{{ $errors->has('productservicename') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                        <label for="input" class="col-sm-4 col-form-label text-muted">To Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('todate', null, array('class' => 'form-control form-control-sm','id'=>'todateid','readonly')) }}
                        </div>
                    </div>
                    <div class="row{{ $errors->has('productservicename') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Work Order Type</label>
                        <div class="col-sm-6">
                            {{ Form::text('workordertype', null, array('class' => 'form-control form-control-sm','id'=>'workordertypeid','readonly')) }}
                        </div>
                    </div>
                    <div class="row{{ $errors->has('productservicename') ? ' has-error' : '' }}" style="padding-bottom: 5px;">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Comprehensive Type</label>
                        <div class="col-sm-6">
                            {{ Form::text('comprehensivetype', null, array('class' => 'form-control form-control-sm','id'=>'comprehensivetypeid','readonly')) }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('selectize-script')
    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#typeofcalldiv").hide();
            $('#callernameidd').selectize({
                delimiter: ',',
                persist: false,
                create: function (input) {
                    return {
                        value: input,
                        text: input
                    }
                }
            });

            $('#productservice').selectize({
                maxItems: 1
            });

            $('#category').selectize({
                maxItems: 1
            });

            $('#subcategory').selectize({
                maxItems: 1
            });

            $('#priority').selectize({
                maxItems: 1
            });

            $('#customers').selectize({
                maxItems: 1
            });

            $('#customersite').selectize({
                maxItems: 1
            });
            $('#productserialno').selectize({
                maxItems: 1
            });
            $('#productsrno').selectize({
                maxItems: 1
            });
            $('#workordernoid').selectize({
                maxItems: 1
            });

            $("#customers").change(function () {
                $('#customersite').selectize()[0].selectize.destroy();
                $("#customersite").empty();
                $('#customersite').append('<option value="" selected disabled>--SELECT--</option>');
                $('#customersite').selectize();

                $('#workordernoid').selectize()[0].selectize.destroy();
                $("#workordernoid").empty();
                $('#workordernoid').append('<option value="" selected disabled>--SELECT--</option>');
                $('#workordernoid').selectize();

                $('#productservice').selectize()[0].selectize.destroy();
                $("#productservice").empty();
                $('#productservice').append('<option value="" selected disabled>--SELECT--</option>');
                $('#productservice').selectize();

                $('#category').selectize()[0].selectize.destroy();
                $("#category").empty();
                $('#category').append('<option value="" selected disabled>--SELECT--</option>');
                $('#category').selectize();

                $('#subcategory').selectize()[0].selectize.destroy();
                $("#subcategory").empty();
                $('#subcategory').append('<option value="" selected disabled>--SELECT--</option>');
                $('#subcategory').selectize();

                var workorderlist = [];
                var workorderlistproductsr = [];
                if ($('#customers').val() != "") {
                    $.ajax({
                        url: "{{URL::to('getequipmentsrcustomerwise/')}}/" + $('#customers').val(),
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $.each(data, function (key, value) {
                                workorderlist.push({
                                    text: value['equipmentsrno'],
                                    value: value['equipmentsrno'],
                                })
                            });
                            $.each(data, function (key, value) {
                                workorderlistproductsr.push({
                                    text: value['productsrno'],
                                    value: value['productsrno'],
                                })
                            });

                            $('#productserialno').selectize()[0].selectize.destroy();
                            $('#productsrno').selectize()[0].selectize.destroy();

                            if (workorderlist.length > 0) {
                                $('#productserialno').selectize({
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
                            } else {
                                $('#productserialno').selectize({
                                    options: null
                                });

                            }
                            if (workorderlistproductsr.length > 0) {
                                $('#productsrno').selectize({
                                    maxItems: 1,
                                    valueField: 'value',
                                    labelField: 'text',
                                    searchField: 'text',
                                    create: false,
                                    sortField: {
                                        field: 'text',
                                        direction: 'asc'
                                    },
                                    options: workorderlistproductsr,

                                });
                            } else {
                                $('#productsrno').selectize({
                                    options: null
                                });

                            }
                        }
                    });
                } else {

                    $('#productserialno').selectize()[0].selectize.destroy();
                    $('#productserialno').selectize({
                        options: null
                    });
                    $('#productsrno').selectize()[0].selectize.destroy();
                    $('#productsrno').selectize({
                        options: null
                    });


                }
            });
                $('#productsrno').change(function () {
                    debugger;
                    var equipment = $('#productsrno').val();
                    $.ajax({
                        url: "{{URL::to('checkequipment/')}}",
                        type: "GET",
                        data: {'equipment': equipment},
                        dataType: "json",
                        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                        success: function (data) {
                            if (data.ticketno != "") {
                                alert("Complaint for this Product Sr. No. already exist. " +
                                    "Ticketno = " + data.ticketno + "");
                                //debugger;
                                $('#productsrno').selectize();
                                $('#productserialno').selectize()[0].selectize.destroy();
                                $("#productserialno").empty();
                                $('#productserialno').append('<option value="" selected disabled>--SELECT--</option>');
                                $("#productserialno").selectize();
                                $('#workordernoid').selectize()[0].selectize.destroy();
                                $("#workordernoid").empty();
                                $('#workordernoid').append('<option value="" selected disabled>--SELECT--</option>');
                                $("#workordernoid").selectize();
                                $('#customersite').selectize()[0].selectize.destroy();
                                $('#customersite').empty();
                                $('#customersite').append('<option value="" selected disabled>--SELECT--</option>');
                                $('#customersite').selectize();
                                $('#productservice').selectize()[0].selectize.destroy();
                                $('#productservice').empty();
                                $('#productservice').append('<option value="" selected disabled>--SELECT--</option>');
                                $('#productservice').selectize();
                                $('#category').selectize()[0].selectize.destroy();
                                $('#category').empty();
                                $('#category').append('<option value="" selected disabled>--SELECT--</option>');
                                $('#category').selectize();
                                return false;
                            } else {
                                // comment till here
                                $("#workordernoid").empty();

                                if ($('#productsrno').val() != "") {
                                    $.ajax({
                                        url: "{{URL::to('Getproductbyworkorderdata/{data}')}}/",
                                        type: "GET",
                                        dataType: "json",
                                        data: {
                                            id: $('#productserialno').val()
                                        },
                                        success: function (data) {
                                            if (data.data[0].workorderno != null) {
                                                $('#productserialno').selectize()[0].selectize.destroy();
                                                $("#productserialno").empty();
                                                $('#productserialno').append('<option value="" selected disabled>--SELECT--</option>');
                                                $('#productserialno').append('<option  value="' + data.data[0].equipmentsrno + '" selected>' + data.data[0].equipmentsrno + '</option>');
                                                $('#productserialno ').selectize();

                                                $('#contractnoid').val(data.data[0].contractno);
                                                $('#workordernoid').selectize()[0].selectize.destroy();
                                                $("#workordernoid").empty();
                                                // $('#workordernoid').append('<option value="" selected disabled>--SELECT--</option>');
                                                $('#workordernoid').append('<option  value="' + data.data[0].workorderno + '" selected>' + data.data[0].workorderno + '</option>');
                                                $('#workordernoid').selectize();
                                            } else {
                                                $('#workordernoid').selectize()[0].selectize.destroy();
                                                $("#workordernoid").empty();
                                                $('#workordernoid').append('<option value="" selected disabled>--SELECT--</option>');
                                                $('#workordernoid').selectize();
                                            }

                                            $('#customersite').selectize()[0].selectize.destroy();
                                            $("#customersite").empty();
                                            $('#customersite').append('<option value="" selected disabled>--SELECT--</option>');
                                            $('#customersite').append('<option  value="' + data.data[0].branchcode + '" selected>' + data.data[0].branchname + '</option>');
                                            $('#customersite').selectize();

                                            $('#productservice').selectize()[0].selectize.destroy();
                                            $("#productservice").empty();
                                            $('#productservice').append('<option value="" selected disabled>--SELECT--</option>');
                                            $('#productservice').append('<option  value="' + data.data[0].productservicecode + '" selected>' + data.data[0].productservicename + '</option>');
                                            $('#productservice').selectize();

                                            $('#category').selectize()[0].selectize.destroy();
                                            $("#category").empty();
                                            $('#category').append('<option value="" selected disabled>--SELECT--</option>');
                                            $('#category').append('<option  value="' + data.data[0].categorycode + '" selected>' + data.data[0].categoryname + '</option>');
                                            $('#category').selectize();

                                            $('#callernameidd').selectize()[0].selectize.destroy();
                                            $("#callernameidd").empty();
                                            $('#callernameidd').append('<option value="" selected disabled>--SELECT--</option>');
                                            if (data.branchcontactlist.length > 0) {
                                                for (var i = 0; i < data.branchcontactlist.length; i++) {
                                                    $('#callernameidd').append('<option  value="' + data.branchcontactlist[i].branchcontactcode + '" >' + data.branchcontactlist[i].contactpersonname + '</option>');
                                                }
                                                $('#callernameidd').selectize({
                                                    delimiter: ',',
                                                    persist: false,
                                                    create: function (input) {
                                                        return {
                                                            value: input,
                                                            text: input
                                                        }
                                                    }
                                                });
                                                // $("#callermobilenoid").val(data.branchcontactlist[0].phone);
                                                // $("#calleremailid").val(data.branchcontactlist[0].emailid);
                                            } else {
                                                $("#callermobilenoid").val('');
                                                $("#calleremailid").val('');
                                                $('#callernameidd').selectize({
                                                    delimiter: ',',
                                                    persist: false,
                                                    create: function (input) {
                                                        return {
                                                            value: input,
                                                            text: input
                                                        }
                                                    }
                                                });
                                            }

                                            GetSubCategory();
                                        }

                                    });
                                }

                            }
                        }
                    })
                });
                $('#productserialno').change(function () {
                    //COMMENT FROM HERE
                    var product = $("#productserialno").val();
                    $.ajax({
                        url: "{{URL::to('checkproductsrno/')}}/",
                        type: "GET",
                        data: {'product': product},
                        dataType: "json",
                        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                        success: function (data) {
                            if (data.ticketno != "") {
                                alert("Complaint for this Product Sr. No. already exist. " +
                                    "Ticketno = " + data.ticketno + "");
                                //debugger;
                                $('#productserialno').selectize();
                                $('#productsrno').selectize()[0].selectize.destroy();
                                $("#productsrno").empty();
                                $('#productsrno').append('<option value="" selected disabled>--SELECT--</option>');
                                $("#productsrno").selectize();
                                $('#workordernoid').selectize()[0].selectize.destroy();
                                $("#workordernoid").empty();
                                $('#workordernoid').append('<option value="" selected disabled>--SELECT--</option>');
                                $("#workordernoid").selectize();
                                $('#customersite').selectize()[0].selectize.destroy();
                                $('#customersite').empty();
                                $('#customersite').append('<option value="" selected disabled>--SELECT--</option>');
                                $('#customersite').selectize();
                                $('#productservice').selectize()[0].selectize.destroy();
                                $('#productservice').empty();
                                $('#productservice').append('<option value="" selected disabled>--SELECT--</option>');
                                $('#productservice').selectize();
                                $('#category').selectize()[0].selectize.destroy();
                                $('#category').empty();
                                $('#category').append('<option value="" selected disabled>--SELECT--</option>');
                                $('#category').selectize();
                                return false;
                            } else {
                                //debugger;

                                // comment till here
                                $("#workordernoid").empty();

                                if ($('#productserialno').val() != "") {
                                    $.ajax({
                                        url: "{{URL::to('Getequipmentbyworkorderdata/{data}')}}/",
                                        type: "GET",
                                        dataType: "json",
                                        data: {
                                            id: $('#productserialno').val()
                                        },
                                        success: function (data) {
                                            if (data.data[0].workorderno != null) {
                                                $('#productsrno').selectize()[0].selectize.destroy();
                                                $("#productsrno").empty();
                                                $('#productsrno').append('<option value="" selected disabled>--SELECT--</option>');
                                                // $('#productsrno').append('<option  value="' + data.data[0].productsrno + '" selected>' + data.data[0].productsrno + '</option>');
                                                $('#productsrno').selectize();

                                                $('#contractnoid').val(data.data[0].contractno);
                                                $('#workordernoid').selectize()[0].selectize.destroy();
                                                $("#workordernoid").empty();
                                                // $('#workordernoid').append('<option value="" selected disabled>--SELECT--</option>');
                                                $('#workordernoid').append('<option  value="' + data.data[0].workorderno + '" selected>' + data.data[0].workorderno + '</option>');
                                                $('#workordernoid').selectize();
                                            } else {
                                                $('#workordernoid').selectize()[0].selectize.destroy();
                                                $("#workordernoid").empty();
                                                $('#workordernoid').append('<option value="" selected disabled>--SELECT--</option>');
                                                $('#workordernoid').selectize();
                                            }

                                            $('#customersite').selectize()[0].selectize.destroy();
                                            $("#customersite").empty();
                                            $('#customersite').append('<option value="" selected disabled>--SELECT--</option>');
                                            $('#customersite').append('<option  value="' + data.data[0].branchcode + '" selected>' + data.data[0].branchname + '</option>');
                                            $('#customersite').selectize();

                                            $('#productservice').selectize()[0].selectize.destroy();
                                            $("#productservice").empty();
                                            $('#productservice').append('<option value="" selected disabled>--SELECT--</option>');
                                            $('#productservice').append('<option  value="' + data.data[0].productservicecode + '" selected>' + data.data[0].productservicename + '</option>');
                                            $('#productservice').selectize();

                                            $('#category').selectize()[0].selectize.destroy();
                                            $("#category").empty();
                                            $('#category').append('<option value="" selected disabled>--SELECT--</option>');
                                            $('#category').append('<option  value="' + data.data[0].categorycode + '" selected>' + data.data[0].categoryname + '</option>');
                                            $('#category').selectize();

                                            $('#callernameidd').selectize()[0].selectize.destroy();
                                            $("#callernameidd").empty();
                                            $('#callernameidd').append('<option value="" selected disabled>--SELECT--</option>');
                                            if (data.branchcontactlist.length > 0) {
                                                for (var i = 0; i < data.branchcontactlist.length; i++) {
                                                    $('#callernameidd').append('<option  value="' + data.branchcontactlist[i].branchcontactcode + '" >' + data.branchcontactlist[i].contactpersonname + '</option>');
                                                }
                                                $('#callernameidd').selectize({
                                                    delimiter: ',',
                                                    persist: false,
                                                    create: function (input) {
                                                        return {
                                                            value: input,
                                                            text: input
                                                        }
                                                    }
                                                });
                                                // $("#callermobilenoid").val(data.branchcontactlist[0].phone);
                                                // $("#calleremailid").val(data.branchcontactlist[0].emailid);
                                            } else {
                                                $("#callermobilenoid").val('');
                                                $("#calleremailid").val('');
                                                $('#callernameidd').selectize({
                                                    delimiter: ',',
                                                    persist: false,
                                                    create: function (input) {
                                                        return {
                                                            value: input,
                                                            text: input
                                                        }
                                                    }
                                                });
                                            }

                                            GetSubCategory();
                                        }

                                    });
                                }
                                //COMMENT
                            }
                        }
                    });
                    //COMMENT
                });

            function GetSubCategory() {

                if ($('#category').val() != "") {
                    var subcategorylist = [];
                    $.ajax({
                        url: "{{URL::to('registration/subcategory/')}}/" + $('#category').val(),
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $.each(data, function (key, value) {
                                subcategorylist.push({
                                    text: value['subcategoryname'],
                                    value: value['subcategorycode'],
                                })
                            });
                            $('#subcategory').selectize()[0].selectize.destroy();
                            if (subcategorylist.length > 0) {
                                $('#subcategory').selectize({
                                    maxItems: 1,
                                    valueField: 'value',
                                    labelField: 'text',
                                    searchField: 'text',
                                    create: false,
                                    sortField: {
                                        field: 'text',
                                        direction: 'asc'
                                    },
                                    options: subcategorylist,
                                });
                            }
                            else {
                                $('#subcategory').selectize({
                                    options: null
                                });
                            }
                        }
                    });
                }
                else {
                    $('#subcategory').selectize()[0].selectize.destroy();
                    $('#subcategory').selectize({
                        options: null
                    });
                }
            }
        });
    </script>
    <script type="text/javascript">
        function chkdropvalues() {
            debugger
            $("#btnsubmitid").attr("disabled", true);
            if ($('#customers').val() != "") {
                    if($('#customersite').val() != "")
                    {
                        if($('#productservice').val() != "")
                        {
                            if($('#category').val() != "")
                            {
                                if($('#subcategory').val() != ""){

                                    if($('#productserialno').val() != ""){
                                        if($('#priority').val() != ""){

                                        }
                                        else {
                                            alert('Select priority');
                                            $("#btnsubmitid").attr("disabled", false);
                                            return false;
                                        }
                                    }
                                    else {
                                        alert('Select Product Serial No');
                                        $("#btnsubmitid").attr("disabled", false);
                                        return false;
                                    }
                                }
                                else{
                                    alert('Select Sub Category');
                                    $("#btnsubmitid").attr("disabled", false);
                                    return false;
                                }
                            }
                            else {
                                alert('Select Category');
                                $("#btnsubmitid").attr("disabled", false);
                                return false;
                            }
                        }
                        else {
                            alert('Select Product & Service');
                            $("#btnsubmitid").attr("disabled", false);
                            return false;
                        }
                    }
                    else
                    {
                        alert('Select Customer Site');
                        $("#btnsubmitid").attr("disabled", false);
                        return false;
                    }
            }
            else
            {
                alert("Select Customer Name");
                $("#btnsubmitid").attr("disabled", false);
                return false;
            }

            return true;
        };
    </script>
    <script>
        function chargedcomplaintype() {
            var chkvalue =  document.getElementById("chargedcomplaintid").checked;
            if(chkvalue==true)
            {
                $("#typeofcalldiv").show();

                $('#hidediv').show();
            }else {
                $("#typeofcalldiv").hide();
                $('#hidediv').show();
            }

        }
    </script>
    <script>
        function selectcalltype() {
            var type= $("#typeofcall").val();
            if(type=='Sale'){
                $('#hidediv').hide();
            }else {
                $('#hidediv').show();
            }
        }
    </script>
    <script type="text/javascript">
        $("#callernameidd").change(function () {
            $.ajax({
                url: "{{URL::to('getcallerdetails/')}}/" + $('#callernameidd').val(),
                type: "GET",
                dataType: "json",
                success:function (data) {
                    debugger
                    $("#callermobilenoid").val(data.phone);
                    $("#calleremailid").val(data.email);
                }
            });
        });
    </script>
    <script>
        $('#workordernoid').change(function(){
            if ($('#workordernoid').val() != "") {
                $.ajax({
                    url: "{{URL::to('getworkordernowisebranch/{data}')}}/",
                    type: "GET",
                    dataType: "json",
                    data: {
                        workordernoid: $('#workordernoid').val(),
                    },
                    success: function (data) {
                        $('#contractnoid').val(data.contractno);
                        if (data.fromdate != "1970-01-01") {
                            if (data.fromdate != "1900-01-01") {
                                $("#fromdateid").val(data.fromdate);
                                $("#todateid").val(data.todate);
                                $("#workordertypeid").val(data.workordertype);
                                $("#comprehensivetypeid").val(data.workordertype);
                                $("#contractdetailsid").show();
                            } else {
                                $("#fromdateid").val('');
                                $("#todateid").val('');
                                $("#contractdetailsid").show();
                            }
                        } else {
                            $("#fromdateid").val('');
                            $("#todateid").val('');
                            $("#contractdetailsid").show();
                        }
                    }
                })
            }
        });
    </script>
@stop

