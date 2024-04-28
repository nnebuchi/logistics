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


