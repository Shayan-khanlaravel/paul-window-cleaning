<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice Payment - Pauls Window Cleaning</title>
</head>

<body style="font-family: Arial, sans-serif; background: #f7f7f7; padding: 0; margin: 0; line-height: 1.6; color: #333;">
    <div
        style="max-width: 650px; margin: 40px auto; background: #fff; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); overflow: hidden;">

        <!-- Header -->
        <div style="background: #00ADEE; padding: 30px 20px; text-align: center;">
            <img src="{{ $logoUrl }}" alt="Pauls Window Cleaning" style="max-width: 120px; margin-bottom: 15px;">
            <h2 style="color: #fff; margin: 0; font-size: 24px;">Invoice Payment</h2>
        </div>

        <!-- Main Content -->
        <div style="padding: 30px;">
            <p style="margin-bottom: 20px; font-size: 16px;">Hello <strong>{{ $clientName }}</strong>,</p>
            <p style="margin-bottom: 20px;">Your invoice is ready! Please find the details below and make your payment
                securely using Stripe.</p> 
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $paymentUrl }}"
                    style="background: #00ADEE; color: #fff; padding: 15px 40px; border-radius: 6px; text-decoration: none; font-size: 18px; font-weight: bold; display: inline-block;">Pay
                    Now</a>
            </div>

            <p style="color: #666; font-size: 14px;">If you have any questions or issues, please feel free to reply to
                this email. Thank you!</p>
        </div>

        <!-- Footer -->
        <div style="background: #f1f1f1; text-align: center; padding: 20px; color: #888; font-size: 14px;">
            <p style="margin: 0 0 10px 0;">Pauls Window Cleaning &copy; {{ date('Y') }}</p>
            <p style="margin: 0;"><a href="{{ $websiteUrl }}" style="color: #00ADEE; text-decoration: none;">Visit
                    Website</a></p>
        </div>

    </div>
</body>

</html>
