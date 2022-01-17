<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 9/20/2018
 * Time: 1:28 PM
 * Change Log:
 * 6/7/2019 - whildebrandt: Cleaned up several lines of code in the on board submit event by removing a redundant "else" clause.
 * 6/7/2019 - whildebrandt: Changed on board checks to no wrap for smaller screens.
 */

require_once('../../Includes/Security/database.php');

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
    .truncate {
        width: 20px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
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

    .modal-backdrop {
        height: unset;
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
                            <table id="employee-table" class="table table-xl table-bordered table-striped nowrap">
                                <thead class="th-vprop-blue-medium">
                                <tr>
                                    <th>Paycom</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Site</th>
                                    <th>Department</th>
                                    <th>Title</th>
                                    <th>Manager</th>
                                    <th>Start Date</th>
                                    <th>Approval</th>
                                    <th>Comment</th>
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
                                            <input autocomplete="off" class="form-control border-right-0" id="OnBoardFirstNameInput" name="name" placeholder="First Name">
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-user text-secondary"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <input autocomplete="off" class="form-control border-right-0 " id="OnBoardLastNameInput" name="name" placeholder="Last Name">
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-user text-secondary"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <input autocomplete="off" class="form-control border-right-0 " id="OnBoardPaycomInput" placeholder="Paycom ID">
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-id-card text-secondary"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <select class="form-control border-right-0" id="onBoardDivisionSelect" title="Select division">
                                                <option value="0">Business Unit</option>
                                            </select>
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-map-marker-alt text-secondary"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">

                                            <select class="form-control border-right-0 " id="OnBoardSiteSelect" title="Select site">
                                                <option value="0">Site</option>
                                            </select>
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-map-marker-alt text-secondary"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <select class="form-control border-right-0" id="OnBoardDeptSelect" title="Select department">
                                                <option value="0">Department</option>
                                            </select>
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-building text-secondary"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <select class="form-control  border-right-0" id="onBoardJobTitleSelect" title="Select job title">
                                                <option value="0">Job Title</option>
                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-basic" type="button" data-toggle="modal" data-target="#editJobTitleModal">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <select class="form-control border-right-0" id="onBoardManagerSelect" title="Select manager">
                                                <option value="0">Manager</option>
                                            </select>
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-user-tie text-secondary"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <input autocomplete="off" class="form-control bg-white border-right-0" id="OnBoardStartDateInput" placeholder="Start Date" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="far fa-calendar text-secondary"></i></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card" id="on-board-employee-accounts-card">
                                <div class="card-header th-vprop-blue-medium">
                                    Account Model
                                </div>
                                <div class="card-body">
                                    <div class="form-group col-xl-12">
                                        <div class="input-group mb-3">
                                            <select class="form-control border-right-0" id="OnBoardSilicoreModelSelect" title="Model after">
                                                <option value="0">Select an employee to model after</option>
                                            </select>
                                            <div class="input-group-append">
                                                <span class="input-group-text text-muted bg-white border-left-0"><i class="fas fa-desktop text-secondary"></i></span>
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
                                    <div class="row"  style="white-space:nowrap;">
                                        <div class="col">
                                            <div class="form-group">
                                                <button type="button" class="btn bg-transparent" id="onBoardPhoneCheck"><i class="far fa-square text-secondary"></i></button>
                                                <label for="onBoardPhoneCheck">Cell Phone</label>
                                            </div>
                                            <div class="form-group ">
                                                <button type="button" class="btn bg-transparent" id="onBoardLaptopCheck"><i class="far fa-square text-secondary"></i></button>
                                                <label for="onBoardLaptopCheck">Laptop</label>
                                            </div>
                                            <div class="form-group ">
                                                <button type="button" class="btn bg-transparent" id="onBoardDesktopCheck"><i class="far fa-square text-secondary"></i></button>
                                                <label for="onBoardDesktopCheck">Desktop</label>
                                            </div>
                                            <div class="form-group ">
                                                <button type="button" class="btn bg-transparent" id="onBoardTabletCheck"><i class="far fa-square text-secondary"></i></button>
                                                <label for="onBoardTabletCheck">Tablet</label>
                                            </div>
                                            <div class="form-group ">
                                                <button type="button" class="btn bg-transparent" id="onBoardRadioCheck"><i class="far fa-square text-secondary"></i></button>
                                                <label for="onBoardRadioCheck">Radio</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <button type="button" class="btn bg-transparent" id="onBoardUniformCheck"><i class="far fa-square text-secondary"></i></button>
                                                <label for="onBoardUniformCheck">Uniform(s)</label>
                                            </div>
                                            <div class="form-group ">
                                                <button type="button" class="btn bg-transparent" id="onBoardBusinessCardsCheck"><i class="far fa-square text-secondary"></i></button>
                                                <label for="onBoardBusinessCardsCheck">Business Cards</label>
                                            </div>
                                            <div class="form-group ">
                                                <button type="button" class="btn bg-transparent" id="onBoardFuelCardCheck"><i class="far fa-square text-secondary"></i></button>
                                                <label for="onBoardFuelCardCheck">Fuel Card</label>
                                            </div>
                                            <div class="form-group ">
                                                <button type="button" class="btn bg-transparent" id="onBoardCreditCardCheck"><i class="far fa-square text-secondary"></i></button>
                                                <label for="onBoardCreditCardCheck">Credit Card</label>
                                            </div>
                                            <div class="form-group ">
                                                <button type="button" class="btn bg-transparent" id="onBoardSalesforceCheck"><i class="far fa-square text-secondary"></i></button>
                                                <label for="onBoardSalesforceCheck">Salesforce Account</label>
                                            </div>
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
                        echo '<div class="card float-right"><div class="card-header bg-warning text-white">For HR Manager use only</div><div class="card-body"><button type="button" class="btn bg-transparent mr-2 hide" id="onBoardPreApprove" value="0" disabled><i class="far fa-square text-secondary"></i></button><label for="onBoardPreApprove mb-0" id="approval-feedback">You must enter a paycom ID to approve.</label></div></div>';
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
                        <label for="firstNameInput">First Name</label>
                        <input autocomplete="off" id="firstNameInput" class="form-control">
                    </div>
                    <div class="form-group col-xl-6">
                        <label for="lastNameInput">Last Name</label>
                        <input autocomplete="off" id="lastNameInput" class="form-control">
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="paycom-input">Paycom ID</label>
                        <input autocomplete="off" id="paycom-input" class="form-control">
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="businessUnitSelect">Business Unit</label>
                        <select id="businessUnitSelect" class="form-control">
                        </select>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="siteSelect">Site</label>
                        <select id="siteSelect" class="form-control">
                        </select>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="departmentSelect">Department</label>
                        <select id="departmentSelect" class="form-control">
                        </select>
                    </div>
                    <div class="form-group col mb-0">
                        <label for="jobTitleSelect">Job Title</label>
                        <div class="input-group mb-3">
                            <select id="jobTitleSelect" class="form-control w-75">
                                <option></option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-basic" data-toggle="modal" data-target="#editJobTitleModal">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="manager-select">Manager</label>
                        <select id="manager-select" class="form-control">
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
<div class="modal" id="editJobTitleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
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
                        <select id="edit-businessUnitSelect" class="form-control" title="Business Unit">
                            <option value="0">Select Business Unit</option>
                        </select>
                    </div>
                    <div class="form-group col-xl-12">
                        <select id="edit-siteSelect" class="form-control" title="Site">
                            <option value="0">Select Site</option>
                        </select>
                    </div>
                    <div class="form-group col-xl-12">
                        <select id="edit-departmentSelect" class="form-control" title="Department">
                            <option value="0">Select department</option>
                        </select>
                    </div>
                    <div class="form-group col-xl-12">
                        <input placeholder="Job title/position" id="edit-job-title-input" type="text" class="form-control">
                        <button type="button" class="btn bg-transparent" id="is-management"><i class="far fa-square text-secondary"></i></button>
                        <label for="is-management">Management Position</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-vprop-green" id="editJobTitleSubmit">Submit</button>
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
        //$('#edit-employee-submit-btn').hide();
        $('.form-row input,select').on('input', function () {
            // $('#edit-employee-submit-btn').show(300);
        });
        $('#employee-edit').on('hidden.bs.modal', function () {
            //$('#edit-employee-submit-btn').hide();
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
            scrollX: true,
            pageLength: '100',
            buttons: [{extend: 'excel', text: 'Export', title: 'Employees Export ' + date}],
            columns: [
                {data: "paycom_id"},
                {data: "last_name"},
                {data: "first_name"},
                {data: "site_name"},
                {data: "department_name"},
                {data: "job_title_name"},
                {
                    data: "manager_name", render: function (data) {
                        if (data === '') {
                            return '';
                        } else {
                            return data;
                        }
                    }
                },
                {data: "start_date", visible: false},
                {
                    data: "is_approved", render: function (data, type, row, meta) {
                        if (data === '1') {
                            return 'Approved';
                        }
                        else if (row.paycom_id !== "" && row.paycom_id !== null && row.paycom_id !== "null") {
                            return '<?php if ($userPermissionsArray['vista']['granbury']['hr'] > 2) {
                                echo '<a class="link pending-approval" href="#">Pending</a>';
                            } else {
                                echo '<a class="link">Pending</a>';
                            }?>';
                        } else {
                            return '<?php echo '<a class="link" data-toggle="tooltip" data-placement="top" title="A Paycom ID must be entered before you can approve" disabled>Pending</a>' ?>';
                        }
                    }
                },
                {data: "comments", visible: false},
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
                    visible: false, targets: [10]
                }
            ],
            initComplete: function () {
                $("#employee-table_filter").detach().appendTo('#table-card-header').addClass('form-inline float-right');
                $("#employee-table_paginate").detach().appendTo('#table-card-footer').addClass('float-right');

                $('#employee-table').css('width', '100%');
                employeeTable.columns.adjust();
            }
        });
        $('#employee-table tbody').on('click', 'tr .pending-approval', function () {
            let e = employeeTable.row($(this).closest('tr')).data();
            let formData = {};
            formData['id'] = e.id;
            formData['first_name'] = e.first_name;
            formData['last_name'] = e.last_name;
            formData['user_id'] = "<?php echo $_SESSION['user_id']; ?>";
            formData['manager_name'] = e.manager_name;
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
                                            let requestData = {};
                                            requestData['employeeData'] = JSON.stringify(e);
                                            requestData['fromTable'] = 1;
                                            requestData['userId'] = "<?php echo $_SESSION['user_id']; ?>";
                                            $.ajax({
                                                url: '../../Includes/HR/saveemployee.php',
                                                data: requestData,
                                                type: 'POST',
                                                beforeSend: function () {
                                                    $('.content-wrapper').slideDown().prepend('<div class="alert alert-warning fade show process-status" style="position:absolute; top:6%; right:40%; z-index:999;" role="alert">\n' +
                                                        '<strong>Processing Employee</strong><div class="spinner-border spinner-border-sm text-warning ml-2" role="status"></div></div>');
                                                },
                                                success: function (response) {
                                                    $('body').find('.process-status').remove();
                                                    bsAlert(null, 0, response);
                                                    employeeTable.ajax.reload();
                                                },
                                                complete: function () {
                                                    employeeTable.ajax.reload();
                                                }
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
        $('#businessUnitSelect').on('change', function () {
            let formData = {};
            formData['id'] = $('#businessUnitSelect').val();
            $.ajax({
                url: '../../Includes/HR/sitesget.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    $('#siteSelect').find('option').remove();
                    $.each(JSON.parse(response), function (key, value) {
                        $('#siteSelect').append('<option value="' + value.id + '">' + value.site + '</option>');
                    });
                    let siteFormData = {};
                    siteFormData['siteId'] = $('#siteSelect').val();
                    $.ajax({
                        url: '../../Includes/HR/departmentsbysiteget.php',
                        type: 'POST',
                        data: JSON.stringify(siteFormData),
                        success: function (response) {
                            $('#departmentSelect').find('option').remove();
                            $.each(JSON.parse(response), function (key, value) {
                                $('#departmentSelect').append('<option value="' + value.id + '">' + value.department_display + '</option>');
                            });
                            let jobFormData = {};
                            jobFormData['department_id'] = $('#departmentSelect').val();
                            $('#jobTitleSelect').find('option').remove();
                            $.ajax({
                                url: '../../Includes/HR/jobtitlesget.php',
                                type: 'POST',
                                data: JSON.stringify(jobFormData),
                                success: function (response) {
                                    $.each(JSON.parse(response), function (key, value) {
                                        $('#jobTitleSelect').append('<option value="' + value.id + '">' + value.name + '</option>');
                                    });
                                    $('#jobTitleSelect').val(e.job_title);
                                }
                            });
                        }
                    });
                }
            });
            $.ajax({
                url: '../../Includes/HR/departmentsbysiteget.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    $('#departmentSelect').find('option').remove();
                    $.each(JSON.parse(response), function (key, value) {
                        $('#departmentSelect').append('<option value="' + value.id + '">' + value.department_display + '</option>');
                    });
                }
            });
        });
        $('#siteSelect').on('change', function () {
            let formData = {};
            formData['siteId'] = $('#siteSelect').val();
            $.ajax({
                url: '../../Includes/HR/departmentsbysiteget.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    $('#departmentSelect').find('option').remove();
                    $.each(JSON.parse(response), function (key, value) {
                        $('#departmentSelect').append('<option value="' + value.id + '">' + value.department_display + '</option>');
                    });
                    let jobFormData = {};
                    jobFormData['department_id'] = $('#departmentSelect').val();
                    $('#jobTitleSelect').find('option').remove();
                    $.ajax({
                        url: '../../Includes/HR/jobtitlesget.php',
                        type: 'POST',
                        data: JSON.stringify(jobFormData),
                        success: function (response) {
                            $.each(JSON.parse(response), function (key, value) {
                                $('#jobTitleSelect').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                            $('#jobTitleSelect').val(e.job_title);
                        }
                    });
                }
            });
        });
        $('#OnBoardSiteSelect').on('change', function () {
            let formData = {};
            formData['siteId'] = $('#OnBoardSiteSelect').val();
            $.ajax({
                url: '../../Includes/HR/departmentsbysiteget.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    $('#OnBoardDeptSelect').find('option').not(':first').remove();
                    $('#onBoardManagerSelect').find('option').not(':first').remove();
                    $.each(JSON.parse(response), function (key, value) {
                        $('#OnBoardDeptSelect').append('<option value="' + value.id + '">' + value.department_display + '</option>');
                    });
                }
            });
        });
        $('#OnBoardDeptSelect').on('change', function () {
            $('#onBoardManagerSelect').find('option').not(':first').remove();
        });
        $('.dt-buttons').addClass('float-left');
        $('.buttons-excel').removeClass('btn-secondary').addClass('btn-vprop-green');
        employeeTable.on('click', 'tbody .edit-btn', function (event) {
            let e = employeeTable.row($(this).closest('tr')).data();
            $('#employee-data').val(JSON.stringify(e));
            let formData = {};
            let jobFormData = {};
            let siteFormData = {};
            siteFormData['siteId'] = e.site_id;
            jobFormData['department_id'] = e.department_id;
            formData['id'] = e.division_id;
            $('#businessUnitSelect').find('option').remove().end();
            $('#manager-select').find('option').remove().end();
            $('#siteSelect').find('option').remove().end();
            $('#departmentSelect').find('option').remove().end();
            $('#jobTitleSelect').find('option').remove().end();
            $.ajax({
                url: '../../Includes/HR/managersget.php',
                type: 'POST',
                data: JSON.stringify(jobFormData),
                success: function (response) {
                    $.each(JSON.parse(response), function (key, value) {
                        $('#manager-select').append('<option value="' + value.id + '">' + value.mgrname + '</option>');
                    });
                    $('#manager-select').val(e.manager_user_id);
                }
            });
            $.ajax({
                url: '../../Includes/HR/divisionsget.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    $.each(JSON.parse(response), function (key, value) {
                        $('#businessUnitSelect').append('<option value="' + value.id + '">' + value.division + '</option>');
                    });
                    $('#businessUnitSelect').val(e.division_id);
                }
            });
            $.ajax({
                url: '../../Includes/HR/sitesget.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    $.each(JSON.parse(response), function (key, value) {
                        $('#siteSelect').append('<option value="' + value.id + '">' + value.site + '</option>');
                    });
                    $('#siteSelect').val(e.site_id);
                }
            });
            $.ajax({
                url: '../../Includes/HR/departmentsbysiteget.php',
                type: 'POST',
                data: JSON.stringify(siteFormData),
                success: function (response) {
                    $.each(JSON.parse(response), function (key, value) {
                        $('#departmentSelect').append('<option value="' + value.id + '">' + value.department_display + '</option>');
                    });
                    $('#departmentSelect').val(e.department_id);
                }
            });
            $.ajax({
                url: '../../Includes/HR/jobtitlesget.php',
                type: 'POST',
                data: JSON.stringify(jobFormData),
                success: function (response) {
                    $.each(JSON.parse(response), function (key, value) {
                        $('#jobTitleSelect').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $('#jobTitleSelect').val(e.job_title);
                }
            });
            $('#firstNameInput').val(e.first_name);
            $('#lastNameInput').val(e.last_name);
            $('#paycom-input').val(e.paycom_id);
            $('#departmentSelect').val(e.department_id);
            $('#siteSelect').val(e.site_name);
            $('#status-select').val(e.is_active);
            $('#jobTitleSelect').val(e.job_title);
        });
        $('#editJobTitleModal').on('shown.bs.modal', function () {
            let $bu = $('#edit-businessUnitSelect');
            let $site = $('#edit-siteSelect');
            let $dept = $('#edit-departmentSelect');
            let $jobInput = $('#edit-jobTitleSelect');
            $bu.children('option:not(:first)').remove();
            $site.children('option:not(:first)').remove();
            $dept.children('option:not(:first)').remove();
            $jobInput.children('option:not(:first)').remove();
            $('#is-management').val(0).find('i').removeClass().addClass('far fa-square text-secondary');
            $.ajax({
                url: '../../Includes/HR/divisionsget.php',
                success: function (response) {
                    let data = JSON.parse(response);
                    $.each(data, function (key, value) {
                        $bu.append('<option value="' + value.id + '">' + value.division + '</option>');
                    });
                }
            });
        });
        $('#edit-businessUnitSelect').on('change', function () {
            let formData = {};
            formData['id'] = $('#edit-businessUnitSelect').val();
            $.ajax({
                url: '../../Includes/HR/sitesget.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    $('#edit-siteSelect').find('option').not(':first').remove();
                    $.each(JSON.parse(response), function (key, value) {
                        $('#edit-siteSelect').append('<option value="' + value.id + '">' + value.site + '</option>');
                    });
                }
            });
        });
        $('#edit-siteSelect').on('change', function () {
            let formData = {};
            formData['siteId'] = $('#edit-siteSelect').val();
            $.ajax({
                url: '../../Includes/HR/departmentsbysiteget.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    $('#edit-departmentSelect').find('option').not(':first').remove();
                    $.each(JSON.parse(response), function (key, value) {
                        $('#edit-departmentSelect').append('<option value="' + value.id + '">' + value.department_display + '</option>');
                    });
                }
            });
        });

        $('#editJobTitleSubmit').on('click', function () {
            let bu = $('#edit-businessUnitSelect');
            let site = $('#edit-siteSelect');
            let dept = $('#edit-departmentSelect');
            let position = $('#edit-job-title-input');
            let formData = {};
            if (bu.val() === '0') {
                bsAlert(bu, 1, 'You must select a Business Unit!');
                return false;
            }
            if (site.val() === '0') {
                bsAlert(site, 1, 'You must select a Site!');
                return false;
            }
            if (!dept.val()) {
                bsAlert(dept, 1, 'You must select a Department!');
                return false;
            } else if (dept.val() === '0') {
                bsAlert(dept, 1, 'You must select a Department!');
                return false;
            } else {
                formData['department_id'] = dept.val();
            }
            if (!position.val()) {
                bsAlert(position, 1, 'You must select a Position!');
                return false;
            } else {
                formData['position'] = position.val();
            }
            formData['is_management'] = $('#is-management').val();
            $.ajax({
                url: '../../Includes/HR/jobtitlefastinsert.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    let result = parseInt(response);
                    if (result === 1) {
                        successAlert('Successfully added position!');
                        position.val("");
                        $('#editJobTitleModal').modal('hide');
                        $.ajax({
                            url: '../../Includes/HR/jobtitlesget.php',
                            type: 'POST',
                            data: JSON.stringify(formData),
                            success: function (response) {
                                $('#onBoardJobTitleSelect').empty();
                                $.each(JSON.parse(response), function (key, value) {
                                    $('#jobTitleSelect').append('<option value="' + value.id + '">' + value.name + '</option>');
                                    $('#onBoardJobTitleSelect').append('<option value="' + value.id + '">' + value.name + '</option>');
                                });
                                $('#jobTitleSelect').val(e.job_title);
                            }
                        });
                    } else {
                        errorAlert('Error adding position!');
                        position.val("");
                    }
                }
            });
        });


        $('#firstNameInput').on('input', function () {
            let fNameInput = $('#firstNameInput').val();
            let fNameFix = fNameInput.replace(/[^a-zA-Z]/g, '');
            $('#firstNameInput').val(fNameFix);
            if (fNameInput.length > 25) {
                $('#firstNameInput').val(fNameInput.substr(0, 25));
            }
        });
        $('#lastNameInput').on('input', function () {
            let lNameInput = $('#lastNameInput').val();
            let lNameFix = lNameInput.replace(/[^a-zA-Z]/g, '');
            $('#lastNameInput').val(lNameFix);
            if (lNameInput.length > 25) {
                $('#lastNameInput').val(lNameInput.substr(0, 25));
            }
        });

        $('#edit-employee-submit-btn').on('click', function () {
            let data = {};
            let employeeData = $('#employee-data').val();
            let e = JSON.parse(employeeData);
            let firstName = $('#firstNameInput');
            let lastName = $('#lastNameInput');
            let businessUnit = $('#businessUnitSelect');
            let site = $('#siteSelect');
            let department = $('#departmentSelect');
            let jobTitle = $('#jobTitleSelect');
            let manager = $('#manager-select');
            let status = $('#status-select');
            data['id'] = e.id;
            if (!firstName.val()) {
                inputError(firstName);
                bsAlert(firstName, 1, 'First name cannot be empty!');
                return false;
            } else {
                data['first_name'] = firstName.val();
            }
            if (!lastName.val()) {
                inputError(lastName);
                bsAlert(lastName, 1, 'Last name cannot be empty!');
                return false;
            } else {
                data['last_name'] = lastName.val();
            }

            if (!jobTitle.val()) {
                inputError(jobTitle);
                bsAlert(jobTitle, 1, 'Job title cannot be empty!');
                return false;
            } else {
                data['job_title_id'] = jobTitle.val();
            }
            if (!businessUnit.val()) {
                inputError(businessUnit);
                bsAlert(businessUnit, 1, 'Business Unit cannot be empty!');
                return false;
            }
            if (!department.val()) {
                inputError(department);
                bsAlert(department, 1, 'Department cannot be empty!');
                return false;
            } else {
                data['department_id'] = department.val();
            }
            if (!manager.val()) {
                inputError(manager);
                bsAlert(manager, 1, 'Manager cannot be empty!');
                return false;
            } else {
                data['manager_id'] = manager.val();
            }
            if (!site.val()) {
                inputError(site);
                bsAlert(site, 1, 'Site cannot be empty!');
                return false;
            } else {
                data['site_id'] = site.val();
            }
            if (!status.val()) {
                inputError(status);
                bsAlert(status, 1, 'Status cannot be empty!');
                return false;
            } else {
                data['is_active'] = status.val();
                data['paycom_id'] = $('#paycom-input').val();
            }
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

        //<editor-fold desc="departmentSelect autopopulation">
        $('#departmentSelect').change(function () {
            $('#manager-select').find('option').remove().end();
            $('#jobTitleSelect').find('option').remove().end();
            let formData = {};
            formData['department_id'] = $('#departmentSelect').val();
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
                        $('#jobTitleSelect').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $('#jobTitleSelect').val(e.job_title);
                }
            });
        });
        //</editor-fold>

        //<editor-fold desc="OnBoardStartDateInput datepicker initialize">
        $('#OnBoardStartDateInput').datepicker({
            format: "yyyy-mm-dd",
            disableEntry: true
        });
        //</editor-fold>

        // <editor-fold desc="checkboxes">
        $('#onBoardPhoneCheck').on('click', function () {
            checkbox($(this));
        });
        $('#onBoardUniformCheck').on('click', function () {
            checkbox($(this));
        });
        $('#onBoardBusinessCardsCheck').on('click', function () {
            checkbox($(this));
        });
        $('#onBoardFuelCardCheck').on('click', function () {
            checkbox($(this));
        });
        $('#onBoardCreditCardCheck').on('click', function () {
            checkbox($(this));
        });
        $('#onBoardLaptopCheck').on('click', function () {
            checkbox($(this));
        });
        $('#onBoardDesktopCheck').on('click', function () {
            checkbox($(this));
        });
        $('#onBoardTabletCheck').on('click', function () {
            checkbox($(this));
        });
        $('#onBoardRadioCheck').on('click', function () {
            checkbox($(this));
        });
        $('#onBoardSalesforceCheck').on('click', function () {
            checkbox($(this));
        });
        $('#onBoardPreApprove').on('click', function () {
            checkbox($(this));
        });
        $('#is-management').on('click', function () {
            checkbox($(this));
        });
        //</editor-fold>

        //<editor-fold desc="Adjust sizing of headers for datatable anytime a tab is opened">
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $('#employee-table').DataTable().columns.adjust();
        });
        //</editor-fold>

        //<editor-fold desc="OnBoardDeptSelect autopopulation">
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            let target = $(e.target).attr('href');
            $('#onBoardDivisionSelect').children('option:not(:first)').remove();
            if (target === "#on-board") {
                let formData = {};

                let departmentSelect = $('#OnBoardDeptSelect');
                let divisionSelect = $('#onBoardDivisionSelect');
                formData['id'] = divisionSelect.val();
                $.ajax({
                    url: '../../Includes/HR/divisionsget.php',
                    dataSrc: '',
                    success: function (response) {
                        $.each(JSON.parse(response), function (key, value) {
                            $('#onBoardDivisionSelect').append('<option value="' + value.id + '">' + value.division + '</option>');
                        });
                    }
                });
                if (departmentSelect.val()) {
                    $.ajax({
                        url: '../../Includes/HR/managersget.php',
                        type: 'POST',
                        data: JSON.stringify(formData),
                        success: function (response) {
                            $.each(JSON.parse(response), function (key, value) {
                                $('#onBoardManagerSelect').append('<option value="' + value.id + '">' + value.mgrname + '</option>');
                            });
                        }
                    });
                }
                $('#OnBoardDeptSelect').change(function () {
                    $('#OnBoardSilicoreModelSelect').find('option').not(':first').remove();
                    $('#onBoardManagerSelect').find('option').not(':first').remove().end();
                    $('#onBoardJobTitleSelect').find('option').not(':first').remove();
                    let formData = {};
                    formData['department_id'] = $('#OnBoardDeptSelect').val();
                    $.ajax({
                        url: '../../Includes/HR/managersget.php',
                        type: 'POST',
                        data: JSON.stringify(formData),
                        success: function (response) {
                            $.each(JSON.parse(response), function (key, value) {
                                $('#onBoardManagerSelect').append('<option value="' + value.id + '">' + value.mgrname + '</option>');
                            });
                        }
                    });
                    $.ajax({
                        url: '../../Includes/HR/jobtitlesget.php',
                        type: 'POST',
                        data: JSON.stringify(formData),
                        success: function (response) {
                            $.each(JSON.parse(response), function (key, value) {
                                $('#onBoardJobTitleSelect').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                    $.ajax({
                        url: '../../Includes/HR/employeesbydepartment.php',
                        type: 'POST',
                        data: JSON.stringify(formData),
                        success: function (response) {
                            $.each(JSON.parse(response), function (key, value) {
                                $('#OnBoardSilicoreModelSelect').append('<option value="' + value.id + '">' + value.name + '</option>');
                                $('#OnBoardEmailModelSelect').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                });
                let paycom_input = $('#OnBoardPaycomInput');
                paycom_input.on('input', function () {
                    if (paycom_input.val() !== null && paycom_input.val() !== '') {
                        $('#onBoardPreApprove').prop('disabled', false).show();
                        $('#approval-feedback').text('Approved');
                    } else {
                        $('#onBoardPreApprove').prop('disabled', true).hide();
                        $('#approval-feedback').text('You must enter a paycom ID to approve.');
                    }
                });

            }
        });
        //</editor-fold>

        $('#onBoardDivisionSelect').on('input', function () {
            let formData = {};
            formData['id'] = $('#onBoardDivisionSelect').val();
            $.ajax({
                url: '../../Includes/HR/sitesget.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    $('#OnBoardSiteSelect').find('option').not(':first').remove();
                    $.each(JSON.parse(response), function (key, value) {
                        $('#OnBoardSiteSelect').append('<option value="' + value.id + '">' + value.site + '</option>');
                    });
                    let siteForm = {};
                    siteForm['siteId'] = $('#OnBoardSiteSelect').val();
                    $.ajax({
                        url: '../../Includes/HR/departmentsbysiteget.php',
                        type: 'POST',
                        data: JSON.stringify(siteForm),
                        success: function (response) {
                            $('#OnBoardDeptSelect').find('option').not(':first').remove();
                            $.each(JSON.parse(response), function (key, value) {
                                $('#OnBoardDeptSelect').append('<option value="' + value.id + '">' + value.department_display + '</option>');
                            });
                            let jobForm = {};
                            jobForm['department_id'] = $('#OnBoardDeptSelect').val();
                            $.ajax({
                                url: '../../Includes/HR/jobtitlesget.php',
                                type: 'POST',
                                data: JSON.stringify(jobForm),
                                success: function (response) {
                                    $('#onBoardJobTitleSelect').find('option').not(':first').remove();
                                    $.each(JSON.parse(response), function (key, value) {
                                        $('#onBoardJobTitleSelect').append('<option value="' + value.id + '">' + value.name + '</option>');
                                    });
                                    $.ajax({
                                        url: '../../Includes/HR/managersget.php',
                                        type: 'POST',
                                        data: JSON.stringify(jobForm),
                                        success: function (response) {
                                            $('#onBoardManagerSelect').find('option').not(':first').remove();

                                            $.each(JSON.parse(response), function (key, value) {
                                                $('#onBoardManagerSelect').append('<option value="' + value.id + '">' + value.mgrname + '</option>');
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            });
        });

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

        $('#main-content-card').on('click', '.submit', function () {
            let $paycom = $('#OnBoardPaycomInput');
            let $firstName = $('#OnBoardFirstNameInput');
            let $lastName = $('#OnBoardLastNameInput');
            let $division = $('#onBoardDivisionSelect');
            let $site = $('#OnBoardSiteSelect');
            let $dept = $('#OnBoardDeptSelect');
            let managerName = $('#onBoardManagerSelect option:selected').text();
            let $manager = $('#onBoardManagerSelect');
            let $job = $('#onBoardJobTitleSelect');
            let $date = $('#OnBoardStartDateInput');
            let $silicore = $('#OnBoardSilicoreModelSelect');
            let $email = $('#OnBoardEmailModelSelect');
            let $comment = $('#comment');
            let $preApprove = $('#onBoardPreApprove');
            let $phone = $('#onBoardPhoneCheck');
            let $laptop = $('#onBoardLaptopCheck');
            let $tablet = $('#onBoardTabletCheck');
            let $desktop = $('#onBoardDesktopCheck');
            let $radio = $('#onBoardRadioCheck');
            let $businessCards = $('#onBoardBusinessCardsCheck');
            let $fuelCard = $('#onBoardFuelCardCheck');
            let $creditCard = $('#onBoardCreditCardCheck');
            let $uniform = $('#onBoardUniformCheck');
            let $salesforce = $('#onBoardSalesforceCheck');
            let formData = {};
            formData['paycomId'] = $paycom.val();
            let result = null;
            $.ajax({
                url: '../../Includes/HR/employeebypaycomget.php',
                data: formData,
                type: 'POST',
                beforeSend: function () {
                    $('.content-wrapper').slideDown().prepend('<div class="alert alert-warning fade show process-status" style="position:absolute; top:10%; right:50%; z-index:999;" role="alert">\n' +
                        '<strong>Processing Employee</strong><div class="spinner-border spinner-border-sm text-warning ml-2" role="status"></div></div>');
                },
                success: function (response) {
                    result = parseInt(JSON.parse(response)[0].result);
                    let saveFormData = {};
                    let employeeData = {};
                    let requestData = {};
                    if (result !== 1) {
                        if ($firstName.val() !== '') {
                            employeeData['firstName'] = $firstName.val();
                        } else {
                            bsAlert($firstName, 1, "You must enter a first name!");
                            return false;
                        }
                        if ($lastName.val() !== '') {
                            employeeData['lastName'] = $lastName.val();
                        } else {
                            bsAlert($lastName, 1, "You must enter a last name!");
                            return false;
                        }
                        if ($division.val() !== '' && $division.val() !== '0') {
                            employeeData['division'] = $division.val();
                        } else {
                            bsAlert($division, 1, "You must select a division!");
                            return false;
                        }
                        if ($site.val() !== '' && $site.val() !== '0') {
                            employeeData['site'] = $site.val();
                        } else {
                            bsAlert($site, 1, "You must select a site!");
                            return false;
                        }
                        if ($dept.val() !== '' && $dept.val() !== '0') {
                            employeeData['departmentId'] = $dept.val();
                        } else {
                            bsAlert($dept, 1, "You must select a department!");
                            return false;
                        }
                        if ($job.val() !== '' && $job.val() !== '0') {
                            employeeData['jobTitleId'] = $job.val();
                        } else {
                            bsAlert($job, 1, "You must select a job title!");
                            return false;
                        }
                        if ($manager.val() !== "" && $manager.val() !== '0') {
                            employeeData['managerId'] = $manager.val();
                        } else {
                            bsAlert($manager, 1, "You must select a manager!");
                            return false;
                        }
                        if (managerName !== "") {
                            employeeData['managerName'] = managerName;
                        } else {
                            bsAlert($manager, 1, "You must select a manager!");
                            return false;
                        }
                        if ($date.val() !== '') {
                            employeeData['startDate'] = $date.val();
                        } else {
                            bsAlert($date, 1, "You must enter a start date!");
                            return false;
                        }
                        if ($silicore.val() !== '' && $silicore.val() !== '0') {
                            employeeData['silicoreAccount'] = $('#OnBoardSilicoreModelSelect option:selected').text();
                        } else {
                            bsAlert($silicore, 1, "You must select an employee to model after for Email and Silicore access!");
                            return false;
                        }
                        if ($email.val() !== '' && $email.val() !== '0') {
                            employeeData['emailAccount'] = $('#OnBoardSilicoreModelSelect option:selected').text();
                        } else {
                            bsAlert($email, 1, "You must select an employee to model after for Email and Silicore access!");
                            return false;
                        }
                        employeeData['comments'] = $comment.val();
                        if ($preApprove.length) {
                            employeeData['isApproved'] = $preApprove.val();
                        } else {
                            saveFormData['isApproved'] = 0;
                        }
                        if ($phone.val() === '1') {
                            requestData['Cell Phone'] = $phone.val();
                        }
                        if ($laptop.val() === '1') {
                            requestData['Laptop'] = $laptop.val();
                        }
                        if ($desktop.val() === '1') {
                            requestData['Desktop'] = $desktop.val();
                        }
                        if ($tablet.val() === '1') {
                            requestData['Tablet'] = $tablet.val();
                        }
                        if ($radio.val() === '1') {
                            requestData['Radio'] = $radio.val();
                        }
                        if ($uniform.val() === '1') {
                            requestData['Uniform'] = $uniform.val();
                        }
                        if ($businessCards.val() === '1') {
                            requestData['Business Card'] = $businessCards.val();
                        }
                        if ($fuelCard.val() === '1') {
                            requestData['Fuel Card'] = $fuelCard.val();
                        }
                        if ($creditCard.val() === '1') {
                            requestData['Credit Card'] = $creditCard.val();
                        }
                        if ($salesforce.val() === '1') {
                            requestData['Salesforce Account'] = $salesforce.val();
                        }
                        employeeData['paycomId'] = $paycom.val();
                        saveFormData['employeeData'] = JSON.stringify(employeeData);
                        saveFormData['requests'] = JSON.stringify(requestData);
                        saveFormData['userId'] = "<?php echo $_SESSION['user_id']; ?>";
                        saveFormData['fromOnBoard'] = 1;
                        $.ajax({
                            url: '../../Includes/HR/saveemployee.php',
                            type: 'POST',
                            data: saveFormData,
                            success: function (response) {
                                if (response > 0) {
                                    bsAlert(null, 0, 'Employee saved!');
                                    setTimeout(function () {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    $('.content-wrapper').find('.process-status').alert('close');
                                    bsAlert(null, 1, 'Process error occurred!');
                                }
                            }
                        });
                    } else {
                        bsAlert($paycom, 1, "This paycom ID has already been entered.");
                        return false;
                    }
                },
                complete: function () {
                }
            });
        });

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

    function bsAlert(div, is_error, content) {
        $('.content-wrapper').find('.process-status').alert('close');
        if (div !== null) {
            div.focus();
        }
        if (is_error === 1) {
            $('.content-wrapper').slideDown().prepend('<div class="alert alert-danger alert-dismissible fade show" style="position:absolute; top:10%; right:40%; z-index:999;" role="alert">\n' +
                '  <strong>Error!</strong> ' + content +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                '  </button>\n' +
                '</div>');
            setTimeout(function () {
                $('.content-wrapper').find('.alert-danger').alert('close');
            }, 2500);
        } else if (is_error === 0) {
            $('.content-wrapper').slideDown().prepend('<div class="alert alert-success alert-dismissible fade show" style="position:absolute; top:10%; right:40%; z-index:999;" role="alert">\n' +
                '  <strong>Success!</strong> ' + content +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                '  </button>\n' +
                '</div>');
            setTimeout(function () {
                $('.content-wrapper').find('.alert-success').alert('close');
            }, 2500);
        }

    }

</script>