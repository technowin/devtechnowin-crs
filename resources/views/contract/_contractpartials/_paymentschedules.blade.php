<div class="col-md-12 form-group table-responsive">
    <br/>
    <table class="table table-sm table-hover" width="100%">
        <tr class="text-muted">
            <td>Payment Cycle</td>
            <td>Cycle Start Date</td>
            <td>Cycle End Date</td>
            <td>Cycle Due Date</td>
            <td>Due Amount</td>
            <td>Invoice Due Date</td>
        </tr>
        @foreach($data as $items)
            <tr>
                <td>{{ $items->paymentcycleno }}</td>
                <td>{{ is_null($items->paymentcyclestartdate) ? '' : \Carbon\Carbon::parse($items->paymentcyclestartdate)->format('d-m-Y') }}</td>
                <td>{{ is_null($items->paymentcycleenddate) ? '' : \Carbon\Carbon::parse($items->paymentcycleenddate)->format('d-m-Y') }}</td>
                <td>{{ is_null($items->paymentduedate) ? '' : \Carbon\Carbon::parse($items->paymentduedate)->format('d-m-Y') }}</td>
                <td>{{ $items->paymentdueamount }}</td>
                <td>{{ is_null($items->invoicegenerationduedate) ? '' : \Carbon\Carbon::parse($items->invoicegenerationduedate)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </table>
</div>