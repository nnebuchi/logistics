@include("admin.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Customer ></h5>
                        <?php 
                            if($customer->is_verified):
                        ?>    
                            <div class="fw-semibold bg-white py-2 px-4 rounded-pill d-flex align-items-center">
                                <img src="{{asset('assets/images/icons/auth/success-icon.svg')}}" width="30" height="30" class="mr-2" />
                                KYC Completed!
                            </div>
                        <?php 
                            else: 
                        ?>
                            <div class="fw-semibold bg-white py-2 px-4 rounded-pill d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center mr-2" style="background-color:#FB04044D;height:30px;width:30px">
                                    <img src="{{asset('assets/images/icons/auth/warning-icon.svg')}}" width="25" height="25" />
                                </div>
                                Update KYC!
                            </div>
                        <?php 
                            endif;
                        ?>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 d-flex align-items-stretch">
                            <div class="card w-100 px-3">
                                <div class="card-body p-0">
                                    <div class="row justify-content-between">
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 pt-3">
                                            <div class="d-flex flex-column align-items-center">
                                                <?php 
                                                    if($customer->photo):
                                                ?>        
                                                    <div class="position-relative">
                                                        <img style="object-fit:cover;" class="rounded-circle photo" src="<?=$customer?->photo?>" width="180" height="180">
                                                    </div>
                                                <?php 
                                                    else:
                                                ?>
                                                    <div class="position-relative rounded-circle d-flex align-items-center justify-content-center" 
                                                    style="border:2px solid #233E834D;height:180px;width:180px;background-color:#FCD8A5">
                                                        <img class="photo rounded-circle" src="{{asset('assets/images/icons/profile/user-profile.svg')}}" style="max-width:180px;max-height:180px">
                                                    </div>
                                                <?php
                                                    endif;
                                                ?>
                                                <h5 class="mt-3"><?=$customer->firstname." ".$customer->lastname?></h5>
                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 pt-3 pb-5" style="border-left: 1px solid #1E1E1E33;">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h5 class="mt-3 fw-semibold">Bio Details</h5>
                                            </div>
                                            <div class="mt-3">
                                                <div class="w-100 mt-md-0 mt-2 mr-2">
                                                    <label for="email" class="custom-input-label">Phone</label>
                                                    <p><?=$customer->phone?></p>
                                                </div>
                                                <div class="w-100 mr-2">
                                                    <label for="email" class="custom-input-label">Email</label>
                                                    <p><?=$customer->email?></p>
                                                </div>
                                                <div class="w-100 mt-md-0 mt-2 mr-2 d-flex flex-column">
                                                    <label for="email" class="custom-input-label">UserType</label>
                                                    <span style="" class="rounded-all"><?=$customer->account->name?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 d-flex align-items-stretch">
                            <div class="card w-100 px-3 pb-5 pt-3">
                                <div class="card-body p-0">
                                    <h4 style="font-weight:700" class="text-center">KYC Documents</h4>
                                    <hr>
                                    <form id="update-kyc" action="/api/v1/" method="POST" enctype="multipart/form-data">
                                        <div class="row justify-content-around">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-5 mt-3">
                                                <h5 class="text-center" style="color:#1E1E1E80">Utility Bill</h5>
                                                <?php if($customer?->profile?->utility_bill):?>        
                                                    <div style="position:relative;" class="kyc-doc">
                                                        <img src="<?=$customer->profile->utility_bill?>" class="w-100"  height="161"  style="border-radius:15px;object-fit:cover;">
                                                        <div class="kyc-doc-element" style="background-color:black; opacity:0.5; width:100%; height:100%;position:absolute; top:0; left:0; bottom:0;border-radius:15px;">
                                                            
                                                        </div>
                                                        <a href="<?=$customer->profile->utility_bill?>" target="_blank" class="btn btn-light kyc-doc-element" style="position: absolute; z-index:10; top:40%; left:30%; width:40%;">View</a>
                                                    </div>
                                                <?php else:?>
                                                    <p style="color:#F79D1D;font-size:12px;font-weight:500">No file uploaded..</p>
                                                <?php endif;?>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-5 mt-3">
                                                <h5  class="text-center" style="color:#1E1E1E80">Government ID</h5>
                                                <?php if($customer?->profile?->valid_govt_id):?>        
                                                    <div style="position:relative;" class="kyc-doc">
                                                        <img src="<?=$customer->profile->valid_govt_id[0]?>"
                                                        class="w-100" 
                                                        height="161" 
                                                        style="border-radius:15px;object-fit:cover;">
                                                        <div class="kyc-doc-element" style="background-color:black; opacity:0.5; width:100%; height:100%;position:absolute; top:0; left:0; bottom:0;border-radius:15px;">
                                                            
                                                        </div>
                                                        <a href="<?=$customer->profile->valid_govt_id[0]?>" target="_blank" class="btn btn-light kyc-doc-element" style="position: absolute; z-index:10; top:40%; left:30%; width:40%;">View</a>

                                                    </div>

                                                    @if(count($customer->profile->valid_govt_id) > 1)
                                                    <div style="position:relative;" class="kyc-doc">
                                                        <img src="<?=$customer->profile->valid_govt_id[1]?>"
                                                        class="w-100" 
                                                        height="161" 
                                                        style="border-radius:15px;object-fit:cover;">
                                                        <div class="kyc-doc-element" style="background-color:black; opacity:0.5; width:100%; height:100%;position:absolute; top:0; left:0; bottom:0;border-radius:15px;">
                                                            
                                                        </div>
                                                        <a href="<?=$customer->profile->valid_govt_id[0]?>" target="_blank" class="btn btn-light kyc-doc-element" style="position: absolute; z-index:10; top:40%; left:30%; width:40%;">View</a>
                                                        
                                                    </div>
                                                    @endif
                                                <?php else:?>
                                                    <p style="color:#F79D1D;font-size:12px;font-weight:500">No file uploaded..</p>
                                                <?php endif;?>
                                            </div>
                                        </div>

                                        <div class="row justify-content-around">
                                            <?php 
                                                if($customer->account->name != "personal"):
                                            ?>
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-5 mt-2">
                                                    <h5 style="color:#1E1E1E80">Business CAC(for businesses only)</h5>
                                                    <?php if($customer?->profile?->business_cac):?>        
                                                        <div class="">
                                                            <img src="<?=$customer->profile->business_cac?>"
                                                            class="w-100" 
                                                            height="161" 
                                                            style="border-radius:15px;object-fit:cover;">
                                                        </div>
                                                    <?php else:?>
                                                        <p style="color:#F79D1D;font-size:12px;font-weight:500">No file uploaded..</p>
                                                    <?php endif;?>
                                                </div>
                                                <?php
                                                endif;
                                            ?>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-5 mt-2">
                                                <h5 style="color:#1E1E1E80">ID Number</h5>
                                                <div class="w-100">
                                                    <input 
                                                    type="text" 
                                                    id="id_number"
                                                    name="id_number"
                                                    value="<?=$customer?->profile?->id_number?>"
                                                    placeholder="Enter ID number of uploaded ID card"
                                                    class="custom-input" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if(!$customer->is_verified):?>    
                        <div class="mt-2">
                            <a href="<?=url('/admin/users/'.$customer->uuid.'/verify-kyc')?>" class="custom-btn">Verify User</a>
                        </div>
                    <?php endif; ?>

                    
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
<script src="{{asset('assets/libs/sweetalert2/sweetalert2.all.js')}}"></script>
<script>
    let token = $("meta[name='csrf-token']").attr("content");
    let baseUrl = $("meta[name='base-url']").attr("content");
</script>
@include("admin.layouts.footer")