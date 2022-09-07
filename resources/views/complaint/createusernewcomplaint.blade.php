@extends('layouts.appnew')

@section('pageTitle', 'New Complaint')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Lodge New Complaint</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array('url' => 'usernewcomplaint','files' => true)) }}
                <div class="row form-group{{ $errors->has('customername') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('customername', $currentUserName,array('class' => 'form-control', 'placeholder'=>'Customer / Company Name','required' => 'required','readonly' => true,'style'=>'background-color:white;')) }}
                        @if ($errors->has('customername'))
                            <span class="help-block"><strong>{{ $errors->first('customername') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('workorderno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">WorkOrder No</label>
                    <div class="col-sm-6">
                        {{ Form::text('workorderno', null, array('class' => 'form-control', 'placeholder'=>'Work Order No','required' => 'required')) }}
                        @if ($errors->has('workorderno'))
                            <span class="help-block"><strong>{{ $errors->first('workorderno') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('branchname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Branch Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('branchname', null, array('class' => 'form-control', 'placeholder'=>'Branch Name','required' => 'required')) }}
                        @if ($errors->has('branchname'))
                            <span class="help-block"><strong>{{ $errors->first('branchname') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('productservice') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product & Service</label>
                    <div class="col-sm-6">
                        {{ Form::select('productservice', $productService, null, array('placeholder' => '--SELECT--','required' => 'required', 'id' => 'productserviceid','onchange' => 'getcategory(); return false;','required' => 'required')) }}
                        @if ($errors->has('productservice'))
                            <span class="help-block"><strong>{{ $errors->first('productservice') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Category</label>
                    <div class="col-sm-6">
                        {{ Form::select('category',array(null => '--SELECT--'),null, array('required' => 'required', 'id' => 'categoryid','onchange' => 'getsubcategory(); return false;')) }}
                        @if ($errors->has('category'))
                            <span class="help-block"><strong>{{ $errors->first('category') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('subcategory') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Sub-Category</label>
                    <div class="col-sm-6">
                        {{ Form::select('subcategory', array('' => '--SELECT--'), null, array('id' => 'subcategoryid')) }}
                        @if ($errors->has('subcategory'))
                            <span class="help-block"><strong>{{ $errors->first('subcategory') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('productsrno_accountno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Product Serial No</label>
                    <div class="col-sm-6">
                        {{ Form::text('productsrno_accountno', null,array('class' => 'form-control', 'placeholder'=>'Product Serial No.')) }}
                        @if ($errors->has('productsrno_accountno'))
                            <span class="help-block"><strong>{{ $errors->first('productsrno_accountno') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('complaintdescription') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Complaint Description (Max 500
                        Chars)</label>
                    <div class="col-sm-6">
                        {{ Form::textarea('complaintdescription',null,['class'=>'form-control', 'rows' => 3, 'cols' => 40, 'required' => 'required']) }}
                        @if ($errors->has('complaintdescription'))
                            <span class="help-block"><strong>{{ $errors->first('complaintdescription') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('yourname') ? ' has-error' : '' }} mt-2">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Your Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('yourname', null, array('class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('yourname'))
                            <span class="help-block"><strong>{{ $errors->first('yourname') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('mobileno') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Mobile No</label>
                    <div class="col-sm-6">
                        {{ Form::number('mobileno', null, array('class' => 'form-control','required' => 'required', 'onKeyPress' => "if(this.value.length==10) return false;")) }}
                        @if ($errors->has('mobileno'))
                            <span class="help-block"><strong>{{ $errors->first('mobileno') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Email ID </label>
                    <div class="col-sm-6">
                        {{ Form::email('email', null, array('class' => 'form-control form-control-sm','required' => 'required')) }}
                        @if ($errors->has('email'))
                            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="row form-group">
                    <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                    <div class="col-sm-6">
                        {{ Form::submit('Submit', array('class' => 'btn btn-primary offset-4','onclick'=>'return chkdropvalues();')) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection

@section('page-script')
    <script src="{{ asset('js/jquery-3.1.1.js') }}"></script>
    <script src="{{ asset('js/complaintlodging.js') }}"></script>
    <script src="{{ asset('assets/Selectize/js/standalone/selectize.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#productserviceid').selectize({
                maxItems: 1
            });
            $('#categoryid').selectize({
                maxItems: 1
            });
            $('#subcategoryid').selectize({
                maxItems: 1
            });
        });
    </script>
    <script type="text/javascript">

        function getcategory() {
            if ($("#productserviceid").val() != "") {
                var categorylist = [];
                var subcategorylist = [];
                $.ajax({
                    url:'{{ url('/registration/category') }}/'+ $("#productserviceid").val(),
                    type: "GET",
                    dataType: "JSON",
                    success: function (data) {

                        $.each(data, function (key, value) {
                            categorylist.push({
                                text: value['categoryname'],
                                value: value['categorycode'],
                            })
                        });

                        $('#categoryid').selectize()[0].selectize.destroy();
                        $('#categoryid').selectize({
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
            else {
                $('select[name="subcategorycode"]').empty();
                $('select[name="category"]').empty();
            }
        }

        function getsubcategory() {
            debugger
            if ($("#categoryid").val() != "") {
                var subcategorylist = [];
                $.ajax({
                    url:'{{ url('/registration/subcategory') }}/'+ $("#categoryid").val(),
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            subcategorylist.push({
                                text: value['subcategoryname'],
                                value: value['subcategorycode'],
                            })
                        });

                        $('#subcategoryid').selectize()[0].selectize.destroy();
                        $('#subcategoryid').selectize({
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
                });
            }
            else {
                $('select[name="subcategorycode"]').empty();
                $('select[name="category"]').empty();
            }
        }

    </script>
    <script type="text/javascript">

        function chkdropvalues() {
            debugger

            if($('#productserviceid').val() !="")
            {
                if($('#categoryid').val() !="")
                {
                }
                else {
                    alert('Select Category')
                    return false;
                }
            }
            else
            {
                alert('Select Product & Service')
                return false;
            }

        }
    </script>
@stop