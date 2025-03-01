@include("admin.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Shippings</h5>
                    </div>

                    <div class="my-3 px-2" style="">
                        <div class="">
                            <input type="text"
                            placeholder="Search by tracking number" 
                            class="form-control w-auto rounded-0 p-4 bg-white" id="filterInput">
                        </div>
                        <div class="d-flex mt-2 flex-wrap">
                            <input type="text"
                            placeholder="Sort by date(from)" 
                            class="form-control w-auto rounded-0 p-4 mr-2 bg-white" id="startDate">
                            <input type="text"
                            placeholder="Sort by date(to)" 
                            class="form-control w-auto rounded-0 p-4 bg-white" id="endDate">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-0">
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
                                                        <h6 class="fw-semibold mb-0">Customer (Info)</h6>
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

                    <!-- Modal -->
                    <div class="modal fade" id="shipmentDataModal" tabindex="-1" role="dialog" aria-labelledby="shipmentDataModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-semibold" id="shipmentDataModalLabel">Shipment Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="shipmentData">

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- End of Modal -->
                    
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{asset('assets/js/paginator.js')}}"></script>
<script>
    let token = $("meta[name='csrf-token']").attr("content");
    let baseUrl = $("meta[name='base-url']").attr("content");

    flatpickr('#startDate', {
        enableTime: false,
        dateFormat: "Y-m-d H:i"
    });

    flatpickr('#endDate', {
        enableTime: false,
        dateFormat: "Y-m-d H:i"
    });

    const status = {
        draft: "custom-bg-warning",
        confirmed: "custom-bg-success",
        delivered: "custom-bg-success",
        "in-transit": "custom-bg-success",
        cancelled: "custom-bg-danger"
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
    function getShipments(url){
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                "X-Requested-With": "XMLHttpRequest"
            }
        };
        axios.get(url, config)
        .then((res) => {
            data = res.data.results;
            renderData();
        });
    };
    getShipments(`${baseUrl}/admin/get-all-shippings`);

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
                    <tr style="cursor:pointer;font-size" data-id="${shipment.external_shipment_id}">
                        <td class="">${getIndex(per_page, current_page, index)}.</td>
                        <td class="">${shipment.external_shipment_id}</td>
                        <td class="">
                            <span class="fw-semibold">${shipment.address_from.firstname+" "+shipment.address_from.lastname}</span><br>
                            <span>${shipment.address_from.email}</span><br>
                            <span>${shipment.address_from.phone}</span>
                        </td>
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

    $('.paginate').on('click', function() {
        current_page = $(this).data("page");
        renderData();
    });

    // jQuery code for filtering
    $(document).ready(function() {
        $('#filterInput').on('keyup', function() {
            //filterTable();
            let value = $(this).val();
            if(value == ""){
                getShipments(`${baseUrl}/admin/get-all-shippings`);
            }else{
                getShipments(`${baseUrl}/admin/get-all-shippings?searchTerm=${value}`);
            }
        });

        $('#startDate, #endDate').on('input', function() {
            let startDate = $("#startDate").val();
            let endDate = $("#endDate").val();
            getShipments(`${baseUrl}/admin/get-all-shippings?startDate=${startDate}&endDate=${endDate}`);
        });

        //Add shipment ID to clipboard text
        $(document).on("click", ".shipments-table tbody tr", function(event){
            event.preventDefault();
            let $id = $(this).data("id");
            // Create a temporary element to hold the text to copy
            var $temp = $("<input>");
            // Add the $id as the value of the temporary input element
            $("body").append($temp);
            $temp.val($id).select();
            // Execute the copy command
            document.execCommand("copy");
            // Remove the temporary element
            $temp.remove();
            // Show a success message to the user
            //alert("ID copied to clipboard: " + $id);

            const config = {
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                    "X-Requested-With": "XMLHttpRequest"
                }
            };
            axios.get(`${baseUrl}/admin/shipping/${$id}/track`, config)
            .then((res) => {
                let shipment = res.data.results;
                let items = "";
                for(const item of shipment.items){
                    items += `<div class="mt-2">
                        <div class="d-flex justify-content-between">
                            <p class="m-0">Item: <span class="fw-semibold">${item.name}</span></p>
                            <p class="m-0">Weight: <span class="fw-semibold">${item.weight}Kg</span></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="m-0">Quantity: <span class="fw-semibold">${item.quantity}pieces</span></p>
                            <p class="m-0">Value: <span class="fw-semibold">₦${parseFloat(item.value).toLocaleString()}</span></p>
                        </div>
                    </div>`;
                }
                $("#shipmentData").empty();
                $("#shipmentData").append(`
                    <div class="p-2" style="border-radius:10px;border:1px solid #bbb">
                        <h4>${shipment.shipment_id}</h4>
                    </div>
                    <div class="p-2 mt-2" style="border-radius:10px;border:1px solid #bbb">
                        <h5>Customer Details</h5>
                        <div class="px-2 small">
                            <p class="m-0">Name: <span class="fw-semibold">${shipment.address_from.first_name+" "+shipment.address_from.last_name}</span></p>
                            <p class="m-0">Email: <span class="fw-semibold">${shipment.address_from.email}</span></p>
                            <p class="m-0">Phone: <span class="fw-semibold">${shipment.address_from.phone}</span></p>
                            <p class="m-0">Address: <span class="fw-semibold">${shipment.address_from.line1}</span></p>
                        </div>
                    </div>
                    <div class="p-2 mt-2" style="border-radius:10px;border:1px solid #bbb">
                        <h5>Delivery Details</h5>
                        <div class="px-2 small">
                            <p class="m-0">Name: <span class="fw-semibold">${shipment.address_to.first_name+" "+shipment.address_to.last_name}</span></p>
                            <p class="m-0">Email: <span class="fw-semibold">${shipment.address_to.email}</span></p>
                            <p class="m-0">Phone: <span class="fw-semibold">${shipment.address_to.phone}</span></p>
                            <p class="m-0">Address: <span class="fw-semibold">${shipment.address_to.line1}</span></p>
                        </div>
                    </div>
                    <div class="p-2 mt-2" style="border-radius:10px;border:1px solid #bbb">
                        <h5>Shipment Details</h5>
                        <div class="px-2 small">
                            ${items}
                        </div>
                    </div>
                `);
                $("#shipmentDataModal").modal("show");
            });
        });

        $("#shipmentDataModal .close").on("click", function(){
            $("#shipmentDataModal").modal("hide");
        });
    });
</script>
@include("admin.layouts.footer")