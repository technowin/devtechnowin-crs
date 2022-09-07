<head>
    <style>
        /*table, td, th {*/
        /*border: 1px solid black;*/
        /*}*/
        body{
            height:297mm;
            /*height:297mm;*/
            width:210mm;
            /*width:210mm;*/
        }
        table {
            border-collapse: collapse;

        }
        /*table {*/
        /*    border-collapse: collapse;*/
        /*    width: 100%;*/
        /*}*/

        th {
            height: 50px;
        }
    </style>
</head>
<body>
<table align="center" style="width: 70%; border-collapse: collapse; margin-left: 50px; margin-right: 50px" >

    <tr>
        <td  align="center"><h1>Quotation</h1></td >
    </tr>
    <tr>
        {{--<td align="right">Date : 17 <sup>th</sup> July, 2017</td>--}}
        <td align="right">Date : {{$date->day}}th {{$date->format('F')}},{{$date->year}}</td>
    </tr>
    <tr>
        <td style="padding-bottom: 30px;">Estimate No : {{$quotationdetails->quotationnumber}}</td>
    </tr>

    <tr>
        <td>
            To,<br>
            Best Undertaking,<br>
            Divisional Customer Care,<br>
            GN Ward <br>
            Dadar
        </td>
    </tr>

    <tr>
        <td align="center" style="padding-top: 8px; word-wrap:break-word;">Sub : Quotation for  {{$quotationdetails->subject}}  </td>
    </tr>


    <tr>
        <td style="padding-top: 8px">Sir / Mam,</td>
    </tr>

    <tr>
        <td style="padding-left: 20px;padding-right: 200px; padding-top: 20px; word-wrap:break-word; width:50%;"> With reference to your enquiry for {{$quotationdetails->description}}.<br> We are quoting our rates which are as given below.
        </td>
    </tr>

    <tr>
        <td>
            <table  style="width: 650px; border:1px solid black;margin-top:8px;">
                <tr style="border: 1px solid black" >
                    <td style="width:20px; border:1px solid black;" align="left"><b>Sr.No</b></td>
                    <td style="width: 200px; border:1px solid black;"  align="left"><b>Description</b></td>
                    <td  style="width: 15px; border:1px solid black;"  align="left"><b>Amt.</b></td>
                    {{--<td style="width: 10px; border:1px solid black;" align="center"><b>Qty</b></td>--}}
                    <td  style="width: 38px; border:1px solid black;"  align="left"><b>GSTIN@<br>18% Extra</b></td>
                    <td  style="width: 25px; border:1px solid black;"  align="left"><b>GST<br>Value</b></td>
                    <td style="width: 15px; border:1px solid black;" align="left"><b>Amt.</b></td>
                </tr>

                <tr>
                    <td style="width: 20px; border:1px solid black;" align="center">1</td>
                    <td style="width: 200px; border:1px solid black; word-wrap:break-word;" align="left">{{$existingusercomplaint->productservicecode}} {{$quotationdetails->product}}<br>({{$quotationdetails->productsrno}})<br>{{$existingusercomplaint->complaintdescription}}</td>
                    <td style="width: 15px; border:1px solid black;" align="center">{{$quotationdetails->rate}}</td>
                    {{--<td style="width: 10px; border:1px solid black;" align="center">{{$quotationdetails->requestedquantity}}</td>--}}
                    <td style="width: 10px; border:1px solid black;" align="center">{{$quotationdetails->gstrate}}</td>
                    <td style="width: 10px; border:1px solid black;" align="center">{{$quotationdetails->taxvalue}}</td>
                    @if($quotationdetails->finalquotationamount==null)
                        <td style="width: 10px; border:1px solid black;" align="center">{{$quotationdetails->quotationamount}}</td>
                    @else
                        <td style="width: 10px; border:1px solid black;" align="center">{{$quotationdetails->finalquotationamount}}</td>
                    @endif
                </tr>
                <tr>
                    <td style="width: 5px; border:1px solid black;"></td>
                    <td colspan="4" style="width: 80px; border:1px solid black;" align="center"><b>Total</b></td>
                    <td style="width: 10px; border:1px solid black;" align="center">{{$quotationdetails->quotationamount}}</td>

                </tr>

            </table>
        </td>
    </tr>
</table>
<table align="center" style="width: 60%; border-collapse: collapse;margin-top:15px; margin-left: 50px; margin-right: 50px" >
    <tr>
        <td><b>In Words : Rs. {{$convertrupee}}.</b></td>
    </tr>
</table>
<table align="center" style="width: 60%; border-collapse: collapse;margin-top:15px; margin-left: 50px; margin-right: 50px" >
    <tr>
        <td style="padding-left: 20px;padding-right: 200px; padding-top: 20px; word-wrap:break-word; width:50%;"> Sir , we hope that you will find our rates as competitive and are waiting for your favourable response. </td>
    </tr>
    <br>
    <tr>
        <td style="padding-top: 15px;padding-left: 66px">Thanking you,</td>
    </tr>
    <tr>
        <td style="padding-top: 45px;">Prepared by</td>
    </tr>
    <tr>
        <td style="padding-top: 15px; padding-right: 35px;" align="right">Yours Truly,</td>
    </tr>
    <tr>
        <td style="padding-top: 20px"></td>
    </tr>
</table>
</body>