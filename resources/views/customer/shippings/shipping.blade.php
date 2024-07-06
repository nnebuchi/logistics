@include("customer.layouts.header")
        <div class="container-fluid main" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill"><a href="{{route('dashboard')}}" class="text-dark">Dashboard</a> > Shipping</h5>
                        <div class="d-flex">
                            @php
                                $isVerified = auth()->user()->is_verified; // Assuming `verified` is the column that checks if a user is verified
                            @endphp
                            <a href="<?= $isVerified ? route('create-shipment') : route('shippings') ?>" class="btn btn-primary mr-2">
                                <img src="{{asset('assets/images/icons/plus.svg')}}" />
                                Book Shipment
                            </a>
                            <a href="<?= $isVerified ? route('track-shipments') : route('shippings') ?>" class="btn btn-outline-primary">
                                <img src="{{asset('assets/images/icons/track.svg')}}" />
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
                                    <div class="p-3 d-flex flex-wrap justify-content-between align-items-center mb-0">
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
                                                        <h6 class="fw-semibold mb-0">Title</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">From</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">To</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Shipment ID</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Status</h6>
                                                    </th>
                                                    <th class="border-bottom-0">
                                                        <h6 class="fw-semibold mb-0">Action</h6>
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
                            <button  type="button" disabled data-page="" class="btn btn-light fs-4 fw-bold paginate">
                                <img src="{{asset('assets/images/icons/auth/cil_arrow-left.svg')}}" width="20" class="mr-2" alt="">Previous
                            </button>
                        </div>
                        <div class="">
                            <button  type="button" data-page="" class="custom-btn fs-4 fw-bold paginate">
                                Next <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                            </button>
                        </div>
                    </div>
                    <!--  Pagination Starts -->
                    <div class="my-2 pl-2">
                        Showing <span class="entries fw-semibold">. </span> to <span class="entries fw-semibold">. </span> of <span class="entries fw-semibold">. </span> shipments
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
        delivered: "custom-bg-success",
        "in-transit": "custom-bg-success",
        cancelled: "custom-bg-danger"
    };

    const reloadToTrackingScreen = (event) => {
        window.location.href=event.target.href
    }

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
    let user_id = "<?=$user->id?>";
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
        axios.get(`${baseUrl}/user/${user_id}/shipments`, config)
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
                let edit_btn_class = `btn btn-sm btn-outline-primary`;
                let track_btn_class = `btn btn-sm btn-primary`;
                let delete_btn_text;
                let modal_text;
                let modal_footer;
                let modal_title;
                if(shipment.status !== "draft" && shipment.status !== 'cancelled'){
                    edit_btn_class+= ` disabled`;
                    delete_btn_text = "Cancel";
                    modal_text = `To cancel a shipement after submission, kindly send a mail to \n support@zigaafrica.com Use ${shipment.external_shipment_id} as your Shipment ID.`;
                    modal_footer='';
                    modal_title="Cancel Shipment ?"
                }else{
                    track_btn_class+= ` disabled`;
                    delete_btn_text = "Delete";
                    modal_text = "Are you sure you want to delete this shipment";
                    modal_footer=`<div class="modal-footer text-center d-flex justify-content-center">
                                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal"> <i class="fa fa-arrow-left"></i> Go Back</button>
                                <a href="${url}/shipping/${shipment.slug}/delete" class="btn btn-primary">proceed >>> </a>
                            </div>`;
                    modal_title="Delete Shipment ?"
                   
                }
                $(".shipments-table tbody").append(`
                    <tr data-status="${shipment.status}" data-id="${shipment.slug}">
                        <td class="">${getIndex(per_page, current_page, index)}.</td>
                        <td class="">${shipment.title}</td>
                        <td class="">${shipment.address_from?.firstname?? ""}</td>
                        <td class="">${shipment.address_to?.firstname?? ""}</td>
                        
                        <td class=""> ${shipment.external_shipment_id ?shipment.external_shipment_id : ""}</td>
                        
                        <td class="">
                            <span class="py-2 badge rounded-2 fw-semibold ${status[shipment.status]}">
                            ${shipment?.status?.charAt(0).toUpperCase() + shipment?.status?.slice(1)}
                            </span>
                        </td>
                        <td>
                            <a href="${url}/shipping/track?tracking_id=${shipment.external_shipment_id}" class="${track_btn_class}" >Track</a>
                        
                            <a href="${url}/shipping/${shipment.slug}" class="${edit_btn_class}" onclick="reloadToTrackingScreen(event)"> Edit</a>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#shipment-${index}-Modal">${delete_btn_text}</button>
                        </td>
                    </tr> 
                `);

                $(".main").append(`
                    <div class="modal fade" id="shipment-${index}-Modal" tabindex="-1" aria-labelledby="shipment-${index}-ModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header text-center">
                                <h1 class="modal-title fs-5 ms-5" id="shipment-${index}-ModalLabel">${modal_title}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                ${modal_text}
                            </div>
                            ${modal_footer}
                            </div>
                        </div>
                    </div>
                `)
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
       
    });
</script>
@include("customer.layouts.footer")