<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__("Site Under Maintenance")}} - {{ setting('site_name', 'Uni Party') }}</title>
    <meta name="description" content="{{__('The site is currently under maintenance. Please check back later.')}}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Arial', sans-serif;
            margin: 0;
        }
        
        .maintenance-container {
            text-align: center;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 3rem 2rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            max-width: 500px;
            width: 90%;
        }
        
        .maintenance-icon {
            font-size: 4rem;
            color: #667eea;
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .maintenance-title {
            color: #333;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        
        .maintenance-message {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .admin-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            display: inline-block;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .admin-link:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .contact-info {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eee;
            color: #777;
            font-size: 0.9rem;
        }
        
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 1rem auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">
            <i class="fas fa-tools"></i>
        </div>
        
        <h1 class="maintenance-title">
            {{__("We'll be back soon!")}}
        </h1>
        
        <p class="maintenance-message">
            {{__("We're currently performing scheduled maintenance to improve your experience. The site will be back online shortly.")}}
        </p>
        
        <div class="spinner"></div>
        
        <p class="maintenance-message">
            {{__("Thank you for your patience!")}}
        </p>
        
        <!-- Admin access link -->
        <div class="admin-access mt-4">
            <a href="{{ url('/admin/login') }}" class="admin-link">
                <i class="fas fa-user-shield me-2"></i>
                {{__("Admin Login")}}
            </a>
        </div>
        
        <!-- Contact information -->
        <div class="contact-info">
            <p class="mb-1">
                <strong>{{__("Need help?")}}</strong>
            </p>
            <p class="mb-0">
                {{__("Contact us at")}} 
                <a href="mailto:{{ setting('admin_email', 'admin@uniparty.com') }}" style="color: #667eea;">
                    {{ setting('admin_email', 'admin@uniparty.com') }}
                </a>
            </p>
        </div>
    </div>
</body>
</html> 