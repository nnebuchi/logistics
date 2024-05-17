@include("customer.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Dashboard</h5>
                        <div class="d-flex">
                            <a href="{{url('/shipping/create')}}" class="d-flex align-items-center btn btn-primary mr-2">
                                <img src="{{asset('assets/images/icons/plus.svg')}}" class="mr-1" width="20" height="20" />
                                Book Shipment
                            </a>
                            <a href="{{url('/shipping/track')}}" class="d-flex align-items-center btn btn-primary">
                                <img src="{{asset('assets/images/icons/track.svg')}}" class="mr-1" width="20" height="20" />
                                Track Shipment
                            </a>
                        </div>
                    </div>

                    @auth
                        <div class="mt-2">
                            @if(session('admin_id'))
                                <a href="{{ route('impersonate.leave') }}" class="btn btn-primary">
                                    Leave Impersonation
                                </a>
                            @endif
                        </div>
                    @endauth

                    <div class="row mt-3">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6" style="height:161px">
                            <div class="h-100 pl-3 pt-3 bg-white position-relative d-flex align-items-center justify-content-between" style="border-radius:20px;">
                                <div class="">
                                    <div class="mb-2 reload-wallet" type="button" data-type="balance">
                                        <img src="{{asset('assets/images/icons/reload.svg')}}">
                                    </div>
                                    <span>Curent Wallet Balance</span>
                                    <h2 class="balance"></h2>
                                    <span class="text-sec"></span>
                                    <div class="position-absolute d-flex align-items-center" style="top:0;right:0;height:100%">
                                        <img height="120" src="{{asset('assets/images/icons/ellipse7.svg')}}">
                                    </div>
                                </div>
                                <div class=" pr-2">
                                    <img src="{{asset('assets/images/icons/wallet2.svg')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mt-xl-0 mt-lg-0 mt-md-0 mt-sm-0 mt-3" style="height:161px">
                            <div class="h-100 pl-3 pt-3 bg-white position-relative d-flex align-items-center justify-content-between" style="border-radius:20px;">
                                <div class="">
                                    <div class="mb-2 reload-wallet" type="button" data-type="all-funding">
                                        <img src="{{asset('assets/images/icons/reload.svg')}}">
                                    </div>
                                    <span>All-time Funding</span>
                                    <h2 class="balance"></h2>
                                    <span class="text-sec"></span>
                                    <div class="position-absolute d-flex align-items-center" style="top:0;right:0;height:100%">
                                        <img height="120" src="{{asset('assets/images/icons/ellipse7.svg')}}">
                                    </div>
                                </div>
                                <div class=" pr-2">
                                    <img src="{{asset('assets/images/icons/wallet2.svg')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 mt-xl-0 mt-lg-0 mt-md-0 mt-3" style="height:161px">
                            <div class="h-100 pl-3 pt-3 bg-white d-flex align-items-center justify-content-between" style="border-radius:20px;">
                                <div class="">
                                    <span>Wallet Account Details</span>
                                    <h5 style="color:#1E1E1E66">Account Name: <span class="" style="color:black">John Doe</span></h5>
                                    <h5 style="color:#1E1E1E66">Account Number: <span class=""  style="color:black">2044556248</span></h5>
                                    <h5 style="color:#1E1E1E66">Bank Name: <span class=""  style="color:black">Ziga Bank</span></h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-0">
                                    <div class="p-3 d-flex flex-wrap justify-content-between align-items-center mb-0">
                                        <h5 class="card-title fw-semibold">Recent Shippings</h5>
                                        <div class="d-flex flex-wrap">
                                            <button type="button" class="btn btn-light mr-2 mb-3 period" data-value="today">
                                                Today
                                            </button>
                                            <button type="button" class="btn btn-light mr-2 mb-3 period" data-value="week">
                                                This Week
                                            </button>
                                            <button type="button" class="btn btn-light mr-2 mb-3 period" data-value="month">
                                                This Month
                                            </button>
                                            <button type="button" class="btn btn-light mr-2 mb-3 period" data-value="year">
                                                This Year
                                            </button>
                                            <a class="btn" href="/shippings">
                                                See All
                                                <img src="{{asset('assets/images/icons/move-right.svg')}}" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="shipments-table table text-nowrap mb-0 align-middle">
                                            <thead class="text-dark fs-4">
                                                <tr>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">S/N</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Shipping ID</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Date</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Pick Up</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Destination</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Status</h6>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>   
                                                                      
                                            </tbody>
                                        </table>
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

    function fetchWallet(){
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                "X-Requested-With": "XMLHttpRequest"
            }
        };
        axios.get(`${baseUrl}/user/${<?=$user->id?>}/wallet`, config)
        .then((res) => {
            let results = res.data.results;
            $(".balance").eq(0).text("₦"+parseInt(results?.wallet.balance).toLocaleString());
            $(".balance").eq(0).next("span.text-sec").text("Last updated: "+results?.wallet.updated_at);
            $(".balance").eq(1).text("₦"+parseInt(results?.totalCredit).toLocaleString());
            $(".balance").eq(1).next("span.text-sec").text("Last updated: "+results?.wallet.updated_at);
        });
    };
    fetchWallet();

    const status = {
        pending: "custom-bg-warning",
        confirmed: "custom-bg-success",
        failed: "custom-bg-danger"
    };

    function getShipments(){
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                "X-Requested-With": "XMLHttpRequest"
            }
        };
        axios.get(`${baseUrl}/user/${<?=$user->id?>}/shipments`, config)
        .then((res) => {
            let shipments = res.data.results.slice(0, 5);
            renderData(shipments);
        });
    };
    getShipments();

    function renderData(shipments){
        $(".shipments-table tbody").empty();
        if(shipments.length == 0){
            $(".shipments-table tbody").append(`
                <tr class="">
                    <td scope="row">No data available...</td>
                </tr> 
            `);
        }else{
            shipments.forEach(function(shipment, index){
                $(".shipments-table tbody").append(`
                    <tr style="cursor:pointer">
                        <td class="">${index + 1}.</td>
                        <td class="">${shipment.external_shipment_id}</td>
                        <td class="">${shipment.pickup_date ?? ""}</td>
                        <td class="">${shipment.address_from.line1.substring(0, 15)+"..."}</td>
                        <td class="">${shipment.address_to.line1.substring(0, 15)+"..."}</td>
                        <td class="">
                            <span class="py-2 badge rounded-2 fw-semibold ${status[shipment.status]}">
                            ${shipment.status.charAt(0).toUpperCase() + shipment.status.slice(1)}
                            </span>
                        </td>
                    </tr> 
                `);
            });
        }
    }

    $(".reload-wallet").on("click", function(event){
        event.preventDefault();
        let type = $(this).data("type");
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                "X-Requested-With": "XMLHttpRequest"
            }
        };
        axios.get(`${baseUrl}/user/${<?=$user->id?>}/wallet`, config)
        .then((res) => {
            let results = res.data.results;
            switch(type){
                case "balance":
                    $(".balance").eq(0).text("₦"+parseInt(results?.wallet.balance).toLocaleString());
                    $(".balance").eq(0).next("span.text-sec").text("Last updated: "+results?.wallet.updated_at);
                break;
                case "all-funding":
                    $(".balance").eq(1).text("₦"+parseInt(results?.totalCredit).toLocaleString());
                    $(".balance").eq(1).next("span.text-sec").text("Last updated: "+results?.wallet.updated_at);
                break;   
            }
        });
    });

    $(".period").on("click", function(event){
        event.preventDefault();
        $(".period").prop("disabled", true);
        let text = $(this).text();
        let value = $(this).data("value");
        $(this).html(`<img src="{{asset('assets/images/loader.gif')}}" id="loader-gif">`);
        $(".period").removeClass("btn-light-active");
        $(this).addClass("btn-light-active");
        // After completing your action, enable all elements with class "period" again
        setTimeout(() => {
            const config = {
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                    "X-Requested-With": "XMLHttpRequest"
                }
            };
            axios.get(`${baseUrl}/user/${<?=$user->id?>}/shipments?period=${value}`, config)
            .then((res) => {
                let shipments = res.data.results.slice(0, 5);
                $(this).text(text);
                $(".period").prop("disabled", false); 
                $(".shipments-table tbody").empty();
                renderData(shipments);
            });
        }, 2000);
    });
</script>
@include("customer.layouts.footer")