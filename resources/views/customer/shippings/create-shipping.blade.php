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
                                <div class="progress bg-primary"></div>
                                <p class="fw-semibold" style="color:#1E1E1EBF">Sender<p>
                            </div>
                            <div class="d-flex flex-column align-items-center mr-2">
                                <div class="progress"></div>
                                <p class="fw-semibold" style="color:#1E1E1EBF">Receiver<p>
                            </div>
                            <div class="d-flex flex-column align-items-center mr-2">
                                <div class="progress"></div>
                                <p class="fw-semibold" style="color:#1E1E1EBF">Item Details<p>
                            </div>
                            <div class="d-flex flex-column align-items-center">
                                <div class="progress"></div>
                                <p class="fw-semibold" style="color:#1E1E1EBF">Carrier and Cost<p>
                            </div>
                        </div>
                    </div>

                    @include('customer.shippings.components.sender')
                    @include('customer.shippings.components.receiver')
                    @include('customer.shippings.components.add-item')
                    @include('customer.shippings.components.add-carrier')
                    @include('customer.shippings.components.checkout')

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
    let states = [];
    let cities = [];

    const displayError = (formId, index, fieldName, errorMessage) => {
        $(`#${formId} .error`).eq(index).text(errorMessage);
        $(`#${formId} input[name='${fieldName}']`).css("border", "1px solid #FA150A");
    };

    const validate = (formId, inputsArray) => {
        const errors = {};
    
        inputsArray.forEach(({ inputName, inputValue, constraints }, index) => {
            const { required, string, min_length, max_length, email, phone, has_special_character, must_have_number, match } = constraints;
            const inputField = $(`#${formId} input[name='${inputName}']`);

            const specialCharsRegex = /[!@#$%^&*(),.?":{}|<>]/;
            const numberRegex = /\d/;
        
            const validationRules = {
                //required: required ? (typeof inputValue === 'string' && inputValue.trim() !== '') || !inputValue : true,
                //required: required ? inputValue.trim() !== '' || !inputValue : true,
                required: required ? !!inputValue : true,
                string: string ? typeof inputValue === 'string' || !inputValue : true,
                phone: phone ? /^[0-9]+$/.test(inputValue) || !inputValue : true,
                min_length: inputValue.length >= min_length || !min_length,
                max_length: inputValue.length <= max_length || !max_length,
                email: email ? /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(inputValue) || !inputValue : true,
                has_special_character: has_special_character ? specialCharsRegex.test(inputValue) || !inputValue : true,
                must_have_number: must_have_number ? numberRegex.test(inputValue) || !inputValue : true,
                match: match ? (inputValue === match) || !inputValue : true,
            };
        
            const errorMessages = {
                required: inputName+' field is required',
                string: inputName + ' must be a string',
                phone: inputName + ' must be a valid phone number',
                min_length: inputName+` must have at least ${min_length} characters`,
                max_length: inputName+` must not exceed ${max_length} characters`,
                email: inputName+' must be a valid email',
                has_special_character: inputName+' must have special characters',
                must_have_number: inputName+' must have a number',
                match: 'Does not match the specified field',
            };
        
            /*const failedRules = Object.entries(validationRules)
            .filter(([rule, pass]) => !pass)
            .map(([rule]) => errorMessages[rule]);

            if (failedRules.length > 0) {
                validationResults[inputName] = failedRules;
            }*/
            
            Object.entries(validationRules)
            .filter(([rule, pass]) => !pass)
            .forEach(([rule]) => {
                if (!errors[inputName]) {
                    errors[inputName] = [];
                }
                errors[inputName].push(errorMessages[rule]);
                displayError(formId, index, inputName, errorMessages[rule]);
            });

        });
    
        return errors;
    };

    $(document).ready(function(){
        let formData = { "sender": {}, "receiver": {}, "items": [] };
        $(".next").on("click", function(event){
            event.preventDefault();
            let type = $(this).data("type");
            var currentStep = $(this).closest(".step");
            var nextStep = currentStep.next(".step");
            //Store form data
            let $currentForm = $(this).closest("form");
            $currentForm.find("input, select").each(function(){
                var fieldName = $(this).attr("name");
                var fieldType = $(this).prop("tagName").toLowerCase();
                if(fieldType === "input" || fieldType === "select") {
                    formData[type][fieldName] = $(this).val();
                }
            });
            let inputs = [];
            switch(type){
                case "sender":
                    inputs = [
                        { inputName: 'firstname', inputValue: $("#sender input[name='firstname']").val(), constraints: { required: true, max_length: 50 } },
                        { inputName: 'lastname', inputValue: $("#sender input[name='lastname']").val(), constraints: { required: true, max_length: 50 } },
                        { inputName: 'email', inputValue: $("#sender input[name='email']").val(), constraints: { required: true, email: true } },
                        { inputName: 'phone', inputValue: $("#sender input[name='phone']").val(), constraints: { required: true, phone: true } },
                        { inputName: 'address1', inputValue: $("#sender input[name='address1']").val(), constraints: { required: true } },
                        { inputName: 'address2', inputValue: $("#sender input[name='address2']").val(), constraints: { required: false } },
                        { inputName: 'country', inputValue: $("#sender select[name='country']").val(), constraints: { required: true } },
                        { inputName: 'state', inputValue: $("#sender select[name='state']").val(), constraints: { required: true } },
                        { inputName: 'city', inputValue: $("#sender select[name='city']").val(), constraints: { required: true } },
                        { inputName: 'zip_code', inputValue: $("#sender input[name='zip_code']").val(), constraints: { required: true } }
                    ];
                break;
                case "receiver":
                    inputs = [
                        { inputName: 'firstname', inputValue: $("#receiver input[name='firstname']").val(), constraints: { required: true, max_length: 50 } },
                        { inputName: 'lastname', inputValue: $("#receiver input[name='lastname']").val(), constraints: { required: true, max_length: 50 } },
                        { inputName: 'email', inputValue: $("#receiver input[name='email']").val(), constraints: { required: true, email: true } },
                        { inputName: 'phone', inputValue: $("#receiver input[name='phone']").val(), constraints: { required: true, phone: true } },
                        { inputName: 'address1', inputValue: $("#receiver input[name='address1']").val(), constraints: { required: true } },
                        { inputName: 'address2', inputValue: $("#receiver input[name='address2']").val(), constraints: { required: false } },
                        { inputName: 'country', inputValue: $("#receiver select[name='country']").val(), constraints: { required: true } },
                        { inputName: 'state', inputValue: $("#receiver select[name='state']").val(), constraints: { required: true } },
                        { inputName: 'city', inputValue: $("#receiver select[name='city']").val(), constraints: { required: true } },
                        { inputName: 'zip_code', inputValue: $("#receiver input[name='zip_code']").val(), constraints: { required: true } }
                    ];
                break;
            }
            const errors = validate(type, inputs);
            if (Object.keys(errors).length === 0) {
                //alert("Sender validation passed!");
                currentStep.hide();
                nextStep.show();
                if(type == "sender"){
                    $(".progress").removeClass("bg-primary");
                    $(".progress").eq(1).addClass("bg-primary");
                }else if(type == "receiver"){
                    $(".progress").removeClass("bg-primary");
                    $(".progress").eq(2).addClass("bg-primary");
                }
                //alert(JSON.stringify(formData));
            } else {
                alert("Sender validation failed!");
            }
        });

        $(".prev").on("click", function(event){
            event.preventDefault();
            var currentStep = $(this).closest(".step");
            var prevStep = currentStep.prev(".step");
            currentStep.hide();
            prevStep.show();
        });

        function fetchStates(formIdentifier, countryId) {
            const config = {
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                    "X-Requested-With": "XMLHttpRequest"
                }
            };
            axios.get(`${baseUrl}/states/${countryId}`, config)
            .then((res) => {
                let states = res.data.results;
                // Update the state select input in the specified form
                $(`${formIdentifier} select[name='state']`).empty(); // Clear previous options
                $(`${formIdentifier} select[name='city']`).empty(); // Clear previous options
                $(`${formIdentifier} select[name='city']`).append(`
                    <option value="">--Select one---</option>
                `);
                states.forEach(state => {
                    $(`${formIdentifier} select[name='state']`).append(`
                        <option value="${state.id}">${state.name}</option>`
                    );
                });
            });
        }
        // Event handler for country select change for sender form
        $("#sender select[name='country']").on("change", function(event) {
            event.preventDefault();
            let countryId = $(this).val();
            fetchStates("#sender", countryId);
        });
        // Event handler for country select change for receiver form
        $("#receiver select[name='country']").on("change", function(event) {
            event.preventDefault();
            let countryId = $(this).val();
            fetchStates("#receiver", countryId);
        });
        // Event handler for country select change for shipping form
        $("#shipping select[name='country']").on("change", function(event) {
            event.preventDefault();
            let countryId = $(this).val();
            fetchStates("#shipping", countryId);
        });

        function fetchCities(formIdentifier, stateId) {
            const config = {
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                    "X-Requested-With": "XMLHttpRequest"
                }
            };
            axios.get(`${baseUrl}/cities/${stateId}`, config)
            .then((res) => {
                let cities = res.data.results;
                // Update the state select input in the specified form
                $(`${formIdentifier} select[name='city']`).empty(); // Clear previous options
                cities.forEach(city => {
                    $(`${formIdentifier} select[name='city']`).append(`
                        <option value="${city.id}">${city.name}</option>`
                    );
                });
            });
        }
        // Event handler for state select change for sender form
        $("#sender select[name='state']").on("change", function(event) {
            event.preventDefault();
            let stateId = $(this).val();
            fetchCities("#sender", stateId);
        });
        // Event handler for state select change for receiver form
        $("#receiver select[name='state']").on("change", function(event) {
            event.preventDefault();
            let stateId = $(this).val();
            fetchCities("#receiver", stateId);
        });
        // Event handler for state select change for shipping form
        $("#shipping select[name='state']").on("change", function(event) {
            event.preventDefault();
            let stateId = $(this).val();
            fetchCities("#shipping", stateId);
        });

        $("#addItem").on("click", function(event) {
            event.preventDefault();
            let item = {};
            const action = $(this).data("action");
            let $currentForm = $(this).closest("form");
            $currentForm.find("input, select").each(function(){
                var fieldName = $(this).attr("name");
                var fieldType = $(this).prop("tagName").toLowerCase();
                if(fieldType === "input" || fieldType === "select") {
                    item[fieldName] = $(this).val();
                }
            });
            switch(action){
                case "create":
                    formData.items.push(item);
                break;
                case "update":
                    formData.items[parseInt($(this).data("item"))] = item;
                    $(this).data("action", "create");
                    $(this).data("item", "");
                break;
            };
            $(".items-table tbody").empty();
            formData.items.forEach((item, index) => {
                $(".items-table tbody").append(`
                    <tr style="">
                        <td scope="row">${item.name}</td>
                        <td scope="row">${item.quantity}</td>
                        <td scope="row">${item.weight}kg</td>
                        <td scope="row"><b>₦</b>${item.name}</td>
                        <td scope="row">
                            <a class="update-item" data-id="${index}" data-action="edit" type="button">
                                <img src="{{asset('assets/images/icons/file-edit.svg')}}" />
                            </a>
                        </td>
                        <td scope="row">
                            <a class="update-item" data-id="${index}" data-action="delete" type="button">
                                <img src="{{asset('assets/images/icons/file-edit.svg')}}" />
                            </a>
                        </td>
                    </tr>  
                `);
            });
            $currentForm[0].reset();
            $currentForm.addClass("d-none");
        });

        $(document).on("click", ".update-item", function(event){
            event.preventDefault();
            const itemId = $(this).data("id");
            const action = $(this).data("action");
            switch(action){
                case "edit":
                    let item = formData.items[itemId];
                    var $form = $("#addItemForm");
                    $form.find("input, select").each(function(){
                        let fieldName = $(this).attr("name");  // Get the name attribute of the input/select element
                        // Check if the current input/select element exists in the item object
                        if(fieldName && item.hasOwnProperty(fieldName)) {
                            $(this).val(item[fieldName]);   // Set the value of the input/select element to the corresponding property of the item object
                        }
                    });
                    $("#addItem").data("action", "update");
                    $("#addItem").data("item", itemId);
                    $form.removeClass("d-none");
                break;
                case "delete":
                    // Delete the object at the specified index
                    formData.items.splice(itemId, 1);
                    $(".items-table tbody").empty();
                    formData.items.forEach((item, index) => {
                        $(".items-table tbody").append(`
                            <tr style="">
                                <td scope="row">${item.name}</td>
                                <td scope="row">${item.quantity}</td>
                                <td scope="row">${item.weight}kg</td>
                                <td scope="row"><b>₦</b>${item.name}</td>
                                <td scope="row">
                                    <a class="update-item" data-id="${index}" data-action="edit" type="button">
                                        <img src="{{asset('assets/images/icons/file-edit.svg')}}" />
                                    </a>
                                </td>
                                <td scope="row">
                                    <a class="update-item" data-id="${index}" data-action="delete" type="button">
                                        <img src="{{asset('assets/images/icons/file-edit.svg')}}" />
                                    </a>
                                </td>
                            </tr>  
                        `);
                    });
                break;
            }
        });

        $(".openAddItemForm").on("click", function(event) {
            event.preventDefault();
            var $form = $("#addItemForm");
            if($form.hasClass("d-none")){
                $form.removeClass("d-none");
            }
        });

        $(".radio-group").click(function() {
            // Remove the 'selected' class from all radio items
            $(".radio-group").removeClass("selected");
            
            // Add the 'selected' class to the clicked radio item
            $(this).addClass("selected");
            
            // Perform any other actions based on the selected item
        });

    });

</script>
@include("customer.layouts.footer")