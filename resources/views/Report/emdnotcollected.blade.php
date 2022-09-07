

<table border="1" width="40px">
    <thead>
    <tr class="text-muted">
{{--        <th>#</th>--}}
        <th style='width:120px;'><b>Ticket No</b></th>
        <th style='width:120px;'><b>Customer Name</b></th>
        <th style='width:150px;'><b>Complaint Date</b></th>
        <th style='width:120px;'><b>Equipment Date</b></th>
        <th style='width:150px;'><b>Equipment No</b></th>
        <th style='width:120px;'><b>Description</b></th>
        <th style=''><b>Status</b></th>
        <th style=''><b>Assignee Name</b></th>

        <th style=''><b>Assignee Date</b></th>
        <th style=''><b>Resolved Date</b></th>
        <th style=''><b>Closed Date</b></th>
    </tr>
    </thead>
    <tbody>

        @foreach($idata as $idatas)
            <tr>
{{--        <td>{{ Form::label($idata->ticketno) }}</td>--}}
        <td>{{ $idatas->ticketno }}</td>
        <td>{{ $idatas->customername }}</td>
        <td>{{ $idatas->complaintdate }}</td>
        <td>{{ $idatas->productservicename }}</td>
        <td>{{ $idatas->productsrno_accountno }}</td>
        <td>{{ $idatas->complaintdescription }}</td>

        <td>{{ $idatas->complaintstatus }}</td>
        <td>{{ $idatas->assigneename }}</td>
        <td>{{ $idatas->assigneestartdate }}</td>
        <td>{{ $idatas->callenddate }}</td>
        <td>{{ $idatas->callclosuredate }}</td>
            </tr>
        @endforeach


{{--        <td style="width: 25px;font-size: 12px;">sub 1</td>--}}
{{--<!--        <td style="width: 25px;font-size: 12px;"></td>-->--}}
<!--        {{--<td>{{ Form::text('test', $mydata->tenderno) }}</td>--}}-->
{{--<!--        <td style="width:75px; text-align: center;font-size: 12px;">{{ Form::label('', $mydata->emdstatus) }}</td>-->--}}
{{--<!--        <td style="width: 75px;font-size: 12px;">{{ Form::label('', $mydata->tenderdate) }}</td>-->--}}
{{--<!--        <td style="font-size: 12px;">{{ Form::label('', $mydata->organisationname) }}</td>-->--}}
{{--<!--        <td style="font-size: 12px;">{{ Form::label('', $mydata->department) }}</td>-->--}}
{{--<!--        <td style="font-size: 12px;">{{ Form::label('', $mydata->subject) }}</td>-->--}}
{{--<!--        <td width="25px;" style="font-size: 12px;">{{ Form::label('0',$mydata->earnestmoneydeposit, array('class' => 'form-control totalcost')) }}</td>-->--}}


    </tbody>
{{--<!--    @endforeach-->--}}
<!--    <tr>-->
<!--        <td colspan="6" style="padding-left:610px; font-size: 12px;"><b>Grand Total</b></td>-->
{{--<!--        <td>{{ Form::label('',$total, array('id'=>'totalid','class' => 'form-control form-control-sm','readonly' => true)) }}</td>-->--}}
<!--    </tr>-->
</table>

