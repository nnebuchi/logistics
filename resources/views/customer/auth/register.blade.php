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
                            <img src="{{asset('assets/images/icons/auth/illustration1.svg')}}" width="350" height="300" alt="">
                            <h5 class="text-white">We have a global reach</h5>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <a href="#" class="text-white mb-2"><strong>Privacy Policy</strong></a>
                            <a href="#" class="text-white mb-2"><strong>Terms and Conditions</strong></a>
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
                                <div class="text-center main-div">
                                    @include('layouts.shared.alert')
                                </div>
                                <h4 style="font-weight:700">Create Account</h4>
                                <form id="signup" action="{{route('user-signup')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-12">
                                            <label for="firstname" class="custom-input-label">First Name</label>
                                            <div class="d-flex position-relative input-box">
                                                <div class="d-flex align-items-center justify-content-center p-l-10 p-r-10 position-absolute h-100 px-2 icon-box"><img src="{{asset('assets/images/icons/auth/ooui_user-avatar.svg')}}" width="15" alt=""></div>
                                                <input value="<?=old('firstname')?>" type="text" id="firstname"name="firstname"placeholder="First name"class="custom-input" />
                                            </div>
                                            <div class="text-danger backend-msg">
                                                @error('firstname')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12">
                                            <label for="lastname" class="custom-input-label">Last Name</label>
                                            <div class="d-flex position-relative input-box">
                                                <div class="d-flex align-items-center justify-content-center p-l-10 p-r-10 position-absolute h-100 px-2 icon-box"><img src="{{asset('assets/images/icons/auth/ooui_user-avatar.svg')}}" width="15" alt=""></div>
                                                <input value="<?=old('lastname')?>" type="text" id="lastname"name="lastname"placeholder="Last name"class="custom-input" />
                                            </div>
                                            <div class="text-danger backend-msg">
                                                @error('lastname')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-xl-6 col-lg-6 col-md-12">
                                            <label for="phone" class="custom-input-label">Phone Number</label>
                                            <div class="d-flex position-relative input-box">
                                                <select id="countrySelect" class="country_code" style="font-size: 14px;"></select>
                                                <input value="<?=old('phone')?>" type="tel" id="phone" name="phone" style="border-radius:0 15px 15px 0" placeholder="Phone Number" class="custom-input pl-2" />
                                            </div>
                                            <div class="text-danger backend-msg">
                                                @error('phone')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12">
                                            <label for="email" class="custom-input-label">Email</label>
                                            <div class="d-flex position-relative input-box">
                                                <div class="d-flex align-items-center justify-content-center p-l-10 p-r-10 position-absolute h-100 px-2 icon-box"><img src="{{asset('assets/images/icons/auth/iconamoon_email-thin.svg')}}" width="15" alt=""></div>
                                                <input value="<?=old('email')?>" type="email" id="email"name="email"placeholder="Email"class="custom-input" />
                                            </div>
                                            <div class="text-danger backend-msg">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                            <label for="account_type" class="custom-input-label">Account Type</label>
                                            <div class="select-box">
                                                <select id="account_type" name="account_type" class="custom-select">
                                                    <option value="">Choose one...</option>
                                                    @foreach($accounts as $account)
                                                        <option value="{{$account->name}}" <?= old('account_type') == $account->name ? 'selected' : ''?>>{{$account->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="text-danger backend-msg">
                                                @error('account_type')
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
                                            <input value="<?=old('password')?>" type="password" id="password" name="password" placeholder="Enter Password" class="custom-input" />
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
                                    <input type="hidden" id="country" value="" name="country">

                                    <p style="font-size:14px;color:#1E1E1E;" class="mt-3">By clicking the Sign Up button below, you agree to ZIga Afrika's 
                                        <a href="" style="font-weight:600" class="custom-text-secondary">terms of acceptable use.</a>
                                    </p>

                                    <div class="d-flex justify-content-center mt-4">
                                        <button type="button" class="custom-btn fs-4 mb-2 reg-btn" onclick="validateRegForm()">
                                            Sign Up 
                                            <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="ml-2" alt="">
                                        </button>
                                    </div>
                                    <h6 style="font-size:14px;" class="mt-2 text-center">Already have an account? <a href="{{route('login')}}" class="custom-text-secondary">Sign in</a></h6>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

        const validateRegForm = () => {
            document.querySelectorAll(".backend-msg").forEach(function(field, index){
                field.innerHTML = '';
            })
            const submitBtn = document.querySelector(".reg-btn");
            const oldBtnHTML = submitBtn.innerHTML;
            setBtnLoading(submitBtn);

            const validation = runValidation([
                {
                    id:"email",
                    rules: {'required':true, 'email':true}
                },
                {
                    id:"firstname",
                    rules: {'required':true}
                },
                {
                    id:"lastname",
                    rules: {'required':true}
                },
                {
                    id:"account_type",
                    rules: {'required':true}
                },
                {
                    id:"phone",
                    rules: {'required':true, max_length:14, min_length:11}
                },
                {
                    id:'password',
                    rules:{'required':true, min_length:8, has_special_character:true, must_have_number:true}
                },
                {
                    id:'password',
                    rules:{'required':true, min_length:8, has_special_character:true, must_have_number:true}
                },
                
            ]);

            if(validation === true){
                submitRegForm();
                // setBtnNotLoading(submitBtn, oldBtnHTML)
            }else{
                setBtnNotLoading(submitBtn, oldBtnHTML)
            }
        }

        const submitRegForm = () => {
            document.querySelector("#signup").submit();
        }
    
        document.getElementById('countrySelect').addEventListener('change', function() {
            var countryCode = this.value;
            //var countryText = this.options[this.selectedIndex].text; // Get the selected text
            var selectedOption = this.options[this.selectedIndex];
            var optionInfo = selectedOption.getAttribute('data-country');

            var phoneNumberInput = document.getElementById('phone');
            phoneNumberInput.value = countryCode;
            phoneNumberInput.focus(); // Optionally, focus on the input field after selecting the country
            document.getElementById("country").value = optionInfo; // Set the country text in the input field with id "country"
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                        <option data-country="${country.name.common}" selected value="${country.idd.root.concat(country.idd.suffixes[0])}">
                            ${country.name.common} (${country.idd.root.concat(country.idd.suffixes[0])})
                        </option>
                    ` : `
                        <option data-country="${country.name.common}" value="${country.idd.root.concat(country.idd.suffixes[0])}">
                            ${country.name.common} (${country.idd.root.concat(country.idd.suffixes[0])})
                        </option>
                    `;
                }
                if(country.name.common == "Nigeria"){
                    var phoneNumberInput = document.getElementById('phone');
                    phoneNumberInput.value = country.idd.root.concat(country.idd.suffixes[0]);
                    $("#country").val(country.name.common)
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