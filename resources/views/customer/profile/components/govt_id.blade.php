<?php 
    if($user?->profile?->valid_govt_id):
?>        
    <div class="">
        <img src="<?=$user->profile->valid_govt_id?>"
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
            data-src="<?=$user->profile->valid_govt_id?>"
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
            <label for="valid_govt_id" class="d-flex align-items-center bg-white px-3 py-2 fw-bold kyc-label" type="button">
                Upload File 
                <img src="{{asset('assets/images/icons/profile/file_10922205.svg')}}" width="15" height="15">
            </label>
            <input type="file" class="form-control d-none" name="valid_govt_id" id="valid_govt_id" multiple>
        </div>
        <p style="color:#F79D1D;font-size:12px;font-weight:500">Front and Back upload of ID Card such as: National ID, Voter’s Card, Driver’s License and International Passport.</p>
    </div>
<?php
    endif;
?>


