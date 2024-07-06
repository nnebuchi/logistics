@include("customer.layouts.header")
        <div class="container-fluid" style="background-color:#F6F6F7;">
            <!--  Row 1 -->
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title fw-normal bg-white py-2 px-3 rounded-pill">Dashboard > Shipping > Create Shipment</h5>
                    </div>
                    
                    @include('customer.shippings.components.step-indicator', ['step' => 2])
                    
                    {{-- @include('customer.shippings.components.create.sender')
                    @include('customer.shippings.components.create.receiver')
                    @include('customer.shippings.components.create.add-item')
                    @include('customer.shippings.components.create.add-carrier')
                    @include('customer.shippings.components.create.checkout') --}}


                    @include('customer.modals.edit-item-modal')
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
<script src="{{asset('assets/js/shipping/parrcels.js')}}"></script>
<script>
    var parcels = [];
    var shipment = {};
    var carriers = [];
    window.onload = async () => {
        shipment = await getShipmentDetails("{{$shipment->id}}");
        parcels = await shipment?.parcels;
        console.log(parcels);
    }
    const getShipmentDetails = async (id) => {
        return await axios.get(`${url}/shipping/${id}/details`)
        .then( async function(response){
            // parcels = response.data.shipment
            // console.log(response.data.shipment);
            return response.data.shipment;
        }).catch(function(error){
            // setBtnNotLoading(submitBtn, oldBtnHTML)
            console.log(error);
            return false;
        });
    }
    const config = {
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").getAttribute("content"),
            "X-Requested-With": "XMLHttpRequest"
        }
    };
    const handleAddParcel = async() => {
        // console.log(parcels);
        let highestId = parcels.reduce((maxId, currentParcel) => Math.max(maxId, currentParcel.id), 0);
        // Assign the new item a unique ID
        $id = highestId + 1;

        parcels[parcels.length] = {id: $id, items:[]};
        await updateParcelsUI();
        populateItems()
    }

    const updateParcelsUI = async () => {
        $("#parcel-container").empty();
        parcels.forEach((parcel, index) => {
            let html =``;
            if(parcel?.items.length > 0){
                html = `<div class="parcel-box" data-id="${index}" id="parcel-${parcel.id}">
                    <div class="mb-1 d-flex align-items-center justify-content-between">
                        <h5 class="m-0">Parcel ${index + 1}</h5>
                        <button class="btn btn-danger delete-parcel" id="delete-parcel-${parcel.id}" onclick="deleteParcel(${parcel.id}, ${index})" data-parcel="${index}" type="button"><i class="fa fa-close"></i> Delete Parcel</button>
                    </div>
                    <div class="mb-2 p-2" style="background-color:#E9EFFD;border-radius:10px;">
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
                                <tbody data-id="${parcel.id}">   
                                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center p-3">
                            <button type="button" data-parcel="${index}"
                            class="btn px-4 openAddItemModal" style="background-color:#FCE4C2F7;">
                            + Add Item
                            </button>
                        </div>
                        <div class="p-3 bg-white">
                                    <form class="proof-of-purchase-form" data-parcel="${index}" 
                                    action="" method="POST" enctype="multipart/form-data">
                                        <h5 class="m-0 mb-1">Upload Attachments</h5> <hr>
                                        <div class="row px-1 justify-content-between">
                                            <div class="col-12 mb-3 d-flex justify-content-left gap-1 attached-files">     
                                            </div>
                                            <div class="col-lg-5 form-group rounded p-3 parcel-doc-box" >
                                                <label for="">Proof of Payments <br> <small class="text-danger">Multiple files allowed PNG, JPG, PDF</small></label>
                                                <input type="file" class="form-contro custom-input rounded-0" multiple accept="image/jpg,image/png,application/pdf" parcel-input-no="pop">
                                                <div class="text-center pt-2">
                                                    <button type="button" parcel-id="${parcel.id}" class="btn btn-outline-primary" onclick="uploadParcelAttachment(event, 'proof_of_payments', 'pop')">Submit</button>

                                                </div>
                                                
                                            </div>
                                            <div class="col-lg-5 form-group rounded p-3 parcel-doc-box">
                                                <label for="">Rec Docs <br> <small class="text-danger">Multiple files allowed PNG, JPG, PDF </small></label>
                                                <input type="file" class="form-contro custom-input rounded-0"multiple accept="image/jpg,image/png,application/pdf" parcel-input-no="rec-doc">
                                                <div class="text-center pt-2">
                                                    <button type="button" parcel-id="${parcel.id}" class="btn btn-outline-primary" onclick="uploadParcelAttachment(event, 'rec_docs', 'rec-doc')">Submit</button>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                    </div>
                </div>`;
            }else{
                html = ` <div class="parcel-box" data-id="${index}" id="parcel-${parcel.id}">
                    <div class="mb-1 d-flex align-items-center justify-content-between">
                        <h5 class="m-0">Parcel ${index + 1}</h5>
                        <button class="btn btn-danger delete-parcel" id="delete-parcel-${parcel.id}" onclick="deleteParcel(${parcel.id}, ${index})" data-parcel="${index}" type="button"><i class="fa fa-close"></i> Delete Parcel</button>
                    </div>
                    <div class="mb-2 p-2" style="background-color:#E9EFFD;border-radius:10px;">
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
                                <tbody data-id="${parcel.id}">   
                                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center p-3">
                            <button type="button" data-parcel="${index}"
                            class="btn px-4 openAddItemModal" style="background-color:#FCE4C2F7;">
                            + Add Item
                            </button>
                        </div>
                       
                    </div>
                </div>`;
            }
            $("#parcel-container").append(html);
            console.log($("#add-parcel"));
        });
        
        $("#add-parcel").attr('data-parcel',  parcels.length);
    }

    const validateItem = async (action) => {
        const validation = runValidation([
            {
                id:"item-name",
                rules: {'required':true}
            },
            {
                id:'item-weight',
                rules:{'required':true}
            },
            {
                id:'item-category',
                rules:{'required':true}
            },
            {
                id:'item-sub-category',
                rules:{'required':true}
            },
            {
                id:'item-hs-code',
                rules:{'required':true}
            },
            {
                id:'item-value',
                rules:{'required':true}
            },
            {
                id:'item-quantity',
                rules:{'required':true}
            }
            
        ]);
        if(validation === true){
            if($("#addItemForm").attr("action") === "add"){
                const parcel_index = $('#addItemModal').attr('data-parcel');
                await handleAddItem(parcel_index);
            }
            if($("#addItemForm").attr("action") === "edit"){
                await updateItem();
            }
        }
    }

    const handleAddItem = async (parcel_index) => {
        const submitBtn = document.querySelector("#addItem");
        const oldBtnHTML = submitBtn.innerHTML;
        setBtnLoading(submitBtn);
        const item = {};
        item.name = $('#item-name').val();
        item.weight = $('#item-weight').val();
        item.category = $('#item-category').val();
        item.sub_category = $('#item-sub-category').val();
        item.hs_code = $('#item-hs-code').val();
        item.quantity = $('#item-quantity').val();
        item.value = $('#item-value').val();
        item.currency = "NGN";
        let description = $('#item-hs-code').find("option:selected").data("description");
        item.description = description;

        /////////// await parcels[parcel_index].items.push(item);
        const shipment_id = document.querySelector('#addItemModal').querySelector('#shipment_id').value;
        item.shipment_id = shipment_id;
        if(parcels[parcel_index].items.length > 0){//if there is an exisiting gitem in the parcel
            console.log("Saving item");
            item.parcel_id = parcels[parcel_index].id;
            await saveItem(item);
            setBtnNotLoading(submitBtn, oldBtnHTML)
        }else{//if there is no exisiting item in the parcel
            console.log("saving Parcel", parcels[parcel_index]);
            let totalWeight = 0;
            for (const item of parcels[parcel_index].items) {
                totalWeight += parseFloat(item.weight);
            }
            parcels[parcel_index].shipment_id = shipment_id;
            parcels[parcel_index].weight = totalWeight

            const result = await createParcel(parcels[parcel_index])
            console.log(result);
            if(result?.status === "success"){ 
                // console.log(result.parcel); 
                item.parcel_id = result.parcel.id;
                // console.log(parcel_i);
                await saveItem(item);
                setBtnNotLoading(submitBtn, oldBtnHTML)
            }
        }
    }

    const createParcel = async (parcel) => {
        return axios.post(url+"/shipping/save-parcel", parcel, config)
        .then( async function(response){
            shipment = response.data.shipment;
            parcels = response.data.shipment.parcels;
            return response.data;
            
            // console.log(result.status);
        }).catch(function(error){
            setBtnNotLoading(submitBtn, oldBtnHTML)
            console.log(error);
            return error;
            
        });
    }

    const saveItem = async (item) => {
        axios.post(url+"/shipping/add-item", item, config)
        .then(async function(response){
            let result = response.data;
            if(result?.status === "success"){
                shipment = response.data.shipment;
                parcels = response.data.shipment.parcels;
                $("#addItemForm")[0].reset();
                $("#addItemModal").modal('hide');
                await updateParcelsUI();
                populateItems();
            }
        }).catch(function(error){
            $("#addItemForm")[0].reset();
            $("#addItemModal").modal('hide');
            return;
        });

        
    }

    const populateItems = async () => {
        parcels.forEach((parcel, parcelIndex) => {
            parcel.items.forEach((item, index) => {
                /*$(".items-table tbody[data-id='" + parcel.id + "']").append(`*/
                $(".items-table tbody").eq(parcelIndex).append(`
                    <tr class="">
                        <td class="pt-0 pb-2">${item.name}</td>
                        <td class="pt-0 pb-2">${item.quantity}pieces</td>
                        <td class="pt-0 pb-2">${item.weight}kg</td>
                        <td class="pt-0 pb-2"><b>₦</b>${item?.value.toLocaleString()}</td>
                        <td class="pt-0 pb-2">
                            <a class="edit-item" data-id="${index}" data-parcel="${parcelIndex}" onclick="showEditModal(${parcelIndex}, ${index})" data-action="edit" type="button">
                                <img src="{{asset('assets/images/icons/material-edit-outline.svg')}}" width="20" />
                            </a>
                        </td>
                        <td class="pt-0 pb-2">
                            <a class="update-item" data-id="${index}" data-parcel="${parcelIndex}"  onclick="deleteItem(event, ${parcelIndex}, ${index})" data-action="delete" type="button">
                                <img src="{{asset('assets/images/icons/mdi-light_delete.svg')}}" width="20" />
                            </a>
                        </td>
                    </tr>  
                `);
            })
            populateAttachments(parcel, parcelIndex);
        });
    }

    const populateAttachments = (parcel, parcelIndex) => {
        let attachments = ``;
        parcel?.attachments?.forEach((attachment, index)=>{
            $("#parcel-container").find(`#parcel-${parcel.id}`).find('.attached-files').append(`
            <div class="d-flex flex-column">
                <a href="${attachment.file}" target="_blank" class="attachment-holder mb-1" style="height: 60px; width: 60px; position: relative;">
                    <img src="${url}/assets/images/icons/file.png" alt="" height="60" width="60" class="attachment-file">
                    <div class="text-center doc-overlay">
                        <div class="doc-download"><i class="fa fa-download"></i></div>
                        <h6 class="doc-txt">File ${index + 1}</h6>
                        <h6 class="doc-txt">${attachment.file.slice(-3)}</h6>
                    </div>
                </a>
             <span href="#" class="btn btn-danger btn-sm" style="width: 60px; cursor:pointer;" onclick="deleteAttachment(event, ${parcelIndex}, ${index})"> <i class="fa fa-trash"></i></span>
            </div>
            `);
            
        })
            
    }

    const deleteAttachment = async (event, parcelIndex, attachmentIndex) => {
        const clickedEle = event.target;
        let deleteBtn;
        if(clickedEle.tagName == "A"){
            deleteBtn = clickedEle
        }else{
            deleteBtn = clickedEle.parentElement;
        }
        
        const oldBtnHTML = deleteBtn.innerHTML;
        setBtnLoading(deleteBtn);
        return await axios.get(`${url}/shipping/delete-attachment?id=${parcels[parcelIndex]?.attachments[attachmentIndex]?.id}`)
        .then( async function(response){    
            setBtnNotLoading(deleteBtn);
            if(response.data.status == 'success'){
                
                // parcels[parcelIndex]?.attachments[attachmentIndex]
                parcels[parcelIndex].attachments.splice(attachmentIndex, 1);
                // console.log(parcels[parcelIndex]);
                await updateParcelsUI()
                populateItems();
            }
        }).catch(function(error){
            setBtnNotLoading(deleteBtn, oldBtnHTML);
            // setBtnNotLoading(submitBtn, oldBtnHTML)
            console.log(error);
            return false;
            
        });
    }

    const showEditModal = async (parcelIndex, itemIndex) => {
        const modalElement = $('#addItemModal').modal('show');
        $("#addItemForm").attr("action", "edit");
        // modalElement.modal('show');
        modalElement.find('#item-name').val(parcels[parcelIndex].items[itemIndex]?.name);
        modalElement.find('#item-weight').val(parcels[parcelIndex].items[itemIndex]?.weight);
        modalElement.find('#item-quantity').val(parcels[parcelIndex].items[itemIndex]?.quantity);
        modalElement.find('#item-value').val(parcels[parcelIndex].items[itemIndex]?.value);
        modalElement.find('#item-id').val(parcels[parcelIndex].items[itemIndex]?.id);
        modalElement.find('#item-category').val(parcels[parcelIndex].items[itemIndex]?.category);

        await populateForm($("#addItemForm"), parcels[parcelIndex].items[itemIndex]);
        modalElement.find('#item-sub-category').val(parcels[parcelIndex].items[itemIndex]?.sub_category);
        modalElement.find('#item-hs-code').val(parcels[parcelIndex].items[itemIndex]?.hs_code);
    }

    const updateItem = () => {
        const submitBtn = document.querySelector("#editItem");
        const oldBtnHTML = submitBtn.innerHTML;
        setBtnLoading(submitBtn);
        const item = {};
        const modalElement = $('#addItemModal')
        item.name =  modalElement.find('#item-name').val();
        item.weight = modalElement.find('#item-weight').val();
        item.category = modalElement.find('#item-category').val();
        item.sub_category = modalElement.find('#item-sub-category').val();
        item.hs_code = modalElement.find('#item-hs-code').val();
        item.quantity = modalElement.find('#item-quantity').val();
        item.value = modalElement.find('#item-value').val();
        item.currency = "NGN";
        item.id = modalElement.find('#item-id').val();
        let description = modalElement.find('#item-hs-code option:selected').data("description");
        item.description = description;

        return saveItem(item);
    }

    const deleteItem = async (event, parcelIndex, itemIndex) => {
        const clickedEle = event.target;
        let deleteBtn;
        if(clickedEle.tagName == "A"){
            deleteBtn = clickedEle
        }else{
            deleteBtn = clickedEle.parentElement;
        }
        
        const oldBtnHTML = deleteBtn.innerHTML;
        setBtnLoading(deleteBtn);
        return await axios.get(`${url}/shipping/delete-item?id=${parcels[parcelIndex]?.items[itemIndex]?.id}`)
        .then( async function(response){
            console.log(response.data);
            setBtnNotLoading(deleteBtn);
            if(response.data.status == 'success'){
                
                // parcels[parcelIndex]?.items[itemIndex]
                parcels[parcelIndex].items.splice(itemIndex, 1);
                console.log(parcels[parcelIndex]);
                await updateParcelsUI()
                populateItems();
            }
        }).catch(function(error){
            setBtnNotLoading(deleteBtn, oldBtnHTML);
            // setBtnNotLoading(submitBtn, oldBtnHTML)
            console.log(error);
            return false;
            
        });
    }

    const deleteParcel = async (parcelId, parcelIndex) => {
        const clickedEle = document.querySelector(`#delete-parcel-${parcelId}`);
        const oldBtnHTML = clickedEle.innerHTML;
        setBtnLoading(clickedEle);
        return await axios.get(`${url}/shipping/delete-parcel?id=${parcelId}`)
        .then( async function(response){
            console.log(response.data);
            setBtnNotLoading(clickedEle);
            if(response.data.status == 'success'){
                parcels.splice(parcelIndex, 1);
                const hasNonEmptyParcel = parcels.some(parcel => Array.isArray(parcel.items) && parcel.items.length > 0);
                // Enable the step3 button if there is at least one non-empty parcel
                $("#step3Btn").prop("disabled", !hasNonEmptyParcel);
                console.log(parcels[parcelIndex]);
                await updateParcelsUI();
                populateItems();
            }
        }).catch(function(error){
            setBtnNotLoading(clickedEle);
            console.log(error);
            return false;
        });
    }

    const uploadParcelAttachment = async (event, type, input_id) => {
        console.log('input id: ', input_id);
        const clickedEle = event.target;
        const oldBtnHTML = clickedEle.innerHTML;
        setBtnLoading(clickedEle);
        const formData = new FormData();
        formData.append('parcel_id', clickedEle.getAttribute('parcel-id'));
        formData.append('type', type);
        console.log( document.querySelector(`#parcel-${clickedEle.getAttribute('parcel-id')}`));
        const selectedFiles = document.querySelector(`#parcel-${clickedEle.getAttribute('parcel-id')}`).querySelector(`[parcel-input-no="${input_id}"]`).files;
        for (const file of selectedFiles) {
            formData.append('attachments[]', file); // Add each file separately
        }

        try {
            const response = await axios.post("{{route('upload-parcel-docs')}}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });

            setBtnNotLoading(clickedEle, oldBtnHTML)
            // console.log(response.data); 
            if(response.data.status === 'success'){
                shipment = await response.data.shipment;
                parcels = await response.data.shipment.parcels;
                await updateParcelsUI()
                populateItems()
                // populateAttachments()
            }

            // Optionally clear the form or display a success message
        } catch (error) {
            setBtnNotLoading(clickedEle, oldBtnHTML)
            console.error(error); // Handle upload errors
        }
    }

    const selectPickupOption = (event) => {
        const pickUpBox = $("#pickUpBox");
        const targetLabel = $(event.target).closest('label');
        if (targetLabel.length) {
            // Reset all dots-line borders and hide all dots
            pickUpBox.find("label .dots-line").css("border-color", "#233E8366");
            pickUpBox.find("label .dots").addClass("d-none");
            // Highlight the selected option
            targetLabel.find(".dots-line").css("border-color", "#233E83");
            targetLabel.find(".dots").removeClass("d-none");

            const hasNonEmptyParcel = parcels.some(parcel => Array.isArray(parcel.items) && parcel.items.length > 0);
            // Enable the step3 button if there is at least one non-empty parcel
            $("#step3Btn").prop("disabled", !hasNonEmptyParcel);
        }
    };

    const getCarriers = async (event) => {
        event.preventDefault();
        const clickedEle = event.target;
        const oldBtnHTML = clickedEle.innerHTML;
        setBtnLoading(clickedEle);
        const currentStep = $(clickedEle).closest(".step");
        const nextStep = currentStep.next(".step");
        $(`#chooseCarrier`).empty(); // Clear previous options
        axios.get(`${url}/shipping/${shipment.id}/carriers`, config)
        .then(function(response){
            carriers = response.data.results.rates;
            console.log(response.data.results.rates);
            setBtnNotLoading(clickedEle, oldBtnHTML)
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
            $(".progress").eq(4).addClass("bg-primary");
        }).catch(function(error){
            setBtnNotLoading(submitBtn, oldBtnHTML)
            console.log(error);
            return false;
        });
    };

    var step = 2;
    let token = $("meta[name='csrf-token']").attr("content");
    var parcelDoc = {};
    $(document).ready(function(){
        let formData = { "sender": {}, "receiver": {}, "items": [], "shipment": {}, "total": "" };
        //let parcel = {};
        //let carriers = [];
        let selectedCarrier = {};

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
                const innerHTML = event.target.innerHTML;
                setBtnLoading(event.target)
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
                const address_data = {...payload}
                console.log(address_data);
                address_data.slug = "{{$slug}}";
                // address_data._token = $("meta[name='csrf-token']").attr("content");
                address_data.type = type;
                const config = {
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                        "X-Requested-With": "XMLHttpRequest"
                    }
                };
                axios.post("{{route('shipment.save-address')}}", address_data, config)
                .then(function(response){
                    setBtnNotLoading(event.target, innerHTML)
                    let result = response.data;
                    if(result?.status === "success"){
                        currentStep.hide();
                        nextStep.show();
                        step = step + 1;
                        if(type == "sender"){
                            $(".progress").removeClass("bg-primary");
                            $(".progress").eq(2).addClass("bg-primary");
                        }else if(type == "receiver"){
                            $(".progress").removeClass("bg-primary");
                            $(".progress").eq(3).addClass("bg-primary");
                        }
                    }
                    // formData[type] = results;
                    // console.log(results);
                    // currentStep.hide();
                    // nextStep.show();
                }).catch(function(error){
                    setBtnNotLoading(event.target, innerHTML)
                    console.log(error);
                    // let errors = error.response.data.error;
                    // alert(error.response.data.message);
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
                $(".progress").eq(1).addClass("bg-primary");
            }else if(type == "shipping"){
                $(".progress").removeClass("bg-primary");
                $(".progress").eq(2).addClass("bg-primary");
            }else if(type == "carrier"){
                $(".progress").removeClass("bg-primary");
                $(".progress").eq(3).addClass("bg-primary");
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

        $(document).on("click", ".openAddItemModal", function() {
            let $parcel = $(this).data("parcel");
            $("#addItem").data("parcel", $parcel);
            $("#addItemModal").attr('data-parcel', $(this).attr('data-parcel'))
            $("#addItemModal").modal("show");
            $("#addItemForm").attr("action", "add");
        });
        $(document).on("click", "#addItemModal .close", function(){
            $("#addItemModal").modal("hide");
        });
        $(document).on('hidden.bs.modal', '#addItemModal', function (e) {
            $("#addItemModal").modal("hide");
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

        $("#step4Btn").click(function(event) {
            event.preventDefault();
            var currentStep = $(this).closest(".step");
            var nextStep = currentStep.next(".step");
            
            $('#checkout').find(".sender span").eq(0).text(shipment.address_from.firstname+" "+shipment.address_from.lastname);
            $('#checkout').find(".sender span").eq(1).text(shipment.address_from.email);
            $('#checkout').find(".sender span").eq(2).text(shipment.address_from.phone);
            $('#checkout').find(".sender span").eq(3).text(shipment.address_from.line1);

            $('#checkout').find(".receiver span").eq(0).text(shipment.address_to.firstname+" "+shipment.address_to.lastname);
            $('#checkout').find(".receiver span").eq(1).text(shipment.address_to.email);
            $('#checkout').find(".receiver span").eq(2).text(shipment.address_to.phone);
            $('#checkout').find(".receiver span").eq(3).text(shipment.address_to.line1);

            $('#checkout').find(".carrier img").attr("src", selectedCarrier.carrier_logo);
            $('#checkout').find(".carrier span").eq(0).text(selectedCarrier.carrier_name);
            $('#checkout').find(".carrier span").eq(1).text(selectedCarrier.pickup_time);
            $('#checkout').find(".carrier span").eq(2).text(selectedCarrier.delivery_time);

            shipment.parcels.forEach((parcel, index) => {
                parcel.items.forEach((item, index) => {
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
                })
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
            // oldBtnHTML = btn.html
            // setBtnLoading(btn)
            btn.html(`<i class="fa fa-spin fa-spinner"></i>`);
            btn.attr("disabled", true);
            let payload = {
                total: formData.total,
                rate_id: selectedCarrier.rate_id,
                shipment_id: shipment.id
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
                    console.log(response);
                    if(response?.data?.status === 'success'){
                        window.location.replace("{{route('shippings')}}") 
                    }
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