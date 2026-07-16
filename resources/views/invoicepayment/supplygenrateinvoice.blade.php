@extends('layouts.appnew')

@section('page-title', '| Customers')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Genrate Invoice No</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array('url' => 'supplysaveinvoice','files' => true,'id'=>'invoicedatailid')) }}

                <div class="row{{ $errors->has('sectorname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Contract No</label>
                    <div class="col-sm-6">
                        {{ Form::text('contractno', $supplymanagement->contractno, array('class' => 'form-control form-control-sm','readonly' => true)) }}
                    </div>
                </div>

                <div class="row{{ $errors->has('customername') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                    <div class="col-sm-6">
                        {{ Form::text('customername', $customer->customername, array('class' => 'form-control form-control-sm','readonly' => true)) }}
                    </div>
                </div>

                <div class="row{{ $errors->has('paymentype') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">Payment Type</label>
                    <div class="col-sm-6">
                        {{ Form::text('paymentype', $paymentype->paymentype, array('class' => 'form-control form-control-sm','readonly' => true)) }}
                    </div>
                </div>

                <div class="row{{ $errors->has('paymentype') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted">payment Percent</label>
                    <div class="col-sm-6">
                        {{ Form::text('paymentype', $paymentpercent, array('class' => 'form-control form-control-sm','readonly' => true)) }}
                    </div>
                </div>

                 <div>
                     {{Form::hidden('paymentpercent',$paymentpercent,array('id'=>'paymentpercent'))}}
                 </div>
                <div>{{Form::hidden('paymentcycleno',$paymentype->paymentcycleno)}}</div>

                <br>
                <table width="100%;" id="invtable">
                    <tr>
                        <th style="width:150px;">Equipment</th>
                        <th style="width:100px;">Qty</th>
                        <th style="width:10px;">Rate</th>
                        <th style="width: 150px">Amount</th>
                        <th style="width:150px;">CGST Amt</th>
                        <th style="width:150px;">SCGST Amt</th>
                        <th style="width:150px;">Tax Amt</th>
                        <th style="width:150px;">Total Amount</th>
                        <th style="width:150px;">Remarks</th>
                    </tr>
                    @foreach($contractdetails as $contract)
                        <tr>
                            <td style="width:150px; text-align: center;">{{ Form::text('productservicename[]', $contract->product->productservicename, array('class' => 'form-control','required' => 'required','readonly')) }}</td>
                            <td style="width:150px; text-align: center;">{{ Form::number('quantity[]', $contract->quantity, array('class' => 'form-control form-control-sm','required' => 'required','readonly')) }}</td>
                            <td style="width:150px; text-align: center;">{{ Form::text('rate[]', $contract->rate, array('class' => 'form-control','readonly')) }}</td>
                            <td style="width:150px; text-align: center;">{{ Form::text('amount[]',$contract->quantity*$contract->rate, array('class' => 'form-control','readonly')) }}</td>
                            <td style="width:150px; text-align: center;">{{ Form::text('cgstamt[]', $contract->quantity*($contract->rate*$contract->cgstrate/100), array('class' => 'form-control','required' => 'required','readonly')) }}</td>
                            <td style="width:150px; text-align: center;">{{ Form::text('sgstamt[]',$contract->quantity*($contract->rate*$contract->sgstrate/100), array('class' => 'form-control','required' => 'required','readonly')) }}</td>
                            <td style="width:150px; text-align: center;">{{ Form::text('taxamt[]',$contract->quantity*($contract->rate*$contract->taxrate/100), array('class' => 'form-control','required' => 'required','readonly')) }}</td>
                            <td style="width:150px; text-align: center;">{{ Form::text('totalamount[]',$contract->totalcontractcost*$paymentpercent/100,array('class' => 'form-control totalcost')) }}</td>
                            <td style="width:150px; text-align: center;">{{ Form::text('remark[]',null, array('class' => 'form-control')) }}</td>
                            <td>{{ Form::text('sgstrate[]', $contract->sgstrate, array('class' => 'form-control','hidden'=>'true')) }}</td>
                            <td>{{ Form::text('cgstrate[]', $contract->cgstrate, array('class' => 'form-control','hidden'=>'true')) }}</td>
                            <td>{{ Form::text('taxrate[]', $contract->taxrate, array('class' => 'form-control','hidden'=>'true')) }}</td>
                            <td>{{ Form::text('totaltax[]', $contract->totaltax, array('class' => 'form-control','hidden'=>'true')) }}</td>
                            <td>{{ Form::text('hsncode[]', $contract->hsncode, array('class' => 'form-control','hidden'=>'true')) }}</td>
                            <td>{{Form::text('warranty_amcperiod[]',$contract->warranty_amcperiod,array('class'=>'form-control','hidden'=>'true'))}}</td>

                        </tr>
                    @endforeach
                </table>
                <br>

                <div class="row{{ $errors->has('sectorname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-2 offset-6 col-form-label text-muted">Total</label>
                    <div class="col-sm-4">
                        {{ Form::text('initialinvoiceamount',null, array('id'=>'totalid','class' => 'form-control form-control-sm','readonly' => true)) }}
                    </div>
                </div>

                <div class="row{{ $errors->has('sectorname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-2 offset-6 col-form-label text-muted">New total</label>
                    <div class="col-sm-4">
                        {{ Form::number('newtotal',null, array('id'=>'newtotalid','class' => 'form-control form-control-sm')) }}
                    </div>
                </div>

                <div class="row{{ $errors->has('sectorname') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-2 offset-6 col-form-label text-muted">Remark</label>
                    <div class="col-sm-4">
                        {{ Form::textarea('totalremark',null, array('class' => 'form-control form-control-sm','rows'=>'2')) }}
                    </div>
                </div>
                <br>

                <div class="row{{ $errors->has('calleremail') ? ' has-error' : '' }}">
                    <label for="input" class="col-sm-4 col-form-label text-muted"></label>
                    <div class="col-sm-6">
                        @if($contractinvoicedetails=='')
                        {{ Form::submit(' Save ', array('class' => 'btn btn-primary')) }}
                        @else
                        <a class="btn btn-primary" href="{{ URL::to('invoicereport',array($supplymanagement->contractno,$paymentype->paymentcycleno))}}">Generate Invoice No</a>
                        @endif
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection
@section('page-script')
    {{--<script>--}}
        {{--$('#invtable').on('blur', 'tr', function () {--}}
            {{--debugger--}}
            {{--var id=$('#serviceparametersid').val();--}}
            {{--var paymentpercent=$('#paymentpercent').val();--}}
            {{--var quantity = this.cells[1].children[0].value;--}}
            {{--var rate=this.cells[2].children[0].value;--}}
            {{--var sgstrate=this.cells[9].children[0].value;--}}
            {{--var cstrate=this.cells[10].children[0].value;--}}
            {{--var taxrate=this.cells[11].children[0].value;--}}
            {{--var warrantyamcperiod=this.cells[14].children[0].value;--}}
            {{--if (quantity != "") {--}}
                {{--this.cells[3].children[0].value=quantity*rate;--}}
                {{--var tax = rate * taxrate / 100;--}}
                {{--var calsgstamt = rate * sgstrate / 100;--}}
                {{--var calcgstamt = rate * cstrate / 100;--}}
                {{--var totaltax = parseFloat(calsgstamt) + parseFloat(calcgstamt) + parseFloat(tax);--}}
                {{--var calgrossrate = parseFloat(rate) + parseFloat(totaltax);--}}
                {{--var test = parseFloat(quantity) * calgrossrate*warrantyamcperiod;--}}
                {{--var totalamu=test*paymentpercent/100;--}}
                {{--this.cells[4].children[0].value=parseFloat(calcgstamt)*quantity;--}}
                {{--this.cells[5].children[0].value=parseFloat(calsgstamt)*quantity;--}}
                {{--this.cells[6].children[0].value=parseFloat(tax)*quantity;--}}
                {{--this.cells[7].children[0].value=totalamu;--}}
            {{--}--}}
        {{--});--}}
    {{--</script>--}}

    <script>
        $(document ).ready(function(){
            debugger
            var sum = 0;
            var cost = $('.totalcost');
//            var cost = $('.bidamountid_' + id);
            for (var i = 0; i < cost.length; i++) {
                sum += parseFloat(cost[i].value);
            }
            var num = (sum).toFixed(0);
            document.getElementById('totalid').value = num;
            document.getElementById('newtotalid').value=num;
        })
    </script>

    <script>

        $('#invtable').on('blur', 'tr', function () {
            var sum = 0;
            var cost = $('.totalcost');
//            var cost = $('.bidamountid_' + id);
            for (var i = 0; i < cost.length; i++) {
                sum += parseFloat(cost[i].value);
            }
            document.getElementById('newtotalid').value = (sum).toFixed(0);
        })

    </script>

@stop




