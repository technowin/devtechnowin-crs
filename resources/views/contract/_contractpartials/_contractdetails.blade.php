<div class="card mt-1 partialRow">
    <div class="card-header">
        <div class="row">
            <div class="col-md-3">Contract Details</div>
            <div class="col-md-9"><a href="#" class="deleteRow btn btn-danger btn-sm" style="float:right;">delete</a></div>
        </div>
    </div>
    <div class="card-body">
        {{ Form::hidden('contractdetailssaved', '', array('id' => 'contractdetailssaved')) }}
        {{Form::open(array('action' => 'ContractController@addContractDetails','method' => 'post'))}}
        <div class="col-md-12">
            {{ Form::hidden('contractdetailsid[]', '0') }}
            <div class="row {{ $errors->has('contractno') ? ' has-error' : '' }} mt-2">
                <label for="input" class="col-sm-4 col-form-label text-muted">Contract No</label>
                <div class="col-sm-6">
                    {{ Form::text('contractno', null, array('class' => 'form-control form-control-sm contract','readonly')) }}
                    @if ($errors->has('contractno'))
                        <span class="help-block"><strong>{{ $errors->first('contractno') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card col-md-12">
            <div class="row{{ $errors->has('productservice') ? ' has-error' : '' }} mt-1">
                <label for="input" class="col-sm-4 col-form-label text-muted">Equipment</label>
                <div class="col-sm-6">
                    {{ Form::select('productservice[]', array('' => '--SELECT--'), null, array('id' => 'productservice')) }}
                    @if ($errors->has('productservice'))
                        <span class="help-block"><strong>{{ $errors->first('productservice') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('quantity') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-4 col-form-label text-muted">Quantity</label>
                <div class="col-sm-6">
                    {{ Form::number('quantity[]', null, array('class' => 'form-control form-control-sm', 'id' => 'quantity', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#tax").val(),$("#warranty_amc_period").val(), $("#grossrate"))')) }}
                    <span class="help-block"><strong>{{ $errors->first('quantity') }}</strong></span>
                </div>
            </div>
            <div class="row{{ $errors->has('rate') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-4 col-form-label text-muted">Rate</label>
                <div class="col-sm-6">
                    {{ Form::number('rate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'rate', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#tax").val(),$("#warranty_amc_period").val(), $("#grossrate"))')) }}
                    @if ($errors->has('rate'))
                        <span class="help-block"><strong>{{ $errors->first('rate') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('tax') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-4 col-form-label text-muted">Tax</label>
                <div class="col-sm-6">
                    {{ Form::number('tax[]', null, array('class' => 'form-control form-control-sm', 'id'=>'tax', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#tax").val(),$("#warranty_amc_period").val(), $("#grossrate"))')) }}
                    @if ($errors->has('tax'))
                        <span class="help-block"><strong>{{ $errors->first('tax') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('warranty_amc_period') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-4 col-form-label text-muted">Warranty / AMC Period (in
                    months)</label>
                <div class="col-sm-6">
                    {{ Form::number('warranty_amc_period[]', null, array('class' => 'form-control form-control-sm', 'id'=>'warranty_amc_period', 'onkeyup'=>'calculategross($("#quantity").val(),$("#rate").val(),$("#tax").val(),$("#warranty_amc_period").val(), $("#grossrate"))')) }}
                    @if ($errors->has('warranty_amc_period'))
                        <span class="help-block"><strong>{{ $errors->first('warranty_amc_period') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="row{{ $errors->has('grossrate') ? ' has-error' : '' }}">
                <label for="input" class="col-sm-4 col-form-label text-muted">Gross Rate (Rs.)</label>
                <div class="col-sm-6">
                    {{ Form::number('grossrate[]', null, array('class' => 'form-control form-control-sm', 'id'=>'grossrate', 'readonly')) }}
                    @if ($errors->has('grossrate'))
                        <span class="help-block"><strong>{{ $errors->first('grossrate') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>

        <input type="hidden" id="contractdetailsrowcount" value="1">
        {{--<div class="add-equipment-div"></div>--}}
        <br/>
        {{--<button class="btn btn-default add-equipment">Add Equipment</button>--}}

        <div class="row">
            <label for="input" class="col-sm-4 col-form-label-sm text-muted"></label>
            <div class="col-sm-6">
                {{ Form::button('Save & Close', array('class' => 'btn btn-primary', 'onclick' => 'addnewcontractdetails()')) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
</div>

{{-- for rendering partial multiple times --}}
<script type="text/javascript">
    $(".add-equipment").click(function (e) {
        e.preventDefault();
        debugger
        var url = '{{ url('getpartialcontractdetails') }}/' + $('#contractno').val();
        $.get(url, null, function (template) {
            $('.contractdetailsTabnew').append(template).fadeIn();
        }, "html");
    });
</script>