<div class="row justify-content-center step" style="display:non;" id="shipping">
    <div class="col-xl-9 col-lg-9 col-md-10">
        <div class="card w-100">
            <div class="card-body">
                <div id="parcel-container">
                    <!-- Table starts here -->
                    <div class="parcel-box">
                        <div class="alert alert-info">
                            <h6>Important Tips:</h6>
                            <ul type="disc">
                                <li><span><i class="fa fa-check"></i></span>Your Shipments are made up of parcels.  </li>
                                <li><span><i class="fa fa-check"></i></span>A parcel is like a box</li>
                                <li><span><i class="fa fa-check"></i></span>We have created the first parcel for you by default.</li>
                                <li><span><i class="fa fa-check"></i></span>You can add as many items you want to a parcel</li>
                                <li><span><i class="fa fa-check"></i></span>To add another parcel, click on "Add new parcel"</li>
                            </ul>
                        </div>
                        <div class="mb-1 d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Parcel 1</h5>
                        </div>
                        <div class="mb-2 p-2" style="background-color:#E9EFFD;border-radius:10px;">
                            <div class="table-responsive">
                                <table class="mb-0 items-table table table-borderless text-nowrap align-middle">
                                    <thead class="text-dark fs-3">
                                        <tr>
                                            <th>Items</th>
                                            <th>Quantity</th>
                                            <th>Weight</th>
                                            <th>Value</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>   
                                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center p-3">
                                <button type="button" data-parcel="0"
                                class="btn bg-whit px-4 openAddItemModal" style="background-color:#FCE4C2F7;">
                                + Add Item
                                </button>
                            </div>
                            <div class="p-3 bg-white">
                                <form class="proof-of-purchase-form" data-parcel="0" 
                                action="" method="POST" enctype="multipart/form-data">
                                    <h5 class="m-0 mb-1">Upload Proof of Purchase</h5>
                                    <div class="mt-2 d-flex align-items-center">
                                        <div class="w-10" style="border:2px solid #FCE4C2F7">
                                            <input type="text" name="document" placeholder="Title" class="custom-input rounded-0" />
                                        </div>
                                        <label for="document-0" type="button" class="m-0 ml-2 rounded-circle d-flex align-items-center justify-content-center" style="background-color:#FCE4C2F7;height:50px;width:50px">
                                            <img src="{{asset('assets/images/icons/cloud-upload.svg')}}" width="25" >
                                            <input type="file" id="document-0" data-parcel="0" data-count="0" class="d-none document-file" />
                                        </label>
                                    </div>
                                    <span class="document-count"> </span>
                                    <div class="mt-1 document-preview">

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Table starts here -->
                </div>
                <div class="d-flex align-items-center justify-content-between p-2" style="background-color:#FCE4C2F7;">
                    <h5 class="m-0">Click to add new parcel</h5>
                    <button id="add-parcel" data-parcel="1" class="custom-btn" type="button">Add new parcel</button>
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