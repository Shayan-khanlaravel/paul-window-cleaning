<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 30px; text-align: center;">
            @if(isset($logoUrl) && $logoUrl)
                <img src="{{ $logoUrl }}" alt="Logo" style="max-height: 50px; margin-bottom: 15px;">
            @endif
            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">Payment Successful!</h1>
            <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0;">Thank you for your payment</p>
        </div>

        <!-- Content -->
        <div style="padding: 30px;">
            <p style="font-size: 16px; color: #333;">Dear <strong>{{ $clientName ?? 'Valued Customer' }}</strong>,</p>
            
            <p style="font-size: 15px; color: #555; line-height: 1.6;">
                We have successfully received your payment. Thank you for choosing Pauls Window Cleaning!
            </p>

            <!-- Payment Details Box -->
            <div style="background: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; padding: 20px; margin: 20px 0;">
                <h3 style="color: #155724; margin: 0 0 15px 0; font-size: 18px;">Payment Receipt</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #666; width: 40%;">Amount Paid:</td>
                        <td style="padding: 8px 0; color: #155724; font-weight: bold; font-size: 20px;">${{ number_format($amount ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Payment Status:</td>
                        <td style="padding: 8px 0;"><span style="background: #28a745; color: #fff; padding: 4px 12px; border-radius: 4px; font-size: 12px; font-weight: bold;">PAID</span></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Service Date:</td>
                        <td style="padding: 8px 0; color: #333;">{{ $serviceDate ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>

            <!-- Service Details -->
            <div style="background: #f8f9fa; border-radius: 8px; padding: 20px; margin: 20px 0;">
                <h3 style="color: #333; margin: 0 0 15px 0; font-size: 16px;">Service Details</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 6px 0; color: #666;">Scope:</td>
                        <td style="padding: 6px 0; color: #333;">{{ $scheduleScope ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #666;">Note:</td>
                        <td style="padding: 6px 0; color: #333;">{{ $scheduleNote ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>

            <p style="font-size: 14px; color: #666; margin-top: 25px;">
                A PDF receipt is attached to this email for your records.
            </p>

            <p style="font-size: 15px; color: #555; margin-top: 20px;">
                If you have any questions, please don't hesitate to contact us.
            </p>

            <p style="font-size: 15px; color: #333; margin-top: 25px;">
                Best regards,<br>
                <strong>Pauls Window Cleaning Team</strong>
            </p>
        </div>

        <!-- Footer -->
        <div style="background: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #eee;">
            <p style="color: #888; font-size: 12px; margin: 0;">
                &copy; {{ date('Y') }} Pauls Window Cleaning. All rights reserved.
            </p>
            @if(isset($websiteUrl))
                <p style="margin: 10px 0 0 0;">
                    <a href="{{ $websiteUrl }}" style="color: #28a745; text-decoration: none; font-size: 12px;">Visit our website</a>
                </p>
            @endif
        </div>
    </div>
</body>
</html>

