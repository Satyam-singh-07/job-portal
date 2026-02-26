<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Email Verification</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f9;font-family:Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
<tr>
<td align="center">

<table width="500" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:10px;box-shadow:0 5px 20px rgba(0,0,0,0.08);padding:40px;text-align:center;">

<tr>
<td>
<h2 style="margin-bottom:10px;color:#333;">Verify Your Email</h2>
<p style="color:#666;font-size:14px;">
Hi {{ $user->email }},
</p>
<p style="color:#666;font-size:14px;margin-bottom:30px;">
Use the verification code below to complete your registration.
</p>

<div style="font-size:32px;letter-spacing:8px;font-weight:bold;color:#0d6efd;margin-bottom:30px;">
{{ $otp }}
</div>

<p style="font-size:13px;color:#999;">
This code will expire in 10 minutes.
</p>

<hr style="margin:30px 0;border:none;border-top:1px solid #eee;">

<p style="font-size:12px;color:#aaa;">
If you did not create this account, you can safely ignore this email.
</p>

</td>
</tr>

</table>

<p style="font-size:12px;color:#aaa;margin-top:20px;">
© {{ date('Y') }} Your Company. All rights reserved.
</p>

</td>
</tr>
</table>

</body>
</html>