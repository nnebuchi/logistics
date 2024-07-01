let tableData; // Variable to store table data

axios.get('your_api_endpoint')
  .then(response => {
    tableData = response.data; // Store response data in the variable
    populateTable(tableData); // Populate the table with the data
  })
  .catch(error => {
    console.error('Error fetching data:', error);
  });


  function populateTable(data) {
  // Clear existing table data, if any
  $('#your-table-body').empty();

  // Iterate over the data and append rows to the table
  data.forEach(item => {
    $('#your-table-body').append(`
      <tr>
        <td>${item.property1}</td>
        <td>${item.property2}</td>
        <!-- Add more columns as needed -->
      </tr>
    `);
  });
}


/*$('.trx-table').DataTable({
        data: @json($transactions),
        columns: [
            { 
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta){
                    let serial = meta.row + meta.settings._iDisplayStart + 1;
                    return serial;
                }
            },
            { 
                data: null,
                render: function(data, type, row){
                    return data.wallet.user.firstname+" "+data.wallet.user.lastname;
                }
            },
            { data: "reference"},
            { data: "amount"},
            { data: "created_at"},
            { data: "purpose"},
            { data: "type"},
            { 
                data: null,
                render: function(data, type, row){
                    return `<span class="py-2 badge rounded-2 fw-semibold ${status[data.status]}">
                    ${data.status.charAt(0).toUpperCase() + data.status.slice(1)}
                    </span>`
                }
            }
        ],
		columnDefs: [{
			targets: "datatable-nosort",
			orderable: false,
		}],
		"language": {
			"info": "_START_-_END_ of _TOTAL_ entries",
			searchPlaceholder: "Search users",
			paginate: {
				next: '<ion-icon name="chevron-forward-outline"></ion-icon>',
                previous: '<ion-icon name="chevron-back-outline"></ion-icon>'   
			}
		},
        "pageLength": 20,
        "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
        //"page": 5,
        //"pagingType": "full_numbers",
        "createdRow": function(row, data, index){
            let verified = data["is_verified"];
            if(verified){
               $(row).css("background-color", "#233E830D");
            }else{
               //$(row).addClass("bg-white");
            }
        }
	});*/

  <td scope="row">
                            <div>${user.firstname+" "+user.lastname}</div>
                            <div><b>${user.email}</b></div>
                        </td>


                        <td scope="row">
                            ${(user.photo != null) ? `<a href=${user.photo} class="rounded-0 photo">
                                <img src="${user.photo}" style="width:50px;height:30px;" />
                            </a>` : ""}
                        </td>
    


$('#filter-input').on('input', function() {
  let searchTerm = $(this).val().toLowerCase();
  let filteredData = tableData.filter(item => {
    // Implement your filtering logic here
    // For example, you can filter based on a specific property
    return item.property1.toLowerCase().includes(searchTerm);
  });

  // Repopulate the table with the filtered data
  populateTable(filteredData);
});


$('#all-button').on('click', function() {
  // Repopulate the table with the original data (tableData)
  populateTable(tableData);

  // Clear the filter input field, if needed
  $('#filter-input').val('');
});


const displayError = (index, fieldName, errorMessage) => {
    $(`#sender .error`).eq(index).text(errorMessage);
    $(`#sender input[name='${fieldName}']`).css("border", "1px solid #FA150A");
};

const errors = validate([
    { inputName: 'firstname', inputValue: $("#sender input[name='firstname']").val(), constraints: { required: true, max_length: 50 } },
    { inputName: 'lastname', inputValue: $("#sender input[name='lastname']").val(), constraints: { required: true, max_length: 50 } },
    { inputName: 'email', inputValue: $("#sender input[name='email']").val(), constraints: { required: true, email: true } },
    { inputName: 'phone', inputValue: $("#sender input[name='phone']").val(), constraints: { required: true, phone: true } },
    { inputName: 'address1', inputValue: $("#sender input[name='address1']").val(), constraints: { required: true } },
    { inputName: 'country', inputValue: $("#sender input[name='country']").val(), constraints: { required: true } },
    { inputName: 'state', inputValue: $("#sender input[name='state']").val(), constraints: { required: true } },
    { inputName: 'city', inputValue: $("#sender input[name='city']").val(), constraints: { required: true } },
    { inputName: 'zip_code', inputValue: $("#sender input[name='zip_code']").val(), constraints: { required: true } }
]);

