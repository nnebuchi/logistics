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
                            <img src="{{asset('assets/images/icons/auth/illustration2.svg')}}" width="350" height="300" alt="">
                            <h5 class="text-white mt-5">We got you covered</h5>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="text-white">Privacy Policy</h6>
                            <h6 class="text-white">Terms and Conditions</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 h-100 box2" style="overflow:auto;">
                    <div class="h-100 d-flex flex-column justify-content-center w-100">
                        <div class="mb-4 dynamic-logo">
                            <a href="{{url('/')}}" class="">
                                <img src="{{asset('assets/images/logos/ziga-blue.png')}}" width="180" alt="">
                            </a>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-8">
                                <div class="text-center main-div">
                                    @include('layouts.shared.alert')
                                </div>
                                <h4 style="font-weight:700">Sign In Here</h4>
                                <form id="login" action="{{route('user-signin')}}" method="POST">
                                    @csrf
                                    <p class="message text-center"></p>
                                    <div class="">
                                        <label for="email" class="custom-input-label">Email</label>
                                        <div class="d-flex position-relative input-box">
                                            <div class="d-flex align-items-center justify-content-center p-l-10 p-r-10 position-absolute h-100 px-2 icon-box">
                                                <img src="{{asset('assets/images/icons/auth/iconamoon_email-thin.svg')}}" width="15" alt="">
                                            </div>
                                            <input type="email"  id="email" name="email" placeholder="Email" class="custom-input" />
                                        </div>
                                        <div class="text-danger backend-msg">
                                            @error('email')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label for="password" class="custom-input-label">Password</label>
                                        <div class="d-flex position-relative input-box">
                                            <div class="d-flex align-items-center justify-content-center p-l-10 p-r-10 position-absolute h-100 px-2" style="top:0;left:0">
                                                <img src="{{asset('assets/images/icons/auth/mdi_password-outline.svg')}}" width="15" alt="">
                                            </div>
                                            <input type="password" id="password" name="password" placeholder="Enter Password" class="custom-input" />
                                            <div class="d-flex align-items-center justify-content-center p-l-10 p-r-10 position-absolute h-100 px-2" style="top:0;right:0">
                                                <img src="{{asset('assets/images/icons/auth/ion_eye.svg')}}" class="show-hide" width="15" alt="">
                                            </div>
                                        </div>
                                        <div class="text-danger backend-msg">
                                            @error('password')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mb-4 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                                            <label class="form-check-label text-dark" for="flexCheckChecked">
                                                Remember Me
                                            </label>
                                        </div>
                                        <a class="custom-text-secondary" href="{{url('/forgot-password')}}" style="font-weight: 600">Forgot Password ?</a>
                                    </div>

                                    <div class="d-flex justify-content-center mt-4">
                                        <button type="button" onclick="validateLoginForm()" class="custom-btn fs-4 mb-2 login-btn
                                        login-btn">
                                            Log In 
                                            <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="ml-2" alt="">
                                        </button>
                                    </div>
                                    <h5 style="font-size:14px;" class="mt-2 text-center">Don't have an account? <a href="{{url('/register')}}" class="custom-text-secondary fw-bold">Sign Up</a></h5>
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


        $('#login').on("submit", function (event) {
            event.preventDefault();
            let btn = $(this).find("button[type='submit']");
            btn.html(`<img src="{{asset('assets/images/loader.gif')}}" id="loader-gif">`);
            btn.attr("disabled", true);
            const form = event.target;
            const url = form.action;
            const inputs = {
                email: $("#email").val(),
                password: $("#password").val()
            };

            $("#email").css("borderColor", "transparent");
            $("#password").css("borderColor", "transparent");
            $('.error').text('');
            $('.message').text('');
            // Append loader immediately
            // setTimeout(() => {
            //     const config = {
            //         headers: {
            //             Accept: "application/json",
            //             "Content-Type": "application/json",
            //             "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
            //             "X-Requested-With": "XMLHttpRequest"
            //         }
            //     };
            //     axios.post(url, inputs, config)
            //     .then(function(response){
            //         let message = response.data.message;
            //         $(".message").css("color", "green").text(message);
            //         toast(message);
            //         btn.attr("disabled", false)
            //         .html("Log In <img src='/assets/images/icons/auth/cil_arrow-right.svg' width='20' class='ml-2' alt=''/>");
            //         // Add User Auth Bearer Token To Local Storage
            //         localStorage.setItem('token', response.data.results.user.token);
            //         window.location.href = response.data.results.redirect;
            //     })
            //     .catch(function(error){
            //         let errors = error.response.data.error;
            //         if(errors.email){
            //             $('.error').eq(0).text(errors.email);
            //             $("#email").css("border", "1px solid #FA150A");
            //         }
            //         if(errors.password){
            //             $('.error').eq(1).text(errors.password);
            //             $("#password").css("border", "1px solid #FA150A");
            //         }

            //         switch(error.response.status){
            //             case 400:
            //                 $(".message").css("color", "red").text(error.response.data.message)
            //             break;
            //             case 401:
            //                 $(".message").css("color", "red").text(error.response.data.message);
            //             break;
            //         }

            //         btn.attr("disabled", false)
            //         .html("Log In <img src='/assets/images/icons/auth/cil_arrow-right.svg' width='20' class='ml-2' alt=''/>");
            //     });
            // }, 100); 
        });

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
    <script>
        $(".show-hide").click(function (event) {
            let icon = $(this);
            var input = $("#password");
            if(input.attr("type") === "password"){
                input.attr("type", "text");
                icon.attr("name", "eye-off-outline");
            }else{
                input.attr("type", "password");
                icon.attr("name", "eye-outline");
            }
        });
    </script>
    
    <script>

        // const submitLoginForm = () => {
        //     const config = {
        //         headers: {
        //             Accept: "application/json",
        //             "Content-Type": "application/json",
        //             "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
        //             "X-Requested-With": "XMLHttpRequest"
        //         }
        //     };
        //     axios.post(url, inputs, config)
        //     .then(function(response){
        //         let message = response.data.message;
        //         $(".message").css("color", "green").text(message);
        //         toast(message);
        //         btn.attr("disabled", false)
        //         .html("Log In <img src='/assets/images/icons/auth/cil_arrow-right.svg' width='20' class='ml-2' alt=''/>");
        //         // Add User Auth Bearer Token To Local Storage
        //         localStorage.setItem('token', response.data.results.user.token);
        //         window.location.href = response.data.results.redirect;
        //     })
        //     .catch(function(error){
        //         let errors = error.response.data.error;
        //         console.log(errors);
        //         if(errors.email){
        //             $('.error').eq(0).text(errors.email);
        //             $("#email").css("border", "1px solid #FA150A");
        //         }
        //         if(errors.password){
        //             $('.error').eq(1).text(errors.password);
        //             $("#password").css("border", "1px solid #FA150A");
        //         }

        //         switch(error.response.status){
        //             case 400:
        //                 $(".message").css("color", "red").text(error.response.data.message)
        //             break;
        //             case 401:
        //                 $(".message").css("color", "red").text(error.response.data.message);
        //             break;
        //         }

        //         btn.attr("disabled", false)
        //         .html("Log In <img src='/assets/images/icons/auth/cil_arrow-right.svg' width='20' class='ml-2' alt=''/>");
        //     });
        // }
        const validateLoginForm = () => {
            // document.querySelectorAll(".backend-msg").forEach(function(field, index){
            //     field.innerHTML = '';
            // })
            const submitBtn = document.querySelector(".login-btn");
            const oldBtnHTML = submitBtn.innerHTML;
            setBtnLoading(submitBtn);

            const validation = runValidation([
                {
                    id:"email",
                    rules: {'required':true, 'email':true}
                },
                {
                    id:'password',
                    rules:{'required':true}
                },
                
            ]);

            if(validation === true){
                submitLoginForm();
                setBtnNotLoading(submitBtn, oldBtnHTML)
            }else{
                setBtnNotLoading(submitBtn, oldBtnHTML)
            }
        }

        const submitLoginForm = () => {
            document.querySelector("#login").submit();
        }
    </script>
    </body>
</html>