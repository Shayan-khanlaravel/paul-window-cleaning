<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Paul (Cleaning Window)!</title>
</head>
<body>
<div style="background-color: #f7f7f7; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #444; max-width: 600px; margin: 20px auto; border: 1px solid #d4d4d4; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="https://cleaning.thebackendprojects.com/AdminDashboard/lnCB2sSJFsC1q8BNB2QJi7ybMhxiIi06oprihnrP.png" alt="Logo" style="max-width: 100px;">
    </div>
    <h2 style="text-align: center; color: #333; margin-bottom: 20px;">New Account Created! Paul (Cleaning Window)!</h2>
    <p style="text-align: center; margin-bottom: 10px;">We are thrilled to have you join Paul (Cleaning Window) | www.cleaning.thebackendprojects.com</p>
    <hr style="margin: 20px 0;">
    <h1>Welcome, {{ $data['name'] }}!</h1>

    <p>We are thrilled to have you join Paul (Cleaning Window)!</p>

    <p>To get started, visit your dashboard using the link below:</p>

    <p>Your Login Credential Here,</p>

    <p>Email:{{$data['email']}}</p>

    <p>Password:{{$data['password']}}</p>

    <a href="{{ $data['url'] }}" style="color: #0066cc; text-decoration: none;">Visit Now</a>

    <p>If you encounter any issues or have any questions, feel free to contact us at any time.</p>

    <p>Thank you for choosing Paul (Cleaning Window)!</p>

    <hr style="margin: 20px 0;">
    <p>Regards,</p>
    <p>Paul (Cleaning Window) Team</p>
    <div style="background-color: #333; color: #fff; text-align: center; padding: 10px; border-radius: 0 0 8px 8px; font-size: 12px;">
        <p>Copyright &copy; 2024 Paul (Cleaning Window), All rights reserved.</p>
        <!-- <p>Our mailing address is:</p>
        <p>8900 six pines dr, Shenandoah, US, 77380</p> -->
    </div>
</div>
</body>
</html>
