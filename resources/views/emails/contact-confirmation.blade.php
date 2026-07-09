<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Received - Younas Dev</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }
        
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #000000 0%, #333333 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        
        .message-box {
            background-color: #f8f9fa;
            border-left: 4px solid #000000;
            padding: 20px;
            margin: 25px 0;
            border-radius: 5px;
        }
        
        .message-box h3 {
            color: #000;
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .details {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .details h4 {
            color: #000;
            margin-bottom: 15px;
            font-size: 16px;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 10px;
            padding: 5px 0;
        }
        
        .detail-label {
            font-weight: bold;
            color: #000;
            width: 100px;
            flex-shrink: 0;
        }
        
        .detail-value {
            color: #555;
            flex: 1;
        }
        
        .footer {
            background-color: #000000;
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .footer h3 {
            margin-bottom: 15px;
            font-size: 20px;
        }
        
        .footer p {
            margin-bottom: 10px;
            opacity: 0.9;
        }
        
        .contact-info {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #333;
        }
        
        .btn {
            display: inline-block;
            background-color: #000000;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin: 15px 0;
            font-weight: bold;
        }
        
        .btn:hover {
            background-color: #333333;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 0;
            }
            
            .header, .content, .footer {
                padding: 20px;
            }
            
            .detail-row {
                flex-direction: column;
            }
            
            .detail-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Younas Dev</h1>
            <p>Laravel & Web Development Expert</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Hello {{ $contact->name }},
            </div>
            
            <div class="message-box">
                <h3>✅ Message Received Successfully!</h3>
                <p>Thank you for reaching out to me. I have received your message and will review it carefully. I will get back to you within 24 hours with a detailed response.</p>
            </div>
            
            <div class="details">
                <h4>📋 Your Message Details</h4>
                <div class="detail-row">
                    <div class="detail-label">Name:</div>
                    <div class="detail-value">{{ $contact->name }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Email:</div>
                    <div class="detail-value">{{ $contact->email }}</div>
                </div>
                @if($contact->service)
                <div class="detail-row">
                    <div class="detail-label">Service:</div>
                    <div class="detail-value">{{ $contact->service }}</div>
                </div>
                @endif
                <div class="detail-row">
                    <div class="detail-label">Subject:</div>
                    <div class="detail-value">{{ $contact->subject }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Date:</div>
                    <div class="detail-value">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</div>
                </div>
            </div>
            
            <p>In the meantime, feel free to check out my portfolio and recent projects. If you have any urgent questions, don't hesitate to reach out directly.</p>
            
            <p style="margin-top: 20px;">
                <strong>What happens next?</strong><br>
                • I'll review your project requirements<br>
                • Prepare a detailed proposal or quote<br>
                • Schedule a call if needed<br>
                • Provide you with next steps
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <h3>Younas Dev</h3>
            <p>Laravel Expert | Web Developer | API Specialist</p>
            
            <div class="contact-info">
                <p><strong>📧 Email:</strong> hello@younasdev.com</p>
                <p><strong>🌐 Website:</strong> www.younasdev.com</p>
                <p><strong>💼 LinkedIn:</strong> linkedin.com/in/younasdev</p>
            </div>
            
            <p style="margin-top: 20px; font-size: 12px; opacity: 0.7;">
                This is an automated confirmation email. Please do not reply to this email.<br>
                For direct communication, use the contact details above.
            </p>
        </div>
    </div>
</body>
</html>