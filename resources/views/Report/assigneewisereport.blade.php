              <div  style="width:10px;">
                <table border="1" >
                    <tr  style="font-size: 16px;">
                        <th style="width: 15px">Ticket No</th>
                        <th style="width: 15px">Customer Name</th>
                        <th style="width: 15px">Customer Type</th>
                        <th style="width: 15px">Contact Person </th>
                        <th style="width: 15px">Mobile No</th>
                        <th style="width: 15px">Complaint Date</th>
                        <th style="width: 15px">Assignee Name</th>
                        <th style="width: 15px">Product Name</th>
                        <th style="width: 15px">Product Sr No</th>
                        <th style="width: 15px">Complaint Description </th>
                        <th style="width: 15px">Complaint Status</th>
                        <th style="width: 15px">Complaint Age</th>
                    </tr>
                    @foreach($compactData[0] as $mydata)
                        <tr style="font-size: 14px;">
                           <td style="width: 15px  ">{{ Form::label('', $mydata->ticketno) }}</td>
                            <td style="width: 15px  ">{{ Form::label('', $mydata->customername) }}</td>
                            <td style="width: 15px  ">{{ Form::label('', $mydata->customertype) }}</td>
                            <td style="width: 15px  ">{{ Form::label('', $mydata->contactpersonname) }}</td>
                            <td style="width: 15px   ">{{ Form::label('', $mydata->contactpersonphone) }}</td>
                            <td style="width: 15px  ">{{ Form::label('', $mydata->complaintdate)
                            }}</td>
                            <td style="width: 15px  ">{{ Form::label('', $mydata->assigneename) }}</td>
                            <td style="width: 15px  ">{{ Form::label('', $mydata->productservicename) }}</td>
                            <td style="width: 15px   ">{{ Form::label('', $mydata->productsrno_accountno) }}</td>
                            <td style="width: 15px  ">{{ Form::label('', $mydata->complaintdescription) }}</td>
                            <td style="width: 15px  ">{{ Form::label('', $mydata->complaintstatus) }}</td>
                            <td style="width: 15px  ">{{ Form::label('', $mydata->days) }}</td>
{{--                            <td width="25px;" style="  ">{{ Form::label('0',$mydata->earnestmoneydeposit, array('class' => 'form-control totalcost')) }}</td>--}}
                        </tr>
                    @endforeach
{{--                    <tr>--}}
{{--                        <td colspan="6" style="padding-left:610px;   "><b>Grand Total</b></td>--}}
{{--                        <td>{{ Form::label('',$total, array('id'=>'totalid','class' => 'form-control form-control-sm','readonly' => true)) }}</td>--}}
{{--                    </tr>--}}
                </table>
                </div>

