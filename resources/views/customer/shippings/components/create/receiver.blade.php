<div class="row justify-content-center step" style="display:none;" id="receiver">
    <div class="col-xl-9 col-lg-9">
        <div class="card w-100">
            <div class="card-body">
                <form action="" method="POST">
                    <div class="row justify-content-center">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-9 mt-sm-2">
                            <h4 style="color:#1E1E1E66">Enter Receiver Details</h4>
                            <div class="w-100 mr-2">
                                <label class="custom-input-label">First Name</label>
                                <input type="text" name="firstname" placeholder="First Name" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-2">
                                <label class="custom-input-label">Last Name</label>
                                <input type="text" name="lastname" placeholder="Last Name" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-2">
                                <label class="custom-input-label">Email</label>
                                <input type="email" name="email" placeholder="xyz@gmail.com" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-2">
                                <label class="custom-input-label">Phone Number</label>
                                <input type="text" name="phone" data-phone="" placeholder="" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-9 mt-0 mt-sm-2">
                            <h4 style="color:#1E1E1E66">Address</h4>
                            <div class="w-100 mr-2">
                                <label class="custom-input-label">Address Line 1</label>
                                <input type="text" maxLength="45" name="address1" placeholder="First Address" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-2">
                                <label class="custom-input-label">Address Line 2 (optional)</label>
                                <input type="text" maxLength="45" name="address2" placeholder="Second Address" class="custom-input" />
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
                                            <option value="{{$country->sortname}}" data-phonecode="{{$country->phonecode}}" data-id="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error"> </span>
                                </div>
                                <div class="w-100 mt-md-0 mt-3">
                                    <label class="custom-input-label">State</label>
                                    <select
                                        name="state" disabled
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
                                        name="city" disabled
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
                            data-type="receiver"
                            class="btn btn-light fs-4 fw-bold prev">
                            <img src="{{asset('assets/images/icons/auth/cil_arrow-left.svg')}}" width="20" class="mr-2" alt="">
                            Previous
                            </button>
                        </div>
                        <div class="">
                            <button 
                            type="button"
                            data-type="receiver"
                            class="custom-btn fs-4 fw-bold next">
                            Next
                            <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>