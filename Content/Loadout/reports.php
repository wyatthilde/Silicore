<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 12/13/2018
 * Time: 8:50 AM
 */
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js"></script>
<script src="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.full.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/custom-data-source/dom-text.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.9/jquery.autocomplete.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<style>
    .datepicker td, .datepicker th {
        width: 35px;
        height: 35px;
    }

    .datepicker table tr td.active {
        background-image: unset !important;
        background-color: #A2BCED !important;
    }
</style>
<div class="container">
    <div class="card">
        <div class="card-header pb-0">
            <ul class="nav nav-tabs border-bottom-0">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" role="tab" href="#transactions-tab">Transactions</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Reports</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-toggle="tab" role="tab" href="#monthly-transactions-tab">Monthly Transactions</a>
                        <a class="dropdown-item" data-toggle="tab" role="tab" href="#transactions-by-product-tab">Transactions By Product</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="tab-content" id="tab-content">
            <div class="tab-pane fade show active" id="transactions-tab" role="tabpanel" aria-labelledby="transactions-tab">
                <div class="card-body">
                    <div class="card" id="reports-card">
                        <div class="card-header" id="reports-card-header">
                        </div>
                        <div class="card-body" id="reports-card-body">
                            <div style="text-align:center;">
                                <div class="loader" id="loader" style="display:inline-block;"><img src="..\..\Images\vprop_logo_navbar.gif" style='width:55%;'/><span class="text-align-center">Processing</span></div>
                            </div>
                            <div class="table-responsive hide" id="table-wrapper">
                                <table class="table table-xl table-bordered table-striped table-hover nowrap" id="reports-table">
                                    <thead class="th-vprop-blue-medium">
                                    <tr>
                                        <th>Serial</th>
                                        <th>Type</th>
                                        <th>Detail</th>
                                        <th>From</th>
                                        <th>From ID</th>
                                        <th>To</th>
                                        <th>To ID</th>
                                        <th>Date</th>
                                        <th>User ID</th>
                                        <th>User</th>
                                    </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                        <div class="card-footer" id="reports-card-footer">

                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="monthly-transactions-tab" role="tabpanel" aria-labelledby="monthly-transactions-tab">
                <div class="card-body">
                    <div class="card" id="monthly-transactions-card">
                        <div class="card-header" id="monthly-transactions-card-header">
                            <div class="form-inline float-left pb-0">
                            <label for="from-datepicker">From </label>&nbsp;<input id="from-datepicker" class="form-control">
                            <label for="to-datepicker">&nbsp;To&nbsp;</label><input id="to-datepicker" class="form-control">
                            </div>
                            <button type="button" class="btn btn-basic float-left ml-2" id="new-report-btn" disabled>Generate</button>
                        </div>
                        <div class="card-body" id="monthly-transactions-card-body">
                            <div class="table-responsive hide" id="monthly-transactions-table-wrapper">
                                <table class="table table-xl table-bordered table-striped table-hover nowrap" id="monthly-transactions-table">
                                    <thead class="th-vprop-blue-medium">
                                    <tr>
                                        <th>Transaction Type</th>
                                        <th>Transaction Count</th>
                                    </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                        <div class="card-footer" id="monthly-transactions-card-footer">

                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="transactions-by-product-tab" role="tabpanel" aria-labelledby="transactions-by-product-tab">
                <div class="card-body">
                    <div class="card" id="transactions-by-product-card">
                        <div class="card-header" id="transactions-by-product-card-header">
                        </div>
                        <div class="card-body" id="transactions-by-product-card-body">
                            <div style="text-align:center;">
                                <div class="loader" id="loader" style="display:inline-block;"><img src="..\..\Images\vprop_logo_navbar.gif" style='width:55%;'/>
                                    <span class="text-align-center">Processing</span>
                                </div>
                            </div>
                            <div class="table-responsive hide" id="table-wrapper">
                                <table class="table table-xl table-bordered table-striped table-hover nowrap" id="transactions-by-product-table">
                                    <thead class="th-vprop-blue-medium">
                                    <tr>

                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer" id="transactions-by-product-card-footer">

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
        <script>
            $(function () {
                let date = new Date(), y = date.getFullYear(), m = date.getMonth();
                let firstDay = new Date(y, m, 1).toISOString().slice(0, 10).replace('T', ' ');
                let today = new Date().toISOString().slice(0, 10).replace('T', ' ');
                let dateFormData = {};
                let $startDate = $('#from-datepicker');
                let $endDate = $('#to-datepicker');
                dateFormData['startDate'] = firstDay;

                $startDate.datepicker({
                    format: "yyyy-mm-dd",
                    disableEntry: true,
                    startView: "months",
                    minViewMode: "months",
                    autoClose: true
                }).val(firstDay).on('change', function() {
                    $('#new-report-btn').prop('disabled', false);
                });

                $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
                    $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
                } );

                $endDate.datepicker({
                    format: "yyyy-mm-dd",
                    disableEntry: true,
                    startView: "months",
                    minViewMode: "months",
                    autoClose: true
                }).on('changeDate',function(e)
                {
                    $("#to-datepicker").datepicker('update', new Date(e.date.getFullYear(), e.date.getMonth() + 1, 0));
                }).val(today).on('change', function() {
                    $('#new-report-btn').prop('disabled', false);

                });

                $('#new-report-btn').on('click', function() {
                    console.log(dateFormData);
                   $monthlyTransTable.ajax.reload(null, 1);
                });

                let $reportsTable = $('#reports-table').DataTable({
                    dom: 'Bfrtip',
                    ajax: {
                        url: '../../Includes/Loadout/transactions_get_all.php',
                        dataSrc: ""
                    },
                    scrollY: '500px',
                    pageLength: '50',
                    columns: [
                        {data: 'product_serial'},
                        {data: 'product_type'},
                        {
                            data: 'is_full', render: function (data) {
                                return (data === '1') ? 'Full' : 'Empty';
                            }
                        },
                        {data: 'type_from'},
                        {data: 'transport_from'},
                        {data: 'type_to'},
                        {data: 'transport_to'},
                        {data: 'date'},
                        {data: 'user_id', visible: false},
                        {data: 'username'}
                    ],
                    buttons: [{extend: 'excel', text: 'Export', className: 'reports-export', title: 'Reports Export ' + date}],
                    initComplete: function () {
                        $('#loader').remove();
                        $('#table-wrapper').show();
                        $("#reports-table_length").remove();
                        $("#reports-table_filter").detach().appendTo('#reports-card-header').addClass('form-inline float-left');
                        $("#reports-table_paginate").detach().appendTo('#reports-card-footer').addClass('float-right');
                        $("#reports-table_info").detach().appendTo('#reports-card-footer').addClass('float-left');
                        $(".reports-export").detach().appendTo('#reports-card-header').removeClass().addClass('btn btn-basic form-inline float-right');
                        $('.dataTables_scrollBody').css("height", "unset")
                            .css("max-height", "500px");
                        $('#reports-table').DataTable().columns.adjust();
                    }
                });
                let $monthlyTransTable = $('#monthly-transactions-table').DataTable({
                    dom: 'Brtip',
                    ajax: {
                        url: '../../Includes/Loadout/movements_summary_get.php',
                        type: 'POST',
                        data: function(d) {
                            dateFormData['startDate'] = $('#from-datepicker').val();
                            dateFormData['endDate'] = $('#to-datepicker').val();
                            return dateFormData;
                        },
                        dataSrc: ''
                    },
                    scrollY: '500px',
                    scrollCollapse: true,
                    autoWidth: false,
                    pageLength: '50',
                    columns: [
                        {data: 'movement', render:function(data){
                                    let frags = data.split('_');
                                    for (i=0; i<frags.length; i++) {
                                        frags[i] = frags[i].charAt(0).toUpperCase() + frags[i].slice(1);
                                    }
                                    return frags.join(' ');
                            }},
                        {data: 'count'}
                    ],
                    buttons: [{extend: 'excel', text: 'Export', className: 'monthly-transactions-export', title: 'Transactions Export From ' + $startDate.val() + ' to '+$endDate.val()}],
                    initComplete: function () {
                        $('#monthly-transactions-loader').remove();
                        $('#monthly-transactions-table-wrapper').show();
                        $("#monthly-transactions-table_length").remove();
                        $("#monthly-transactions-table_filter").detach().appendTo('#monthly-transactions-card-header').addClass('form-inline float-left');
                        $("#monthly-transactions-table_paginate").detach().appendTo('#monthly-transactions-card-footer').addClass('float-right');
                        $("#monthly-transactions-table_info").detach().appendTo('#monthly-transactions-card-footer').addClass('float-left');
                        $(".monthly-transactions-export").detach().appendTo('#monthly-transactions-card-header').removeClass().addClass('btn btn-vprop-green form-inline float-right');
                        $('.dataTables_scrollBody').css("height", "unset")
                            .css("max-height", "500px");
                        $('#monthly-transactions-table').DataTable().columns.adjust();
                    }
                });
            });

        </script>