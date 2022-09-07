
<head>
    <link href="{{asset('bootstrap-3.3.7/css/bootstrap.min.css')}}" rel="stylesheet">
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
<table align="center" style="width: 90%; border-collapse: collapse;" >

    <tr>
        <td colspan="7" align="center"><h1>Quotation</h1></td>
    </tr>
    <tr>
        {{--<td align="right">Date : 17 <sup>th</sup> July, 2017</td>--}}
        <td align="right">Date : {{$date->day}} <sup>th</sup> {{$date->format('F')}},{{$date->year}}</td>
    </tr>
    <tr>
        <td style="padding-bottom: 30px;">Estimate No : {{$saleproduct[0]->quotationnumber}}</td>
    </tr>
    <tr>
        <td>To,</td>
    </tr>
    <tr>
        <td  style="width: 90%;padding-top: 7px">
            <table>
                <tr>
                    <td style="width: 25%" align="left">{{$custaddres->address}}</td>
                    <td style="width: 65%"></td>
                </tr>
            </table>
        </td>
        {{--<td colspan="6" style="width: 10px; border:1px solid black;" align="left">{{$custaddres->address}}</td>--}}
        {{--<td>Best Undertaking,<br>Divisional Customer Care,<br>GN Ward <br>Dadar</td>--}}
    </tr>

    <tr>
        <td style="padding-top: 10px" align="center"><b>Sub : <u>Estimate for Supply of new {{$saleproduct[0]->productsupply}}  at {{$saleproduct[0]->customersite}} .</u></b>  </td>
    </tr>


    <tr>
        <td>Sir / Mam,</td>
    </tr>

    <tr>
        <td style="padding-left: 100px; padding-top: 20px;">We are offering you new {{$saleproduct[0]->productsupply}} . We are quoting our best rates which are given below.</td>
    </tr>

    <tr>
        <td style="padding-top: 7px">
            <table  style="width: 100%; border:1px solid black;">
                <tr style="border: 1px solid black" >
                    <td style="width:10px; border:1px solid black;" align="center"><b>Sr.No</b></td>
                    <td style="width: 30px; border:1px solid black;"  align="center"><b>Description</b></td>
                    <td  style="width:10px; border:1px solid black;"  align="center"><b>Amt.</b></td>
                    <td style="width: 10px; border:1px solid black;" align="center"><b>Qty</b></td>
                    <td  style="width: 15px; border:1px solid black;"  align="center"><b>GST % Extra</b></td>
                    <td  style="width: 10px; border:1px solid black;"  align="center"><b>GST Value</b></td>
                    <td style="width: 20px; border:1px solid black;" align="center"><b>Total Amount</b></td>
                </tr>

                @for($i=0;$i<count($saleproduct);$i++)
                    @if($saleproduct[$i]->productdescription !="Installation Charge")
                <tr>
                    <td style=" width:10%;border-right :1px solid black;" align="center">{{$i+1}}</td>
                    <td style="width:35%;border-right: 1px solid black" align="left">
                        <table>
                            @if($i==0)
                            <tr>
                                <td align="center"><b>New Supply</b></td>
                            </tr>
                            @endif
                            <tr>
                                <td align="center">{{$saleproduct[$i]->productdescription}}</td>
                            </tr>
                        </table>
                    </td>
                    {{--<td style=" border:1px solid black;" align="left" width="450px;"><b>New Supply</b></td>--}}
                    {{--<td style="border-right: 1px solid black" align="left" width="450px;"><b>{{$saleproduct[$i]->productdescription}}</b></td>--}}
                    <td style="width: 10%; border-right:1px solid black;" align="center" >{{$saleproduct[$i]->rate}}</td>
                    <td style="width: 10%; border-right:1px solid black;" align="center">{{$saleproduct[$i]->requestedquantity}}</td>
                    <td style="width: 10%; border-right:1px solid black;" align="center">{{$saleproduct[$i]->gstrate}}</td>
                    <td style="width: 10%; border-right:1px solid black;" align="center">{{$saleproduct[$i]->taxvalue}}</td>
                    <td style="width: 15%; border-right:1px solid black;" align="center">{{$saleproduct[$i]->totalamount}}</td>

                </tr>
                    @endif

                @endfor

                <tr>
                    {{--<td style=" border:1px solid black;"></td>--}}
                    <td colspan="6" style=" border:1px solid black;" align="right"><b>Total</b></td>
                    <td style=" border:1px solid black;" align="center">{{$totalproductamt}}</td>
                </tr>
                @for($i=0;$i<count($saleproduct);$i++)
                @if($saleproduct[$i]->productdescription =="Installation Charge")
                <tr>
                    <td style=" border-right:1px solid black;" align="center">1</td>
                    <td>
                        <table>
                            <tr>
                                <td align="center"><b>Installation</b></td>
                            </tr>
                            <tr>
                                <td align="center">{{$saleproduct[$i]->productdescription}}</td>
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
                    <td colspan="6" style=" border:1px solid black;" align="right"><b>Total</b></td>
                    <td style=" border:1px solid black;" align="center">{{$saleproduct[$i]->totalamount}}</td>
                </tr>
                    @endif
                @endfor
            </table>
        </td>
    </tr>

    <tr>
        <td><b>In Words :{{$convertrupee}}. </b></td>
    </tr>
    <tr>
        <td style="padding-top: 15px"><b>Terms & Conditions:</b></td>
    </tr>
    <tr>
        <td style="padding-left: 66px"><b>1) </b>  Order for the Machine to be placed on Techno Win IT Infra Pvt Ltd.</td>
    </tr>
    <tr>
        <td style="padding-left: 66px"><b>2) </b>  Payment : For Machine – 100% advance</td>
    </tr>
     <tr>
         <td style="padding-left: 150px">For Installation – 50 % advance</td>
     </tr>
    <tr>
        <td style="padding-left: 251px"> – 50% against delivery of material</td>
    </tr>
    <tr>
        <td style="padding-left: 66px"><b>3)</b> Warranty: 12 months from the date of delivery. </td>
    </tr>
    <tr>
        <td style="padding-left: 66px"><b>4)</b> Delivery: 1 to 2 Weeks from the date of technically and commercially clear the order.</td>
    </tr>
    <tr>
        <td style="padding-left: 66px"><b>5)</b> Power for testing and commissioning the Unit has to be provided by you.</td>
    </tr>
    <tr>
        <td style="padding-left: 66px"><b>6)</b> Statutory Variations : All Statutory variations will be to your account</td>
    </tr>
    <tr>
        <td style="padding-top: 20px;padding-left: 66px">We hope that you will find our rates as competitive and are waiting for your favourable response.</td>
    </tr>

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
        <td align="right">Techno Win IT Infra Pvt Ltd.</td>
    </tr>
    <tr>
        <td style="padding-top: 20px"></td>
    </tr>
</table>
</div>
</body>
<br>
{{Form::open(array('url' => 'saledownload/','files' => true))}}
<div align="center">
    {{Form::hidden('quotationnumber',$saleproduct[0]->quotationnumber)}}
    {{--<input type="button" value="Print" id="btnPrint" style="height:30px" class="btn-primary" onclick="printDiv('dvContainer')" />--}}
    {{Form::button('Print',array('id'=>'btnPrint','class'=>'btn btn-primary','onclick'=>'printDiv("dvContainer")'))}}
    {{ Form::submit('Generate PDF',array('class'=>'btn btn-primary','style=height:30px'))}}
    <a href="{{URL::to('saleproduct')}}">{{Form::button('Close',array('class'=>'btn btn-primary','style=height:30px'))}}</a>
</div>
{{Form::close()}}