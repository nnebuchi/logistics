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

