<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold" id="userModalLabel">Subadmin Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?=route('subadmin.create')?>" method="POST">
                    <div class="mt-2">
                        <input type="text" name="firstname"
                        placeholder="Firstname" class="w-100 form-control rounded-0">
                        <span class="error"> </span>
                    </div>
                    <div class="mt-2">
                        <input type="text" name="lastname"
                        placeholder="Lastname" class="w-100 form-control rounded-0">
                        <span class="error"> </span>
                    </div>
                    <div class="mt-2">
                        <input type="email" name="email" readonly
                        placeholder="Email" class="w-100 form-control rounded-0">
                        <span class="error"> </span>
                    </div>
                    <div class="mt-2">
                        <input type="text" name="phone" readonly
                        placeholder="phone" class="w-100 form-control rounded-0">
                        <span class="error"> </span>
                    </div>
                    <input type="hidden" name="id"
                    placeholder="id" class="w-100 form-control rounded-0">
                    <div class="mt-2">
                        <select class="w-100 form-control rounded-0" name="role" readonly>
                            @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        <span class="error"> </span>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button 
                        type="button"
                        id="editAdmin"
                        class="custom-btn fs-4 fw-bold">
                        Submit
                        <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>