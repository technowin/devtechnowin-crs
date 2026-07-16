@extends('layouts.appnew')
@section('page-css')
    <link href="{{ asset('assets/Selectize/css/selectize.css') }}" rel="stylesheet">

@stop
@section('content')

    @if (Session::has('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div>
                    <h3 class="panel-title"><span class="text-muted">Lodge New Complaint <small> ( admin access )</small></span>
                    </h3>
                </div>
                <div id="contractdetailsid" style="display: none;">
                    <a  href="#" data-toggle="modal" data-target=".bs-example-modal-lg"> <b>Contract Details</b></a>
                </div>
            </div>
            <div class="panel-body">
                {{ Form::open(array('action' => 'AppAdminController@storeComplaint','method' => 'post', 'role' => 'form-horizontal', 'invalidate' => 'invalidate','class'=>'onSave', 'onsubmit' => 'return chkdropvalues();')) }}
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
                <div class="row{{ $errors->has('productserialno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Equipment Serial No</label>
                    <div class="col-sm-6">
                        {{ Form::select('productserialno',array(null => '--SELECT--'),null, array('id' => 'productserialno')) }}
                        {{--{{ Form::select('productserialno', $productservice, null, array('placeholder' => '--SELECT--', 'id' => 'productserialno')) }}--}}
                        @if ($errors->has('productserialno'))
                            <span class="help-block"><strong>{{ $errors->first('productserialno') }}</strong></span>
                        @endif
                    </div>
                </div>
{{--                Added--}}
                <div class="row{{ $errors->has('productsrno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product Serial No</label>
                    <div class="col-sm-6">
                        {{ Form::select('productsrno',array(null => '--SELECT--'),null, array('id' => 'productsrno')) }}
                        {{--{{ Form::select('productsrno', $productservice, null, array('placeholder' => '--SELECT--', 'id' => 'productsrno')) }}--}}
                        @if ($errors->has('productsrno'))
                            <span class="help-block"><strong>{{ $errors->first('productsrno') }}</strong></span>
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
                        {{ Form::select('callername',array(null => '--SELECT--'),null, array('id' => 'callernameidd')) }}
                        @if ($errors->has('callername'))
                            <span class="help-block"><strong>{{ $errors->first('callername') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('callermobile') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Caller Mobile</label>
                    <div class="col-sm-6">
                        {{ Form::number('callermobile', '', array('class' => 'form-control','required' => 'required','min' => 0,'onKeyPress' => "if(this.value.length==10) return false;",'id'=>'callerphoneid', 'onfocusout' => 'mobile()')) }}
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
{{--                        {{ Form::submit('Save & Close', array('class' => 'btn btn-primary offset-4','onclick'=>'return chkdropvalues();')) }}--}}
                        {{ Form::submit('Save & Close', array( 'id'=>'btnsubmitid','class' => 'btn btn-primary offset-4','onclick' => 'return mobile()')) }}
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

            // $('#sitecontactpersonid').selectize({
            //     maxItems: 1
            // });
            $('#callernameidd').selectize({
                delimiter: ',',
                persist: false,
                create: function(input) {
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
                var workorderlist = [];
                debugger
                if ($('#customers').val() != "") {
                    $.ajax({
                        url: "{{URL::to('getworkorderno/')}}/" + $('#customers').val(),
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $.each(data, function (key, value) {
                                workorderlist.push({
                                    text: value['workorderno'],
                                    value: value['workorderno'],
                                })
                            });
                            debugger;

                            $('#workordernoid').selectize()[0].selectize.destroy();

                            if (workorderlist.length > 0) {
                                $('#workordernoid').selectize({
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
                                $('#workordernoid').selectize({
                                    options: null
                                });
                            }
                        }
                    });
                }
                else {

                    $('#workordernoid').selectize()[0].selectize.destroy();
                    $('#workordernoid').selectize({
                        options: null
                    });
                }
            });
            $("#workordernoid").change(function () {
                var branchlist = [];
                if ($('#workordernoid').val() != "") {
                    $.ajax({
                        url: "{{URL::to('getworkordernowisebranch/{data}')}}/",
                        type: "GET",
                        dataType: "json",
                        data: {
                            workordernoid: $('#workordernoid').val(),
                        },
                        success: function (data) {
                            $.each(data.branchlist, function (key, value) {
                                branchlist.push({
                                    text: value['branchname'],
                                    value: value['branchcode'],
                                })
                            });
                            $('#customersite').selectize()[0].selectize.destroy();
                            if (branchlist.length > 0) {
                                $('#customersite').selectize({
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
                                $('#customersite').selectize({
                                    options: null
                                });
                            }
                            $('#contractnoid').val(data.contractno);
                            if(data.fromdate !="1970-01-01"){
                                if(data.fromdate !="1900-01-01")
                                {
                                    $("#fromdateid").val(data.fromdate);
                                    $("#todateid").val(data.todate);
                                    $("#workordertypeid").val(data.workordertype);
                                    $("#comprehensivetypeid").val(data.workordertype);
                                    $("#contractdetailsid").show();
                                }
                                else {
                                    $("#fromdateid").val('');
                                    $("#todateid").val('');
                                    $("#contractdetailsid").show();
                                }
                            }
                            else {
                                $("#fromdateid").val('');
                                $("#todateid").val('');
                                $("#contractdetailsid").show();
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
            $('#customersite').change(function () {
                $("#productservice").empty();
                $("#category").empty();
                $("#productserialno").empty();
                $("#productsrno").empty();

                if ($('#customersite').val() != "") {
                    $.ajax({
                        url: "{{URL::to('getequipment/')}}/" + $('#customersite').val(),
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            debugger
                            $('#productserialno').selectize()[0].selectize.destroy();
                            $('#productsrno').selectize()[0].selectize.destroy();
                            // $('#category').selectize()[0].selectize.destroy();
                            $('#productservice').selectize()[0].selectize.destroy();
                            $('#callernameidd').selectize()[0].selectize.destroy();
                            $("#productservice").empty();
                            // $("#category").empty();
                            $("#productserialno").empty();
                            $("#productsrno").empty();
                            $("#callernameidd").empty();
                            $('#productserialno').append('<option value="" selected disabled>--SELECT--</option>');
                            $('#productsrno').append('<option value="" selected disabled>--SELECT--</option>');
                            // $('#category').append('<option value="" selected disabled>--SELECT--</option>');
                            $('#productservice').append('<option value="" selected disabled>--SELECT--</option>');
                            $('#callernameidd').append('<option value="" selected disabled>--SELECT--</option>');

                            for (var i = 0; i < data.equipmentsnolist.length; i++) {

                                if(data.equipmentsnolist[i] != undefined)
                                {
//                                    $('#productserialno').append('<option value="'+data.equipmentsnolist[i].equipmentsrno+'">'+data.equipmentsnolist[i].equipmentsrno+'</option>');
                                }

                                if( data.productservicelist[i] != undefined)
                                {
                                    $("#productservice").append($("<option>" + "  " + + "</option>" +"<option value=" + data.productservicelist[i].productservicecode + ">" + data.productservicelist[i].productservicename + "</option>"));
                                }
                                // if(data.categorylist[i] != undefined){
                                //       $("#category").append($("<option>" + "  " + + "</option>" +"<option value = " + data.categorylist[i].categorycode + ">" + data.categorylist[i].categoryname + "</option>"));
                                // }
                            }
                            debugger
                            for (var n =0; n < data.branchcontactmaster.length;n++)
                            {
                                $("#callernameidd").append($("<option>" + "  " + + "</option>" +"<option value=" + data.branchcontactmaster[n].branchcontactcode+ ">" + data.branchcontactmaster[n].contactpersonname + "</option>"));
                            }
                            $('#callernameidd').selectize({
                                delimiter: ',',
                                persist: false,
                                create: function(input) {
                                    return {
                                        value: input,
                                        text: input
                                    }
                                }
                            });
                            $('#productserialno').selectize();
                            $('#productsrno').selectize();
                            // $('#category').selectize();
                            $('#productservice').selectize();

                        }

                    });
                }
            });
            $('#productservice').change(function(){
                var test = $('#productservice').val();
                $("#category").empty();
                if ($('#productservice').val() != "") {
                    debugger
                    $.ajax({
                        url: "{{URL::to('getcategory/')}}/" + $('#productservice').val()+"/"+$('#customersite').val(),
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            debugger
                            $('#category').selectize()[0].selectize.destroy();
                            $("#category").empty();
                            $('#category').append('<option value="" selected disabled>--SELECT--</option>');

                            for (var i = 0; i < data.categorylist.length; i++) {
                                if (data.categorylist[i] != undefined) {
                                    $("#category").append($("<option>" + "  " + +"</option>" + "<option value = " + data.categorylist[i].categorycode + ">" + data.categorylist[i].categoryname + "</option>"));
                                }
                            }
                            $('#category').selectize();
                        }
                    })
                }
            });

            $('#category').change(function () {
                $("#subcategory").empty();
                $("#productserialno").empty();
                $("#productsrno").empty();

                if ($('#category').val() != "") {
                    $.ajax({
                        url: "{{URL::to('getequipmentproductsrno/{data}')}}/",
                        type: "GET",
                        dataType: "json",
                        data: {
                            productservice: $('#productservice').val(),
                            contractnoid: $('#contractnoid').val(),
                            customerscode: $('#customers').val(),
                            branchcode: $('#customersite').val(),
                            categorycode: $("#category").val()
                        },
                        success: function (data) {
                            $('#productserialno').selectize()[0].selectize.destroy();
                            $('#productsrno').selectize()[0].selectize.destroy();
                            $('#subcategory').selectize()[0].selectize.destroy();
                            $("#subcategory").empty();
                            $("#productserialno").empty();
                            $("#productsrno").empty();
                            $('#productserialno').append('<option value="" selected disabled>--SELECT--</option>');
                            $('#productsrno').append('<option value="" selected disabled>--SELECT--</option>');
                            $('#subcategory').append('<option value="" selected disabled>--SELECT--</option>');

                            for (var i = 0; i < data.productsrnolist.length; i++) {
                                if(data.productsrnolist[i] != undefined)
                                {
                                    $('#productserialno').append('<option value="'+data.productsrnolist[i].equipmentsrno+'">'+data.productsrnolist[i].equipmentsrno+'</option>');
                                }
                            }for (var i = 0; i < data.productsrnolist.length; i++) {
                                if(data.productsrnolist[i] != undefined)
                                {
                                    $('#productsrno').append('<option value="'+data.productsrnolist[i].productsrno+'">'+data.productsrnolist[i].productsrno+'</option>');
                                }
                            }
                            for (var n =0;n < data.subcategorylist.length; n++)
                            {
                                if(data.subcategorylist[n] != undefined){
                                    $("#subcategory").append($("<option>" + "  " + + "</option>" +"<option value = " + data.subcategorylist[n].subcategorycode + ">" + data.subcategorylist[n].subcategoryname + "</option>"));
                                }
                            }

                            $('#productserialno').selectize();
                            $('#productsrno').selectize();
                            $('#subcategory').selectize();
                        }

                    });
                }
            });
            {{--$("#productservice").change(function () {--}}
            {{--    var categorylist = [];--}}
            {{--    if ($('#productservice').val() != "") {--}}

            {{--        $.ajax({--}}
            {{--            url: "{{URL::to('registration/category/')}}/" + $('#productservice').val(),--}}
            {{--            type: "GET",--}}
            {{--            dataType: "json",--}}
            {{--            success: function (data) {--}}
            {{--                $.each(data, function (key, value) {--}}
            {{--                    categorylist.push({--}}
            {{--                        text: value['categoryname'],--}}
            {{--                        value: value['categorycode'],--}}
            {{--                    })--}}
            {{--                });--}}

            {{--                $('#category').selectize()[0].selectize.destroy();--}}

            {{--                if (categorylist.length > 0) {--}}
            {{--                    $('#category').selectize({--}}
            {{--                        maxItems: 1,--}}
            {{--                        valueField: 'value',--}}
            {{--                        labelField: 'text',--}}
            {{--                        searchField: 'text',--}}
            {{--                        create: false,--}}
            {{--                        sortField: {--}}
            {{--                            field: 'text',--}}
            {{--                            direction: 'asc'--}}
            {{--                        },--}}
            {{--                        options: categorylist,--}}
            {{--                    });--}}
            {{--                }--}}
            {{--                else {--}}
            {{--                    $('#category').selectize({--}}
            {{--                        options: null--}}
            {{--                    });--}}
            {{--                }--}}
            {{--            }--}}
            {{--        });--}}
            {{--    }--}}
            {{--    else {--}}

            {{--        $('#category').selectize()[0].selectize.destroy();--}}
            {{--        $('#category').selectize({--}}
            {{--            options: null--}}
            {{--        });--}}
            {{--    }--}}
            {{--});--}}
        });

    </script>
    <script>
        $(".onSaves").on("submit", function () {
            var customerName = document.getElementById("customers");
            var customerNameselectedText = customerName.options[customerName.selectedIndex].text;

            var customerSite = document.getElementById("customersite");
            var customerSiteselectedText = customerSite.options[customerSite.selectedIndex].text;

            var productSerial = document.getElementById("productserialno");
            var productSerialselectedText = productSerial.options[productSerial.selectedIndex].text;
            var productSerial = document.getElementById("productsrno");
            var productSrNoselectedText = productSrNo.options[productSrNo.selectedIndex].text;


            if (customerNameselectedText != "") {
                if (customerSiteselectedText == "") {
                    alert('select customer site');
                    return false;
                } else if (productSerialselectedText == "" || productSrNoselectedText == "") {
                    if(productSerialselectedText == ""){
                        alert('select Equipment serial number');
                    }
                    else{
                        alert('select Product serial number');
                    }
                    return false;
                }
            } else {
                return confirm("Do you want to save this complaint without selecting Customer Name, Customer Site ,Product Serial Number ?");
            }
        });
    </script>

    <script type="text/javascript">
        function chkdropvalues() {
            $("#btnsubmitid").attr("disabled", true);
            if ($('#customers').val() != "") {
                if($('#workordernoid').val() != "")
                {
                    if($('#customersite').val() != "")
                    {
                        if($('#productservice').val() != "")
                        {
                            if($('#category').val() != "")
                            {
                                if($('#subcategory').val() != ""){

                                    if($('#productserialno').val() != "" || $('#productsrno').val() != "" ){

                                    }
                                    else {
                                        if($('#productserialno').val() == ""){
                                            alert('Select Equipment Serial No');
                                            $("#btnsubmitid").attr("disabled", false);
                                        }
                                        else{
                                            alert('Select Product Serial No');
                                            $("#btnsubmitid").attr("disabled", false);
                                        }

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
                    alert('Select Work Order No');
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
        }
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
                    $("#callerphoneid").val(data.phone);
                    $("#calleremailid").val(data.email);
                }
            });
        });
    </script>
    <script type="text/javascript">
        function mobile(){
            var number;
            debugger;
            number = document.getElementById('callerphoneid').value;
            if(number.length < 10){
                debugger;
                alert('Mobile no. must be of 10 digits.');
                return false;
            }
        }
    </script>
@stop

