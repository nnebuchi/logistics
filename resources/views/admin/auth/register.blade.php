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
                            <img src="{{asset('assets/images/icons/auth/illustration1.svg')}}" width="350" height="300" alt="">
                            <h5 class="text-white">We have a global reach</h5>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="text-white">Privacy Policy</h6>
                            <h6 class="text-white">Terms and Conditions</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 h-100 box2" style="overflow:auto">
                    <div style="margin-top:80px;margin-bottom:60px">
                        <div class="mb-4 dynamic-logo">
                            <a href="{{url('/')}}" class="">
                                <img src="{{asset('assets/images/logos/ziga-blue.png')}}" width="180" alt="">
                            </a>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-xl-11 col-lg-11 col-md-12 col-sm-10">
                                <h4 style="font-weight:700">Create Account</h4>
                                <form id="signup" action="{{url('/register')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-12">
                                            <label for="firstname" class="custom-input-label">First Name</label>
                                            <div class="d-flex position-relative input-box">
                                                <div class="d-flex align-items-center justify-content-center p-l-10 p-r-10 position-absolute h-100 px-2 icon-box"><img src="{{asset('assets/images/icons/auth/ooui_user-avatar.svg')}}" width="15" alt=""></div>
                                                <input 
                                                type="text" 
                                                id="firstname"
                                                name="firstname"
                                                placeholder="First name"
                                                class="custom-input" />
                                            </div>
                                            <span class="error"> </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12">
                                            <label for="lastname" class="custom-input-label">Last Name</label>
                                            <div class="d-flex position-relative input-box">
                                                <div class="d-flex align-items-center justify-content-center p-l-10 p-r-10 position-absolute h-100 px-2 icon-box"><img src="{{asset('assets/images/icons/auth/ooui_user-avatar.svg')}}" width="15" alt=""></div>
                                                <input 
                                                type="text" 
                                                id="lastname"
                                                name="lastname"
                                                placeholder="Last name"
                                                class="custom-input" />
                                            </div>
                                            <span class="error"> </span>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-xl-6 col-lg-6 col-md-12">
                                            <label for="phone" class="custom-input-label">Phone Number</label>
                                            <div class="d-flex position-relative input-box">
                                                <select id="countrySelect" class="country_code">
                                                    
                                                </select>
                                                <input 
                                                type="tel" 
                                                id="phone"
                                                name="phone"
                                                style="border-radius:0 15px 15px 0"
                                                placeholder="Phone Number"
                                                class="custom-input pl-2" />
                                            </div>
                                            <span class="error"> </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12">
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
                                    </div>
                                    <div class="mt-3">
                                            <label for="account_type" class="custom-input-label">Account Type</label>
                                            <div class="select-box">
                                                <select
                                                id="account_type"
                                                name="account_type"
                                                class="custom-select">
                                                <option value="">--Select one---</option>
                                                @foreach($accounts as $account)
                                                <option value="{{$account->name}}">{{$account->name}}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                            <span class="error"> </span>
                                        </div>
                                    <div class="mt-3">
                                        <label for="password" class="custom-input-label">Password</label>
                                        <div class="d-flex position-relative input-box">
                                            <div class="d-flex align-items-center justify-content-center p-l-10 p-r-10 position-absolute h-100 px-2" style="top:0;left:0">
                                                <img src="{{asset('assets/images/icons/auth/mdi_password-outline.svg')}}" width="15" alt="">
                                            </div>
                                            <input 
                                            type="password" 
                                            id="password"
                                            name="password"
                                            placeholder="Enter Password" 
                                            class="custom-input" />
                                            <div class="d-flex align-items-center justify-content-center p-l-10 p-r-10 position-absolute h-100 px-2" style="top:0;right:0">
                                                <img src="{{asset('assets/images/icons/auth/ion_eye.svg')}}" class="show-hide" width="15" alt="">
                                            </div>
                                        </div>
                                        <span class="error"></span>
                                    </div>

                                    <p style="font-size:14px;color:#1E1E1E;" class="mt-3">By clicking the Sign Up button below, you agree to ZIga Afrika's 
                                        <a href="" style="font-weight:600" class="custom-text-secondary">terms of acceptable use.</a>
                                    </p>

                                    <div class="d-flex justify-content-center mt-4">
                                        <button type="submit" class="custom-btn fs-4 mb-2">Sign Up 
                                            <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="ml-2" alt="">
                                        </button>
                                    </div>
                                    <h6 style="font-size:14px;" class="mt-2 text-center">Already have an account? <a href="{{url('/login')}}" class="custom-text-secondary">Sign in</a></h6>
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
        $('#signup').on("submit", function (event) {
            event.preventDefault();
            let btn = $(this).find("button[type='submit']");
            btn.html(`<img src="{{asset('assets/images/loader.gif')}}" id="loader-gif">`);
            btn.attr("disabled", true);
            const form = event.target;
            const url = form.action;
            const inputs = {
                firstname: $("#firstname").val(),
                lastname: $("#lastname").val(),
                email: $("#email").val(),
                phone: $("#phone").val(),
                password: $("#password").val(),
                account_type: $("#account_type").val()
            };

            $("#firstname").css("borderColor", "transparent");
            $("#lastname").css("borderColor", "transparent");
            $("#phone").css("borderColor", "transparent");
            $("#email").css("borderColor", "transparent");
            $("#password").css("borderColor", "transparent");
            $("#account_type").css("borderColor", "transparent");
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
                    btn.attr("disabled", false).text("Sign Up");
                    window.location.href = response.data.results;
                })
                .catch(function(error){ 
                    console.log(error);
                    btn.attr("disabled", false).text("Sign Up");
                   
                    let errors = error?.response?.data?.error;
                    console.log(errors);
                    if(errors?.firstname){
                        $('.error').eq(0).text(errors.firstname);
                        $("#firstname").css("border", "1px solid #FA150A");
                    }
                    if(errors?.lastname){
                        $('.error').eq(1).text(errors.lastname);
                        $("#lastname").css("border", "1px solid #FA150A");
                    }
                    if(errors?.phone){
                        $('.error').eq(2).text(errors.phone);
                        $("#phone").css("border", "1px solid #FA150A");
                    }
                    if(errors?.email){
                        $('.error').eq(3).text(errors.email);
                        $("#email").css("border", "1px solid #FA150A");
                    }
                    if(errors?.account_type){
                        $('.error').eq(4).text(errors.account_type);
                        $("#account_type").css("border", "1px solid #FA150A");
                    }
                    if(errors?.password){
                        $('.error').eq(5).text(errors.password);
                        $("#password").css("border", "1px solid #FA150A");
                    }

                    btn.attr("disabled", false).text("Sign Up");
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
    
        document.getElementById('countrySelect').addEventListener('change', function() {
            var countryCode = this.value;
            var phoneNumberInput = document.getElementById('phone');
            phoneNumberInput.value = countryCode;
            phoneNumberInput.focus(); // Optionally, focus on the input field after selecting the country
        });
    </script>
    <script>
        async function getCountries(){
            const response = await axios.get("https://restcountries.com/v3.1/all");
            let countries = response.data;
            countries.sort((a, b) => {
                let nameA = a.name.common.toLowerCase();
                let nameB = b.name.common.toLowerCase();
                if (nameA < nameB) {
                    return -1; // 'a' comes before 'b'
                }
                if (nameA > nameB) {
                    return 1; // 'a' comes after 'b'
                }
                return 0; // names are equal
            });
            $("#countrySelect").empty();
            countries.forEach(country => {
                let append = "";
                if(country.idd.root){
                    append = (country.name.common == "Nigeria") ? `
                        <option selected value="${country.idd.root.concat(country.idd.suffixes[0])}">
                            ${country.name.common} (${country.idd.root.concat(country.idd.suffixes[0])})
                        </option>
                    ` : `
                        <option value="${country.idd.root.concat(country.idd.suffixes[0])}">
                            ${country.name.common} (${country.idd.root.concat(country.idd.suffixes[0])})
                        </option>
                    `;
                }
                if(country.name.common == "Nigeria"){
                    var phoneNumberInput = document.getElementById('phone');
                    phoneNumberInput.value = country.idd.root.concat(country.idd.suffixes[0]);
                }
                
                $("#countrySelect").append(`
                    ${append}
                `);
            });
        }
        getCountries();
    </script>
    </body>
</html>