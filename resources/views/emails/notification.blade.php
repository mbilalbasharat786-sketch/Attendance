<!DOCTYPE html>
<html>
<head>
    <title>System Notification</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; border: 1px solid #eee; padding: 20px; border-radius: 10px;">
        <h2 style="color: #111827;">{{ $details['title'] }}</h2>
        <p>Assalam o Alaikum!</p>
        <div style="background: #f9fafb; padding: 15px; border-radius: 5px; margin: 20px 0;">
            {!! $details['body'] !!}
        </div>
        <p style="font-size: 12px; color: #777;">Yeh ek automated notification hai aapke Attendance System se.</p>
    </div>
</body>
</html>