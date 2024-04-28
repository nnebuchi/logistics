<div class="card w-100" style="display:none;"  id="carrier">
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
            <div class="d-flex justify-content-between" style="overflow-x:auto;">
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
                    <p>NGN 15,000.50</p>
                </div>
            </div>
        </form>
    </div>
</div>