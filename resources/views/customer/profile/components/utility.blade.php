<?php 
    if($user?->profile?->utility_bill):
?>        
    <div class="">
        <img src="<?=$user->profile->utility_bill?>"
        class="w-100" 
        height="161" 
        style="border-radius:15px;object-fit:cover;">
        <div class="d-flex justify-content-between mt-3">
            <button 
            disabled
            class="btn btn-light"
            type="button">
                Update
            </button>
            <a href="<?=$user->profile->utility_bill?>" target="_blank" class="custom-btn" type="button">
                View File
                <img src="{{asset('assets/images/icons/profile/file-eye.svg')}}" width="15" height="15">
            </a>
        </div>
    </div>
<?php 
    else:
?>
    <div class="">
        
        <div class="w-100 kyc-docs">
            <p class="text-danger text-center mt-2">PNG and JPEG only</p>
            <div class=" d-flex align-items-center justify-content-center">
                <label for="utility_bill" class="d-flex align-items-center bg-white px-3 py-2 fw-bold kyc-label" type="button">
                    Upload File 
                    <img src="{{asset('assets/images/icons/profile/file_10922205.svg')}}" width="15" height="15">
                </label>
                <input type="file" class="form-control d-none" name="utility_bill" id="utility_bill" accept="image/jpeg, image/jpg, image/png">
            </div>
            {{-- <p class="text-danger">PNG and JPEG only</p><br> --}}
            
        </div>
        <p style="color:#F79D1D;font-size:12px;font-weight:500">Not later than 3 months</p>
    </div>
<?php
    endif;
?>