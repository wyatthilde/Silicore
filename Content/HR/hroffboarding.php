<!--<editor-fold desc="Header-resources">-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/custom-data-source/dom-text.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.9/jquery.autocomplete.js"></script>
<style>
    .autocomplete-suggestions {
        position: absolute;
        top: 18px;
        border: 1px solid #ccc;
        border-radius: 3px;
        left: 0px;
        list-style: none;
        padding: 4px 0px;
        display: none;
        background-color: white;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .175);
        overflow: auto;
    }

    .autocomplete-suggestion {
        display: block;
        padding: 6px 20px;
        white-space: nowrap;
        min-width: 100px;
    }

    .autocomplete-selected {

        background: #F0F0F0;

    }

    .autocomplete-suggestions strong {
        font-weight: normal;
        color: #3399FF;

    }

    .search-feedback.feedback-icon {
        position: absolute;
        width: auto;
        bottom: 10px;
        right: 10px;
        margin-top: 0;
        margin-right: 5px;
    }

    @media (min-width: 992px) {
        .container {
            max-width: 50%;
        }
    }

    .check:focus {
        border-color: transparent;
        box-shadow: none;
    }
</style>
<div class="container">
    <div class="card">

        <div class="card-body">
            <div class="form-row" id="employee-search-form">
                <div class="form-group col-xl-12">
                    <label for="employee-search">Employee</label>
                    <input class="form-control" id="employee-search" placeholder="Start typing to search employee">
                </div>
            </div>
            <div class="form-row" id="employee-info-form">

            </div>
        </div>

    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="assets-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Employee Assets</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="modal-content">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" id="modal-close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="return-assets-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Employee Assets</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="text-align:center;">
                <div class="loader hide" id="loader"><img src="..\..\Images\vprop_logo_navbar.gif" style='width:20%;'/></div>
            </div>
            <div class="modal-body" id="return-modal-content">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" id="modal-close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.$global = {
        employee_id: null,
        name: null
    };
    $(function () {
        let $employeeSearch = $('#employee-search');
        let $employeeSearchForm = $('#employee-search-form');
        let $employeeInfoForm = $('#employee-info-form');
        let $autocomplete = $employeeSearch.autocomplete({
            serviceUrl: '../../Includes/HR/offboardemployeesearch.php',
            onSelect: function (suggestion) {
                let self = $(this);
                self.prop('disabled', true).parent().append('<div class="search-feedback feedback-icon" id="close-search" style="display:block;"><i class="fa fa-times"></i></div></div>');
                let formData = {};
                $global.employee_id = suggestion.data;
                $global.name = suggestion.value;
                formData['id'] = $global.employee_id;
                $.ajax({
                    url: '../../Includes/HR/employeebyidget.php',
                    type: 'POST',
                    data: JSON.stringify(formData),
                    success: function (response) {
                        let data = JSON.parse(response)[0];
                        $employeeInfoForm.append('<div class="form-group col-xl-12"><label for="employee-info-group">Employee Information</label><ul class="list-group"><li class="list-group-item" id="employee-info-group"></li></ul></div>');
                        $.each(data, function (key, value) {
                            if (key === 'start_date' || key === 'paycom_id' || key === 'separation_date') {
                                if (key === 'separation_date') {
                                    if (value === null) {
                                        value = 'Currently employed'
                                    }
                                }
                                if (key === 'start_date') {
                                    if (value === null) {
                                        value = 'Start date not recorded'
                                    }
                                }
                                $employeeInfoForm.find('#employee-info-group').append('<div class="form-group col-xl-12"><label for="' + key + '">' + humanize(key) + '</label>' +
                                    '<input id="' + key + '" class="form-control" type="text" value="' + value + '" disabled></div>');
                            }

                        });
                        if (data.is_active === '1') {
                            $employeeInfoForm.append('<div class="form-group col-xl-12">' +
                                '<label for="action-group">Actions</label>' +
                                '<ul class="list-group">' +
                                '<li class="list-group-item" id="action-group">' +
                                '<div class="form-group col-xl-12">' +
                                '<button type="button" class="btn btn-basic float-left" data-toggle="modal" data-target="#assets-modal">View Assets</button><button type="button" class="btn btn-basic float-right" id="terminate-employee">Terminate</button>' +
                                '</div>' +
                                '</li>' +
                                '</ul>' +
                                '</div>');
                        } else {
                            $employeeInfoForm.append('<div class="form-group col-xl-12">' +
                                '<label for="action-group">Actions</label>' +
                                '<ul class="list-group">' +
                                '<li class="list-group-item" id="action-group">' +
                                '<div class="form-group col-xl-12 text-center mb-0">' +
                                '<button type="button" class="btn btn-basic" data-toggle="modal" data-target="#return-assets-modal">Return Assets</button>' +
                                '</div>' +
                                '</li>' +
                                '</ul>' +
                                '</div>');
                        }

                    }

                });
            }
        });
        let $returnAssetsModal = $('#return-assets-modal');
        let $assetsModal = $('#assets-modal');
        $employeeSearchForm.on('click', '#close-search', function () {
            $employeeSearch.prop('disabled', false).val('');
            $employeeInfoForm.children().remove();
            $('#close-search').remove();
        });

        $('#assets-modal').on('show.bs.modal', function () {
            let $content = $('#modal-content');
            let formData = {};
            formData['id'] = $global.employee_id;
            $content.children().remove();
            $.ajax({
                url: '../../Includes/HR/assetrequestsbyemployeeid.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    if (parseInt(response) !== 0) {
                        let data = JSON.parse(response);
                        $content.append('<label>Currently Assigned</label><ul class="list-group"><li class="list-group-item pb-0"><div class="form-row pb-0" id="current-assets"></div></li></ul>');
                        $.each(data, function (key, value) {
                            $content.find('#current-assets').append('<div class="form-group col-xl-12">' + value.type + '</div>')
                        });
                    } else {
                        $content.append('<p>No records found.</p>');
                    }

                }
            });
        });

        $returnAssetsModal.on('show.bs.modal', function () {
            let $content = $('#return-modal-content');
            let $self = $(this);
            let formData = {};
            $self.find('#return-assets-save').remove();
            formData['id'] = $global.employee_id;
            $content.children().remove();
            $.ajax({
                url: '../../Includes/HR/assetrequestsbyemployeeid.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    if (parseInt(response) !== 0) {
                        let data = JSON.parse(response);
                        $content.append('<label>Check the assets that have been returned</label><ul class="list-group">' +
                            '<li class="list-group-item pb-0">' +
                            '<h6 class="list-group-item-heading pb-2">Assigned Assets</h6>' +
                            '<div class="form-row pb-0" id="return-current-assets"></div></li>' +
                            '<li class="list-group-item pb-0"><h6 class="list-group-item-heading pb-2">Other Assets</h6>' +
                            '<div class="form-row pb-0" id="return-other-assets"></div>' +
                            '</li>' +
                            '<li class="list-group-item pb-0"><h6 class="list-group-item-heading pb-2">Returned Assets</h6>' +
                            '<div class="form-row pb-0" id="returned-assets"></div>' +
                            '</li></ul>');
                        $.each(data, function (key, value) {
                            $content.find('#return-current-assets').append('<div class="form-group col-xl-12">' +
                                '<button type="button" class="btn bg-transparent check" id="' + value.type + '"><i class="far fa-square text-secondary"></i></button><label for="' + value.type + '">' + value.type + '</label></div>');
                        });
                        $content.find('#return-other-assets').append('<div class="form-group col-xl-12">' +
                            '<button type="button" class="btn bg-transparent check" id="Uniform"><i class="far fa-square text-secondary"></i></button>' +
                            '<label for="Uniform">Uniform</label>' +
                            '</div>');

                        $.ajax({
                            url: '../../Includes/HR/returnedassetsbyemployeeidget.php',
                            type: 'POST',
                            data: JSON.stringify(formData),
                            success: function (response) {
                                let data = JSON.parse(response);
                                if (parseInt(response) !== 0) {
                                    $.each(data, function (key, value) {
                                        $content.find('#returned-assets').append('<div class="form-group col-xl-12">' +
                                            '<label class="ml-3">' + value.asset_type + '</label></div>');
                                    });
                                } else {
                                    $content.find('#returned-assets').append('<div class="form-group col-xl-12">' +
                                        'No assets have been returned</div>');
                                }
                            }
                        });

                        $self.find('.modal-footer').append('<button type="button" class="btn btn-vprop-blue-medium float-right" id="return-assets-save">Save</button>');
                    } else {
                        $content.append('<label>Check the assets that have been returned</label>' +
                            '<ul class="list-group"><li class="list-group-item pb-0">' +
                            '<div class="form-row pb-0" id="return-current-assets"></div></li>' +
                            '<li class="list-group-item pb-0"><h6 class="list-group-item-heading pb-2">Returned Assets</h6>' +
                            '<div class="form-row pb-0" id="returned-assets"></div></li></ul>');
                        $.ajax({
                            url: '../../Includes/IT/assettypesget.php',
                            dataSrc: '',
                            success: function (response) {
                                let data = JSON.parse(response);
                                $.each(data, function (key, value) {
                                    $content.find('#return-current-assets').append('<div class="form-group col-xl-12">' +
                                        '<button type="button" class="btn bg-transparent check" id="' + value.type + '"><i class="far fa-square text-secondary"></i></button>' +
                                        '<label for="' + value.type + '">' + value.type + '</label></div>');
                                });
                                $content.find('#return-current-assets').append('<div class="form-group col-xl-12">' +
                                    '<button type="button" class="btn bg-transparent check" id="Uniform"><i class="far fa-square text-secondary"></i></button>' +
                                    '<label for="Uniform">Uniform</label>' +
                                    '</div>');
                                $.ajax({
                                    url: '../../Includes/HR/returnedassetsbyemployeeidget.php',
                                    type: 'POST',
                                    data: JSON.stringify(formData),
                                    success: function (response) {
                                        let data = JSON.parse(response);
                                        if (parseInt(response) !== 0) {
                                            $.each(data, function (key, value) {
                                                $content.find('#returned-assets').append('<div class="form-group col-xl-12">' +
                                                    '<label class="ml-3">' + value.asset_type + '</label></div>');
                                            });
                                        } else {
                                            $content.find('#returned-assets').append('<div class="form-group col-xl-12">' +
                                                'No assets have been returned</div>');
                                        }
                                    }
                                });
                                $self.find('.modal-footer').append('<button type="button" class="btn btn-vprop-blue-medium float-right" id="return-assets-save">Save</button>');
                            },
                            error: function () {
                                errorAlert('Bad server response!');
                            }
                        });
                    }

                }
            });
        });

        $employeeInfoForm.on('click', '#terminate-employee', function () {
            let formData = {};
            formData['id'] = $global.employee_id;
            $.confirm({
                title: 'Terminate Employee',
                type: 'red',
                content: 'Are you sure you want to terminate ' + $employeeSearch.val() + '?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-danger',
                        action: function () {
                            $.ajax({
                                url: '../../Includes/HR/deactivateemployee.php',
                                type: 'POST',
                                data: JSON.stringify(formData),
                                beforeSend: function () {
                                    $employeeInfoForm.find('#employee-info-group').hide();
                                },
                                success: function (response) {
                                    let data = JSON.parse(response);
                                    $employeeInfoForm.children().remove();
                                    if (data.read === 1) {
                                        $.ajax({
                                            url: '../../Includes/HR/employeebyidget.php',
                                            type: 'POST',
                                            data: JSON.stringify(formData),
                                            success: function (response) {
                                                let data = JSON.parse(response)[0];
                                                $employeeInfoForm.append('<div class="form-group col-xl-12"><label for="employee-info-group">Employee Information</label><ul class="list-group"><li class="list-group-item" id="employee-info-group"></li></ul></div>');
                                                $.each(data, function (key, value) {
                                                    if (key === 'start_date' || key === 'paycom_id' || key === 'separation_date') {
                                                        if (key === 'separation_date') {
                                                            if (value === null) {
                                                                value = 'Currently employed'
                                                            }
                                                        }
                                                        if (key === 'start_date') {
                                                            if (value === null) {
                                                                value = 'Start date not recorded'
                                                            }
                                                        }
                                                        $employeeInfoForm.find('#employee-info-group').append('<div class="form-group col-xl-12"><label for="' + key + '">' + humanize(key) + '</label>' +
                                                            '<input id="' + key + '" class="form-control" type="text" value="' + value + '" disabled></div>');
                                                    }

                                                });
                                                if (data.is_active === '1') {
                                                    $employeeInfoForm.append('<div class="form-group col-xl-12">' +
                                                        '<label for="action-group">Actions</label>' +
                                                        '<ul class="list-group">' +
                                                        '<li class="list-group-item" id="action-group">' +
                                                        '<div class="form-group col-xl-12">' +
                                                        '<button type="button" class="btn btn-basic float-left" data-toggle="modal" data-target="#assets-modal">View Assets</button><button type="button" class="btn btn-basic float-right" id="terminate-employee">Terminate</button>' +
                                                        '</div>' +
                                                        '</li>' +
                                                        '</ul>' +
                                                        '</div>');
                                                } else {
                                                    $employeeInfoForm.append('<div class="form-group col-xl-12">' +
                                                        '<label for="action-group">Actions</label>' +
                                                        '<ul class="list-group">' +
                                                        '<li class="list-group-item" id="action-group">' +
                                                        '<div class="form-group col-xl-12 text-center mb-0">' +
                                                        '<button type="button" class="btn btn-basic" data-toggle="modal" data-target="#return-assets-modal">Return Assets</button>' +
                                                        '</div>' +
                                                        '</li>' +
                                                        '</ul>' +
                                                        '</div>');
                                                }

                                            }

                                        });
                                    }
                                }
                            });
                        }
                    },
                    cancel: {
                        btnClass: 'btn-basic',
                        action: function () {

                        }
                    }
                }
            });
        });

        $('.modal').on('click', '.check', function () {
            let $self = $(this);
            checkbox($self);
        });

        $returnAssetsModal.on('click', '#return-assets-save', function () {
            let formData = {};
            formData['id'] = $global.employee_id;
            formData['userId'] = <?php echo $_SESSION['user_id']; ?>;
            $.each($returnAssetsModal.find('button'), function (key, value) {
                if ($(value).val() === '1') {
                    formData['type'] = $(value).attr('id');
                    $.ajax({
                        url: '../../Includes/HR/returnasset.php',
                        type: 'POST',
                        data: JSON.stringify(formData),
                        beforeSend: function () {
                            $('#return-modal-content').hide();
                            $('#loader').show();

                        },
                        success: function (response) {
                            $returnAssetsModal.modal('hide');
                            $('#loader').hide();
                            $('#return-modal-content').show();
                        },
                        error: function () {

                        }
                    });
                }

            });
        });

    });

    function checkbox(e) {
        if (e.find('i').attr('class') === 'far fa-square text-secondary') {
            e.find('i').removeClass().addClass('far fa-check-square text-secondary');
            e.val(1);
        }
        else if (e.find('i').attr('class') === 'far fa-check-square text-secondary') {
            e.find('i').removeClass().addClass('far fa-square text-secondary');
            e.val(0);
        }
    }

    function successAlert(message) {
        $.alert({
            title: 'Success',
            icon: 'fa fa-check',
            type: 'green',
            content: message
        });
    }

    function errorAlert(message) {
        $.alert({
            title: 'Error',
            icon: 'fa fa-warning',
            type: 'red',
            content: message
        });
    }

    function humanize(str) {
        let frags = str.split('_');
        for (i = 0; i < frags.length; i++) {
            frags[i] = frags[i].charAt(0).toUpperCase() + frags[i].slice(1);
        }
        return frags.join(' ');
    }

    function upperCaseFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function lowerCaseAllWordsExceptFirstLetters(string) {
        return string.replace(/\w\S*/g, function (word) {
            return word.charAt(0) + word.slice(1).toLowerCase();
        });
    }
</script>