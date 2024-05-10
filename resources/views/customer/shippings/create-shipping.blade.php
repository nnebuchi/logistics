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

                    @include('customer.shippings.components.create.sender')
                    @include('customer.shippings.components.create.receiver')
                    @include('customer.shippings.components.create.add-item')
                    @include('customer.shippings.components.create.add-carrier')
                    @include('customer.shippings.components.create.checkout')

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

    const displayError = (formId, index, fieldName, errorMessage) => {
        $(`#${formId} .error`).eq(index).text(errorMessage);
        $(`#${formId} input[name='${fieldName}']`).css("border", "1px solid #FA150A");
    };

    const validate = (formId, inputsArray) => {
        const errors = {};
    
        inputsArray.forEach(({ inputName, inputValue, constraints }, index) => {
            const { 
                required, string, min_length, max_length, email, phone, 
                has_special_character, must_have_number, match, numeric, integer 
            } = constraints;
            const inputField = $(`#${formId} input[name='${inputName}']`);

            const specialCharsRegex = /[!@#$%^&*(),.?":{}|<>]/;
            const numberRegex = /\d/;
        
            const validationRules = {
                required: required ? !!inputValue : true,
                string: string ? typeof inputValue === 'string' || !inputValue : true,
                phone: phone ? /^\+?[0-9]+$/.test(inputValue) || !inputValue : true,
                min_length: inputValue.length >= min_length || !min_length,
                max_length: inputValue.length <= max_length || !max_length,
                email: email ? /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(inputValue) || !inputValue : true,
                has_special_character: has_special_character ? specialCharsRegex.test(inputValue) || !inputValue : true,
                must_have_number: must_have_number ? numberRegex.test(inputValue) || !inputValue : true,
                match: match ? (inputValue === match) || !inputValue : true,
                numeric: numeric ? !isNaN(parseFloat(inputValue)) && isFinite(inputValue) || !inputValue : true,
                integer: integer ? Number.isInteger(Number(inputValue)) || !inputValue : true,
            };
            
            // If underscore is present, replace it with a space
            if(inputName.includes("_")){
                inputName = inputName.replace("_", " ");
            }
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
                numeric: "Please enter a valid number.",
                integer: "Please enter a valid integer."
            };
        
            /*const failedRules = Object.entries(validationRules)
            .filter(([rule, pass]) => !pass)
            .map(([rule]) => errorMessages[rule]);

            if (failedRules.length > 0) {
                errors[inputName] = failedRules;
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
        let formData = { "sender": {}, "receiver": {}, "items": [], "shipment": {}, "total": "" };
        let parcel = {};
        let carriers = [];
        let selectedCarrier = {};
        const createParcel = async (items) => {
            let payload = {
                "description": 'New parcel for shipment',
                "weight_unit": "kg",
                "items": [], // Initialize an empty array for items,
                "address_from": formData.sender.address_id,
                "address_to": formData.receiver.address_id
            };
            // Loop through the items array and construct payload items
            items.forEach(item => {
                payload.items.push({
                    "name": item.name,
                    "hs_code": item.hs_code,
                    "description": item.description,
                    "type": "parcel",
                    "currency": "NGN",
                    "value": parseFloat(item.value),
                    "quantity": parseInt(item.quantity),
                    "weight": parseFloat(item.weight)
                });
            });
            
            try{
                const config = {
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                        "X-Requested-With": "XMLHttpRequest"
                    }
                };
                const response = await axios.post("<?=route('shipment.create')?>", payload, config);
                parcel = response.data.results.parcel;
                formData.shipment = response.data.results.shipment;
                carriers = response.data.results.rates;
                console.log(response.data.results);
            } catch (error) {
                console.error('An error occurred:', error);
            }
        }
        $(".next").on("click", async function(event){
            event.preventDefault();
            let type = $(this).data("type");
            var currentStep = $(this).closest(".step");
            var nextStep = currentStep.next(".step");
            //Store form data
            let $currentForm = $(this).closest("form");
            $(`#${type} .error`).text('');
            $(`#${type} input`).css("borderColor", "transparent");
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
                        { inputName: 'phone', inputValue: $("#sender input[name='phone']").val(), constraints: { required: true, phone: true, min_length: 8 } },
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
                        { inputName: 'phone', inputValue: $("#receiver input[name='phone']").val(), constraints: { required: true, phone: true, min_length: 8 } },
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
                let payload = {
                    "first_name": formData[type].firstname,
                    "last_name": formData[type].lastname,
                    "email": formData[type].email,
                    "phone": formData[type].phone,
                    "city": formData[type].city,
                    "country": formData[type].country,
                    "state": formData[type].state,
                    "zip": formData[type].zip_code,
                    "line1": formData[type].address1
                };
                const config = {
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        Authorization: "Bearer sk_live_HYNPAz62alrkgOI3E3Nj1mB0uojcRFWJ"
                    }
                };
                axios.post(`https://api.terminal.africa/v1/addresses`, payload, config)
                .then(function(response){
                    let results = response.data.data;
                    formData[type] = results;
                    currentStep.hide();
                    nextStep.show();
                    if(type == "sender"){
                        $(".progress").removeClass("bg-primary");
                        $(".progress").eq(1).addClass("bg-primary");
                    }else if(type == "receiver"){
                        $(".progress").removeClass("bg-primary");
                        $(".progress").eq(2).addClass("bg-primary");
                    }
                }).catch(function(error){
                    //alert(error);
                })
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
                    <option value="">Choose one...</option>
                `);
                $(`${formIdentifier} select[name='state']`).append(`
                    <option value="">Choose one...</option>
                `);
                states.forEach(state => {
                    $(`${formIdentifier} select[name='state']`).append(`
                        <option value="${state.name}" data-id="${state.id}">${state.name}</option>`
                    );
                });
            });
        }
        // Event handler for country select change for sender form
        $("#sender select[name='country']").on("change", function(event) {
            event.preventDefault();
            //let countryId = $(this).val();
            let countryId = $(this).find('option:selected').data('id');
            // Attach country code
            var countryCode = $(this).find('option:selected').data('phonecode');
            $("input[name='phone']").val(countryCode);
            $("input[name='phone']").data("phone", countryCode);
            fetchStates("#sender", countryId);
        });
        // Event handler for country select change for receiver form
        $("#receiver select[name='country']").on("change", function(event) {
            event.preventDefault();
            //let countryId = $(this).val();
            let countryId = $(this).find('option:selected').data('id');
            // Attach country code
            var countryCode = $(this).find('option:selected').data('phonecode');
            $("input[name='phone']").val(countryCode);
            $("input[name='phone']").data("phone", countryCode);
            fetchStates("#receiver", countryId);
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
                $(`${formIdentifier} select[name='city']`).append(`
                    <option value="">Choose one...</option>
                `);
                cities.forEach(city => {
                    $(`${formIdentifier} select[name='city']`).append(`
                        <option value="${city.name}" data-id="${city.id}">${city.name}</option>`
                    );
                });
            });
        }
        // Event handler for state select change for sender form
        $("#sender select[name='state']").on("change", function(event) {
            event.preventDefault();
            //let stateId = $(this).val();
            let stateId = $(this).find('option:selected').data('id');
            fetchCities("#sender", stateId);
        });
        // Event handler for state select change for receiver form
        $("#receiver select[name='state']").on("change", function(event) {
            event.preventDefault();
            //let stateId = $(this).val();
            let stateId = $(this).find('option:selected').data('id');
            fetchCities("#receiver", stateId);
        });

        function fetchSubCategories(formIdentifier, $chapter) {
            const config = {
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer sk_live_HYNPAz62alrkgOI3E3Nj1mB0uojcRFWJ"
                }
            };
            axios.get(`https://api.terminal.africa/v1/hs-codes/simplified/category?chapter=${$chapter}`, config)
            .then((res) => {
                let categories = res.data.data;
                // Update the state select input in the specified form
                $(`${formIdentifier} select[name='sub_category']`).empty(); // Clear previous options
                $(`${formIdentifier} select[name='sub_category']`).append(`
                    <option value="">Choose one...</option>
                `); // Clear previous options
                $(`${formIdentifier} select[name='hs_code']`).empty(); // Clear previous options
                $(`${formIdentifier} select[name='hs_code']`).append(`
                    <option value="">Choose one...</option>
                `);
                categories.forEach(category => {
                    $(`${formIdentifier} select[name='sub_category']`).append(`
                        <option value="${category._id}" data-id="${$chapter}">${category.category}</option>`
                    );
                });
            });
        }
        // Event handler for state select change for sender form
        $("#addItemForm select[name='category']").on("change", function(event) {
            event.preventDefault();
            let $id = $(this).val();
            fetchSubCategories("#addItemForm", $id);
        });
        function fetchHsCode(formIdentifier, $chapter, $category) {
            const config = {
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    Authorization: "Bearer sk_live_HYNPAz62alrkgOI3E3Nj1mB0uojcRFWJ"
                }
            };
            axios.get(`https://api.terminal.africa/v1/hs-codes/simplified?chapter=${$chapter}&category_code=${$category}`, config)
            .then((res) => {
                let hs_codes = res.data?.data?.hs_codes;
                // Update the state select input in the specified form
                $(`${formIdentifier} select[name='hs_code']`).empty(); // Clear previous options
                hs_codes.forEach(hs_code => {
                    $(`${formIdentifier} select[name='hs_code']`).append(`
                        <option value="${hs_code.hs_code}" data-description="${hs_code.sub_category}">${hs_code.sub_category}</option>`
                    );
                });
            });
        }
        // Event handler for state select change for sender form
        $("#addItemForm select[name='sub_category']").on("change", function(event) {
            event.preventDefault();
            let $category = $(this).val();
            let $chapter = $(this).find('option:selected').data('id');
            fetchHsCode("#addItemForm", $chapter, $category);
        });

        $("#addItemForm input[name='quantity'], #addItemForm input[name='value'], #addItemForm input[name='weight']").on("input", function() {
            // Get the input value
            let value = $(this).val();
            // Remove any non-numeric characters except for dot '.'
            let sanitizedValue = value.replace(/[^\d.]/g, ''); // Allow only digits and one dot
            // Remove extra dots except the first one
            sanitizedValue = sanitizedValue.replace(/\.(?=.*\.)/g, '');
            // Update the input value with the sanitized value
            $(this).val(sanitizedValue);
        });

        $("#addItem").on("click", async function(event) {
            event.preventDefault();
            let item = {};
            const action = $(this).data("action");
            let $currentForm = $(this).closest("form");
            $currentForm.find("input, select").each(function(){
                var fieldName = $(this).attr("name");
                var fieldType = $(this).prop("tagName").toLowerCase();
                if(fieldType === "input" || fieldType === "select") {
                    item[fieldName] = $(this).val();
                    if(fieldName == "hs_code"){
                        let description = $(this).find("option:selected").data("description");
                        item["description"] = description;
                    }
                }
            });
            $(`#shipping .error`).text('');
            $(`#shipping input`).css("borderColor", "transparent");
            inputs = [
                { inputName: 'name', inputValue: $("#shipping input[name='name']").val(), constraints: { required: true } },
                { inputName: 'category', inputValue: $("#shipping select[name='category']").val(), constraints: { required: true } },
                { inputName: 'sub_category', inputValue: $("#shipping select[name='sub_category']").val(), constraints: { required: true } },
                { inputName: 'hs_code', inputValue: $("#shipping select[name='hs_code']").val(), constraints: { required: true } },
                { inputName: 'weight', inputValue: $("#shipping input[name='weight']").val(), constraints: { required: true } },
                { inputName: 'quantity', inputValue: $("#shipping input[name='quantity']").val(), constraints: { required: true, integer: true } },
                { inputName: 'value', inputValue: $("#shipping input[name='value']").val(), constraints: { required: true } }
            ];
            const errors = validate("shipping", inputs);
            if (Object.keys(errors).length === 0) {
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
                            <td scope="row">${item.quantity}pieces</td>
                            <td scope="row">${item.weight}kg</td>
                            <td scope="row"><b>₦</b>${item?.value.toLocaleString()}</td>
                            <td scope="row">
                                <a class="update-item" data-id="${index}" data-action="edit" type="button">
                                    <img src="{{asset('assets/images/icons/material-edit-outline.svg')}}" width="20" />
                                </a>
                            </td>
                            <td scope="row">
                                <a class="update-item" data-id="${index}" data-action="delete" type="button">
                                    <img src="{{asset('assets/images/icons/mdi-light_delete.svg')}}" width="20" />
                                </a>
                            </td>
                        </tr>  
                    `);
                });
                $currentForm[0].reset();
                $("#addItemModal").modal('hide');
            } else {
                //alert("Sender validation failed!");
            }
            
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
                    $("#addItemModal").modal("show");
                break;
                case "delete":
                    // Delete the object at the specified index
                    formData.items.splice(itemId, 1);
                    $(".items-table tbody").empty();
                    formData.items.forEach((item, index) => {
                        $(".items-table tbody").append(`
                            <tr style="">
                            <td scope="row">${item.name}</td>
                            <td scope="row">${item.quantity}pieces</td>
                            <td scope="row">${item.weight}kg</td>
                            <td scope="row"><b>₦</b>${item?.value.toLocaleString()}</td>
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
                    $("#step3Btn").prop("disabled", !(formData.items.length != 0));
                break;
            }
        });

        $(".openAddItemModal").click(function() {
           $("#addItemModal").modal("show");
        });
        $("#addItemModal .close").on("click", function(){
            $("#addItemModal").modal("hide");
        });
        $('#addItemModal').on('hidden.bs.modal', function (e) {
            $("#addItemModal").modal("hide");
        });

        $("#pickUpBox label").click(function() {
            $("#pickUpBox label > div").find(".dots-line").css("border-color", "#233E8366");
            $(this).children("div").find(".dots-line").css("border-color", "#233E83");
            $("#pickUpBox label .dots").addClass("d-none");
            $(this).find(".dots").removeClass("d-none");
            
            $("#step3Btn").prop("disabled", !(formData.items.length != 0));
        });

        $(document).on("click", "#chooseCarrier .radio-group", function(){
            // Remove the 'selected' class from all radio items
            $(".radio-group").removeClass("selected");
            // Add the 'selected' class to the clicked radio item
            $(this).addClass("selected");

            $("#chooseCarrier .radio-group").find(".dots-line").css("border-color", "#233E8366");
            $(this).find(".dots-line").css("border-color", "#233E83");
            $("#chooseCarrier .radio-group .dots").addClass("d-none");
            $(this).find(".dots").removeClass("d-none");

            // Get the value of the selected radio button
            var selectedValue = $(this).find("input[type='radio']").val();
            selectedCarrier = carriers[parseInt(selectedValue)];

            $("#step4Btn").prop("disabled", false);
        });

        $("#step3Btn").click(async function(event) {
            event.preventDefault();
            var currentStep = $(this).closest(".step");
            var nextStep = currentStep.next(".step");
            
            await createParcel(formData.items);
            $(`#chooseCarrier`).empty(); // Clear previous options
            carriers.forEach((carrier, index) => {
                $(`#chooseCarrier`).append(`
                    <label for="${carrier.rate_id}" class="radio-group d-flex justify-content-between p-2" style="overflow-x:auto;">
                        <input type="radio" id="${carrier.rate_id}" name="carrier" value="${index}" class="d-none">
                        <div class="" style="min-width:200px">
                            <img src="${carrier.carrier_logo}" width="70" height="50" class="mr-2" alt="">
                            <p>${carrier.carrier_name}</p>
                        </div>
                        <div class="" style="min-width:150px">
                            <p>Pick Up: ${carrier.pickup_time}</p>
                            <p>Delivery: ${carrier.delivery_time}</p>
                        </div>
                        <div class="d-flex align-items-center" style="min-width:200px">
                            <p><b>₦</b>${carrier.amount}</p>
                        </div>
                        <div class="d-flex align-items-center" style="min-width:100px">
                            <div class="dots-line rounded-circle d-flex align-items-center justify-content-center" style="height:20px;width:20px;border:2px solid #233E8366;">
                                <div class="dots d-none rounded-circle" style="height:12.5px;width:12.5px;background-color:#233E83;"></div>
                            </div>
                        </div>
                    </label>
                `);
            });
            currentStep.hide();
            nextStep.show();
            $(".progress").removeClass("bg-primary");
            $(".progress").eq(3).addClass("bg-primary");
        });

        $("#step4Btn").click(function(event) {
            event.preventDefault();
            var currentStep = $(this).closest(".step");
            var nextStep = currentStep.next(".step");
            
            $('#checkout').find(".sender span").eq(0).text(formData.sender.first_name+" "+formData.sender.last_name);
            $('#checkout').find(".sender span").eq(1).text(formData.sender.email);
            $('#checkout').find(".sender span").eq(2).text(formData.sender.phone);
            $('#checkout').find(".sender span").eq(3).text(formData.sender.line1);

            $('#checkout').find(".receiver span").eq(0).text(formData.receiver.first_name+" "+formData.receiver.last_name);
            $('#checkout').find(".receiver span").eq(1).text(formData.receiver.email);
            $('#checkout').find(".receiver span").eq(2).text(formData.receiver.phone);
            $('#checkout').find(".receiver span").eq(3).text(formData.receiver.line1);

            $('#checkout').find(".carrier img").attr("src", selectedCarrier.carrier_logo);
            $('#checkout').find(".carrier span").eq(0).text(selectedCarrier.carrier_name);
            $('#checkout').find(".carrier span").eq(1).text(selectedCarrier.pickup_time);
            $('#checkout').find(".carrier span").eq(2).text(selectedCarrier.delivery_time);

            formData.items.forEach((item, index) => {
                $("#checkout .items").append(`
                    <div class="mt-2">
                        <div class="d-flex justify-content-between">
                            <p class="m-0">Item: <span class="fw-semibold">${item.name}</span></p>
                            <p class="m-0">Weight: <span class="fw-semibold">${item.weight}Kg</span></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="m-0">Quantity: <span class="fw-semibold">${item.quantity}pieces</span></p>
                            <p class="m-0">Value: <span class="fw-semibold">₦${parseFloat(item.value).toLocaleString()}</span></p>
                        </div>
                    </div>
                `)
            });

            // Given values
            const subtotal = selectedCarrier.amount;
            const subchargePercentage = <?=$user->account->markup_price?>;
            const subcharge = (subtotal * subchargePercentage) / 100;
            const total = subtotal + subcharge;
            // Format values to 2 significant figures
            const formattedSubcharge = Number(subcharge.toFixed(2));
            const formattedTotal = Number(total.toFixed(2));
            formData.total = formattedTotal;
            $('#checkout').find(".total").text("₦"+formattedTotal);
            $('#checkout').find(".subcharge").text("₦"+formattedSubcharge);

            currentStep.hide();
            nextStep.show();
        });

        // Listen for changes in the input field
        $("input[name='phone']").on("input", function() {
            var value = $(this).val();
            let countryCode = $(this).data("phone");
            // Check if the value starts with the country code
            if (!value.startsWith(countryCode)) {
                // If not, prepend the country code to the value
                $(this).val(countryCode);
            }
        });

        $("#checkoutBtn").on("click", function(event) {
            event.preventDefault();
            let url = $(this).data("url");
            let btn = $(this);
            btn.html(`<img src="/assets/images/loader.gif" id="loader-gif">`);
            btn.attr("disabled", true);
            let payload = {
                total: formData.total,
                rate_id: selectedCarrier.rate_id,
                shipment_id: formData.shipment.shipment_id
            }
            $('#checkout .message').text('');
            // Append loader immediately
            setTimeout(() => {
                const config = {
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                        "X-Requested-With": "XMLHttpRequest"
                    }
                };
                axios.post(url, payload, config)
                .then(function(response){
                    let message = response.data.message;
                    $("#checkout .message").css("color", "green").text(message);
                    btn.attr("disabled", true).text("Payment Successful...");
                })
                .catch(function(error){
                    let errors = error.response.data.error;
                    switch(error.response.status){
                        case 400:
                            $("#checkout .message").css("color", "red").text(error.response.data.message)
                        break;
                    }

                    btn.attr("disabled", false).text("Make Payment");
                });
            }, 100); // Delay submission by 100 milliseconds

        });

    });

</script>
@include("customer.layouts.footer")