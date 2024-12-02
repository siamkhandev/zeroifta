<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Request</title>
</head>
<body>
<p>Hello,</p>

<p>You requested a password reset. Click the link below to reset your password:</p>

<p><a href="{{ $resetLink }}">{{ $resetLink }}</a></p>

<p>If you did not request a password reset, no further action is required.</p>

<p>Thank you!</p>
</body>
</html>
