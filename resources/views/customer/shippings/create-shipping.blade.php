@include("customer.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Shipping > Create Shipment</h5>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col d-flex justify-content-center">
                            <div class="d-flex flex-column align-items-center mr-2">
                                <div class="bg-primary" style="height:10px;width:100px;border-radius:10px;"></div>
                                <p class="fw-semibold" style="color:#1E1E1EBF">Sender<p>
                            </div>
                            <div class="d-flex flex-column align-items-center mr-2">
                                <div class="" style="background-color:#DFE4F0;height:10px;width:100px;border-radius:10px;"></div>
                                <p class="fw-semibold" style="color:#1E1E1EBF">Receiver<p>
                            </div>
                            <div class="d-flex flex-column align-items-center mr-2">
                                <div class="" style="background-color:#DFE4F0;height:10px;width:100px;border-radius:10px;"></div>
                                <p class="fw-semibold" style="color:#1E1E1EBF">Item Details<p>
                            </div>
                            <div class="d-flex flex-column align-items-center">
                                <div class="" style="background-color:#DFE4F0;height:10px;width:100px;border-radius:10px;"></div>
                                <p class="fw-semibold" style="color:#1E1E1EBF">Carrier and Cost<p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body">
                                    @include('customer.shippings.components.sender')
                                    @include('customer.shippings.components.receiver')
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('customer.modals.broadcast-modal')
                </div>
            </div>
            <!--  End of Row 1 -->
        </div>
    </div>
</div>
<script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/slim.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

<script src="{{asset('assets/libs/axios/axios.js')}}"></script>
<script src="{{asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/dist/simplebar.js')}}"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    let token = $("meta[name='csrf-token']").attr("content");
    let baseUrl = $("meta[name='base-url']").attr("content");

    const validate = (inputsArray) => {
        const validationResults = {};
    
        inputsArray.forEach(({ inputName, inputValue, constraints }) => {
            const { required, min_length, max_length, email, has_special_character, must_have_number, match } = constraints;
        
            const specialCharsRegex = /[!@#$%^&*(),.?":{}|<>]/;
            const numberRegex = /\d/;
        
            const validationRules = {
                required: required ? !!inputValue : true,
                min_length: inputValue.length >= min_length || !min_length,
                max_length: inputValue.length <= max_length || !max_length,
                email: email ? /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(inputValue) || !inputValue : true,
                has_special_character: has_special_character ? specialCharsRegex.test(inputValue) || !inputValue : true,
                must_have_number: must_have_number ? numberRegex.test(inputValue) || !inputValue : true,
                match: match ? (inputValue === match) || !inputValue : true,
            };
        
            const errorMessages = {
                required: inputName+' field is required',
                min_length: inputName+` must have at least ${min_length} characters`,
                max_length: inputName+` must not exceed ${max_length} characters`,
                email: inputName+' must be a valid email',
                has_special_character: inputName+' must have special characters',
                must_have_number: inputName+' must have a number',
                match: 'Does not match the specified field',
            };
        
            const failedRules = Object.entries(validationRules)
            .filter(([rule, pass]) => !pass)
            .map(([rule]) => errorMessages[rule]);

            if (failedRules.length > 0) {
                validationResults[inputName] = failedRules;
            }
        });
    
        return validationResults;
    };

    $(document).ready(function(){
        let formData = {};
        $(".next").on("click", function(event){
            event.preventDefault();
            let $currentForm = $(this).closest("form");
            let $nextForm = $currentForm.next("form");
            //Store form data
            $currentForm.find("input").each(function(){
                formData[$(this).attr("name")] = $(this).val();
            });
            //alert(JSON.stringify(formData));
            
            /*const errors = validate([
                {
                    inputName: 'firstname', 
                    inputValue: $("#sender input[name='firstname']").val(),
                    constraints: {required: true, max_length: 50}
                },
                {
                    inputName: 'lastname', 
                    inputValue: $("#sender input[name='lastname']").val(),
                    constraints: {required: true, max_length: 50}
                },
                {
                    inputName: 'email', 
                    inputValue: $("#sender input[name='email']"),
                    constraints: {required: true, email: true}
                },
                {
                    inputName: 'phone', 
                    inputValue: $("#sender input[name='phone']"),
                    constraints: {required: true}
                }
            ]);
            if(Object.keys(errors).length === 0){
                alert("hshshsh");
            }else{
                if(errors.firstname){
                    $('#sender .error').eq(0).text(errors.firstname);
                    $("#sender input[name='firstname']").css("border", "1px solid #FA150A");
                }
                if(errors.lastname){
                    $('#sender .error').eq(1).text(errors.lastname);
                    $("#sender input[name='lastname']").css("border", "1px solid #FA150A");
                }
                if(errors.email){
                    $('#sender .error').eq(2).text(errors.email);
                    $("#sender input[name='email']").css("border", "1px solid #FA150A");
                }
                if(errors.phone){
                    $('#sender .error').eq(3).text(errors.phone);
                    $("#sender input[name='phone']").css("border", "1px solid #FA150A");
                }
            }*/

            $currentForm.hide();
            $nextForm.show();
            //$("#sender").hide();
            //$("#receiver").show();
        });

        $(".prev").on("click", function(event){
            event.preventDefault();
            let $currentForm = $(this).closest("form");
            var $prevForm = $currentForm.prev("form");
            //Retrieve and populate previous form data
            $prevForm.find("input").each(function(){
                var field = $(this).attr("name");
                $(this).val(field);
            });
            alert(JSON.stringify(formData));
            //$currentForm.hide();
            //$nextForm.show();
        });
    });
</script>
@include("customer.layouts.footer")