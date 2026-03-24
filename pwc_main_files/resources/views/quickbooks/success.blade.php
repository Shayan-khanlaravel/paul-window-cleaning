<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickBooks Connected - PWC</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 700px;
            width: 100%;
            text-align: center;
        }
        .success-icon {
            font-size: 80px;
            color: #2ecc71;
            margin-bottom: 20px;
        }
        h1 {
            color: #2ecc71;
            margin-bottom: 10px;
            font-size: 32px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 16px;
        }
        .credentials {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin: 25px 0;
            text-align: left;
        }
        .credential-item {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }
        .credential-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        .credential-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .credential-value {
            background: white;
            padding: 12px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #2c3e50;
            word-break: break-all;
            border: 1px solid #e0e0e0;
        }
        .instructions {
            background: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            text-align: left;
            font-size: 14px;
            line-height: 1.6;
        }
        .instructions strong {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .instructions ol {
            margin-left: 20px;
        }
        .instructions li {
            margin-bottom: 8px;
        }
        .btn {
            display: inline-block;
            padding: 14px 30px;
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            margin-top: 20px;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .copy-btn {
            background: #3498db;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 11px;
            margin-left: 10px;
            transition: background 0.2s;
        }
        .copy-btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">✅</div>
        <h1>QuickBooks Connected Successfully!</h1>
        <p class="subtitle">Your QuickBooks account is now connected to Paul Window Cleaning</p>

        <div class="instructions">
            <strong>⚠️ Important: Copy these credentials to your .env file</strong>
            <ol>
                <li>Open your <code>.env</code> file in the project root</li>
                <li>Add or update the following values:</li>
                <li>Save the file and clear cache: <code>php artisan config:clear</code></li>
                <li>Keep these credentials secure and never share them</li>
            </ol>
        </div>

        <div class="credentials">
            <div class="credential-item">
                <div class="credential-label">
                    QUICKBOOKS_COMPANY_ID (Realm ID)
                    <button class="copy-btn" onclick="copyToClipboard('{{ $companyId }}')">Copy</button>
                </div>
                <div class="credential-value">{{ $companyId }}</div>
            </div>

            <div class="credential-item">
                <div class="credential-label">
                    QUICKBOOKS_ACCESS_TOKEN
                    <button class="copy-btn" onclick="copyToClipboard('{{ $accessToken }}')">Copy</button>
                </div>
                <div class="credential-value">{{ $accessToken }}</div>
            </div>

            <div class="credential-item">
                <div class="credential-label">
                    QUICKBOOKS_REFRESH_TOKEN
                    <button class="copy-btn" onclick="copyToClipboard('{{ $refreshToken }}')">Copy</button>
                </div>
                <div class="credential-value">{{ $refreshToken }}</div>
            </div>
        </div>

        <a href="/dashboard_index" class="btn">Go to Dashboard</a>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Copied to clipboard!');
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
</body>
</html>

