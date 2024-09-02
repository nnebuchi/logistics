<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <title>Dinma - Health Care</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,400;1,400;1,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,800;1,800&display=swap" rel="stylesheet">
    </head>
    <body style="font-family: 'Open Sans', sans-serif;">
        <div>  
            <img src="{{asset('assets/images/logos/dark-logo.png')}}" style="display: block; margin-left: auto; margin-right: auto; width: 200px;" alt="">
            <h3 style="text-align: center; font-size: 30px; color: rgba(0, 46, 102, 1); font-family: Montserrat; margin-top: 3%;">Password Reset Request</h3>

            <div style="text-align: center;">
                <a href="<?=url('/password-reset/'.$user->email.'/'.$code)?>" 
                style="background-color:rgb(216,56,62);padding:10px 20px;outline:none;border:none;color:white;text-decoration:none;border-radius:5px;">Reset Password</a>
            </div>

            <div style="background-color: #cedee4; border-radius: 35px; padding: 5% 4%; margin-top: 5%; text-align: center;">
                <img src="{{asset('assets/images/logos/favicon.jpg')}}" style="display: block; margin-left: auto; margin-right: auto; margin-bottom: 3%; width: 30px;" alt="">
                <p>For support, contact us via <a href="mailto:support@dinma.com">support@dinma.com</a></p>
                <p style="text-align: center;">© <script>document.write(new Date().getFullYear())</script> {{ env('APP_NAME') }}. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>