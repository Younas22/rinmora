<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f4f1ec; font-family: 'Helvetica Neue', Arial, sans-serif; color: #000; }
        .wrapper { max-width: 560px; margin: 0 auto; padding: 32px 16px; }
        .card { background: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .header { background-color: #000000; padding: 28px 32px; text-align: center; }
        .header span { color: #ffffff; font-size: 20px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; }
        .body { padding: 36px 32px; }
        .body h1 { font-size: 22px; margin: 0 0 16px; }
        .body p { font-size: 14px; line-height: 1.7; color: rgba(0,0,0,0.6); margin: 0 0 16px; }
        .meta { font-size: 13px; color: rgba(0,0,0,0.45); margin: 0 0 4px; }
        .message-box { background: #f4f1ec; border-radius: 16px; padding: 20px; font-size: 14px; line-height: 1.7; color: #000; white-space: pre-wrap; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="header"><span>Rinmora Admin</span></div>
            <div class="body">
                <h1>New Contact Message</h1>
                <p class="meta"><strong>From:</strong> {{ $contactMessage->name }} ({{ $contactMessage->email }})</p>
                <p class="meta"><strong>Subject:</strong> {{ $contactMessage->subject }}</p>
                <div class="message-box">{{ $contactMessage->message }}</div>
            </div>
        </div>
    </div>
</body>
</html>
