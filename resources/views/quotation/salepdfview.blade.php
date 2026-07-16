
<head>

    <style>
        /*table, td, th {*/
        /*border: 1px solid black;*/
        /*}*/

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

</head>
<body>
    <table align="center" style="width: 90%; border-collapse: collapse;" >

        <tr>
            <td colspan="7" align="center"><h1>Quotation</h1></td>
        </tr>
        <tr>
            {{--<td align="right">Date : 17 <sup>th</sup> July, 2017</td>--}}
            <td colspan="4" align="right"> Date : {{$date->day}}th {{$date->format('F')}},{{$date->year}}</td>
        </tr>
        <tr>
            <td colspan="7" style="padding-bottom: 30px;">Estimate No : {{$saleproduct[0]->quotationnumber}}</td>
        </tr>
        <tr>
            <td colspan="7">To,</td>
        </tr>
        <tr>
            <td  style="width: 100%;padding-top: 7px">
                <table>
                    <tr>
                        <td style="width: 55%" align="left">{{$custaddres->address}}</td>
                        <td style="width: 45%"></td>
                    </tr>
                </table>
            </td>
            {{--<td colspan="7">Best Undertaking,<br>Divisional Customer Care,<br>GN Ward <br>Dadar</td>--}}
        </tr>

        <tr>
            <td colspan="4" align="center"><b>Sub : Estimate for Supply of new {{$saleproduct[0]->productsupply}}  at {{$saleproduct[0]->customersite}}.</b>  </td>
        </tr>
        <tr>
            <td colspan="7">Sir / Mam,</td>
        </tr>


        <tr>
            <td colspan="7" style="padding-left: 100px; padding-top: 20px;">We are offering you new {{$saleproduct[0]->productsupply}}. We are quoting our best rates which are given below.</td>
        </tr>

        <tr>
            <td colspan="7" style="padding-top: 7px">
                <table  style="width: 100%; border:1px solid black;">
                    <tr style="border: 1px solid black" >
                        <td style="width:12%; border:1px solid black;" align="center"><b>Sr.No</b></td>
                        <td style="width: 50%; border:1px solid black;"align="left"><b>Description</b></td>
                        <td style="width: 15%; border:1px solid black;"  align="left"><b>Amt.</b></td>
                        <td style="width: 10%; border:1px solid black;" align="center"><b>Qty</b></td>
                        <td style="width: 28%; border:1px solid black;"  align="left"><b>GST% Extra</b></td>
                        <td style="width: 20%; border:1px solid black;"  align="left"><b>GST Value</b></td>
                        <td style="width: 28%; border:1px solid black;" align="left"><b>Total Amount</b></td>
                    </tr>
                    @for($i=0;$i<count($saleproduct);$i++)
                        @if($saleproduct[$i]->productdescription !="Installation Charge")
                            <tr>
                                <td style="width: 5%; border-right :1px solid black;" align="center">{{$i+1}}</td>
                                <td style="width: 40%; border-right: 1px solid black" align="left">
                                    <table>
                                        @if($i==0)
                                        <tr>
                                                <td align="left"><b>New Supply</b></td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td  align="left">{{$saleproduct[$i]->productdescription}}</td>
                                        </tr>
                                    </table>
                                </td>
                                {{--<td style=" border:1px solid black;" align="left" width="450px;"><b>New Supply</b></td>--}}
                                {{--<td style="border-right: 1px solid black" align="left" width="450px;"><b>{{$saleproduct[$i]->productdescription}}</b></td>--}}
                                <td style="width:10%; border-right:1px solid black;" align="center" >{{$saleproduct[$i]->rate}}</td>
                                <td style="width: 10%; border-right:1px solid black;" align="center" >{{$saleproduct[$i]->requestedquantity}}</td>
                                <td style="width: 10%; border-right:1px solid black;" align="center" >{{$saleproduct[$i]->gstrate}}</td>
                                <td style="width: 10%; border-right:1px solid black;" align="center" >{{$saleproduct[$i]->taxvalue}}</td>
                                <td style="width: 15%; border-right:1px solid black;" align="center" >{{$saleproduct[$i]->totalamount}}</td>
                            </tr>
                        @endif
                    @endfor
                    <tr>
                        {{--<td style=" border:1px solid black;"></td>--}}
                        <td colspan="6" style=" border:1px solid black;" align="center"><b>Total</b></td>
                        <td style=" border:1px solid black;" align="center">{{$totalproductamt}}</td>
                    </tr>
                    @for($i=0;$i<count($saleproduct);$i++)
                        @if($saleproduct[$i]->productdescription =="Installation Charge")
                            <tr>
                                <td style=" border-right:1px solid black;" align="center">1</td>
                                <td>
                                    <table>
                                        <tr>
                                            <td align="left"><b>Installation</b></td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="width: 53%">{{$saleproduct[$i]->productdescription}}</td>
                                        </tr>
                                    </table>
                                </td>

                                <td style=" border:1px solid black;" align="center">{{$saleproduct[$i]->rate}}</td>
                                <td style=" border:1px solid black;" align="center">{{$saleproduct[$i]->requestedquantity}}</td>
                                <td style=" border:1px solid black;" align="center">{{$saleproduct[$i]->gstrate}}</td>
                                <td style=" border:1px solid black;" align="center">{{$saleproduct[$i]->taxvalue}}</td>
                                <td style="border-right: 1px solid black" align="center">{{$saleproduct[$i]->totalamount}}</td>
                            </tr>
                            <tr>
                                <td colspan="6" style=" border:1px solid black;" align="center"><b>Total</b></td>
                                <td style=" border:1px solid black;" align="center">{{$saleproduct[$i]->totalamount}}</td>
                            </tr>
                        @endif
                    @endfor
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="7"><b>In Words :{{$convertrupee}}. </b></td>
        </tr>
        <tr>
            <td colspan="7" style="padding-top: 15px"><b>Terms & Conditions:</b></td>
        </tr>
        <tr>
            <td colspan="7" style="padding-left: 66px">1)  Order for the Machine to be placed on Techno Win IT Infra Pvt Ltd.</td>
        </tr>
        <tr>
            <td colspan="7" style="padding-left: 66px">2)   Payment : For Machine – 100% advance</td>
        </tr>
        <tr>
            <td colspan="7" style="padding-left: 150px">For Installation – 50 % advance</td>
        </tr>
        <tr>
            <td colspan="7" style="padding-left: 251px"> – 50% against delivery of material</td>
        </tr>
        <tr>
            <td colspan="7" style="padding-left: 66px">3) Warranty: 12 months from the date of delivery. </td>
        </tr>
        <tr>
            <td colspan="7" style="padding-left: 66px">4) Delivery: 1 to 2 Weeks from the date of technically and commercially clear the order.</td>
        </tr>
        <tr>
            <td colspan="7" style="padding-left: 66px">5) Power for testing and commissioning the Unit has to be provided by you.</td>
        </tr>
        <tr>
            <td colspan="7" style="padding-left: 66px">6) Statutory Variations : All Statutory variations will be to your account</td>
        </tr>
        <tr>
            <td colspan="7" style="padding-top: 20px;padding-left: 66px">We hope that you will find our rates as competitive and are waiting for your favourable response.</td>
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
            <td colspan="4" align="right">Techno Win IT Infra Pvt Ltd.</td>
        </tr>
        <tr>
            <td colspan="7" style="padding-top: 20px"></td>
        </tr>
    </table>
</body>