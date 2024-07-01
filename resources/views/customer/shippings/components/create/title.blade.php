<div class="row justify-content-center step" style="display:non;" id="sender">
    <div class="col-xl-9 col-lg-9">
        <div class="card w-100">
            <div class="card-body">
                <form action="{{route('add-shipment')}}" method="POST" id="title-form">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-sm-12 mt-sm-2">
                            <h4 style="color:#1E1E1E66">Create  New Shipment</h4>
                            <div class="w-100 mr-2">
                                <label class="custom-input-label">Shipment Title </label>
                                <small class="text-info">A descriptive title helps you identify a shipment at a glance</small>
                                <input type="text" name="title" placeholder="e.g June Shipment to Fayiza in Canada" class="custom-input" id="title" />
                            </div>
                            <div class="text-danger backend-msg">
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </div>
                            
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        
                        <div class="">
                            <button  type="button" data-to="" data-type="sender" class="custom-btn fs-4 fw-bold next" id="next" onclick="validateForm()">
                                Next <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    const validateForm = () => {
        document.querySelectorAll(".backend-msg").forEach(function(field, index){
            field.innerHTML = '';
        })
        const submitBtn = document.querySelector(".next");
        const oldBtnHTML = submitBtn.innerHTML;
        setBtnLoading(submitBtn);

        const validation = runValidation([
            {
                id:"title",
                rules: {'required':true}
            } 
        ]);

        if(validation === true){
            submitForm();
            setBtnNotLoading(submitBtn, oldBtnHTML)
        }else{
            setBtnNotLoading(submitBtn, oldBtnHTML)
        }
    }

    const submitForm = () => {
        document.querySelector("#title-form").submit();
    }
</script>