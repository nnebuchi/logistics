//Preview the images before uploading
$(document).on("change", ".document-file", function(event){
    const fileInput = $(this);
    let img = fileInput.closest("form").find("img");
    let title = fileInput.closest("form").find("input").val();
    if (title.length == 0) {
        alert("please input a title in the field");
    }else{
        img.replaceWith('<img src="/assets/images/loader.gif" id="loader-gif">');
        let count = fileInput.data("count");
        let table = fileInput.data("parcel");
        const previewDiv = fileInput.closest("form").find(".document-preview");
        const documentCountSpan = fileInput.closest("form").find(".document-count");
        let payload = {
            photo: fileInput[0].files[0]
        };
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "multipart/form-data",
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
                "X-Requested-With": "XMLHttpRequest"
            }
        };
        axios.post(`${baseUrl}/user`, payload, config)
        .then((res) => {
            let data = res.data.results;
            count++;
            $(this).data("count", count);
            documentCountSpan.text(`${count} document(s) uploaded`);
            previewDiv.append(`<p class="fw-semibold m-0" style="font-size:14px">${data.photo}</p>`);
            if (!parcelDoc[table]) {
                parcelDoc[table] = [];
            }
            parcelDoc[table].push(data.photo);
            // Replace loading GIF with cloud image
            fileInput.closest("form").find("img#loader-gif").replaceWith('<img src="/assets/images/icons/cloud-upload.svg" width="25">');
            //img.replaceWith('<img src="/assets/images/icons/cloud-upload.svg" width="25">');
        })
        .catch((error) => {
            console.error("Error uploading file:", error);
            // Handle error by removing the loader GIF
            fileInput.closest("form").find("img#loader-gif").remove();
        });
    }
});