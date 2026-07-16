 @extends('layouts.appnew')

@section('page-title', '| Customers')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Sale Quotation Details</h3>
            </div>
            <div class="panel-body">
                <div class="container">
                    {{ Form::open(array('url'=>'salegenratequotation', 'files' =>true )) }}

                    {{Form::hidden('customercode',$existingusercomplaint->customercode,array('id'=>'customercode'))}}
                    {{Form::hidden('branchcode',$existingusercomplaint->branchcode,array('id'=>'branchcode'))}}
                    {{Form::hidden('typeofcall',$existingusercomplaint->typeofcall)}}
                    <div class="row mt-1{{ $errors->has('ticketno') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Ticket No</label>
                        <div class="col-sm-6">
                            {{ Form::text('ticketno',$existingusercomplaint->ticketno, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>
                    </div>

                    {{--<div class="row mt-1{{ $errors->has('productsrno') ? ' has-error' : '' }}">--}}
                        {{--<label for="input" class="col-sm-4 col-form-label text-muted">Product Sr.No</label>--}}
                        {{--<div class="col-sm-6">--}}
                            {{--{{ Form::text('productsrno',$existingusercomplaint->productsrno_accountno, array('class' => 'form-control','readonly'=>'true')) }}--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="row mt-1{{ $errors->has('customername') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Name</label>
                        <div class="col-sm-6">
                            {{ Form::text('customername',$customername->customername, array('class' => 'form-control','readonly'=>'true')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('branchname') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Customer Site</label>
                        <div class="col-sm-6">
                            {{ Form::text('branchname',null, array('class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('productsupply') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Supply Product</label>
                        <div class="col-sm-6">
                            {{ Form::text('productsupply',null, array('class' => 'form-control','required')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('productdescription') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Product Description</label>
                        <div class="col-sm-6">
                            {{ Form::text('productdescription[]',null, array('class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('requestedquantity') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Requested Quantity</label>
                        <div class="col-sm-6">
                            {{ Form::number('requestedquantity[]',null, array('class' => 'form-control','id'=>'requestedquantity','onblur'=>'taxcalculate("",$("#requestedquantity").val(),$("#rate").val(),$("#gst").val())'))}}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('rate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Rate</label>
                        <div class="col-sm-6">
                            {{ Form::number('rate[]',null, array('class' => 'form-control','id'=>'rate','onblur'=>'taxcalculate("",$("#requestedquantity").val(),$("#rate").val(),$("#gst").val())')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('gst') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Tax Rate(GST%)</label>
                        <div class="col-sm-6">
                            {{ Form::number('gst[]',null, array('class' => 'form-control','id'=>'gst','onblur'=>'taxcalculate("",$("#requestedquantity").val(),$("#rate").val(),$("#gst").val())')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('taxvalue') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Tax Value(GST )</label>
                        <div class="col-sm-6">
                            {{ Form::text('taxvalue[]',null, array('class' => 'form-control','id'=>'taxvalue','readonly'=>'true')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('amount') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Amount</label>
                        <div class="col-sm-6">
                            {{ Form::text('amount[]',null, array('class' => 'form-control','id'=>'amount','readonly'=>'true')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('quotationdate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Quotation Date</label>
                        <div class="col-sm-6">
                            {{ Form::date('quotationdate',null, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <input type="hidden" id="productcount" value="1">
                    <div id="adddivlist">
                    </div >


                    <div class="row mt-1{{ $errors->has('productdescription') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Installation</label>
                        <div class="col-sm-6">
                            {{ Form::select('productdescription[]',array('Installation Charge'=>'Installation Charge') ,null, array('placeholder'=>'--select--','class' => 'form-control','required')) }}
                        </div>
                    </div>


                    <div class="row mt-1{{ $errors->has('requestedquantity') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Installation Quantity</label>
                        <div class="col-sm-6">
                            {{ Form::number('requestedquantity[]',null, array('class' => 'form-control','id'=>'installationquantity','onblur'=>'installation()')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('rate') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Installation Charge</label>
                        <div class="col-sm-6">
                            {{ Form::number('rate[]',null, array('class' => 'form-control','id'=>'installationcharge','onblur'=>'installation()')) }}
                        </div>
                    </div>

                    <div class="row mt-1{{ $errors->has('gst ') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Installation GST %</label>
                        <div class="col-sm-6">
                            {{ Form::number('gst[]',null, array('class' => 'form-control','id'=>'installationgst','onblur'=>'installation()')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('taxvalue') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Installation GST Value</label>
                        <div class="col-sm-6">
                            {{ Form::number('taxvalue[]',null, array('class' => 'form-control','id'=>'installationgstvalue','readonly')) }}
                        </div>
                    </div>
                    <div class="row mt-1{{ $errors->has('amount') ? ' has-error' : '' }}">
                        <label for="input" class="col-sm-4 col-form-label text-muted">Installation Amount</label>
                        <div class="col-sm-6">
                            {{ Form::number('amount[]',null, array('class' => 'form-control','id'=>'installationamount','readonly')) }}
                        </div>
                    </div>

                    <input  href="javascript:void(0);" type="image" src="{{asset('img/plus.jpg')}}"
                           style="height: 20px; width: 20px;"
                           onclick="adddiv(); return false;"></input>
                    {{--<div class="row mt-1{{ $errors->has('quotationstatus') ? ' has-error' : '' }}">--}}
                    {{--<label for="input" class="col-sm-4 col-form-label text-muted">Quotation Status</label>--}}
                    {{--<div class="col-sm-6">--}}
                    {{--{{ Form::select('quotationstatus', array('Approved'=>'Approved','Not approved'=>'Not approved'),null,array('placeholder'=>'--SELECT--','class'=>'form-control')) }}--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <br>
                    <div align="center">
                          @if($saleproduct==null)
                            {{Form::submit('Save',array('class'=>'btn btn-primary'))}}
                        @else
                        <a class="btn btn-primary" href="{{ URL::to('salequotation',array($saleproduct->ticketno))}}">Generate Quotation </a>
                              @endif
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection


@section('page-script')
    <script type="text/javascript">
     function adddiv() {
         debugger
         var count=$("#productcount").val();
         var newdiv= $("#adddivlist");
         var quantity = "$('#requestedquantity%count%').val()".replace("%count%", count);
         var rate="$('#rate%count%').val()".replace("%count%",count);
         var gst="$('#gst%count%').val()".replace("%count%",count);
         var taxvalue="$('#taxvalue%count%').val()".replace('%count%',count);
         var amount="$('#amount%count%').val()".replace('%count%',count);

         var appendtags='<div class="col-sm-12"><a  href="javascript:void(0);" class="remove_button" title="Remove field"><img src="{{asset('img/cancel-512.png')}}" style="height: 20px; width: 20px; margin-left:810px;"/></a> '+
                        '<div class="panel col-sm-11" style="border: silver 1px solid;"><div class="panel-body">'+
             '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Product Description</label> <div class="col-sm-7" style="margin-left:10px;"> '+

         '{{ Form::text('productdescription[]',null, array('class' => 'form-control ','id'=>'product')) }}</div></div>'+
             '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Requested Quantity</label> <div class="col-sm-7" style="margin-left:10px;"> '+
             '{{ Form::number('requestedquantity[]',null, array('class' => 'form-control ','id'=>'requestedquantity%count%','onblur'))}}</div></div>'.replace('%count%',count).replace('onblur',"onblur=taxcalculate("+count+","+quantity+","+rate+","+gst+")")+
             '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Rate</label> <div class="col-sm-7" style="margin-left:10px;"> '+
                 '{{ Form::number('rate[]',null, array('class' => 'form-control','id'=>'rate%count%','onblur')) }}</div></div>'.replace('%count%',count).replace('onblur',"onblur=taxcalculate("+count+","+quantity+","+rate+","+gst+")")+
             '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Tax Rate(GST%)</label> <div class="col-sm-7" style="margin-left:10px;"> '+
             '{{ Form::number('gst[]',null, array('class' => 'form-control','id'=>'gst%count%','onblur')) }}</div></div>'.replace('%count%',count).replace('onblur',"onblur=taxcalculate("+count+","+quantity+","+rate+","+gst+")")+
             '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Tax Value(GST)</label> <div class="col-sm-7" style="margin-left:10px;"> '+
              '{{ Form::text('taxvalue[]',null, array('class' => 'form-control','id'=>'taxvalue%count%','readonly'=>'true'))}}</div></div>'.replace('%count%',count)+
             '<div class="row" style="margin-top:5px;"> <label for="input" class="col-sm-4 col-form-label text-muted">Amount</label> <div class="col-sm-7" style="margin-left:10px;"> '+
             '{{ Form::text('amount[]',null, array('class' => 'form-control','id'=>'amount%count%','readonly'=>'true')) }}</div></div>'.replace('%count%',count)+
             '</div></div>';
           $(newdiv).append(appendtags);

            count=parseInt(count)+1;
           $("#productcount").val(count);
         $(newdiv).on('click', '.remove_button', function (e) {
             $(this).parent('div').remove();
             var count=parseInt(count)-1;
             $("#productcount").val(count);
         });
     }
    </script>
    <script>

        function taxcalculate(count,quantity,rate,gst) {
            debugger
            var q=count;
              var qty=quantity;
              var rateamt=rate;
              var gstrate=gst;
            var taxamt=qty*(rateamt*gstrate/100);
            var qtyamt=qty*rateamt+taxamt;
            document.getElementById("taxvalue"+count).value=taxamt;
            document.getElementById("amount"+count).value=qtyamt;

//            var qty=$("#requestedquantity").val();
//            var rateamt=$("#rate").val();
//            var taxamt=qty*(rateamt*18/100);
//            var qtyamt=qty*rateamt+taxamt;
//            document.getElementById('taxvalue').value=taxamt;
//            document.getElementById('quotationamount').value=qtyamt;
        }
    </script>
    <script>
        function installation () {
            debugger
           var inscharge=$("#installationcharge").val();
           var qty= $("#installationquantity").val();
           var gst= $("#installationgst").val();
            var gstvalue=qty*(inscharge*gst/100);
            var insamount=qty*inscharge + gstvalue;
            document.getElementById("installationgstvalue").value=gstvalue;
            document.getElementById("installationamount").value=insamount;

        }
    </script>

@stop