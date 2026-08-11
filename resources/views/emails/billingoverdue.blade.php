<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2 style="color: #c0392b;">Payment Overdue Notice</h2>
    <p>Dear Team,</p>
    <p>The payment for the following billing cycle is overdue by <strong>{{ $daysoverdue }}</strong> day(s):</p>
    <table style="border-collapse: collapse; width: 100%;">
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Contract No</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $contractno }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Customer Name</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $customername }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Payment Cycle No</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $paymentcycleno }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Estimated Billing Date</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $estimateddate }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Bill Amount</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $billamount }}</td>
        </tr>
    </table>
    <p>Please arrange payment at the earliest to avoid further escalation.</p>
    <p>Regards,<br>Technowin IT Infra</p>
</body>
</html>