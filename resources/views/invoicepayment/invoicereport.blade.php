<head>
    <style id="st">
        table, td, th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            width: 70%;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            height: 50px;
        }
    </style>

  <script>
      function printDiv(divName) {
          var printContents = document.getElementById(divName).innerHTML;
          var originalContents = document.body.innerHTML;
          document.body.innerHTML =
              "<html><head><title>Invoice Report</title></head><body>" +
              printContents + "</body>";
          window.print();
          document.body.innerHTML = originalContents;
      }
  </script>
</head>
{{ Form::open(array('url' => '/downloadinv/','files' => true)) }}
<div id="dvContainer">
<table align="center" style="width: 95%; border-collapse: collapse;" >

    <tr>
        <td colspan="9" align="center"><h1>Invoice Report</h1></td>
    </tr>
</table>

<table align="center" style="width: 95%">
    <tr>
        <td colspan="3" style="width: 50%">
            <table>
                <tr> <td>Invoice No : {{$invoicedetails->invoicebillno}}</td></tr>
                <tr> <td>Date Of Invoice : {{ Form::label( $invoicedetails->invoicedate) }}</td></tr>
                <tr> <td>PO No :{{$contractmatsrs->purchaseorderno}}</td></tr>
                <tr> <td>PO Date :{{$contractmatsrs->purchaseorderdate}}</td></tr>
                <tr> <td style="height: 21px;"></td></tr>
            </table>

        </td>
        <td colspan="3" style="width: 40%">
            <table>
                <tr><td>Challan No. & Date : 208 dt. 18.08.2017</td></tr>
                <tr> <td>Mode of Transport :</td></tr>
                <tr> <td>Veh.No : </td></tr>
                <tr>  <td>Date & Time of Supply :  </td></tr>
                <tr> <td>Place OF Supply : </td></tr>
                {{--<tr> <td style="height:45px;"></td></tr>--}}
            </table>
        </td>
    </tr>
</table>

<table align="center" style="width: 95%">
    <tr>
        <td colspan="3" style="width: 50%">
            <table>
                @if($workordercustomer!='')
                <tr> <td colspan="3">Details of Receiver (Billed to)</td></tr>
                <tr> <td colspan="3">Name : {{ $workordercustomer->customername}}</td></tr>
                <tr> <td colspan="3" style="width: 150px;" valign="top">Address : {{$workordercustomer->address}}</td></tr>
                <tr> <td colspan="3">State : {{$workordercustomer->state}}</td></tr>
                <tr> <td colspan="3">State Code : {{$workordercustomer->statecode}}</td></tr>
                <tr> <td colspan="3">GSTIN/Unique ID : {{$workordercustomer->customergstno}}</td></tr>
                <tr> <td style="height:29px;"></td></tr>
                    @else
                    <tr> <td colspan="3">Details of Receiver (Billed to)</td></tr>
                    <tr> <td colspan="3">Name : NA</td></tr>
                    <tr> <td colspan="3" style="width: 150px;" valign="top">Address : NA</td></tr>
                    <tr> <td colspan="3">State : NA</td></tr>
                    <tr> <td colspan="3">State Code : NA</td></tr>
                    <tr> <td colspan="3">GSTIN/Unique ID : NA</td></tr>
                    <tr> <td style="height:29px;"></td></tr>
                    @endif
            </table>

        </td>
        <td colspan="3" style="width: 40%">
            <table>
                <tr> <td colspan="3">Details of Consignee </td></tr>
                <tr> <td colspan="3">Name : Empty</td></tr>
                <tr> <td colspan="3" style="height: 50px;" valign="top">Address : Empty</td></tr>
                <tr> <td colspan="3">State : Empty</td></tr>
                <tr> <td colspan="3">State Code : Empty</td></tr>
                <tr> <td colspan="3">GSTIN/Unique ID: : Empty</td></tr>
            </table>
        </td>
    </tr>
</table>


