<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order Has Arrived — Rinmora</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f4f1ec; font-family: 'Helvetica Neue', Arial, sans-serif; color: #000; }
        .wrapper { max-width: 560px; margin: 0 auto; padding: 32px 16px; }
        .card { background: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .header { background-color: #000000; padding: 28px 32px; text-align: center; }
        .header span { color: #ffffff; font-size: 20px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; }
        .body { padding: 36px 32px; }
        .body h1 { font-size: 22px; margin: 0 0 16px; }
        .body p { font-size: 14px; line-height: 1.7; color: rgba(0,0,0,0.6); margin: 0 0 16px; }
        table.items { width: 100%; border-collapse: collapse; margin: 16px 0 24px; }
        table.items td { padding: 10px 0; font-size: 13px; border-bottom: 1px solid rgba(0,0,0,0.06); vertical-align: middle; }
        .review-btn { display: inline-block; background-color: #000000; color: #ffffff !important; text-decoration: none; font-weight: 600; font-size: 11px; letter-spacing: 0.03em; text-transform: uppercase; padding: 8px 16px; border-radius: 999px; }
        .footer { padding: 20px 32px 32px; text-align: center; font-size: 12px; color: rgba(0,0,0,0.4); }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="header"><span>Rinmora</span></div>
            <div class="body">
                <h1>Thank you, {{ $order->customer_name }}!</h1>
                <p>Your order <strong>{{ $order->order_number }}</strong> has been delivered. We hope you love it as much as we loved putting it together for you.</p>

                <table class="items">
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                {{ $item['name'] }}
                                @if ($item['variant_label'])
                                    <br><span style="color: rgba(0,0,0,0.45);">{{ $item['variant_label'] }}</span>
                                @endif
                                <br><span style="color: rgba(0,0,0,0.45);">Qty {{ $item['quantity'] }}</span>
                            </td>
                            <td style="text-align: right; width: 140px;">
                                @if ($item['review_url'])
                                    <a href="{{ $item['review_url'] }}" class="review-btn">Leave a Review</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>

                <p>Your feedback means a lot to us and helps other customers shop with confidence. Thank you again for choosing Rinmora.</p>
            </div>
        </div>
        <p class="footer">&copy; {{ date('Y') }} Rinmora. All rights reserved.</p>
    </div>
</body>
</html>
