<div class="row justify-content-center step" style="display:none;" id="checkout">
    <div class="col-xl-6 col-lg-6 col-md-8">
        <div class="card w-100">
            <div class="card-body">
                <div>
                    <h4 style="color:#1E1E1E66" class="mt-2">Shipping Summary</h4>
                    <div class="" id="">
                        <div class="mt-2 sender">
                            <p class="small m-0" style="color:#1E1E1E66">Sender</p>
                            <div class="px-2 small py-2" style="border-radius:10px;border:2px solid #233E83">
                                <p class="m-0">Name: <span class="fw-semibold"></span></p>
                                <p class="m-0">Email: <span class="fw-semibold"></span></p>
                                <p class="m-0">Phone: <span class="fw-semibold"></span></p>
                                <p class="m-0">Address: <span class="fw-semibold"></span></p>
                            </div>
                        </div>
                        <div class="mt-2 receiver">
                            <p class="small m-0" style="color:#1E1E1E66">Receiver</p>
                            <div class="px-2 small py-2" style="border-radius:10px;border:2px solid #233E83">
                                <p class="m-0">Name: <span class="fw-semibold"></span></p>
                                <p class="m-0">Email: <span class="fw-semibold"></span></p>
                                <p class="m-0">Phone: <span class="fw-semibold"></span></p>
                                <p class="m-0">Address: <span class="fw-semibold"></span></p>
                            </div>
                        </div>
                        <div class="mt-2 carrier">
                            <p class="small m-0">Carrier</p>
                            <div class="px-2 small py-2" style="border-radius:10px;border:2px solid #233E83">
                                <div class="" style="min-width:200px">
                                    <img src="" width="70" height="50" class="mr-2" alt="">
                                    <p class="m-0">Name: <span class="fw-semibold"></span></p>
                                    <p class="m-0">Pick Up: <span class="fw-semibold"></span></p>
                                    <p class="m-0">Delivery: <span class="fw-semibold"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="small m-0" style="color:#1E1E1E66">Shipment Details</p>
                            <div class="px-2 small py-2 items" style="border-radius:10px;border:2px solid #233E83">
                                
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4">
        <div class="card w-100">
            <div class="card-body">
                <form action="" method="POST">
                    <div class="d-flex justify-content-center">
                        <img src="{{asset('assets/images/logos/ziga-yellow.svg')}}">
                    </div>
                    <h4 class="mt-2 text-center">Checkout</h4>
                    <!--<p class="text-center fs-2 m-0">Subcharge: <span class="subcharge fw-semibold" style="color:#233E83;"> </span></p>-->
                    <p class="text-center fs-2 m-0">Total Charges</p>
                    <div class="text-center m-2">
                        <span class="total py-2 px-4 rounded fw-semibold" style="color:#233E83;background-color:#DAE3FE;"> </span>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <div class="w-100">
                            <button 
                            id="checkoutBtn"
                            type="button"
                            data-url="{{route('shipment.pay')}}"
                            class="custom-btn fs-4 fw-bold w-100">
                            Make Payment
                            </button>
                        </div>
                    </div>
                    <p class="message mt-3 text-center semibold" style='font-size:14px;'></p>
                </form>
            </div>
        </div>
    </div>
</div>