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
                <div class="">
                    <img src="" class="avatar rounded-circle" width="50" height="50">
                </div>
                <div class="mt-2">
                    <input type="text"
                    placeholder="firstname" class="w-100 form-control rounded-0">
                </div>
                <div class="mt-2">
                    <input type="text"
                    placeholder="lastname" class="w-100 form-control rounded-0">
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
                    <input type="text"
                    placeholder="country" class="w-100 form-control rounded-0">
                </div>
                <div class="mt-2">
                    <select class="w-100 form-control rounded-0" name="account">
                        @foreach($accounts as $account)
                            <option value="{{$account->id}}">{{$account->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button 
                    type="button"
                    disabled
                    class="btn btn-primary fs-4 fw-bold">
                    Submit
                    <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>