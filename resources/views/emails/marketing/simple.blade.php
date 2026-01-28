<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $campaign->subject }}</title>
</head>
<body style="font-family: sans-serif; line-height: 1.5; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="margin-bottom: 20px;">
        {!! $campaign->content !!}
    </div>
    
    <div style="margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px; font-size: 12px; color: #999; text-align: center;">
        <p>You received this email because you are subscribed to our updates.</p>
        <p><a href="#" style="color: #999;">Unsubscribe</a></p>
    </div>
</body>
</html>