<table align="center" style="width: 95%">
    <tr>
        <td align="center"><b>Sr No.</b></td>
        <td align="center"><b> Description of Goods</b></td>
        <td align="center"><b> HSN Code</b></td>
        <td align="center"><b> Qty</b></td>
        <td align="center"><b> Rate</b></td>
        <td align="center"><b> Total</b></td>
        <td align="center"><b> Taxable value</b></td>
        <td>
            <table align="right">
                <tr>
                    <td colspan="5" align="center"><b>SGST | CGST</b></td>
                </tr>
                <tr>
                    <td width="50px" align="center"><b>Rate</b></td>
                    <td  width="50px" align="center"><b>Amt</b></td>
                    <td  width="50px" align="center"><b>Rate</b></td>
                    <td  width="50px" align="center"><b>Amt</b></td>
                </tr>

            </table>
        </td>
    </tr>
       @for($i=1;$i<=count($contractinvoicedetails);$i++)
    <tr>
        <td  valign="top">{{$i}}</td>
        <td align="center" valign="top" style="width: 50px;">{{$contractinvoicedetails[$i-1]->equipmenttype}}</td>
        <td align="center" valign="top">{{$contractinvoicedetails[$i-1]->hsncode}}</td>
        <td align="center" valign="top">{{$contractinvoicedetails[$i-1]->quantity}}</td>
        <td align="center" valign="top">{{$contractinvoicedetails[$i-1]->rate}}</td>
        <td align="center" valign="top"> {{$contractinvoicedetails[$i-1]->totalamount }}</td>
        <td align="center" valign="top"> {{$contractinvoicedetails[$i-1]->taxamount}}</td>
        <td align="center" valign="top">
            <table  align="right">
                <tr>
                    <td width="50px" align="center">{{$contractinvoicedetails[$i-1]->sgstrate}}</td>
                    <td  width="50px" align="center">{{$contractinvoicedetails[$i-1]->sgstamount}}</td>
                    <td  width="50px" align="center">{{$contractinvoicedetails[$i-1]->cgstrate}}</td>
                    <td  width="50px" align="center">{{$contractinvoicedetails[$i-1]->cgstamount}}</td>
                </tr>
            </table>
        </td>
    </tr>
    @endfor
    <tr>
        <td  valign="top" colspan="7">Invoice Total ( In Words) : {{$convertrupee}}</td>
        <td valign="top" align="right"><h4>Total : {{$invoicedetails->invoiceamount }}</h4></td>
    </tr>

    <tr>
        <td  valign="top" colspan="7">
            <table>
                <tr>
                    <td>Vendor Code No. : {{$contractsdetails->vendorcode}}</td>
                </tr>
                {{--<tr>--}}
                    {{--<td>GSTIN :  {{$company->gstin}}</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<td>CIN No. : {{$company->cinno}}</td>--}}
                {{--</tr>--}}
            </table>
        </td>
        <td  valign="top"  align="right"><h4>Invoice Total : {{ $invoicedetails->invoiceamount }} </h4></td>
    </tr>
    <tr>
        <td  valign="top" colspan="8">

            <table>
                <tr><td><b>Certified that the Particulars given above are true and correct and the amount indicated</b></td></tr>
                <tr><td>a)represent the price actually charged and that there is no flow additional consideration directly orindirectly from the buyer or</td></tr>
                <tr><td>b)is provisional as additional consideration will be received from the buyer on account of</td></tr>
            </table>

        </td>
    </tr>

    <tr>
        <td valign="top" colspan="8">
            <table>
                <tr><td><b>Terms Of Sale</b></td></tr>
                <tr><td>1) Goods once sold will not be taken back or exchange.</td></tr>
                <tr><td>2) Seller is not responsible for any loss or damaged of goods in transit</td></tr>
                <tr><td>3) Buyer Undertakes to submit prescribted ST declaration to sender on damand.Disputes if any will be subject to seller court jurisdication</td></tr>

            </table>
        </td>
    </tr>

    <tr><td  valign="top" colspan="8" align="right"><b>For Techno Win IT Infra Pvt. Ltd.</b></td></tr>
    <tr>
        <td colspan="8" style="height:15px;"></td>
    </tr>
</table>

<table  align="center" style="width: 95%" >
    <tr>
        <td colspan="3">Prepared By</td>
        <td colspan="2">Certified By</td>
        <td colspan="1">Authorised Signature</td>
    </tr>
    <tr>
        <td colspan="8" style="height:15px;" align="right">Receivers Signature</td>
    </tr>
</table>

</div>
<br>
<div align="center">
        {{Form::hidden('contractno',$contractno)}}
        {{Form::hidden('paymentcycle',$paymentcycle)}}
          {{--<input type="button" id="create_pdf" value="Generate PDF">--}}
          <input type="button" value="Print" id="btnPrint" style="height:30px" onclick="printDiv('dvContainer')" />
           {{ Form::submit('Generate PDF',array('class'=>'btn','style=height:30px'))}}

{{--        {{ Form::submit(' Print ',array('class'=>'btn','style=height:25px'))}}--}}
       @if($contractmatsrs->workordertype=='Hardware Warranty')
        <a href="{{ URL::to('supplyindex')}}">{{ Form::button(' Close ',array('class'=>'btn','style=height:30px'))}}</a>
    @else
        <a href="{{ URL::to('invoicepaymentdetails')}}">{{ Form::button(' Close ',array('class'=>'btn','style=height:30px'))}}</a>
           @endif
</div>

{{Form::close()}}