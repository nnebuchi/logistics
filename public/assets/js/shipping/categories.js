async function fetchSubCategories($form, $chapter) {
    const config = {
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
            "X-Requested-With": "XMLHttpRequest"
        },
        params: {chapter: $chapter}
    };
    return axios.get(`${baseUrl}/categories`, config)
    .then((res) => {
        let categories = res.data.results;
        // Update the state select input in the specified form
        $form.find("select[name='sub_category']").empty().append(`
            <option value="">Choose one...</option>
        `).prop("disabled", false);
        $form.find("select[name='hs_code']").empty().append(`
            <option value="">Choose one...</option>
        `);

        categories.forEach(category => {
            $form.find("select[name='sub_category']").append(`
                <option value="${category._id}" data-id="${$chapter}">${category.category}</option>`
            );
        });
    }).catch((error) => {
        console.error('Error fetching subcategories:', error);
    });
}
// Event handler for state select change for sender form
$("#addItemForm select[name='category']").on("change", async function(event) {
    event.preventDefault();
    let $id = $(this).val();
    $(`#addItemForm select[name='sub_category']`).html(`
        <option value="">Processing...</option>
    `).prop("disabled", true);
    await fetchSubCategories($("#addItemForm"), $id);
});
async function fetchHsCode($form, $chapter, $category) {
    const config = {
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
            "X-Requested-With": "XMLHttpRequest"
        },
        params: {chapter: $chapter, category: $category}
    };
    return axios.get(`${baseUrl}/hs_codes`, config)
    .then((res) => {
        let hs_codes = res.data?.results?.hs_codes;
        // Update the state select input in the specified form
        $form.find("select[name='hs_code']").empty().append(`
            <option value="">Choose one...</option>
        `).prop("disabled", false);

        hs_codes.forEach(hs_code => {
            $form.find("select[name='hs_code']").append(`
                <option value="${hs_code.hs_code}" data-description="${hs_code.sub_category}">${hs_code.sub_category}</option>`
            );
        });
    }).catch((error) => {
        console.error('Error fetching hs_codes:', error);
    });
}
// Event handler for state select change for sender form
$("#addItemForm select[name='sub_category']").on("change", async function(event) {
    event.preventDefault();
    let $category = $(this).val();
    let $chapter = $(this).find('option:selected').data('id');
    $(`#addItemForm select[name='hs_code']`).html(`
        <option value="" >Processing...</option>`
    ).prop("disabled", true);
    await fetchHsCode($("#addItemForm"), $chapter, $category);
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
