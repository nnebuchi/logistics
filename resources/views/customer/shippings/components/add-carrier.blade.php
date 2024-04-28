<div class="step" style="display:none;" id="carrier">
    <div class="card w-100">
        <div class="card-body">
            <form action="" method="POST">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="fw-semibold m-0">Select Carrier</h5>
                    <button 
                        type="button"
                        data-toggle="modal" data-target="#changePasswordModal"
                        class="btn btn-light fs-4 fw-bold">
                    Refresh
                    <img src="{{asset('assets/images/icons/auth/mdi_password-outline.svg')}}" width="20" class="mr-2" alt="">
                    </button>
                </div>
                <div class="mt-3">
                    <div class="radio-group d-flex justify-content-between p-2" style="overflow-x:auto;">
                        <div class="" style="min-width:200px">
                            <img src="{{asset('assets/images/icons/auth/mdi_password-outline.svg')}}" width="20" class="mr-2" alt="">
                            <p>DHL Express</p>
                        </div>
                        <div class="" style="min-width:150px">
                            <p>Pick Up: within 2 days</p>
                            <p>Delivery: within 5 days</p>
                        </div>
                        <div class="d-flex align-items-center" style="min-width:200px">
                            <p>NGN 15,000.50</p>
                        </div>
                        <div class="d-flex align-items-center" style="min-width:100px">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="height:20px;width:20px;border:2px solid #233E8366;">
                                <div class="rounded-circle" style="height:12.5px;width:12.5px;background-color:#233E83;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="radio-group d-flex justify-content-between p-2" style="overflow-x:auto;">
                        <div class="" style="min-width:200px">
                            <img src="{{asset('assets/images/icons/auth/mdi_password-outline.svg')}}" width="20" class="mr-2" alt="">
                            <p>DHL Express</p>
                        </div>
                        <div class="" style="min-width:150px">
                            <p>Pick Up: within 2 days</p>
                            <p>Delivery: within 5 days</p>
                        </div>
                        <div class="d-flex align-items-center" style="min-width:200px">
                            <p>NGN 15,000.50</p>
                        </div>
                        <div class="d-flex align-items-center" style="min-width:100px">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="height:20px;width:20px;border:2px solid #233E8366;">
                                <div class="rounded-circle" style="height:12.5px;width:12.5px;background-color:#233E83;"></div>
                            </div>
                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-3">
        <div class="mr-3">
            <button 
            type="button"
            class="btn btn-light fs-4 fw-bold prev">
            <img src="{{asset('assets/images/icons/auth/cil_arrow-left.svg')}}" width="20" class="mr-2" alt="">
            Previous
            </button>
        </div>
        <div class="">
            <button 
                type="button"
                id="step4Btn"
                class="custom-btn fs-4 fw-bold">
            Proceed to payment
            <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
            </button>
        </div>
    </div>
</div>