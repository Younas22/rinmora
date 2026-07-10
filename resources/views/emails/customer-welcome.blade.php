<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Rinmora</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f4f1ec; font-family: 'Helvetica Neue', Arial, sans-serif; color: #000; }
        .wrapper { max-width: 560px; margin: 0 auto; padding: 32px 16px; }
        .card { background: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .header { background-color: #000000; padding: 28px 32px; text-align: center; }
        .header span { color: #ffffff; font-size: 20px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; }
        .body { padding: 36px 32px; }
        .body h1 { font-size: 22px; margin: 0 0 16px; }
        .body p { font-size: 14px; line-height: 1.7; color: rgba(0,0,0,0.6); margin: 0 0 16px; }
        .btn { display: inline-block; background-color: #CFBAA5; color: #000000 !important; text-decoration: none; font-weight: 600; font-size: 13px; letter-spacing: 0.05em; text-transform: uppercase; padding: 14px 32px; border-radius: 999px; margin: 8px 0 24px; }
        .footer { padding: 20px 32px 32px; text-align: center; font-size: 12px; color: rgba(0,0,0,0.4); }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="header"><span>Rinmora</span></div>
            <div class="body">
                <h1>Welcome, {{ $name }}!</h1>
                <p>Thank you for creating a Rinmora account. You're all set to track orders, save your favorite pieces, and enjoy a faster checkout every time.</p>
                <p style="text-align: center;">
                    <a href="{{ $shopUrl }}" class="btn">Start Shopping</a>
                </p>
                <p>Elegance you can carry, every day.</p>
            </div>
        </div>
        <p class="footer">&copy; {{ date('Y') }} Rinmora. All rights reserved.</p>
    </div>
</body>
</html>
