{{--@extends('layouts.appnew')--}}




                <table border="1" width="40%px">
                    <tr>
                        <th style="width: 15px;">Tender No</th>
                        <th style="width:75px;">Emd Status</th>
                        <th style="width:75px;">Tender Date</th>
                        <th>Organisation Name</th>
                        <th>Department</th>
                        <th>Subject</th>
                        <th width="25px;">EMD</th>
                    </tr>
                    @foreach($data as $mydata)
                        <tr>
                           <td style="width: 25px;font-size: 12px;">{{ Form::label('', $mydata->tenderno) }}</td>
                            {{--<td>{{ Form::text('test', $mydata->tenderno) }}</td>--}}
                            <td style="width:75px; text-align: center;font-size: 12px;">{{ Form::label('', $mydata->emdstatus) }}</td>
                            <td style="width: 75px;font-size: 12px;">{{ Form::label('', $mydata->tenderdate) }}</td>
                            <td style="font-size: 12px;">{{ Form::label('', $mydata->organisationname) }}</td>
                            <td style="font-size: 12px;">{{ Form::label('', $mydata->department) }}</td>
                            <td style="font-size: 12px;">{{ Form::label('', $mydata->subject) }}</td>
                            <td width="25px;" style="font-size: 12px;">{{ Form::label('0',$mydata->earnestmoneydeposit, array('class' => 'form-control totalcost')) }}</td>

                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="6" style="padding-left:610px; font-size: 12px;"><b>Grand Total</b></td>
                        <td>{{ Form::label('',$total, array('id'=>'totalid','class' => 'form-control form-control-sm','readonly' => true)) }}</td>
                    </tr>
                </table>

