<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order Has Shipped — Rinmora</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f4f1ec; font-family: 'Helvetica Neue', Arial, sans-serif; color: #000; }
        .wrapper { max-width: 560px; margin: 0 auto; padding: 32px 16px; }
        .card { background: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .header { background-color: #000000; padding: 28px 32px; text-align: center; }
        .header span { color: #ffffff; font-size: 20px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; }
        .body { padding: 36px 32px; }
        .body h1 { font-size: 22px; margin: 0 0 16px; }
        .body p { font-size: 14px; line-height: 1.7; color: rgba(0,0,0,0.6); margin: 0 0 16px; }
        .tracking-box { background: #f4f1ec; border-radius: 16px; padding: 20px 24px; margin: 16px 0 24px; }
        .tracking-box p { margin: 0 0 6px; font-size: 13px; color: #000; }
        .btn { display: inline-block; background-color: #CFBAA5; color: #000000 !important; text-decoration: none; font-weight: 600; font-size: 13px; letter-spacing: 0.05em; text-transform: uppercase; padding: 14px 32px; border-radius: 999px; margin: 8px 0 24px; }
        .footer { padding: 20px 32px 32px; text-align: center; font-size: 12px; color: rgba(0,0,0,0.4); }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="header"><span>Rinmora</span></div>
            <div class="body">
                <h1>Your order is on its way, {{ $order->customer_name }}!</h1>
                <p>Great news — order <strong>{{ $order->order_number }}</strong> has shipped and is headed your way.</p>

                @if ($carrier || $trackingNumber)
                    <div class="tracking-box">
                        @if ($carrier)
                            <p><strong>Carrier:</strong> {{ $carrier }}</p>
                        @endif
                        @if ($trackingNumber)
                            <p><strong>Tracking Number:</strong> {{ $trackingNumber }}</p>
                        @endif
                    </div>
                @endif

                <p><strong>Shipping to:</strong><br>
                    {{ $order->shipping_name }}<br>
                    {{ $order->shipping_address_line1 }}@if($order->shipping_address_line2), {{ $order->shipping_address_line2 }}@endif<br>
                    {{ $order->shipping_city }}@if($order->shipping_state), {{ $order->shipping_state }}@endif @if($order->shipping_zip) {{ $order->shipping_zip }}@endif<br>
                    {{ $order->shipping_country }}
                </p>

                <p style="text-align: center;">
                    <a href="{{ $orderUrl }}" class="btn">Track Your Order</a>
                </p>

                <p>Thank you for shopping with Rinmora.</p>
            </div>
        </div>
        <p class="footer">&copy; {{ date('Y') }} Rinmora. All rights reserved.</p>
    </div>
</body>
</html>
