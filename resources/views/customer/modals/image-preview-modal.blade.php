<!-- Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold text-center" id="imagePreviewModalLabel">Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mb-3">
                <div class="">
                    <div class="d-flex justify-content-center" id="imagePreviewBox">
                        
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button 
                        id="discard-img"
                        type="button" class="btn btn-light fw-bold">
                            Discard
                            <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="ml-2" alt="">
                        </button>
                        <button 
                        data-imgEl=""
                        type="button" 
                        class="custom-btn fw-bold upload-kyc-btn">
                            Upload File
                            <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="ml-2" alt="">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal -->