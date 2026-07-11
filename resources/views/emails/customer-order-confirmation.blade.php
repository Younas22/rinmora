<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed — Rinmora</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f4f1ec; font-family: 'Helvetica Neue', Arial, sans-serif; color: #000; }
        .wrapper { max-width: 560px; margin: 0 auto; padding: 32px 16px; }
        .card { background: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .header { background-color: #000000; padding: 28px 32px; text-align: center; }
        .header span { color: #ffffff; font-size: 20px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; }
        .body { padding: 36px 32px; }
        .body h1 { font-size: 22px; margin: 0 0 16px; }
        .body p { font-size: 14px; line-height: 1.7; color: rgba(0,0,0,0.6); margin: 0 0 16px; }
        table.items { width: 100%; border-collapse: collapse; margin: 16px 0; }
        table.items td { padding: 8px 0; font-size: 13px; border-bottom: 1px solid rgba(0,0,0,0.06); }
        table.totals td { padding: 4px 0; font-size: 13px; }
        .bank-box { background: #f4f1ec; border-radius: 16px; padding: 20px; margin: 16px 0; }
        .bank-box p { margin: 0 0 6px; font-size: 13px; }
        .footer { padding: 20px 32px 32px; text-align: center; font-size: 12px; color: rgba(0,0,0,0.4); }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="header"><span>Rinmora</span></div>
            <div class="body">
                <h1>Thank You, {{ $order->customer_name }}!</h1>
                <p>Your order <strong>{{ $order->order_number }}</strong> has been placed successfully. Here's a summary:</p>

                <table class="items">
                    @foreach ($order->items as $item)
                        <tr>
                            <td>
                                {{ $item->product_name }}
                                @if ($item->variant_label)
                                    <br><span style="color: rgba(0,0,0,0.45);">{{ $item->variant_label }}</span>
                                @endif
                            </td>
                            <td style="text-align: center;">x{{ $item->quantity }}</td>
                            <td style="text-align: right;">{{ format_price($item->line_total) }}</td>
                        </tr>
                    @endforeach
                </table>

                <table class="totals">
                    <tr><td>Subtotal</td><td style="text-align: right;">{{ format_price($order->subtotal) }}</td></tr>
                    <tr><td>Shipping</td><td style="text-align: right;">{{ format_price($order->shipping_amount) }}</td></tr>
                    <tr><td><strong>Total</strong></td><td style="text-align: right;"><strong>{{ format_price($order->total) }}</strong></td></tr>
                </table>

                <p><strong>Shipping to:</strong><br>
                    {{ $order->shipping_name }}<br>
                    {{ $order->shipping_address_line1 }}@if($order->shipping_address_line2), {{ $order->shipping_address_line2 }}@endif<br>
                    {{ $order->shipping_city }}@if($order->shipping_state), {{ $order->shipping_state }}@endif @if($order->shipping_zip) {{ $order->shipping_zip }}@endif<br>
                    {{ $order->shipping_country }}
                </p>

                @if ($isBankTransfer && $bankAccounts->isNotEmpty())
                    <p><strong>Please transfer the total amount to one of the accounts below, then upload your payment screenshot from the order confirmation page.</strong></p>
                    @foreach ($bankAccounts as $account)
                        <div class="bank-box">
                            <p><strong>{{ $account->bank_name }}</strong></p>
                            <p>Account Title: {{ $account->account_title }}</p>
                            <p>Account Number: {{ $account->account_number }}</p>
                            @if ($account->iban)
                                <p>IBAN: {{ $account->iban }}</p>
                            @endif
                        </div>
                    @endforeach
                @elseif (!$isBankTransfer)
                    <p>Payment method: <strong>Cash on Delivery</strong>. Please have the exact amount ready at delivery.</p>
                @endif

                <p>We'll notify you as your order progresses. Thank you for shopping with Rinmora.</p>
            </div>
        </div>
        <p class="footer">&copy; {{ date('Y') }} Rinmora. All rights reserved.</p>
    </div>
</body>
</html>
