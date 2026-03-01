<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operation Successful</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }
        .success-container {
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .success-card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 28rem;
            padding: 2rem;
            text-align: center;
        }
        .success-icon {
            margin: 0 auto 1rem;
            width: 4rem;
            height: 4rem;
            border-radius: 9999px;
            background-color: #dcfce7;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .success-icon i {
            color: #16a34a;
            font-size: 1.75rem;
        }
        .success-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        .success-message {
            color: #64748b;
            margin-bottom: 1.5rem;
        }
        .success-details {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 1rem;
            margin-bottom: 1.5rem;
            text-align: left;
            color: #1e40af;
        }
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            margin: 0.25rem;
        }
        .btn-back {
            background-color: #f1f5f9;
            color: #334155;
        }
        .btn-back:hover {
            background-color: #e2e8f0;
        }
        .btn-dashboard {
            background-color: #2563eb;
            color: white;
        }
        .btn-dashboard:hover {
            background-color: #1d4ed8;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-card">
            <!-- Success Icon -->
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            
            <!-- Success Message -->
            <h2 class="success-title">Success!</h2>
            <p class="success-message" id="success-message">
                Operation completed successfully.
            </p>
            
            <!-- Additional Details (optional) -->
            <div class="success-details" id="success-details" style="display: none;"></div>
            
            <!-- Action Buttons -->
            <div>
                <a href="javascript:history.back()" class="btn btn-back">
                    <i class="fas fa-arrow-left mr-2"></i> Go Back
                </a>
                <a href="/dashboard" class="btn btn-dashboard">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
            </div>
        </div>
    </div>

    <script>
        // Parse URL parameters for AJAX responses
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('message');
            const details = urlParams.get('details');
            
            if (message) {
                document.getElementById('success-message').textContent = message;
            }
            
            if (details) {
                const detailsEl = document.getElementById('success-details');
                detailsEl.style.display = 'block';
                detailsEl.textContent = details;
            }
        });
    </script>
</body>
</html>