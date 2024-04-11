@include("customer.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Dashboard</h5>
                        <div class="d-flex">
                            <a href="{{url('/users')}}" class="btn btn-primary mr-2">
                                <img src="{{asset('assets/images/icons/user-plus-light.svg')}}" />
                                Book Shipment
                            </a>
                            <a href="{{url('/users')}}" class="btn btn-primary">
                                <img src="{{asset('assets/images/icons/user-plus-light.svg')}}" />
                                Track Shipment
                            </a>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-xl-4 col-lg-4 col-md-4" style="height:161px">
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
                        <div class="col-xl-4 col-lg-4 col-md-4 mt-xl-0 mt-lg-0 mt-md-0 mt-3" style="height:161px">
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
                                    <h2 class="balance"></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-0">
                                    <div class="p-3 d-flex flex-wrap justify-content-between align-items-center mb-4">
                                        <h5 class="card-title fw-semibold">Recent Shipments</h5>
                                        <div class="d-flex flex-wrap">
                                            <a class="btn btn-light mr-2 mb-3 period" data-filter="today">
                                                Today
                                            </a>
                                            <a class="btn btn-light mr-2 mb-3 period" data-filter="week">
                                                This Week
                                            </a>
                                            <a class="btn btn-light mr-2 mb-3 period" data-filter="month">
                                                This Month
                                            </a>
                                            <a class="btn btn-light mr-2 mb-3 period" data-filter="year">
                                                This Year
                                            </a>
                                            <a class="btn" href="/">
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
    var userToken = localStorage.getItem('token');

    function fetchWallet(){
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                Authorization: "Bearer "+ userToken
            }
        };
        axios.get(`${baseUrl}/api/v1/user/dashboard-data`, config)
        .then((res) => {
            let results = res.data.results;
            $(".balance").eq(0).text("₦"+parseInt(results?.wallet.balance).toLocaleString());
            $(".balance").eq(0).next("span.text-sec").text("Last updated: "+results?.wallet.updated_at);
            $(".balance").eq(1).text("₦"+parseInt(results?.totalCredit).toLocaleString());
            $(".balance").eq(1).next("span.text-sec").text("Last updated: "+results?.wallet.updated_at);
            //$(".balance").eq(2).text("₦"+parseInt(325000).toLocaleString());
        });
    };
    fetchWallet();

    const status = {
        pending: "bg-warning",
        delivered: "bg-success",
        failed: "bg-danger"
    };

    const rowColors = {
        pending: "#ffffff",
        delivered: "#233E830D",
        failed: "#233E830D"
    };

    function fetchAllShipments(){
        //axios.get(`${baseUrl}/api/user/shipments`)
        axios.get(`${baseUrl}/api`)
        .then((res) => {
            //let transactions = res.data.results.slice(0, 10);
            let shipments = [
                {id: 1, status: "pending"},
                {id: 1, status: "delivered"},
                {id: 1, status: "pending"},
                {id: 1, status: "pending"},
                {id: 1, status: "delivered"},
                {id: 1, status: "delivered"},
                {id: 1, status: "pending"},
                {id: 1, status: "pending"},
                {id: 1, status: "delivered"}
            ].slice(0, 10);

            $(".shipments-table tbody").empty();
            shipments.forEach(function(shipment, index){
                $(".shipments-table tbody").append(`
                    <tr style="background-color:${rowColors[shipment.status]}">
                        <td class="border-bottom-0">
                            <span class="fw-normal mb-0">${index + 1}.</span>
                        </td>
                        <td class="border-bottom-0">
                            <span class="fw-normal mb-1">154JKL-MNY</span>                        
                        </td>
                        <td class="border-bottom-0">
                            <span class="mb-0 fw-normal">12/03/24</span>
                        </td>
                        <td class="border-bottom-0">
                            <span class="mb-0 fw-normal">15 Peter Odili Road, Port Harcourt</span>
                        </td>
                        <td class="border-bottom-0">
                            <span class="fw-normal mb-0">12 Aminu Kano Road, Kano</span>
                        </td>
                        <td class="border-bottom-0">
                            <div class="d-flex align-items-center gap-2">
                                <span class="py-2 badge rounded-3 fw-semibold ${status[shipment.status]}">
                                ${shipment.status.charAt(0).toUpperCase() + shipment.status.slice(1)}
                                </span>
                            </div>
                        </td>
                    </tr> 
                `);
            })
        });
    };
    fetchAllShipments();

    $(".reload-wallet").on("click", function(event){
        event.preventDefault();
        let type = $(this).data("type");
        alert(type);
    });

    $(".period").on("click", function(event){
        event.preventDefault();
        $(this).html(`<img src="{{asset('assets/images/loader.gif')}}" id="loader-gif">`);
        $(".period").removeClass("btn-light-active");
        $(this).addClass("btn-light-active");
        let filter = $(this).data("filter");
        //$(".shipments-table tbody").empty();
    });
</script>
@include("customer.layouts.footer")