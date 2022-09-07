<html>
<head>

    <link href="{{asset('bootstrap-3.3.7/css/bootstrap.min.css')}}" rel="stylesheet">
    <script type="text/javascript">

        var finalqut = function(){
            debugger
            var status= document.getElementById('quotationstatus').value;
            if(status!='Approved')
            {
                document.getElementById('final').style.display='none';

            }else {
                document.getElementById('final').style.display='block';
            }
            if(status!=""){
                document.getElementById('remarkid').style.display='block';
            }else {
                document.getElementById('remarkid').style.display='none';
            }

        }

    </script>
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
<table align="center" style="width: 60%; border-collapse: collapse;" >

    <tr>
        <td colspan="5" align="center"><h1>Quotation</h1></td>
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
        <td  style="width: 100%;padding-top: 7px">
            <table>
                <tr>
                    <td style="width: 30%" align="left">{{$custaddres->address}}</td>
                    <td style="width: 70%"></td>
                </tr>
            </table>
        </td>
        {{--<td>Best Undertaking,<br>Divisional Customer Care,<br>GN Ward <br>Dadar</td>--}}
    </tr>

    <tr>
        <td align="center"><b>Sub : <u>Estimate for Supply of new {{$saleproduct[0]->productsupply}}  at {{$saleproduct[0]->customersite}} .</u></b>  </td>
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
                    <td style="width:5%; border:1px solid black;" align="center"><b>Sr.No</b></td>
                    <td style="width: 40%; border:1px solid black;"align="center"><b>Description</b></td>
                    <td style="width: 10%; border:1px solid black;"  align="center"><b>Amt.</b></td>
                    <td style="width: 10%; border:1px solid black;" align="center"><b>Qty</b></td>
                    <td style="width: 10%; border:1px solid black;"  align="center"><b>GST % Extra</b></td>
                    <td style="width: 10%; border:1px solid black;"  align="center"><b>GST Value</b></td>
                    <td style="width: 15%; border:1px solid black;" align="center"><b>Total Amount</b></td>
                </tr>
                @for($i=0;$i<count($saleproduct);$i++)
                    @if($saleproduct[$i]->productdescription !="Installation Charge")
                        <tr>
                            <td style="width:5%; border-right :1px solid black;" align="center">{{$i+1}}</td>
                            <td style="width:40%;border-right: 1px solid black" align="left">
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
                            <td style="width: 10%; border-right:1px solid black;" align="center">{{$saleproduct[$i]->rate}}</td>
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
<br>

{{ Form::open(array('url' => 'savesalestatus/','files' => true,'id'=>'status')) }}
{{Form::hidden('quotationnumber',$saleproduct[0]->quotationnumber)}}
<table>
    <tr>
        <td align="center" ><b>Quotation Status : </b>
            {{Form::select('quotationstatus',array('Approved'=>'Approved','Not approved'=>'Not approved'),null,array('placeholder'=>'--select--','id'=>'quotationstatus','onchange'=>'finalqut();return false;','required','style=height:30px;width:250px'))}}</td>
    </tr>
    <tr align="center" id="final" hidden style="margin-right: 50px; margin-top: 7px;">
        <td><b>Final Quotation amount : </b>
            {{Form::number('finalquotationamount',null,array('id'=>'finalquotation','style=height:30px;width:250px;'))}}</td>
    </tr>
    <tr id="remarkid" hidden align="center" style="padding-top: 7px;padding-left: 60px">
        <td ><b>Remarks :</b>
            {{Form::text('remarks',null,array('id'=>'remarks','style=height:30px;width:250px'))}}</td>
    </tr>
    <tr align="center"  style="margin-left: 81px; margin-top: 7px">
        <td>
            <br>
            {{Form::submit('Save',array('class'=>'btn btn-primary','onclick'=>'return remarksval();'))}}
        </td>
    </tr>
</table>
{{Form::close()}}
</body>
<script>
    function remarksval() {

        var quotationvalue= document.getElementById('quotationstatus').value;
        if(quotationvalue=='Not approved'){
            var remarktex= document.getElementById('remarks').value;
            if(remarktex=="")
            {
                alert('Enter remarks')
                return false;
            }
        }
    }
</script>
</html>