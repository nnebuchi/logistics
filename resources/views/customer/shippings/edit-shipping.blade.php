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

                    @include('customer.shippings.components.edit.sender')
                    @include('customer.shippings.components.edit.receiver')
                    @include('customer.shippings.components.edit.add-item')
                    @include('customer.shippings.components.edit.add-carrier')
                    @include('customer.shippings.components.edit.checkout')

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
<script src="{{asset('assets/js/shipping/validate.js')}}"></script>
<script src="{{asset('assets/js/shipping/countries.js')}}"></script>
<script src="{{asset('assets/js/shipping/categories.js')}}"></script>
<script>
    let token = $("meta[name='csrf-token']").attr("content");
    let baseUrl = $("meta[name='base-url']").attr("content");
    var parcelDoc = {};

    function modifyItems() {
        let parcels = <?= json_encode($shipment->parcels) ?>;
        let groupedItems = [];
        // Iterate over each parcel
        parcels.forEach((parcel, parcelIndex) => {
            // Iterate over each item in the parcel
            parcel.items.forEach((item, itemIndex) => {
                item.parcel_id = parcelIndex; // Assign the parcel index as the parcel_id
                groupedItems.push(item); // Add the item to the groupedItems array
            });
        });

        return groupedItems;
    }

    $(document).ready(function(){
        // Call the function to get the modified items
        let modifiedItems = modifyItems();
        let formData = { "sender": {}, "receiver": {}, "items": modifiedItems, "shipment": {}, "total": "" };
        let parcel = {};
        let carriers = [];
        let selectedCarrier = {};
        const createParcel = async (items) => {
            let payload = {
                "description": 'New parcel for shipment',
                "weight_unit": "kg",
                "items": [], // Initialize an empty array for items,
                "address_from": formData.sender.address_id,
                "address_to": formData.receiver.address_id,
                "shipment_id": "<?=$shipment->external_shipment_id?>"
            };
            // Create a map to group items by parcel_id
            let parcelsMap = {};
            // Loop through the items array and construct payload items
            items.forEach(item => {
                if (!parcelsMap[item.parcel_id]) {
                    parcelsMap[item.parcel_id] = [];
                }
                parcelsMap[item.parcel_id].push({
                //payload.items.push({
                    "name": item.name,
                    "hs_code": item.hs_code,
                    "description": item.description,
                    "type": "parcel",
                    "currency": "NGN",
                    "value": parseFloat(item.value),
                    "quantity": parseInt(item.quantity),
                    "weight": parseFloat(item.weight),
                    //"parcel_id": item.parcel_id
                });
            });

            // Construct the payload.parcels array
            for (let parcel_id in parcelsMap) {
                if (parcelsMap.hasOwnProperty(parcel_id)) {
                    payload.items.push({
                        "parcel_id": parcel_id,
                        "items": parcelsMap[parcel_id],
                        "docs": parcelDoc[parcel_id] ?? []
                    });
                }
            }
            
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
                    "firstname": formData[type].firstname,
                    "lastname": formData[type].lastname,
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
                        "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                        "X-Requested-With": "XMLHttpRequest"
                    }
                };
                axios.post(`${baseUrl}/address`, payload, config)
                .then(function(response){
                    let results = response.data.results;
                    formData[type] = results;
                    console.log(results);
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
                    let errors = error.response.data.error;
                    alert(error.response.data.message);
                });
            }
        });

        $(".prev").on("click", function(event){
            event.preventDefault();
            var currentStep = $(this).closest(".step");
            var prevStep = currentStep.prev(".step");
            currentStep.hide();
            prevStep.show();

            let type = $(this).data("type");
            if(type == "receiver"){
                $(".progress").removeClass("bg-primary");
                $(".progress").eq(0).addClass("bg-primary");
            }else if(type == "shipping"){
                $(".progress").removeClass("bg-primary");
                $(".progress").eq(1).addClass("bg-primary");
            }else if(type == "carrier"){
                $(".progress").removeClass("bg-primary");
                $(".progress").eq(2).addClass("bg-primary");
            }
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

        $("#add-parcel").on("click", function(event){
            event.preventDefault();
            $parcel = $(this).data("parcel");
            $("#parcel-container").append(`
                <div class="parcel-box" data-id="${$parcel}">
                    <div class="mb-1 d-flex align-items-center justify-content-between">
                        <h5 class="m-0">Parcel ${$parcel + 1}</h5>
                        <button class="btn btn-danger" id="delete-parcel" data-parcel="${$parcel}" type="button">X Delete Parcel</button>
                    </div>
                    <div class="mb-2" style="background-color:#E9EFFD;border-radius:10px;">
                        <div class="table-responsive">
                            <table data-id="0" class="mb-0 items-table table table-borderless text-nowrap align-middle">
                                <thead class="text-dark fs-3">
                                    <tr>
                                        <th>Items</th>
                                        <th>Quantity</th>
                                        <th>Weight</th>
                                        <th>Value</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>   
                                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center p-3">
                            <button type="button" data-parcel="${$parcel}"
                            class="btn px-4 openAddItemModal" style="background-color:#FCE4C2F7;">
                            + Add Item
                            </button>
                        </div>
                        <div class="p-3 bg-white">
                            <form class="proof-of-purchase-form" data-parcel="${$parcel}" 
                            action="" method="POST" enctype="multipart/form-data">
                                <h5 class="m-0 mb-1">Upload Proof of Purchase</h5>
                                <div class="mt-2 d-flex align-items-center">
                                    <div class="w-10" style="border:2px solid #FCE4C2F7">
                                        <input type="text" name="document" placeholder="Title" class="custom-input rounded-0" />
                                    </div>
                                    <label for="document-${$parcel}" type="button" class="m-0 ml-2 rounded-circle d-flex align-items-center justify-content-center" style="background-color:#FCE4C2F7;height:50px;width:50px">
                                        <img src="{{asset('assets/images/icons/cloud-upload.svg')}}" width="25" >
                                        <input type="file" id="document-${$parcel}" data-parcel="${$parcel}" data-count="0" class="d-none document-file" />
                                    </label>
                                </div>
                                <span class="document-count"> </span>
                                <div class="mt-1 document-preview">
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `);
            $(this).data("parcel", $parcel + 1);
        });

        $(document).on("click", "#delete-parcel", function(event){
            event.preventDefault();
            $parcel_id = $(this).data("parcel");
            formData.items = formData.items.filter(item => item.parcel_id !== $parcel_id);
            $("#add-parcel").data("parcel", $parcel_id);
            $(this).parent().parent().remove();

            $('.parcel-box').each(function(index) {
                $(this).find('h5').eq(0).text('Parcel ' + (index + 1)); // Update the parcel number in the heading
                //$(this).find('#delete-parcel').data('parcel', index); // Update the delete button data-parcel
                //$(this).find('.update-item').data('parcel', index); // Update the item data-parcel attributes
                //$(this).find('.openAddItemModal').data('parcel', index); // Update the add item button data-parcel
                //$(this).find('.proof-of-purchase-form').data('parcel', index); // Update the proof of purchase form data-parcel
                //$(this).find('.document-file').data('parcel', index).attr('id', 'document-' + index); // Update the file input id and data-parcel
                //$(this).find('label[for^="document-"]').attr('for', 'document-' + index); // Update the label for attribute
            });

            // Update the data-parcel attribute on the add new parcel button
            const newParcelCount = $('.parcel-box').length;
            $('#add-parcel').data('parcel', newParcelCount);
        });

        $("#addItem").on("click", async function(event) {
            event.preventDefault();
            let item = {};
            const action = $(this).data("action");
            let table = $(this).data("parcel");
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
            item["parcel_id"] = table;
            $(`#shipping .error`).text('');
            $(`#shipping input`).css("borderColor", "transparent");
            let inputs = [
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
                        let highestId = formData.items.reduce((maxId, currentItem) => Math.max(maxId, currentItem.id), 0);
                        // Assign the new item a unique ID
                        item["id"] = highestId + 1;
                        formData.items.push(item);
                    break;
                    case "update":
                        index = parseInt($(this).data("item"));
                        item["id"] = index;
                        formData.items = replaceItemById(index, item);
                        $(this).data("action", "create");
                        $(this).data("item", "");
                    break;
                };
                $(".items-table tbody").eq(table).empty();
                formData.items.forEach((item) => {
                    if(item.parcel_id == table){
                        renderTableData(item, table);
                    }
                });
                $currentForm[0].reset();
                $("#addItemModal").modal('hide');
            } else {
                //alert("Sender validation failed!");
            }
        });

        function renderTableData(item, table){
            $(".items-table tbody").eq(table).append(`
                <tr class="">
                    <td class="pt-0 pb-2">${item.name}</td>
                    <td class="pt-0 pb-2">${item.quantity}pieces</td>
                    <td class="pt-0 pb-2">${item.weight}kg</td>
                    <td class="pt-0 pb-2"><b>₦</b>${item?.value.toLocaleString()}</td>
                    <td class="pt-0 pb-2">
                        <a class="update-item" data-id="${item.id}" data-parcel="${table}" data-action="edit" type="button">
                            <img src="{{asset('assets/images/icons/material-edit-outline.svg')}}" width="20" />
                        </a>
                    </td>
                    <td class="pt-0 pb-2">
                        <a class="update-item" data-id="${item.id}" data-parcel="${table}" data-action="delete" type="button">
                            <img src="{{asset('assets/images/icons/mdi-light_delete.svg')}}" width="20" />
                        </a>
                    </td>
                </tr>  
            `);
        }

        // Function to find item by ID
        function getItemById(id) {
            return formData.items.find(item => item.id === id);
        }
        // Function to delete item by ID
        function deleteItemById(id) {
            return formData.items.filter(item => item.id !== id);
        }
        // Function to replace item by ID
        function replaceItemById(id, newItem) {
            return formData.items.map(item => item.id === id ? newItem : item);
        }

        $(document).on("click", ".update-item", function(event){
            event.preventDefault();
            const itemId = $(this).data("id");
            const action = $(this).data("action");
            const table = $(this).data("parcel");
            $("#addItem").data("parcel", table);
            switch(action){
                case "edit":
                    //let item = formData.items[itemId];
                    let item = getItemById(itemId);
                    var $form = $("#addItemForm");
                    // Variable to track when the second dropdown should be populated
                    let populateSecondDropdown = false;
                    // Variable to track when the third dropdown should be populated
                    let populateThirdDropdown = false;
                    $form.find("input, select").each(function(){
                        let fieldName = $(this).attr("name");  // Get the name attribute of the input/select element
                        // Check if the current input/select element exists in the item object
                        if(fieldName && item.hasOwnProperty(fieldName)) {
                            $(this).val(item[fieldName]);   // Set the value of the input/select element to the corresponding property of the item object
                            // Check for the first dropdown and trigger change event
                            if (fieldName === 'category') {
                                $(this).val(item[fieldName]).trigger('change');
                                populateSecondDropdown = true; // Indicate that the second dropdown should be populated next
                            }
                            
                            // Check for the second dropdown and trigger change event
                            if (populateSecondDropdown && fieldName === 'sub_category') {
                                $(this).val(item[fieldName]).trigger('change');
                                populateSecondDropdown = false; // Reset the flag
                                populateThirdDropdown = true; // Indicate that the third dropdown should be populated next
                            }
                            
                            // Set the third dropdown value
                            if (populateThirdDropdown && fieldName === 'hs_code') {
                                $(this).val(item[fieldName]);
                                populateThirdDropdown = false; // Reset the flag
                            }
                        }
                    });
                    $("#addItem").data("action", "update");
                    $("#addItem").data("item", itemId);
                    $("#addItemModal").modal("show");
                break;
                case "delete":
                    formData.items = deleteItemById(itemId);  //Delete the object at the specified index
                    $(".items-table tbody").eq(table).empty();
                    formData.items.forEach((item) => {
                        if(item.parcel_id == table){
                            renderTableData(item, table);
                        }
                    });
                    $("#step3Btn").prop("disabled", !(formData.items.length != 0));
                break;
            }
        });

        $(document).on("click", ".openAddItemModal", function() {
            let $parcel = $(this).data("parcel");
            $("#addItem").data("parcel", $parcel);
            $("#addItemModal").modal("show");
        });
        $(document).on("click", "#addItemModal .close", function(){
            $("#addItemModal").modal("hide");
        });
        $(document).on('hidden.bs.modal', '#addItemModal', function (e) {
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
<script src="{{asset('assets/js/shipping/parceldoc.js')}}"></script>
@include("customer.layouts.footer")