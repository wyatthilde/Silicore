<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 4/8/2019
 * Time: 2:00 PM
 */
?>
<section id="reqs">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script src="../../Includes/HR/js/Preemployment/applicant.js"></script>
    <script src="../../Includes/Admin/dropdown-functions.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.9/jquery.autocomplete.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js" integrity="sha256-H9jAz//QLkDOy/nzE9G4aYijQtkLt9FvGmdUTwBk6gs=" crossorigin="anonymous"></script>

</section>
<style>

    .form-control:focus {
        border-color: #cccccc;
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    .modal-content-lg {
        max-width: unset !important;
        width: 850px;
    }

    .modal-dialog {
        max-width: unset;
    }

    .datepicker td, .datepicker th {
        width: 35px;
        height: 35px;
    }

    .datepicker table tr td.active {
        background-image: unset !important;
        background-color: #A2BCED !important;
    }

    .center-icon {
        text-align: center;
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

    .big-checkbox {
        width: 18px;
        height: 18px;
    }

    .alert-display {
        position: fixed;
        left: 0;
        right: 0;
        top: 7.6%;
        margin-left: auto;
        margin-right: auto;
        width: 400px;
        z-index: 999;
    }

</style>

<div class="card">
    <div class="card-header" id="applicantCardHeader">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#allMedicalRequestsModal">
                    <button class="btn btn-vprop-blue-medium"><i class="fa fa-search"></i> View All Medical Requests</button>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#applicantModal">
                    <button class="btn btn-vprop-green"><i class="fa fa-plus-circle"></i> New Applicant</button>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#medicalRequestModal">
                    <button class="btn btn-vprop-green" id="medicalRequestBtn"><i class="fa fa-plus-circle"></i> New Medical Request</button>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#settingsModal">
                    <button class="btn btn-outline-secondary"><i class="fa fa-cog"></i> Settings</button>
                </a>
            </li>
            <li class="nav-item ml-auto" id="tableFilter"></li>
        </ul>
    </div>
    <div class="card-body" style="min-height:410px;">
        <div class="card-title"><h5>Applicants</h5></div>
        <div class="table-responsive">
            <table id="applicantTable" class="table table-bordered table-hover" style="min-height:120px;">
                <thead>
                <tr>
                    <th>Applicant ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Create Date</th>
                    <th>Create User ID</th>
                    <th>Create User</th>
                    <th>Status</th>
                    <th>Manage</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer" id="applicantCardFooter">
    </div>
</div>

<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Settings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="clinicSelect">Clinic</label>
                <div class="input-group mb-3">
                    <select id="clinicSelect" class="form-control">
                        <option value="0">Select a clinic</option>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-basic" type="button" id="clinicAdd" data-target="#clinicAddModal" data-toggle="modal">Add</button>
                    </div>
                </div>
                <div id="testCheckboxesContainer">
                    <div class="container border rounded-0" id="testCheckboxes" style="display:none;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium" id="settingsSubmit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="medicalRequestModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">New Medical Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text request-search-icon bg-white"><i class="fa fa-search"></i></span>
                            </div>
                            <input class="form-control border-left-0 pl-0" id="search" placeholder="Start typing to search applicant or employee">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="requestReasons">Reason</label>
                        <select id="requestReasons" class="form-control">
                            <option value="0">Select a reason</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="testTypes">Test Type</label>
                        <select id="testTypes" class="form-control">
                            <option value="0">Select a test type</option>
                            <option value="1">NON-DOT</option>
                            <option value="2">DOT</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="requestClinicSelect">Clinic</label>
                        <select id="requestClinicSelect" class="form-control">
                            <option value="0">Select a clinic</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <div class="container border rounded-0" id="clinicTests" style="overflow-y:auto;max-height:200px;">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium" id="requestSubmit">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="applicantModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Applicant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col">
                        <label for="divisionSelect">Division</label>
                        <select id="divisionSelect" class="form-control">
                            <option value="0">Select a division</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="siteSelect">Site</label>
                        <select id="siteSelect" class="form-control">
                            <option value="0">Select a site</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="firstNameInput">First Name</label>
                        <input id="firstNameInput" class="form-control">
                    </div>
                    <div class="form-group col">
                        <label for="lastNameInput">Last Name</label>
                        <input id="lastNameInput" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="dobInput">Date of birth</label>
                        <input id="dobInput" class="form-control dob-input">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="phoneInput">Phone Number</label>
                        <input id="phoneInput" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium" id="applicantSubmit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="applicantEditModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Applicant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col">
                        <label for="editDivisionSelect">Division</label>
                        <select class="form-control" id="editDivisionSelect"></select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="editSiteSelect">Site</label>
                        <select class="form-control" id="editSiteSelect"></select>
                    </div>
                </div>

                <div class="form-row">
                    <input type="hidden" id="applicantId">
                    <div class="form-group col">
                        <label for="editFirstNameInput">First Name</label>
                        <input class="form-control" id="editFirstNameInput">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="editLastNameInput">Last Name</label>
                        <input class="form-control" id="editLastNameInput">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="editDOBInput">Date of birth</label>
                        <input class="form-control dob-input" id="editDOBInput">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="editPhoneInput">Phone Number</label>
                        <input class="form-control" id="editPhoneInput">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="editStatusSelect">Status</label>
                        <select class="form-control" id="editStatusSelect">
                            <option value="0">Select a status</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium" id="applicantEditSubmit">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="applicantDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-lg">
            <div class="modal-header">
                <h5 class="modal-title">Medical Requests</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height:500px;overflow-y:auto;">
                <div id="applicantRequestsBody">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium" id="applicantSubmit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="clinicAddModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Clinic</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col">
                        <label for="clinicNameInput">Name</label>
                        <input id="clinicNameInput" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="clinicPhoneInput">Phone Number</label>
                        <input id="clinicPhoneInput" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="clinicFaxInput">Fax Number</label>
                        <input id="clinicFaxInput" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="clinicEmailInput">Email Address</label>
                        <input id="clinicEmailInput" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="clinicAddressInput">Address</label>
                        <input type="text" class="form-control" id="clinicAddressInput" placeholder="1234 Main St">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="clinicCityInput">City</label>
                        <input type="text" class="form-control" id="clinicCityInput">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="clinicStateSelect">State</label>
                        <select id="clinicStateSelect" class="form-control">
                            <option selected>Choose...</option>
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="DC">District Of Columbia</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="clinicZipInput">Zip</label>
                        <input type="text" class="form-control" id="clinicZipInput">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium" id="clinicAddSubmit">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="allMedicalRequestsModal" tabindex="-1" role="dialog" style="overflow-y:hidden;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-lg">
            <div class="modal-header">
                <h5 class="modal-title">All Medical Requests</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="min-height:500px;overflow-y:auto;">
                <div class="form-row">
                    <div class="form-group col-xl-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text all-request-search-icon bg-white"><i class="fa fa-search"></i></span>
                            </div>
                            <input id="requestSearch" class="form-control border-left-0 pl-0" placeholder="Start typing to search requests">
                        </div>
                    </div>
                    <div class="form-group col-xl-4">
                        <div class="dropdown w-100">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-filter mr-1"></i> Filter</span>
                                </div>
                                <button class="btn btn-light form-control border btn-block" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span id="filterTitle">All</span>
                                </button>
                                <div class="dropdown-menu status-dropdown" aria-labelledby="dropdownMenuButton">
                                    <h6 class="dropdown-header">Filter by status</h6>
                                    <a class="dropdown-item" href="#">All</a>
                                    <a class="dropdown-item" href="#">Follow up</a>
                                    <a class="dropdown-item" href="#">Not sent</a>
                                    <a class="dropdown-item " href="#">Sent</a>
                                    <a class="dropdown-item " href="#">Sent for invoice</a>
                                    <a class="dropdown-item" href="#">Not sent for invoice</a>
                                    <a class="dropdown-item" href="#">Void</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group col-xl-2">
                        <button class="btn btn-light border w-100">Export</button>
                    </div>
                </div>
                <div style="max-height:450px;overflow-y:auto;">
                    <div id="applicantRequestsList" class="list-group">

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="statusUpdateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request Status Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="statusRequestId">
                <div class="form-row">
                    <div class="form-group col">
                        <label for="statusSelect">Status</label>
                        <select id="statusSelect" class="form-control">
                            <option value="0">Select a Status</option>
                        </select>
                    </div>
                </div>
                <div id="paidDateGroup" class="form-row d-none">
                    <div class="form-group col">
                        <label for="paidDate">Date</label>
                        <input id="paidDate" class="form-control date-picker">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-vprop-blue-medium" id="statusSubmit" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-basic" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    let date = new Date().toDateString();
    let $applicantTable = $('#applicantTable').DataTable({
        dom: "<\'row\'<\'col-xl-12\'f>>" + "<\'row\'<\'col-xl-12\'tr>>" + "<\'row\'<'col-xl-5 mt-1'B><\'col-xl-7\'p>>",
        ajax: {
            url: '../../Includes/HR/applicantsget.php',
            dataSrc: ""
        },
        pageLength: '10',
        scrollY: '475px',
        buttons: [{extend: 'excel', text: 'Export', title: 'Employees Export ' + date}],
        columns: [
            {data: "id"},
            {data: "first_name"},
            {data: "last_name"},
            {data: "create_date"},
            {data: "create_user_id", visible: false},
            {data: "username"},
            {
                data: 'hr_status_code_text'
            },
            {
                data: null, render: function (data, type, row, meta) {
                    return '<div class="dropdown dropleft">' +
                        '<button class="btn btn-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                        '<i class="fa fa-ellipsis-h"></i></button>' +
                        '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
                        '<h6 class="dropdown-header">' + row.first_name + ' ' + row.last_name + '</h6>' +
                        '<a class="dropdown-item applicant-edit" href="#">Edit</a>' +
                        '<a class="dropdown-item applicant-add-request" href="#">Add Request</a>' +
                        '<a class="dropdown-item applicant-details" href="#">View Requests</a>' +
                        '</div>' +
                        '</div>';
                }
            }
        ],
        columnDefs: [
            {sortable: false, targets: [7]},
            {className: 'center-icon', targets: [7]}
        ],
        initComplete: function () {
            $('.dataTables_scrollBody').css('height', 'unset').css('max-height', '500px');
            $("#applicantTable_filter").addClass('float-left');
            $("#applicantTable_paginate").detach().appendTo('#applicantCardFooter').addClass('float-right');
            $(".dt-buttons").detach().appendTo('#applicantCardFooter').addClass('float-left');
            $('#applicantTable').DataTable().columns.adjust();
        }
    });

    window.$global = {
        employeeId: null,
        name: null
    };

    $(function () {
        let $autocomplete = $('#search').autocomplete({
            serviceUrl: '../../Includes/HR/employeeandapplicantsearch.php',
            onSelect: function (suggestion) {
                let self = $(this);
                self.prop('disabled', true).parent().append('<div class="search-feedback feedback-icon" id="searchClose" style="display:block;"><i class="fa fa-times"></i></div></div>');
                $('.request-search-icon').toggleClass('bg-white', 'bg-muted');
                let formData = {};
                $global.employeeId = suggestion.data;
                $global.name = suggestion.value;
                formData['id'] = applicantEmployeeIdDecrypt($global.employeeId);
                $.ajax({
                    url: '../../Includes/HR/employeebyidget.php',
                    type: 'POST',
                    data: JSON.stringify(formData),
                    success: function (response) {
                        let data = JSON.parse(response)[0];
                        console.log(data);
                    }

                });
            }
        });
        let $requestSearch = $('#requestSearch').autocomplete({
            serviceUrl: '../../Includes/HR/employeeandapplicantsearch.php',
            onSelect: function (suggestion) {
                let self = $(this);
                let $requestBody = $('#applicantRequestsList');
                self.prop('disabled', true).parent().append('<div class="search-feedback feedback-icon" id="requestSearchClose" style="display:block;"><i class="fa fa-times"></i></div></div>');
                $('.all-request-search-icon').toggleClass('bg-white', 'bg-muted');
                let formData = {};
                $global.employeeId = suggestion.data;
                $global.name = suggestion.value;
                formData['appEmpCode'] = $global.employeeId;
                $.ajax({
                    url: '../../Includes/HR/request_search.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#filterTitle').text('All');
                        if (parseInt(response) !== 0) {
                            let data = JSON.parse(response);
                            $('#applicantSubmit').toggleClass('d-none', 'd-block');
                            $requestBody.empty();
                            displayMedicalRequests($requestBody, data);
                        } else {
                            $requestBody.empty().append('No medical requests found');
                        }
                    }

                });
            }
        });
        let $settingsModal = $('#settingsModal');
        let $medicalReqModal = $('#medicalRequestModal');
        let $allMedicalReqModal = $('#allMedicalRequestsModal');
        let $applicantDetailsModal = $('#applicantDetailsModal');
        let $allRequestsTable = $('#allRequestsTable');
        let $applicantsTable = $('#applicantTable');
        $('.dob-input').datepicker({
            format: "yyyy-mm-dd",
            disableEntry: true
        });
        $('.date-picker').datepicker({
            format: "yyyy-mm-01",
            viewMode: 'months',
            minViewMode:'months',
            disableEntry: true
        });
        $allMedicalReqModal.on('show.bs.modal', function () {
            let $requestBody = $('#applicantRequestsList');
            $('#filterTitle').text('All');
            $requestBody.text('');
            $requestBody.children().remove();
            allMedicalRequestsGet();
        });
        $medicalReqModal.on('shown.bs.modal', function () {
            let $clinicSelect = $('#requestClinicSelect');
            medicalAuthReasonsGet();
            clinicsPopulate($clinicSelect);
        });
        $('#requestClinicSelect').on('change', function () {
            let $clinicSelect = $('#requestClinicSelect');
            let formData = {};
            formData['clinicId'] = $clinicSelect.val();
            testByClinicGet(formData);
        });
        $medicalReqModal.on('click', '#searchClose', function () {
            allRequestSearchClear();
        });
        $allMedicalReqModal.on('click', '#requestSearchClose', function () {
            $('#applicantRequestsList').empty();
            requestSearchClear();
            allMedicalRequestsGet();
        });
        $('#medicalRequestBtn').on('click', function () {
            $('#search').prop('disabled', false).val('');
            $('#searchClose').remove();
        });
        let $divisionSelect = $('#divisionSelect');
        divisionsGet($divisionSelect);
        applicantStatusesGet();
        $($divisionSelect).on('change', function () {
            let formData = {};
            formData['id'] = $($divisionSelect).val();
            sitesGet($('#siteSelect'), formData);
        });
        $('#applicantSubmit').on('click', function () {
            let firstName = $('#firstNameInput');
            let lastName = $('#lastNameInput');
            let dob = $('#dobInput');
            let phone = $('#phoneInput');
            let division = $('#divisionSelect');
            let site = $('#siteSelect');
            let user = '<?php echo $_SESSION['user_id']; ?>';
            if (division.val() === '0') {
                bsAlert(division, 'danger', 'You select a division!');
                return false;
            }
            if (site.val() === '0') {
                bsAlert(site, 'danger', 'You must select a site!');
                return false;
            }
            if (firstName.val() === '') {
                bsAlert(firstName, 'danger', 'You must enter a first name!');
                return false;
            }
            if (lastName.val() === '') {
                bsAlert(lastName, 'danger', 'You must enter a last name!');
                return false;
            }
            if (dob.val() === '') {
                bsAlert(dob, 'danger', 'You must enter a date of birth!');
                return false;
            }
            if (phone.val() === '') {
                bsAlert(phone, 'danger', 'You must enter a phone number!');
                return false;
            }
            let applicant = new Applicant(firstName.val(), lastName.val(), phone.val(), dob.val(), site.val(), division.val());
            applicantInsert(applicant, '../../Includes/HR/applicant_insert.php', user);

        });
        $applicantsTable.on('click', 'tbody .applicant-details', function () {
            let $requestBody = $('#applicantRequestsBody');
            let tableData = $applicantTable.row($(this).closest('tr')).data();
            let applicantId = tableData.id;
            let formData = {};
            formData['applicantId'] = applicantId;
            $('#applicantDetailsModal').modal('show');
            $requestBody.children().remove();
            medicalRequestsByApplicant(formData);
        });
        $applicantsTable.on('click', 'tbody .applicant-add-request', function () {
            let $search = $('#search');
            let tableData = $applicantTable.row($(this).closest('tr')).data();
            $global.employeeId = '000' + tableData.id;
            $global.name = tableData.first_name + ' ' + tableData.last_name;
            $search.val($global.name);
            $search.prop('disabled', true);
            $('.request-search-icon').toggleClass('bg-white', 'bg-muted');
            $('#medicalRequestModal').modal('toggle');
        });
        $applicantsTable.on('click', 'tbody .applicant-edit', function () {
            let tableData = $applicantTable.row($(this).closest('tr')).data();
            $('#applicantId').val(tableData.id);
            $('#applicantEditModal').modal('toggle');
            let formData = {};
            formData['id'] = tableData.id;
            divisionsGet($('#editDivisionSelect'));
            applicantByIdGet(formData);
        });
        $allMedicalReqModal.on('click', 'div .manage-request', function () {
            $('#allMedicalRequestsModal').modal('toggle');
            let requestId = $(this).find('.request-id').text();
            let formData = {};
            formData['requestId'] = requestId;
            manageRequest(requestId);
        });
        $applicantDetailsModal.on('click', 'div .manage-request', function () {
            $('#applicantDetailsModal').modal('toggle');
            let requestId = $(this).find('.request-id').text();
            let formData = {};
            formData['requestId'] = requestId;
            manageRequest(requestId);
        });
        $('#statusSubmit').on('click', function () {
            let formData = {};
            let $statusSelect = $('#statusSelect');
            formData['requestId'] = $('#statusRequestId').val();
            formData['paidDate'] = $('#paidDate').val();
            formData['statusId'] = $statusSelect.val();
            formData['userId'] = '<?php echo $_SESSION['user_id']; ?>';
            statusUpdate(formData);
        });
        $('#statusSelect').on('change', function() {
            let self = $(this);
            if(self.val() === '3') {
                $('#paidDateGroup').removeClass('d-none');
            } else {
                $('#paidDateGroup').addClass('d-none');
            }
        });
        $('#clinicAddSubmit').on('click', function () {
            let $nameInput = $('#clinicNameInput');
            let $addressInput = $('#clinicAddressInput');
            let $cityInput = $('#clinicCityInput');
            let $stateInput = $('#clinicStateSelect');
            let $zipInput = $('#clinicZipInput');
            let $phoneInput = $('#clinicPhoneInput');
            let $faxInput = $('#clinicFaxInput');
            let $emailInput = $('#clinicEmailInput');
            let formData = {};
            formData['userId'] = '<?php echo $_SESSION['user_id']; ?>';
            if (!$nameInput.val()) {
                return false;
            } else {
                formData['name'] = $nameInput.val();
            }
            if (!$addressInput.val()) {
                return false;
            } else {
                formData['address'] = $addressInput.val();
            }
            if (!$cityInput.val()) {
                return false;
            } else {
                formData['city'] = $cityInput.val();
            }
            if (!$stateInput.val()) {
                return false;
            } else {
                formData['state'] = $stateInput.val();
            }
            if (!$zipInput.val()) {
                return false;
            } else {
                formData['zip'] = $zipInput.val();
            }
            if (!$phoneInput.val()) {
                return false;
            } else {
                formData['phone'] = $phoneInput.val();
            }
            if (!$faxInput.val()) {
                return false;
            } else {
                formData['fax'] = $faxInput.val();
            }
            if (!$emailInput.val()) {
                formData['email'] = 'NA';
            } else {
                formData['email'] = $emailInput.val();
            }
            $.ajax({
                url: '../../Includes/HR/clinicinsert.php',
                data: formData,
                type: 'POST',
                success: function (response) {
                    let $clinicSel = $('#clinicSelect');
                    if (parseInt(response) === 1) {
                        $nameInput.val('');
                        $addressInput.val('');
                        $cityInput.val('');
                        $stateInput.val('');
                        $zipInput.val('');
                        $phoneInput.val('');
                        $faxInput.val('');
                        $emailInput.val('');
                        $('#clinicAddModal').modal('toggle');
                        clinicsPopulate($clinicSel);
                        bsAlert(null, 'success', 'Successfully added clinic!');
                    } else {
                        clinicsPopulate($clinicSel);
                        bsAlert(null, 'danger', 'Error adding clinic!');
                    }
                }
            });
        });
        $('#clinicSelect').on('change', function () {
            let $clinicSelect = $('#clinicSelect');
            let formData = {};
            if ($clinicSelect.val() > 0) {
                formData['clinicId'] = $clinicSelect.val();
                clinicTestRelationshipGet(formData);
                $('#testCheckboxes').show();
            } else {
                $('#testCheckboxes').hide();
            }
        });
        $settingsModal.on('shown.bs.modal', function () {
            let $clinicSelect = $('#clinicSelect');
            clinicsPopulate($clinicSelect);
            clinicTestsGet();
        });
        $settingsModal.on('hidden.bs.modal', function () {
            $('#clinicSelect').val(0);
            $('#testCheckboxes').hide().children().remove();
        });

        $('#settingsSubmit').on('click', function () {
            let checkboxes = $('#testCheckboxes').find('.custom-control-input');
            let formData = {};
            let checkedArray = [];
            let unCheckedArray = [];
            for (let i = 0; i < checkboxes.length; ++i) {
                if (checkboxes[i].checked) {
                    checkedArray.push($(checkboxes[i]).val());
                } else {
                    unCheckedArray.push($(checkboxes[i]).val());
                }
            }
            formData['clinicId'] = $('#clinicSelect').val();
            formData['checkedArray'] = JSON.stringify(checkedArray);
            formData['unCheckedArray'] = JSON.stringify(unCheckedArray);
            $.ajax({
                url: '../../Includes/HR/clinictestrelationshipinsert.php',
                data: formData,
                type: 'POST',
                success: function (response) {
                    let data = JSON.parse(response);
                    bsAlert(null, 'success', 'Setting saved!');
                }
            });
        });
        $('#requestSubmit').on('click', function () {
            let $searchInput = $('#search');
            let $reasonSelect = $('#requestReasons');
            let $testTypeSelect = $('#testTypes');
            let $clinicSelect = $('#requestClinicSelect');
            let employeeId = $global.employeeId;
            let checkboxes = $('#clinicTests').find('.custom-control-input');
            let formData = {};
            let checkedArray = {};

            if (!$searchInput.val()) {
                bsAlert($searchInput, 'danger', 'You must select an employee or applicant!');
                return false;
            } else {
                formData['applicantEmployeeId'] = employeeId;
            }
            if ($reasonSelect.val() === '0') {
                bsAlert($reasonSelect, 'danger', 'You must select a request reason!');
                return false;
            } else {
                formData['reasonId'] = $reasonSelect.val();
            }
            if ($testTypeSelect.val() === '0') {
                bsAlert($reasonSelect, 'danger', 'You must select a test type!');
                return false;
            } else {
                if ($testTypeSelect.val() === '1') {
                    formData['isDot'] = 0;
                } else if ($testTypeSelect.val() === '2') {
                    formData['isDot'] = 1;
                }

            }
            if ($clinicSelect.val() === '0') {
                bsAlert($reasonSelect, 'danger', 'You must select a clinic!');
                return false;
            } else {
                formData['clinicId'] = $clinicSelect.val();
            }
            for (let i = 0; i < checkboxes.length; ++i) {
                if (checkboxes[i].checked) {
                    checkedArray['testId_' + i] = ($(checkboxes[i]).val());
                }
            }
            if (checkedArray.length === 0) {
                bsAlert($reasonSelect, 'danger', 'You must select at least one test to perform!');
                return false;
            } else {
                formData['clinicTestIds'] = JSON.stringify(checkedArray);
            }
            formData['userId'] = '<?php echo $_SESSION['user_id']; ?>';
            medicalRequestSubmit(formData);
        });
        $('.status-dropdown').on('click', 'a', function () {
            if ($('#requestSearch').val() !== "") {
                requestSearchClear();
            }
            let status = $(this).text();
            if (status === 'All') {
                $('#filterTitle').text(status);
                allMedicalRequestsGet();
            } else {
                $('#filterTitle').text(status);
                medicalRequestsByStatusGet(status);
            }

        });
        $('#applicantEditSubmit').on('click', function () {
            let $division = $('#editDivisionSelect');
            let $site = $('#editSiteSelect');
            let $fName = $('#editFirstNameInput');
            let $lName = $('#editLastNameInput');
            let $dob = $('#editDOBInput');
            let $phone = $('#editPhoneInput');
            let $status = $('#editStatusSelect');
            let formData = {};
            formData['id'] = $('#applicantId').val();
            formData['userId'] = '<?php echo $_SESSION['user_id']; ?>';
            if ($division.val() === '') {
                bsAlert($division, 'danger', 'You must select a division');
                return false;
            } else {
                formData['division'] = $division.val();
            }
            if ($site.val() === '') {
                bsAlert($site, 'danger', 'You must select a site!');
                return false;
            } else {
                formData['site'] = $site.val();
            }
            if ($fName.val() === '') {
                bsAlert($fName, 'danger', 'First name cannot be blank!');
                return false;
            } else {
                formData['fName'] = $fName.val();
            }
            if ($lName.val() === '') {
                bsAlert($lName, 'danger', 'Last name cannot be blank!');
                return false;
            } else {
                formData['lName'] = $lName.val();
            }
            if ($dob.val() === '') {
                bsAlert($dob, 'danger', 'Date of birth cannot be blank!');
                return false;
            } else {
                formData['dob'] = $dob.val();
            }
            if ($phone.val() === '') {
                bsAlert($phone, 'danger', 'Phone number cannot be blank!');
                return false;
            } else {
                formData['phone'] = $phone.val();
            }
            if ($status.val() === '0') {
                bsAlert($fName, 'danger', 'You must select a status!');
                return false;
            } else {
                formData['status'] = $status.val();
            }
            applicantUpdate(formData);
        });
    });

    function allMedicalRequestsGet() {
        $.ajax({
            url: '../../Includes/HR/all_medical_requests_get.php',
            dataSrc: '',
            beforeSend: function () {

            },
            success: function (response) {
                let $requestBody = $('#applicantRequestsList');
                $requestBody.empty();
                if (parseInt(response) !== 0) {
                    let data = JSON.parse(response);
                    displayMedicalRequests($requestBody, data);
                } else {
                    $requestBody.append('No medical requests found');

                }
            }
        });
    }

    function allRequestSearchClear() {
        $('#search').prop('disabled', false).val('');
        $('.request-search-icon').toggleClass('bg-white', 'bg-muted');
        $('#searchClose').remove();
    }

    function applicantByIdGet(formData) {
        try {
            $.ajax({
                url: '../../Includes/HR/applicant_by_id_get.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    let data = JSON.parse(response);
                    let siteData = {};
                    let $site = $('#editSiteSelect');
                    $.each(data, function (key, value) {
                        $('#editDivisionSelect').val(value.hr_division_id);
                        siteData['id'] = value.hr_division_id;
                        sitesGet($site, siteData);
                        $site.val(value.hr_site_id);
                        $('#editFirstNameInput').val(value.first_name);
                        $('#editLastNameInput').val(value.last_name);
                        $('#editDOBInput').val(value.dob);
                        $('#editPhoneInput').val(value.phone_number);
                        $('#editStatusSelect').val(value.hr_applicant_status_code_id);
                    });
                }
            });
        } catch (error) {
            return null;
        }

    }

    function applicantEmployeeIdDecrypt(str) {
        return str.substring(3, str.length);
    }

    function applicantInsert(applicant, url, user) {
        $.ajax({
            url: url,
            type: 'POST',
            data: applicant.toFormData(user),
            beforeSend: function () {
                $('.content-wrapper').slideDown().prepend('<div class="alert alert-warning fade show process-status" style="position:absolute; top:7%; right:45%; z-index:999;" role="alert">\n' +
                    '<strong>Processing Applicant</strong><div class="spinner-border spinner-border-sm text-warning ml-2" role="status"></div></div>');
            },
            success: function (response) {
                if (response === '1') {
                    $('#firstNameInput').val('');
                    $('#lastNameInput').val('');
                    $('#dobInput').val('');
                    $('#phoneInput').val('');
                    $('#divisionSelect').val('');
                    $('#siteSelect').val('');
                    $('#applicantModal').modal('hide');
                    $applicantTable.ajax.reload();
                    $('.content-wrapper').find('.process-status').alert('close');
                    bsAlert(null, 'success', 'Applicant saved!');
                } else {
                    $('#applicantModal').modal('hide');
                    $('.content-wrapper').find('.process-status').alert('close');
                    bsAlert(null, 1, 'Error saving applicant!');
                    $applicantTable.ajax.reload();
                }
            }
        });
    }

    function applicantStatusesGet() {
        $.ajax({
            url: '../../Includes/HR/applicant_statuses_get.php',
            dataSrc: '',
            success: function (response) {
                let data = JSON.parse(response);
                $.each(data, function (key, value) {
                    $('#editStatusSelect').append('<option value="' + value.id + '">' + value.description + '</option>');
                });

            }
        });
    }

    function applicantUpdate(formData) {
        console.log(formData);
        try {
            $.ajax({
                url: '../../Includes/HR/applicant_update.php',
                data: formData,
                type: 'POST',
                beforeSend: function () {
                    bsAlert(null, 'processing', 'Updating applicant');
                },
                success: function (response) {
                    if (parseInt(response) === 1) {
                        bsAlert(null, 'success', 'Successfully updated applicant!');
                        $applicantTable.ajax.reload();
                    } else {
                        bsAlert(null, 'danger', 'Error updating applicant!');
                    }
                }
            });
        } catch (error) {
            console.log(error);
            return null;
        }
    }

    function bsAlert(div, status, content) {
        let $content = $('.content-wrapper');
        let $statusAlert = $content.find('.alert-dismissible');
        if ($statusAlert) {
            $statusAlert.remove();
        }
        if (div !== null) {
            div.focus();
        }
        if (status === 'danger') {
            $content.slideDown().prepend('<div class="alert alert-danger alert-dismissible fade show alert-display" role="alert">\n' +
                '  <strong>Error!</strong> ' + content +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                '  </button>\n' +
                '</div>');
            setTimeout(function () {
                $content.find('.alert-danger').alert('close');
            }, 2500);
        } else if (status === 'success') {
            $content.slideDown().prepend('<div class="alert alert-success alert-dismissible fade show alert-display" role="alert">\n' +
                '  <strong>Success!</strong> ' + content +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                '  </button>\n' +
                '</div>');
        }
        else if (status === 'warning') {
            $content.slideDown().prepend('<div class="alert alert-warning alert-dismissible fade show alert-display" role="alert">\n' +
                '  <strong>Success!</strong> ' + content +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                '  </button>\n' +
                '</div>');
        } else if (status === 'processing') {
            $content.slideDown().prepend('<div class="alert alert-warning alert-dismissible fade show alert-display" role="alert">\n' +
                '  <strong class="mr-1">Processing Request</strong>' +
                '<div class="spinner-border spinner-border-sm text-warning ml-1" role="status">\n' +
                '  <span class="sr-only">Loading...</span>\n' +
                '</div>' +
                '</div>');
        }
        setTimeout(function () {
            $content.find('.alert-dismissible').alert('close');
        }, 2500);
    }

    function clinicsPopulate(div) {
        let $clinicSelect = div;
        $clinicSelect.find('option').not(':first').remove();
        $.ajax({
            url: '../../Includes/HR/clinicsget.php',
            dataSrc: '',
            success: function (response) {
                let data = JSON.parse(response);
                $.each(data, function (key, value) {
                    $clinicSelect.append('<option value="' + value.id + '">' + value.name + ' - ' + value.city + ', ' + value.state + '</option>');
                });
            }
        });
    }

    function clinicTestsGet() {
        let $testCheckboxes = $('#testCheckboxes');
        $testCheckboxes.children().remove();
        $.ajax({
            url: '../../Includes/HR/medicaltestsget.php',
            dataSrc: '',
            success: function (response) {
                let data = JSON.parse(response);
                $.each(data, function (key, value) {
                    $testCheckboxes.append('<div class="custom-control custom-checkbox">\n' +
                        '    <input type="checkbox" class="custom-control-input big-checkbox" id="check' + value.id + '" value="' + value.id + '">\n' +
                        '    <label class="custom-control-label" for="check' + value.id + '">' + value.description + '</label>\n' +
                        '  </div>');
                    $testCheckboxes.hide();
                });
            }
        });
    }

    function clinicTestRelationshipGet(formData) {
        $.ajax({
            url: '../../Includes/HR/clinictestrelationshipget.php',
            type: 'POST',
            data: formData,
            beforeSend: function () {
                $('#testCheckboxes').hide();
                $('#testCheckboxesContainer').append('<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');
            },
            success: function (response) {
                $('#testCheckboxesContainer').find('.spinner-border').remove();
                $('#testCheckboxes').show();
                $(':checkbox').prop('checked', false);
                let data = JSON.parse(response);
                $.each(data, function (key, value) {
                    $('#check' + value.hr_lab_test_id).prop('checked', 'checked');
                });
            }
        });
    }

    function displayMedicalRequests(div, data) {
        $.each(data, function (key, value) {
            let personalData = JSON.parse(value.personalData)[0];
            let tests = JSON.parse(value.clinicTests);
            let status = parseInt(value.statusCodeId);
            let statusClass = statusDisplay(status);
            let testList = [];
            $.each(tests, function (key, value) {
                testList.push(value);
            });
            if (status !== 1) {
                if(status === 3) {
                    let paidDate = new Date(value.paidDate);
                    div.append('' +
                        '<a href="#" class="list-group-item list-group-item-action manage-request">' +
                        '<div class="d-flex w-100 justify-content-between">' +
                        '<h5 class="mb-1">' + personalData.first_name + ' ' + personalData.last_name + '<span class="request-id d-none">' + value.requestId + '</span></h5>' +
                        '<small>Updated ' + moment(value.modifyDate).fromNow() + '</small>' +
                        '</div>' +
                        '<p class="mb-1">' + testList + '<span class="badge ' + statusClass + ' float-right">' + value.statusCodeText + ' ' + ((paidDate.toLocaleString('en-us', { month: 'long' })) + ' ' + paidDate.getFullYear()) + '</span></p>' +
                        '<p class="mb-1">' + value.clinicName + ' <small><span class="float-right">' + value.clinicCity + ', ' + value.clinicState + '</span></small></p>' +
                        '</a>');
                } else {
                    div.append('' +
                        '<a href="#" class="list-group-item list-group-item-action manage-request">' +
                        '<div class="d-flex w-100 justify-content-between">' +
                        '<h5 class="mb-1">' + personalData.first_name + ' ' + personalData.last_name + '<span class="request-id d-none">' + value.requestId + '</span></h5>' +
                        '<small>Updated ' + moment(value.modifyDate).fromNow() + '</small>' +
                        '</div>' +
                        '<p class="mb-1">' + testList + '<span class="badge ' + statusClass + ' float-right">' + value.statusCodeText + '</span></p>' +
                        '<p class="mb-1">' + value.clinicName + ' <small><span class="float-right">' + value.clinicCity + ', ' + value.clinicState + '</span></small></p>' +
                        '</a>');
                }

            } else {
                div.append('<a href="#" class="list-group-item list-group-item-action manage-request">' +
                    '<div class="d-flex w-100 justify-content-between">' +
                    '<h5 class="mb-1">' + personalData.first_name + ' ' + personalData.last_name + '<span class="request-id d-none">' + value.requestId + '</span></h5>' +
                    '<small>Updated ' + moment(value.modifyDate).fromNow() + '</small>' +
                    '</div>' +
                    '<p class="mb-1">' + testList + '<span class="badge ' + statusClass + ' float-right">' + value.statusCodeText + '</span></p>' +
                    '<p class="mb-1">' + value.clinicName + ' <small><span class="float-right">' + value.clinicCity + ', ' + value.clinicState + '</span></small></p>' +
                    '</a>');
            }

        });
    }

    function manageRequest(requestId) {
        let formData = {};
        formData['requestId'] = requestId;
        $.ajax({
            url: '../../Includes/HR/medical_request_by_id.php',
            data: formData,
            type: 'POST',
            success: function (response) {
                let data = JSON.parse(response)[0];
                if (data.status_code_id !== '1') {
                    $.confirm({
                        title: 'Medical Request #' + requestId,
                        theme: 'bootstrap',
                        content: '<div class="form-row"><div class="form-group">What would you like to do?</div></div>',
                        buttons: {
                            preview: {
                                text: 'Preview <i class="fa fa-eye text-white"></i>',
                                btnClass: 'btn btn-vprop-blue-medium',
                                action: function () {
                                    $.ajax({
                                        url: '../../Includes/HR/medical_auth_file_get.php',
                                        data: formData,
                                        type: 'POST',
                                        success: function (response) {
                                            let data = JSON.parse(response)[0].file_path;
                                            $.confirm({
                                                title: 'Medical Authorization',
                                                theme: 'supervan',
                                                columnClass: 'col-xl-12',
                                                content: '<object data="' + data + '" type="application/pdf" width="100%" height="100%"><iframe src="' + data + '" width="100%" height="100%" style="border: none;">This browser does not support PDFs. Please download the PDF to view it: <a href="' + response + '">Download PDF</a> </iframe> </object>',
                                                buttons: {
                                                    close: {
                                                        text: 'Close'
                                                    }
                                                }
                                            });
                                        }
                                    });

                                }
                            },
                            sendToLab: {
                                text: 'Resend to Lab <i class="fa fa-paper-plane"></i>',
                                btnClass: 'btn btn-warning text-white',
                                action: function () {
                                    $.ajax({
                                        url: '../../Includes/HR/applicant_employee_check_by_request_id.php',
                                        data: formData,
                                        type: 'POST',
                                        success: function (response) {
                                            let data = JSON.parse(response);
                                            if (data.type === 0) {
                                                $.confirm({
                                                    title: 'Send to Lab',
                                                    content: '<div class="form-row w-75 ml-4"><div class="form-group col-xl-12">' +
                                                    '<label>Enter SSN</label>' +
                                                    '<input type="text" placeholder="SSN" id="requestSsnInput" class="form-control">' +
                                                    '</div></div>',
                                                    buttons: {
                                                        submit: function () {
                                                            let submitData = {};
                                                            submitData['ssn'] = $('#requestSsnInput').val();
                                                            submitData['requestId'] = requestId;
                                                            submitData['userId'] = '<?php echo $_SESSION['user_id']; ?>';
                                                            medicalAuthSend(submitData);
                                                        },
                                                        close: function () {

                                                        }
                                                    }
                                                });
                                            } else if (data.type === 1) {
                                                $.confirm({
                                                    title: 'Send to Lab',
                                                    content: '<div class="form-row w-75 ml-4">' +
                                                    '<div class="form-group col-xl-12">' +
                                                    '<label>SSN</label>' +
                                                    '<input type="text" placeholder="SSN" id="requestSsnInput" class="form-control">' +
                                                    '</div>' +
                                                    '</div>' +
                                                    '<div class="form-row w-75 ml-4">' +
                                                    '<div class="form-group col-xl-12">' +
                                                    '<label>Date of birth</label>' +
                                                    '<input type="text" placeholder="Example 01-01-2019" id="requestDobInput" class="form-control dob-input">' +
                                                    '</div>' +
                                                    '</div>' +
                                                    '<div class="form-row w-75 ml-4">' +
                                                    '<div class="form-group col-xl-12">' +
                                                    '<label>Phone Number</label>' +
                                                    '<input type="text" placeholder="Enter phone number" id="requestPhoneInput" class="form-control dob-input">' +
                                                    '</div>' +
                                                    '</div>',
                                                    buttons: {
                                                        submit: function () {
                                                            let submitData = {};
                                                            submitData['ssn'] = $('#requestSsnInput').val();
                                                            submitData['userId'] = '<?php echo $_SESSION['user_id']; ?>';
                                                            submitData['phone'] = $('#requestPhoneInput').val();
                                                            submitData['dob'] = $('#requestDobInput').val();
                                                            submitData['requestId'] = requestId;
                                                            medicalAuthSend(submitData);
                                                        },
                                                        close: function () {

                                                        }
                                                    }
                                                });
                                            }

                                        }
                                    });

                                }
                            },
                            updateStatus: {
                                text: 'Update Status <i class="fa fa-edit text-white"></i>',
                                btnClass: 'btn btn-vprop-green',
                                action: function () {
                                    $('#statusRequestId').val(requestId);
                                    $('#statusUpdateModal').modal('toggle');
                                    statusPopulate(formData);
                                }
                            },
                            close: {
                                text: 'Close'
                            }
                        }
                    });
                } else {
                    $.confirm({
                        title: 'Medical Request #' + requestId,
                        theme: 'bootstrap',
                        content: '<div class="form-row"><div class="form-group">What would you like to do?</div></div>',
                        buttons: {
                            preview: {
                                text: 'Preview <i class="fa fa-eye text-white"></i>',
                                btnClass: 'btn btn-vprop-blue-medium',
                                action: function () {
                                    $.ajax({
                                        url: '../../Includes/HR/medical_auth_file_get.php',
                                        data: formData,
                                        type: 'POST',
                                        success: function (response) {
                                            let data = JSON.parse(response)[0].file_path;
                                            $.confirm({
                                                title: 'Medical Authorization',
                                                theme: 'supervan',
                                                columnClass: 'col-xl-12',
                                                content: '<object data="' + data + '" type="application/pdf" width="100%" height="100%"><iframe src="' + data + '" width="100%" height="100%" style="border: none;">This browser does not support PDFs. Please download the PDF to view it: <a href="' + response + '">Download PDF</a> </iframe> </object>',
                                                buttons: {
                                                    close: {
                                                        text: 'Close'
                                                    }
                                                }
                                            });
                                        }
                                    });

                                }
                            },
                            sendToLab: {
                                text: 'Send to Lab <i class="fa fa-paper-plane text-white"></i>',
                                btnClass: 'btn btn-vprop-green',
                                action: function () {
                                    $.ajax({
                                        url: '../../Includes/HR/applicant_employee_check_by_request_id.php',
                                        data: formData,
                                        type: 'POST',
                                        success: function (response) {
                                            let data = JSON.parse(response);
                                            if (data.type === 0) {
                                                $.confirm({
                                                    title: 'Send to Lab',
                                                    content: '<div class="form-row w-75 ml-4"><div class="form-group col-xl-12">' +
                                                    '<label>Enter SSN</label>' +
                                                    '<input type="text" placeholder="SSN" id="requestSsnInput" class="form-control">' +
                                                    '</div></div>',
                                                    buttons: {
                                                        submit: function () {
                                                            let submitData = {};
                                                            submitData['ssn'] = $('#requestSsnInput').val();
                                                            submitData['requestId'] = requestId;
                                                            submitData['userId'] = '<?php echo $_SESSION['user_id']; ?>';
                                                            medicalAuthSend(submitData);
                                                        },
                                                        close: function () {

                                                        }
                                                    }
                                                });
                                            } else if (data.type === 1) {
                                                $.confirm({
                                                    title: 'Send to Lab',
                                                    content: '<div class="form-row w-75 ml-4">' +
                                                    '<div class="form-group col-xl-12">' +
                                                    '<label>SSN</label>' +
                                                    '<input type="text" placeholder="SSN" id="requestSsnInput" class="form-control">' +
                                                    '</div>' +
                                                    '</div>' +
                                                    '<div class="form-row w-75 ml-4">' +
                                                    '<div class="form-group col-xl-12">' +
                                                    '<label>Date of birth</label>' +
                                                    '<input type="text" placeholder="Example 01-01-2019" id="requestDobInput" class="form-control dob-input">' +
                                                    '</div>' +
                                                    '</div>' +
                                                    '<div class="form-row w-75 ml-4">' +
                                                    '<div class="form-group col-xl-12">' +
                                                    '<label>Phone Number</label>' +
                                                    '<input type="text" placeholder="Enter phone number" id="requestPhoneInput" class="form-control dob-input">' +
                                                    '</div>' +
                                                    '</div>',
                                                    buttons: {
                                                        submit: function () {
                                                            let submitData = {};
                                                            submitData['ssn'] = $('#requestSsnInput').val();
                                                            submitData['userId'] = '<?php echo $_SESSION['user_id']; ?>';
                                                            submitData['phone'] = $('#requestPhoneInput').val();
                                                            submitData['dob'] = $('#requestDobInput').val();
                                                            submitData['requestId'] = requestId;
                                                            medicalAuthSend(submitData);
                                                        },
                                                        close: function () {

                                                        }
                                                    }
                                                });
                                            }

                                        }
                                    });

                                }
                            },
                            close: {
                                text: 'Close'
                            }
                        }
                    });
                }
            }
        });

    }

    function medicalAuthReasonsGet() {
        let $reasonSelect = $('#requestReasons');
        $.ajax({
            url: '../../Includes/HR/medical_auth_reasons_get.php',
            dataSrc: '',
            beforeSend: function () {
                $reasonSelect.find('option').not(':first').remove();
            },
            success: function (response) {
                let data = JSON.parse(response);
                $.each(data, function (key, value) {
                    $reasonSelect.append('<option value="' + value.id + '">' + value.description + '</option>');
                });
            }
        });
    }

    function medicalAuthSend(submitData) {
        $.ajax({
            url: '../../Includes/HR/medical_auth_send.php',
            data: submitData,
            type: 'POST',
            beforeSend: function () {
                bsAlert(null, 'processing', null);
            },
            success: function (response) {
                if (parseInt(response) === 1) {
                    if ($('.content-wrapper').find('.alert-dismissible')) {
                        $('.content-wrapper').find('.alert-dismissible').remove();
                    }
                    bsAlert(null, 'success', 'Sent medical request!');
                }
            }
        });
    }

    function medicalRequestsByApplicant(formData) {
        $.ajax({
            url: '../../Includes/HR/applicant_medical_requests_by_id_get.php',
            data: formData,
            type: 'POST',
            beforeSend: function () {

            },
            success: function (response) {
                let data = JSON.parse(response);
                let $requestBody = $('#applicantRequestsBody');
                $requestBody.empty();
                if (parseInt(response) !== 0) {
                    displayMedicalRequests($requestBody, data);
                } else {
                    $requestBody.append('No medical requests found');

                }

            }
        });
    }

    function medicalRequestsByStatusGet(status) {
        let formData = {};
        formData['status'] = status;
        $.ajax({
            url: '../../Includes/HR/all_medical_requests_by_status_get.php',
            type: 'POST',
            data: formData,
            beforeSend: function () {

            },
            success: function (response) {
                let $requestBody = $('#applicantRequestsList');
                $requestBody.empty();
                if (parseInt(response) !== 0) {
                    let data = JSON.parse(response);
                    displayMedicalRequests($requestBody, data);
                } else {
                    $requestBody.append('No medical requests found');

                }
            }
        });
    }

    function medicalRequestSubmit(formData) {
        $.ajax({
            url: '../../Includes/HR/medical_request_submit.php',
            data: formData,
            type: 'POST',
            beforeSend: function () {
                bsAlert(null, 'processing', null);
            },
            success: function (response) {
                let data = JSON.parse(response);
                if (data.authResult !== '') {
                    let id = JSON.parse(data.authResult)[0].id;
                    $('.content-wrapper').find('.alert-dismissible').remove();
                    $('#medicalRequestModal').modal('toggle');
                    bsAlert(null, 'success', 'Saved Request #' + id);
                    let createFormData = {};
                    createFormData['requestId'] = id;
                    $.ajax({
                        url: '../../Includes/HR/medical_auth_create.php',
                        data: createFormData,
                        type: 'POST',
                        beforeSend: function () {
                            bsAlert(null, 'processing', null);
                        },
                        success: function (response) {
                            console.log(response);
                        }
                    });
                }
            },

        });

    }

    function requestSearchClear() {
        $('#requestSearch').prop('disabled', false).val('');
        $('.all-request-search-icon').toggleClass('bg-white', 'bg-muted');
        $('#requestSearchClose').remove();
    }

    function statusDisplay(status) {
        let statusClass = '';
        if (status === 1) {
            statusClass = 'badge-warning text-white'
        }
        else if (status === 2) {
            statusClass = 'badge-info'
        }
        else if (status === 3) {
            statusClass = 'badge-success text-white'
        }
        else if (status === 4) {
            statusClass = 'badge-danger'
        }
        return statusClass;
    }

    function statusPopulate(formData) {
        $.ajax({
            url: '../../Includes/HR/request_status_get.php',
            dataSrc: '',
            success: function (response) {
                $('#paidDateGroup').addClass('d-none');
                let data = JSON.parse(response);
                let $statusSelect = $('#statusSelect');
                let $modal = $('#statusUpdateModal');
                let $submit = $('#statusSubmit');
                $statusSelect.find('option').not(':first').remove();
                $.each(data, function (key, value) {
                    $statusSelect.append('<option value="' + value.id + '">' + value.description + '</option>');
                });
                $.ajax({
                    url: '../../Includes/HR/request_status_by_id_get.php',
                    data: formData,
                    type: 'POST',
                    success: function (response) {
                        $modal.find('.modal-body').find('.status-alert').remove();
                        $statusSelect.show();
                        $statusSelect.parent().find('label').show();
                        $submit.show();
                        let data = JSON.parse(response)[0];
                        let status = data.status_code_id;
                        if (status !== '1') {
                            if (status !== '2') {
                                $statusSelect.val(status);
                            } else {
                                $statusSelect.val(0);
                            }
                        } else {
                            $statusSelect.hide();
                            $statusSelect.parent().find('label').hide();
                            $submit.hide();
                            $modal.find('.modal-body').append('<br> <span class="status-alert">Request must be sent to lab before status can be updated.</span>');
                        }


                    }
                });
            }
        });
    }

    function statusUpdate(formData) {
        $.ajax({
            url: '../../Includes/HR/medical_request_status_update.php',
            data: formData,
            type: 'POST',
            success: function (response) {
                console.log(response);
            }
        });
    }

    function testByClinicGet(formData) {
        $.ajax({
            url: '../../Includes/HR/tests_by_clinic_get.php',
            type: 'POST',
            data: formData,
            beforeSend: function () {
                let $clinicTests = $('#clinicTests');
                $clinicTests.children().remove();
            },
            success: function (response) {
                let $clinicTests = $('#clinicTests');
                let data = JSON.parse(response);
                $.each(data, function (key, value) {
                    $clinicTests.append('<div class="custom-control custom-checkbox">\n' +
                        '    <input type="checkbox" class="custom-control-input big-checkbox" id="check' + value.id + '" value="' + value.id + '">\n' +
                        '    <label class="custom-control-label" for="check' + value.id + '">' + value.description + '</label>\n' +
                        '  </div>');
                });
            }
        });
    }
</script>