if (Object.keys(errors).length === 0) {
    alert("Validation passed!");
} else {
    if (errors.firstname) displayError(0, 'firstname', errors.firstname);
    if (errors.lastname) displayError(1, 'lastname', errors.lastname);
    if (errors.email) displayError(2, 'email', errors.email);
    if (errors.phone) displayError(3, 'phone', errors.phone);
    if (errors.address1) displayError(4, 'address1', errors.address1);
    if (errors.country) displayError(5, 'country', errors.country);
    if (errors.state) displayError(6, 'state', errors.state);
    if (errors.city) displayError(7, 'city', errors.city);
    if (errors.zip_code) displayError(8, 'zip_code', errors.zip_code);
}



<!--<form class="d-none" method="POST" id="addItemForm" style="">
                    <h4 style="color:#1E1E1E66" class="mt-2">Enter Shipping Details</h4>
                    <div class="row justify-content-center">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-9 mt-sm-2">
                            <div class="w-100 mr-2">
                                <label class="custom-input-label">Name of item</label>
                                <input type="text" name="name" placeholder="e.g books" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-2">
                                <label class="custom-input-label">Category</label>
                                <input type="text" name="category" placeholder="" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-2">
                                <label class="custom-input-label">Sub-Category</label>
                                <input type="text" name="sub_category" placeholder="" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-2">
                                <label class="custom-input-label">HS Code</label>
                                <input type="text" name="hs_code" placeholder="" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-9 mt-0 mt-sm-2">
                            <div class="w-100 mr-2">
                                <label class="custom-input-label">Weight (kg)</label>
                                <input type="number" name="weight" placeholder="" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                            <div class="w-100 mt-2">
                                <label class="custom-input-label">Quantity</label>
                                <input type="number" name="quantity" placeholder="" class="custom-input" />
                                <span class="error"> </span>
                            </div>
                            <div class="d-flex flex-column flex-md-row mt-2 justify-content-between">
                                <div class="w-100 mr-2">
                                    <label class="custom-input-label">Country</label>
                                    <select
                                        name="country"
                                        class="custom-select">
                                        <option value="">--Select one---</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error"> </span>
                                </div>
                                <div class="w-100 mt-md-0 mt-3">
                                    <label class="custom-input-label">State</label>
                                    <select
                                        name="state"
                                        class="custom-select">
                                        <option value="">--Select one---</option>
                                    </select>
                                    <span class="error"> </span>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-md-row mt-2 justify-content-between">
                                <div class="w-100 mr-2">
                                    <label class="custom-input-label">City</label>
                                    <select
                                        name="city"
                                        class="custom-select">
                                        <option value="">--Select one---</option>
                                    </select>
                                    <span class="error"> </span>
                                </div>
                                <div class="w-100 mt-md-0 mt-3">
                                    <label class="custom-input-label">Zip Code</label>
                                    <input type="text" name="zip_code" placeholder="xyz@gmail.com" class="custom-input" />
                                    <span class="error"> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <div class="mr-3">
                            <button 
                            type="button"
                            class="btn btn-light fs-4 fw-bold prev">
                            <img src="{{asset('assets/images/icons/auth/cil_arrow-left.svg')}}" width="20" class="mr-2" alt="">
                            Previous
                            </button>
                        </div>
                        <div class="">
                            <button 
                            type="button"
                            id="addItem"
                            data-item=""
                            data-action="create"
                            data-type="shipping"
                            class="custom-btn fs-4 fw-bold">
                            Save
                            <img src="{{asset('assets/images/icons/auth/cil_arrow-right.svg')}}" width="20" class="mr-2" alt="">
                            </button>
                        </div>
                    </div>
                </form>-->


                <input type="radio" id="d-young" name="carrier" value="CSS" class="d-none">
                        <label for="d-young" class="radio-group d-flex justify-content-between p-2" style="overflow-x:auto;">
                            <div class="" style="min-width:200px">
                                <img src="{{asset('assets/images/icons/auth/mdi_password-outline.svg')}}" width="70" height="50" class="mr-2" alt="">
                                <p>DHL Express</p>
                            </div>
                            <div class="" style="min-width:150px">
                                <p>Pick Up: within 2 days</p>
                                <p>Delivery: within 5 days</p>
                            </div>
                            <div class="d-flex align-items-center" style="min-width:200px">
                                <p>NGN 15,000.50</p>
                            </div>
                            <div class="d-flex align-items-center" style="min-width:100px">
                                <div class="dots-line rounded-circle d-flex align-items-center justify-content-center" style="height:20px;width:20px;border:2px solid #233E8366;">
                                    <div class="dots d-none rounded-circle" style="height:12.5px;width:12.5px;background-color:#233E83;"></div>
                                </div>
                            </div>
                        </label>




                        // Check if any radio button is selected
            /*if ($('#optionsBox #html').is(':checked') || $('#optionsBox #css').is(':checked')) {
                // At least one radio button is checked
                console.log('At least one radio button is selected.');

                // Identify which radio button is checked
                if ($('#optionsBox #html').is(':checked')) {
                    console.log('HTML radio button is selected.');
                } else {
                    console.log('CSS radio button is selected.');
                }
            }*/

            <a class="" data-id="${user.id}" type="button" href="${impersonateBaseUrl.replace(':id', user.id)}">
                                Impersonate
                            </a>


                            <td scope="row">
                            <button data-id="${user.id}" data-email="${user.email}" 
                            data-name="${user.firstname+" "+user.lastname}" 
                            class="btn btn-light fund-user" type="button">Fund
                            </button>
                        </td>






                        <div class="row justify-content-center step" style="display:non;" id="shipping">
    <div class="col-xl-9 col-lg-9 col-md-10">
        <div class="card w-100">
            <div class="card-body">
                <div class="" style="background-color:#E9EFFD;border-radius:10px;">
                    <div class="table-responsive">
                        <table class="items-table table table-borderless text-nowrap align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold">Items</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold">Quantity</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold">Weight</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold">Value</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold">Edit</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold">Delete</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>   
                                                        
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-center pt-4 mt-2" style="height:130px;background-color:#FCE4C2F7;border-radius:10px;">
                    <p class="fw-semibold">What's inside your shipment</p>
                    <div>
                        <button type="button"
                        class="btn bg-white px-4 openAddItemModal">
                            Add Item to your Shipment
                        </button>
                    </div>
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




