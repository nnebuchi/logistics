<?php 
    if($user?->profile?->business_cac):
?>        
    <div class="">
        <img src="<?=$user->profile->business_cac?>"
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
            <button 
            data-src="<?=$user?->profile?->business_cac?>"
            class="custom-btn"
            type="button">
                View File
                <img src="{{asset('assets/images/icons/profile/file-eye.svg')}}" width="15" height="15">
            </button>
        </div>
    </div>
<?php 
    else:
?>
    <div class="">
        <div class="w-100 d-flex align-items-center justify-content-center kyc-docs">
            <label for="business_cac" class="d-flex align-items-center bg-white px-3 py-2 fw-bold kyc-label" type="button">
                Upload File 
                <img src="{{asset('assets/images/icons/profile/file_10922205.svg')}}" width="15" height="15">
            </label>
            <input type="file" class="form-control d-none" name="business_cac" id="business_cac">
        </div>
    </div>
<?php
    endif;
?>

