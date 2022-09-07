<head>
    <script>
        function myFunction() {
            window.print();
        }
    </script>
    <style>
        /*table, td, th {*/
        /*border: 1px solid black;*/
        /*}*/
        body{
            height:297mm;
            width:210mm;
        }
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
        .test{
            overflow-wrap: break-word;
        }

    </style>
</head>
<body>
<table  align="center" style="width: 80%; border-collapse: collapse; margin-left: 80px; margin-top:210px;" >

    {{--<tr>--}}
        {{--<td colspan="7" align="center"><h1>Quotation</h1></td>--}}
    {{--</tr>--}}
    <tr>
        <td colspan="7" align="right">Date : {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ProspectiveQutation->quotationdate )->format('d-M-Y') }}</td>
        {{--<td colspan="7" align="right">Date : 14<sup>th</sup> May 2018 </td>--}}

    </tr>
    <tr>
        <td colspan="7" style="padding-bottom: 30px;">Quotationno No : {{$ProspectiveQutation->quotationno}}</td>
    </tr>
    <tr>
        <td colspan="7">To,</td>
    </tr>
    <tr>
        {{--<td colspan="7">Best Undertaking,<br>Divisional Customer Care,<br>GN Ward <br>Dadar</td>--}}
        <td colspan="7" >{{$ProspectiveQutation->subject}}</td>
    </tr>

    <tr>
        {{--<td colspan="7" align="center"><b>Sub : <u>Estimate for repair of {{$existingusercomplaint->productservicecode}} {{$quotationdetails->product}} at {{$quotationdetails->customersite}}</u></b>  </td>--}}
    </tr>


    <tr>
        <td colspan="7">Sir / Mam,</td>
    </tr>

    <tr>
        {{--<td colspan="7" style="padding-left: 100px; padding-top: 20px;">With have checked printer at your ofiice.During our inspection it was found that power supply has been worn out are quoting our rates for printer repair which are as follows.</td>--}}
        <td colspan="7" style="padding-left: 100px; padding-top: 10px;">{{$ProspectiveQutation->description}}</td>
    </tr>


    <tr>
        <td style="padding-top: 15px;" colspan="7">
            <table  style="width: 100%; border:1px solid black;">
                <tr style="border: 1px solid black" >
                    <td style="width: 5px; border:1px solid black;" align="center"><b>Sr.No</b></td>
                    <td style="width: 20px; border:1px solid black;"  align="center"><b>Description</b></td>
                    <td  style="width: 10px; border:1px solid black;"  align="center"><b>Amt.</b></td>
                    <td style="width: 5px;  border:1px solid black;" align="center"><b>Qty</b></td>
                    {{--<td  style="width: 10px; border:1px solid black;"  align="center"><b>GST % Extra</b></td>--}}
                    <td  style="width: 10px; border:1px solid black;"  align="center"><b>GST Value</b></td>
                    <td style="width: 10px; border:1px solid black;" align="center"><b>Total Amount</b></td>
                </tr>

                @foreach($ProspectiveQutationdetails as $key => $ProspectiveQutationde)
                    <tr>
                        <td style="width: 5px; border:1px solid black;" align="center">{{$key+1}}</td>
                        <td style="width: 20px; border:1px solid black;" align="center">{{$ProspectiveQutationde->configuration}}</td>
                        <td style=" border:1px solid black;" align="center" width="550px;">{{$ProspectiveQutationde->total}}</td>
                        <td style="width: 10px; border:1px solid black;" align="center">{{$ProspectiveQutationde->qty}}</td>
                        <td style="width: 10px; border:1px solid black;" align="center">{{$ProspectiveQutationde->amt}}</td>
                        <td style="width:10px; border:1px solid black;" align="center">{{$ProspectiveQutationde->grandamt}}</td>
                    </tr>
                @endforeach

                <tr>
                    <td style="width: 5px; border:1px solid black;"></td>
                    <td colspan="4" style="width: 60px; border:1px solid black;" align="center"><b>Total</b></td>
                    <td style="width: 10px; border:1px solid black;" align="center">{{$grandtotal}}</td>
                </tr>

            </table>
        </td>
    </tr>

    <tr>
        {{--<td colspan="7"><b>In Words : {{$convertrupee}}.</b></td>--}}
    </tr>
    <tr>
        <td colspan="7" style="padding-top: 15px"><b>Remark:</b></td>
    </tr>
    <tr>
        <td colspan="7" style="padding-left: 66px"><b>1)</b> Above mentioned part cover only 3 month warranty by service center.</td>
    </tr>
    <tr>
        <td colspan="7" style="padding-left: 66px"><b>2)</b> Any Physical damage or Worn out part will not be covered under Warranty/AMC.</td>
    </tr>

    <tr>
        <td colspan="7" style="padding-top: 20px;padding-left: 66px">Sir, We hope that you find our rates competitive and are waiting for your favourable response.</td>
    </tr>

    <tr>
        <td colspan="7" style="padding-top: 15px;padding-left: 66px">Tahnking you,</td>
    </tr>
    <tr>
        <td colspan="7" style="padding-top: 45px;">Prepared by</td>
    </tr>
    <tr>
        <td colspan="7" style="padding-top: 15px; padding-right: 35px;" align="right">Your Truly,</td>
    </tr>
    <tr>
        <td colspan="7" align="right">Techno Win IT Infra Pvt Ltd.</td>
    </tr>
    <tr>
        <td colspan="7" style="padding-top: 250px;padding-left:46px; font-size: 15px;"><p>De-Elmas, 401, 4<sup>th</sup>Floor, Sonawale Cross Lane, Pahadi Village,Goregaon (East),Mumbai-400063</p> </td>
    </tr>
    <tr>
        <td colspan="7" style="padding-left:50px; font-size: 15px;"> Mob:9321392010 / 7738393574 | E-mail : techno-win@hotmail.com | Website : technowin.co.in </td>
    </tr>
</table>
<br>

</body>
{{--<table style="margin-left: 350px;">--}}
    {{--<tr>--}}
        {{--<td><button onclick="myFunction()">Print</button></td>--}}
    {{--</tr>--}}
{{--</table>--}}
