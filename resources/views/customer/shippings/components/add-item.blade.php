<div class="step" style="displa:none;" id="shipping">
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
                    <button type="button" class="btn bg-white px-4 openAddItemForm">
                        Add Item to your Shipment
                    </button>
                </div>
            </div>

            <form class="d-none" method="POST" id="addItemForm" style="">
                <h4 style="color:#1E1E1E66" class="mt-2">Enter Shipping Details</h4>
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-9 mt-sm-2">
                        <div class="w-100 mr-2">
                            <label class="custom-input-label">Name of item</label>
                            <input type="text" name="name" placeholder="e.g books" class="custom-input" />
                            <span class="error"> </span>
                        </div>
                        <div class="w-100 mt-2">
                            <label class="custom-input-label">Category</label>
                            <input type="text" name="category" placeholder="" class="custom-input" />
                            <span class="error"> </span>
                        </div>
                        <div class="w-100 mt-2">
                            <label class="custom-input-label">Sub-Category</label>
                            <input type="text" name="sub_category" placeholder="" class="custom-input" />
                            <span class="error"> </span>
                        </div>
                        <div class="w-100 mt-2">
                            <label class="custom-input-label">HS Code</label>
                            <input type="text" name="hs_code" placeholder="" class="custom-input" />
                            <span class="error"> </span>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-9 mt-0 mt-sm-2">
                        <div class="w-100 mr-2">
                            <label class="custom-input-label">Weight (kg)</label>
                            <input type="number" name="weight" placeholder="" class="custom-input" />
                            <span class="error"> </span>
                        </div>
                        <div class="w-100 mt-2">
                            <label class="custom-input-label">Quantity</label>
                            <input type="number" name="quantity" placeholder="" class="custom-input" />
                            <span class="error"> </span>
                        </div>
                        <div class="d-flex flex-column flex-md-row mt-2 justify-content-between">
                            <div class="w-100 mr-2">
                                <label class="custom-input-label">Country</label>
                                <select
                                    name="country"
                                    class="custom-select">
                                    <option value="">--Select one---</option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-md-0 mt-3">
                                <label class="custom-input-label">State</label>
                                <select
                                    name="state"
                                    class="custom-select">
                                    <option value="">--Select one---</option>
                                </select>
                                <span class="error"> </span>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row mt-2 justify-content-between">
                            <div class="w-100 mr-2">
                                <label class="custom-input-label">City</label>
                                <select
                                    name="city"
                                    class="custom-select">
                                    <option value="">--Select one---</option>
                                </select>
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-md-0 mt-3">
                                <label class="custom-input-label">Zip Code</label>
                                <input type="text" name="zip_code" placeholder="xyz@gmail.com" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-5">
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
                        id="addItem"
                        data-item=""
                        data-action="create"
                        data-type="shipping"
                        class="custom-btn fs-4 fw-bold">
                        Save
                        <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="optionsBox" style="displa:none;">
        <div class="card w-100">
            <div class="card-body">
                <h6 style="color:#1E1E1E66">Select preferred option</h6>

                <input type="radio" id="html" name="options" value="HTML" class="d-none">
                <label for="html" class="d-flex align-items-center">
                    <div class="">
                        Carrier should pick shipment from your address
                    </div>
                    <div class="ml-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="height:20px;width:20px;border:2px solid #233E8366;">
                            <div class="rounded-circle" style="height:12.5px;width:12.5px;background-color:#233E83;"></div>
                        </div>
                    </div>
                </label>
                <input type="radio" id="css" name="options" value="CSS" class="d-none">
                <label for="css" class="d-flex align-items-center">
                    <div class="">
                        You will send shipment to Carrier's office
                    </div>
                    <div class="ml-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="height:20px;width:20px;border:2px solid #233E8366;">
                            <div class="rounded-circle" style="height:12.5px;width:12.5px;background-color:#233E83;"></div>
                        </div>
                    </div>
                </label>
            
                

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
                    id="step3Btn"
                    class="custom-btn fs-4 fw-bold">
                Next
                <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                </button>
            </div>
        </div>
    </div>
</div>