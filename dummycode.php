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

