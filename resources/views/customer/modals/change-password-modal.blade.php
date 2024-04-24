<!-- Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="change-password" action="{{url('/change-password')}}" method="POST">
                    <span class="message d-block" style="text-align:center"> </span>
                    <div class="">
                        <label for="password" class="custom-input-label">Enter Current Password</label>
                        <div class="d-flex position-relative input-box">
                            <input 
                            type="password" 
                            id="current_password"
                            name="current_password"
                            placeholder="Enter Current Password" 
                            class="custom-input" />
                            <div class="d-flex align-items-center justify-content-center p-l-10 p-r-10 position-absolute h-100 px-2" style="top:0;right:0">
                                <img src="{{asset('assets/images/icons/auth/ion_eye.svg')}}" class="show-hide" width="15" alt="">
                            </div>
                        </div>
                        <span class="error"></span>
                    </div>
                    <div class="mt-1">
                        <label for="password" class="custom-input-label">Enter New Password</label>
                        <div class="d-flex position-relative input-box">
                            <input 
                            type="password" 
                            id="password"
                            name="password"
                            placeholder="Enter New Password" 
                            class="custom-input" />
                            <div class="d-flex align-items-center justify-content-center p-l-10 p-r-10 position-absolute h-100 px-2" style="top:0;right:0">
                                <img src="{{asset('assets/images/icons/auth/ion_eye.svg')}}" class="show-hide" width="15" alt="">
                            </div>
                        </div>
                        <span class="error"></span>
                    </div>
                    <div class="mt-1">
                        <label for="password" class="custom-input-label">Confirm New Password</label>
                        <div class="d-flex position-relative input-box">
                            <input 
                            type="password" 
                            id="confirm_password"
                            name="confirm_password"
                            placeholder="Confirm New Password" 
                            class="custom-input" />
                            <div class="d-flex align-items-center justify-content-center p-l-10 p-r-10 position-absolute h-100 px-2" style="top:0;right:0">
                                <img src="{{asset('assets/images/icons/auth/ion_eye.svg')}}" class="show-hide" width="15" alt="">
                            </div>
                        </div>
                        <span class="error"></span>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="custom-btn fw-bold">
                            Change Password
                            <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="ml-2" alt="">
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal -->