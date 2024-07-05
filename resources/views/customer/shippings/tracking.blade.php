@include("customer.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill"><a href="{{route('dashboard')}}" class="text-dark">Dashboard</a> > <a href="{{route('shippings')}}" class="text-dark">Shipping</a> > Track Shipment</h5>
                    </div>


                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card w-100">
                                <div class="card-body p-0">
                                    <div class="p-3 mb-4">
                                        <h5 class="card-title fw-semibold text-center">Track Your Shipment</h5>
                                        <div class="row justify-content-center mt-4">
                                            <div class="col-xl-5 col-lg-5 col-md-6 col-sm-8">
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
    window.addEventListener('load', function() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const tracking_id = urlParams.get('tracking_id');
        document.querySelector('#shipment_id').value = tracking_id
    })

    function formatDate(dateString) {
        const date = new Date(dateString);
        
        // Get day, month, year
        const day = String(date.getUTCDate()).padStart(2, '0');
        const month = String(date.getUTCMonth() + 1).padStart(2, '0'); // Months are zero-based
        const year = date.getUTCFullYear();
        
        // Get hours, minutes, seconds
        let hours = date.getUTCHours();
        const minutes = String(date.getUTCMinutes()).padStart(2, '0');
        const seconds = String(date.getUTCSeconds()).padStart(2, '0');
        
        // Determine AM/PM and format hours
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // The hour '0' should be '12'
        const formattedHours = String(hours).padStart(2, '0');

        // Format the final date and time string
        const formattedDate = `${day}/${month}/${year}`;
        const formattedTime = `${formattedHours}:${minutes}:${seconds} ${ampm}`;

        return [formattedDate, formattedTime];
    }

const dateString = "2024-05-28T14:23:07.129Z";
console.log(formatDate(dateString)); // Output: 28/05/2024 02:23:07 PM


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
                    let events = "";
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
                    for(const event of shipment.events){
                        events += `<div class="d-flex mt-2" style="font-size:14px">
                            <div class="mr-2 d-flex flex-column align-items-center" style="">
                                <img src="{{asset('assets/images/icons/auth/success-icon.png')}}" width="20" height="20" />
                                <div style="height:50px;width:7.5px;background-color:#F79D1D;margin-top:5px;"></div>
                            </div>
                            <div class="d-flex justify-content-between w-100">
                                <div class="">
                                    <p class="fw-bold" style="color:#F79D1D">${event.location}</p>
                                    <p>${event.description}</p>
                                </div>
                                <div class="">
                                    <p class="fw-bold">${formatDate(event.created_at)[0]}</p>
                                    <p class="fw-bold">${formatDate(event.created_at)[1]}</p>
                                </div>
                            </div>
                        </div>`;
                    }
                    $("#shipping-data").empty();
                    $("#shipping-data").append(`
                        <div class="p-2" style="border-radius:10px;border:1px solid #bbb">
                            <h4>${shipment.shipment_id}</h4>
                            ${events}
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