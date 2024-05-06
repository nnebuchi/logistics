@include("customer.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Shipping > Track Shipment</h5>
                    </div>


                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card w-100">
                                <div class="card-body p-0">
                                    <div class="p-3 mb-4">
                                        <h5 class="card-title fw-semibold text-center">Track Your Shipment</h5>
                                        <div class="row justify-content-center mt-4">
                                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-6">
                                                <h5 style="color:#1E1E1E80">Shipment ID</h5>
                                                <div class="w-100">
                                                    <input 
                                                    type="text" 
                                                    id="shipment_id"
                                                    name="shipment_id"
                                                    placeholder="SH-123456789"
                                                    class="custom-input" />
                                                </div>
                                                <div class="text-center">
                                                    <button 
                                                        class="custom-btn mt-3"
                                                        id=""
                                                        type="button">
                                                        Track Shipment
                                                        <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>
            <!--  End of Row 1 -->
        </div>
    </div>
</div>
<script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/slim.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

<script src="{{asset('assets/libs/axios/axios.js')}}"></script>
<script src="{{asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/dist/simplebar.js')}}"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    let token = $("meta[name='csrf-token']").attr("content");
    let baseUrl = $("meta[name='base-url']").attr("content");

    // jQuery code for filtering
    $(document).ready(function() {
        $('.paginate').on('click', function() {
            current_page = $(this).data("page");
            renderData();
        });
    });
</script>
@include("customer.layouts.footer")