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