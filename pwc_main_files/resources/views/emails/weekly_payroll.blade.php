<!DOCTYPE html>
<html>
<head>
    <title>Weekly Payroll Details</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <h2 style="color: #00ADEE; text-align: center;">Weekly Payroll Details</h2>
        
        <p>Hello Accountant,</p>
        <p>Here are the payroll details for <strong>{{ $data['staff_name'] }}</strong> for Week <strong>{{ $data['week_number'] }}</strong> ({{ $data['date_range'] }}).</p>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; background: #f9f9f9;">Staff Member</td>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ $data['staff_name'] }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; background: #f9f9f9;">Week</td>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ $data['week_number'] }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; background: #f9f9f9;">Date Range</td>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ $data['date_range'] }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; background: #f9f9f9;">Gross Sales</td>
                <td style="padding: 10px; border: 1px solid #ddd;">${{ number_format($data['gross_sales'], 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; background: #f9f9f9;">Commission</td>
                <td style="padding: 10px; border: 1px solid #ddd;">${{ number_format($data['commission'], 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; background: #f9f9f9;">Bonus</td>
                <td style="padding: 10px; border: 1px solid #ddd;">${{ number_format($data['bonus'], 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; background: #e9ecef; color: #000;">Total Gross Pay</td>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; background: #e9ecef; color: #000;">${{ number_format($data['total_gross_pay'], 2) }}</td>
            </tr>
        </table>
        
        <p style="margin-top: 30px; font-size: 14px; text-align: center; color: #777;">
            Sent automatically from the Cleaning Portal
        </p>
    </div>
</body>
</html>
