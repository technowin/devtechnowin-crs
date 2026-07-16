<div class="card">
    <div class="card-header">New Contract</div>
    <div class="card-body">
        <div class="col-md-12">
            {{Form::open(array('action' => 'DummyContractController@storecontractmaster','method' => 'post'))}}

            <div class="row {{ $errors->has('contractno') ? ' has-error' : '' }} mt-2">
                <label for="input" class="col-sm-3 col-form-label text-muted">Contract No</label>
                <div class="col-sm-6">
                    {{ Form::text('contractno', null, array('class' => 'form-control form-control-sm contract', 'readonly', 'id'=>'contractno')) }}
                    @if ($errors->has('contractno'))
                        <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('customers') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-3 col-form-label text-muted">Customer Name</label>
                <div class="col-sm-6">
                    {{ Form::select('customers', $customers, null, array('placeholder' => '--SELECT--','id' => 'customers', 'required' => 'required')) }}
                    @if ($errors->has('customers'))
                        <span class="help-block"><strong>{{ $errors->first('customers') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('customersite') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-3 col-form-label text-muted">Customer Site</label>
                <div class="col-sm-6">
                    {{ Form::select('customersite',array(null => '--SELECT--'),null, array('id' => 'customersite')) }}
                    @if ($errors->has('customersite'))
                        <span class="help-block"><strong>{{ $errors->first('customersite') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('tenderno') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-3 col-form-label text-muted">Tender No</label>
                <div class="col-sm-6">
                    {{ Form::select('tenderno', $tenders, null, array('placeholder' => '--SELECT--','id' => 'tenderno')) }}
                    @if ($errors->has('tenderno'))
                        <span class="help-block"><strong>{{ $errors->first('tenderno') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row {{ $errors->has('tenderopendate') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-3 col-form-label text-muted">Tender Open Date</label>
                <div class="col-sm-6">
                    {{ Form::date('tenderopendate', null, array('class' => 'form-control form-control-sm')) }}
                    @if ($errors->has('tenderopendate'))
                        <span class="help-block"><strong>{{ $errors->first('tenderopendate') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('workordertype') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-3 col-form-label text-muted">Work Order Type</label>
                <div class="col-sm-6">
                    {{ Form::select('workordertype',array('None'=>'None','AMC'=>'AMC', 'Warranty'=>'Warranty'),null, array('placeholder' => '--SELECT--','id' => 'workordertype', 'required' => 'required')) }}
                    @if ($errors->has('workordertype'))
                        <span class="help-block"><strong>{{ $errors->first('workordertype') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('workorderno') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-3 col-form-label text-muted">Work Order No</label>
                <div class="col-sm-6">
                    {{ Form::select('workorderno', array('' => '--SELECT--'), null, array('id' => 'workorderno', 'required' => 'required')) }}
                    @if ($errors->has('workorderno'))
                        <span class="help-block"><strong>{{ $errors->first('workorderno') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('workorderdescription') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-3 col-form-label text-muted">Work Order
                    Description</label>
                <div class="col-sm-6">
                    {{ Form::textarea('workorderdescription',null,['class'=>'form-control form-control-sm', 'rows' => 3, 'cols' => 40,'onKeyPress' => "if(this.value.length==500) return false;"]) }}
                    @if ($errors->has('workorderdescription'))
                        <span class="help-block"><strong>{{ $errors->first('workorderdescription') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row {{ $errors->has('workorderdate') ? ' has-error' : '' }} mt-1">
                <label for="input" class="col-sm-3 col-form-label text-muted">Work Order Date</label>
                <div class="col-sm-6">
                    {{ Form::date('workorderdate', null, array('class' => 'form-control form-control-sm')) }}
                    @if ($errors->has('workorderdate'))
                        <span class="help-block"><strong>{{ $errors->first('workorderdate') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row {{ $errors->has('contractfromdate') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-3 col-form-label text-muted">Contract From Date</label>
                <div class="col-sm-6">
                    {{ Form::date('contractfromdate', null, array('class' => 'form-control form-control-sm')) }}
                    @if ($errors->has('contractfromdate'))
                        <span class="help-block"><strong>{{ $errors->first('contractfromdate') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row {{ $errors->has('contracttodate') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-3 col-form-label text-muted">Contract To Date</label>
                <div class="col-sm-6">
                    {{ Form::date('contracttodate', null, array('class' => 'form-control form-control-sm')) }}
                    @if ($errors->has('contracttodate'))
                        <span class="help-block"><strong>{{ $errors->first('contracttodate') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('contractperiod') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-3 col-form-label text-muted">Contract Period (In
                    Years)</label>
                <div class="col-sm-6">
                    {{ Form::number('contractperiod', '', array('class' => 'form-control form-control-sm')) }}
                    @if ($errors->has('contractperiod'))
                        <span class="help-block"><strong>{{ $errors->first('contractperiod') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('purchaseorderno') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-3 col-form-label text-muted">Purchase Order No</label>
                <div class="col-sm-6">
                    {{ Form::text('purchaseorderno', '', array('class' => 'form-control form-control-sm')) }}
                    @if ($errors->has('purchaseorderno'))
                        <span class="help-block"><strong>{{ $errors->first('purchaseorderno') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row {{ $errors->has('purchaseorderdate') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-3 col-form-label text-muted">Purchase Order
                    Date</label>
                <div class="col-sm-6">
                    {{ Form::date('purchaseorderdate', null, array('class' => 'form-control form-control-sm')) }}
                    @if ($errors->has('purchaseorderdate'))
                        <span class="help-block"><strong>{{ $errors->first('purchaseorderdate') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('amendmentno') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-3 col-form-label text-muted">Amendment No</label>
                <div class="col-sm-6">
                    {{ Form::text('amendmentno', '', array('class' => 'form-control form-control-sm')) }}
                    @if ($errors->has('amendmentno'))
                        <span class="help-block"><strong>{{ $errors->first('amendmentno') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('amendmentdescription') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-3 col-form-label text-muted">Amendment
                    Description</label>
                <div class="col-sm-6">
                    {{ Form::textarea('amendmentdescription',null,['class'=>'form-control form-control-sm', 'rows' => 3, 'cols' => 40,'onKeyPress' => "if(this.value.length==500) return false;"]) }}
                    @if ($errors->has('amendmentdescription'))
                        <span class="help-block"><strong>{{ $errors->first('amendmentdescription') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('renewalperiod') ? ' has-error' : '' }} mt-1">
                <label for="input" class="col-sm-3 col-form-label text-muted">Renewal Period</label>
                <div class="col-sm-6">
                    {{ Form::text('renewalperiod', '', array('class' => 'form-control form-control-sm')) }}
                    @if ($errors->has('renewalperiod'))
                        <span class="help-block"><strong>{{ $errors->first('renewalperiod') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('totalcost') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-3 col-form-label text-muted">Total Cost</label>
                <div class="col-sm-6">
                    {{ Form::number('totalcost', '', array('class' => 'form-control form-control-sm')) }}
                    @if ($errors->has('totalcost'))
                        <span class="help-block"><strong>{{ $errors->first('totalcost') }}</strong></span>
                    @endif
                </div>
            </div>
            <br/>
            <div class="row">
                <label for="input" class="col-sm-3 col-form-label-sm text-muted"></label>
                <div class="col-sm-6">
                    <button id="contractSubmit" value="Submit" onclick="addnewcontract()"
                            class="btn btn-primary">Submit
                    </button>
                    {{ Form::submit('Save & Close', array('class' => 'btn btn-primary')) }}
                </div>
            </div>
              {{ Form::close() }}
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        $('#workorderno').selectize({
            maxItems: 1
        });

        $('#productserialno').selectize({
            maxItems: 1
        });

        $('#productservice').selectize({
            maxItems: 1
        });

        $('#category').selectize({
            maxItems: 1
        });

        $('#tenderno').selectize({
            maxItems: 1
        });

        $('#workordertype').selectize({
            maxItems: 1
        });

        $('#customers').selectize({
            maxItems: 1
        });

        $('#customersite').selectize({
            maxItems: 1
        });

        $('.selectize').selectize({
            maxItems: 1
        });

        $("#customers").change(function () {
            var branchlist = [];
            if ($('#customers').val() != "") {
                $.ajax({
                    url: '{{ URL::to('registration/branch') }}/' + $('#customers').val(),
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
                    }
                });

                var workorderlist = [];
                $.ajax({
                    url: '{{ URL::to('appadmin/workorders') }}/' + $('#customers').val(),
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            workorderlist.push({
                                text: value['workorderno'],
                                value: value['workorderno'],
                            })
                        });

                        $('#workorderno').selectize()[0].selectize.destroy();

                        if (workorderlist.length > 0) {
                            $('#workorderno').selectize({
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
                            $('#workorderno').selectize({
                                options: null
                            });
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

        $('#workorderno').change(function () {

            if ($('#workordertype').val() != "" && $('#workorderno').val() != "") {
                if ($('#workordertype').val() == "None") {

                    var contractno = 'NEW-' + $('#workorderno').val();
                    populateContractNo(contractno);
                }
                else {
                    var contractno = $('#workordertype').val().substring(0, 3).toUpperCase() + '-' + $('#workorderno').val();
                    populateContractNo(contractno);
                }
            }
            else {
                populateContractNo('');
            }
        });

        $('#workordertype').change(function () {

            if ($('#workordertype').val() == "AMC") {
                $("#amcdiv").show();
                $("#salesdiv").hide();
            }
            else if ($('#workordertype').val() == "Warranty") {
                $("#amcdiv").hide();
                $("#salesdiv").show();
            }
            else {
                $("#amcdiv").hide();
                $("#salesdiv").hide();
            }

            if ($('#workordertype').val() != "" && $('#workorderno').val() != "") {
                if ($('#workordertype').val() == "None") {
                    var contractno = 'NEW-' + $('#workorderno').val();
                    populateContractNo(contractno);
                }
                else {
                    var contractno = $('#workordertype').val().substring(0, 3).toUpperCase() + '-' + $('#workorderno').val();
                    populateContractNo(contractno);
                }
            }
            else {
                populateContractNo('');
            }
        });
    });

    function checkifcontractnoisavailable() {
        $contractno = document.getElementById('contractno');
        if ($contractno.value == "") {
            event.preventDefault();
            alert("Contract No not available!");
            return false;
        }
        return true;
    }

    function checkifcontractissaved() {
        $contractsaveid = document.getElementById('contractsavedid');
        if ($contractsaveid.value == "") {
            event.preventDefault();
            alert("Save Contract Data to Proceed!!!");
            return false;
        }
        return true;
    }

    function checkifcontractdetailssaved() {
        $contractdetailssaved = document.getElementById('contractdetailssaved');
        if ($contractdetailssaved.value == "") {
            event.preventDefault();
            alert("Save Contract Details Data to Proceed!!!");
            return false;
        }
        return true;
    }

    function populateContractNo(contractno) {
        $abc = document.getElementsByClassName('contract');
        $.each($abc, function (contract, value) {
            var abc = value;
            abc.value = contractno;
        });
    }

</script>
