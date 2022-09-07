<html>
<style>
    /*table, td, th {*/
    /*border: 1px solid black;*/
    /*}*/
    table {
        border-collapse: collapse;
        width: 100%;
    }
    @page
    {
        size:  auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }

    html
    {
        background-color: #FFFFFF;
        margin: 0px;  /* this affects the margin on the html before sending to printer */
    }

</style>
<link href="{{asset('bootstrap-3.3.7/css/bootstrap.min.css')}}" rel="stylesheet">
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML =
            "<html><body>" +
            printContents + "</body>";
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<div id="challan">
<head>
    <h2 align="center" style="padding-top: 180px;">Delivery Challan</h2>
</head>
<body>
<table align="center" style="width: 60%; border-collapse: collapse;" >
    <tr>
    <tr>
        <td align="right"><b>Date : </b>{{$date->day}} <sup>th</sup> {{$date->format('F')}},{{$date->year}}</td>
    </tr>
    <tr>
        <td style="padding-bottom: 30px;"><b>Challan No : </b>{{$challanData->challanNo}}</td>
    </tr>
    <tr>
        <td><b>Customer : </b>{{$challanData->customers->customername}}</td>
    </tr>
    <tr><td><b>Customer Site : </b>{{$challanData->customers->address}}</td></tr>
    <tr>
        <td>
            <table style="width: 100%; border:1px solid black;margin-top:8px;">
                <thead>
                <tr style="border: 1px solid black" >
                    <td style="width:5px; border:1px solid black;" align="center"><b>Sr.No</b></td>
                    <td style="width: 20px; border:1px solid black;"  align="center"><b>Description</b></td>
                    <td  style="width: 10px; border:1px solid black;"  align="center"><b>Quantity</b></td>
                </tr>
                </thead>
                <tbody>
                <tr style="border: 1px solid black">
                    <td style="padding-top: 20px; border: 1px solid black" align="center">1</td>
                    <td style="padding-top: 20px; border: 1px solid black" align="center">{{$challanData->outwardProductDetails}}</td>
                    <td style="padding-top: 20px; border: 1px solid black" align="center">{{$challanData->outwardQuantity}}</td>
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="width:5px; border:1px solid black; padding-top: 5px"></td>
                    <td align="center" style="width:5px; border:1px solid black; padding-top: 5px"><b>Total</b></td>
                    <td align="center" style="width:5px; border:1px solid black; padding-top: 5px">{{$challanData->outwardQuantity}}</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>
<table align="center" style="width: 60%; border-collapse: collapse;margin-top:15px;" >
    <tr>
        <td style="padding-top: 60px"><b>Company GSTIN :</b>27AACCT9295R1Z7</td>
        <td align="right" style="text-decoration:overline;padding-top: 60px"><b>Issued By</b></td>
    </tr>
</table>
<table align="center" style="width: 60%; border-collapse: collapse;margin-top:15px;">
    <tr>
        <td><b>Terms & Condition :</b></td>
    </tr>
    <tr>
        <td>
            <ol>
                <li>Subject to Material Jurisdiction.</li>
                <li>Goods should be inspected by the RECEIVER while taking the Delivery.<br>No claim will be Entertained later.</li>
            </ol>
        </td>
    </tr>
    <tr>
        <td align="right" style="padding-top: 20px; text-decoration:overline"><b>Receiver's Signature</b></td>
    </tr>
    <tr>
        <td><b>Material taken over by: </b></td>
    </tr>
</table>
</body>
</div>
<br>
{{Form::open(array('url' => 'downloadchallan/','files' => true))}}
<div align="center">
    {{Form::hidden('ticketno',$challanData->ticketno)}}
    {{Form::hidden('id',$challanData->id)}}
    {{--<input type="button" value="Print" id="btnPrint" style="height:30px" class="btn-primary" onclick="printDiv('dvContainer')" />--}}
    {{Form::button('Print',array('id'=>'btnPrint','class'=>'btn btn-primary','onclick'=>'printDiv("challan")'))}}
    {{ Form::submit('Generate PDF',array('class'=>'btn btn-primary','style=height:30px'))}}
    <a href="{{URL::to('outwardindex')}}">{{Form::button('Close',array('class'=>'btn btn-primary','style=height:30px'))}}</a>
</div>
{{Form::close()}}
</html>