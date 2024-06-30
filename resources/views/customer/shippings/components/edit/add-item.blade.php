<div class="row justify-content-center step" style="display:none;" id="shipping">
    <div class="col-xl-9 col-lg-9 col-md-10">
        <div class="card w-100">
            <div class="card-body">
                <div class="alert alert-info">
                    <h6>Important Tips:</h6>
                    <ul type="disc">
                        <li><span><i class="fa fa-check"></i></span>Your Shipments are made up of parcels.  </li>
                        <li><span><i class="fa fa-check"></i></span>A parcel is like a box</li>
                        
                        <li><span><i class="fa fa-check"></i></span>You can add as many items you want to a parcel</li>
                        <li><span><i class="fa fa-check"></i></span>To add another parcel, click on "Add new parcel"</li>
                    </ul>
                </div>
                <div id="parcel-container">
                    
                    <?php foreach($shipment->parcels as $parcelIndex => $parcel): ?>
                        <div class="parcel-box" data-id="{{$parcelIndex}}" id="parcel-{{$parcel->id}}">
                            <div class="mb-1 d-flex align-items-center justify-content-between">
                                <h5 class="m-0">Parcel <?=$parcelIndex + 1?></h5>
                                <button class="btn btn-danger delete-parcel" id="delete-parcel-{{$parcel->id}}" onclick="deleteParcel('{{$parcel->id}}', '{{$parcelIndex}}')" data-parcel="<?=$parcelIndex?>" type="button"><i class="fa fa-close"></i> Delete Parcel</button>
                            </div>
                            <div class="mb-2 p-2" style="background-color:#E9EFFD;border-radius:10px;">
                                <div class="table-responsive">
                                    <table class="mb-0 items-table table table-borderless text-nowrap align-middle">
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
                                        <tbody data-id="<?=$parcelIndex?>">   
                                            <?php foreach($parcel->items as $index => $item): ?>
                                                <tr style="">
                                                    <td class="pt-0 pb-2"><?=$item->name?></td>
                                                    <td class="pt-0 pb-2"><?=$item->quantity?>pieces</td>
                                                    <td class="pt-0 pb-2"><?=$item->weight?>kg</td>
                                                    <td class="pt-0 pb-2"><b>₦</b><?= number_format($item->value, 2, '.', ',') ?></td>
                                                    <td class="pt-0 pb-2">
                                                        <a class="edit-item" data-id="<?=$item->id?>" data-parcel="<?=$parcelIndex?>" data-action="edit" type="button" data-bs-target="#editItemModal" onclick="showEditModal('{{$parcelIndex}}', '{{$index}}')">
                                                            <img src="{{asset('assets/images/icons/material-edit-outline.svg')}}" width="20" />
                                                        </a>
                                                    </td>
                                                    <td class="pt-0 pb-2">
                                                        <a class="delete-item" data-id="<?=$item->id?>" data-parcel="<?=$parcelIndex?>" data-action="delete" type="button" onclick="deleteItem(event, '{{$parcelIndex}}', '{{$index}}')">
                                                            <img src="{{asset('assets/images/icons/mdi-light_delete.svg')}}" width="20" />
                                                        </a>
                                                    </td>
                                                </tr> 
                                                 
                                            <?php endforeach;?>              
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center p-3">
                                    <button type="button" data-parcel="<?=$parcelIndex?>"
                                    class="btn bg-whit px-4 openAddItemModal" style="background-color:#FCE4C2F7;">
                                    + Add Item
                                    </button>
                                </div>
                                <div class="p-3 bg-white">
                                    <form class="proof-of-purchase-form" data-parcel="<?=$parcelIndex?>" 
                                    action="" method="POST" enctype="multipart/form-data">
                                        <h5 class="m-0 mb-1">Upload Attachments</h5> <hr>
                                        <div class="row px-1 justify-content-between">
                                            <div class="col-12 mb-3 d-flex justify-content-left gap-1 attached-files">
                                                @foreach($parcel->attachments as $index=>$attachment)
                                                <a href="{{$attachment->file}}" target="_blank" class="attachment-holder" style="height: 60px; width: 60px; position: relative;">
                                                    <img src="{{asset('assets/images/icons/file.png')}}" alt="" height="50" class="attachment-file">
                                                    <div class="text-center doc-overlay">
                                                        <div class="doc-download"><i class="fa fa-download"></i></div>
                                                        <h6 class="doc-txt">File {{$index + 1}}</h6>
                                                        <h6 class="doc-txt">{{substr($attachment->file, -3)}}</h6>
                                                    </div>
                                                </a>
                                                @endforeach
                                                
                                            </div>
                                            <div class="col-lg-5 form-group rounded p-3 parcel-doc-box" >
                                                <label for="">Proof of Payments <br> <small class="text-danger">Multiple files allowed PNG, JPG, PDF</small></label>
                                                <input type="file" class="form-contro custom-input rounded-0" multiple accept="image/jpg,image/png,application/pdf" id="pop">
                                                <div class="text-center pt-2">
                                                    <button type="button" parcel-id="{{$parcel->id}}" class="btn btn-outline-primary" onclick="uploadParcelAttachment(event, 'proof_of_payments', 'pop')">Submit</button>

                                                </div>
                                                
                                            </div>
                                            <div class="col-lg-5 form-group rounded p-3 parcel-doc-box">
                                                <label for="">Rec Docs <br> <small class="text-danger">Multiple files allowed PNG, JPG, PDF </small></label>
                                                <input type="file" class="form-contro custom-input rounded-0"multiple accept="image/jpg,image/png,application/pdf" id="rec-doc">
                                                <div class="text-center pt-2">
                                                    <button type="button" parcel-id="{{$parcel->id}}" class="btn btn-outline-primary" onclick="uploadParcelAttachment(event, 'rec_docs', 'rec-doc')">Submit</button>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <!-- Table starts here -->
                </div>
                <div class="d-flex align-items-center justify-content-between p-2" style="background-color:#FCE4C2F7;">
                    <h5 class="m-0">Click to add new parcel</h5>
                    <button id="add-parcel" data-parcel="<?=count($shipment->parcels)?>" class="btn bg-white" type="button" style="background-color:#FCE4C2F7;" onclick="handleAddParcel()">+ Add new parcel</button>
                </div>

                @include('customer.modals.add-item-modal')
                
            </div>
        </div>
        <div id="pickUpBox" onclick="selectPickupOption(event)">
            <div class="card w-100">
                <div class="card-body">
                    <h6 style="color:#1E1E1E66">Select preferred option</h6>

                    <input type="radio" id="html" name="options" value="HTML" class="d-none">
                    <label for="html" class="d-flex align-items-center">
                        <div class="fs-3">
                            Carrier should pick shipment from your address
                        </div>
                        <div class="ml-2">
                            <div class="dots-line rounded-circle d-flex align-items-center justify-content-center" style="height:20px;width:20px;border:2px solid #233E8366;">
                                <div class="dots d-none rounded-circle" style="height:10px;width:10px;background-color:#233E83;"></div>
                            </div>
                        </div>
                    </label>

                    <input type="radio" id="css" name="options" value="CSS" class="d-none">
                    <label for="css" class="d-flex align-items-center">
                        <div class="fs-3">
                            You will send shipment to Carrier's office
                        </div>
                        <div class="ml-2">
                            <div class="dots-line rounded-circle d-flex align-items-center justify-content-center" style="height:20px;width:20px;border:2px solid #233E8366;">
                                <div class="dots d-none rounded-circle" style="height:10px;width:10px;background-color:#233E83;"></div>
                            </div>
                        </div>
                    </label>
                
                    

                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <div class="mr-3">
                    <button 
                    data-type="shipping"
                    type="button"
                    class="btn btn-light fs-4 fw-bold prev">
                    <img src="{{asset('assets/images/icons/auth/cil_arrow-left.svg')}}" width="20" class="mr-2" alt="">
                    Previous
                    </button>
                </div>
                <div class="">
                    <button 
                        type="button"
                        id="step3Btn"
                        disabled
                        class="custom-btn fs-4 fw-bold">
                    Next
                    <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                    </button>
                </div>
            </div>
        </div>
        
    </div>
