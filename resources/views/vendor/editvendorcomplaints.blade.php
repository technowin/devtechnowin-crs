@extends('layouts.appnew')
@section('page-css')
    <link href="{{ asset('assets/Selectize/css/selectize.css') }}" rel="stylesheet">

@stop
@section('content')

    @if (session('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="text-muted">Edit Complaint<small>( Hello! )</small></span>
                </h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array('url' => 'updatevendor','files' => true ,'id'=>'form')) }}
                {{ Form::hidden('contractno', '', array('id' => 'contractnoid')) }}
                {{ Form::hidden('ticketno', $data->ticketno, array('id' => 'contractnoid')) }}
                {{ Form::hidden('id', $data->id, array('id' => 'contractnoid')) }}

                <div class="row{{ $errors->has('customers') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Ticket No </label>
                    <div class="col-sm-6">
                        {{ Form::text('ticketno', $data->ticketno, array('class'=>'form-control','readonly'=>'true')) }}
                        @if ($errors->has('customers'))
                            <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('customers') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name </label>
                    <div class="col-sm-6">
                        {{ Form::text('customers',  $customercode->customername, array('class'=>'form-control','readonly'=>'true', 'id' => 'customers')) }}
                        @if ($errors->has('customers'))
                            <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('productserialno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product Serial No</label>
                    <div class="col-sm-6">
                        {{ Form::text('productserialno',$equipmentcode, array('class'=>'form-control','id' => 'productserialno','readonly'=>'true')) }}
                        @if ($errors->has('productserialno'))
                            <span class="help-block"><strong>{{ $errors->first('productserialno') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('workorderno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Workorder No </label>
                    <div class="col-sm-6">
                        {{ Form::text('workorderno',$workordercode, array('class'=>'form-control','id' => 'workordernoid','readonly'=>'true')) }}
                        @if ($errors->has('workorderno'))
                            <span class="help-block"><strong>{{ $errors->first('workorderno') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('customersite') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Site </label>
                    <div class="col-sm-6">
                        {{ Form::text('customersite',$customersitecode, array('class'=>'form-control','readonly'=>'true','id' => 'customersite')) }}
                        @if ($errors->has('customersite'))
                            <span class="help-block"><strong>{{ $errors->first('customersite') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('productservice') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product & Service </label>
                    <div class="col-sm-6">
                        {{ Form::text('productservice',$productservicecode, array('id' => 'productservice','class'=>'form-control','readonly'=>'true')) }}
                        @if ($errors->has('productservice'))
                            <span class="help-block"><strong>{{ $errors->first('productservice') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('category') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Category</label>
                    <div class="col-sm-6">
                        {{ Form::text('category',$categorycode, array('class'=>'form-control','readonly'=>'true', 'id' => 'category')) }}
                        @if ($errors->has('productservice'))
                            <span class="help-block"><strong>{{ $errors->first('category') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('sub-category') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Sub-Category</label>
                    <div class="col-sm-6">
                        {{ Form::text('subcategory',  $subcategorycode, array('class'=>'form-control','readonly'=>'true','id' => 'subcategory', 'rel' => URL::to('/'))) }}
                        @if ($errors->has('subcategory'))
                            <span class="help-block"><strong>{{ $errors->first('subcategory') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('complaintdescription') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Complaint Description <br/>(Max 500
                        Chars)</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('complaintdescription',$data->complaintdescription,['class'=>'form-control', 'rows' => 3, 'cols' => 40, 'required' => 'required','onKeyPress' => "if(this.value.length==500) return false;"]) }}
                        @if ($errors->has('complaintdescription'))
                            <span class="help-block"><strong>{{ $errors->first('complaintdescription') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('callername') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Caller Name</label>
                    <div class="col-sm-6">
                        {{--                        {{ Form::text('callername', $data->callername, array('class' => 'form-control')) }}--}}
                        {{ Form::text('callername',$data->callername, array('class'=>'form-control','readonly'=>'true','id' => 'callernameidd')) }}
                        @if ($errors->has('callername'))
                            <span class="help-block"><strong>{{ $errors->first('callername') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('callermobile') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Caller Mobile</label>
                    <div class="col-sm-6">
                        {{ Form::number('callermobile',$data->mobilenumber , array('class'=>'form-control','readonly'=>'true','min' => 0,'onKeyPress' => "if(this.value.length==10) return false;",'id'=>'callermobilenoid' )) }}
                        @if ($errors->has('callermobile'))
                            <span class="help-block"><strong>{{ $errors->first('callermobile') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('calleremail') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Caller Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('calleremail',$data->emailid, array('class'=>'form-control','readonly'=>'true','id'=>'calleremailid')) }}
                        @if ($errors->has('calleremail'))
                            <span class="help-block"><strong>{{ $errors->first('calleremail') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row mt-2 {{ $errors->has('priority') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Priority</label>
                    <div class="col-sm-6">
                        {{ Form::text('priority',  $data->priority, array('class'=>'form-control','readonly'=>'true', 'id' => 'priority')) }}
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
                        {{ Form::select('typeofcall', $complainttype, $complainttypecode, array('class'=>'form-control','placeholder' => '--SELECT--', 'id' => 'customers')) }}
                    </div>
                </div>
                <br>
                <div class="row">
                    <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                    <div class="col-sm-2">
                        {{ Form::submit('Save & Close', array('class' => 'btn btn-primary offset-4','onclick'=>'return chkdropvalues();')) }}

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

@endsection

@section('selectize-script')
    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script>

        $(document).ready(function () {
            $("#typeofcalldiv").hide();
            // $('#callernameidd').selectize({
            //     delimiter: ',',
            //     persist: false,
            //     create: function(input) {
            //         return {
            //             value: input,
            //             text: input
            //         }
            //     }
            // });

            // $('#productservice').selectize({
            //     maxItems: 1
            // });

            // $('#category').selectize({
            //     maxItems: 1
            // });
            //
            // $('#subcategory').selectize({
            //     maxItems: 1
            // });

            // $('#priority').selectize({
            //     maxItems: 1
            // });

            // $('#customers').selectize({
            //     maxItems: 1
            // });

            // $('#customersite').selectize({
            //     maxItems: 1
            // });
            // $('#productserialno').selectize({
            //     maxItems: 1
            // });
            // $('#workordernoid').selectize({
            //     maxItems: 1
            // });


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

                            $('#productserialno').selectize()[0].selectize.destroy();

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
                            }
                            else {
                                $('#productserialno').selectize({
                                    options: null
                                });

                            }
                        }
                    });
                }
                else {

                    $('#productserialno').selectize()[0].selectize.destroy();
                    $('#productserialno').selectize({
                        options: null
                    });


                }
            });

            $('#productserialno').change(function () {
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
                            debugger
                            if(data.data[0].workorderno !=null){
                                $('#contractnoid').val(data.data[0].contractno);
                                $('#workordernoid').selectize()[0].selectize.destroy();
                                $("#workordernoid").empty();
                                $('#workordernoid').append('<option value="" selected disabled>--SELECT--</option>');
                                $('#workordernoid').append('<option  value="'+data.data[0].workorderno+'" selected>'+data.data[0].workorderno+'</option>');
                                $('#workordernoid').selectize();
                            }
                            else {
                                $('#workordernoid').selectize()[0].selectize.destroy();
                                $("#workordernoid").empty();
                                $('#workordernoid').append('<option value="" selected disabled>--SELECT--</option>');
                                $('#workordernoid').selectize();
                            }

                            $('#customersite').selectize()[0].selectize.destroy();
                            $("#customersite").empty();
                            $('#customersite').append('<option value="" selected disabled>--SELECT--</option>');
                            $('#customersite').append('<option  value="'+data.data[0].branchcode+'" selected>'+data.data[0].branchname+'</option>');
                            $('#customersite').selectize();

                            $('#productservice').selectize()[0].selectize.destroy();
                            $("#productservice").empty();
                            $('#productservice').append('<option value="" selected disabled>--SELECT--</option>');
                            $('#productservice').append('<option  value="'+data.data[0].productservicecode+'" selected>'+data.data[0].productservicename+'</option>');
                            $('#productservice').selectize();

                            $('#category').selectize()[0].selectize.destroy();
                            $("#category").empty();
                            $('#category').append('<option value="" selected disabled>--SELECT--</option>');
                            $('#category').append('<option  value="'+data.data[0].categorycode+'" selected>'+data.data[0].categoryname+'</option>');
                            $('#category').selectize();

                            $('#callernameidd').selectize()[0].selectize.destroy();
                            $("#callernameidd").empty();
                            $('#callernameidd').append('<option value="" selected disabled>--SELECT--</option>');
                            if(data.branchcontactlist.length > 0)
                            {
                                $('#callernameidd').append('<option  value="'+data.branchcontactlist[0].branchcontactcode+'" selected>'+data.branchcontactlist[0].contactpersonname+'</option>');
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
                                $("#callermobilenoid").val(data.branchcontactlist[0].phone);
                                $("#calleremailid").val(data.branchcontactlist[0].emailid)

                            }
                            else {
                                $("#callermobilenoid").val('');
                                $("#calleremailid").val('');
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
                            }

                            GetSubCategory();
                        }

                    });
                }
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
                                    value: value['subcategorycode']
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
            if ($('#customers').val() != "") {
                if($('#customersite').val() != "")
                {
                    if($('#productservice').val() != "")
                    {
                        if($('#category').val() != "")
                        {
                            if($('#subcategory').val() != ""){

                                if($('#productserialno').val() != ""){

                                }
                                else {
                                    alert('Select Product Serial No');
                                    return false;
                                }
                            }
                            else{
                                alert('Select Sub Category');
                                return false;
                            }
                        }
                        else {
                            alert('Select Category');
                            return false;
                        }
                    }
                    else {
                        alert('Select Product & Service');
                        return false;
                    }
                }
                else
                {
                    alert('Select Customer Site');
                    return false;
                }
            }
            else
            {
                alert("Select Customer Name");
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

@stop

