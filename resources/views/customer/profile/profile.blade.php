@include("customer.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Profile</h5>
                        <?php 
                            if($user->is_verified):
                        ?>    
                            <div class="fw-semibold bg-white py-2 px-4 rounded-pill d-flex align-items-center">
                                <img src="{{asset('assets/images/icons/auth/success-icon.svg')}}" width="30" height="30" class="mr-2" />
                                KYC Completed!
                            </div>
                        <?php 
                            else: 
                        ?>
                            <div class="fw-semibold bg-white py-2 px-4 rounded-pill d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center mr-2" style="background-color:#FB04044D;height:30px;width:30px">
                                    <img src="{{asset('assets/images/icons/auth/warning-icon.svg')}}" width="25" height="25" />
                                </div>
                                Update KYC!
                            </div>
                        <?php 
                            endif;
                        ?>
                    </div>

                    <div class="d-flex mt-4">
                        <a class="w-50 border-0 custom-tab-btn custom-tab-btn-active" 
                            style="border-radius:15px 0px 0px 15px;"
                            data-bs-toggle="collapse" 
                            href="#collapseExample1" 
                            role="button" 
                            aria-expanded="false" 
                            aria-controls="collapseExample1">
                            Bio Details
                        </a>
                        <button 
                            class="w-50 border-0 custom-tab-btn" 
                            style="border-radius:0px 15px 15px 0px;"
                            type="button" data-bs-toggle="collapse" 
                            data-bs-target="#collapseExample2" 
                            aria-expanded="false" 
                            aria-controls="collapseExample2">
                            Know Your Customer(KYC)
                        </button>
                    </div>

                    <div class="row mt-4 collapse show" id="collapseExample1">
                        <div class="col-12 d-flex align-items-stretch">
                            <div class="card w-100 px-3">
                                <div class="card-body p-0">
                                    <div class="row justify-content-between">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 pt-3">
                                            <div class="d-flex flex-column align-items-center">
                                                <?php 
                                                    if($user->photo):
                                                ?>        
                                                    <div class="position-relative">
                                                        <img style="object-fit:cover;" class="rounded-circle photo" src="<?=$user?->photo?>" width="180" height="180">
                                                        <form id="update-photo" action="/api/v1/events" method="POST" enctype="multipart/form-data">
                                                            <label type="button" for="image" class="position-absolute rounded-circle d-flex align-items-center justify-content-center" style="height:40px;width:40px;top:110px;right:-15px;background-color:#FEF5E8">
                                                                <img src="{{asset('assets/images/icons/ph_camera-light.svg')}}" width="20" height="20">
                                                                <input type="file" class="form-control d-none" name="image" id="image">
                                                            </label>
                                                        </form>
                                                    </div>
                                                <?php 
                                                    else:
                                                ?>
                                                    <div class="position-relative rounded-circle d-flex align-items-center justify-content-center" 
                                                    style="border:2px solid #233E834D;height:180px;width:180px;background-color:#FCD8A5">
                                                        <img class="photo rounded-circle" src="{{asset('assets/images/icons/profile/user-profile.svg')}}" style="max-width:180px;max-height:180px">
                                                        <form id="update-photo" action="/api/v1/events" method="POST" enctype="multipart/form-data">
                                                            <label type="button" for="image" class="position-absolute rounded-circle d-flex align-items-center justify-content-center" style="height:40px;width:40px;top:110px;right:-15px;background-color:#FEF5E8">
                                                                <img src="{{asset('assets/images/icons/ph_camera-light.svg')}}" width="20" height="20">
                                                                <input type="file" class="form-control d-none" name="image" id="image">
                                                            </label>
                                                        </form>
                                                    </div>
                                                <?php
                                                    endif;
                                                ?>
                                                <h5 class="mt-3"><?=$user->firstname." ".$user->lastname?></h5>
                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 pt-3 pb-5" style="border-left: 1px solid #1E1E1E33;">
                                            <h5 class="mt-3 fw-semibold">Bio Details</h5>
                                            <div class="d-flex flex-column flex-md-row">
                                                <div class="w-100 mr-2">
                                                    <label for="email" class="custom-input-label">Address</label>
                                                    <input 
                                                    type="text" 
                                                    id="address"
                                                    value="<?=$user->address?>"
                                                    name="address"
                                                    placeholder="House Address"
                                                    class="custom-input" />
                                                    <span class="error"> </span>
                                                </div>
                                                <div class="w-100 mt-md-0 mt-3 mr-2">
                                                    <label for="email" class="custom-input-label">Phone</label>
                                                    <input 
                                                    type="text" 
                                                    id="phone"
                                                    value="<?=$user->phone?>"
                                                    name="phone"
                                                    placeholder="Phone Number"
                                                    class="custom-input" />
                                                    <span class="error"> </span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column flex-md-row mt-3">
                                                <div class="w-100 mr-2">
                                                    <label for="email" class="custom-input-label">Email</label>
                                                    <input 
                                                    type="email" 
                                                    id="email"
                                                    value="<?=$user->email?>"
                                                    name="email"
                                                    placeholder="Email Address"
                                                    class="custom-input" readonly/>
                                                    <span class="error"> </span>
                                                </div>
                                                <div class="w-100 mt-md-0 mt-3 mr-2">
                                                    <label for="email" class="custom-input-label">UserType</label>
                                                    <input 
                                                    type="text" 
                                                    id="account_type"
                                                    value="<?=$user->account->name?>"
                                                    name="account_type"
                                                    placeholder="Account Type"
                                                    class="custom-input" readonly/>
                                                    <span class="error"> </span>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <button 
                                                type="button"
                                                data-toggle="modal" data-target="#changePasswordModal"
                                                class="custom-btn fs-4 fw-bold">
                                                <img src="{{asset('assets/images/icons/auth/mdi_password-outline.svg')}}" width="20" class="mr-2" alt="">
                                                Change Password
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 collapse" id="collapseExample2">
                        <div class="col-12 d-flex align-items-stretch">
                            <div class="card w-100 px-3 pb-5 pt-3">
                                <div class="card-body p-0">
                                    <h4 style="font-weight:700" class="text-center">KYC</h4>
                                    <form id="update-kyc" action="/api/v1/" method="POST" enctype="multipart/form-data">
                                        <div class="row justify-content-around">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-5 mt-3">
                                                <h5 style="color:#1E1E1E80">Utility Bill</h5>
                                                @include('customer.profile.components.utility')
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-5 mt-3">
                                                <h5 style="color:#1E1E1E80">Government ID</h5>
                                                @include('customer.profile.components.govt_id')
                                            </div>
                                        </div>

                                        <div class="row justify-content-around">
                                            <?php 
                                                if($user->account->name != "personal"):
                                            ?>
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-5 mt-2">
                                                    <h5 style="color:#1E1E1E80">Business CAC(for businesses only)</h5>
                                                    @include('customer.profile.components.business_cac')
                                                </div>
                                                <?php
                                                endif;
                                            ?>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-5 mt-2">
                                                <h5 style="color:#1E1E1E80">ID Number</h5>
                                                <div class="w-100">
                                                    <input 
                                                    type="text" 
                                                    id="id_number"
                                                    name="id_number"
                                                    value="<?=$user?->profile->id_number?>"
                                                    placeholder="Enter ID number of uploaded ID card"
                                                    class="custom-input" />
                                                </div>
                                                <?php if(is_null($user?->profile->id_number)):?>
                                                <button 
                                                    class="custom-btn mt-3"
                                                    id="save_id_number"
                                                    type="button">
                                                    Save
                                                </button>
                                                <?php else: ?>
                                                    <button 
                                                    disabled
                                                    class="btn btn-light mt-3"
                                                    type="button">
                                                        Save
                                                    </button>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @include('customer.modals.image-preview-modal')
                    @include('customer.modals.change-password-modal')
                </div>
            </div>
            <!--  End of Row 1 -->
        </div>
    </div>
</div>
<script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/slim.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

<script src="{{asset('assets/libs/axios/axios.js')}}"></script>
<script src="{{asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/dist/simplebar.js')}}"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    let token = $("meta[name='csrf-token']").attr("content");
    let baseUrl = $("meta[name='base-url']").attr("content");
    var userToken = localStorage.getItem('token');

    //Preview the images before uploading
    $("#image").change(function(event){
        let payload = {
            photo: $(this)[0].files[0]
        };
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "multipart/form-data",
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                "X-Requested-With": "XMLHttpRequest"
            }
        };
        axios.post(`${baseUrl}/user`, payload, config)
        .then((res) => {
            let data = res.data.results;
            $(".photo").attr("src", data.photo);
        });
    });

    //Preview the images before uploading
    $("#utility_bill").change(function(event){
        $("#imagePreviewBox").empty();
        var inputs = event.target.files;
        var filesAmount = inputs.length;
        // Loop through each file
        for(var i = 0; i < filesAmount; i++) {
            var reader = new FileReader();
            // Convert each image file to a string
            reader.readAsDataURL(inputs[i]);
            // FileReader will emit the load event when the dataURL is ready
            // Access the string using reader.result inside the callback function
            reader.onload = function(e){
                $("#imagePreviewBox").append(`
                    <img src=${e.target.result} 
                    height="250" 
                    class="w-50 kyc-img-preview" 
                    style="border:1px solid #233E8366;border-radius:20px;object-fit:cover;">
                `);
                $("#imagePreviewModal").modal("show");
                $(".upload-kyc-btn").data("imgEl", "utility_bill");
            }
        }
    });

    //Preview the images before uploading
    $("#business_cac").change(function(event){
        $("#imagePreviewBox").empty();
        var inputs = event.target.files;
        var filesAmount = inputs.length;
        // Loop through each file
        for(var i = 0; i < filesAmount; i++) {
            var reader = new FileReader();
            // Convert each image file to a string
            reader.readAsDataURL(inputs[i]);
            // FileReader will emit the load event when the dataURL is ready
            // Access the string using reader.result inside the callback function
            reader.onload = function(e){
                $("#imagePreviewModal").modal("show");
                $(".upload-kyc-btn").data("imgEl", "business_cac");
                $("#imagePreviewBox").append(`
                    <img src=${e.target.result} 
                    height="250" 
                    class="w-50 kyc-img-preview" 
                    style="border:1px solid #233E8366;border-radius:20px;object-fit:cover;">
                `);
            }
        }
    });

    //Preview the images before uploading
    $("#valid_govt_id").change(function(event){
        $("#imagePreviewBox").empty();
        var inputs = event.target.files;
        var filesAmount = inputs.length;
        // Loop through each file
        for(var i = 0; i < filesAmount; i++) {
            var reader = new FileReader();
            // Convert each image file to a string
            reader.readAsDataURL(inputs[i]);
            // FileReader will emit the load event when the dataURL is ready
            // Access the string using reader.result inside the callback function
            reader.onload = function(e){
                $("#imagePreviewModal").modal("show");
                $(".upload-kyc-btn").data("imgEl", "valid_govt_id");
                $("#imagePreviewBox").append(`
                    <img src=${e.target.result} 
                    height="250" 
                    class="w-50 kyc-img-preview" 
                    style="border:1px solid #233E8366;border-radius:20px;object-fit:cover;">
                `);
            }
        }
    });

    $(".upload-kyc-btn").on('click', function () {
        let btn = $(this);
        btn.html(`<img src="{{asset('assets/images/loader.gif')}}" id="loader-gif">`);
        btn.attr("disabled", true);
        let element = $(this).data("imgEl");
        let payload = {
            [element]: $("#"+element)[0].files[0]
        };
        // Append loader immediately
        setTimeout(() => {
            const config = {
                headers: {
                    Accept: "application/json",
                    "Content-Type": "multipart/form-data",
                    "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                    "X-Requested-With": "XMLHttpRequest"
                }
            };
            axios.post(`${baseUrl}/user`, payload, config)
            .then((res) => {
                let data = res.data.results;
                console.log(data);
                btn.attr("disabled", false).text("Upload File");
                $("#imagePreviewModal").modal("hide");
                window.location.href = "/profile";
            });
        }, 100); // Delay submission by 100 milliseconds
    });

    $("#save_id_number").on('click', function () {
        let btn = $(this);
        btn.html(`<img src="{{asset('assets/images/loader.gif')}}" id="loader-gif">`);
        btn.attr("disabled", true);
        let payload = {
            id_number: $("#id_number").val()
        };
        // Append loader immediately
        setTimeout(() => {
            const config = {
                headers: {
                    Accept: "application/json",
                    "Content-Type": "multipart/form-data",
                    "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                    "X-Requested-With": "XMLHttpRequest"
                }
            };
            axios.post(`${baseUrl}/user`, payload, config)
            .then((res) => {
                let data = res.data.results;
                console.log(data);
                btn.attr("disabled", false).text("Save");
                window.location.href = "/profile";
            });
        }, 100); // Delay submission by 100 milliseconds
    });

    $("#discard-img").on('click', function () {
        //event.preventDefault();
        $("#imagePreviewBox").empty();
        $(".upload-kyc-btn").data("imgEl", "");
        $("#imagePreviewModal").modal("hide");
        //Delete the file in the FileReader
        /*const filteredFiles = new DataTransfer();
        const fileName = $(this).data("name");
        let files = $("#images").prop("files");
        
        for(var i=0; i<files.length; i++){
            if(files[i].name !== fileName){
                filteredFiles.items.add(files[i]); //here you exclude the file. thus removing it.
            }
        }

        //update the input with the new filelist;
        $("#images").prop("files", filteredFiles.files);  //Assign the updates list*/
    });
