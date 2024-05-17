@include("customer.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Shipping > Track Shipment</h5>
                    </div>


                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card w-100">
                                <div class="card-body p-0">
                                    <div class="p-3 mb-4">
                                        <h5 class="card-title fw-semibold text-center">Track Your Shipment</h5>
                                        <div class="row justify-content-center mt-4">
                                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-6">
                                                <div id="formBox" class="">
                                                    <h5 style="color:#1E1E1E80">Shipment ID</h5>
                                                    <div class="w-100">
                                                        <input 
                                                        type="text" 
                                                        id="shipment_id"
                                                        name="shipment_id"
                                                        placeholder="SH-123456789"
                                                        class="custom-input" />
                                                    </div>
                                                    <div class="text-center">
                                                        <button 
                                                            class="custom-btn mt-3"
                                                            id="track"
                                                            type="button">
                                                            Track Shipment
                                                            <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                                                        </button>
                                                    </div>
                                                </div>
                                                <div style="" class="mt-2" id="shipping-data">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
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

    // jQuery code for filtering
    $(document).ready(function() {
        $('#track').on('click', function(event) {
            event.preventDefault();
            let btn = $(this);
            btn.html(`<img src="/assets/images/loader.gif" id="loader-gif">`);
            btn.attr("disabled", true);
            let shippingId = $("#shipment_id").val();
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
                axios.get(`${baseUrl}/shipping/${shippingId}/track`, config)
                .then((res) => {
                    $("#formBox").addClass("d-none");
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
                    $("#shipping-data").empty();
                    $("#shipping-data").append(`
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
                });
            }, 100); // Delay submission by 100 milliseconds
        });
    });
</script>
@include("customer.layouts.footer")