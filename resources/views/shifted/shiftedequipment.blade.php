@extends('layouts.appnew')
@section('pageTitle', 'Manage User Complaint')
@section('content')
    <div class="row">
        <div class="col-md-10" style="padding-left: 200px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Customer Site Shift</h3>
                </div>
                <div class="panel-body">
                    {{ Form::open(array('url' => 'storeshiftequipment')) }}
                    <div class="row mt-2 {{ $errors->has('customers') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Contractno No</label>
                        <div class="col-sm-6">
                            {{ Form::select('contractno', $contractnolist,null, array('placeholder' => '--SELECT--','id'=>'contractnoid', 'class' => 'selectize' ,'onchange'=>'contractdetails(); return false;')) }}
                            @if ($errors->has('customers'))
                                <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-2 {{ $errors->has('customers') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                        <div class="col-sm-6">
                            {{ Form::select('customercode', $customerlist,null, array('placeholder' => '--SELECT--','id' => 'customers', 'class' => 'selectize')) }}
                            @if ($errors->has('customers'))
                                <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="row{{ $errors->has('customersite') ? ' has-error' : '' }}" >
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Site</label>
                        <div class="col-sm-6">
                            {{--{{ Form::select('customersite', $branchlist, null,  array('placeholder' => '--SELECT--','id' => 'customersite', 'class' => 'selectize')) }}--}}
                            {{ Form::select('customersite',array(null => '--SELECT--'),null, array('required' => 'required', 'id' => 'customersite', 'class' => 'selectize','onchange'=>'getproductwiseequipment(); return false;')) }}
                            @if ($errors->has('customersite'))
                                <span class="help-block"><strong>{{ $errors->first('customersite') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    {{--<div class="row{{ $errors->has('productservice') ? ' has-error' : '' }}">--}}
                        {{--<label for="input" class="col-sm-4 col-form-label text-muted">Product & Service</label>--}}
                        {{--<div class="col-sm-6">--}}
                            {{--{{ Form::select('productservicecode', $productlist, null,  array('placeholder' => '--SELECT--','id' => 'productservice', 'class' => 'selectize')) }}--}}
                            {{--@if ($errors->has('productservice'))--}}
                                {{--<span class="help-block"><strong>{{ $errors->first('productservice') }}</strong></span>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row{{ $errors->has('productservice') ? ' has-error' : '' }}">--}}
                        {{--<label for="input" class="col-sm-4 col-form-label text-muted">Category</label>--}}
                        {{--<div class="col-sm-6">--}}
                            {{--{{ Form::select('categorycode',array(null => '--SELECT--'),null, array('required' => 'required', 'id' => 'category', 'class' => 'selectize','onchange'=>'getproductwiseequipment(); return false;')) }}--}}
                            {{--@if ($errors->has('productservice'))--}}
                                {{--<span class="help-block"><strong>{{ $errors->first('productservice') }}</strong></span>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div id="chkall" hidden>
                        <input type="checkbox" id="checkAll" > Check All
                    </div>
                    <div id="productservicesrnoid" class="row col-md-12">

                    </div>
                    <div class="row{{ $errors->has('callername') ? ' has-error' : '' }} mt-2">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Specifications</label>
                        <div class="col-sm-6">
                            {{ Form::textarea('specification',null, array('class' => 'form-control form-control-sm','rows' => 3)) }}
                            @if ($errors->has('callername'))
                                <span class="help-block"><strong>{{ $errors->first('callername') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="row{{ $errors->has('callername') ? ' has-error' : '' }} mt-2">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Installation Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('installationdate',null, array('class' => 'form-control form-control-sm')) }}
                            @if ($errors->has('callername'))
                                <span class="help-block"><strong>{{ $errors->first('callername') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="row{{ $errors->has('callername') ? ' has-error' : '' }} mt-2">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Warranty/AMC</label>
                        <div class="col-sm-6">
                            {{ Form::text('warrantyamc',null, array('class' => 'form-control form-control-sm')) }}
                            @if ($errors->has('callername'))
                                <span class="help-block"><strong>{{ $errors->first('callername') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="row{{ $errors->has('callername') ? ' has-error' : '' }} mt-2">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Warranty/AMC End Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('warrantyamcenddate',null, array('class' => 'form-control form-control-sm','id'=>'warrantyamcendid','readonly')) }}
                            @if ($errors->has('callername'))
                                <span class="help-block"><strong>{{ $errors->first('callername') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="row{{ $errors->has('callername') ? ' has-error' : '' }} mt-2">
                        <label for="input" class="col-sm-4 col-form-label text-muted">AMC Amount</label>
                        <div class="col-sm-6">
                            {{ Form::text('amcamount',null, array('class' => 'form-control form-control-sm','id'=>'amcamountid','readonly')) }}
                            @if ($errors->has('callername'))
                                <span class="help-block"><strong>{{ $errors->first('callername') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="row{{ $errors->has('customersite') ? ' has-error' : '' }} mt-2" >
                        <label for="input" class="col-sm-4 col-form-label text-muted">New Customer Site</label>
                        <div class="col-sm-6">
                            {{ Form::select('newcustomersite', $branchlist, null,  array('placeholder' => '--SELECT--','id' => 'newcustomersiteid','class'=>'selectize')) }}
                            @if ($errors->has('customersite'))
                                <span class="help-block"><strong>{{ $errors->first('customersite') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="row{{ $errors->has('callername') ? ' has-error' : '' }} mt-2">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Shift Remarks</label>
                        <div class="col-sm-6">
                            {{ Form::textarea('shiftremarks',null, array('class' => 'form-control form-control-sm','rows' => 3)) }}
                            @if ($errors->has('callername'))
                                <span class="help-block"><strong>{{ $errors->first('callername') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="row{{ $errors->has('callername') ? ' has-error' : '' }} mt-2">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Shift Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('shiftdate',null, array('class' => 'form-control form-control-sm')) }}
                            @if ($errors->has('callername'))
                                <span class="help-block"><strong>{{ $errors->first('callername') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="row" >
                        <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                        <div class="col-sm-6">
                            <br>
                            {{ Form::submit('Transfer ', array('class' => 'btn btn-primary','onclick'=>'return chkdropvalues();')) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('selectize-script')
    <script src="{{ asset('http://loudev.com/js/jquery.multi-select.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#departmentsSelectable').multiSelect({
                afterSelect: function(values){
                    alert("Select value: "+values);
                }
            });

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.selectize').selectize({
                maxItems: 1
            });
            $('#productserialno').selectize({
                maxItems: 1
            });
        });
        $("#customers").change(function () {
            var branchlist = [];
            if ($('#customers').val() != "") {
                $.ajax({
                    url: "{{URL::to('registration/branch/')}}/" + $('#customers').val(),
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            branchlist.push({
                                text: value['branchname'],
                                value: value['branchcode'],
                            })
                        });

                        $('#customersite').selectize()[0].selectize.destroy();

                        if(branchlist.length > 0) {
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
                                options:null
                            });
                        }
                    }
                });
            }
            else{

                $('#customersite').selectize()[0].selectize.destroy();
                $('#customersite').selectize({
                    options: null
                });
            }
        })
        $('#productservice').change(function () {
            if ($('#productservice').val() != "") {
                var categorylist = [];
                $.ajax({
                    url: "{{URL::to('registration/category/')}}/" + $('#productservice').val(),
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
                        $('#category').selectize()[0].selectize.destroy();
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
                });
            }
            else{
                $('#category').selectize()[0].selectize.destroy();
                $('#category').selectize({
                    options:null
                });
                $('#subcategory').selectize()[0].selectize.destroy();
                $('#subcategory').selectize({
                    options:null
                });
            }
        });
        function getproductwiseequipment() {
            debugger
            if ($('#customersite').val() != "") {
                $.ajax({
                    url: '{{ url('/getproductwiseequipment/{data}') }}/',
                    type: "GET",
                    dataType: "json",
                    data : {
                        customersite : $("#customersite").val(),
                    },
                    success: function (data) {
                        debugger
                        if(data.length > 0)
                        {
                            debugger
                            $('#productservicesrnoid').empty();
                            var appendtagsequipement = "";
                            appendtagsequipement+="<table id='mytableid' style='border: silver 2px solid;'  width='40%'><tr><td></td><td style='padding-left: 80px;'><b>Equipment Sr No</b></td>" +
                                "<td style='padding-left: 50px;'><b>Branch Name</b></td>"+
                                "<td style='padding-left: 45px;'><b>Product Name</b></td>"+
                                "<td style='padding-left: 15px;'><b>Category Name</b></td>"+
                                "<td style='padding-left: 25px;'><b>Specification</b></td>"+
                                "</tr>"
                            for (var i = 0; i < data.length; i++) {
                                appendtagsequipement+="<tr style='line-height:1.6;'>" +
                                    "<td><input name='equipmentsrno[]' type='checkbox' value='"+data[i].equipmentsrno+"'></td>"+
                                    "<td style='padding-left: 15px;'><input type='text' value='"+data[i].equipmentsrno+"' readonly style='width: 250px;' ></td>" +
                                    "<td  style='padding-left: 8px;'><input type='text' value='"+data[i].branchname+"' readonly style='width: 180px;' ></td>" +
                                    "<td  style='padding-left: 13px;'><input type='hidden' name='productservicecode[]' value='"+data[i].productservicecode+"'><input type='text' value='"+data[i].productservicename+"' readonly  style='width: 90px;' ></td>" +
                                    "<td  style='padding-left: 13px;'><input type='hidden' name='categorycode[]' value='"+data[i].categorycode+"'><input type='text' value='"+data[i].categoryname+"' readonly  style='width: 90px;' ></td>" +
                                    "<td  style='padding-left: 30px;'><input  type='text' name='exitspecification[]' value='"+data[i].specification+"' readonly style='width: 180px;' ></td>" +
                                    "</tr>"
                            }
                            appendtagsequipement+="</table>";
                            appendtagsequipement+="</br>";
                            $('#productservicesrnoid').append(appendtagsequipement);
                            $('#chkall').show();
                        }
                        else
                        {
                            $('#productservicesrnoid').empty();
                            $("#mytableid").empty();
                            alert('There is No Data')
                            {{--window.location.href = '{{URL::to('shiftedequipment')}}';--}}
                        }

                    }
                });
            }
        }
        function contractdetails() {
            debugger
            $.ajax({
                url: "{{URL::to('getcontractdetails/')}}/" + $('#contractnoid').val(),
                type: "GET",
                dataType: "json",
                success: function (data) {
                    debugger
                    $('#amcamountid').val(data.totalcost);
                    $('#warrantyamcendid').val(data.closuredate);
                }
            });
        }

//        function chkall() {
        $('#checkAll').click(function () {
            debugger
            $('input:checkbox').prop('checked', this.checked);
        });
//        }
    </script>
    <script type="text/javascript">
        function chkdropvalues() {
            debugger
            if ($('#contractnoid').val() != "") {
                if($('#customers').val() != "")
                {
                    if($("#customersite").val() !="")
                    {
                        if($("#newcustomersiteid").val() !="")
                        {

                        }
                        else
                        {
                            alert("Select New Customer Site")
                            return false;
                        }
                    }
                    else
                    {
                        alert('Select Customer Site')
                        return false;
                    }
                }
                else
                {
                    alert('Select Customer Name')
                    return false;
                }
            }
            else
            {
                alert("Select Contract No")
                return false;
            }
        };
    </script>
@stop