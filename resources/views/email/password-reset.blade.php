<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ziga Afrika - Verify Email</title>
    </head>
    <style>
        .btn{
            display:flex;
            align-items:center;
            justify-content:center;
            background-color:#233E83;
            color:white;
            width:180px;
            padding:7px 20px;
            border-radius:10px;
            text-decoration:none;
        }
        .hor-center{
            display:flex;
            justify-content:center;
        }
        .social-div{
            display:flex;
            justify-content:space-between;
            width: 50%;
        }
    </style>
    <body style="font-family: 'Open Sans', sans-serif;">
        <div style="">
            <a href="{{url('/')}}"><img src="{{asset('assets/images/logos/ziga-blue.png')}}" style="display:block;margin-left:auto;margin-right:auto;" width="180" alt=""></a>
            <h3 style="text-align: center; font-size: 30px; color: rgba(0, 46, 102, 1); font-family: Montserrat; margin-top: 3%;">Reset Password Request</h3>

            <div style="background-color: #F79D1D1A; padding: 5% 5%; text-align: left;">
                <p>You are receiving this email because we received a password reset request for your account.</p>
                <div style="margin-top:40px;" class="hor-center">
                    <a href="<?=$url?>" class="btn">Reset Password <img style="margin-left:10px" src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="ml-2" alt=""></a>
                </div>
                <p>This password link will expire in 60 minutes.</p>
                <p>Thank you for using our application!</p>
            </div>

            <div style="padding: 5% 4%;text-align: center;">
                <p class="hor-center">Follow us</p>
                <div class="hor-center">
                    <div class="social-div">
                        <img src="{{asset('assets/images/icons/email-template/facebook.svg')}}" width="30" alt="">
                        <img src="{{asset('assets/images/icons/email-template/twitter.svg')}}" width="30" alt="">
                        <img src="{{asset('assets/images/icons/email-template/linkedin.svg')}}" width="30" alt="">
                        <img src="{{asset('assets/images/icons/email-template/instagram.svg')}}" width="30" alt="">
                    </div>
                </div>
                
                <p style="text-align: center;margin-top:40px;">Sent By <?=config('app.name')?>, Lagos. All rights reserved.</p>
            </div>
            
        </div>
    </body>
</html>