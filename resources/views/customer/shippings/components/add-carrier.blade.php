<div class="row justify-content-center step" style="display:none;" id="carrier">
    <div class="col-xl-10 col-lg-10">
        <div class="card w-100">
            <div class="card-body">
                <form action="" method="POST">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="fw-semibold m-0">Select Carrier</h5>
                        <button 
                            type="button"
                            class="btn btn-light fs-4 fw-bold">
                        Refresh
                        <img src="{{asset('assets/images/icons/auth/mdi_password-outline.svg')}}" width="20" class="mr-2" alt="">
                        </button>
                    </div>
                    <div class="mt-3" id="chooseCarrier">
                        
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
                    disabled
                    class="custom-btn fs-4 fw-bold">
                Proceed to payment
                <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                </button>
            </div>
        </div>
    </div>
</div>