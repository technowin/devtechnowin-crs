<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Billing Payment Reminder</h2>
    <p>Dear Team,</p>
    <p>This is a reminder regarding the following billing cycle:</p>
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
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Billing Due Date</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $billingduedate }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><strong>Bill Amount</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $billamount }}</td>
        </tr>
    </table>
    <p>Please ensure the payment is processed on time.</p>
    <p>Regards,<br>Technowin IT Infra</p>
</body>
</html>