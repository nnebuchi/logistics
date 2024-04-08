<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Complaint</title>
</head>
<body style="font-family: 'Open Sans', sans-serif;">
    <div style="padding: 5% 4%;">
        <img src="{{asset('assets/images/logos/dark-logo.png')}}" style="display: block; margin-left: auto; margin-right: auto; width: 200px;" alt="">
        <h3 style="text-align: center; font-size: 30px; color: rgba(0, 46, 102, 1); font-family: Montserrat; margin-top: 3%;">{{$data["subject"]}}</h3>

        <div style="background-color: #cedee4; border-radius: 35px; padding: 5% 5%; margin-top: 5%; text-align: left;">
            <h2 style="font-size: 18px; font-weight: bold; color: rgba(0, 46, 102, 1)">{{$data["body"]}}</h2>
        
            <p>Best regards,</p>
            <p><strong>Dinma Team</strong></p>
        </div>

        <div style="background-color: #cedee4; border-radius: 35px; padding: 5% 4%; margin-top: 5%; text-align: center;">
            <img src="{{asset('assets/images/logos/favicon.png')}}" style="display: block; margin-left: auto; margin-right: auto; margin-bottom: 3%; width: 30px;" alt="">
            <p>For support, contact us via <a href="mailto:<?=env("SUPPORT_MAIL")?>"><?=env("SUPPORT_MAIL")?></a></p>
            <p style="text-align: center;">© <?=date("Y")?> {{ env('APP_NAME') }}. All rights reserved.</p>
        </div>
        
    </div>
</body>
</html>