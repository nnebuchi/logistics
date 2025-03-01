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
                    
                    <!-- Table starts here -->
                    <?php foreach($shipment->parcels as $parcelIndex => $parcel): ?>
                        <div class="parcel-box">
                            
                            <div class="mb-1 d-flex align-items-center justify-content-between">
                                <h5 class="m-0">Parcel <?=$parcelIndex + 1?></h5>
                                <?php if($parcelIndex > 0): ?>
                                    <button class="btn btn-danger" id="delete-parcel" data-parcel="<?=$parcelIndex?>" type="button">X Delete Parcel</button>
                                <?php endif; ?>
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
                                        <tbody>   
                                            <?php foreach($parcel->items as $index => $item): ?>
                                                <tr style="">
                                                    <td class="pt-0 pb-2"><?=$item->name?></td>
                                                    <td class="pt-0 pb-2"><?=$item->quantity?>pieces</td>
                                                    <td class="pt-0 pb-2"><?=$item->weight?>kg</td>
                                                    <td class="pt-0 pb-2"><b>₦</b><?= number_format($item->value, 2, '.', ',') ?></td>
                                                    <td class="pt-0 pb-2">
                                                        <a class="update-item" data-id="<?=$item->id?>" data-parcel="<?=$parcelIndex?>" data-action="edit" type="button">
                                                            <img src="{{asset('assets/images/icons/material-edit-outline.svg')}}" width="20" />
                                                        </a>
                                                    </td>
                                                    <td class="pt-0 pb-2">
                                                        <a class="update-item" data-id="<?=$item->id?>" data-parcel="<?=$parcelIndex?>" data-action="delete" type="button">
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
                                        <h5 class="m-0 mb-1">Upload Proof of Purchase</h5>
                                        <div class="mt-2 d-flex align-items-center">
                                            <div class="w-10" style="border:2px solid #FCE4C2F7">
                                                <input type="text" name="document" placeholder="Title" class="custom-input rounded-0" />
                                            </div>
                                            <label for="document-<?=$parcelIndex?>" type="button" class="m-0 ml-2 rounded-circle d-flex align-items-center justify-content-center" style="background-color:#FCE4C2F7;height:50px;width:50px">
                                                <img src="{{asset('assets/images/icons/cloud-upload.svg')}}" width="25" >
                                                <input type="file" id="document-<?=$parcelIndex?>" data-parcel="<?=$parcelIndex?>" data-count="0" class="d-none document-file" />
                                            </label>
                                        </div>
                                        <span class="document-count"> </span>
                                        <div class="mt-1 document-preview">
                                            
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
        <div id="pickUpBox">
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
        parcels[parcels.length] = {items:[]};
        await updateParcelsUI();
        populateItems()
        
    }


    const updateParcelsUI = async () => {
        $("#parcel-container").empty();
        // console.log(parcels);
        parcels.forEach((parcel, index) => {
            $("#parcel-container").append(`
                <div class="parcel-box" data-id="${index}">
                    <div class="mb-1 d-flex align-items-center justify-content-between">
                        <h5 class="m-0">Parcel ${index + 1}</h5>
                        <button class="btn btn-danger" id="delete-parcel" data-parcel="${index}" type="button">X Delete Parcel</button>
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
                                <tbody>   
                                                    
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
                                <h5 class="m-0 mb-1">Upload Proof of Purchase</h5>
                                <div class="mt-2 d-flex align-items-center">
                                    <div class="w-10" style="border:2px solid #FCE4C2F7">
                                        <input type="text" name="document" placeholder="Title" class="custom-input rounded-0" />
                                    </div>
                                    <label for="document-${index}" type="button" class="m-0 ml-2 rounded-circle d-flex align-items-center justify-content-center" style="background-color:#FCE4C2F7;height:50px;width:50px">
                                        <img src="{{asset('assets/images/icons/cloud-upload.svg')}}" width="25" >
                                        <input type="file" id="document-${index}" data-parcel="${index}" data-count="0" class="d-none document-file" />
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
            console.log($("#add-parcel"));
            
        });
        $("#add-parcel").attr('data-parcel',  parcels.length);
    }

    const validateItem = async () => {
        

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
            const parcel_index = $('#addItemModal').attr('data-parcel');
            await handleAddItem(parcel_index);
            
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
        item.currency ="NGN";

        await parcels[parcel_index].items.push(item);
        const shipment_id = document.querySelector('#addItemModal').querySelector('#shipment_id').value;
        item.shipment_id = shipment_id;
        if(parcels[parcel_index].items.length > 0){//if there is an exisiting gitem in the parcel
            console.log("Saving item");
            item.parcel_id = parcels[parcel_index].id;
            await createitem(item);
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
                await createitem(item);
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

    const createitem = async (item) => {
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
        parcels.forEach((parcel, parcelIndex)=>{
            parcel.items.forEach((item, index)=>{
                 $(".items-table tbody").eq(parcelIndex).append(`
                <tr class="">
                    <td class="pt-0 pb-2">${item.name}</td>
                    <td class="pt-0 pb-2">${item.quantity}pieces</td>
                    <td class="pt-0 pb-2">${item.weight}kg</td>
                    <td class="pt-0 pb-2"><b>₦</b>${item?.value.toLocaleString()}</td>
                    <td class="pt-0 pb-2">
                        <a class="update-item" data-id="${index}" data-parcel="${parcelIndex}" data-action="edit" type="button">
                            <img src="{{asset('assets/images/icons/material-edit-outline.svg')}}" width="20" />
                        </a>
                    </td>
                    <td class="pt-0 pb-2">
                        <a class="update-item" data-id="${index}" data-parcel="${parcelIndex}" data-action="delete" type="button">
                            <img src="{{asset('assets/images/icons/mdi-light_delete.svg')}}" width="20" />
                        </a>
                    </td>
                </tr>  
            `);
            })
        });
       
    }

    


   

    
    
    

    // const parcels = [
    //     [
    //         items:[
    //             {},
    //             {}
    //         ]
    //     ], 
    //     []
    // ]
</script>