public function saveShipment($data, User $user){
    $shipment = new Shipment;
    $shipment->user_id = $user->id;
    //$shipment->external_shipment_id = $data->shipment_id;
    //$shipment->pickup_date = $data->pickup_date;
    $shipment->save();

    foreach($data->parcels as $parcel):
        $newParcel = new Parcel;
        $newParcel->shipment_id = $shipment->id;
        //$newParcel->external_parcel_id = $parcel->parcel_id;
        //$newParcel->weight = $parcel->total_weight;
        //$newParcel->weight_unit = $parcel->weight_unit;
        $newParcel->save();

        foreach($parcel->items as $item):
            $newItem = new Item;
            $newItem->shipment_id = $shipment->id;
            $newItem->parcel_id = $newParcel->id;
            $newItem->name = $item->name;
            $newItem->currency = $item->currency;
            $newItem->description = $item->description;
            $newItem->value = $item->value;
            $newItem->quantity = $item->quantity;
            $newItem->weight = $item->weight;
            $newItem->save();
        endforeach;
    endforeach;

    $from = new Address;
    $from->shipment_id = $shipment->id;
    $from->firstname = $data->address_from->first_name;
    $from->lastname = $data->address_from->last_name;
    $from->email = $data->address_from->email;
    $from->phone = $data->address_from->phone;
    $from->country = $data->address_from->country;
    $from->state = $data->address_from->state;
    $from->city = $data->address_from->city;
    $from->zip = $data->address_from->zip;
    $from->line1 = $data->address_from->line1;
    $from->type = "from";
    $from->save();

    $to = new Address;
    $to->shipment_id = $shipment->id;
    $to->firstname = $data->address_to->first_name;
    $to->lastname = $data->address_to->last_name;
    $to->email = $data->address_to->email;
    $to->phone = $data->address_to->phone;
    $to->country = $data->address_to->country;
    $to->state = $data->address_to->state;
    $to->city = $data->address_to->city;
    $to->zip = $data->address_to->zip;
    $to->line1 = $data->address_to->line1;
    $to->type = "to";
    $to->save();
}

