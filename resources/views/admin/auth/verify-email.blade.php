@include("admin.auth.layouts.header")
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
                            <img src="{{asset('assets/images/icons/auth/illustration4.svg')}}" width="350" height="300" alt="">
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
                        <div class="text-center">
                            <img src="{{asset('assets/images/icons/auth/success-icon.svg')}}" width="120" height="120" alt="">
                        </div>
                        <p class="text-center mt-2">Your account registration was successful</p>
                        <h5 class="text-center custom-text-primary" style="font-weight:bold">Please verify your account on your email. Thank you!</h5>
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