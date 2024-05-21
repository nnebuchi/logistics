<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold" id="userModalLabel">User Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span class="message d-block text-center"> </span>
                <div class="">
                    <img src="" class="avatar rounded-circle" width="50" height="50">
                </div>
                <div class="mt-2">
                    <input type="text" readonly
                    placeholder="firstname" class="w-100 form-control rounded-0">
                </div>
                <div class="mt-2">
                    <input type="text"
                    placeholder="email" readonly class="w-100 form-control rounded-0">
                </div>
                <div class="mt-2">
                    <input type="text"
                    placeholder="phone" readonly class="w-100 form-control rounded-0">
                </div>
                <div class="mt-2">
                    <input type="text" readonly
                    placeholder="country" class="w-100 form-control rounded-0">
                </div>
                <div class="mt-2">
                    <select class="w-100 form-control rounded-0" readonly name="account">
                        @foreach($accounts as $account)
                            <option value="{{$account->id}}">{{$account->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-2">
                    <input type="text" placeholder="Bank Name"
                    name="bank_name" class="w-100 form-control rounded-0">
                    <span class="error"> </span>
                </div>
                <div class="mt-2">
                    <input type="text" placeholder="Account Name"
                    name="account_name" class="w-100 form-control rounded-0">
                    <span class="error"> </span>
                </div>
                <div class="mt-2">
                    <input type="text" placeholder="Account Number"
                    name="account_number" class="w-100 form-control rounded-0">
                    <span class="error"> </span>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button 
                    type="submit"
                    data-url=""
                    disabled
                    class="btn btn-primary fs-4 fw-bold">
                    Save
                    <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>