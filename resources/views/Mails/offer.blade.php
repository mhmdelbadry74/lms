<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $offer->name }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #4a6baf; padding: 20px; text-align: center; }
        .header img { max-width: 200px; }
        .content { padding: 20px; background: #f9f9f9; }
        .offer-box { background: #fff; border: 2px dashed #4a6baf; padding: 15px; text-align: center; margin: 20px 0; }
        .code { font-size: 24px; font-weight: bold; color: #e63946; }
        .button { background-color: #e63946; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block; }
        .footer { text-align: center; font-size: 12px; color: #777; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="{{ $companyName }} Logo">
    </div>
    <div class="content">
        <h1>Hi {{ $client->name }},</h1>
        <p>As a valued customer, we're excited to offer you <strong>{{ $offer->discount }}% OFF</strong> on {{ $offer->name }}!</p>
        
        <div class="offer-box">
            <p>Use code:</p>
            <div class="code">{{ $offer->promo_code }}</div>
            <p>at checkout. Valid until {{ $expireDate }}.</p>
        </div>

        <p style="text-align: center;">
            <a href="" class="button">Redeem Offer</a>
        </p>

        <p>Hurry, this exclusive offer won't last long!</p>
        <p>Best regards,<br>The {{ $companyName }} Team</p>
    </div>
    <div class="footer">
        © {{ now()->year }} {{ $companyName }}. All rights reserved.<br>
        <a href="">Unsubscribe</a> | 
        <a href="">Privacy Policy</a>
    </div>
</body>
</html>