</div>



<script>
    var parcels = [];
    window.onload = async () => {
        var shipment = await getShipmentDetails("{{$shipment->id}}");
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
            $("#parcel-container").append(`
                <div class="parcel-box" data-id="${index}" id="parcel-${parcel.id}">
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
                                                <input type="file" class="form-contro custom-input rounded-0" multiple accept="image/jpg,image/png,application/pdf" id="pop">
                                                <div class="text-center pt-2">
                                                    <button type="button" parcel-id="${parcel.id}" class="btn btn-outline-primary" onclick="uploadParcelAttachment(event, 'proof_of_payments', 'pop')">Submit</button>

                                                </div>
                                                
                                            </div>
                                            <div class="col-lg-5 form-group rounded p-3 parcel-doc-box">
                                                <label for="">Rec Docs <br> <small class="text-danger">Multiple files allowed PNG, JPG, PDF </small></label>
                                                <input type="file" class="form-contro custom-input rounded-0"multiple accept="image/jpg,image/png,application/pdf" id="rec-doc">
                                                <div class="text-center pt-2">
                                                    <button type="button" parcel-id="${parcel.id}" class="btn btn-outline-primary" onclick="uploadParcelAttachment(event, 'rec_docs', 'rec-doc')">Submit</button>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                    </div>
                </div>
            `);
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
            populateAttachments(parcel);
        });
    }

    const populateAttachments = (parcel) => {
        let attachments = ``;
        console.log(parcel.id);
        parcel?.attachments?.forEach((attachment, index)=>{
            $("#parcel-container").find(`#parcel-${parcel.id}`).find('.attached-files').append(`
            <a href="${attachment.file}" target="_blank" class="attachment-holder" style="height: 60px; width: 60px; position: relative;">
                <img src="${url}/assets/images/icons/file.png" alt="" height="50" class="attachment-file">
                <div class="text-center doc-overlay">
                    <div class="doc-download"><i class="fa fa-download"></i></div>
                    <h6 class="doc-txt">File ${index + 1}}</h6>
                    <h6 class="doc-txt">${attachment.file.slice(-3)}</h6>
                </div>
            </a>`);
            
        })
        // console.log(attachments);
        // $("#parcel-container")
        // $("#parcel-container").querySelector('.attached-files').innerHTML = attachments;
         
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
        item.currency ="NGN";
        item.id = modalElement.find('#item-id').val();

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
                console.log(parcels[parcelIndex]);
                await updateParcelsUI()
                populateItems();
            }
        }).catch(function(error){
            setBtnNotLoading(clickedEle);
            console.log(error);
            return false;
            
        });
    }

    const uploadParcelAttachment = async (event, type, input_id) => {
        const clickedEle = event.target;
        const oldBtnHTML = clickedEle.innerHTML;
        setBtnLoading(clickedEle);
        const formData = new FormData();
        formData.append('parcel_id', clickedEle.getAttribute('parcel-id'));
        formData.append('type', type);
        
        const selectedFiles = document.getElementById(`${input_id}`).files;
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
</script>