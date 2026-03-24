<!DOCTYPE html>
<html>
<head>
    <title>Request Quote | Paul (Cleaning Window)</title>
</head>
<body>
<div style="background-color: #f7f7f7; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #444; max-width: 600px; margin: 20px auto; border: 1px solid #d4d4d4; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="https://cleaning.thebackendprojects.com/AdminDashboard/lnCB2sSJFsC1q8BNB2QJi7ybMhxiIi06oprihnrP.png" alt="Logo" style="max-width: 100px;">
    </div>
    <h2 style="text-align: center; color: #333; margin-bottom: 20px;">New Quote Request!</h2>
    <p style="text-align: center; margin-bottom: 10px;">A new quote request has been submitted on Paul (Cleaning Window) | www.cleaning.thebackendprojects.com</p>
    <hr style="margin: 20px 0;">
    <h3 style="color: #333;">User Details</h3>
    <p><strong>Name:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Phone:</strong> {{ preg_replace('/(\d{3})(\d{3})(\d{5})/', '$1-$2-$3', $data['phone']) }}</p>
    <p><strong>Subject:</strong> {{ $data['subject'] }}</p>
    <hr style="margin: 20px 0;">
    <p>For more information, click the link below to visit the site:</p>
    <p>
        <a href="{{ $data['url'] }}" style="color: #0066cc; text-decoration: none; font-weight: bold;">Visit Now</a>
    </p>
    <p>If you have any questions, feel free to reach out to the user at their provided email or phone number.</p>
    <hr style="margin: 20px 0;">
    <p>Regards,</p>
    <p>Paul (Cleaning Window) Team</p>
    <div style="background-color: #333; color: #fff; text-align: center; padding: 10px; border-radius: 0 0 8px 8px; font-size: 12px;">
        <p>Copyright &copy; 2024 Paul (Cleaning Window), All rights reserved.</p>
    </div>
</div>
</body>
</html>
