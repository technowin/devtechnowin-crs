@extends('layouts.app')
@section('head-css')
    <link href="{{ asset('assets/Selectize/css/selectize.css') }}" rel="stylesheet">
@stop
@section('content')
    <div class="container card col-md-8">
        <div class="col card-body">
            <div class="row"  style="border-bottom: 1px solid darkgray">
                <div class="col-md-6"><h5 class="card-title text-muted">Lodge New Complaint <small> ( admin access )</small></h5></div>
                <div class="col-md-6"><img src="{{ asset('images/addcomplaint.png') }}" width="40" height="40" style="float: right; margin-top: -15px"/></div>
            </div>
            <div class="row mt-1">
                @if(session()->has('error-message'))
                    <div class="alert alert-danger mt-3" role="alert">
                        {{ session()->get('error-message') }}
                    </div>
                @endif
                @if(session()->has('success-message'))
                    <div class="alert alert-success mt-3" role="alert">
                        {{ session()->get('success-message') }}
                    </div>
                @endif
            </div>
            <div class="container">
                <br>
                {{Form::open(array('action' => 'ComplaintController@storeNewComplaint','method' => 'post', 'role' => 'form', 'invalidate' => 'invalidate', 'files'=>true,'class'=>'onSave'))}}
                <div class="row{{ $errors->has('customers') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                    <div class="col-sm-6">
                        {{ Form::select('customers', $customers, null, array('placeholder' => '--SELECT--','id' => 'customers')) }}
                        @if ($errors->has('customers'))
                            <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('customersite') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Site</label>
                    <div class="col-sm-6">
                        {{ Form::select('customersite',array(null => '--SELECT--'),null, array('id' => 'customersite')) }}
                        @if ($errors->has('customersite'))
                            <span class="help-block"><strong>{{ $errors->first('customersite') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('productservice') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product & Service</label>
                    <div class="col-sm-6">
                        {{ Form::select('productservice', $productService, null, array('placeholder' => '--SELECT--','required' => 'required', 'id' => 'productservice', 'rel' => URL::to('/'),'required' => 'required')) }}
                        @if ($errors->has('productservice'))
                            <span class="help-block"><strong>{{ $errors->first('productservice') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('category') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Category</label>
                    <div class="col-sm-6">
                        {{ Form::select('category',array(null => '--SELECT--'),null, array('required' => 'required', 'id' => 'category', 'rel' => URL::to('/'))) }}
                        @if ($errors->has('productservice'))
                            <span class="help-block"><strong>{{ $errors->first('category') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('sub-category') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Sub-Category</label>
                    <div class="col-sm-6">
                        {{ Form::select('subcategory', array('' => '--SELECT--'), null, array('required' => 'required', 'id' => 'subcategory', 'rel' => URL::to('/'))) }}
                        @if ($errors->has('subcategory'))
                            <span class="help-block"><strong>{{ $errors->first('subcategory') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('productserialno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product Serial No</label>
                    <div class="col-sm-6">
                        {{ Form::select('productserialno', $productService, null, array('placeholder' => '--SELECT--', 'id' => 'productserialno')) }}
                        @if ($errors->has('productserialno'))
                            <span class="help-block"><strong>{{ $errors->first('productserialno') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('complaintdescription') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Complaint Description <br/>(Max 500 Chars)</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('complaintdescription',null,['class'=>'form-control form-control-sm', 'rows' => 3, 'cols' => 40, 'required' => 'required','onKeyPress' => "if(this.value.length==500) return false;"]) }}
                        @if ($errors->has('complaintdescription'))
                            <span class="help-block"><strong>{{ $errors->first('complaintdescription') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('callername') ? ' has-error' : '' }} mt-2">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Caller Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('callername', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('callername'))
                            <span class="help-block"><strong>{{ $errors->first('callername') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('callermobile') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Caller Mobile</label>
                    <div class="col-sm-6">
                        {{ Form::number('callermobile', '', array('class' => 'form-control form-control-sm','required' => 'required','onKeyPress' => "if(this.value.length==10) return false;" )) }}
                        @if ($errors->has('callermobile'))
                            <span class="help-block"><strong>{{ $errors->first('callermobile') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Caller Email</label>
                    <div class="col-sm-6">
                        {{ Form::email('calleremail', '', array('class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('calleremail'))
                            <span class="help-block"><strong>{{ $errors->first('calleremail') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row mt-2 {{ $errors->has('priority') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Priority</label>
                    <div class="col-sm-6">
                        {{ Form::select('priority', array('High' => 'High','Low' => 'Low','Medium' => 'Medium'), null, array('placeholder' => '--SELECT--','required' => 'required', 'id' => 'priority')) }}
                        @if ($errors->has('priority'))
                            <span class="help-block"><strong>{{ $errors->first('priority') }}</strong></span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                    <div class="col-sm-6">
                        {{ Form::submit('Submit', array('class' => 'btn btn-primary offset-4')) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
@section('script-js')
    <script src="{{ asset('assets/Selectize/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script>

        $(document).ready(function () {

            $('#productservice').selectize({
                maxItems: 1
            });

            $('#productserialno').selectize({
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
                        url: url + '/registration/category/' + $('#productservice').val(),
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('#subcategory').selectize()[0].selectize.destroy();

                            $.each(data, function (key, value) {
                                categorylist.push({
                                    text: value['categoryname'],
                                    value: value['categorycode'],
                                })
                            });
                            $('#subcategory').selectize({
                                options:null
                            });
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

            $('#category').change(function () {
                if ($('#category').val() != "") {
                    var subcategorylist = [];
                    $.ajax({
                        url: url + '/registration/subcategory/' + $('#category').val(),
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
                            if(subcategorylist.length > 0){
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
                            else{
                                $('#subcategory').selectize({
                                    options:null
                                });
                            }
                        }
                    });
                }
                else{
                    $('#subcategory').selectize()[0].selectize.destroy();
                    $('#subcategory').selectize({
                        options:null
                    });
                }
            });
        });

    </script>
    <script>
        $(".onSaves").on("submit", function(){

            debugger
            var customerName = document.getElementById("customers");
            var customerNameselectedText = customerName.options[customerName.selectedIndex].text;

            var customerSite = document.getElementById("customersite");
            var customerSiteselectedText = customerSite.options[customerSite.selectedIndex].text;

            var productSerial = document.getElementById("productserialno");
            var productSerialselectedText = productSerial.options[productSerial.selectedIndex].text;

            if (customerNameselectedText != "") {
                if(customerSiteselectedText == "" ){
                    alert('select customer site');
                    return false;
                }else if(productSerialselectedText == ""){
                    alert('select product serial number');
                    return false;
                }
            }else {
                return confirm("Do you want to save this complaint without selecting Customer Name, Customer Site ,Product Serial Number ?");
            }
        });
    </script>
@stop

