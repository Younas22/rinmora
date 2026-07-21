<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Re: {{ $contactMessage->subject }}</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f4f1ec; font-family: 'Helvetica Neue', Arial, sans-serif; color: #000; }
        .wrapper { max-width: 560px; margin: 0 auto; padding: 32px 16px; }
        .card { background: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .header { background-color: #000000; padding: 28px 32px; text-align: center; }
        .header span { color: #ffffff; font-size: 20px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; }
        .body { padding: 36px 32px; }
        .body h1 { font-size: 20px; margin: 0 0 16px; }
        .body p { font-size: 14px; line-height: 1.7; color: rgba(0,0,0,0.6); margin: 0 0 16px; }
        .reply-box { background-color: #f4f1ec; border-radius: 16px; padding: 20px 24px; font-size: 14px; line-height: 1.7; color: #000; margin: 0 0 24px; }
        .original { border-left: 3px solid rgba(0,0,0,0.1); padding-left: 16px; margin: 0 0 8px; font-size: 13px; line-height: 1.6; color: rgba(0,0,0,0.45); }
        .original-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: rgba(0,0,0,0.35); margin: 0 0 8px; }
        .footer { padding: 20px 32px 32px; text-align: center; font-size: 12px; color: rgba(0,0,0,0.4); }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="header"><span>Rinmora</span></div>
            <div class="body">
                <h1>Hi {{ $contactMessage->name }},</h1>
                <p>Thanks for reaching out about "{{ $contactMessage->subject }}". Here's our reply:</p>

                <div class="reply-box">{!! nl2br(e($contactMessage->reply_body)) !!}</div>

                <p class="original-label">Your original message</p>
                <p class="original">{!! nl2br(e($contactMessage->message)) !!}</p>

                <p>If you have any more questions, just reply to this email and we'll be happy to help.</p>
            </div>
        </div>
        <p class="footer">&copy; {{ date('Y') }} Rinmora. All rights reserved.</p>
    </div>
</body>
</html>
