<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <base href="{{url('')}}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
        <meta name="csrf-token" content="{{csrf_token()}}">

        <meta name="theme-color" content="" />
        <meta name="apple-mobile-web-app-status-bar-style" content="" />
        <title>Ziga Afrika Dashboard</title>
        <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logos/favicon.png')}}" />
        <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css" />
        <link rel="stylesheet" href="{{asset('assets/libs/sweetalert2/sweetalert2.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}" />
        <?php date_default_timezone_set("Africa/Lagos"); ?>
    </head>
    <body>

    <section class="d-flex" style="height:100vh;width:100%">
        <div class="container-fluid w-100 h-100 px-0" style="position:absolute;top:0;left:0">
            <div class="row w-100 h-100 mx-0" style="background-color:#4f659c">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 pt-3 h-100 box1">
                    <div class="h-100 d-flex flex-column justify-content-between">
                        <div class="">
                            <a href="{{url('/')}}" class="">
                                <img src="{{asset('assets/images/logos/ziga-blue2.svg')}}" width="180" alt="">
                            </a>
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            <img src="{{asset('assets/images/icons/auth/illustration3.svg')}}" width="350" height="300" alt="">
                            <h5 class="text-white">Our Prices Are Affordable</h5>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="text-white">Privacy Policy</h6>
                            <h6 class="text-white">Terms and Conditions</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 h-100 box2" style="overflow:auto">
                    <div class="h-100 d-flex flex-column justify-content-center w-100">
                        <div class="mb-4 dynamic-logo">
                            <a href="{{url('/')}}" class="">
                                <img src="{{asset('assets/images/logos/ziga-blue.png')}}" width="180" alt="">
                            </a>
                        </div>
                        <h5 class="text-center" style="font-weight:bold">Congratulations</h5>
                        <p class="text-center">Your password has been changed successfully</p>
                        <div class="text-center">
                            <img src="{{asset('assets/images/icons/auth/success-icon.svg')}}" width="120" height="120" alt="">
                        </div>
                        <div class="text-center mt-5">
                            <a href="" class="custom-btn">
                                Proceed to Dashboard
                                <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="ml-2" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('assets/libs/axios/axios.js')}}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="{{asset('assets/libs/sweetalert2/sweetalert2.all.js')}}"></script>
    </body>
</html>