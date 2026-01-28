<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $campaign->subject }}</title>
</head>
<body style="font-family: Georgia, serif; background-color: #ffffff; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 40px;">
        <!-- Logo/Header -->
        <div style="text-align: left; margin-bottom: 30px; border-bottom: 2px solid #1a5c2e; padding-bottom: 20px;">
            <span style="font-size: 28px; color: #1a5c2e; font-weight: bold;">Umera Farms</span>
        </div>
        
        <!-- Content -->
        <div style="color: #333; font-size: 16px; line-height: 1.8;">
            {!! $campaign->content !!}
        </div>
        
        <!-- Signature -->
        <div style="margin-top: 40px; padding-top: 20px;">
            <p style="margin: 0; font-weight: bold;">Sincerely,</p>
            <p style="margin: 5px 0 0;">The Umera Team</p>
        </div>
        
        <!-- Footer -->
        <div style="margin-top: 40px; border-top: 1px solid #ddd; padding-top: 15px; font-size: 11px; color: #888; font-family: sans-serif;">
            <p>This email was sent to {{ $contact->email }}. If you no longer wish to receive these emails, you can <a href="#" style="color: #666;">unsubscribe</a>.</p>
        </div>
    </div>
</body>
</html>
