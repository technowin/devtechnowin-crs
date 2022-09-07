<table border='1' width='700px'  align='center'>
    <tr>
        <td colspan="4" style="border: silver 1px solid;" align="center"><b><h1>Report</h1></b></td>
    </tr>

    @foreach($value as $val)
        <tr>
            <td style="border: silver 1px solid;"><b>Company Name : {{$val->companyname}}</b></td>
            <td style="border: silver 1px solid;"><b>Total Amt : {{$val->totalbidderamt}}</b></td>
        </tr>
        <tr>
            <td style='text-align: center'><b>Component</b></td>
            <td style='text-align: center'><b>QTY</b></td>
            <td style='text-align: center'><b>Rate</b></td>
            <td style='text-align: center'><b>AMT</b></td>
        </tr>
        @foreach($data as $mydata)
            @if($val->id == $mydata->biddercompanynameid)
                <tr>
                    <td style="text-align: center">{{$mydata->component}}</td>
                    <td style="text-align: center">{{$mydata->noofquantity}}</td>
                    <td style="text-align: center">{{$mydata->perunitrate}}</td>
                    <td style="text-align: center">{{$mydata->bidamount + 0}}</td>

                </tr>
            @endif
        @endforeach
    @endforeach
</table>