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
                <input type="hidden" name="user_id">
                <div class="mt-2">
                    <input type="text" readonly placeholder="firstname" name="firstname" class="w-100 form-control rounded-0">
                </div>
                <div class="mt-2">
                    <input type="text" readonly placeholder="lasstname" name="lastname" class="w-100 form-control rounded-0">
                </div>
                <div class="mt-2">
                    <input type="text" placeholder="email" name="email" readonly class="w-100 form-control rounded-0">
                </div>
                <div class="mt-2">
                    <input type="text" placeholder="phone" name="phone" readonly class="w-100 form-control rounded-0">
                </div>
                <div class="mt-2">
                    <input type="text" readonly placeholder="country" name="country" class="w-100 form-control rounded-0">
                </div>
                
                <div class="mt-2">
                    <select class="w-100 form-control rounded-0" readonly name="account">
                        @foreach($accounts as $account)
                            <option value="{{$account->id}}">{{$account->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-2">
                    <input type="text" dva="true" placeholder="Bank Name" name="bank_name" class="w-100 form-control rounded-0">
                    <span class="error"> </span>
                </div>
                <div class="mt-2">
                    <input type="text" dva="true" placeholder="Account Name" name="account_name" class="w-100 form-control rounded-0">
                    <span class="error"> </span>
                </div>
                <div class="mt-2">
                    <input type="text" dva="true" placeholder="Account Number" name="account_number" class="w-100 form-control rounded-0">
                    <span class="error"> </span>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" data-url="" disabled class="btn btn-primary fs-4 fw-bold" id="dva-update"> Save
                        <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('#userModal').querySelectorAll('input').forEach((input)=>{
    
        input.addEventListener('dblclick', function(){
            input.removeAttribute('readonly');
            if(input.hasAttribute('dva')){
                document.querySelector('#dva-update').removeAttribute('disabled')
            }
        })
    });

    document.querySelector('#userModal').querySelectorAll('input').forEach((input)=>{
        input.addEventListener('blur', function(){
            if(input.getAttribute('readonly') != "true"){
                input.setAttribute('readonly', true);
                if(!input.hasAttribute('dva')){
                    
                    
                    document.querySelector('#dva-update').removeAttribute('disabled')
                    // const data = {}
                    // data[input.getAttribute('name')] = input.value
                    updateUser(input.getAttribute('name'), input.value)
                }
            }
            
        })
    });

    const updateUser = async (param, value) => {
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                "X-Requested-With": "XMLHttpRequest"
            }
        };
        const data = {user_id:  document.querySelector("[name=user_id]").value}
        data[param] = value;
        axios.post('{{route("admin.update-customer-profile")}}', data, config)
        .then(function(response){
            let message = response?.data?.message;
            console.log(response);
            console.log(response?.data);
        }).catch(function(error){
            console.log(error);
            alert("Something went wrong")
            
        });
    }
</script>