<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message - Younas Dev</title>
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
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .alert {
            background-color: #ff4444;
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
        }
        
        .content {
            padding: 30px;
        }
        
        .client-info {
            background-color: #f8f9fa;
            border: 2px solid #000000;
            border-radius: 8px;
            padding: 25px;
            margin: 20px 0;
        }
        
        .client-info h3 {
            color: #000;
            margin-bottom: 20px;
            font-size: 18px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 12px;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: bold;
            color: #000;
            width: 120px;
            flex-shrink: 0;
        }
        
        .info-value {
            color: #555;
            flex: 1;
        }
        
        .message-content {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .message-content h4 {
            color: #000;
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .message-text {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #000;
            white-space: pre-wrap;
            font-family: Georgia, serif;
            line-height: 1.7;
        }
        
        .actions {
            background-color: #000000;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        
        .actions h4 {
            margin-bottom: 15px;
        }
        
        .btn {
            display: inline-block;
            background-color: white;
            color: #000;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
            font-weight: bold;
            border: 2px solid #000;
        }
        
        .btn:hover {
            background-color: #f0f0f0;
        }
        
        .priority {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 10px;
        }
        
        .priority.high {
            background-color: #ff4444;
            color: white;
        }
        
        .priority.medium {
            background-color: #ffaa00;
            color: white;
        }
        
        .priority.low {
            background-color: #00aa00;
            color: white;
        }
        
        .footer {
            background-color: #000000;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            opacity: 0.8;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 0;
            }
            
            .header, .content {
                padding: 20px;
            }
            
            .info-row {
                flex-direction: column;
            }
            
            .info-label {
                width: 100%;
                margin-bottom: 5px;
            }
            
            .btn {
                display: block;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🚨 New Contact Message</h1>
            <p>A new client has reached out to you</p>
        </div>
        
        <!-- Alert -->
        <div class="alert">
            ⚡ IMMEDIATE ATTENTION REQUIRED
        </div>
        
        <!-- Content -->
        <div class="content">
            <p><strong>Hello Younas,</strong></p>
            <p>You have received a new contact message through your website. Here are the details:</p>
            
            <!-- Client Information -->
            <div class="client-info">
                <h3>👤 Client Information</h3>
                <div class="info-row">
                    <div class="info-label">Name:</div>
                    <div class="info-value"><strong>{{ $contact->name }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">
                        <a href="mailto:{{ $contact->email }}" style="color: #000; text-decoration: none; font-weight: bold;">
                            {{ $contact->email }}
                        </a>
                    </div>
                </div>
                @if($contact->service)
                <div class="info-row">
                    <div class="info-label">Service:</div>
                    <div class="info-value"><strong>{{ $contact->service }}</strong>
                        @if(str_contains($contact->service, 'laravel') || str_contains($contact->service, 'api'))
                            <span class="priority high">HIGH PRIORITY</span>
                        @elseif(str_contains($contact->service, 'consultation') || str_contains($contact->service, 'maintenance'))
                            <span class="priority medium">MEDIUM PRIORITY</span>
                        @else
                            <span class="priority low">NORMAL</span>
                        @endif
                    </div>
                </div>
                @endif
                <div class="info-row">
                    <div class="info-label">Subject:</div>
                    <div class="info-value"><strong>{{ $contact->subject }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Received:</div>
                    <div class="info-value">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Time Ago:</div>
                    <div class="info-value">{{ $contact->created_at->diffForHumans() }}</div>
                </div>
            </div>
            
            <!-- Message Content -->
            <div class="message-content">
                <h4>💬 Client Message:</h4>
                <div class="message-text">{{ $contact->message }}</div>
            </div>
            
            <!-- Quick Actions -->
            <div class="actions">
                <h4>⚡ Quick Actions</h4>
                <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}&body=Hello {{ $contact->name }},%0D%0A%0D%0AThank you for your message regarding {{ $contact->subject }}. I have reviewed your requirements and would like to discuss your project further.%0D%0A%0D%0ABest regards,%0D%0AYounas Dev" class="btn">
                    📧 Reply Now
                </a>
                @if($contact->service)
                <a href="mailto:{{ $contact->email }}?subject=Quote for {{ $contact->service }}&body=Hello {{ $contact->name }},%0D%0A%0D%0AI would be happy to provide you with a detailed quote for {{ $contact->service }}. Let me prepare a proposal for you.%0D%0A%0D%0ABest regards,%0D%0AYounas Dev" class="btn">
                    💰 Send Quote
                </a>
                @endif
                <a href="https://calendly.com/younasdev" class="btn" target="_blank">
                    📅 Schedule Call
                </a>
            </div>
            
            <p style="margin-top: 20px;">
                <strong>⏰ Response Time Goal:</strong> Respond within 4 hours during business hours<br>
                <strong>🎯 Priority Level:</strong> 
                @if($contact->service && (str_contains($contact->service, 'laravel') || str_contains($contact->service, 'api')))
                    <span style="color: #ff4444; font-weight: bold;">HIGH - Your specialty service!</span>
                @else
                    <span style="color: #00aa00; font-weight: bold;">NORMAL</span>
                @endif
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>This notification was sent automatically from your contact form.</p>
            <p>Contact ID: #{{ $contact->id }} | Generated at {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>
</body>
</html>