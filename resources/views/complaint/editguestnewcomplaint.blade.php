@extends('layouts.appnew')
@section('page-css')
    <link href="{{ asset('assets/Selectize/css/selectize.css') }}" rel="stylesheet">

@stop
@section('content')
    @if (session('success-message'))
        <div class="alert alert-success">
            {{ session('success-message') }}
        </div>
    @endif

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="text-muted">Edit Complaint <small> ( admin access )</small></span>
                </h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array('url' => 'updateguestcomplaint','files' => true ,'id'=>'form')) }}
                {{ Form::hidden('ticketno',$data->ticketno) }}
                {{ Form::hidden('id',$data->id) }}
                <div class="row{{ $errors->has('customers') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Ticket No</label>
                    <div class="col-sm-6">
                        <label>{{$data->ticketno}}</label>
                    </div>
                </div>
                <div class="row{{ $errors->has('customers') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name </label>
                    <div class="col-sm-6">
                        {{ Form::text('customerscode', $customercode, array('class' => 'form-control', 'id' => 'customers','onchange'=>'myclick(); return false;','readonly'=>'true')) }}
                        @if ($errors->has('customers'))
                            <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('customers') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Type Of Call </label>
                    <div class="col-sm-6">
                        {{ Form::text('typeofcall', $complainttypecode, array('class' => 'form-control', 'id' => 'typeofcallid','readonly'=>'true')) }}
                        @if ($errors->has('customers'))
                            <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('productservice') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product & Service </label>
                    <div class="col-sm-6">
                        {{ Form::text('productservicecode',$productServicecode, array('class' => 'form-control','id' => 'productserviceid','readonly'=>'true')) }}
                        @if ($errors->has('productservice'))
                            <span class="help-block"><strong>{{ $errors->first('productservice') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('category') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Category</label>
                    <div class="col-sm-6">
                        {{ Form::text('categorycode',$categorycode, array('class' => 'form-control', 'id' => 'category','readonly'=>'true')) }}
                        @if ($errors->has('productservice'))
                            <span class="help-block"><strong>{{ $errors->first('category') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('sub-category') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Sub-Category</label>
                    <div class="col-sm-6">
                        {{ Form::text('subcategorycode', $subcategorycode, array('class' => 'form-control','id' => 'subcategory', 'rel' => URL::to('/'),'readonly'=>'true')) }}
                        @if ($errors->has('subcategory'))
                            <span class="help-block"><strong>{{ $errors->first('subcategory') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div  id="divtextproductsrnoid" class="row{{ $errors->has('productserialno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Equipment Serial No</label>
                    <div class="col-sm-6" id="divnewproductsrnoid">
                        {{ Form::text('textproductservicesrno',$data->productsrno_accountno,array('class'=>'form-control',  'id' => 'Productid','readonly'=>'true')) }}
                    </div>
                </div>

{{--                <div  id="divproductid" class="row{{ $errors->has('productsrno') ? ' has-error' : '' }}">--}}
{{--                    <label for="input" class="col-sm-4 col-form-label text-muted">p\Product Serial No</label>--}}
{{--                    <div class="col-sm-6" id="divnewproductid">--}}
{{--                        {{ Form::text('textproductservicesrno',$data->productsrno,array('class'=>'form-control',  'id' => 'productsrno','required'=>'required')) }}--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="row{{ $errors->has('complaintdescription') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Complaint Description <br/>(Max 500
                        Chars)</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('complaintdescription',$data->complaintdescription,['class'=>'form-control', 'rows' => 3, 'cols' => 40, 'onKeyPress' => "if(this.value.length==500) return false;"]) }}
                        @if ($errors->has('complaintdescription'))
                            <span class="help-block"><strong>{{ $errors->first('complaintdescription') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('callername') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Caller Name</label>
                    <div class="col-sm-6">
{{--                        {{ Form::text('callername', $data->callername, array('class' => 'form-control','required' => 'required')) }}--}}
                        {{ Form::TEXT('callername',$data->callername, array('class'=>'form-control','id' => 'callernameidd','readonly'=>'true')) }}
                        @if ($errors->has('callername'))
                            <span class="help-block"><strong>{{ $errors->first('callername') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('callermobile') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Caller Mobile</label>
                    <div class="col-sm-6">
                        {{ Form::number('callermobile', $data->mobilenumber, array('class' => 'form-control','min' => 0,'onKeyPress' => "if(this.value.length==10) return false;",'id'=>'callermobilenoid','onfocusout' => 'mobile()','readonly'=>'true' )) }}
                        @if ($errors->has('callermobile'))
                            <span class="help-block"><strong>{{ $errors->first('callermobile') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('calleremail') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Caller Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('calleremail',$data->emailid, array('class' => 'form-control','id'=>'calleremailid','readonly'=>'true')) }}
                        @if ($errors->has('calleremail'))
                            <span class="help-block"><strong>{{ $errors->first('calleremail') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row mt-2 {{ $errors->has('priority') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Priority</label>
                    <div class="col-sm-6">
                        {{ Form::text('priority', $data->priority, array('class' => 'form-control', 'id' => 'priority','readonly'=>'true')) }}
                        @if ($errors->has('priority'))
                            <span class="help-block"><strong>{{ $errors->first('priority') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row mt-2 {{ $errors->has('chargedcomplaint') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Charged Complaint</label>
                    <div class="col-sm-6">
                        {{Form::hidden('chargedcomplaint',0)}}
                        {{ Form::checkbox('chargedcomplaint', 1, $chargedcomplaint) }}
                        @if ($errors->has('chargedcomplaint'))
                            <span class="help-block"><strong>{{ $errors->first('chargedcomplaint') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                    <div class="col-sm-2">
                        {{ Form::submit('save & close', array('class' => 'btn btn-primary offset-4','onclick'=>'return chkdropvalues();','onclick' => 'return mobile()')) }}

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

            $("#divdropproductsrnoid").hide();
            // $('#productserviceid').selectize({
            //     maxItems: 1
            // });

            // $('#category').selectize({
            //     maxItems: 1
            // });

            // $('#subcategory').selectize({
            //     maxItems: 1
            // });

            // $('#priority').selectize({
            //     maxItems: 1
            // });

//            $('#customers').selectize({
//                maxItems: 1
//            });
//             $('#typeofcallid').selectize({
//                 maxItems: 1
//             });
            // $('#customers').selectize({
            //     delimiter: ',',
            //     persist: false,
            //     create: function(input) {
            //         return {
            //             value: input,
            //             text: input
            //         }
            //     }
            // });

            $("#productserviceid").change(function () {
                debugger
                var categorylist = [];
                if ($('#productserviceid').val() != "") {

                    $.ajax({
                        url: "{{URL::to('registration/category/')}}/" + $('#productserviceid').val(),
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            debugger
                            $.each(data, function (key, value) {
                                categorylist.push({
                                    text: value['categoryname'],
                                    value: value['categorycode'],
                                })
                            });

                            $('#category').selectize()[0].selectize.destroy();

                            if (categorylist.length > 0) {
                                $('#category').selectize({
                                    maxItems: 1,
                                    valueField: 'value',
                                    labelField: 'text',
                                    searchField: 'text',
                                    create: false,
                                    sortField: {
                                        field: 'text',
                                        direction: 'asc'
                                    },
                                    options: categorylist,
                                });
                            }
                            else {
                                $('#category').selectize({
                                    options: null
                                });
                            }
                        }
                    });
                }
                else {

                    $('#category').selectize()[0].selectize.destroy();
                    $('#category').selectize({
                        options: null
                    });
                }
            })

            $('#category').change(function () {
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
            });
        });

    </script>
    <script type="text/javascript">
        function chkdropvalues() {
            if ($('#customers').val() != "") {
                if($('#productserviceid').val() != "")
                {
                    if($('#category').val() != "")
                    {
                        if($('#priority').val() != "")
                        {

                        }
                        else {
                            alert('Select Priority')
                            return false;
                        }
                    }
                    else {
                        alert('Select Category')
                        return false;
                    }
                }
                else {
                    alert('Select Product & Service')
                    return false;
                }
            }
            else
            {
                alert("Select Customer Name")
                return false;
            }
        };

        function myclick() {
//         var values = document.getElementById('customers').innerText;
            var name  = $('#customers').text();
            if($('#customers').text() !="") {
                $.ajax({
                    url: "{{URL::to('chkcustomername/')}}/" + $('#customers').text(),
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        var values = "\'" + name + "\'";
                        if(data == null){
                            alert('Please create a new customer in master for '+values);
                            window.location.reload();
                        }
                        else
                        {
                            $.ajax({
                                url: "{{URL::to('getequipmentdetailsnewcustomer/')}}/" + $('#customers').val(),
                                type: "GET",
                                dataType: "json",
                                success: function (data) {
                                    $('#productsrnoid').selectize()[0].selectize.destroy();
                                    $("#productsrnoid").empty();
                                    $('#productsrnoid').append('<option value="" selected disabled>--SELECT--</option>');
                                    if(data.newequipmentlist.length > 0)
                                    {
                                        for(var i=0; i < data.newequipmentlist.length; i++)
                                        {
                                            $("#productsrnoid").append($("<option>" + "  " + + "</option>" +"<option value=" + data.newequipmentlist[i].equipmentsrno + ">" + data.newequipmentlist[i].equipmentsrno + "</option>"));
                                        }
                                        $("#divdropproductsrnoid").show();
                                        $("#divtextproductsrnoid").hide();
                                    }
                                    else
                                    {
                                        $("#divdropproductsrnoid").hide();
                                        $("#divtextproductsrnoid").show();
                                    }
                                    $('#productsrnoid').selectize();
                                }
                            });
                        }
                    }
                });
            }

        }
    </script>
    <script type="text/javascript">
        function  createnewequipmentsrno() {
            debugger
            $.ajax({
                url: "{{ URL::to('addequipmentdetailsnewcustomer/') }}",
                type: "GET",
                dataType: "json",
                success: function (data) {
                    debugger
                    $("#Productid").val(data);
                    $("#divtextproductsrnoid").show();
                    $("#divdropproductsrnoid").hide();
                }
            });
        }
    </script>

    <script type="text/javascript">
        $('#productsrnoid').change(function () {
            debugger
            if ($('#productsrnoid').val() != "") {
                $.ajax({
                    url: "{{URL::to('Getequipmentbyworkorderdata/{data}')}}/",
                    type: "GET",
                    dataType: "json",
                    data: {
                        id: $('#productsrnoid').val()
                    },
                    success: function (data) {
                        debugger
                        if(data.data.length > 0){
                            $('#callernameidd').selectize()[0].selectize.destroy();
                            $("#callernameidd").empty();
                            $('#callernameidd').append('<option value="" selected disabled>--SELECT--</option>');
                                // for (var i=0; i < data.data.length;i++){
                                    $('#callernameidd').append('<option  value="'+data.data[0].callername+'" selected>'+data.data[0].callername+'</option>');
                                // }
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
                                $("#callermobilenoid").val(data.data[0].mobilenumber)
                                $("#calleremailid").val(data.data[0].emailid)
                                document.getElementById("Productid").required = false;
                        }
                        else {
                            $("#callermobilenoid").val('');
                            $("#calleremailid").val('');
                            $('#callernameidd').selectize()[0].selectize.destroy();
                            $('#callernameidd').append('<option value="" selected disabled>--SELECT--</option>');
                            $("#callernameidd").empty();
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
                    }
                });
            }
        });

    </script>
    <script type="text/javascript">
        function mobile(){
            var number;
            debugger;
            number = document.getElementById('callermobilenoid').value;
            if(number.length < 10){
                debugger;
                alert('Mobile no. must be of 10 digits.');
                return false;
            }
        }
    </script>
@stop

