<html>
<style>
    body{
        height:297mm;
        width:200mm;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
</style>
<head><h2 align="center" style="padding-top: 180px;padding-bottom: 30px">Delivery Challan</h2></head>
<body>
    <table align="center" style="width: 60%; border-collapse: collapse; " >
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
                <table style="width: 100%; border:1px solid black;margin-top:8px;" id="table">
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
                    <tr style="border: 1px solid black">
                        <td style="width:5px; border:1px solid black;"></td>
                        <td align="center" style="width:5px; border:1px solid black;"><b>Total</b></td>
                        <td style="width:5px; border:1px solid black;"></td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <table align="center" style="width: 60%; border-collapse: collapse;margin-top:15px;" >
        <tr>
            <td><b>Company GSTIN :</b>27AACCT9295R1Z7</td>
            <td align="right" style="text-decoration:overline; padding-top: 50px"><b>Issued By</b></td>
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
            <td align="right" style="padding-top: 50px; text-decoration:overline"><b>Receiver's Signature</b></td>
        </tr>
        <tr>
            <td><b>Material taken over by: </b></td>
        </tr>
    </table>
</body>
</html>
