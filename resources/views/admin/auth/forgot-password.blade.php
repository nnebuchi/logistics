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
                            <img src="{{asset('assets/images/icons/auth/illustration2.svg')}}" width="320" height="270" alt="">
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
                        <div class="row justify-content-center">
                            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-8">
                                <h4 style="font-weight:700">Reset Password</h4>
                                <form id="forgot-pwd" action="{{url('/forgot-password')}}" method="POST">
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
                                        <span class="error"> </span>
                                    </div>

                                    <div class="d-flex justify-content-center mt-4">
                                        <button 
                                        type="submit" 
                                        class="custom-btn fs-4 mb-2">
                                        Submit <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="ml-2" alt="">
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
        $('#forgot-pwd').on("submit", function (event) {
            event.preventDefault();
            let btn = $(this).find("button[type='submit']");
            btn.html(`<img src="/assets/images/loader.gif" id="loader-gif">`);
            btn.attr("disabled", true);
            const form = event.target;
            const url = form.action;
            const inputs = { email: $("#email").val() };

            $("#email").css("borderColor", "transparent");
            $('.error').text('');
            $('.message').text('');
            // Append loader immediately
            setTimeout(() => {
                const config = {
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                        "X-Requested-With": "XMLHttpRequest"
                    }
                };
                axios.post(url, inputs, config)
                .then(function(response){
                    let message = response.data.message;
                    $(".message").css("color", "green").text(message);
                    toast(message);
                    btn.attr("disabled", false).text("Submit");
                })
                .catch(function(error){
                    let errors = error.response.data.error;
                    if(errors.email){
                        $('.error').eq(0).text(errors.email);
                        $("#email").css("border", "1px solid #FA150A");
                    }
        
                    btn.attr("disabled", false).text("Submit");
                });
            }, 100); // Delay submission by 100 milliseconds
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
    </body>
</html>