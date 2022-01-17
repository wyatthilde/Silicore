<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 12/3/2018
 * Time: 2:27 PM
 */
?>

<!--<editor-fold desc="Header-resources">-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js"></script>
<script src="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.full.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/custom-data-source/dom-text.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.9/jquery.autocomplete.js"></script>
<style>
    .page-item.active .page-link {
        background-color: #4C7AD0;
        border-color: #4C7AD0;
    }

    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    .modal-content {
        width: 100% !important;
        max-width: 1080px !important;
    }

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

    .btn-basic:not(:disabled):not(.disabled).active {
        background-color: #4C7AD0;
        color: white;
    }

    .valid-check {
        top: 10px;
    }
</style>
<!--</editor-fold>-->

<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Add Transaction</h4>
        </div>
        <div class="card-body p-0">
            <div class="card bg-light border-bottom-0 border-left-0 border-right-0 border-top-0 mt-2 rounded-0" id="transaction-card">
                <div class="card-header bg-white">
                    <div id="form-select">
                        <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                            <label for="primary" class="btn btn-basic w-100 border-white">
                                Spool
                                <input type="radio" class="hide" name="options" id="primary">
                            </label>
                            <label for="secondary" class="btn btn-basic w-100 border-white">
                                Parts
                                <input type="radio" class="hide" name="options" id="secondary">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-row hide" id="product-input">
                        <div class="form-group col-xl-12">
                            <label for="existing-products">Product Serial</label>
                            <input type="text" id="existing-products" class="form-control" placeholder="Scan or type the product serial">
                        </div>
                        <div id="prod-transaction-form" class="w-100 form-row">

                        </div>
                    </div>
                    <div class="form-row hide" id="part-input">
                        <div class="form-group col-xl-12">
                            <label>Part Information</label>
                            <ul class="list-group">
                                <li class="list-group-item bg-light" id="part-info-list-group">
                                    <div class="form-group col-xl-12">
                                        <label for="part-type-select">Part Type</label>
                                        <div class="btn-group btn-group-toggle d-flex" id="part-type-select" data-toggle="buttons"><span class="valid-check"></span></div>
                                        <script>
                                            $.ajax({
                                                url: '../../Includes/Loadout/part_types_get.php',
                                                dataSrc: '',
                                                success: function (response) {
                                                    let data = JSON.parse(response);
                                                    $.each(data, function (key, value) {
                                                        $('#part-type-select').prepend('<label for="from-' + value.part_type + '" class="btn btn-basic w-100 border-white">' +
                                                            '<input type="radio" class="hide" name="options" id="from-' + value.part_type + '" value="' + value.id + '">' + value.part_type + '</label>');
                                                    });
                                                }
                                            });
                                        </script>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <label>Part Size</label>
                                        <div class="btn-group btn-group-toggle d-flex" id="part-size-select" data-toggle="buttons">
                                            <label for="prod-MXL Coil" class="btn btn-basic w-100 border-white"><input type="radio" class="hide" name="options" id="prod-MXL Coil" value="3">
                                                MXL Coil</label>
                                            <label for="prod-12" class="btn btn-basic w-100 border-white"><input type="radio" class="hide" name="options" id="prod-12" value="2">
                                                12</label>
                                            <label for="prod-13.5" class="btn btn-basic w-100 border-white">
                                                <input type="radio" class="hide" name="options" id="prod-13.5" value="1">
                                                13.5</label>
                                            <span class="valid-check"></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <label for="quantity-input">Quantity</label>
                                        <input type="number" class="form-control" id="quantity-input">
                                        <div class="feedback">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div id="part-transaction-form" class="w-100 form-row">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(function () {
        //<editor-fold desc="variables">

        let $partForm = $('#part-transaction-form');
        let $productInput = $('#product-input');
        let $transactionForm = $('#prod-transaction-form');
        let $primaryLabel = $('label[for="primary"]');
        let $secondaryLabel = $('label[for="secondary"]');
        let $existingProducts = $('#existing-products');
        let $transactionCard = $('#transaction-card');
        let gStart = '<div class="form-group col-xl-12">';
        let gEnd = '</div>';
        let $partInput = $('#part-input');
        //</editor-fold>
        $primaryLabel.on('click', function () {
            $productInput.show();
            $partInput.hide();
        });
        $secondaryLabel.on('click', function () {
            $productInput.hide();
            $partInput.show();
        });
        let $autocomplete = $existingProducts.autocomplete({
            serviceUrl: '../../Includes/Loadout/onhandproductsget.php',
            deferRequestBy: '250',
            ajaxSettings: {
                success: function (response) {
                    let data = JSON.parse(response);
                    if (data.suggestions[0].value === "") {
                        $('body').find('div.autocomplete-suggestions').remove();
                    }
                }
            },
            onSelect: function (suggestion) {
                let self = $(this);
                self.prop('disabled', true).parent().append('<div class="search-feedback feedback-icon" id="close-product-btn" style="display:block;"><i class="fa fa-times"></i></div></div>');
                let formData = {};
                formData['product_id'] = suggestion.data;
                $.ajax({
                    url: '../../Includes/Loadout/productsbyidget.php',
                    type: 'POST',
                    data: JSON.stringify(formData),
                    success: function (response) {
                        let prodData = JSON.parse(response)[0];
                        $('#transaction-card').show().append('<div class="card-footer" id="transaction-card-footer"><button type="button" class="btn btn-vprop-green float-xl-right" id="new-transaction-btn">Submit</button></div>');
                        let fromListGroup = '<ul class="list-group"><li class="list-group-item bg-light" id="from-list-group">';
                        let toListGroup = '<ul class="list-group"><li class="list-group-item bg-light" id="to-list-group">';
                        let prodListGroup = '<ul class="list-group"><li class="list-group-item bg-light" id="prod-list-group">';
                        let lEnd = '</li></ul>';
                        let prodInfoLabel = '<label>Product Information</label>';
                        let prodTypeLabel = '<label for="product-type">Product Type</label>';
                        let prodTypeSelect = '<div class="btn-group btn-group-toggle d-flex" id="prod-type-select" data-toggle="buttons"><span class="valid-check"><i class="fa fa-check ml-1 valid-check text-success" style="position:absolute;"></i></span></div>';
                        let prodDescLabel = '<label for="product-desc-select">Product Description</label>';
                        let prodDescSelect = '<div class="btn-group btn-group-toggle d-flex" id="prod-desc-select" data-toggle="buttons">' +
                            '<label for="full" class="btn btn-basic w-100 border-white">Full' +
                            '<input type="radio" class="hide" name="options" id="full" value="1"></label>' +
                            '<label for="empty" class="btn btn-basic w-100 border-white">Empty' +
                            '<input type="radio" class="hide" name="options" id="empty" value="0"></label>' +
                            '<span class="valid-check"></span></div>';
                        let fromLabel = '<label for="from-input">From</label>';
                        let typeLabel = '<label>Type</label>';
                        let toIdLabel = '<label id="to-id-label"></label>';
                        let fromIdLabel = '<label id="from-id-label">Storage Number</label>';
                        let fromIdInput = '<input type="text" class="form-control from-id-input is-valid" id="from-id-input" value="' + prodData.to_trans_number + '"><div class="valid-feedback">Looks good!</div>';
                        let toIdInput = '<input type="text" class="form-control to-id-input hide" id="to-id-input"><div class="feedback"></div>';
                        let fromInput = '<div class="btn-group btn-group-toggle d-flex" id="from-type-select" data-toggle="buttons"><span class="valid-check"><i class="fa fa-check ml-1 valid-check text-success" style="position:absolute;"></i></span></div>';
                        let toLabel = '<label for="from-select">To</label>';
                        let toInput = '<div class="btn-group btn-group-toggle d-flex" id="to-type-select" data-toggle="buttons"><span class="valid-check"></span></div>';
                        $transactionForm.append(gStart + prodInfoLabel + prodListGroup + gStart + prodTypeLabel + prodTypeSelect + gEnd + gStart + prodDescLabel + prodDescSelect + gEnd + lEnd + gEnd + gStart + fromLabel + fromListGroup + gStart + typeLabel + fromInput + gEnd + gStart + fromIdLabel + fromIdInput + gEnd + lEnd + gEnd + gStart + toLabel + '<div>' + toListGroup + gStart + typeLabel + toInput + gEnd + gStart + toIdLabel + toIdInput + gEnd + lEnd + gEnd + gEnd + gEnd);
                        $.ajax({
                            url: '../../Includes/Loadout/product_types_get.php',
                            dataSrc: '',
                            success: function (response) {
                                let data = JSON.parse(response);
                                $.each(data, function (key, value) {
                                    $transactionForm.find('#prod-type-select').prepend('<label for="prod-' + value.product_type + '" class="btn btn-basic w-100 border-white" disabled>' +
                                        '<input type="text" class="hide" name="options" id="prod-' + value.product_type + '" value="' + value.id + '" disabled>' + value.product_type + '</label>');
                                });
                                $transactionForm.find('label[for="prod-' + prodData.product_type + '"]').addClass('active');
                            }
                        });
                        $.ajax({
                            url: '../../Includes/Loadout/transport_types_get.php',
                            dataSrc: '',
                            success: function (response) {
                                let data = JSON.parse(response);
                                $.each(data, function (key, value) {
                                    $transactionForm.find('#to-type-select').prepend('<label for="to-' + value.type + '" class="btn btn-basic w-100 border-white">' +
                                        '<input type="radio" class="hide" name="options" id="to-' + value.type + '" value="' + value.id + '">' + value.type + '</label>');
                                });
                                $.each(data, function (key, value) {
                                    $transactionForm.find('#from-type-select').prepend('<label for="from-' + value.type + '" class="btn btn-basic w-100 border-white">' +
                                        '<input type="radio" class="hide" name="options" id="from-' + value.type + '" value="' + value.id + '">' + value.type + '</label>');
                                });
                                $transactionForm.find('label[for="from-' + prodData.to_trans_type + '"]').addClass('active');
                            }
                        });
                        $('#new-transaction-btn').show();
                    }
                });
            },
            onSearchComplete: function (query, suggestions) {
                if (suggestions[0].value === "") {
                    let self = $(this);
                    self.prop('disabled', true).parent().append('<div class="search-feedback feedback-icon" id="close-product-btn" style="display:block;"><i class="fa fa-times"></i></div></div>');
                    let formData = {};
                    formData['product_id'] = self.val();
                    $('#transaction-card').show().append('<div class="card-footer" id="transaction-card-footer"><button type="button" class="btn btn-vprop-green float-xl-right" id="new-transaction-btn">Submit</button></div>');
                    let fromListGroup = '<ul class="list-group"><li class="list-group-item bg-light" id="from-list-group">';
                    let toListGroup = '<ul class="list-group"><li class="list-group-item bg-light" id="to-list-group">';
                    let prodListGroup = '<ul class="list-group"><li class="list-group-item bg-light" id="prod-list-group">';
                    let lEnd = '</li></ul>';
                    let prodInfoLabel = '<label>Product Information</label>';
                    let prodTypeLabel = '<label for="product-type">Product Type</label>';
                    let prodTypeSelect = '<div class="btn-group btn-group-toggle d-flex" id="prod-type-select" data-toggle="buttons"><span class="valid-check"></span></div>';
                    let prodDescLabel = '<label for="product-desc-select">Product Description</label>';
                    let prodDescSelect = '<div class="btn-group btn-group-toggle d-flex" id="prod-desc-select" data-toggle="buttons">' +
                        '<label for="full" class="btn btn-basic w-100 border-white">Full' +
                        '<input type="radio" class="hide" name="options" id="full" value="1"></label>' +
                        '<label for="empty" class="btn btn-basic w-100 border-white">Empty' +
                        '<input type="radio" class="hide" name="options" id="empty" value="0"></label>' +
                        '<span class="valid-check"></span></div>';
                    let fromLabel = '<label for="from-input">From</label>';
                    let typeLabel = '<label>Type</label>';
                    let toIdLabel = '<label id="to-id-label"></label>';
                    let fromIdLabel = '<label id="from-id-label"></label>';
                    let fromIdInput = '<input type="text" class="form-control from-id-input hide" id="from-id-input" value=""><div class="feedback"></div>';
                    let toIdInput = '<input type="text" class="form-control to-id-input hide" id="to-id-input"><div class="feedback"></div>';
                    let fromInput = '<div class="btn-group btn-group-toggle d-flex" id="from-type-select" data-toggle="buttons"><span class="valid-check"></span></div>';
                    let toLabel = '<label for="from-select">To</label>';
                    let toInput = '<div class="btn-group btn-group-toggle d-flex" id="to-type-select" data-toggle="buttons"><span class="valid-check"></span></div>';
                    $transactionForm.append(gStart + prodInfoLabel + prodListGroup + gStart + prodTypeLabel + prodTypeSelect + gEnd + gStart + prodDescLabel + prodDescSelect + gEnd + lEnd + gEnd + gStart + fromLabel + fromListGroup + gStart + typeLabel + fromInput + gEnd + gStart + fromIdLabel + fromIdInput + gEnd + lEnd + gEnd + gStart + toLabel + '<div>' + toListGroup + gStart + typeLabel + toInput + gEnd + gStart + toIdLabel + toIdInput + gEnd + lEnd + gEnd + gEnd + gEnd);
                    $.ajax({
                        url: '../../Includes/Loadout/product_types_get.php',
                        dataSrc: '',
                        success: function (response) {
                            let data = JSON.parse(response);
                            $.each(data, function (key, value) {
                                $transactionForm.find('#prod-type-select').prepend('<label for="prod-' + value.product_type + '" class="btn btn-basic w-100 border-white">' +
                                    '<input type="radio" class="hide" name="options" id="prod-' + value.product_type + '" value="' + value.id + '">' + value.product_type + '</label>');
                            });

                        }
                    });
                    $.ajax({
                        url: '../../Includes/Loadout/transport_types_get.php',
                        dataSrc: '',
                        success: function (response) {
                            let data = JSON.parse(response);
                            $.each(data, function (key, value) {
                                $transactionForm.find('#to-type-select').prepend('<label for="to-' + value.type + '" class="btn btn-basic w-100 border-white">' +
                                    '<input type="radio" class="hide" name="options" id="to-' + value.type + '" value="' + value.id + '">' + value.type + '</label>');
                            });
                            $.each(data, function (key, value) {
                                $transactionForm.find('#from-type-select').prepend('<label for="from-' + value.type + '" class="btn btn-basic w-100 border-white">' +
                                    '<input type="radio" class="hide" name="options" id="from-' + value.type + '" value="' + value.id + '">' + value.type + '</label>');
                            });
                        }
                    });

                }
            }
        });
        $partInput.one('click', '#part-type-select label', function () {
            let self = $(this);
            self.parent().parent().find('.valid-check').append('<i class="fa fa-check ml-1 valid-check text-success" style="position:absolute;"></i>');
            let selectedValue = self.find('input').val();
            let formData = {};
            formData['product_type'] = selectedValue;
            $('#transaction-card').show().append('<div class="card-footer" id="part-transaction-card-footer"><button type="button" class="btn btn-vprop-green float-xl-right" id="new-part-transaction-btn">Submit</button></div>');
            let fromListGroup = '<ul class="list-group"><li class="list-group-item bg-light" id="part-from-list-group">';
            let toListGroup = '<ul class="list-group"><li class="list-group-item bg-light" id="part-to-list-group">';
            let lEnd = '</li></ul>';

            let fromLabel = '<label for="part-from-input">From</label>';
            let typeLabel = '<label>Type</label>';
            let toIdLabel = '<label id="part-to-id-label"></label>';
            let fromIdLabel = '<label id="part-from-id-label"></label>';
            let fromIdInput = '<input type="text" class="form-control part-from-id-input hide" id="part-from-id-input" value=""><div class="feedback"></div>';
            let toIdInput = '<input type="text" class="form-control part-to-id-input hide" id="part-to-id-input"><div class="feedback"></div>';
            let fromInput = '<div class="btn-group btn-group-toggle d-flex" id="part-from-type-select" data-toggle="buttons"><span class="valid-check"></span></div>';
            let toLabel = '<label for="from-select">To</label>';
            let toInput = '<div class="btn-group btn-group-toggle d-flex" id="part-to-type-select" data-toggle="buttons"><span class="valid-check"></span></div>';
            $partForm.append(gStart + fromLabel + fromListGroup + gStart + typeLabel + fromInput + gEnd + gStart + fromIdLabel + fromIdInput + gEnd + lEnd + gEnd + gStart + toLabel + '<div>' + toListGroup + gStart + typeLabel + toInput + gEnd + gStart + toIdLabel + toIdInput + gEnd + lEnd + gEnd + gEnd + gEnd);
            $.ajax({
                url: '../../Includes/Loadout/transport_types_get.php',
                dataSrc: '',
                success: function (response) {
                    let data = JSON.parse(response);
                    $.each(data, function (key, value) {
                        $partForm.find('#part-to-type-select').prepend('<label for="part-to-' + value.type + '" class="btn btn-basic w-100 border-white">' +
                            '<input type="radio" class="hide" name="options" id="part-to-' + value.type + '" value="' + value.id + '">' + value.type + '</label>');
                    });
                    $.each(data, function (key, value) {
                        $partForm.find('#part-from-type-select').prepend('<label for="part-from-' + value.type + '" class="btn btn-basic w-100 border-white">' +
                            '<input type="radio" class="hide" name="options" id="part-from-' + value.type + '" value="' + value.id + '">' + value.type + '</label>');
                    });
                }
            });


        });
        $('#part-info-list-group input').on('input', function () {
            let self = $(this);
            if (self.val().length > 44) {
                self.val(self.val().substring(0, 44));
            }
            if (self.val().length < 1) {
                self.attr('class', 'form-control is-invalid').next('.feedback').attr('class', 'feedback invalid-feedback').text('Must be at least 1 character!');
            } else {
                self.attr('class', 'form-control is-valid').next('.feedback').attr('class', 'feedback valid-feedback').text('Looks good!');
            }

        });
        $partForm.on('click', '#part-from-list-group label', function () {
            let fromId = $partInput.find('#part-from-id-input');
            let fromLabel = $partInput.find('#part-from-id-label');
            let driverNameLabel = $partInput.find('#part-from-driver-name-label');
            let driverNameInput = $partInput.find('#part-from-driver-name-input');
            let driverCompanyLabel = $partInput.find('#part-from-driver-company-label');
            let driverCompanyInput = $partInput.find('#part-from-driver-company-select');
            let self = $(this);
            let inputId = self.find('input').attr('id');
            if (inputId) {
                fromId.attr('class', 'form-control');
                if (fromId.is(':visible')) {
                    fromId.hide().val("");
                    fromLabel.hide().text("");
                    driverNameInput.parent().remove();
                    driverNameLabel.parent().remove();
                    driverCompanyInput.parent().remove();
                    driverCompanyLabel.parent().remove();
                }
                if (inputId === 'part-from-Railcar') {
                    fromId.show();
                    fromLabel.show().text('Railcar Number');
                }
                if (inputId === 'part-from-Truck') {
                    fromId.show();
                    fromLabel.show().text('Truck Number');
                    self.parent().parent().parent().append(gStart + '<label id="part-from-driver-name-label">Driver Name</label><input id="part-from-driver-name-input" type="text" class="form-control"><div class="feedback"' + gEnd);
                    self.parent().parent().parent().append(gStart + '<label id="part-from-driver-company-label">Company</label><div class="btn-group btn-group-toggle d-flex" id="part-from-driver-company-select" data-toggle="buttons"><span class="valid-check"></span></div>' + gEnd);
                    $.ajax({
                        url: '../../Includes/Loadout/companies_get.php',
                        dataSrc: '',
                        success: function (response) {
                            let data = JSON.parse(response);
                            $.each(data, function (key, value) {
                                $partForm.find('#part-from-driver-company-select').prepend('<label for="options" class="btn btn-basic w-100 border-white">' +
                                    '<input type="radio" class="hide" name="options"  value="' + value.id + '">' + value.company_name + '</label>');
                            });
                        }
                    });
                }
                if (inputId === 'part-from-Storage') {
                    fromId.show();
                    fromLabel.show().text('Storage Number');
                }
            }
            if (self.text() !== 'Type' && self.text() !== 'Railcar Number' && self.text() !== 'Truck Number' && self.text() !== 'Storage Number' && self.text() !== 'Company') {
                if (self.parent().parent().find('.valid-check')) {
                    if (self.parent().parent().find('.valid-check').length < 2) {
                        self.parent().parent().find('.valid-check').append('<i class="fa fa-check ml-1 valid-check text-success" style="position:absolute;"></i>');
                    } else {
                        self.parent().parent().find('.valid-check').children().remove();
                        self.parent().parent().find('.valid-check').append('<i class="fa fa-check ml-1 valid-check text-success" style="position:absolute;"></i>');
                    }
                }
            }
        });
        $('#part-info-list-group').one('click', '#part-size-select label', function() {
            let self = $(this);
            self.parent().parent().find('.valid-check').append('<i class="fa fa-check ml-1 valid-check text-success" style="position:absolute;"></i>');
            if(self.hasClass('active')){
                self.parent().parent().find('.valid-check').children().remove();
            }
        });
        $partForm.on('click', '#part-to-list-group label', function () {
            let toId = $partInput.find('#part-to-id-input');
            let toLabel = $partInput.find('#part-to-id-label');
            let driverNameLabel = $partInput.find('#part-to-driver-name-label');
            let driverNameInput = $partInput.find('#part-to-driver-name-input');
            let driverCompanyLabel = $partInput.find('#part-to-driver-company-label');
            let driverCompanyInput = $partInput.find('#part-to-driver-company-select');
            let self = $(this);
            let inputId = self.find('input').attr('id');
            if (inputId) {
                toId.attr('class', 'form-control');
                if (toId.is(':visible')) {
                    toId.hide().val("");
                    toLabel.hide().text("");
                    driverNameInput.parent().remove();
                    driverNameLabel.parent().remove();
                    driverCompanyInput.parent().remove();
                    driverCompanyLabel.parent().remove();
                }
                if (inputId === 'part-to-Railcar') {
                    toId.show();
                    toLabel.show().text('Railcar Number');
                }
                if (inputId === 'part-to-Truck') {
                    toId.show();
                    toLabel.show().text('Truck Number');
                    self.parent().parent().parent().append(gStart + '<label id="part-to-driver-name-label">Driver Name</label><input id="part-to-driver-name-input" type="text" class="form-control"><div class="feedback"' + gEnd);
                    self.parent().parent().parent().append(gStart + '<label id="part-to-driver-company-label">Company</label><div class="btn-group btn-group-toggle d-flex" id="part-to-driver-company-select" data-toggle="buttons"><span class="valid-check"></span></div>' + gEnd);
                    $.ajax({
                        url: '../../Includes/Loadout/companies_get.php',
                        dataSrc: '',
                        success: function (response) {
                            let data = JSON.parse(response);
                            $.each(data, function (key, value) {
                                $partForm.find('#part-to-driver-company-select').prepend('<label for="options" class="btn btn-basic w-100 border-white">' +
                                    '<input type="radio" class="hide" name="options"  value="' + value.id + '">' + value.company_name + '</label>');
                            });
                        }
                    });
                }
                if (inputId === 'part-to-Storage') {
                    toId.show();
                    toLabel.show().text('Storage Number');
                }
            }
            if (self.text() !== 'Type' && self.text() !== 'Railcar Number' && self.text() !== 'Truck Number' && self.text() !== 'Storage Number' && self.text() !== 'Company') {
                if (self.parent().parent().find('.valid-check')) {
                    if (self.parent().parent().find('.valid-check').length < 2) {
                        self.parent().parent().find('.valid-check').append('<i class="fa fa-check ml-1 valid-check text-success" style="position:absolute;"></i>');
                    } else {
                        self.parent().parent().find('.valid-check').children().remove();
                        self.parent().parent().find('.valid-check').append('<i class="fa fa-check ml-1 valid-check text-success" style="position:absolute;"></i>');
                    }
                }
            }
        });
        $partForm.on('input', '#part-to-list-group input', function () {
            let self = $(this);
            if (self.attr('id') !== 'to-driver-name-input') {
                if (self.val().length > 44) {
                    self.val(self.val().substring(0, 44));
                }
                if (self.val().length < 2) {
                    self.attr('class', 'form-control is-invalid').next('.feedback').attr('class', 'feedback invalid-feedback').text('Must be at least 2 characters!');
                } else {
                    self.attr('class', 'form-control is-valid').next('.feedback').attr('class', 'feedback valid-feedback').text('Looks good!');
                }
            } else {
                self.val(self.val().replace(/[0-9]/g, ""));
                if (self.val().length >= 1) {
                    if (self.val().length < 69) {
                        self.attr('class', 'form-control is-valid').next('.feedback').attr('class', 'feedback valid-feedback').text('Looks good!');
                    } else {
                        self.attr('class', 'form-control is-invalid').next('.feedback').attr('class', 'feedback invalid-feedback').text('Must be at least 2 characters!');
                    }
                } else {
                    self.attr('class', 'form-control is-invalid').next('.feedback').attr('class', 'feedback invalid-feedback').text('Must be at least 1 character!');
                }
            }


        });
        $partForm.on('input', '#part-from-list-group input', function () {
            let self = $(this);
            if (self.attr('id') !== 'from-driver-name-input') {
                if (self.val().length > 44) {
                    self.val(self.val().substring(0, 44));
                }
                if (self.val().length < 2) {
                    self.attr('class', 'form-control is-invalid').next('.feedback').attr('class', 'feedback invalid-feedback').text('Must be at least 2 characters!');
                } else {
                    self.attr('class', 'form-control is-valid').next('.feedback').attr('class', 'feedback valid-feedback').text('Looks good!');
                }
            } else {
                self.val(self.val().replace(/[0-9]/g, ""));
                if (self.val().length >= 1) {
                    if (self.val().length < 69) {
                        self.attr('class', 'form-control is-valid').next('.feedback').attr('class', 'feedback valid-feedback').text('Looks good!');
                    } else {
                        self.attr('class', 'form-control is-invalid').next('.feedback').attr('class', 'feedback invalid-feedback').text('Must be at least 2 characters!');
                    }
                } else {
                    self.attr('class', 'form-control is-invalid').next('.feedback').attr('class', 'feedback invalid-feedback').text('Must be at least 1 character!');
                }
            }
        });

        $productInput.on('click', '#close-product-btn', function () {
            $transactionForm.children().remove();
            $productInput.find('#product-info').remove();
            $productInput.find('input').prop('disabled', false).val('');
            $('#close-product-btn').remove();
            $transactionCard.find('#transaction-card-footer').remove();
        });
        $productInput.on('click', '#from-list-group label', function () {
            let fromId = $productInput.find('#from-id-input');
            let fromLabel = $productInput.find('#from-id-label');
            let driverNameLabel = $productInput.find('#from-driver-name-label');
            let driverNameInput = $productInput.find('#from-driver-name-input');
            let driverCompanyLabel = $productInput.find('#from-driver-company-label');
            let driverCompanyInput = $productInput.find('#from-driver-company-select');
            let self = $(this);
            let inputId = self.find('input').attr('id');
            if (inputId) {
                fromId.attr('class', 'form-control');
                if (fromId.is(':visible')) {
                    fromId.hide().val("");
                    fromLabel.hide().text("");
                    driverNameInput.parent().remove();
                    driverNameLabel.parent().remove();
                    driverCompanyInput.parent().remove();
                    driverCompanyLabel.parent().remove();
                }
                if (inputId === 'from-Railcar') {
                    fromId.show();
                    fromLabel.show().text('Railcar Number');
                }
                if (inputId === 'from-Truck') {
                    fromId.show();
                    fromLabel.show().text('Truck Number');
                    self.parent().parent().parent().append(gStart + '<label id="from-driver-name-label">Driver Name</label><input id="from-driver-name-input" type="text" class="form-control"><div class="feedback"' + gEnd);
                    self.parent().parent().parent().append(gStart + '<label id="from-driver-company-label">Company</label><div class="btn-group btn-group-toggle d-flex" id="from-driver-company-select" data-toggle="buttons"><span class="valid-check"></span></div>' + gEnd);
                    $.ajax({
                        url: '../../Includes/Loadout/companies_get.php',
                        dataSrc: '',
                        success: function (response) {
                            let data = JSON.parse(response);
                            $.each(data, function (key, value) {
                                $transactionForm.find('#from-driver-company-select').prepend('<label for="options" class="btn btn-basic w-100 border-white">' +
                                    '<input type="radio" class="hide" name="options"  value="' + value.id + '">' + value.company_name + '</label>');
                            });
                        }
                    });
                }
                if (inputId === 'from-Storage') {
                    fromId.show();
                    fromLabel.show().text('Storage Number');
                }
            }
            if (self.text() !== 'Type' && self.text() !== 'Railcar Number' && self.text() !== 'Truck Number' && self.text() !== 'Storage Number' && self.text() !== 'Company') {
                if (self.parent().parent().find('.valid-check')) {
                    if (self.parent().parent().find('.valid-check').length < 2) {
                        self.parent().parent().find('.valid-check').append('<i class="fa fa-check ml-1 valid-check text-success" style="position:absolute;"></i>');
                    } else {
                        self.parent().parent().find('.valid-check').children().remove();
                        self.parent().parent().find('.valid-check').append('<i class="fa fa-check ml-1 valid-check text-success" style="position:absolute;"></i>');
                    }
                }
            }
        });
        $productInput.on('click', '#to-list-group label', function () {
            let toId = $productInput.find('#to-id-input');
            let toLabel = $productInput.find('#to-id-label');
            let driverNameLabel = $productInput.find('#to-driver-name-label');
            let driverNameInput = $productInput.find('#to-driver-name-input');
            let driverCompanyLabel = $productInput.find('#to-driver-company-label');
            let driverCompanyInput = $productInput.find('#to-driver-company-select');
            let self = $(this);
            let inputId = self.find('input').attr('id');
            if (inputId) {
                toId.attr('class', 'form-control');
                if (toId.is(':visible')) {
                    toId.hide().val("");
                    toLabel.hide().text("");
                    driverNameInput.parent().remove();
                    driverNameLabel.parent().remove();
                    driverCompanyInput.parent().remove();
                    driverCompanyLabel.parent().remove();
                }
                if (inputId === 'to-Railcar') {
                    toId.show();
                    toLabel.show().text('Railcar Number');
                }
                if (inputId === 'to-Truck') {
                    toId.show();
                    toLabel.show().text('Truck Number');
                    self.parent().parent().parent().append(
                        gStart + '<label id="to-driver-name-label">Driver Name</label>' +
                        '<input id="to-driver-name-input" type="text" class="form-control">' +
                        '<div class="feedback"></div>' + gEnd);
                    self.parent().parent().parent().append(
                        gStart + '<label id="from-driver-company-label">Company</label><div class="btn-group btn-group-toggle d-flex" id="to-driver-company-select" data-toggle="buttons"><span class="valid-check"></span></div>' + gEnd);
                    $.ajax({
                        url: '../../Includes/Loadout/companies_get.php',
                        dataSrc: '',
                        success: function (response) {
                            let data = JSON.parse(response);
                            $.each(data, function (key, value) {
                                $transactionForm.find('#to-driver-company-select').prepend('<label for="options" class="btn btn-basic w-100 border-white">' +
                                    '<input type="radio" class="hide" name="options"  value="' + value.id + '">' + value.company_name + '</label>');
                            });
                        }
                    });
                }
                if (inputId === 'to-Storage') {
                    toId.show();
                    toLabel.show().text('Storage Number');
                }
            }
            if (self.text() !== 'Type' && self.text() !== 'Railcar Number' && self.text() !== 'Truck Number' && self.text() !== 'Storage Number' && self.text() !== 'Company') {
                if (self.parent().parent().find('.valid-check')) {
                    if (self.parent().parent().find('.valid-check').length < 2) {
                        self.parent().parent().find('.valid-check').append('<i class="fa fa-check ml-1 valid-check text-success" style="position:absolute;"></i>');
                    } else {
                        self.parent().parent().find('.valid-check').children().remove();
                        self.parent().parent().find('.valid-check').append('<i class="fa fa-check ml-1 valid-check text-success" style="position:absolute;"></i>');
                    }
                }
            }

        });
        $productInput.on('click', '#prod-list-group label', function () {
            let self = $(this);
            if (self.attr('for') !== 'product-type' && self.attr('for') !== 'product-desc-select') {
                if (self.parent().parent().find('.valid-check').length < 2) {
                    self.parent().parent().find('.valid-check').append('<i class="fa fa-check ml-1 valid-check text-success" style="position:absolute;"></i>');
                } else {
                    self.parent().parent().find('.valid-check').children().remove();
                    self.parent().parent().find('.valid-check').append('<i class="fa fa-check ml-1 valid-check text-success" style="position:absolute;"></i>');
                }
            }

        });
        $productInput.on('input', '#to-list-group input', function () {
            let self = $(this);
            if (self.attr('id') !== 'to-driver-name-input') {
                if (self.val().length > 44) {
                    self.val(self.val().substring(0, 44));
                }
                if (self.val().length < 2) {
                    self.attr('class', 'form-control is-invalid').next('.feedback').attr('class', 'feedback invalid-feedback').text('Must be at least 2 characters!');
                } else {
                    self.attr('class', 'form-control is-valid').next('.feedback').attr('class', 'feedback valid-feedback').text('Looks good!');
                }
            } else {
                self.val(self.val().replace(/[0-9]/g, ""));
                if (self.val().length >= 1) {
                    if (self.val().length < 69) {
                        self.attr('class', 'form-control is-valid').next('.feedback').attr('class', 'feedback valid-feedback').text('Looks good!');
                    } else {
                        self.attr('class', 'form-control is-invalid').next('.feedback').attr('class', 'feedback invalid-feedback').text('Must be at least 2 characters!');
                    }
                } else {
                    self.attr('class', 'form-control is-invalid').next('.feedback').attr('class', 'feedback invalid-feedback').text('Must be at least 1 character!');
                }
            }
        });
        $productInput.on('input', '#from-list-group input', function () {
            let self = $(this);
            if (self.attr('id') !== 'from-driver-name-input') {
                if (self.val().length > 44) {
                    self.val(self.val().substring(0, 44));
                }
                if (self.val().length < 2) {
                    self.attr('class', 'form-control is-invalid').next('.feedback').attr('class', 'feedback invalid-feedback').text('Must be at least 2 characters!');
                } else {
                    self.attr('class', 'form-control is-valid').next('.feedback').attr('class', 'feedback valid-feedback').text('Looks good!');
                }
            } else {
                self.val(self.val().replace(/[0-9]/g, ""));
                if (self.val().length >= 1) {
                    if (self.val().length < 69) {
                        self.attr('class', 'form-control is-valid').next('.feedback').attr('class', 'feedback valid-feedback').text('Looks good!');
                    } else {
                        self.attr('class', 'form-control is-invalid').next('.feedback').attr('class', 'feedback invalid-feedback').text('Must be at least 2 characters!');
                    }
                } else {
                    self.attr('class', 'form-control is-invalid').next('.feedback').attr('class', 'feedback invalid-feedback').text('Must be at least 1 character!');
                }
            }
        });
        $transactionCard.on('click', '#new-transaction-btn', function () {
            let formData = {};
            let prodSerial = $('#existing-products').val();
            let prodType = $productInput.find('#prod-type-select label.active').find('input');
            let prodDesc = $productInput.find('#prod-desc-select label.active').find('input');
            let fromTransNumber = $productInput.find('#from-id-input');
            let fromTransType = $productInput.find('#from-type-select label.active').find('input');
            let fromTransDriver = $productInput.find('#from-driver-name-input');
            let fromTransCompany = $productInput.find('#from-driver-company-select label.active').find('input');
            let toTransNumber = $productInput.find('#to-id-input');
            let toTransType = $productInput.find('#to-type-select label.active').find('input');
            let toTransDriver = $productInput.find('#to-driver-name-input');
            let toTransCompany = $productInput.find('#to-driver-company-select label.active').find('input');
            let prodTypeSelect = $productInput.find('#prod-type-select label');
            let userId = <?php echo $_SESSION['user_id'];?>;
            if (prodSerial !== "") {
                formData['productSerial'] = prodSerial;
            } else {
                errorAlert('No product serial entered!');
                return false;
            }
            if (prodTypeSelect.hasClass('active')) {
                if (prodType.val() !== "") {
                    formData['productTypeId'] = prodType.val();
                } else {
                    errorAlert('Something is wrong with the product type!');
                    return false;
                }
            } else {
                $('#prod-type-select').find('.valid-check').append('<i class="fa fa-times ml-1 text-danger valid-check" style="position:absolute;"></i>');
                errorAlert('You must select a product type!');
                return false;
            }
            if ($('#prod-desc-select label').hasClass('active')) {
                if (prodDesc.val() !== '') {
                    formData['isFull'] = prodDesc.val();
                } else {
                    errorAlert('Something is wrong with the product description!');
                    return false;
                }
            } else {
                $('#prod-desc-select').find('.valid-check').append('<i class="fa fa-times ml-1 text-danger valid-check" style="position:absolute;"></i>');
                errorAlert('You must select a product description!');
                return false;
            }
            if ($('#from-type-select label').hasClass('active')) {
                if (fromTransType.val() !== "") {
                    formData['transportFromTypeId'] = fromTransType.val();
                    if (fromTransNumber.val() !== "") {
                        formData['transportFromNumber'] = fromTransNumber.val();
                    } else {
                        fromTransNumber.attr('class', 'form-control is-invalid');
                        errorAlert('You must put the transport number!');
                        return false;
                    }
                    if (fromTransType.val() === '1') {
                        if (fromTransDriver.val() !== "") {
                            formData['transportFromDriver'] = fromTransDriver.val();
                        } else {
                            fromTransDriver.attr('class', 'form-control is-invalid');
                            errorAlert('You must put the name of the driver!');
                            return false;
                        }
                        if ($('#from-driver-company-select label').hasClass('active')) {
                            if (fromTransCompany.val() !== "") {
                                formData['transportFromCompany'] = fromTransCompany.val();
                            } else {
                                errorAlert('Something is wrong with the from transport company!');
                                return false;
                            }
                        } else {
                            $('#from-driver-company-select').find('.valid-check').append('<i class="fa fa-times ml-1 text-danger valid-check" style="position:absolute;"></i>');
                            errorAlert('You must put the company name of the transporter!');
                            return false;
                        }

                    } else {
                        formData['transportFromDriver'] = 'No Driver';
                        formData['transportFromCompany'] = '1';
                    }
                } else {
                    errorAlert('Something is wrong with the transport type!');
                    return false;
                }
            } else {
                $('#from-type-select').find('.valid-check').append('<i class="fa fa-times ml-1 text-danger valid-check" style="position:absolute;"></i>');
                errorAlert('You must put the transport type!');
                return false;
            }
            if ($('#to-type-select label').hasClass('active')) {
                if (toTransType.val() !== "") {
                    formData['transportToTypeId'] = toTransType.val();
                    if (toTransNumber.val() !== "") {
                        formData['transportToNumber'] = toTransNumber.val();
                    } else {
                        toTransNumber.attr('class', 'form-control is-invalid');
                        errorAlert('You must enter the transport number!');
                        return false;
                    }
                    if (toTransType.val() === '1') {
                        if (toTransDriver.val() !== "") {
                            formData['transportToDriver'] = toTransDriver.val();
                        } else {
                            toTransDriver.attr('class', 'form-control is-invalid');
                            errorAlert('You must enter a driver name!');
                            return false;
                        }
                        if ($('#to-driver-company-select label').hasClass('active')) {
                            if (toTransCompany.val() !== "") {
                                formData['transportToCompany'] = toTransCompany.val();
                            } else {
                                errorAlert('Something is wrong with the selected company!');
                                return false;
                            }
                        } else {
                            $('#to-driver-company-select').find('.valid-check').append('<i class="fa fa-times ml-1 text-danger valid-check" style="position:absolute;"></i>');
                            errorAlert('You must select a company!');
                            return false;
                        }

                    } else {
                        formData['transportToDriver'] = 'No Driver';
                        formData['transportToCompany'] = '1';
                    }
                } else {
                    errorAlert('Something is wrong with the transport type!');
                    return false;
                }
            } else {
                $('#to-type-select').find('.valid-check').append('<i class="fa fa-times ml-1 text-danger valid-check" style="position:absolute;"></i>');
                errorAlert('You must select a transport type!');
                return false;
            }
            formData['user_id'] = userId;
            transactionInsert(formData);
        });

        $transactionCard.on('click', '#new-part-transaction-btn', function () {
            let formData = {};
            let partType = $partInput.find('#part-type-select label.active').find('input');
            let fromTransNumber = $partInput.find('#part-from-id-input');
            let fromTransType = $partInput.find('#part-from-type-select label.active').find('input');
            let fromTransDriver = $partInput.find('#part-from-driver-name-input');
            let fromTransCompany = $partInput.find('#part-from-driver-company-select label.active').find('input');
            let toTransNumber = $partInput.find('#part-to-id-input');
            let toTransType = $partInput.find('#part-to-type-select label.active').find('input');
            let toTransDriver = $partInput.find('#part-to-driver-name-input');
            let toTransCompany = $partInput.find('#part-to-driver-company-select label.active').find('input');
            let partTypeSelect = $partInput.find('#part-type-select label');
            let quantityInput = $partInput.find('#quantity-input');
            let partSize = $partInput.find('#part-size-select label.active').find('input');
            let userId = <?php echo $_SESSION['user_id'];?>;
            if (partTypeSelect.hasClass('active')) {
                if (partType.val() !== "") {
                    formData['partTypeId'] = partType.val();
                } else {
                    errorAlert('Something is wrong with the product type!');
                    return false;
                }
            } else {
                $('#part-type-select').find('.valid-check').append('<i class="fa fa-times ml-1 text-danger valid-check" style="position:absolute;"></i>');
                errorAlert('You must select a product type!');
                return false;
            }
            if (quantityInput.val() !== "") {
                formData['partQuantity'] = quantityInput.val();
            } else {
                quantityInput.attr('class', 'form-control is-invalid');
                errorAlert('You must enter a quantity for the part!');
                return false;
            }
            if ($('#part-from-type-select label').hasClass('active')) {
                if (fromTransType.val() !== "") {
                    formData['transportFromTypeId'] = fromTransType.val();
                    if (fromTransNumber.val() !== "") {
                        formData['transportFromNumber'] = fromTransNumber.val();
                    } else {
                        fromTransNumber.attr('class', 'form-control is-invalid');
                        errorAlert('You must put the transport number!');
                        return false;
                    }
                    if (fromTransType.val() === '1') {
                        if (fromTransDriver.val() !== "") {
                            formData['transportFromDriver'] = fromTransDriver.val();
                        } else {
                            fromTransDriver.attr('class', 'form-control is-invalid');
                            errorAlert('You must put the name of the driver!');
                            return false;
                        }
                        if ($('#part-from-driver-company-select label').hasClass('active')) {
                            if (fromTransCompany.val() !== "") {
                                formData['transportFromCompany'] = fromTransCompany.val();
                            } else {
                                errorAlert('Something is wrong with the from transport company!');
                                return false;
                            }
                        } else {
                            $('#part-from-driver-company-select').find('.valid-check').append('<i class="fa fa-times ml-1 text-danger valid-check" style="position:absolute;"></i>');
                            errorAlert('You must put the company name of the transporter!');
                            return false;
                        }

                    } else {
                        formData['transportFromDriver'] = 'No Driver';
                        formData['transportFromCompany'] = '1';
                    }
                } else {
                    errorAlert('Something is wrong with the transport type!');
                    return false;
                }
            } else {
                $('#part-from-type-select').find('.valid-check').append('<i class="fa fa-times ml-1 text-danger valid-check" style="position:absolute;"></i>');
                errorAlert('You must put the transport type!');
                return false;
            }
            if ($('#part-size-select label').hasClass('active')) {
               if(partSize.val() !== "") {
                   formData['partSize'] = partSize.val();
               }
            } else {
                $('#part-size-select').find('.valid-check').append('<i class="fa fa-times ml-1 text-danger valid-check" style="position:absolute;"></i>');
                errorAlert('You must select a part size!');
                return false;
            }
            if ($('#part-to-type-select label').hasClass('active')) {
                if (toTransType.val() !== "") {
                    formData['transportToTypeId'] = toTransType.val();
                    if (toTransType.val() === '1') {
                        if (toTransDriver.val() !== "") {
                            formData['transportToDriver'] = toTransDriver.val();
                            if (toTransNumber.val() !== "") {
                                formData['transportToNumber'] = toTransNumber.val();
                            } else {
                                toTransNumber.attr('class', 'form-control is-invalid');
                                errorAlert('You must enter the transport number!');
                                return false;
                            }
                        } else {
                            toTransDriver.attr('class', 'form-control is-invalid');
                            errorAlert('You must enter a driver name!');
                            return false;
                        }
                        if ($('#part-to-driver-company-select label').hasClass('active')) {
                            if (toTransCompany.val() !== "") {
                                formData['transportToCompany'] = toTransCompany.val();
                            } else {
                                errorAlert('Something is wrong with the selected company!');
                                return false;
                            }
                        } else {
                            $('#part-to-driver-company-select').find('.valid-check').append('<i class="fa fa-times ml-1 text-danger valid-check" style="position:absolute;"></i>');
                            errorAlert('You must select a company!');
                            return false;
                        }
                    } else {
                        formData['transportToDriver'] = 'No Driver';
                        formData['transportToCompany'] = '1';
                    }
                } else {
                    errorAlert('Something is wrong with the transport type!');
                    return false;
                }
            } else {
                $('#part-to-type-select').find('.valid-check').append('<i class="fa fa-times ml-1 text-danger valid-check" style="position:absolute;"></i>');
                errorAlert('You must select a transport type!');
                return false;
            }
            formData['user_id'] = userId;
            partTransactionInsert(formData);
        });
    });

    function transactionInsert(formData) {
        $('#transaction-card').find('#new-transaction-btn').remove();
        $.ajax({
            url: '../../Includes/Loadout/transaction_insert.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                successAlert('Transaction saved!');
                setTimeout(function () {
                    location.reload();
                }, 2000);

            },
            error: function() {
                errorAlert('Server Error');
            }
        });
    }

    function partTransactionInsert(formData) {
        $('#transaction-card').find('#new-transaction-btn').remove();
        $.ajax({
            url: '../../Includes/Loadout/parts_insert.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                successAlert('Transaction saved!');
                setTimeout(function () {
                    location.reload();
                }, 2000);
            }
        });
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

</script>