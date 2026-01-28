<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $campaign->subject }}</title>
</head>
<body style="font-family: 'Times New Roman', Times, serif; background-color: #f3f4f6; margin: 0; padding: 20px;">
    <div style="max-width: 700px; margin: 0 auto; background-color: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="padding: 40px; text-align: center; border-bottom: 4px double #e5e7eb;">
            <h1 style="margin: 0; font-size: 36px; color: #111827; font-weight: normal;">THE UMERA WEEKLY</h1>
            <p style="margin: 10px 0 0; color: #6b7280; font-style: italic; font-size: 14px;">Insights for the Modern Investor</p>
        </div>
        
        <!-- Date -->
        <div style="padding: 10px 40px; border-bottom: 1px solid #e5e7eb; text-align: right; color: #9ca3af; font-size: 12px; font-family: sans-serif;">
            {{ now()->format('F d, Y') }}
        </div>
        
        <!-- Content -->
        <div style="padding: 40px; font-family: Georgia, serif; font-size: 18px; line-height: 1.8; color: #374151;">
            {!! $campaign->content !!}
        </div>
        
        <!-- Footer -->
        <div style="background-color: #1f2937; color: #ffffff; padding: 40px; text-align: center; font-family: sans-serif;">
            <h3 style="margin: 0 0 10px; font-size: 16px;">Umera Farms</h3>
            <p style="margin: 0; font-size: 12px; color: #9ca3af;">Growing Wealth, Naturally.</p>
            <div style="margin-top: 20px;">
                <a href="#" style="color: #d1d5db; text-decoration: none; font-size: 12px; margin: 0 10px;">Website</a>
                <a href="#" style="color: #d1d5db; text-decoration: none; font-size: 12px; margin: 0 10px;">Contact</a>
                <a href="#" style="color: #d1d5db; text-decoration: none; font-size: 12px; margin: 0 10px;">Unsubscribe</a>
            </div>
        </div>
    </div>
</body>
</html>