public function saShipment($data, User $user){
        $shipment = new Shipment;
        $shipment->user_id = $user->id;
        //$shipment->external_shipment_id = $data->shipment_id;
        //$shipment->pickup_date = $data->pickup_date;
        $shipment->save();

        foreach($data->parcels as $parcel):
            $newParcel = new Parcel;
            $newParcel->shipment_id = $shipment->id;
            //$newParcel->external_parcel_id = $parcel->parcel_id;
            //$newParcel->weight = $parcel->total_weight;
            //$newParcel->weight_unit = $parcel->weight_unit;
            $newParcel->save();

            foreach($parcel->items as $item):
                $newItem = new Item;
                $newItem->shipment_id = $shipment->id;
                $newItem->parcel_id = $newParcel->id;
                $newItem->name = $item->name;
                $newItem->currency = $item->currency;
                $newItem->description = $item->description;
                $newItem->value = $item->value;
                $newItem->quantity = $item->quantity;
                $newItem->weight = $item->weight;
                $newItem->save();
            endforeach;
        endforeach;

        $from = new Address;
        $from->shipment_id = $shipment->id;
        $from->firstname = $data->address_from->first_name;
        $from->lastname = $data->address_from->last_name;
        $from->email = $data->address_from->email;
        $from->phone = $data->address_from->phone;
        $from->country = $data->address_from->country;
        $from->state = $data->address_from->state;
        $from->city = $data->address_from->city;
        $from->zip = $data->address_from->zip;
        $from->line1 = $data->address_from->line1;
        $from->type = "from";
        $from->save();

        $to = new Address;
        $to->shipment_id = $shipment->id;
        $to->firstname = $data->address_to->first_name;
        $to->lastname = $data->address_to->last_name;
        $to->email = $data->address_to->email;
        $to->phone = $data->address_to->phone;
        $to->country = $data->address_to->country;
        $to->state = $data->address_to->state;
        $to->city = $data->address_to->city;
        $to->zip = $data->address_to->zip;
        $to->line1 = $data->address_to->line1;
        $to->type = "to";
        $to->save();
    }

    public function edShipment($data){
        $shipment = Shipment::where("external_shipment_id", $data->shipment_id)->first();
        $shipment->parcels()->delete();
        $shipment->items()->delete();

        foreach($data->parcels as $parcel):
            $newParcel = new Parcel;
            $newParcel->shipment_id = $shipment->id;
            $newParcel->external_parcel_id = $parcel->parcel_id;
            $newParcel->weight = $parcel->total_weight;
            $newParcel->weight_unit = $parcel->weight_unit;
            $newParcel->save();

            foreach($parcel->items as $item):
                $newItem = new Item;
                $newItem->shipment_id = $shipment->id;
                $newItem->parcel_id = $newParcel->id;
                $newItem->name = $item->name;
                $newItem->currency = $item->currency;
                $newItem->description = $item->description;
                $newItem->value = $item->value;
                $newItem->quantity = $item->quantity;
                $newItem->weight = $item->weight;
                $newItem->save();
            endforeach;
        endforeach;

        $from = Address::where(["shipment_id" => $shipment->id, "type" => "from"])->first();
        $from->firstname = $data->address_from->first_name;
        $from->lastname = $data->address_from->last_name;
        $from->email = $data->address_from->email;
        $from->phone = $data->address_from->phone;
        $from->country = $data->address_from->country;
        $from->state = $data->address_from->state;
        $from->city = $data->address_from->city;
        $from->zip = $data->address_from->zip;
        $from->line1 = $data->address_from->line1;
        $from->type = "from";
        $from->save();

        $to = Address::where(["shipment_id" => $shipment->id, "type" => "to"])->first();;
        $to->firstname = $data->address_to->first_name;
        $to->lastname = $data->address_to->last_name;
        $to->email = $data->address_to->email;
        $to->phone = $data->address_to->phone;
        $to->country = $data->address_to->country;
        $to->state = $data->address_to->state;
        $to->city = $data->address_to->city;
        $to->zip = $data->address_to->zip;
        $to->line1 = $data->address_to->line1;
        $to->type = "to";
        $to->save();
    }


    function fetchSubCategories(formIdentifier, $chapter) {
    const config = {
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
            "X-Requested-With": "XMLHttpRequest"
        },
        params: {chapter: $chapter}
    };
    axios.get(`${baseUrl}/categories`, config)
    .then((res) => {
        let categories = res.data.results;
        // Update the state select input in the specified form
        $(`${formIdentifier} select[name='sub_category']`).empty(); // Clear previous options
        $(`${formIdentifier} select[name='sub_category']`).append(`
            <option value="">Choose one...</option>
        `).prop("disabled", false); // Clear previous options
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
    $(`#addItemForm select[name='sub_category']`).html(`
        <option value="">Processing...</option>
    `).prop("disabled", true);
    fetchSubCategories("#addItemForm", $id);
});
function fetchHsCode(formIdentifier, $chapter, $category) {
    const config = {
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
            "X-Requested-With": "XMLHttpRequest"
        },
        params: {chapter: $chapter, category: $category}
    };
    axios.get(`${baseUrl}/hs_codes`, config)
    .then((res) => {
        let hs_codes = res.data?.results?.hs_codes;
        // Update the state select input in the specified form
        $(`${formIdentifier} select[name='hs_code']`).empty(); // Clear previous options
        $(`${formIdentifier} select[name='hs_code']`).append(`
            <option value="">Choose one...</option>
        `).prop("disabled", false);
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
    $(`#addItemForm select[name='hs_code']`).html(`
        <option value="" >Processing...</option>`
    ).prop("disabled", true);
    fetchHsCode("#addItemForm", $chapter, $category);
});

async function populateForm($form, item) {
    for (let element of $form.find("input, select")) {
        let fieldName = $(element).attr("name"); 
        if (fieldName && item.hasOwnProperty(fieldName)) {
            if (fieldName === 'category') {
                $(element).val(item[fieldName]);
                console.log(`Fetching sub-categories for ${item[fieldName]}`);
                await fetchSubCategories($form, item[fieldName]);
                console.log(`Sub-categories fetched for ${item[fieldName]}`);
            }else if(fieldName === 'sub_category') {
                $(element).val(item[fieldName]);
                let $chapter = item['category'];
                console.log(`Fetching hs_codes for ${$chapter} and ${item[fieldName]}`);
                await fetchHsCode($form, $chapter, item[fieldName]);
                console.log(`HS codes fetched for ${$chapter} and ${item[fieldName]}`);
            }else if(fieldName === 'hs_code') {
                $(element).val(item[fieldName]);
            }else{
                $(element).val(item[fieldName]);
            }
        }
    }
}

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
</script>