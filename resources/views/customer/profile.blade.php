@include("customer.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Profile</h5>
                        <div class="fw-semibold bg-white py-2 px-4 rounded-pill d-flex align-items-center">
                            <img src="{{asset('assets/images/icons/auth/success-icon.svg')}}" width="30" height="30" class="mr-2" />
                            KYC Completed!
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-0">
                                    <div class="row justify-content-between">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 pt-3">
                                            <div class="d-flex flex-column align-items-center">        
                                                <div class="position-relative">
                                                    <img class="rounded-circle" src="{{asset('assets/images/profile/s5.jpg')}}" width="180" height="180">
                                                    <div class="position-absolute rounded-circle bg-dark d-flex align-items-center justify-content-center" style="height:40px;width:40px;top:110px;right:-15px">
                                                        <img src="{{asset('assets/images/profile/s5.jpg')}}" width="20" height="20">
                                                    </div>
                                                </div>
                                                <h5 class="mt-3"><?=$user->firstname." ".$user->lastname?></h5>
                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 pt-3 pb-5" style="border-left: 1px solid #1E1E1E33;">
                                            <h5 class="mt-3 fw-semibold">Bio Details</h5>
                                            <div class="d-flex flex-column flex-md-row pr-3">
                                                <div class="w-100">
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
                                                <div class="w-100 mt-md-0 mt-3">
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
                                            <div class="d-flex flex-column flex-md-row pr-3 mt-3">
                                                <div class="w-100 pr-2">
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
                                                <div class="w-100 mt-md-0 mt-3">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('customer.modals.broadcast-modal')
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
    var authToken = localStorage.getItem('token');

    function fetchWallet(){
        axios.get(`${baseUrl}/api/statistics`)
        axios.get(`${baseUrl}/api`)
        .then((res) => {
            let data = res.data.results;
            $(".balance").eq(0).text("₦"+parseInt(75000).toLocaleString());
            $(".balance").eq(1).text("₦"+parseInt(350000).toLocaleString());
            $(".balance").eq(2).text("₦"+parseInt(325000).toLocaleString());
        });
    };
    fetchWallet();

    $(".reload-wallet").on("click", function(event){
        event.preventDefault();
        let type = $(this).data("type");
        alert(type);
    });
</script>
@include("customer.layouts.footer")