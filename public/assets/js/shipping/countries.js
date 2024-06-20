function fetchStates(formIdentifier, countryId) {
    const config = {
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
            "X-Requested-With": "XMLHttpRequest"
        }
    };
    axios.get(`${baseUrl}/states/${countryId}`, config)
    .then((res) => {
        let states = res.data.results;
        // Update the state select input in the specified form
        $(`${formIdentifier} select[name='state']`).empty(); // Clear previous options
        $(`${formIdentifier} select[name='city']`).empty(); // Clear previous options
        $(`${formIdentifier} select[name='city']`).html(`
            <option value="">Choose one...</option>
        `).prop("disabled", true);
        $(`${formIdentifier} select[name='state']`).html(`
            <option value="">Choose one...</option>
        `).prop("disabled", false);
        states.forEach(state => {
            $(`${formIdentifier} select[name='state']`).append(`
                <option value="${state.name}" data-id="${state.id}">${state.name}</option>`
            );
        });
    });
}
// Event handler for country select change for sender form
$("#sender select[name='country']").on("change", function(event) {
    event.preventDefault();
    //let countryId = $(this).val();
    let countryId = $(this).find('option:selected').data('id');
    // Attach country code
    var countryCode = $(this).find('option:selected').data('phonecode');
    $("input[name='phone']").val(countryCode);
    $("input[name='phone']").data("phone", countryCode);
    $(`#sender select[name='state']`).html(`
        <option value="">Processing...</option>
    `).prop("disabled", true);
    fetchStates("#sender", countryId);
});
// Event handler for country select change for receiver form
$("#receiver select[name='country']").on("change", function(event) {
    event.preventDefault();
    //let countryId = $(this).val();
    let countryId = $(this).find('option:selected').data('id');
    // Attach country code
    var countryCode = $(this).find('option:selected').data('phonecode');
    $("input[name='phone']").val(countryCode);
    $("input[name='phone']").data("phone", countryCode);
    $(`#receiver select[name='state']`).html(`
        <option value="">Processing...</option>
    `).prop("disabled", true);
    fetchStates("#receiver", countryId);
});

function fetchCities(formIdentifier, stateId) {
    const config = {
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
            "X-Requested-With": "XMLHttpRequest"
        }
    };
    axios.get(`${baseUrl}/cities/${stateId}`, config)
    .then((res) => {
        let cities = res.data.results;
        // Update the state select input in the specified form
        $(`${formIdentifier} select[name='city']`).empty(); // Clear previous options
        $(`${formIdentifier} select[name='city']`).html(`
            <option value="">Choose one...</option>
        `).prop("disabled", false);
        cities.forEach(city => {
            $(`${formIdentifier} select[name='city']`).append(`
                <option value="${city.name}" data-id="${city.id}">${city.name}</option>`
            );
        });
    });
}
// Event handler for state select change for sender form
$("#sender select[name='state']").on("change", function(event) {
    event.preventDefault();
    //let stateId = $(this).val();
    let stateId = $(this).find('option:selected').data('id');
    $(`#sender select[name='city']`).html(`
        <option value="">Processing...</option>
    `).prop("disabled", true);
    fetchCities("#sender", stateId);
});
// Event handler for state select change for receiver form
$("#receiver select[name='state']").on("change", function(event) {
    event.preventDefault();
    //let stateId = $(this).val();
    let stateId = $(this).find('option:selected').data('id');
    $(`#receiver select[name='city']`).html(`
        <option value="">Processing...</option>
    `).prop("disabled", true);
    fetchCities("#receiver", stateId);
});