</script>
<script>
    $(document).ready(function() {
        $('.collapse').on('show.bs.collapse', function () {
            $('.collapse').not(this).collapse('hide');
        });

        $('.custom-tab-btn').on('click', function () {
            $(".custom-tab-btn").removeClass("custom-tab-btn-active");
            $(this).addClass("custom-tab-btn-active");
        });
    });
</script>
<script>
    $("#change-password").on("submit", function(event){
        event.preventDefault();
        const form = event.target;
        const url = form.action;
        let btn = $(this).find("button[type='submit']");
        btn.html(`<img src="{{asset('assets/images/loader.gif')}}" id="loader-gif">`);
        btn.attr("disabled", true);
        let inputs = {
            current_password: $("#change-password input[name='current_password']").val(),
            password: $("#change-password input[name='password']").val(),
            confirm_password: $("#change-password input[name='confirm_password']").val(),
        }

        $("#change-password input[name='current_password']").css("borderColor", "transparent");
        $("#change-password input[name='password']").css("borderColor", "transparent");
        $("#change-password input[name='confirm_password']").css("borderColor", "transparent");
        $('.error').text('');
        $('#change-password .message').text('');
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
                $('#change-password .message').css("color", "green").text(message);
                btn.attr("disabled", false).text("Change Password");
                //window.location.href = "<?=url('/logout')?>";
            })
            .catch(function(error){
                let errors = error.response.data.error;
                if(errors.current_password){
                    $('#change-password .error').eq(0).text(errors.current_password);
                    $("#change-password input[name='current_password']").css("border", "1px solid #FA150A");
                }
                if(errors.password){
                    $('#change-password .error').eq(1).text(errors.password);
                    $("#change-password input[name='password']").css("border", "1px solid #FA150A");
                }
                if(errors.confirm_password){
                    $('#change-password .error').eq(2).text(errors.confirm_password);
                    $("#change-password input[name='confirm_password']").css("border", "1px solid #FA150A");
                }

                switch(error.response.status){
                    case 400:
                        $("#change-password .message").text(error.response.data.message)
                    break;
                    case 401:
                        $("#change-password .message").text(error.response.data.message);
                    break;
                }
                btn.attr("disabled", false).text("Change Password");
            });
        }, 100); // Delay submission by 100 milliseconds
    });
</script>
@include("customer.layouts.footer")