<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $campaign->subject }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #fff9f0; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 2px solid #fbd38d; border-radius: 12px; overflow: hidden;">
        <!-- Banner -->
        <div style="background-color: #fbd38d; padding: 20px; text-align: center;">
            <span style="font-size: 24px; color: #744210; font-weight: bold; text-transform: uppercase; letter-spacing: 2px;">Special Offer</span>
        </div>
        
        <!-- Content -->
        <div style="padding: 30px; text-align: center;">
            <div style="color: #2d3748; font-size: 18px; line-height: 1.6;">
                {!! $campaign->content !!}
            </div>
            
            <div style="margin-top: 30px;">
                <a href="{{ config('app.url') }}" style="background-color: #1a5c2e; color: #ffffff; padding: 15px 30px; border-radius: 30px; text-decoration: none; font-weight: bold; display: inline-block;">Explore Now</a>
            </div>
        </div>
        
        <!-- Footer -->
        <div style="background-color: #f7fafc; padding: 20px; text-align: center; font-size: 12px; color: #a0aec0;">
            <p>Don't miss out on our latest updates!</p>
            <p><a href="#" style="color: #a0aec0;">Manage Preferences</a></p>
        </div>
    </div>
</body>
</html>
