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
                <h3 class="panel-title"><span class="text-muted">Create New User Complaint <small> ( admin access )</small></span>
                </h3>
            </div>

            <div class="panel-body">
                {{ Form::open(array('url' => 'newcomplaint','files' => true ,'id'=>'form','onsubmit' => 'return chkdropvalues();')) }}
                <div class="row{{ $errors->has('customers') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name </label>
                    <div class="col-sm-6">
                        {{ Form::select('customerscode', $customers, null, array('placeholder' => '--SELECT--','required' => 'required', 'id' => 'customers','onchange'=>'myclick(); return false;')) }}
                        @if ($errors->has('customers'))
                            <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('customers') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Type Of Call </label>
                    <div class="col-sm-6">
                        {{ Form::select('typeofcall', $complainttype, null, array('placeholder' => '--SELECT--','required' => 'required', 'id' => 'typeofcallid')) }}
                        @if ($errors->has('customers'))
                            <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('productservice') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product & Service </label>
                    <div class="col-sm-6">
                        {{ Form::select('productservicecode',$productService,null, array('placeholder' => '--SELECT--','id' => 'productserviceid','required' => 'required')) }}
                        @if ($errors->has('productservice'))
                            <span class="help-block"><strong>{{ $errors->first('productservice') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('category') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Category</label>
                    <div class="col-sm-6">
                        {{ Form::select('categorycode',array(null => '--SELECT--'),null, array( 'id' => 'category')) }}
                        @if ($errors->has('category'))
                            <span class="help-block"><strong>{{ $errors->first('category') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row{{ $errors->has('sub-category') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Sub-Category</label>
                    <div class="col-sm-6">
                        {{ Form::select('subcategorycode', array('' => '--SELECT--'), null, array('id' => 'subcategory', 'rel' => URL::to('/'))) }}
                        @if ($errors->has('subcategory'))
                            <span class="help-block"><strong>{{ $errors->first('subcategory') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div  id="divtextproductsrnoid" class="row{{ $errors->has('productserialno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product Serial No</label>
                    <div class="col-sm-6" id="divnewproductsrnoid">
                        {{ Form::text('textproductservicesrno',null,array('class'=>'form-control',  'id' => 'Productid')) }}
                    </div>
                    <div class="col-sm-2">
                        <a href="" onclick="createnewequipmentsrno();return false;">Add Equipment</a>
                    </div>
                </div>
                <div id="divdropproductsrnoid"  class="row{{ $errors->has('productserialno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product Serial No</label>
                    <div class="col-sm-6">
                        {{ Form::select('productservicesrno',array(null => '--SELECT--'),null, array('id' => 'productsrnoid')) }}
                    </div>
                    <div class="col-sm-2">
                        <a href="" onclick="createnewequipmentsrno();return false;">Add Equipment</a>
                    </div>
                </div>
                <div class="row{{ $errors->has('complaintdescription') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Complaint Description <br/>(Max 500
                        Chars)</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('complaintdescription',null,['class'=>'form-control', 'rows' => 3, 'cols' => 40, 'onKeyPress' => "if(this.value.length==500) return false;"]) }}
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
                        {{ Form::number('callermobile', null, array('class' => 'form-control','required' => 'required','minlength' => 10,
                        'onKeyPress' => "if(this.value.length==10) return false;",'id'=>'callermobilenoid','onfocusout' => 'mobile()' )) }}
                        @if ($errors->has('callermobile'))
                            <span class="help-block"><strong>{{ $errors->first('callermobile') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('calleremail') ? ' has-error' : '' }}" style="margin-top: 0.5rem;">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Caller Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('calleremail',null, array('class' => 'form-control','required' => 'required','id'=>'calleremailid')) }}
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
                        {{ Form::checkbox('chargedcomplaint', 1, true) }}
                        {{--{{Form::checkbox('chargedcomplaint')}}--}}
                        @if ($errors->has('chargedcomplaint'))
                            <span class="help-block"><strong>{{ $errors->first('chargedcomplaint') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                    <div class="col-sm-2">
{{--                        {{ Form::submit('Save & Close', array('id'=>'btnsubmitid','class' => 'btn btn-primary offset-4','onclick'=>'return chkdropvalues();')) }}--}}
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

@endsection

@section('selectize-script')
    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script>
        $(document).ready(function () {
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
            $("#divdropproductsrnoid").hide();
            $('#productserviceid').selectize({
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
            $('#typeofcallid').selectize({
                maxItems: 1
            });
            $('#customers').selectize({
                delimiter: ',',
                persist: false,
                create: function(input) {
                    return {
                        value: input,
                        text: input
                    }
                }
            });
            $("#productserviceid").change(function () {
                var categorylist = [];
                if ($('#productserviceid').val() != "") {

                    $.ajax({
                        url: "{{URL::to('registration/category/')}}/" + $('#productserviceid').val(),
                        type: "GET",
                        dataType: "json",
                        success: function (data) {

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
            debugger
            $("#btnsubmitid").attr("disabled", true);
            if ($('#customers').val() != "") {
                if($('#productserviceid').val() != "")
                {
                    if($('#category').val() != "")
                    {
                        if($('#priority').val() != "")
                        {

                        }
                        else {
                            alert('Select Priority');
                            $("#btnsubmitid").attr("disabled", false);
                            return false;
                        }
                    }
                    else {
                        debugger
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
                alert("Select Customer Name");
                $("#btnsubmitid").attr("disabled", false);
                return false;
            }
            return true;
        };
        function myclick() {
            var name  = $('#customers').text();
            var customercode = $('#customers').val();
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
                            url: "{{URL::to('getequipmentdetailsnewcustomer/')}}/" + customercode,
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

        $("#Productid").keyup(function () {
           if($("#Productid").val() =="") {
               document.getElementById("Productid").required = true;
           }
        });


    </script>
    <script type="text/javascript">
        function  createnewequipmentsrno() {
            $.ajax({
                url: "{{URL::to('addequipmentdetailsnewcustomer/')}}",
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $("#Productid").val(data);
                    $("#divtextproductsrnoid").show();
                    $("#divdropproductsrnoid").hide();
                    $("#productsrnoid").val('');
                }
            });
        }

        $('#productsrnoid').change(function () {
            if ($('#productsrnoid').val() != "") {
                $.ajax({
                    url: "{{URL::to('Getequipmentbyworkorderdata/{data}')}}/",
                    type: "GET",
                    dataType: "json",
                    data: {
                        id: $('#productsrnoid').val()
                    },
                    success: function (data) {
                        $('#callernameidd').selectize()[0].selectize.destroy();
                        $("#callernameidd").empty();
                        $('#callernameidd').append('<option value="" selected disabled>--SELECT--</option>');
                        if(data.data.length > 0)
                        {
                            $('#callernameidd').append('<option  value="'+data.data[0].callername+'" selected>'+data.data[0].callername+'</option>');
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

        $("#btnsubmitid").click(function () {
            var textproduct = $("#Productid").val();
            var dropproduct = $("#productsrnoid").val();
            if(textproduct !="" || dropproduct !=""){
                return true;
            }
            else {
                alert('Fill Product sr no');;
                return  false;
            }
        })
    </script>
    <script type="text/javascript">
        function mobile(){
            var number;
            number = document.getElementById('callermobilenoid').value;
            if(number.length < 10){
                alert('Mobile no. must be of 10 digits.');
                return false;
            }
        }
    </script>
@stop

