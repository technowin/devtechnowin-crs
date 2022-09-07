@extends('layouts.appnew')
@section('pageTitle', 'Complaints')
@section('content')

    <br/>
    <div class="container card col-md-9">
        <div class="col card-block">
            <div class="tab-content">
                <div class="tab-pane fade active in" role="tabpanel" id="contract-tab" style="margin-left: 250px;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Add Prospective Quotation </h3>
                        </div>
                        <div class="panel-body">
                            {{ Form::open(array('url' => 'newprospectivequotation','files' => true)) }}

                            <div class="row{{ $errors->has('quotationdate') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Quotation Date</label>
                                <div class="col-sm-6">
                                    {{ Form::date('quotationdate',null,  array('class' => 'form-control form-control-sm','required' => 'required')) }}
                                    @if ($errors->has('quotationdate'))
                                        <span class="help-block"><strong>{{ $errors->first('quotationdate') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('organizationname') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Organisation Name</label>
                                <div class="col-sm-6">
                                    {{Form::select('organizationname',$organisationname,null,array('placeholder' => '--SELECT--','id'=>'organisationnameid','required' => 'required') )}}
                                    @if ($errors->has('organizationname'))
                                        <span class="help-block"><strong>{{ $errors->first('organizationname') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('organizationaddress') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Organisation Address</label>
                                <div class="col-sm-6">
                                    {{ Form::textarea('organizationaddress',null , array('placeholder' => 'Organisation Address', 'class' => 'form-control form-control-sm', 'rows' => '2')) }}
                                    @if ($errors->has('organizationaddress'))
                                        <span class="help-block"><strong>{{ $errors->first('organizationaddress') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('organizationaddress') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Email</label>
                                <div class="col-sm-6">
                                    {{ Form::email('emailid',null , array('placeholder' => 'Email', 'class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('organizationaddress'))
                                        <span class="help-block"><strong>{{ $errors->first('organizationaddress') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('organizationaddress') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Phone</label>
                                <div class="col-sm-6">
                                    {{ Form::number('phone',null , array('placeholder' => 'Phone', 'class' => 'form-control form-control-sm')) }}
                                    @if ($errors->has('organizationaddress'))
                                        <span class="help-block"><strong>{{ $errors->first('organizationaddress') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('organizationaddress') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Subject</label>
                                <div class="col-sm-6">
                                    {{ Form::textarea('subject',null , array('class' => 'form-control form-control-sm','rows'=>'2','required' => 'required')) }}
                                    @if ($errors->has('organizationaddress'))
                                        <span class="help-block"><strong>{{ $errors->first('organizationaddress') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="row{{ $errors->has('description') ? ' has-error' : '' }}" style="padding: 3px">
                                <label for="input" class="col-sm-3 col-form-label-sm text-muted">Description</label>
                                <div class="col-sm-6">
                                    {{ Form::textarea('description',null , array('class' => 'form-control form-control-sm','rows'=>'2','required' => 'required')) }}
                                    @if ($errors->has('description'))
                                        <span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            <input type="hidden" id="count" value="1">
                            <div id="addcontractsitemaster">
                            </div>
                            <input href="javascript:void(0);" type="image" src="{{asset('img/plus.jpg')}}"
                                   style="height: 20px; width: 20px;"
                                   onclick="addprospectivequotationdetails(); return false;">

                            <div class="row">
                                <label for="input" class="col-sm-3 col-form-label text-muted"></label>
                                <div class="col-sm-6">
                                    <br/>
                                    {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
                                </div>
                            </div>

                            {{ Form::close() }}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('page-script')
    <script>
        $(document).ready(function () {
            $('#organisationnameid').selectize({
                maxItems: 1
            });
        })

        function addprospectivequotationdetails() {
            var count = $('#count').val();
            var id = $('#count').val();
            var wrapper = $('#addcontractsitemaster');
            var addButton = $('#addcontractsitemastersdiv');
            var appendtags = '<div><a  href="javascript:void(0);" class="remove_button" title="Remove field"><img src="{{asset('img/cancel-512.png')}}" style="height: 20px; width: 20px; margin-left:658px;"/></a><div class="panel col-md-12" style="border: silver 1px solid;"><div class="panel-body">{{ Form::hidden('contractsitemaster[]', '0',array('class'=>'contractsitemasterclass')) }} <div class="row mt-1">' +

                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Product</label> <div class="col-sm-6"> ' +
                '{{ Form::select('productservicecode[]',$product, null,array('placeholder' => '--SELECT--','id' => 'productserviid_%count%','required' => 'required','onchange'=>'getproductname(%id%); return false;')) }} </div> </div>'.replace('%count%', count).replace('%id%', id)+

                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Category</label> <div class="col-sm-6"> ' +
                '{{ Form::select('categorycode[]',array('placeholder' => '--SELECT--'),null, array('required' => 'required', 'id' => 'category_%count%')) }}</div></div>'.replace('%count%', count) +
                {{--' {{ Form::select('categorycode',array(null => '--SELECT--'),null, array('required' => 'required', 'id' => 'category_%count%')) }}'.replace('%count%', count)+--}}

                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Model No</label> <div class="col-sm-6">' +
                '{{ Form::text('modelno[]', null, array('class' => 'form-control form-control-sm', 'id'=>'phoneid','onKeyPress'=>'if(this.value.length==11) return false;','required' => 'required')) }}</div></div>'+

                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Configuration</label> <div class="col-sm-6">' +
                '{{ Form::textarea('configuration[]', null, array('class' => 'form-control form-control-sm', 'id'=>'phoneid','required' => 'required','rows'=>'2')) }}</div></div>'+

                ' <div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Qty</label> <div class="col-sm-6">' +
                ' {{ Form::number('qty[]', null, array('class' => 'form-control form-control-sm', 'id'=>'qtyid_%count%','required' => 'required','onkeyup'=>'calculater(%id%); return false;')) }} </div></div>'.replace('%count%',count).replace('%id%',id)+

                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Rate</label> <div class="col-sm-6">' +
                '{{ Form::number('rate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'rateid_%count%','required' => 'required','onkeyup'=>'calculater(%id%); return false;')) }}</div></div>'.replace('%count%',count).replace('%id%',id)+

                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">SGST</label> <div class="col-sm-6">' +
                '{{ Form::number('sgst[]', null, array('class' => 'form-control form-control-sm', 'id'=>'sgstid_%count%','required' => 'required','onkeyup'=>'calculater(%id%); return false;')) }}</div></div>'.replace('%count%',count).replace('%id%',id)+

                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">SGST Amt</label> <div class="col-sm-6">' +
                '{{ Form::number('sgstamt[]', null, array('class' => 'form-control form-control-sm', 'id'=>'sgstamtid_%id%','required' => 'required','readonly')) }}</div></div>'.replace('%id%',id)+

                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">CGST</label> <div class="col-sm-6">' +
                '{{ Form::number('cgst[]', null, array('class' => 'form-control form-control-sm', 'id'=>'cgstid_%count%','required' => 'required','onkeyup'=>'calculater(%id%); return false;')) }}</div></div>'.replace('%count%',count).replace('%id%',id)+

                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">CGST Amt</label> <div class="col-sm-6">' +
                '{{ Form::number('cgstamt[]', null, array('class' => 'form-control form-control-sm', 'id'=>'cgstamtid_%id%','required' => 'required','readonly' )) }}</div></div>'.replace('%id%',id)+

                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Tax Amt</label> <div class="col-sm-6">' +
                '{{ Form::number('amt[]', null, array('class' => 'form-control form-control-sm', 'id'=>'totaotaxamtid_%id%','required' => 'required','readonly')) }}</div></div>'.replace('%id%',id)+

                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Total</label> <div class="col-sm-6">' +
                '{{ Form::number('total[]', null, array('class' => 'form-control form-control-sm', 'id'=>'totalid_%count%','required' => 'required','readonly')) }}</div></div>'.replace('%count%',count)+

                '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Grand Total</label> <div class="col-sm-6">' +
                '{{ Form::number('grandamt[]', null, array('class' => 'form-control form-control-sm', 'id'=>'grandtotalid_%id%','required' => 'required','readonly')) }}</div></div>'.replace('%id%',id)+

                '</div></div>';



            $(addButton).click(function () { //Once add button is clicked
                $(wrapper).append(appendtags); // Add field html
            });

            $(wrapper).on('click', '.remove_button', function (e) { //Once remove button is clicked
                $(this).parent('div').remove(); //Remove field html
            });

            $('#addcontractsitemaster').append(appendtags);

            $('#productserviid_'+count).selectize({
                maxItems: 1
            });
            $('#category_'+count).selectize({
                maxItems: 1
            });
            count = parseInt(count) + 1;
            $('#count').val(count);

        }

    </script>

    <script>

        function getproductname(id) {
            debugger
            var categorylist = [];
            if ($('#productserviid_'+id).val() != "") {
                $.ajax({
                    url: "{{URL::to('registration/category/')}}/" + $('#productserviid_'+id).val(),
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

                        $('#category_'+id).selectize()[0].selectize.destroy();

                        if (categorylist.length > 0) {
                            $('#category_'+id).selectize({
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
                            $('#category_'+id).selectize({
                                options: null
                            });
                        }
                    }
                });
            }
            else {

                $('#category_'+id).selectize()[0].selectize.destroy();
                $('#category_'+id).selectize({
                    options: null
                });
            }
        }

        function calculater(id) {
            debugger
            var qty = $('#qtyid_'+id).val();
            var rate = $('#rateid_'+id).val();
            var sgst = $('#sgstid_'+id).val();
            var cgst = $('#cgstid_'+id).val();
            var total = rate * qty;
            var sgstamt = rate*sgst/100;
            var cgstamt = rate*cgst/100;
            var totaltax = sgstamt+cgstamt;
            var grandtotal = total + totaltax;
            $('#sgstamtid_'+id).val(sgstamt);
            $('#cgstamtid_'+id).val(cgstamt);
            $('#totaotaxamtid_'+id).val(totaltax);
            $('#totalid_'+id).val(total);
            $('#grandtotalid_'+id).val(grandtotal);
        }

    </script>
@endsection