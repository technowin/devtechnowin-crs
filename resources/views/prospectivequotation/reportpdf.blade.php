 <table border="1" width="750px;">
        <tr>
            <td><b>Organization Name</b> </td>
            <td style="padding-left:50px;"><b>Quotation Date </b> </td>
            <td style="padding-left:50px;"><b>Quotation No</b> </td>
            <td style="padding-left:30px;"><b>Products</b> </td>
            <td style="padding-left:30px;"><b>Category</b> </td>
            <td style="padding-left:0px;text-align:center;"><b>Qty</b> </td>
            <td style="text-align:center;"><b>Amount</b></td>
            {{--<td style="text-align:center;"><h4>Configuration</h4></td>--}}

        </tr>
        @foreach($report as $key => $reportlist)
            <tr>
                <td>{{$reportlist->customers->customername}}</td>
                <td style="padding-left:60px;">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$reportlist->quotationdate)->format('Y-m-d') }}</td>
                <td style="padding-left:30px;">{{$reportlist->quotationno}}</td>
                <td>
                    <table border="0">
                        @foreach($mainreport as $kry => $mainreportlist)
                            @if($reportlist->quotationno == $mainreportlist->quotationno)
                                <tr>
                                    <td style="padding-left:30px;">{{$mainreportlist->products->productservicename}}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </td>
                <td>
                    <table border="0">
                        @foreach($mainreport as $kry => $mainreportlist)
                            @if($reportlist->quotationno == $mainreportlist->quotationno)
                                <tr>
                                    <td style="padding-left:30px;">{{$mainreportlist->category->categoryname}}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </td>
                <td>
                    <table style="margin-left:10px;" border="0">
                        @foreach($mainreport as $kry => $mainreportlist)
                            @if($reportlist->quotationno == $mainreportlist->quotationno)
                                <tr>
                                    <td style="padding-left:0px;">{{$mainreportlist->qty}}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </td>
                <td>
                    <table style="margin-left:15px;" border="0">
                        @foreach($mainreport as $kry => $mainreportlist)
                            @if($reportlist->quotationno == $mainreportlist->quotationno)
                                <tr>
                                    <td style="padding-left:10px;">{{$mainreportlist->rate}}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </td>
            </tr>
        @endforeach
    </table>
