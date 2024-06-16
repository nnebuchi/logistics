@include("customer.auth.layouts.header")
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
                            <img src="{{asset('assets/images/icons/auth/illustration2.svg')}}" width="320" height="270" alt="">
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="text-white">Privacy Policy</h6>
                            <h6 class="text-white">Terms and Conditions</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 h-100 box2 pt-3" style="overflow:auto">
                    @include("customer.auth.layouts.auth-nav")
                    <div class="h-10 d-flex flex-column justify-content-center w-100">
                        <div class="row justify-content-center">
                            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-8 pt-2">
                                <h4 style="font-weight:700"id="auth-heading">Reset Password</h4>
                                <form id="forgot-pwd" action="{{route('forgot-password')}}" method="POST">
                                    @csrf
                                    <p class="message text-center"></p>
                                    <div class="">
                                        <label for="email" class="custom-input-label">Email</label>
                                        <div class="d-flex position-relative input-box">
                                            <div class="d-flex align-items-center justify-content-center p-l-10 p-r-10 position-absolute h-100 px-2 icon-box"><img src="{{asset('assets/images/icons/auth/iconamoon_email-thin.svg')}}" width="15" alt=""></div>
                                            <input 
                                            type="email" 
                                            id="email"
                                            name="email"
                                            placeholder="Email"
                                            class="custom-input" />
                                        </div>
                                        <div class="text-danger backend-msg">
                                            @error('email')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-center mt-4">
                                        <button type="submit" class="custom-btn fs-4 mb-2 login-btn" onclick="validateForm()">Submit <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="ml-2" alt="">
                                        </button>
                                    </div>
                                    <h5 style="font-size:14px;" class="mt-2 text-center">Already have an account? <a href="{{url('/login')}}" class="custom-text-secondary fw-bold">Login</a></h5>
                                </form>
                            </div>
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


    <script>

        const submitForm = () => {
            document.querySelector("#forgot-pwd").submit();
        }

        const validateForm = () => {
            document.querySelectorAll(".backend-msg").forEach(function(field, index){
                field.innerHTML = '';
            })
            const submitBtn = document.querySelector(".login-btn");
            const oldBtnHTML = submitBtn.innerHTML;
            setBtnLoading(submitBtn);

            const validation = runValidation([
                {
                    id:"email",
                    rules: {'required':true, 'email':true}
                }
                
            ]);

            if(validation === true){
                submitForm();
                setBtnNotLoading(submitBtn, oldBtnHTML)
            }else{
                setBtnNotLoading(submitBtn, oldBtnHTML)
            }
        }

        const submitLoginForm = () => {
            document.querySelector("#login").submit();
        }
    </script>
    <script>

        function toast(message){
            const Toast = Swal.mixin({
                toast: true,
                position: 'center',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                },
                background: "#233E83",
                color: "#ffffff"
            });
            
            Toast.fire({
                icon: 'success',
                title: message
            });
        }
    </script>

    {{-- <script>
        const 
        const submitBtn = document.querySelector(".login-btn");
    </script> --}}
    </body>
</html>