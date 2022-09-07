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
        <td style="padding-bottom: 30px;">Estimate No : {{$quotationdetails->quotationnumber}}</td>
    </tr>
    <tr>
        <td>To,</td>
    </tr>
    <tr>
        <td>Best Undertaking,<br>Divisional Customer Care,<br>GN Ward <br>Dadar</td>
    </tr>

    <tr>
        <td align="center"><b>Sub : <u>Estimate for repair of {{$existingusercomplaint->productservicecode}} {{$quotationdetails->product}} at {{$quotationdetails->customersite}}</u></b>  </td>
    </tr>


    <tr>
        <td>Sir / Mam,</td>
    </tr>

    <tr>
        <td style="padding-left: 100px; padding-top: 20px;">With have checked printer at your ofiice.During our inspection it was found that power supply has been worn out are quoting our rates for printer repair which are as follows.</td>
    </tr>

    <tr>
        <td>
            <table  style="width: 100%; border:1px solid black;">
                <tr style=" border: 1px solid black" >
                    <td style="width:150px; border:1px solid black;" align="center"><b>Sr.No</b></td>
                    <td style=" border:1px solid black;"  align="center"><b>Description</b></td>
                    <td  style=" border:1px solid black;"  align="center"><b>Amt.</b></td>
                    <td style=" border:1px solid black;" align="center"><b>Qty</b></td>
                    <td  style=" border:1px solid black;"  align="center"><b>GST % Extra</b></td>
                    <td  style=" border:1px solid black;"  align="center"><b>GST Value</b></td>
                    <td style=" border:1px solid black;" align="center"><b>Total Amount</b></td>
                </tr>

                <tr>
                    <td style="width: 5px; border:1px solid black;" align="center">1</td>
                    <td style=" border:1px solid black;" align="center" width="20px;">{{$existingusercomplaint->productservicecode}} {{$quotationdetails->product}}<br>({{$quotationdetails->productsrno}})<br>{{$existingusercomplaint->complaintdescription}}</td>
                    {{--<td style=" border:1px solid black;" align="center" width="450px;">{{customersite->complaintdescription}}</td>--}}
                    <td style="width: 10px; border:1px solid black;" align="center">{{$quotationdetails->rate}}</td>
                    <td style="width: 10px; border:1px solid black;" align="center">{{$quotationdetails->requestedquantity}}</td>
                    <td style="width: 10px; border:1px solid black;" align="center">{{$quotationdetails->gstrate}}</td>
                    <td style="width: 10px; border:1px solid black;" align="center">{{$quotationdetails->taxvalue}}</td>
                    @if($quotationdetails->finalquotationamount==null)
                        <td style="width: 10px; border:1px solid black;" align="center">{{$quotationdetails->quotationamount}}</td>
                    @else
                        <td style="width: 10px; border:1px solid black;" align="center">{{$quotationdetails->finalquotationamount}}</td>
                    @endif
                </tr>
                <tr>
                    <td style=" border:1px solid black;"></td>
                    <td colspan="5" style=" border:1px solid black;" align="center"><b>Total</b></td>
                    <td style=" border:1px solid black;" align="center">{{$quotationdetails->quotationamount}}</td>

                </tr>

            </table>
        </td>
    </tr>

    <tr>
        <td><b>In Words : {{$convertrupee}}.</b></td>
    </tr>
    <tr>
        <td style="padding-top: 15px"><b>Remark:</b></td>
    </tr>
    <tr>
        <td style="padding-left: 66px"><b>1)</b> Above mentioned part cover only 3 month warranty by service center.</td>
    </tr>
    <tr>
        <td style="padding-left: 66px"><b>2)</b> Any Physical damage or Worn out part will not be covered under Warranty/AMC.</td>
    </tr>

    <tr>
        <td style="padding-top: 20px;padding-left: 66px">Sir, We hope that you find our rates competitive and are waiting for your favourable response.</td>
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
{{ Form::open(array('url' => 'status/','files' => true,'id'=>'status')) }}
{{Form::hidden('quotationnumber',$quotationdetails->quotationnumber)}}
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

