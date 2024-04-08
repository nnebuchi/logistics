<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CISADOC - Verify Email</title>
</head>
<body style="font-family: 'Open Sans', sans-serif;">
        <div style="padding: 5% 4%;">
           <img src="{{asset('assets/images/logos/dark-logo.png')}}" style="display: block; margin-left: auto; margin-right: auto; width: 200px;" alt="">
           <h3 style="text-align: center; font-size: 30px; color: rgba(0, 46, 102, 1); font-family: Montserrat; margin-top: 3%;">Account Verification</h3>

           <div style="background-color: #cedee4; border-radius: 35px; padding: 5% 5%; margin-top: 5%; text-align: left;">
            <p>Hello!, {{$user->name}}</p>

            <p>Welcome to Dinma. To verify your email, and ensure the security of your account, please enter the following One-Time Password (OTP) code:</p>
 
            <h2 style="font-size: 35px; font-weight: bold; letter-spacing: 20px;">{{$code}}</h2>
 
            <p>This code is valid for 10 minutes.</p>
 
            <p>Thank you for choosing Dinma.</p>
 
            <p>Best regards,</p>
            <p><strong>Dinma Team</strong></p>
           </div>

           <div style="background-color: #cedee4; border-radius: 35px; padding: 5% 4%; margin-top: 5%; text-align: center;">
                <img src="{{asset('assets/images/logos/favicon.png')}}" style="display: block; margin-left: auto; margin-right: auto; margin-bottom: 3%; width: 30px;" alt="">
                <p>For support, contact us via <a href="mailto:<?=env("SUPPORT_MAIL")?>"><?=env("SUPPORT_MAIL")?></a></p>
               <p style="text-align: center;">© <script>document.write(new Date().getFullYear())</script> {{ env('APP_NAME') }}. All rights reserved.</p>
           </div>
           
        </div>
</body>
</html>