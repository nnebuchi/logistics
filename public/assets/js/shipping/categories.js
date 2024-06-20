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