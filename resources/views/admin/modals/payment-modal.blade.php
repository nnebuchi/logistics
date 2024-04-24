<!-- Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="paymentModalLabel">Fund Customer Wallet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="message text-center"> </div>
                <form id="paymentForm">
                    <div class="mb-2 text-center">
                        <div class="name"></div>
                        <div class="email"></div>
                    </div>
                    <div class="mb-5">
                        <label for="amount" class="fw-semibold">Enter Amount</label>
                        <input 
                        min="0"
                        type="number"
                        class="w-100 custom-input" 
                        name="amount"
                        id="amount" 
                        placeholder="E.g 5000">
                        <span class="error"> </span>
                    </div>
                    <input type="hidden" id="userId" value="">
                    <div class="mt-2 d-flex justify-content-center">
                        <button 
                            disabled
                            id="submitBtn"
                            type="submit"
                            onclick="payWithPaystack()"
                            class="btn btn-primary fw-bolder">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal -->