function divisionsGet(selector){
    $.ajax({
        url: '../../Includes/HR/divisionsget.php',
        dataSrc: '',
        success: function (response) {
            $.each(JSON.parse(response), function (key, value) {
                $(selector).append('<option value="' + value.id + '">' + value.division + '</option>');
            });
        }
    });
}

function sitesGet(selector, formData) {
    $.ajax({
        url: '../../Includes/HR/sitesget.php',
        type: 'POST',
        data: JSON.stringify(formData),
        success: function (response) {
            $(selector).find('option').not(':first').remove();
            $.each(JSON.parse(response), function (key, value) {
                $(selector).append('<option value="' + value.id + '">' + value.site + '</option>');
            });
        }
    });
}