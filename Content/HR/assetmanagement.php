<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 9/20/2018
 * Time: 1:28 PM
 */

include('../../Includes/Security/database.php');

$database = new Database();

$departments_read = $database->get("sp_adm_DepartmentsGetAllv2");


?>

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
<style>
    .scroll {
        max-height: 350px;
        overflow-y: auto;
    }

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

    .modal-content-load {
        width: 25% !important;
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        display: block;
    }

    .datepicker td, .datepicker th {
        width: 35px;
        height: 35px;
    }

    .datepicker table tr td.active {
        background-image: unset !important;
        background-color: #A2BCED !important;
    }

    .border-vprop-blue-medium {
        border-color: #A2BCED;
    }

</style>
<!--</editor-fold>-->
<input autocomplete="off" type="hidden" id="employee-data">
<div class="container-fluid">
    <div class="card" id="main-content-card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" role="tablist" id="card-tab">
                <li class="nav-item">
                    <a class="nav-link active" role="tab" data-toggle="tab" id="employees-tab" href="#employees">Employees</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" role="tab" data-toggle="tab" id="on-board-tab" href="#on-board">On Board</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="card-tab-content">
                <div class="tab-pane fade show active" id="employees" role="tabpanel">
                    <div class="card">
                        <div class="card-header" id="table-card-header">

                        </div>
                        <div class="card-body">
                            <table id="employee-table" class="table table-md bg-light nowrap">
                                <thead class="th-vprop-blue-medium">
                                <tr>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Paycom</th>
                                    <th>Title</th>
                                    <th>Department</th>
                                    <th>Manager</th>
                                    <th>Site</th>
                                    <th>Start Date</th>
                                    <th>Approval</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <!--<th>Request</th>-->
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card-footer pb-0" id="table-card-footer">
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show " id="on-board" role="tabpanel">
                    <form id="onboard-form">
                        <div class="card-group">
                            <div class="card" id="on-board-employee-info-card">
                                <div class="card-header th-vprop-blue-medium">Information</div>
                                <div class="card-body">
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <input autocomplete="off" class="form-control border-right-0" id="on-board-first-name-input" name="name" placeholder="First Name">
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-user text-secondary"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <input autocomplete="off" class="form-control border-right-0 " id="on-board-last-name-input" name="name" placeholder="Last Name">
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-user text-secondary"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <input autocomplete="off" class="form-control border-right-0 " id="on-board-paycom-input" placeholder="Paycom ID">
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-id-card text-secondary"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-muted bg-white border-right-0"><label class="mb-0" for="on-board-site-select">Site</label></span>
                                            </div>
                                            <select class="form-control border-right-0 border-left-0" id="on-board-site-select">
                                                <option></option>
                                            </select>
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-map-marker-alt text-secondary"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-muted bg-white border-right-0"><label class="mb-0" for="on-board-department-select">Department</label></span>
                                            </div>
                                            <select class="form-control border-left-0 border-right-0" id="on-board-department-select">
                                                <option></option>
                                            </select>
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-building text-secondary"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-muted bg-white border-right-0"><label class="mb-0" for="on-board-job-title-select">Job Title</label></span>
                                            </div>
                                            <select class="form-control border-left-0 border-right-0" id="on-board-job-title-select">
                                                <option></option>
                                            </select>
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-briefcase text-secondary"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-muted bg-white border-right-0"><label class="mb-0" for="on-board-manager-select">Manager</label></span>
                                            </div>
                                            <select class="form-control border-left-0 border-right-0" id="on-board-manager-select">
                                                <option></option>
                                            </select>
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-user-tie text-secondary"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <input autocomplete="off" class="form-control bg-white border-right-0" id="on-board-start-date-input" placeholder="Start Date" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="far fa-calendar text-secondary"></i></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card" id="on-board-employee-accounts-card">
                                <div class="card-header th-vprop-blue-medium">
                                    Accounts
                                </div>
                                <div class="card-body">
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-muted bg-white border-right-0" id="silicore-model-prepend"><label class="mb-0" for="on-board-silicore-model-select">Silicore Model</label></span>
                                            </div>
                                            <select class="form-control border-right-0 border-left-0" id="on-board-silicore-model-select"></select>
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-desktop text-secondary"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-muted bg-white border-right-0" id="email-model-prepend"><label class="mb-0" for="on-board-email-model-select">Email Model</label></span>
                                            </div>
                                            <select class="form-control border-right-0 border-left-0" id="on-board-email-model-select"></select>
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-envelope text-secondary"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" id="on-board-employee-requests-card">
                                <div class="card-header th-vprop-blue-medium">
                                    Requests
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col">
                                            <button type="button" class="btn bg-transparent" id="on-board-phone-check"><i class="far fa-square text-secondary"></i></button>
                                            <label for="on-board-phone-check">Cell Phone</label>
                                        </div>
                                        <div class="form-group col">
                                            <button type="button" class="btn bg-transparent" id="on-board-uniform-check"><i class="far fa-square text-secondary"></i></button>
                                            <label for="on-board-uniform-check">Uniform(s)</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <button type="button" class="btn bg-transparent" id="on-board-laptop-check"><i class="far fa-square text-secondary"></i></button>
                                            <label for="on-board-laptop-check">Laptop</label>
                                        </div>
                                        <div class="form-group col">
                                            <button type="button" class="btn bg-transparent" id="on-board-business-cards-check"><i class="far fa-square text-secondary"></i></button>
                                            <label for="on-board-business-cards-check">Business Cards</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <button type="button" class="btn bg-transparent" id="on-board-desktop-check"><i class="far fa-square text-secondary"></i></button>
                                            <label for="on-board-desktop-check">Desktop</label>
                                        </div>
                                        <div class="form-group col">
                                            <button type="button" class="btn bg-transparent" id="on-board-fuel-card-check"><i class="far fa-square text-secondary"></i></button>
                                            <label for="on-board-fuel-card-check">Fuel Card</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <button type="button" class="btn bg-transparent" id="on-board-tablet-check"><i class="far fa-square text-secondary"></i></button>
                                            <label for="on-board-tablet-check">Tablet</label>
                                        </div>
                                        <div class="form-group col">
                                            <button type="button" class="btn bg-transparent" id="on-board-credit-card-check"><i class="far fa-square text-secondary"></i></button>
                                            <label for="on-board-credit-card-check">Credit Card</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <button type="button" class="btn bg-transparent" id="on-board-radio-check"><i class="far fa-square text-secondary"></i></button>
                                            <label for="on-board-radio-check">Radio</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group col-xl-12">
                                        <label for="comment">Comment:</label>
                                        <textarea class="form-control" rows="5" id="comment"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                    if ($userPermissionsArray['vista']['granbury']['hr'] >= 3) {
                        echo '<div class="card float-right"><div class="card-header bg-warning text-white">For HR Manager use only</div><div class="card-body"><button type="button" class="btn bg-transparent mr-2 hide" id="on-board-pre-approve" value="0" disabled><i class="far fa-square text-secondary"></i></button><label for="on-board-pre-approve mb-0" id="approval-feedback">You must enter a paycom ID to approve.</label></div></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="loader" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="width:65%!important;">
            <div class="modal-body text-center">
                <div class="form-group col-xl-12" id="loading-img">
                    <img src="../../Images/vprop_logo_navbar.gif" width="35">
                </div>
                <div class="form-group col-xl-12">
                    <p id="loading-message" class="text-muted">Please wait while we process your request.</p>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="employee-edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employee-modal-title">Edit Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-xl-6">
                        <label for="first-name-input">First Name</label>
                        <input autocomplete="off" id="first-name-input" class="form-control">
                    </div>
                    <div class="form-group col-xl-6">
                        <label for="last-name-input">Last Name</label>
                        <input autocomplete="off" id="last-name-input" class="form-control">
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="paycom-input">Paycom ID</label>
                        <input autocomplete="off" id="paycom-input" class="form-control">
                    </div>
                    <div class="form-group col">
                        <label for="job-title-select">Job Title</label>
                        <div class="form-row ml-0">
                            <div class="input-group mb-3">
                            <select id="job-title-select" class="form-control w-75">
                                <option></option>
                            </select>
                                <div class="input-group-append">
                                    <button class="btn btn-basic" data-toggle="modal" data-target="#edit-job-title-modal">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="department-select">Department</label>
                        <select id="department-select" class="form-control">
                        </select>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="manager-select">Manager</label>
                        <select id="manager-select" class="form-control">
                        </select>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="site-select">Site</label>
                        <select id="site-select" class="form-control">
                        </select>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="status-select">Status</label>
                        <select id="status-select" class="form-control">
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium update-employee-btn" id="edit-employee-submit-btn">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="employee-request" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requests-modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-xl-12">
                        <button class="btn btn-basic cell-btn" id="cell-button"><span><i class="fas fa-mobile text-secondary"></i></span> Phone</button>
                        <button class="btn btn-basic radio-btn" id="radio-button"><span><i class="fas fa-microphone-alt text-secondary"></i></span> Radio</button>
                        <button class="btn btn-basic desktop-btn" id="desktop-button"><span><i class="fas fa-desktop text-secondary"></i></span> Desktop</button>
                        <button class="btn btn-basic laptop-btn" id="laptop-button"><span><i class="fas fa-laptop text-secondary"></i></span> Laptop</button>

                    </div>
                </div>
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium">Submit Request</button>
            </div>-->
        </div>
    </div>
</div>
<div class="modal  bg-transparent" id="loader-simple">
    <div class="modal-content-load shadow border-0 text-center">
        <div class="form-group col-xl-12" id="loading-img">
            <img src="../../Images/vprop_logo_navbar.gif" width="35">
        </div>
        <div class="form-group col-xl-12">
            <p id="loading-message" class="text-muted">Please wait while we process your request.</p>
        </div>
    </div>

</div>
<div class="modal" id="edit-job-title-modal" tabindex="-1" role="dialog">
    <div  class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Job Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-xl-12">
                        <select id="edit-job-title-select" class="form-control" title="Department">
                            <option value="0">Select department</option>
                        </select>
                    </div>
                    <div class="form-group col-xl-12">
                        <input placeholder="Job title/position" id="edit-job-title-input" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-vprop-green" id="edit-job-title-submit">Submit</button>
                <button type="button" class="btn btn-basic" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('body').tooltip({selector: '[data-toggle="tooltip"]'});
        let date = new Date().toDateString();
        //<editor-fold desc="Paycom input control">
        $('#paycom-input').on('change', function () {
            let input = $(this).val();
            let limit = 33;
            if (input.length > limit) {

                input.substring(0, limit);
            }
        });
        //</editor-fold>
        $('#loader').hide();
        $('#edit-employee-submit-btn').hide();
        $('.form-row input,select').on('input', function () {
            $('#edit-employee-submit-btn').show(300);
        });
        $('#employee-edit').on('hidden.bs.modal', function () {
            $('#edit-employee-submit-btn').hide();
            $('#employee-table').DataTable().columns.adjust();
            $('#employee-table').DataTable().ajax.reload();
        });

        //<editor-fold desc="employee datatable">
        let employeeTable = $('#employee-table').DataTable({
            dom: "<\'row\'<\'col-xl-12\'f>>" + "<\'row\'<\'col-xl-12\'tr>>" + "<\'row\'<'col-xl-5 mt-1'B><\'col-xl-7\'p>>",
            ajax: {
                url: '../../Includes/HR/employeesget.php',
                dataSrc: ""
            },
            scrollY: '600px',
            pageLength: '100',
            buttons: [{extend: 'excel', text: 'Export', title: 'Employees Export '+date}],
            columns: [
                {data: "last_name"},
                {data: "first_name"},
                {data: "paycom_id"},
                {data: "job_title_name"},
                {data: "department_name"},
                {data: "manager_name"},
                {data: "site_name"},
                {data: "start_date"},
                {
                    data: "is_approved", render: function (data, row, meta) {
                        if (data === '1') {
                            return 'Approved';
                        }
                        else if(meta.paycom_id !== "") {
                            return '<?php if ($userPermissionsArray['vista']['granbury']['hr'] > 2){
                                echo '<a class="link pending-approval" href="#">Pending</a>';
                            }else{
                                echo '<a class="link">Pending</a>';
                            }?>';
                        } else {
                            return  '<?php echo '<a class="link" data-toggle="tooltip" data-placement="top" title="A Paycom ID must be entered before you can approve" disabled>Pending</a>;' ?>';
                        }
                    }
                },
                {data: "is_active"},
                {
                    render: function (row) {
                        return '<div class="text-center"><button class="btn bg-transparent edit-btn" style="background-color:transparent;border-color:transparent;" data-toggle="modal" data-target="#employee-edit"><span><i class="fas fa-edit text-success"></i></span></button></div>';
                    }
                }/*,
                {
                    render: function (data, type, row) {
                        if (row['is_approved'] === "1") {
                            return '<div class="text-center"><button class="btn bg-transparent request-btn" style="background-color:transparent;border-color:transparent;" data-toggle="modal" data-target="#employee-request"><span><i class="fas fa-concierge-bell text-primary"></i></i></span></button></div>';
                        } else {
                            return '<div class="text-center"><button class="btn bg-transparent" style="background-color:transparent;border-color:transparent;" disabled><span><i class="fas fa-concierge-bell text-secondary"></i></i></span></button></div>';
                        }
                    }
                }*/
            ],
            columnDefs: [
                {
                    orderable: false, targets: [10/*, 11*/]
                },
                {
                    visible: false, targets: [9]
                }
            ],
            initComplete: function () {
                $("#employee-table_filter").detach().appendTo('#table-card-header').addClass('form-inline float-right');
                $("#employee-table_paginate").detach().appendTo('#table-card-footer').addClass('float-right');
                $('#employee-table').DataTable().columns.adjust();
            }
        });
        $('#employee-table tbody').on('click', 'tr .pending-approval', function () {
            let e = employeeTable.row($(this).closest('tr')).data();
            let formData = {};
            formData['id'] = e.id;
            formData['first_name'] = e.first_name;
            formData['last_name'] = e.last_name;
            $.ajax({
                url: '../../Includes/HR/assetrequestsbynameget.php',
                type: 'post',
                data: JSON.stringify(formData),
                beforeSend: function () {
                    $('#loader-simple').show();
                },
                success: function (response, data) {
                    let content = 'Do you approve <strong>' + upperCaseFirstLetter(lowerCaseAllWordsExceptFirstLetters(e.first_name)) + ' ' + upperCaseFirstLetter(lowerCaseAllWordsExceptFirstLetters(e.last_name)) + '?</strong><br/>';
                    let obj = JSON.parse(response);
                    if (obj.assets !== 0) {
                        let assets = JSON.parse(obj.assets);
                        let accounts = JSON.parse(obj.accounts);
                        content += '<br/>This will also send requests for the following assets:<br/><ul class="list-group">';
                        $.each(assets, function (index, value) {
                            content += '<li class="list-group-item border-0">' + assets[index].type + '</li>';
                        });
                        content += '</ul>';
                        //content += '<br/>Request emails will be sent to <strong>' + e.manager_name + '</strong><br/><br/>';
                        $.confirm({
                                icon: 'fa fa-warning',
                                title: 'Approval',
                                columnClass: 'col-md-5',
                                content: content,
                                type: 'orange',
                                buttons: {
                                    confirm: {
                                        text: 'Approve',
                                        btnClass: 'btn-vprop-blue-medium',
                                        action: function () {
                                            approveEmployee(formData, employeeTable);
                                            $.each(assets, function (index, value) {
                                                let requestType = assets[index].type;
                                                let requestFormData = {};
                                                requestFormData['id'] = e.id;
                                                requestFormData['first_name'] = e.first_name;
                                                requestFormData['last_name'] = e.last_name;
                                                requestFormData['manager_name'] = e.manager_name;
                                                requestFormData['request'] = requestType;
                                                sendRequestEmails(requestFormData);
                                            });
                                        }


                                    },
                                    cancel: function () {
                                    }
                                }
                            }
                        );
                    }
                    else {
                        $.confirm({
                            icon: 'fa fa-warning',
                            title: 'Approval',
                            columnClass: 'col-md-4',
                            content: content,
                            type: 'orange',
                            buttons: {
                                confirm: {
                                    text: 'Approve',
                                    btnClass: 'btn-vprop-blue-medium',
                                    action: function () {
                                        approveEmployee(formData, employeeTable);
                                    }
                                },
                                cancel: function () {
                                }
                            }
                        });
                    }
                },
                complete:
                    function () {
                        $('#loader-simple').hide();
                    },
                error: function () {
                    $.alert('error');
                }
            })
            ;
        });
        employeeTable.buttons().containers().appendTo($('#table-card-footer'));
        $('#employee-table').DataTable().columns.adjust();
        //</editor-fold>

        $('#on-board-site-select').on('change', function(e) {
            let selected = e.target.options[e.target.selectedIndex].text;
                $('#on-board-department-select option').each(function () {
                    if (selected === "Granbury"){
                        if ($(this).text() === "QC" || $(this).text() === "Wet Plt" || $(this).text() === "Pit Mining" || $(this).text() === "Maintenance") {
                            $(this).show();
                        }
                    }
                    if (selected !== "Tolar") {
                        if ($(this).text().includes('Tolar')) {
                            $(this).hide();
                        }
                    } else {
                        if ($(this).text().includes('Tolar')) {
                            $(this).show();
                        }
                        if ($(this).text() === "QC" || $(this).text() === "Wet Plt" || $(this).text() === "Pit Mining" || $(this).text() === "Maintenance") {
                            $(this).hide();
                        }
                    }
                    if (selected !== 'West Texas') {
                        if ($(this).text().includes('WTX')) {
                            $(this).hide();
                        }
                    } else {
                            if ($(this).text().includes('WTX')) {
                                $(this).show();
                            }
                            if ($(this).text() === "QC" || $(this).text() === "Wet Plt" || $(this).text() === "Pit Mining" || $(this).text() === "Maintenance") {
                                $(this).hide();
                            }
                        }
                });

               });


        //<editor-fold desc="datatable buttons customization">
        $('.dt-buttons').addClass('float-left');
        $('.buttons-excel').removeClass('btn-secondary').addClass('btn-vprop-green');
        //</editor-fold>

        //<editor-fold desc="employee edit">
        employeeTable.on('click', 'tbody .edit-btn', function (event) {
            let e = employeeTable.row($(this).closest('tr')).data();
            $('#employee-data').val(JSON.stringify(e));
            let departmentsObj =  <?php echo $departments_read; ?>;
            let formData = {};
            $('#manager-select').find('option').remove().end();
            $('#site-select').find('option').remove().end();
            $('#department-select').find('option').remove().end();
            $('#job-title-select').find('option').remove().end();
            formData['department_id'] = e.department_id;
            $.ajax({
                url: '../../Includes/HR/managersget.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    $.each(JSON.parse(response), function (key, value) {
                        $('#manager-select').append('<option value="' + value.id + '">' + value.mgrname + '</option>');
                    });
                    $('#manager-select').val(e.manager_user_id);
                }
            });
            $.ajax({
                url: '../../Includes/HR/sitesget.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    $.each(JSON.parse(response), function (key, value) {
                        $('#site-select').append('<option value="' + value.id + '">' + value.description + '</option>');
                    });
                    $('#site-select').val(e.site_id);
                }
            });
            $.each(departmentsObj, function (key, value) {
                $('#department-select').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
            $.ajax({
                url: '../../Includes/HR/jobtitlesget.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    $.each(JSON.parse(response), function (key, value) {
                        $('#job-title-select').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $('#job-title-select').val(e.job_title);
                }
            });
            $('#first-name-input').val(e.first_name);
            $('#last-name-input').val(e.last_name);
            $('#paycom-input').val(e.paycom_id);
            $('#department-select').val(e.department_id);
            $('#site-select').val(e.site_name);
            $('#status-select').val(e.is_active);
            $('#job-title-select').val(e.job_title);
        });

        $('#edit-job-title-modal').on('shown.bs.modal', function() {
           let departmentsObj =  <?php echo $departments_read; ?>;
            $.each(departmentsObj, function (key, value) {
                $('#edit-job-title-select').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
        });
        $('#edit-job-title-modal').on('hidden.bs.modal', function() {
            $('#edit-job-title-select').children().remove();
        });

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
        function inputError(input) {
            $(input).focus().removeClass().addClass("form-control border border-danger");
        }

        function inputValid(input) {
            $(input).removeClass().addClass("form-control border border-success");
        }
        $('#edit-job-title-submit').on('click', function() {
           let dept = $('#edit-job-title-select');
           let position = $('#edit-job-title-input');
           let formData = {};
           formData['department_id'] = dept.val();
           formData['position'] = position.val();
           if(!dept) {
               inputError(dept);
               return;
           }
           if(!position) {
               inputError(position);
           }
           $.ajax({
               url: '../../Includes/HR/jobtitlefastinsert.php',
               type: 'POST',
               data: JSON.stringify(formData),
               success: function(response) {
                   let result = parseInt(response);
                   if (result === 1) {
                       successAlert('Successfully added position!');
                       position.val("");

                       $.ajax({
                           url: '../../Includes/HR/jobtitlesget.php',
                           type: 'POST',
                           data: JSON.stringify(formData),
                           success: function (response) {
                               $.each(JSON.parse(response), function (key, value) {
                                   $('#job-title-select').append('<option value="' + value.id + '">' + value.name + '</option>');
                               });
                               $('#job-title-select').val(e.job_title);
                           }
                       });
                   } else {
                       errorAlert('Error adding position!');
                       position.val("");
                   }
               }
           });
        });

        //</editor-fold>

        //<editor-fold desc="employee requests">
        /*employeeTable.on('click', 'tbody .request-btn', function () {
                    let e = employeeTable.row($(this).closest('tr')).data();
                    $('#employee-data').val(JSON.stringify(e));
                    $('#requests-modal-title').text(e.first_name + ' ' + e.last_name);
                });*/
        /*$('#laptop-button').on('click', function () {
            let employeeData = $('#employee-data').val();
            let e = JSON.parse(employeeData);
            let formData = {};
            formData['first_name'] = e.first_name;
            formData['last_name'] = e.last_name;
            $.ajax({
                url: '../../Includes/IT/requestsbynameget.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    let data = JSON.parse(response)
                }
            });
            e['device'] = 'Laptop';
            if (e.laptop_requested === '1') {
                $.confirm({
                    icon: 'fa fa-warning',
                    title: 'Warning',
                    type: 'orange',
                    columnClass: 'col-md-6 col-md-offset-3',
                    content: 'This employee has already requested this asset.</br></br><strong>Send request to ' + e.manager_name + ' anyway?</strong>',
                    buttons: {
                        confirm: function () {
                            $.alert('Request sent to ' + e.manager_name);
                        },
                        cancel: function () {
                        }
                    }
                });
            } else {
                $.confirm({
                    icon: 'fa fa-check',
                    title: 'Confirm',
                    type: 'blue',
                    columnClass: 'col-md-6 col-md-offset-3',
                    content: '<strong>Send laptop request to ' + e.manager_name + '?</strong>',
                    buttons: {
                        confirm: function () {
                            $.ajax({
                                url: '../../Includes/HR/requestemail.php',
                                type: 'POST',
                                data: JSON.stringify(e),
                                success: function (response) {
                                    let data = JSON.parse(response);
                                    if (data.response === 1)
                                        $.alert({
                                            type: 'green',
                                            icon: 'fa fa-check',
                                            title: 'Success',
                                            columnClass: 'col-md-6 col-md-offset-3',
                                            content: 'Email successfully sent to ' + data.email
                                        });
                                }
                            });
                        },
                        cancel: function () {
                        }
                    }
                });
            }
        });
        $('#desktop-button').on('click', function () {
            let employeeData = $('#employee-data').val();
            let e = JSON.parse(employeeData);
            e['device'] = 'Desktop';
            if (e.desktop_requested === '1') {
                $.confirm({
                    icon: 'fa fa-warning',
                    title: 'Warning',
                    type: 'orange',
                    columnClass: 'col-md-6 col-md-offset-3',
                    content: 'This employee has already requested this asset.</br></br><strong>Send request to ' + e.manager_name + ' anyway?</strong>',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-vprop-blue-medium',
                            action: function () {
                                $.alert('Request sent to ' + e.manager_name);
                            }
                        },
                        cancel: function () {

                        }
                    }
                });
            } else {
                $.confirm({
                    icon: 'fa fa-check',
                    title: 'Confirm',
                    type: 'blue',
                    columnClass: 'col-md-6 col-md-offset-3',
                    content: '<strong>Send desktop request to ' + e.manager_name + '?</strong>',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-vprop-blue-medium',
                            action: function () {
                                $.ajax({
                                    url: '../../Includes/HR/requestemail.php',
                                    type: 'POST',
                                    data: JSON.stringify(e),
                                    success: function (response) {
                                        let data = JSON.parse(response);
                                        if (data.response === 1)
                                            $.alert({
                                                type: 'green',
                                                icon: 'fa fa-check',
                                                title: 'Success',
                                                columnClass: 'col-md-6 col-md-offset-3',
                                                content: 'Email successfully sent to ' + data.email
                                            });
                                    }
                                });

                            }
                        },
                        cancel: function () {

                        }
                    }
                });
            }
        });
        $('#cell-button').on('click', function () {
            let employeeData = $('#employee-data').val();
            let e = JSON.parse(employeeData);
            e['device'] = 'Cell Phone';
            if (e.cell_phone_requested === '1') {
                $.confirm({
                    icon: 'fa fa-warning',
                    title: 'Warning',
                    type: 'orange',
                    columnClass: 'col-md-6 col-md-offset-3',
                    content: 'This employee has already requested this asset.</br></br><strong>Send request to ' + e.manager_name + ' anyway?</strong>',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-vprop-blue-medium',
                            action: function () {
                                $.alert('Request sent to ' + e.manager_name);
                            }
                        },
                        cancel: function () {

                        }
                    }
                });
            } else {
                $.confirm({
                    icon: 'fa fa-check',
                    title: 'Confirm',
                    type: 'blue',
                    columnClass: 'col-md-6 col-md-offset-3',
                    content: '<strong>Send cell phone request to ' + e.manager_name + '?</strong>',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-vprop-blue-medium',
                            action: function () {
                                $.ajax({
                                    url: '../../Includes/HR/requestemail.php',
                                    type: 'POST',
                                    data: JSON.stringify(e),
                                    success: function (response) {
                                        let data = JSON.parse(response);
                                        if (data.response === 1)
                                            $.alert({
                                                type: 'green',
                                                icon: 'fa fa-check',
                                                title: 'Success',
                                                columnClass: 'col-md-6 col-md-offset-3',
                                                content: 'Email successfully sent to ' + data.email
                                            });
                                    }
                                });
                            }
                        },
                        cancel: function () {

                        }
                    }
                });
            }
        });
        $('#radio-button').on('click', function () {
            let employeeData = $('#employee-data').val();
            let e = JSON.parse(employeeData);
            e['device'] = 'Two Way Radio';
            if (e.two_way_radio_requested === '1') {
                $.confirm({
                    icon: 'fa fa-warning',
                    title: 'Warning',
                    type: 'orange',
                    columnClass: 'col-md-6 col-md-offset-3',
                    content: 'This employee has already requested this asset.</br></br><strong>Send request to ' + e.manager_name + ' anyway?</strong>',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-vprop-blue-medium',
                            action: function () {
                                $.alert('Request sent to ' + e.manager_name);
                            }
                        },
                        cancel: function () {

                        }
                    }
                });
            } else {
                $.confirm({
                    icon: 'fa fa-check',
                    title: 'Confirm',
                    type: 'blue',
                    columnClass: 'col-md-6 col-md-offset-3',
                    content: '<strong>Send radio request to ' + e.manager_name + '?</strong>',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-vprop-blue-medium',
                            action: function () {
                                $.ajax({
                                    url: '../../Includes/HR/requestemail.php',
                                    type: 'POST',
                                    data: JSON.stringify(e),
                                    success: function (response) {
                                        let data = JSON.parse(response);
                                        if (data.response === 1)
                                            $.alert({
                                                type: 'green',
                                                icon: 'fa fa-check',
                                                title: 'Success',
                                                columnClass: 'col-md-6 col-md-offset-3',
                                                content: 'Email successfully sent to ' + data.email
                                            });
                                    }
                                });
                            }
                        },
                        cancel: function () {

                        }
                    }
                });
            }
        });*/
        //</editor-fold>

        //<editor-fold desc="Save Changes on employee edit">
        $('#edit-employee-submit-btn').on('click', function () {
            let data = {};
            let employeeData = $('#employee-data').val();
            let e = JSON.parse(employeeData);
            data['id'] = e.id;
            data['first_name'] = $('#first-name-input').val();
            data['last_name'] = $('#last-name-input').val();
            data['paycom_id'] = $('#paycom-input').val();
            data['job_title_id'] = $('#job-title-select').val();
            data['department_id'] = $('#department-select').val();
            data['manager_id'] = $('#manager-select').val();
            data['site_id'] = $('#site-select').val();
            data['is_active'] = $('#status-select').val();
            data['user_id'] = <?php echo $_SESSION['user_id']; ?>;
            //$.alert(JSON.stringify(data));
            $.ajax({
                url: '../../Includes/HR/updateemployee.php',
                type: 'POST',
                data: JSON.stringify(data),
                success: function (data) {
                    let data_parse = JSON.parse(data);
                    let error_info = data_parse.response[2];
                    if (data_parse.response === 1) {
                        $.alert({
                            icon: 'fas fa-check',
                            title: 'Success',
                            content: 'Changes saved successfully!',
                            type: 'green'
                        });
                        employeeTable.ajax.reload();

                    } else {
                        $.alert({
                            icon: 'fas fa-exclamation-circle',
                            title: 'Error',
                            content: error_info,
                            type: 'red'
                        });
                    }
                }
            });
        });
        //</editor-fold>

        //<editor-fold desc="department-select autopopulation">
        $('#department-select').change(function () {
            $('#manager-select').find('option').remove().end();
            $('#job-title-select').find('option').remove().end();
            let formData = {};
            formData['department_id'] = $('#department-select').val();
            $.ajax({
                url: '../../Includes/HR/managersget.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    $.each(JSON.parse(response), function (key, value) {
                        $('#manager-select').append('<option value="' + value.id + '">' + value.mgrname + '</option>');
                    });
                }
            });
            $.ajax({
                url: '../../Includes/HR/jobtitlesget.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    $.each(JSON.parse(response), function (key, value) {
                        $('#job-title-select').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $('#job-title-select').val(e.job_title);
                }
            });
        });
        //</editor-fold>

        //<editor-fold desc="on-board-start-date-input datepicker initialize">
        $('#on-board-start-date-input').datepicker({
            format: "yyyy/mm/dd",
            disableEntry: true
        });
        //</editor-fold>

        // <editor-fold desc="checkboxes">
        $('#on-board-phone-check').on('click', function () {
            checkbox($(this));
        });
        $('#on-board-uniform-check').on('click', function () {
            checkbox($(this));
        });
        $('#on-board-business-cards-check').on('click', function () {
            checkbox($(this));
        });
        $('#on-board-fuel-card-check').on('click', function () {
            checkbox($(this));
        });
        $('#on-board-credit-card-check').on('click', function () {
            checkbox($(this));
        });
        $('#on-board-laptop-check').on('click', function () {
            checkbox($(this));
        });
        $('#on-board-desktop-check').on('click', function () {
            checkbox($(this));
        });
        $('#on-board-tablet-check').on('click', function () {
            checkbox($(this));
        });
        $('#on-board-radio-check').on('click', function () {
            checkbox($(this));
        });
        $('#on-board-pre-approve').on('click', function () {
            checkbox($(this));
        });
        //</editor-fold>

        //<editor-fold desc="Adjust sizing of headers for datatable anytime a tab is opened">
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $('#employee-table').DataTable().columns.adjust();
        });
        //</editor-fold>

        //<editor-fold desc="on-board-department-select autopopulation">
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            let target = $(e.target).attr('href');
            if (target === "#on-board") {
                let departmentsObj =  <?php echo $departments_read; ?>;
                let formData = {};
                let departmentSelect = $('#on-board-department-select');
                formData['department_id'] = departmentSelect.val();
                departmentSelect.find('option').remove().end().append('<option></option>');
                $.each(departmentsObj, function (key, value) {
                    $('#on-board-department-select').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                $.ajax({
                    url: '../../Includes/HR/sitesget.php',
                    type: 'POST',
                    data: JSON.stringify(formData),
                    success: function (response) {
                        $.each(JSON.parse(response), function (key, value) {
                            $('#on-board-site-select').append('<option value="' + value.id + '">' + value.description + '</option>');
                        });
                    }
                });
                if (departmentSelect.val().length > 0) {
                    $.ajax({
                        url: '../../Includes/HR/managersget.php',
                        type: 'POST',
                        data: JSON.stringify(formData),
                        success: function (response) {
                            $.each(JSON.parse(response), function (key, value) {
                                $('#on-board-manager-select').append('<option value="' + value.id + '">' + value.mgrname + '</option>');
                            });
                        }
                    });
                }
                $('#on-board-department-select').change(function () {
                    $('#on-board-manager-select').find('option').remove().end();
                    $('#on-board-job-title-select').find('option').remove().end();
                    $('#on-board-silicore-model-select').find('option').remove().end();
                    $('#on-board-email-model-select').find('option').remove().end();
                    let formData = {};
                    formData['department_id'] = $('#on-board-department-select').val();

                    $.ajax({
                        url: '../../Includes/HR/managersget.php',
                        type: 'POST',
                        data: JSON.stringify(formData),
                        success: function (response) {
                            $.each(JSON.parse(response), function (key, value) {
                                $('#on-board-manager-select').append('<option value="' + value.id + '">' + value.mgrname + '</option>');
                            });
                        }
                    });

                    $.ajax({
                        url: '../../Includes/HR/jobtitlesget.php',
                        type: 'POST',
                        data: JSON.stringify(formData),
                        success: function (response) {
                            $.each(JSON.parse(response), function (key, value) {
                                $('#on-board-job-title-select').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });

                    $.ajax({
                        url: '../../Includes/HR/employeesbydepartment.php',
                        type: 'POST',
                        data: JSON.stringify(formData),
                        success: function (response) {
                            $.each(JSON.parse(response), function (key, value) {
                                $('#on-board-silicore-model-select').append('<option value="' + value.id + '">' + value.name + '</option>');
                                $('#on-board-email-model-select').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                });
                let paycom_input = $('#on-board-paycom-input');
                paycom_input.on('input', function() {
                    if(paycom_input.val() !== null && paycom_input.val() !== '') {
                        $('#on-board-pre-approve').prop('disabled', false).show();
                        $('#approval-feedback').text('Approved');
                    } else {
                        $('#on-board-pre-approve').prop('disabled', true).hide();
                        $('#approval-feedback').text('You must enter a paycom ID to approve.');
                    }
                });

            }
        });
        //</editor-fold>

        //<editor-fold desc="show submit button for onboard">
        $('#on-board-tab').on('shown.bs.tab', function () {
            if ($('#main-content-card-footer').length) {
                $('#main-content-card-footer').remove()
            } else {
                let cardFooter = '<div class="card-footer" id="main-content-card-footer"><button type="button" class="btn btn-vprop-green float-right submit">Submit</button></div>';
                $('#main-content-card').append(cardFooter);
            }
        });

        $('#employees-tab').on('click', function () {
            if ($('#main-content-card-footer').length) {
                $('#main-content-card-footer').remove();
            }
        });
        //</editor-fold>

        //<editor-fold desc="On Board Submit Employee">
        $('#main-content-card').on('click', '.submit', function () {
            if ($('#on-board-first-name-input').val() === '') {
                $('#on-board-first-name-input').focus();
                $('.content-wrapper').slideDown().prepend('<div class="alert alert-danger alert-dismissible fade show" style="position:absolute; top:6%; right:40%; z-index:999;" role="alert">\n' +
                    '  <strong>Error!</strong> You must enter a first name.\n' +
                    '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '    <span aria-hidden="true">&times;</span>\n' +
                    '  </button>\n' +
                    '</div>')
            }
            else if ($('#on-board-last-name-input').val() === '') {
                $('#on-board-last-name-input').focus();
                $('.content-wrapper').slideDown().prepend('<div class="alert alert-danger alert-dismissible fade show" style="position:absolute; top:6%; right:40%; z-index:999;" role="alert">\n' +
                    '  <strong>Error!</strong> You must enter a last name.\n' +
                    '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '    <span aria-hidden="true">&times;</span>\n' +
                    '  </button>\n' +
                    '</div>')
            }
            /* else if($('#on-board-paycom-input').val() === '') {
                 $('#on-board-last-name-input').focus();
                 $('.content-wrapper').slideDown().prepend('<div class="alert alert-danger alert-dismissible fade show" style="position:absolute; top:6%; right:40%; z-index:999;" role="alert">\n' +
                     '  <strong>Error!</strong> You must enter a last name.\n' +
                     '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                     '    <span aria-hidden="true">&times;</span>\n' +
                     '  </button>\n' +
                     '</div>')
             }*/
            else if ($('#on-board-site-select').val() === '') {
                $('#on-board-site-select').focus();
                $('.content-wrapper').slideDown().prepend('<div class="alert alert-danger alert-dismissible fade show" style="position:absolute; top:6%; right:40%; z-index:999;" role="alert">\n' +
                    '  <strong>Error!</strong> You must select a site.\n' +
                    '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '    <span aria-hidden="true">&times;</span>\n' +
                    '  </button>\n' +
                    '</div>')
            }
            else if ($('#on-board-department-select').val() === '') {
                $('#on-board-department-select').focus();
                $('.content-wrapper').slideDown().prepend('<div class="alert alert-danger alert-dismissible fade show" style="position:absolute; top:6%; right:40%; z-index:999;" role="alert">\n' +
                    '  <strong>Error!</strong> You must select a department.\n' +
                    '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '    <span aria-hidden="true">&times;</span>\n' +
                    '  </button>\n' +
                    '</div>')
            }
            else if ($('#on-board-job-title-select').val() === '') {
                $('#on-board-job-title-select').focus();
                $('.content-wrapper').slideDown().prepend('<div class="alert alert-danger alert-dismissible fade show" style="position:absolute; top:6%; right:40%; z-index:999;" role="alert">\n' +
                    '  <strong>Error!</strong> You must select a job title.\n' +
                    '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '    <span aria-hidden="true">&times;</span>\n' +
                    '  </button>\n' +
                    '</div>')
            }
            else if ($('#on-board-start-date-input').val() === '') {
                $('#on-board-start_date-input').focus();
                $('.content-wrapper').slideDown().prepend('<div class="alert alert-danger alert-dismissible fade show" style="position:absolute; top:6%; right:40%; z-index:999;" role="alert">\n' +
                    '  <strong>Error!</strong> You must select a start date.\n' +
                    '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '    <span aria-hidden="true">&times;</span>\n' +
                    '  </button>\n' +
                    '</div>')
            }
            else if ($('#on-board-silicore-model-select').val() === '') {
                $('#on-board-silicore-model-select').focus();
                $('.content-wrapper').slideDown().prepend('<div class="alert alert-danger alert-dismissible fade show" style="position:absolute; top:6%; right:40%; z-index:999;" role="alert">\n' +
                    '  <strong>Error!</strong> You must select an employee to model the silicore account after.\n' +
                    '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '    <span aria-hidden="true">&times;</span>\n' +
                    '  </button>\n' +
                    '</div>')
            }
            else if ($('#on-board-email-model-select').val() === '') {
                $('#on-board-email-model-select').focus();
                $('.content-wrapper').slideDown().prepend('<div class="alert alert-danger alert-dismissible fade show" style="position:absolute; top:6%; right:40%; z-index:999;" role="alert">\n' +
                    '  <strong>Error!</strong> You must select an employee to model the email account after.\n' +
                    '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '    <span aria-hidden="true">&times;</span>\n' +
                    '  </button>\n' +
                    '</div>')
            }
            else {
                let saveFormData = {};
                let requestFormData = {};
                let requestArray = {};
                saveFormData['first_name'] = $('#on-board-first-name-input').val();
                saveFormData['last_name'] = $('#on-board-last-name-input').val();
                saveFormData['paycom_id'] = $('#on-board-paycom-input').val();
                saveFormData['site'] = $('#on-board-site-select').val();
                saveFormData['department_id'] = $('#on-board-department-select').val();
                saveFormData['job_title_id'] = $('#on-board-job-title-select').val();
                saveFormData['manager_name'] = $('#on-board-manager-select option:selected').text();
                saveFormData['manager_id'] = $('#on-board-manager-select').val();
                saveFormData['start_date'] = $('#on-board-start-date-input').val();
                saveFormData['silicore_account'] = $('#on-board-silicore-model-select option:selected').text();
                saveFormData['email_account'] = $('#on-board-email-model-select option:selected').text();
                saveFormData['comments'] = $('#comment').val();
                if ($('#on-board-pre-approve').length) {
                    saveFormData['is_approved'] = $('#on-board-pre-approve').val();
                } else {
                    saveFormData['is_approved'] = 0;
                }
                requestFormData['manager_name'] = $('#on-board-manager-select option:selected').text();
                requestFormData['first_name'] = $('#on-board-first-name-input').val();
                requestFormData['last_name'] = $('#on-board-last-name-input').val();
                if($('#on-board-phone-check').val() === '1'){requestArray['Cell Phone'] = $('#on-board-phone-check').val();}
                if($('#on-board-laptop-check').val() === '1'){requestArray['Laptop'] = $('#on-board-laptop-check').val();}
                if($('#on-board-desktop-check').val() === '1'){requestArray['Desktop'] = $('#on-board-desktop-check').val();}
                if($('#on-board-tablet-check').val() === '1'){requestArray['Tablet'] = $('#on-board-tablet-check').val();}
                if($('#on-board-radio-check').val() === '1'){requestArray['Radio'] = $('#on-board-radio-check').val();}
                if($('#on-board-uniform-check').val() === '1'){requestArray['Uniform'] = $('#on-board-uniform-check').val();}
                if($('#on-board-business-cards-check').val() === '1'){requestArray['Business Card'] = $('#on-board-business-cards-check').val();}
                if($('#on-board-fuel-card-check').val() === '1'){requestArray['Fuel Card'] = $('#on-board-fuel-card-check').val();}
                if($('#on-board-credit-card-check').val() === '1'){requestArray['Credit Card'] = $('#on-board-credit-card-check').val();}
                $.ajax({
                    url: '../../Includes/HR/saveemployee.php',
                    type: 'POST',
                    data: JSON.stringify(saveFormData),
                    beforeSend: function () {
                        $('#loader').modal();
                    },
                    success: function (data) {
                        let response = JSON.parse(data);
                        $('#loader .modal-content').addClass('border-success');
                        $('#loading-img').empty();
                        $('#loading-message').slideUp(function () {
                            $(this).empty();
                            $(this).append('Sent requests successfully. <i class="fas fa-check text-success"></i>');
                            $('#loading-message').slideDown();
                        });
                        window.setTimeout(function () {
                            $('#loader').modal('toggle');
                        }, 3000);
                        //$('#onboard-form :input, option:selected').val('');
                        $('#on-board-phone-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                        $('#on-board-laptop-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                        $('#on-board-desktop-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                        $('#on-board-tablet-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                        $('#on-board-radio-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                        $('#on-board-uniform-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                        $('#on-board-business-cards-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                        $('#on-board-fuel-card-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                        $('#on-board-credit-card-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');

                        $('#main-content-card').append('<input type="hidden" id="last-employee-id" value="' + response + '">');
                        requestFormData['id'] = $('#last-employee-id').val();
                    },
                    complete: function () {
                        let preApprove = $('#on-board-pre-approve').val();
                        if (preApprove === '1') {
                            let formData = {};
                            formData['id'] = $('#last-employee-id').val();
                            formData['first_name'] = $('#on-board-first-name-input').val();
                            formData['last_name'] = $('#on-board-last-name-input').val();
                            $.ajax({
                                url: '../../Includes/HR/approveemployee.php',
                                type: 'POST',
                                data: JSON.stringify(formData),
                                beforeSend: function () {
                                    $('#loader').modal();
                                },
                                success: function () {
                                    requestFormData['expedite'] = 1;
                                    $('#loader .modal-content').addClass('border-success');
                                    $('#loading-img').empty();
                                    $('#loading-message').slideUp(function () {
                                        $(this).empty();
                                        $(this).append('Sent requests successfully. <i class="fas fa-check text-success"></i>');
                                        $('#loading-message').slideDown();
                                    });
                                    window.setTimeout(function () {
                                        $('#loader').modal('toggle');
                                    }, 3000);
                                    $('#onboard-form :input, option:selected').val('');
                                    $('#on-board-phone-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                                    $('#on-board-laptop-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                                    $('#on-board-desktop-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                                    $('#on-board-tablet-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                                    $('#on-board-radio-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                                    $('#on-board-uniform-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                                    $('#on-board-business-cards-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                                    $('#on-board-fuel-card-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                                    $('#on-board-credit-card-check').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
                                    $.each(requestArray, function (key, value) {
                                        if (value === '1') {
                                            requestFormData['request'] = key;
                                            sendRequestEmails(requestFormData);
                                        }
                                    });
                                },
                                complete: function () {
                                    window.setTimeout(function () {
                                        location.reload();
                                    }, 5000);

                                },
                                error: function () {
                                    $('#loader .modal-content').addClass('border-danger');
                                    $('#loading-img').empty();
                                    $('#loading-message').slideUp(function () {
                                        $(this).empty();
                                        $(this).append('Unable to send request. <i class="fas fa-times text-danger"></i>');
                                        $('#loading-message').slideDown();
                                    });
                                    window.setTimeout(function () {
                                        $('#loader').modal('toggle');
                                    }, 3000);


                                }
                            });
                        } else {
                            $.each(requestArray, function (key, value) {
                                if (value === '1') {
                                    console.log(requestFormData);
                                    requestFormData['request'] = key;
                                    requestFormData['silicore'] = $('#on-board-silicore-model-select option:selected').text();
                                    requestFormData['email'] = $('#on-board-email-model-select option:selected').text();
                                    $.ajax({
                                        url: '../../Includes/HR/preapprovalrequests.php',
                                        type: 'POST',
                                        data: JSON.stringify(requestFormData),
                                        success: function (response) {
                                            let data = JSON.parse(response);
                                            if (data.response === 1)
                                                $.alert({
                                                    type: 'green',
                                                    icon: 'fa fa-check',
                                                    title: 'Success',
                                                    columnClass: 'col-md-6 col-md-offset-3',
                                                    content: 'Approval request sent to HR.'
                                                });
                                        }
                                    });
                                }
                            });
                        }
                        window.setTimeout(function () {
                            location.reload();
                        }, 5000);

                    },
                    error: function () {
                        $('#loader .modal-content').addClass('border-danger');
                        $('#loading-img').empty();
                        $('#loading-message').slideUp(function () {
                            $(this).empty();
                            $(this).append('Unable to send request. <i class="fas fa-times text-danger"></i>');
                            $('#loading-message').slideDown();
                        });
                        window.setTimeout(function () {
                            $('#loader').modal('toggle');
                        }, 3000);


                    }
                });
            }
        });
        //</editor-fold>

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

    function approveEmployee(formData, employeeTable) {
        $.ajax({
            url: '../../Includes/HR/approveemployee.php',
            type: 'POST',
            data: JSON.stringify(formData),
            beforeSend: function () {
                $('#loader-simple').show();
            },
            success: function () {
                employeeTable.ajax.reload();
            },
            error: function () {

            },
            complete: function () {
                $('#loader-simple').hide();
            }
        })
    }

    function upperCaseFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function lowerCaseAllWordsExceptFirstLetters(string) {
        return string.replace(/\w\S*/g, function (word) {
            return word.charAt(0) + word.slice(1).toLowerCase();
        });
    }

    function sendRequestEmails(requestFormData) {
        $.ajax({
            url: '../../Includes/HR/sendrequestemails.php',
            type: 'POST',
            data: JSON.stringify(requestFormData),
            success: function (response) {
                let data = JSON.parse(response);
                if (data.response === 1)
                    $.alert({
                        type: 'green',
                        icon: 'fa fa-check',
                        title: 'Success',
                        columnClass: 'col-md-6 col-md-offset-3',
                        content: 'Email successfully sent to ' + data.email
                    });
            }
        });
    }

</script>