
<head>
    <link href="{{asset('bootstrap-3.3.7/css/bootstrap.min.css')}}" rel="stylesheet">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
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
                "<html><head><title>Quotation Report</title></head><body>" +
                printContents + "</body>";
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
</head>
<body>
<div id="dvContainer">
    <table align="center" style="width: 60%; border-collapse: collapse;" >

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
            <td>To,</td>
        </tr>
        <tr>
            <td>Best Undertaking,<br>Divisional Customer Care,<br>GN Ward <br>Dadar</td>
        </tr>

        <tr>
            <td align="center" style="padding-top: 8px"><b>Sub : <u>Quotation for  {{$quotationdetails->subject}}</u></b>  </td>
        </tr>


        <tr>
            <td style="padding-top: 8px">Sir / Mam,</td>
        </tr>

        <tr>
            <td style="padding-left: 100px; padding-top: 20px;">With reference to your enquiry for {{$quotationdetails->description}} . We are quoting our rates which are as gived below.</td>
        </tr>

        <tr>
            <td>
                <table  style="width: 100%; border:1px solid black;margin-top:8px;">
                    <tr style="border: 1px solid black" >
                        <td style="width:5px; border:1px solid black;" align="center"><b>Sr.No</b></td>
                        <td style="width: 20px; border:1px solid black;"  align="center"><b>Description</b></td>
                        <td  style="width: 10px; border:1px solid black;"  align="center"><b>Amt.</b></td>
                        {{--<td style="width: 10px; border:1px solid black;" align="center"><b>Qty</b></td>--}}
                        <td  style="width: 10px; border:1px solid black;"  align="center"><b>GSTIN@<br>18% Extra</b></td>
                        <td  style="width: 10px; border:1px solid black;"  align="center"><b>GST<br>Value</b></td>
                        <td style="width: 10px; border:1px solid black;" align="center"><b>Amt.</b></td>
                    </tr>

                    <tr>
                        <td style="width: 5px; border:1px solid black;" align="center">1</td>
                        <td style="width: 20px; border:1px solid black;" align="center">{{$existingusercomplaint->productservicecode}} {{$quotationdetails->product}}<br>({{$quotationdetails->productsrno}})<br>{{$existingusercomplaint->complaintdescription}}</td>
                        <td style="width: 10px; border:1px solid black;" align="center">{{$quotationdetails->rate}}</td>
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
    <table align="center" style="width: 60%; border-collapse: collapse;margin-top:15px;" >
        <tr>
                <td><b>In Words : Rs. {{$convertrupee}}.</b></td>
        </tr>
    </table>
    <table align="center" style="width: 60%; border-collapse: collapse;margin-top:15px;" >
        <tr>
            <td style="padding-left: 66px"> Sir , we hope that you will find our rates as competitive and are waiting for your fevorable response.</td>
        </tr>
        <br>
        <tr>
            <td style="padding-top: 15px;padding-left: 66px">Tahnking you,</td>
        </tr>
        <tr>
            <td style="padding-top: 45px;">Prepared by</td>
        </tr>
        <tr>
            <td style="padding-top: 15px; padding-right: 35px;" align="right">Your Truly,</td>
        </tr>
        <tr>
            <td style="padding-top: 20px"></td>
        </tr>
    </table>

</div>
</body>
<br>
{{Form::open(array('url' => 'download/','files' => true))}}
<div align="center">
    {{Form::hidden('quotationnumber',$quotationdetails->quotationnumber)}}
    {{--<input type="button" value="Print" id="btnPrint" style="height:30px" class="btn-primary" onclick="printDiv('dvContainer')" />--}}
    {{Form::button('Print',array('id'=>'btnPrint','class'=>'btn btn-primary','onclick'=>'printDiv("dvContainer")'))}}
    {{ Form::submit('Generate PDF',array('class'=>'btn btn-primary','style=height:30px'))}}
    <a href="{{URL::to('quotation')}}">{{Form::button('Close',array('class'=>'btn btn-primary','style=height:30px'))}}</a>
</div>
{{Form::close()}}
