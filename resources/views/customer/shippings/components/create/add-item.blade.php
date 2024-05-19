<div class="row justify-content-center step" style="display:none;" id="shipping">
    <div class="col-xl-9 col-lg-9 col-md-10">
        <div class="card w-100">
            <div class="card-body">
                <div class="" style="background-color:#E9EFFD;border-radius:10px;">
                    <div class="table-responsive">
                        <table class="items-table table table-borderless text-nowrap align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold">Items</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold">Quantity</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold">Weight</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold">Value</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold">Edit</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold">Delete</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>   
                                                        
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-center pt-4 mt-2" style="height:130px;background-color:#FCE4C2F7;border-radius:10px;">
                    <p class="fw-semibold">What's inside your shipment</p>
                    <div>
                        <button type="button"
                        class="btn bg-white px-4 openAddItemModal">
                            Add Item to your Shipment
                        </button>
                    </div>
                </div>

                @include('customer.modals.add-item-modal')
                
            </div>
        </div>
        <div id="pickUpBox">
            <div class="card w-100">
                <div class="card-body">
                    <h6 style="color:#1E1E1E66">Select preferred option</h6>

                    <input type="radio" id="html" name="options" value="HTML" class="d-none">
                    <label for="html" class="d-flex align-items-center">
                        <div class="fs-3">
                            Carrier should pick shipment from your address
                        </div>
                        <div class="ml-2">
                            <div class="dots-line rounded-circle d-flex align-items-center justify-content-center" style="height:20px;width:20px;border:2px solid #233E8366;">
                                <div class="dots d-none rounded-circle" style="height:10px;width:10px;background-color:#233E83;"></div>
                            </div>
                        </div>
                    </label>

                    <input type="radio" id="css" name="options" value="CSS" class="d-none">
                    <label for="css" class="d-flex align-items-center">
                        <div class="fs-3">
                            You will send shipment to Carrier's office
                        </div>
                        <div class="ml-2">
                            <div class="dots-line rounded-circle d-flex align-items-center justify-content-center" style="height:20px;width:20px;border:2px solid #233E8366;">
                                <div class="dots d-none rounded-circle" style="height:10px;width:10px;background-color:#233E83;"></div>
                            </div>
                        </div>
                    </label>
                
                    

                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <div class="mr-3">
                    <button 
                    data-type="shipping"
                    type="button"
                    class="btn btn-light fs-4 fw-bold prev">
                    <img src="{{asset('assets/images/icons/auth/cil_arrow-left.svg')}}" width="20" class="mr-2" alt="">
                    Previous
                    </button>
                </div>
                <div class="">
                    <button 
                        type="button"
                        id="step3Btn"
                        disabled
                        class="custom-btn fs-4 fw-bold">
                    Next
                    <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                    </button>
                </div>
            </div>
        </div>
        
    </div>
</div>