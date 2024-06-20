<div class="row justify-content-center step" style="display:none;" id="sender">
    <div class="col-xl-9 col-lg-9">
        <div class="card w-100">
            <div class="card-body">
                <form action="" method="POST">
                    <div class="row justify-content-center">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-9 mt-sm-2">
                            <h4 style="color:#1E1E1E66">Enter Sender Details</h4>
                            <div class="w-100 mr-2">
                                <label class="custom-input-label">First Name</label>
                                <input value="<?=$shipment->address_from->firstname?>" type="text" name="firstname" placeholder="First Name" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-2">
                                <label class="custom-input-label">Last Name</label>
                                <input value="<?=$shipment->address_from->lastname?>" type="text" name="lastname" placeholder="Last Name" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-2">
                                <label class="custom-input-label">Email</label>
                                <input value="<?=$shipment->address_from->email?>" type="email" name="email" placeholder="xyz@gmail.com" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-2">
                                <label class="custom-input-label">Phone Number</label>
                                <input value="<?=$shipment->address_from->phone?>" type="text" name="phone"  placeholder="" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-9 mt-0 mt-sm-2">
                            <h4 style="color:#1E1E1E66">Address</h4>
                            <div class="w-100 mr-2">
                                <label class="custom-input-label">Address Line 1</label>
                                <input value="<?=$shipment->address_from->line1?>" type="text" maxLength="45" name="address1" placeholder="First Address" class="custom-input" />
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
                                        @foreach($countries as $country)
                                            @if($country->sortname == $shipment->address_from->country)
                                                <option selected value="{{$country->sortname}}" data-phonecode="{{$country->phonecode}}" data-id="{{$country->id}}">{{$country->name}}</option>
                                            @else
                                                <option value="{{$country->sortname}}" data-phonecode="{{$country->phonecode}}" data-id="{{$country->id}}">{{$country->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="error"> </span>
                                </div>
                                <div class="w-100 mt-md-0 mt-3">
                                    <label class="custom-input-label">State</label>
                                    <select
                                        name="state"
                                        class="custom-select">
                                        @foreach($states["from"] as $state)
                                            @if($state->name == $shipment->address_from->state)
                                                <option selected value="{{$state->name}}" data-id="{{$state->id}}">{{$state->name}}</option>
                                            @else
                                                <option value="{{$state->name}}" data-id="{{$state->id}}">{{$state->name}}</option>
                                            @endif
                                        @endforeach
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
                                        @foreach($cities["from"] as $city)
                                            @if($city->name == $shipment->address_from->city)
                                                <option selected value="{{$city->name}}" data-id="{{$city->id}}">{{$city->name}}</option>
                                            @else
                                                <option value="{{$city->name}}" data-id="{{$city->id}}">{{$city->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="error"> </span>
                                </div>
                                <div class="w-100 mt-md-0 mt-3">
                                    <label class="custom-input-label">Zip Code</label>
                                    <input value="<?=$shipment->address_from->zip?>" type="text" name="zip_code" placeholder="xyz@gmail.com" class="custom-input" />
                                    <span class="error"> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <div class="mr-3">
                            <button 
                            data-type="sender"
                            type="button"
                            disabled
                            class="btn btn-light fs-4 fw-bold prev">
                            <img src="{{asset('assets/images/icons/auth/cil_arrow-left.svg')}}" width="20" class="mr-2" alt="">
                            Previous
                            </button>
                        </div>
                        <div class="">
                            <button 
                            type="button"
                            data-to=""
                            data-type="sender"
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