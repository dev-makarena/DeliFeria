function cargarVer(id) {
    $.ajax({
        type: 'GET',
        url: "{{ route('product.get') }}",
        data: {
            id: id,
        },
        success: function (data) {
            console.log(data[0].price);
            $('#nameInfo').text(data[0].name);
            $('#priceInfo').text(data[0].price);
            $('#descriptionInfo').text(data[0].description);
            $('#imgInfo').attr('src', data[0].img_url);

            $('#idedit').attr('value', id);

            clearModal();
            let info = $('#productInfo');
            if (info.css("display") == "none") {
                info.css("display", "block");
            }
            eg1OpenModal('eg1_modal');
        },
        error: function (error) {
            console.log(error);
        }
    }).fail(function (jqXHR, textStatus, error) {
        // Handle error here
        console.log(jqXHR.responseText);
    });

}

function formProduct(active = true) {
    clearModal();
    if (active == true) {
        let form = $('#formProduct');
        if (form.css("display") == "none") {
            form.css("display", "block");
        }
    }
}

function editProduct(active = true) {
    clearModal();
    if (active == true) {
        let edit = $('#editProduct');
        if (edit.css("display") == "none") {
            edit.css("display", "block");
        }
    }


}

function clearModal() {
    let form = $('#formProduct');
    form.css("display", "none");

    let info = $('#productInfo');
    info.css("display", "none");
    let edit = $('#editProduct');
    edit.css("display", "none");
}