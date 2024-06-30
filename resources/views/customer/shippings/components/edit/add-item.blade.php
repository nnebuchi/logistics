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
                        onclick="getCarriers(event)"
                        class="custom-btn fs-4 fw-bold">
                    Next
                    <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                    </button>
                </div>
            </div>
        </div>
        
    </div>
</div>