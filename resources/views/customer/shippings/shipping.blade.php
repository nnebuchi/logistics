@include("customer.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Shipping</h5>
                        <div class="d-flex">
                            <a href="{{url('/shipping/create')}}" class="btn btn-primary mr-2">
                                <img src="{{asset('assets/images/icons/user-plus-light.svg')}}" />
                                Book Shipment
                            </a>
                            <a href="{{url('/shipping/track')}}" class="btn btn-primary">
                                <img src="{{asset('assets/images/icons/user-plus-light.svg')}}" />
                                Track Shipment
                            </a>
                        </div>
                    </div>

                    <div class="row mt-3 justify-content-center">
                        <div class="col-xl-3 col-lg-3 col-md-5 col-sm-6" style="height:161px">
                            <div class="h-100 pl-3 pt-3 bg-white position-relative d-flex align-items-center justify-content-between" style="border-radius:20px;">
                                <div class="">
                                    <span>Total Shippings</span>
                                    <h2 class="stats"></h2>
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
                        <div class="col-xl-3 col-lg-3 col-md-5 col-sm-6 mt-xl-0 mt-lg-0 mt-md-0 mt-sm-0 mt-3" style="height:161px">
                            <div class="h-100 pl-3 pt-3 bg-white position-relative d-flex align-items-center justify-content-between" style="border-radius:20px;">
                                <div class="">
                                    <span>Delivered</span>
                                    <h2 class="stats"></h2>
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
                        <div class="col-xl-3 col-lg-3 col-md-5 col-sm-6 mt-xl-0 mt-lg-0 mt-md-3 mt-3" style="height:161px">
                            <div class="h-100 pl-3 pt-3 bg-white d-flex align-items-center justify-content-between" style="border-radius:20px;">
                                <div class="">
                                    <span>In-Transit</span>
                                    <h2 class="stats"></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-5 col-sm-6 mt-xl-0 mt-lg-0 mt-md-3 mt-3" style="height:161px">
                            <div class="h-100 pl-3 pt-3 bg-white d-flex align-items-center justify-content-between" style="border-radius:20px;">
                                <div class="">
                                    <span>Cancelled</span>
                                    <h2 class="stats"></h2>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-5">
                        <div class="col-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-0">
                                    <div class="p-3 d-flex flex-wrap justify-content-between align-items-center mb-4">
                                        <h5 class="card-title fw-semibold">All Shippings</h5>
                                        <div class="d-flex flex-wrap">
                                            
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

                    <div class="d-flex justify-content-center mt-2">
                        <div class="mr-3">
                            <button 
                            type="button"
                            disabled
                            data-page=""
                            class="btn btn-light fs-4 fw-bold paginate">
                            <img src="{{asset('assets/images/icons/auth/cil_arrow-left.svg')}}" width="20" class="mr-2" alt="">
                            Previous
                            </button>
                        </div>
                        <div class="">
                            <button 
                            type="button"
                            data-page=""
                            class="custom-btn fs-4 fw-bold paginate">
                            Next
                            <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                            </button>
                        </div>
                    </div>
                    <!--  Pagination Starts -->
                    <div class="my-2 pl-2">
                        Showing
                        <span class="entries fw-semibold">. </span> to
                        <span class="entries fw-semibold">. </span> of
                        <span class="entries fw-semibold">. </span>
                        shipments
                    </div>
                    <!--  Pagination Ends -->


                    @include('customer.modals.broadcast-modal')
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
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.all.js')}}"></script>
<script>
    let token = $("meta[name='csrf-token']").attr("content");
    let baseUrl = $("meta[name='base-url']").attr("content");
    var authToken = localStorage.getItem('token');

    function getStats(stats){
        $(".stats").eq(0).text(stats.total.toLocaleString());
        $(".stats").eq(1).text(stats.delivered.toLocaleString());
        $(".stats").eq(2).text(stats["in-transit"].toLocaleString());
        $(".stats").eq(3).text(stats.cancelled.toLocaleString());
    };
    getStats(@json($stats));

    const status = {
        draft: "custom-bg-warning",
        confirmed: "custom-bg-success",
        failed: "custom-bg-danger"
    };

    function getIndex(per_page, current_page, index)
    {
        if(current_page == 1){
            return index + 1
        }else{
            return (per_page * current_page) - per_page + 1 + index
        }
    }

    const per_page = 10;
    let current_page = 1;
    let data = [];
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
            data = res.data.results;
            renderData();
        });
    };
    getShipments();

    function renderData(){
        $(".shipments-table tbody").empty();
        const startIndex = (current_page - 1) * per_page;
        const endIndex = startIndex + per_page;
        shipments = data.slice(startIndex, endIndex);
        if(shipments.length == 0){
            $(".shipments-table tbody").append(`
                <tr class="">
                    <td scope="row">No data available...</td>
                </tr> 
            `);
        }else{
            shipments.forEach(function(shipment, index){
                $(".shipments-table tbody").append(`
                    <tr style="cursor:pointer" data-id="${shipment.external_shipment_id}">
                        <td class="">${getIndex(per_page, current_page, index)}.</td>
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

        // Calculate last_page
        const last_page = data.length > 0 ? Math.ceil(data.length / per_page) : 1;
        // Enable or disable the button based on the condition
        $(".paginate").eq(0).prop('disabled', current_page === 1);
        $(".paginate").eq(1).prop('disabled', current_page === last_page);

        $(".paginate").eq(0).data("page", current_page - 1);
        $(".paginate").eq(1).data("page", current_page + 1);

        $(".entries").eq(0).text((current_page - 1) * per_page + 1);
        $(".entries").eq(1).text((current_page - 1) * per_page + shipments.length);
        $(".entries").eq(2).text(data.length);
    }

    $(".period").on("click", function(event){
        event.preventDefault();
        $(".period").removeClass("btn-light-active");
        $(this).addClass("btn-light-active");
        let filter = $(this).data("filter");
        //$(".shipments-table tbody").empty();
    });

    // jQuery code for filtering
    $(document).ready(function() {
        $('.paginate').on('click', function() {
            current_page = $(this).data("page");
            renderData();
        });
        
        //Add shipment ID to clipboard text
        $(document).on("click", ".shipments-table tbody tr", function(event){
            event.preventDefault();
            // Get the data-id attribute of the clicked row
            let shipmentId = $(this).data("id");
            // Construct the URL
            let url = `/shippings/${shipmentId}`;
            //window.open(url, '_blank');  // Open the URL in a new tab
            // Redirect to the desired page with the shipment ID
            window.location.href = url;
            /*// Create a temporary element to hold the text to copy
            var $temp = $("<input>");
            // Add the $id as the value of the temporary input element
            $("body").append($temp);
            $temp.val($id).select();
            // Execute the copy command
            document.execCommand("copy");
            // Remove the temporary element
            $temp.remove();
            // Show a success message to the user
            alert("ID copied to clipboard: " + $id);*/
        });
    });
</script>
@include("customer.layouts.footer")