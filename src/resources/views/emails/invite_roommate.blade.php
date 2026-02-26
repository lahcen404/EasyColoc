<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; background-color: #f4f7f8; padding: 20px; }
        .container { background-color: #ffffff; max-width: 600px; margin: 0 auto; padding: 40px; border-radius: 20px; border-top: 6px solid #0A6071; }
        .header { color: #0A6071; font-size: 24px; font-weight: 800; text-transform: uppercase; margin-bottom: 20px; }
        .content { color: #4a5568; line-height: 1.6; font-size: 16px; }
        .button { display: inline-block; background-color: #0A6071; color: #ffffff !important; padding: 15px 30px; border-radius: 10px; text-decoration: none; font-weight: bold; margin-top: 25px; text-transform: uppercase; font-size: 14px; }
        .footer { margin-top: 30px; font-size: 12px; color: #a0aec0; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">EasyColoc</div>
        <div class="content">
            <p>Hello,</p>
            <p>You have been invited to join the house: <strong>{{ $invitation->colocation->name }}</strong>.</p>
            <p>Click the button below to accept the invitation and start managing your shared expenses.</p>

            <a href="{{ $joinUrl }}" class="button">Join the Colocation</a>

            <p style="margin-top: 30px; font-size: 12px; color: #718096;">
                This link will expire on {{ $invitation->expires_at->format('M d, Y') }}.
            </p>
        </div>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} EasyColoc Management Engine
    </div>
</body>
</html>
