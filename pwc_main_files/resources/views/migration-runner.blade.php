<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Migration Runner - PWC</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }

        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .result {
            margin-top: 25px;
            padding: 20px;
            border-radius: 8px;
            display: none;
        }

        .result.success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .result.error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .output {
            margin-top: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            max-height: 300px;
            overflow-y: auto;
            white-space: pre-wrap;
        }

        .warning {
            background: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .loader {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
            display: none;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🚀 Migration Runner</h1>
        <p class="subtitle">Paul Window Cleaning - Database Migration Tool</p>

        <div class="warning">
            ⚠️ <strong>Warning:</strong> This will run database migrations on the live server. Make sure you have a
            backup before proceeding.
        </div>

        <form id="migrationForm">
            <div class="form-group">
                <label for="password">Enter Migration Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter secure password" required>
            </div>
            <button type="submit" class="btn" id="runBtn">Run Migrations</button>
        </form>

        <div class="loader" id="loader"></div>
        <div class="result" id="result"></div>
    </div>

    <script>
        document.getElementById('migrationForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const password = document.getElementById('password').value;
            const btn = document.getElementById('runBtn');
            const loader = document.getElementById('loader');
            const result = document.getElementById('result');

            // Reset
            result.style.display = 'none';
            result.className = 'result';

            // Show loader
            btn.disabled = true;
            btn.textContent = 'Running...';
            loader.style.display = 'block';

            try {
                const response = await fetch(`/run-migrations/${password}`);
                const data = await response.json();

                // Hide loader
                loader.style.display = 'none';
                btn.disabled = false;
                btn.textContent = 'Run Migrations';

                // Show result
                result.style.display = 'block';

                if (data.success) {
                    result.className = 'result success';
                    result.innerHTML = `
                        <strong>✅ Success!</strong><br>
                        ${data.message}<br>
                        <small>Timestamp: ${data.timestamp}</small>
                        ${data.output ? `<div class="output">${data.output}</div>` : ''}
                    `;
                } else {
                    result.className = 'result error';
                    result.innerHTML = `
                        <strong>❌ Error!</strong><br>
                        ${data.message}<br>
                        ${data.error ? `<div class="output">${data.error}</div>` : ''}
                    `;
                }
            } catch (error) {
                loader.style.display = 'none';
                btn.disabled = false;
                btn.textContent = 'Run Migrations';

                result.style.display = 'block';
                result.className = 'result error';
                result.innerHTML = `
                    <strong>❌ Network Error!</strong><br>
                    ${error.message}
                `;
            }
        });
    </script>
</body>

</html>
