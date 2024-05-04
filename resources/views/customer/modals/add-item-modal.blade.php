<!-- Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold" style="color:#1E1E1E66" id="addItemModalLabel">Enter Shipping Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="addItemForm">
                    <div class="row justify-content-center">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-9 mt-sm-2">
                            <div class="w-100 mr-2">
                                <label class="custom-input-label">Name of item</label>
                                <input type="text" name="name" placeholder="e.g books" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-2">
                                <label class="custom-input-label">Category</label>
                                <select
                                    name="category"
                                    class="custom-select">
                                    <option value="">--Select one---</option>
                                    @foreach($chapters as $chapter)
                                        <option value="{{$chapter->_id}}">{{$chapter->chapter_name}}</option>
                                    @endforeach
                                </select>
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-2">
                                <label class="custom-input-label">Sub-Category</label>
                                <select
                                    name="sub_category"
                                    class="custom-select">
                                    <option value="">--Select one---</option>
                                </select>
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-2">
                                <label class="custom-input-label">HS Code</label>
                                <select
                                    name="hs_code"
                                    class="custom-select">
                                    <option value="">--Select one---</option>
                                </select>
                                <span class="error"> </span>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-9 mt-0 mt-sm-2">
                            <div class="w-100 mr-2">
                                <label class="custom-input-label">Weight (kg)</label>
                                <input type="text" name="weight" placeholder="" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-2">
                                <label class="custom-input-label">Quantity</label>
                                <input type="text" name="quantity" placeholder="" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-2">
                                <label class="custom-input-label">Monetary Value</label>
                                <input type="text" name="value" placeholder="NGN" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                            <!--<div class="d-flex flex-column flex-md-row mt-2 justify-content-between">
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
                            </div>-->
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
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
    </div>
</div>
<!-- End of Modal -->