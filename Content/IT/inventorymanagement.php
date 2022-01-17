<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 9/17/2018
 * Time: 10:23 AM
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

    .modal-open {
        overflow-y: hidden !important;

    }

    .modal-open .modal {
        overflow-x: hidden;
        overflow-y: hidden;
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
        max-height: unset !important;
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

</style>
<!--</editor-fold>-->

<input type="hidden" id="user_id" value="<?php echo $_SESSION['user_id']; ?>">

<div class="container-fluid">
    <div class="card text-center mt-3">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" role="tablist" id="card-tab">
                <li class="nav-item">
                    <a class="nav-link active" role="tab" data-toggle="tab" id="inventory-tab" href="#inventory">Inventory</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" role="tab" data-toggle="tab" id="outgoing-tab" href="#outgoing">Outgoing <span class="badge badge-danger task-alert rounded-circle" style="position: relative;bottom: 8px;right: 6px;"></span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="reports" role="button" data-toggle="dropdown">Reports</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" role="tab" data-toggle="tab" href="#assign-log">Assigned</a>
                        <a class="dropdown-item" role="tab" data-toggle="tab" href="#discharge-log">Discharges</a>
                        <a class="dropdown-item" role="tab" data-toggle="tab" href="#purchase-log">Purchases</a>
                    </div>

                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="card-tab-content">
                <div class="tab-pane fade show active" id="inventory" role="tabpanel">
                    <div class="card " id="inventory-card">
                        <div class="card-header" id="inventory-card-header">
                            <div class="float-right">
                                <button class="btn btn-vprop-blue-light ml-1" style="height:38px;" type="button" id="add-inventory-btn" data-toggle="modal" data-target="#inventory-add-modal"><i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="Add item to inventory"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div style="text-align:center;">
                                <div class="loader" id="inventory-loader" style="display:inline-block;"><img src="..\..\Images\vprop_logo_navbar.gif" style='width:55%;'/><span class="text-align-center">Processing</span></div>
                            </div>
                            <div class="table-responsive hide" id="inventory-table-wrapper">
                                <table class="table table-xl table-bordered  nowrap" id="inventory-table">
                                    <thead class="th-vprop-blue-medium">
                                    <tr>
                                        <th>ID</th>
                                        <th>Division ID</th>
                                        <th>Division</th>
                                        <th>Site ID</th>
                                        <th>Site</th>
                                        <th>Type</th>
                                        <th>Make ID</th>
                                        <th>Make</th>
                                        <th>Description</th>
                                        <th>Part #</th>
                                        <th>Details</th>
                                        <th>Added By</th>
                                        <th>Date</th>
                                        <th>Assigned To</th>
                                        <th>Edit</th>
                                        <th>Remove</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer" id="inventory-card-footer">
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="outgoing" role="tabpanel">
                    <div class="card">
                        <div class="card-header" id="outgoing-card-header">
                            <?php
                            if ($userPermissionsArray['vista']['granbury']['it'] >= 1) {
                                echo '
<button class="btn btn-vprop-blue-light ml-1 float-right" style="height:38px;" type="button" id="add-request-btn" data-toggle="modal" data-target="#request-add-modal">
<i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="Add request"></i></button>';
                            }
                            ?>
                        </div>
                        <div class="card-body" id="outgoing-card-body">
                            <div style="text-align:center;">
                                <div class="loader" id="outgoing-loader" style="display:inline-block;"><img src="..\..\Images\vprop_logo_navbar.gif" style='width:55%;'/><span class="text-align-center">Processing</span></div>
                            </div>
                            <div class="table-responsive hide" id="outgoing-table-wrapper">
                                <table id="outgoing-table" class="table table-xl table-bordered">
                                    <thead class="th-vprop-blue-medium">
                                    <tr>
                                        <th>Request ID</th>
                                        <th>Division</th>
                                        <th>Location</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Type</th>
                                        <th>Timestamp</th>
                                        <th>Approval Status</th>
                                        <th>Completion Status</th>
                                        <th>Kace #</th>
                                        <?php if ($userPermissionsArray['vista']['granbury']['it'] >= 4) {
                                            echo '<th>Legal</th>';
                                            echo '<th>Manage</th>';
                                        } ?>
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>
                        <div class="card-footer" id="outgoing-card-footer">

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="assign-log" role="tabpanel">
                    <div class="card">
                        <div id="assign-log-card-header" class="card-header">

                        </div>
                        <div class="card-body">
                            <div style="text-align:center;">
                                <div class="loader" id="assign-log-loader" style="display:inline-block;"><img src="..\..\Images\vprop_logo_navbar.gif" style='width:55%;'/><span class="text-align-center">Processing</span></div>
                            </div>
                            <div class="table-responsive hide" id="assign-log-table-wrapper">
                                <table id="assign-log-table" class="table table-bordered table-xl nowrap">
                                    <thead class="th-vprop-blue-medium">
                                    <tr>
                                        <th>Type</th>
                                        <th>Serial</th>
                                        <th>Description</th>
                                        <th>Employee</th>
                                        <th>In</th>
                                        <th>Out</th>
                                        <th>Date Added</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="assign-log-card-footer" class="card-footer">

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="discharge-log" role="tabpanel">
                    <div class="card">
                        <div id="discharge-log-card-header" class="card-header">
                        </div>
                        <div class="card-body">
                            <div style="text-align:center;">
                                <div class="loader" id="discharge-log-loader" style="display:inline-block;"><img src="..\..\Images\vprop_logo_navbar.gif" style='width:55%;'/><span class="text-align-center">Processing</span></div>
                            </div>
                            <div class="table-responsive hide" id="discharge-log-table-wrapper">
                                <table id="discharge-log-table" class="table table-bordered table-xl nowrap">
                                    <thead class="th-vprop-blue-medium">
                                    <tr>
                                        <th>Type</th>
                                        <th>Serial</th>
                                        <th>Reason</th>
                                        <th>Discharged By</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div id="discharge-log-card-footer" class="card-footer">

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="purchase-log" role="tabpanel">
                    <div class="card">
                        <div id="purchase-log-card-header" class="card-header">
                        </div>
                        <div class="card-body">
                            <div style="text-align:center;">
                                <div class="loader" id="purchase-log-loader" style="display:inline-block;"><img src="..\..\Images\vprop_logo_navbar.gif" style='width:55%;'/><span class="text-align-center">Processing</span></div>
                            </div>
                            <div class="table-responsive hide" id="purchase-log-table-wrapper">
                                <table id="purchase-log-table" class="table table-bordered table-xl  nowrap">
                                    <thead class="th-vprop-blue-medium">
                                    <tr>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Serial</th>
                                        <th>Date Added</th>
                                        <th>Cost</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <td class="bg-light"></td>
                                        <td class="bg-light"></td>
                                        <td class="bg-light"></td>
                                        <td>Total</td>
                                        <td id="total"></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div id="purchase-log-card-footer" class="card-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="inventory-add-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inventory-add-modal-title">Add Asset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="inventory-add-form">
                    <div class="form-row">
                        <div class="form-group col-xl-12">
                            <select class="form-control device-select" id="business-unit-select" title="Business Unit">
                                <option value="0" selected>Select Business Unit</option>
                            </select>
                        </div>
                        <div class="form-group col-xl-12">
                            <select class="form-control device-select" id="site-select" title="Site">
                                <option value="0" selected>Select Site</option>
                            </select>
                        </div>
                        <div class="form-group col-xl-12">
                            <select class="form-control device-select" id="inventory-type-select" title="Device Type">
                                <option value="0" selected>Select device type</option>
                            </select>
                        </div>
                        <div class="form-group col-xl-12">
                            <select class="form-control make-select" id="inventory-make-select" title="Device Make">
                                <option value="0" selected>Select device make</option>
                            </select>
                        </div>
                        <div class="form-group col-xl-12">
                            <input type="text" class="form-control" id="inventory-serial-input" placeholder="Part number/serial number">
                        </div>
                        <div class="form-group col-xl-12 hide" id="phone-details">
                            <input type="text" class="form-control" id="inventory-phone-input" placeholder="Phone number">
                        </div>
                        <div class="form-group col-xl-12 hide" id="monitor-details">
                            <select title="Monitor Size" class="form-control" id="monitor-size-select">
                                <option value="0">Select a size</option>
                                <option value="22">22 inches</option>
                                <option value="23">23 inches</option>
                                <option value="24">24 inches</option>
                                <option value="27">27 inches</option>
                                <option value="32">32 inches</option>
                            </select>
                        </div>
                        <div class="form-group col-xl-12" id="inventory-description">
                            <input type="text" class="form-control" id="inventory-description-input" placeholder="Description">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal" id="inventory-add-close">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium add-submit" id="inventory-add-submit">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-assign-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-assign-modal-title">Asset Allocation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inventory-id">
                <div class="form-group col-xl-12">
                    <select class="form-control" id="edit-assign-action-select" title="Actions">
                        <option value="0">Select an action</option>
                        <option value="1">Remove asset from employee</option>
                        <option value="2">Remove asset from employee and inventory</option>
                    </select>
                </div>
                <div class="form-group col-xl-12">
                    <input class="form-control " id="discharge-note" type="text" placeholder="Discharge Reason">
                    <p class="muted " id="discharge-feedback">This action cannot be undone.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal" id="edit-assign-close">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium edit-assign-submit" id="edit-assign-submit">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="device-info-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="device-info-modal-title">Device Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-xl-12">
                        <label for="device-serial">Serial</label>
                        <input id="device-serial" class="form-control" disabled>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="device-description">Description</label>
                        <input id="device-description" class="form-control" disabled>
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="device-date">Date added to inventory</label>
                        <input id="device-date" class="form-control" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-phone-number-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Phone Number</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-xl-12">
                        <label for="edit-phone-number">Phone Number</label>
                        <input type="text" id="edit-phone-number" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal" id="edit-phone-number-close">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium edit-phone-number-submit" id="edit-phone-number-submit">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="request-add-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-xl-12">
                        <label for="name-search">Employee</label>
                        <input id="name-search" class="form-control" placeholder="Begin typing to search for employee">
                    </div>
                    <div class="form-group col-xl-12">
                        <label for="request-type">Type</label>
                        <select class="form-control" id="request-type"></select>
                        <script>

                            $.ajax({
                                url: '../../Includes/IT/assettypesget.php',
                                dataSrc: '',
                                success: function (response) {
                                    let data = JSON.parse(response);
                                    $.each(data, function (key, value) {
                                        $('#request-type').append('<option value="' + value.id + '">' + value.type + '</option>');
                                    });
                                }
                            });

                        </script>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal" id="request-add-close">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium  hide" id="request-add-submit">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="inventoryEditModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editInventoryId">
                <label for="editDivisionSelect">Division</label>
                <select id="editDivisionSelect" class="form-control">
                </select>
                <label for="editSiteSelect">Site</label>
                <select id="editSiteSelect" class="form-control">
                    <option>Select a Site</option>
                </select>
                <label for="editTypeSelect">Type</label>
                <select id="editTypeSelect" class="form-control">
                    <option>Select a Type</option>
                </select>
                <label for="editMakeSelect">Make</label>
                <select id="editMakeSelect" class="form-control">
                    <option>Select a Make</option>
                </select>
                <label for="editDescriptionInput">Description</label>
                <input class="form-control" id="editDescriptionInput">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal" id="editEntryClose">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium  hide" id="editEntrySubmit">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ackUploadModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Acknowledgement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="uploadRequestId">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Upload</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="fileUpload">
                        <label class="custom-file-label" for="fileUpload">Choose file</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-basic" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium" id="uploadSubmit">Submit</button>
            </div>
        </div>
    </div>
</div>


<script>
    let date = new Date().toDateString();
    window.$global = {
        inventory_id: null,
        employee_id: null,
        first_name: null,
        last_name: null
    };

    $(function () {
        $('body').tooltip({selector: '[data-toggle="tooltip"]'});
        $('#discharge-note').hide();
        $('#discharge-feedback').hide();
        businessUnitsGet('#business-unit-select');
        let outgoingTable = $('#outgoing-table').DataTable({
            dom: 'Bfrtip',
            ajax: {
                url: '../../Includes/IT/requestsget.php',
                dataSrc: ""
            },
            scrollY: '500px',
            pageLength: '50',
            scrollX: true,
            order: [0, 'desc'],
            columns: [
                {data: "id"},
                {data: "division"},
                {data: "site"},
                {data: "first_name"},
                {data: "last_name"},
                {data: "type"},
                {
                    data: "approved_date", render: function (data) {
                        if (data === null) {
                            return 'Pending Approval';
                        }
                        else {
                            return data;
                        }
                    }
                },
                {
                    data: "is_approved", render: function (data) {
                        if (data === '1') {
                            return 'Approved';
                        }
                        else if (data === '0') {
                            return 'Denied';
                        }
                        else if (data === null) {
                            return 'Pending Approval';
                        }
                    }
                },
                {
                    data: "is_complete", render: function (data, type, row, meta) {
                        if (data === '1') {
                            return 'Completed';
                        }
                        else if (data === '0') {
                            if (row.is_approved === '1') {
                                return '<?php if ($userPermissionsArray['vista']['granbury']['it'] >= 1) {
                                    echo '<span class="">Pending</span>';
                                } else {
                                    echo '<span class="">Pending</span>';
                                }?>';
                            } else {
                                return '<span class="">Pending Approval</span>';
                            }
                        }
                    }
                },
                {
                    data: 'kace_ticket', render: function (data) {
                        if (data !== null) {
                            return '<a class="link" target="_blank" href="http://kbox.maalt.com/userui/ticket.php?ID=' + data + '">' + data + '</a>';
                        } else {
                            return 'Incomplete';
                        }
                    }
                },
                {
                    data: null, render: function (data, type, row, meta) {
                        if (row.is_complete === "1") {
                            if (row.signed_id !== null) {
                                return '<span class="text-success">Signed</span>';
                            } else if (row.signed_id === null) {
                                return '<span class="text-danger">Not signed</span>';
                            }
                        } else {
                            return '<span>Not complete</span>';
                        }
                    }, sortable: true
                },
                {
                    data: null, render: function (data, type, row, meta) {
                        let dHeader;
                        let dItems;
                        if (row.is_auto === '1') {
                            dHeader = '<h6 class="dropdown-header">System Generated</h6>';
                            if (row.is_complete !== '1') {
                                dItems = '<a class="dropdown-item pending-approval" href="#">Complete</a>';
                            } else {
                                if (row.signed_id !== null) {
                                    dItems = '<a class="dropdown-item print-acknowledgement" href="#">View Acknowledgement</a>';
                                } else {
                                    dItems = '<a class="dropdown-item print-acknowledgement" href="#">Sign Acknowledgement</a>';
                                }

                            }
                        } else {
                            dHeader = '<h6 class="dropdown-header">Manual Request</h6>';
                            if (row.is_complete !== '1') {
                                dItems = '<a class="dropdown-item pending-approval" href="#">Complete</a>' + '<a class="dropdown-item remove-request" href="#">Remove</a>';
                            } else {
                                if (row.signed_id !== null) {
                                    dItems = '<a class="dropdown-item print-acknowledgement" href="#">View Acknowledgement</a>';
                                } else {
                                    dItems = '<a class="dropdown-item print-acknowledgement" href="#">Sign Acknowledgement</a>';
                                }

                            }

                        }
                        return '<div class="dropdown dropleft">' +
                            '<button class="btn btn-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '<i class="fa fa-ellipsis-h"></i></button>' +
                            '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
                            dHeader +
                            dItems +
                            '</div></div>';
                    }, sortable: false
                },
                {
                    data: 'is_auto', visible: false
                }
            ],
            buttons: [{extend: 'excel', text: 'Export', className: 'outgoing-export', title: 'Outgoing Requests Export ' + date}],
            initComplete: function () {
                $('#outgoing-loader').remove();
                $('#outgoing-table-wrapper').show();
                $("#outgoing-table_length").remove();
                $("#outgoing-table_filter").detach().appendTo('#outgoing-card-header').addClass('form-inline float-left');
                $("#outgoing-table_paginate").detach().appendTo('#outgoing-card-footer').addClass('float-right');
                $("#outgoing-table_info").detach().appendTo('#outgoing-card-footer').addClass('float-left');
                $(".outgoing-export").detach().appendTo('#outgoing-card-header').removeClass().addClass('btn btn-vprop-green form-inline float-right');
                $('#outgoing-table').DataTable().columns.adjust();
                $('#outgoing-table').css('width', '100%');
                $('.dataTables_scrollBody').css("height", "unset")
                    .css("max-height", "500px");
            }
        }).rows(function (idx, data, node) {
            return data[5] === '0'
        }).remove();

        let inventoryTable = $('#inventory-table').DataTable({
            dom: "<\'row\'<\'col-xl-12\'Bf>>" + "<\'row\'<\'col-xl-12\'tr>>" + "<\'row\'<\'col-xl-5\'i><\'col-xl-7\'p>>",
            ajax: {
                url: '../../Includes/IT/inventoryget.php',
                dataSrc: ""
            },
            scrollY: '500px',
            scrollX: true,
            pageLength: '50',
            autoWidth: true,
            buttons: [{extend: 'excel', text: 'Export', className: 'inventory-export hide', visible: false, title: 'Inventory Export ' + date}],
            columns: [
                {data: "id", visible: false},
                {data: "division_id", visible: false},
                {data: "division_name"},
                {data: "site_id", visible: false},
                {data: "site_name"},
                {data: "type_name"},
                {data: "make_id", visible: false},
                {data: "make"},
                {data: "description"},
                {data: "part_number"},
                {
                    data: "phone_number", render: function (data) {
                        if (data === null) {
                            return 'Not applicable';
                        } else {
                            return '<a class="link phone-number" data-toggle="modal" data-target="#edit-phone-number-modal" href="#">' + data + '</a>';
                        }
                    }
                },
                {data: "name"},
                {data: "create_date"},
                {
                    data: "assigned_user", render: function (data) {
                        if (data !== null) {
                            return '<a href="#" class="link employee-link" data-toggle="modal" data-target="#edit-assign-modal">' + data + '</a>';
                        } else {
                            return 'Not assigned';
                        }
                    }
                },
                {
                    data: null, render: function () {
                        return '<button type="button" class="btn btn-vprop-light inventory-edit" data-toggle="modal" data-target="#inventoryEditModal" data-placement="top" title="Edit entry"><i class="fa fa-pencil-square-o text-success"></i></button>'
                    }
                },
                {
                    data: null, render: function (data, type, row, meta) {
                        if (row.assigned_user !== null) {
                            return '<button type="button" class="btn btn-vprop-light" disabled><i class="fas fa-minus-circle text-danger"></i></button>';
                        } else {
                            return '<button type="button" class="btn btn-vprop-light inventory-remove" data-toggle="" data-placement="top" title="Remove from inventory"><i class="fas fa-minus-circle text-danger"></i></button>';
                        }
                    },
                    "orderable": false
                },

            ],
            initComplete: function () {
                $('#inventory-loader').remove();
                $('#inventory-table-wrapper').show();
                $("#inventory-table_filter").detach().appendTo('#inventory-card-header').addClass('form-inline float-left');
                $("#inventory-table_paginate").detach().appendTo('#inventory-card-footer').addClass('float-right');
                $(".inventory-export").detach().appendTo('#inventory-card-header').removeClass().addClass('btn btn-vprop-green form-inline float-right').show();
                $("#inventory-table_info").detach().appendTo('#inventory-card-footer').addClass('float-left');
                $('#inventory-table').css('width', '100%');
                $('#inventory-table').DataTable().columns.adjust();
                $('.pagination').addClass("mb-0");
                $('.dataTables_scrollBody').css("height", "unset").css("max-height", "500px");
            }
        });

        let assignLogTable = $('#assign-log-table').DataTable({
            dom: "<\'row\'<\'col-xl-12\'Bf>>" + "<\'row\'<\'col-xl-12\'tr>>" + "<\'row\'<\'col-xl-5\'i><\'col-xl-7\'p>>",
            ajax: {
                url: '../../Includes/IT/assignlogget.php',
                dataSrc: ''
            },
            scrollY: '500px',
            scrollX: true,
            pageLength: '50',
            autoWidth: true,
            buttons: [{extend: 'excel', text: 'Export', className: 'assign-log-export hide', visible: false, title: 'Assigned Log Export ' + date}],
            columns: [
                {data: 'type'},
                {
                    data: 'part_number', render: function (data) {
                        return '<a class="link device-info" href="#" data-toggle="modal" data-target="#device-info-modal">' + data + '</a>';
                    },
                },
                {data: 'description', visible: false},
                {data: 'name'},
                {data: 'in_timestamp'},
                {
                    data: 'out_timestamp', render: function (data) {
                        if (data === null) {
                            return 'Currently assigned'
                        } else {
                            return data;
                        }
                    }
                },
                {data: 'create_date', visible: false}
            ],
            initComplete: function () {
                $('#assign-log-loader').remove();
                $('#assign-log-table-wrapper').show();
                $("#assign-log-table_filter").detach().appendTo('#assign-log-card-header').addClass('form-inline float-left');
                $("#assign-log-table_paginate").detach().appendTo('#assign-log-card-footer').addClass('float-right');
                $(".assign-log-export").detach().appendTo('#assign-log-card-header').removeClass().addClass('btn btn-vprop-green form-inline float-right').show();
                $("#assign-log-table_info").detach().appendTo('#assign-log-card-footer').addClass('float-left');
                $('#assign-log-table').DataTable().columns.adjust();
                $('.pagination').addClass("mb-0");
                $('#assign-log-table').css('width', '100%');
                $('.dataTables_scrollBody').css("height", "unset")
                    .css("max-height", "500px");
            }
        });

        let dischargeLogTable = $('#discharge-log-table').DataTable({
            dom: "<\'row\'<\'col-xl-12\'Bf>>" + "<\'row\'<\'col-xl-12\'tr>>" + "<\'row\'<\'col-xl-5\'i><\'col-xl-7\'p>>",
            ajax: {
                url: '../../Includes/IT/dischargelogget.php',
                dataSrc: ''
            },
            scrollY: '500px',
            scrollX: true,
            pageLength: '50',
            autoWidth: true,
            buttons: [{extend: 'excel', text: 'Export', className: 'discharge-log-export ', visible: false, title: 'Discharge Log Export ' + date}],
            columns: [
                {data: 'type'},
                {data: 'serial'},
                {data: 'note'},
                {data: 'name'},
                {data: 'timestamp'}
            ],
            initComplete: function () {
                $('#discharge-log-loader').remove();
                $('#discharge-log-table-wrapper').show();
                $("#discharge-log-table_filter").detach().appendTo('#discharge-log-card-header').addClass('form-inline float-left');
                $("#discharge-log-table_paginate").detach().appendTo('#discharge-log-card-footer').addClass('float-right');
                $("#discharge-log-table_info").detach().appendTo('#discharge-log-card-footer').addClass('float-left');
                $(".discharge-log-export").detach().appendTo('#discharge-log-card-header').removeClass().addClass('btn btn-vprop-green form-inline float-right').show();
                $('#discharge-log-table').DataTable().columns.adjust();
                $('.pagination').addClass("mb-0");
                $('#discharge-log-table').css('width', '100%');
                $('.dataTables_scrollBody').css("height", "unset")
                    .css("max-height", "500px");
            }
        });

        let purchaseLogTable = $('#purchase-log-table').DataTable({
            dom: "<\'row\'<\'col-xl-12\'Bf>>" + "<\'row\'<\'col-xl-12\'tr>>" + "<\'row\'<\'col-xl-5\'i><\'col-xl-7\'p>>",
            ajax: {
                url: '../../Includes/IT/purchaselogget.php',
                dataSrc: ''
            },
            scrollY: '500px',
            scrollX: true,
            pageLength: '50',
            autoWidth: true,
            buttons: [{extend: 'excel', text: 'Export', className: 'purchase-log-export ', visible: false, footer: true, title: 'Purchase Log Export ' + date}],
            columns: [
                {data: 'type'},
                {data: 'description'},
                {data: 'part_number'},
                {data: 'create_date'},
                {
                    data: 'purchase_price', render: function (data) {
                        if (data != null) {
                            return '$' + data;
                        } else {
                            return 'No cost data found';
                        }
                    }
                }
            ],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0)
                    .toFixed(2);

                // Total over this page
                pageTotal = api
                    .column(4, {page: 'current'})
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0)
                    .toFixed(2);

                // Update footer
                $(api.column(4).footer()).html(
                    '$' + total
                );
            },
            initComplete: function () {
                $('#purchase-log-loader').remove();
                $('#purchase-log-table-wrapper').show();
                $("#purchase-log-table_filter").detach().appendTo('#purchase-log-card-header').addClass('form-inline float-left');
                $("#purchase-log-table_paginate").detach().appendTo('#purchase-log-card-footer').addClass('float-right');
                $("#purchase-log-table_info").detach().appendTo('#purchase-log-card-footer').addClass('float-left');
                $(".purchase-log-export").detach().appendTo('#purchase-log-card-header').removeClass().addClass('btn btn-vprop-green form-inline float-right').show();
                $('#purchase-log-table').DataTable().columns.adjust();
                $('.pagination').addClass("mb-0");
                $('.dataTables_scrollBody').css("height", "unset")
                    .css("max-height", "500px");
            }
        });

        let $inventory_table_body = $('#inventory-table tbody');

        let $outgoing_table_body = $('#outgoing-table tbody');

        let $assign_log_table_body = $('#assign-log-table tbody');

        let $inventory_add_modal = $('#inventory-add-modal');

        $('#business-unit-select').on('change', function () {
            $('#site-select').find('option').not(':first').remove();
            let division = $('#business-unit-select').val();
            let formData = {};
            formData['id'] = division;
            sitesGet('#site-select', formData);
        });


        $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
            outgoingTable.columns.adjust();
            outgoingTable.ajax.reload();
            inventoryTable.columns.adjust();
            inventoryTable.ajax.reload();
            assignLogTable.columns.adjust();
            assignLogTable.ajax.reload();
            dischargeLogTable.columns.adjust();
            dischargeLogTable.ajax.reload();
            purchaseLogTable.columns.adjust();
            purchaseLogTable.ajax.reload();
        });

        $inventory_add_modal.on('shown.bs.modal', function () {
            $('#business-unit-select').val('0');
            $('#site-select').val('0');
            let inventoryMakeSelect = $('#inventory-make-select');
            inventoryMakeSelect.find("option:gt(0)").remove();
            inventoryMakeSelect.val('0');
            assetTypesPopulate();
        });

        $inventory_add_modal.on('hidden.bs.modal', function () {
            clearForm('#inventory-add-form');
            $('#phone-details').hide();
        });

        $('#name-search').autocomplete({
            serviceUrl: '../../Includes/IT/namesget.php',
            onSelect: function (suggestion) {
                let formData = {};
                formData['id'] = suggestion.data;
                $.ajax({
                    url: '../../Includes/IT/employeebyidget.php',
                    type: 'POST',
                    data: JSON.stringify(formData),
                    success: function (response) {
                        let data = JSON.parse(response);
                        $global.employee_id = data[0].id;
                        $global.first_name = data[0].first_name;
                        $global.last_name = data[0].last_name;
                        $('#request-add-submit').show();
                    }
                });
            }
        });

        $outgoing_table_body.on('click', 'tr .print-acknowledgement', function () {
            let rowData = outgoingTable.row($(this).closest('tr')).data();
            let formData = {};
            let isMobile = "<?php echo $_SESSION['user_agent'] ?>";
            formData['id'] = rowData.id;
            formData['inventory_id'] = rowData.inventory_id;
            $.ajax({
                url: '../../Includes/IT/acknowledgement_pdf_get.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    if (parseInt(response) !== 0) {
                        $.ajax({
                            url: response,
                            success: function () {
                                if (isMobile === '0') {
                                    $.confirm({
                                        title: 'Acknowledgement',
                                        theme: 'supervan',
                                        columnClass: 'col-xl-12',
                                        content: '<object data="' + response + '" type="application/pdf" width="100%" height="100%"><iframe src="' + response + '" width="100%" height="100%" style="border: none;">This browser does not support PDFs. Please download the PDF to view it: <a href="' + response + '">Download PDF</a> </iframe> </object>',
                                        buttons: {
                                            close: {
                                                text: 'Close'
                                            }
                                        }
                                    });
                                } else {
                                    window.location.href = response;
                                }
                            },
                            error: function () {
                                $.ajax({
                                    url: '../../Includes/IT/serialbyidget.php',
                                    type: 'POST',
                                    data: JSON.stringify(formData),
                                    success: function (response) {
                                        let dollar = null;
                                        if (rowData.type === 'Cell Phone') {
                                            dollar = '$900';
                                        }
                                        if (rowData.type === 'Radio') {
                                            dollar = '$850';
                                        }
                                        if (rowData.type === 'Tablet') {
                                            dollar = '$1500';
                                        }
                                        if (rowData.type === 'Laptop') {
                                            dollar = '$2000';
                                        }
                                        if (rowData.type === 'Hotspot') {
                                            dollar = '$600';
                                        }
                                        let serial = JSON.parse(response)[0].part_number;
                                        $.confirm({
                                            type: 'orange',
                                            content: '<p class="text-danger">Could not find document.</p>Please select the acknowledgement type.',
                                            icon: 'fa fa-warning',
                                            title: 'Acknowledgement',
                                            buttons: {
                                                digital: {
                                                    text: 'Digital',
                                                    btnClass: 'btn btn-vprop-blue',
                                                    action: function () {
                                                        let name = rowData.first_name + ' ' + rowData.last_name;
                                                        let serial = JSON.parse(response)[0].part_number;
                                                        let urlString = "?id=" + rowData.employee_id +
                                                            "&name=" + name +
                                                            "&inv_id=" + rowData.inventory_id +
                                                            "&type=" + rowData.type +
                                                            "&dollar=" + dollar +
                                                            "&serial=" + serial +
                                                            "&userId=" + <?php echo $_SESSION['user_id']; ?> +
                                                                "&request=" + rowData.id;
                                                        window.open("../../Includes/IT/useracknowledgement.php" + urlString);
                                                    }
                                                },
                                                print: {
                                                    text: 'Print',
                                                    btnClass: 'btn btn-secondary',
                                                    action: function () {
                                                        acknowledgementPdf(rowData, rowData.inventory_id);
                                                    }
                                                },
                                                upload: {
                                                  text: 'Upload',
                                                  btnClass: 'btn btn-vprop-blue-medium',
                                                  action: function() {
                                                      uploadPdf(rowData);
                                                  }
                                                },
                                                cancel: function () {

                                                }
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    } else {
                        $.ajax({
                            url: '../../Includes/IT/serialbyidget.php',
                            type: 'POST',
                            data: JSON.stringify(formData),
                            success: function (response) {
                                let dollar = null;
                                if (rowData.type === 'Cell Phone') {
                                    dollar = '$900';
                                }
                                if (rowData.type === 'Radio') {
                                    dollar = '$850';
                                }
                                if (rowData.type === 'Tablet') {
                                    dollar = '$1500';
                                }
                                if (rowData.type === 'Laptop') {
                                    dollar = '$2000';
                                }
                                if (rowData.type === 'Hotspot') {
                                    dollar = '$600';
                                }
                                let serial = JSON.parse(response)[0].part_number;
                                $.confirm({
                                    type: 'orange',
                                    content: 'Please select the acknowledgement type.',
                                    icon: 'fa fa-warning',
                                    title: 'Acknowledgement',
                                    buttons: {
                                        digital: {
                                            text: 'Digital',
                                            btnClass: 'btn btn-vprop-blue',
                                            action: function () {
                                                let name = rowData.first_name + ' ' + rowData.last_name;
                                                let serial = JSON.parse(response)[0].part_number;
                                                let urlString = "?id=" + rowData.employee_id +
                                                    "&name=" + name +
                                                    "&inv_id=" + rowData.inventory_id +
                                                    "&type=" + rowData.type +
                                                    "&dollar=" + dollar +
                                                    "&serial=" + serial +
                                                    "&userId=" + <?php echo $_SESSION['user_id']; ?> +
                                                        "&request=" + rowData.id;
                                                window.open("../../Includes/IT/useracknowledgement.php" + urlString);
                                            }
                                        },
                                        print: {
                                            text: 'Print',
                                            btnClass: 'btn btn-secondary',
                                            action: function () {
                                                acknowledgementPdf(rowData, rowData.inventory_id);
                                            }
                                        },
                                        upload: {
                                            text: 'Upload',
                                            btnClass: 'btn btn-vprop-blue-medium',
                                            action: function () {
                                                console.log(rowData);
                                                $('#uploadRequestId').val(rowData.id);
                                                $('#ackUploadModal').modal('toggle');
                                            }
                                        },
                                        cancel: function () {

                                        }
                                    }
                                });
                            }
                        });
                    }
                }
            });
        });

        $('#inventory-type-select').on('change', function (e) {
            let type = $(this).val();
            let formData = {};
            formData['type'] = $(this).val();
            assetMakesPopulate(formData);
            if (type === '1') {
                $('#phone-details').show();
            } else {
                $('#phone-details').hide();
            }
            if (type === '5') {
                $('#inventory-description').hide();
                $('#monitor-details').show();
            } else {
                $('#inventory-description').show();
                $('#monitor-details').hide();
            }
        });

        $('#inventory-add-submit').on('click', function () {
            let formData = {};
            let user_id = $('#user_id');
            let bu = $('#business-unit-select');
            let site = $('#site-select');
            let type = $('#inventory-type-select');
            let make = $('#inventory-make-select');
            let part_number = $('#inventory-serial-input');
            let description = null;
            if (type.val() === '5') {
                description = $('#monitor-size-select');
            } else {
                description = $('#inventory-description-input');
            }
            let phone_number = $('#inventory-phone-input');
            let purchase_price = $('#inventory-purchase-input');
            if (user_id.val() !== "") {
                formData['user_id'] = user_id.val();
                if (bu.val() !== "") {
                    inputValid(bu);
                    formData['business_unit'] = bu.val();
                    if (site.val() !== "") {
                        inputValid(site);
                        formData['site'] = site.val();
                        if (type.val() !== '0') {
                            inputValid(type);
                            formData['type'] = type.val();
                            if (make.val() !== "0") {
                                inputValid(make);
                                formData['make'] = make.val();
                                if (part_number.val() !== "") {
                                    inputValid(part_number);
                                    formData['part_number'] = part_number.val();
                                    if (description.val() !== "") {
                                        inputValid(description);
                                        formData['description'] = description.val();
                                        if (type.val() === '1') {
                                            if (phone_number.val() !== '') {
                                                inputValid(phone_number);
                                                formData['phone_number'] = phone_number.val();
                                                formData['purchase_price'] = '900.00';
                                                assetSubmit(formData, inventoryTable);
                                            } else {
                                                inputError(phone_number);
                                                formError(phone_number, 'Phone number cannot be empty.');
                                            }
                                        } else {
                                            if (type.val() === '1') {
                                            }
                                            if (type.val() === '2') {
                                                formData['purchase_price'] = '2000.00';
                                            }
                                            if (type.val() === '3') {
                                                if (purchase_price.val() !== "")
                                                    formData['purchase_price'] = purchase_price.val();
                                            }
                                            if (type.val() === '4') {
                                                formData['purchase_price'] = '1500.00';
                                            }
                                            if (type.val() === '5') {
                                                if (purchase_price.val() !== "")
                                                    formData['purchase_price'] = purchase_price.val();
                                            }
                                            if (type.val() === '6') {
                                                formData['purchase_price'] = '850.00';
                                            }
                                            if (type.val() === '9') {
                                                formData['purchase_price'] = '600.00';
                                            }
                                            assetSubmit(formData, inventoryTable);
                                        }
                                    } else {
                                        inputError(description);
                                        formError(description, 'Description cannot be empty.');
                                    }
                                } else {
                                    inputError(part_number);
                                    formError(part_number, 'Serial/part number cannot be empty.');
                                }
                            } else {
                                inputError(make);
                                formError(make, 'Asset make cannot be empty.');
                            }
                        } else {
                            inputError(type);
                            formError(type, 'Asset type cannot be empty.')
                        }
                    } else {
                        inputError(site);
                        formError(site, 'Site cannot be empty.');
                    }

                } else {
                    inputError(bu);
                    formError(bu, 'Business unit cannot be empty.');
                }

            } else {
                $.alert({
                    title: 'Error',
                    type: 'red',
                    icon: 'fa fa-warning',
                    content: 'You must be logged in to perform this operation.'
                });
            }

        });

        $outgoing_table_body.on('click', 'tr .pending-approval', function () {
            let e = outgoingTable.row($(this).closest('tr')).data();
            let title = 'Complete Request ' + e.id;
            let form = null;
            if (e.type === 'Credit Card') {
                form = '<form action=""><div class="form-group col-xl-12 mt-2"><input type="number" class="form-control kace-input" placeholder="Kace #"></div><div class="form-group col-xl-12"><input class="form-control card" type="number" placeholder="Last 4 of card number"></div></form>';
            } else {
                form = '<form action=""><div class="form-group col-xl-12 mt-2"><input type="number" class="form-control kace-input" placeholder="Kace #"></div><div class="form-group col-xl-12"><select class="form-control serial"><option value="0">Select a serial to assign</select></div></form>';
            }
            if (e.type === 'Desktop') {
                form = '<form action=""><div class="form-group col-xl-12 mt-2"><input type="number" class="form-control kace-input" placeholder="Kace #"/></div><div class="form-group col-xl-12"><select class="form-control serial"><option value="0">Select a serial to assign</option></select></div><div class="form-group col-xl-12"><select class="form-control monitors-select"><option value="0">How many monitors?</option><option value="1">1</option><option value="2">2</option><option ' +
                    'value="3">3</option></select> </div></div></form>';
            }
            let formData = {};
            let name = e.first_name + ' ' + e.last_name;
            formData['employee_id'] = e.employee_id;
            completeRequestConfirm(title, form, formData, e, outgoingTable, e.type, name);

        });

        $inventory_table_body.on('click', 'tr .employee-link', function () {
            let e = inventoryTable.row($(this).closest('tr')).data();
            $global.inventory_id = e.id;
        });

        $inventory_table_body.on('click', 'tr .inventory-remove', function () {
            let e = inventoryTable.row($(this).closest('tr')).data();
            let title = 'Discharge';
            let form = '<form action="">A discharged device will not be available for assigning.<div class="mt-2 mb-2 ml-1 mr-1"><textarea id="discharge-note-req" class="form-control note" placeholder="Discharge reason"></textarea></div><strong>This cannot be undone.</strong></form>';
            let formData = {};
            formData['id'] = e.id;
            formData['user_id'] = $('#user_id').val();
            removeInventoryConfirm(title, form, formData, e, inventoryTable)
        });

        businessUnitsGet('#editDivisionSelect');
        $inventory_table_body.on('click', 'tr .inventory-edit', function () {
            let e = inventoryTable.row($(this).closest('tr')).data();
            $('#editInventoryId').val(e.id);
            let buData = {};
            buData['id'] = e.division_id;
            $.ajax({
                url: '../../Includes/HR/sitesget.php',
                type: 'POST',
                data: JSON.stringify(buData),
                beforeSend: function () {
                    $('#editDivisionSelect').val(e.division_id);
                },
                success: function (response) {
                    $.each(JSON.parse(response), function (key, value) {
                        $('#editSiteSelect').append('<option value="' + value.id + '">' + value.site + '</option>');
                    });
                    $('#editSiteSelect').val(e.site_id);
                },
                complete: function () {
                    let $select = $('#editTypeSelect');
                    $select.children('option:not(:first)').remove();
                    $.ajax({
                        url: '../../Includes/IT/assettypesget.php',
                        type: 'POST',
                        success: function (response) {
                            $.each(JSON.parse(response), function (key, value) {
                                $select.append('<option value="' + value.id + '">' + value.type + '</option>');

                            });
                        },
                        error: function () {
                            $select.append('<option>No asset types found</option>');
                        },
                        complete: function () {
                            $select.val(e.type);
                            $('#editMakeSelect').children('option:not(:first)').remove();
                            let typeData = {};
                            typeData['type'] = e.type;
                            $.ajax({
                                url: '../../Includes/IT/assetmakesbytypeget.php',
                                type: 'POST',
                                data: JSON.stringify(typeData),
                                success: function (response) {
                                    $.each(JSON.parse(response), function (key, value) {
                                        $('#editMakeSelect').append('<option value="' + value.id + '">' + value.make + '</option>');
                                    });
                                },
                                error: function () {
                                    $('#editMakeSelect').append('<option>No asset makes found</option>');
                                },
                                complete: function () {
                                    $('#editMakeSelect').val(e.make_id);
                                }
                            });
                        }
                    });
                    $('#editMakeSelect').val(e.make_id);
                    $('#editDescriptionInput').val(e.description);

                }
            });

        });

        $('#editTypeSelect').on('change', function () {
            let formData = {};
            formData['type'] = $('#editTypeSelect').val();
            $('#editMakeSelect').children('option:not(:first)').remove();
            $.ajax({
                url: '../../Includes/IT/assetmakesbytypeget.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    $.each(JSON.parse(response), function (key, value) {
                        $('#editMakeSelect').append('<option value="' + value.id + '">' + value.make + '</option>');
                    });
                },
                error: function () {
                    $('#editMakeSelect').append('<option>No asset makes found</option>');
                }
            });
        });

        $('#editDivisionSelect').on('change', function () {
            $('#editSiteSelect').find('option').remove();
            let formData = {};
            formData['id'] = $('#editDivisionSelect').val();
            sitesGet('#editSiteSelect', formData);
        });

        $inventory_table_body.on('click', 'tr .phone-number', function (e) {
            let invData = inventoryTable.row($(this).closest('tr')).data();
            $global.inventory_id = invData.id;
            $('#edit-phone-number').val(invData.phone_number);
        });

        $outgoing_table_body.on('click', 'tr .remove-request', function () {
            let data = outgoingTable.row($(this).closest('tr')).data();
            let formData = {};
            formData['id'] = data.id;
            $.confirm({
                title: 'Remove Request',
                content: 'Are you sure you want to remove request #' + data.id + '?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: '../../Includes/IT/requestinactivate.php',
                            type: 'POST',
                            data: JSON.stringify(formData),
                            success: function (response) {
                                if (parseInt(response) === 1) {
                                    successAlert('Successfully removed request!');
                                    outgoingTable.ajax.reload();
                                } else {
                                    errorAlert('Issue removing request!');
                                }
                            },
                            error: function () {
                                errorAlert('Bad server response');
                            }
                        });
                    },
                    cancel: function () {

                    },
                }
            });
        });

        $('#request-add-modal').on('hide.bs.modal', function (e) {
            $('#request-type').val(1);
            $('#name-search').val('');
        });

        $('#edit-phone-number-submit').on('click', function () {
            let formData = {};
            formData['id'] = $global.inventory_id;
            formData['phone_number'] = $('#edit-phone-number').val();
            formData['user_id'] = $('#user_id').val();
            $.ajax({
                url: '../../Includes/IT/phonenumberupdate.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    if (parseInt(response) === 1) {
                        successAlert('Updated!');
                    } else {
                        errorAlert('Failed to update!');
                    }

                },
                error: function () {
                    errorAlert('Invalid response.');
                },
                complete: function () {
                    inventoryTable.ajax.reload();
                }
            });
        });

        $('#edit-assign-modal').on('shown.bs.modal', function () {
            let $discharge_note = $('#discharge-note');
            $('#edit-assign-action-select').val('0');
            if ($discharge_note.is(':visible')) {
                $discharge_note.val('').hide();
                $('#discharge-feedback').val('').hide();
            }
        });

        $assign_log_table_body.on('click', 'tr .device-info', function () {
            let e = assignLogTable.row($(this).closest('tr')).data();
            $('#device-serial').val(e.part_number);
            $('#device-description').val(e.description);
            $('#device-date').val(e.create_date);
        });


        $('#edit-assign-action-select').on('change', function () {
            let note = $('#discharge-note');
            let feedback = $('#discharge-feedback');
            if ($(this).val() === '2') {
                note.show();
                feedback.show();
            } else {
                note.hide();
                feedback.hide();
            }
        });

        $('#edit-assign-submit').on('click', function () {
            let formData = {};
            let action = $('#edit-assign-action-select').val();
            let note = $('#discharge-note');
            formData['id'] = $global.inventory_id;
            formData['action'] = action;
            formData['user_id'] = $('#user_id').val();
            if (action === '2') {
                $('#discharge-feedback').show();
                if (note.val() === "") {
                    errorAlert('You must put a discharge reason!');
                } else {
                    formData['note'] = note.val();
                    editAssetAssign(formData, inventoryTable);
                }
            } else {
                editAssetAssign(formData, inventoryTable);
            }

        });

        $('#request-add-submit').on('click', function () {
            let formData = {};
            formData['id'] = $global.employee_id;
            formData['firstName'] = $global.first_name;
            formData['lastName'] = $global.last_name;
            formData['type'] = $('#request-type option:selected').text();
            formData['userId'] = <?php echo $_SESSION['user_id']; ?>;
            $.ajax({
                url: '../../Includes/IT/requestadd.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function (response) {
                    if (parseInt(response) === 1) {
                        successAlert('Successfully added request!');
                        outgoingTable.ajax.reload();
                        $('#request-add-modal').modal('hide');
                    } else {
                        errorAlert('Unable to add request! Try again!');
                    }

                },
                error: function () {
                    errorAlert('Bad server response');
                }
            });
        });

        $('#editEntrySubmit').on('click', function () {
            let $modal = $('#inventoryEditModal').find('.modal-body');
            let $id = $('#editInventoryId');
            let $division = $('#editDivisionSelect');
            let $site = $('#editSiteSelect');
            let $type = $('#editTypeSelect');
            let $make = $('#editMakeSelect');
            let $description = $('#editDescriptionInput');
            let formData = {};
            if ($id.val() === "") {
                errorAlertModal($modal, 'Please close and retry.');
                return false;
            } else {
                formData['id'] = $id.val();
            }
            if ($division.val() === "") {
                errorAlertModal($modal, 'Division cannot be empty!');
                return false;
            } else {
                formData['division'] = $division.val();
            }
            if ($site.val() === "") {
                errorAlertModal($modal, 'Site cannot be empty!');
                return false;
            } else {
                formData['site'] = $site.val();
            }
            if ($type.val() === "") {
                errorAlertModal($modal, 'Type cannot be empty!');
                return false;
            } else {
                formData['type'] = $type.val();
            }
            if ($make.val() === "") {
                errorAlertModal($modal, 'Make cannot be empty!');
                return false;
            } else {
                formData['make'] = $make.val();
            }
            if ($description.val() === "") {
                errorAlertModal($modal, 'Description cannot be empty!');
                return false;
            } else {
                formData['description'] = $description.val();
            }
            formData['userId'] = '<?php echo $_SESSION['user_id']; ?>';
            $.ajax({
                url: '../../Includes/IT/inventory_update.php',
                type: 'POST',
                data: formData,
                beforeSend: function () {

                },
                success: function (response) {
                    console.log(response);
                    inventoryTable.ajax.reload();
                },
                error: function () {

                },
                complete: function () {

                }
            });
        });

        $('#uploadSubmit').on('click', function () {
            let formData = new FormData();
            let requestId = $('#uploadRequestId').val();
            formData.append('file', $('#fileUpload').prop('files')[0]);
            formData.append('requestId', requestId);
            formData.append('userId', '<?php echo $_SESSION['user_id']; ?>');
            $.ajax({
                url: '../../Includes/IT/acknowledgement_upload.php',
                data: formData,
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function (response) {
                    let data = parseInt(response);
                    if(data !== 1) {
                        errorAlert('Failed to upload! Try again.');
                    } else {
                        successAlert('Successfully uploaded!');
                        $('#ackUploadModal').modal('toggle');
                    }
                },
                error: function(obj, error, errorThrown) {
                    errorAlert(errorThrown);
                }
            });
        });

    });

    function serialsByTypePopulate(formData) {
        $.ajax({
            url: '../../Includes/IT/serialsbytypeget.php',
            type: 'POST',
            data: JSON.stringify(formData),
            success: function (response) {
                if (parseInt(response) !== 0) {
                    $.each(JSON.parse(response), function (key, value) {
                        $('.serial').append('<option value="' + value.id + '">' + value.part_number + '</option>');
                    });
                } else {
                    $('.serial').replaceWith('<input type="text" value="No serials found" class="form-control serial-error" disabled>');
                }

            }
        });
    }

    function successAlert(message) {
        let $contentWrapper = $('.content-wrapper');
        $contentWrapper.prepend('<div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert" style="position: absolute;z-index: 999;margin-top: 5px;right: 40%;">\n' +
            '  <strong>Success!</strong> ' + message +
            '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
            '    <span aria-hidden="true">&times;</span>\n' +
            '  </button>\n' +
            '</div>');
        setTimeout(function () {
            $contentWrapper.find('#success-alert').alert('close');
            $contentWrapper.find('#success-alert').alert('dispose');
        }, 5000);
    }

    function errorAlert(message) {
        let $contentWrapper = $('.content-wrapper');
        $contentWrapper.prepend('<div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert" style="position: absolute;z-index: 9999;margin-top: -100px;right: 40%;">\n' +
            '  <strong>Error!</strong> ' + message +
            '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
            '    <span aria-hidden="true">&times;</span>\n' +
            '  </button>\n' +
            '</div>');
        setTimeout(function () {
            $contentWrapper.find('#error-alert').alert('close');
            $contentWrapper.find('#error-alert').alert('dispose');
        }, 5000);
        /* $.alert({
             title: 'Error',
             icon: 'fa fa-warning',
             type: 'red',
             content: message
         });*/
    }

    function errorAlertModal(modal, message) {
        let $contentWrapper = modal;
        $contentWrapper.prepend('<div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert">\n' +
            '  <strong>Error!</strong> ' + message +
            '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
            '    <span aria-hidden="true">&times;</span>\n' +
            '  </button>\n' +
            '</div>');
        setTimeout(function () {
            $contentWrapper.find('#error-alert').alert('close');
            $contentWrapper.find('#error-alert').alert('dispose');
        }, 5000);
        /* $.alert({
             title: 'Error',
             icon: 'fa fa-warning',
             type: 'red',
             content: message
         });*/
    }

    function completeRequestConfirm(title, form, formData, e, table, type, name) {
        $.confirm({
            icon: 'fa fa-check',
            title: title,
            type: 'green',
            content: form,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: "btn-vprop-green",
                    action: function () {
                        let id = e.id;
                        let kace = this.$content.find('.kace-input').val();
                        let inventory_id = this.$content.find('.serial').val();
                        let cc = this.$content.find('.card').val();
                        formData['id'] = id;
                        formData['user_id'] = $('#user_id').val();
                        if (!kace) {
                            errorAlert('You must enter the Kace ticket #!');
                            return false;
                        } else {
                            formData['kace'] = kace;
                            if (type === 'Credit Card') {
                                if (!cc) {
                                    errorAlert('You must enter the last 4 credit card numbers!');
                                    return false;
                                } else {
                                    if (cc.length > 4 || cc.length < 4) {
                                        errorAlert('Input must be 4 digits!');
                                        return false;
                                    } else {
                                        formData['inventory_id'] = cc;
                                        $.ajax({
                                            url: '../../Includes/IT/completerequest.php',
                                            type: 'POST',
                                            data: JSON.stringify(formData),
                                            beforeSend: function () {

                                            },
                                            success: function (response) {
                                                let responseData = parseInt(response);
                                                if (responseData === 1) {
                                                    successAlert('Request ' + id + ' updated!');
                                                } else {
                                                    errorAlert('Failed to update ' + id)
                                                }
                                                table.ajax.reload();
                                            },
                                            error: function () {
                                                errorAlert('Failed to update ' + id)
                                            },
                                            complete: function () {

                                            }
                                        });
                                    }
                                }
                            } else {
                                if (type === 'Desktop') {
                                    if (!inventory_id) {
                                        errorAlert('You must select a serial number!');
                                    } else {
                                        if (inventory_id === "0") {
                                            errorAlert('You must select a serial number!');
                                        } else {
                                            let $monitors = $('.monitor-serial');
                                            if ($monitors.length) {
                                                for (let i = 0; i < $monitors.length; i++) {
                                                    let monitor = $('.monitor-' + i);
                                                    if (monitor.val() === '0') {
                                                        errorAlert('You must select a serial for each monitor!');
                                                        return false;
                                                    } else {
                                                        formData['inventory_id'] = monitor.val();
                                                        $.ajax({
                                                            url: '../../Includes/IT/completerequest.php',
                                                            type: 'POST',
                                                            data: JSON.stringify(formData),
                                                            beforeSend: function () {

                                                            },
                                                            success: function (response) {
                                                                let dollar = null;
                                                                if (type === 'Cell Phone') {
                                                                    dollar = '$900';
                                                                }
                                                                if (type === 'Radio') {
                                                                    dollar = '$850';
                                                                }
                                                                if (type === 'Tablet') {
                                                                    dollar = '$1500';
                                                                }
                                                                if (type === 'Laptop') {
                                                                    dollar = '$2000';
                                                                }
                                                                if (type === 'Hotspot') {
                                                                    dollar = '$600';
                                                                }
                                                                if (type === 'Monitor') {
                                                                    dollar = '$700';
                                                                }
                                                                let responseData = parseInt(response);
                                                                if (responseData === 1) {
                                                                    $.confirm({
                                                                        type: 'orange',
                                                                        content: 'Please select the acknowledgement type.',
                                                                        icon: 'fa fa-warning',
                                                                        title: 'Acknowledgement',
                                                                        buttons: {
                                                                            digital: {
                                                                                text: 'Digital',
                                                                                btnClass: 'btn btn-vprop-blue',
                                                                                action: function () {
                                                                                    let serial = JSON.parse(response)[0].part_number;
                                                                                    let urlString = "?id=" + e.employee_id +
                                                                                        "&name=" + name +
                                                                                        "&inv_id=" + monitor.val() +
                                                                                        "&type=" + 'Monitor' +
                                                                                        "&dollar=" + dollar +
                                                                                        "&serial=" + serial +
                                                                                        "&userId=" + <?php echo $_SESSION['user_id']; ?> +
                                                                                            "&request=" + e.id;
                                                                                    window.open("../../Includes/IT/useracknowledgement.php" + urlString);
                                                                                }
                                                                            },
                                                                            print: {
                                                                                text: 'Print',
                                                                                btnClass: 'btn btn-secondary',
                                                                                action: function () {
                                                                                    acknowledgementPdf(e, inventory_id);

                                                                                }
                                                                            },
                                                                            cancel: function () {

                                                                            }
                                                                        }
                                                                    });

                                                                } else {
                                                                    errorAlert('Failed to update ' + id);
                                                                }
                                                                table.ajax.reload();
                                                            },
                                                            error: function () {
                                                                errorAlert('Bad response');
                                                            },
                                                            complete: function () {
                                                                let div = $('#pdf-content');
                                                                div.children().remove();
                                                                div.hide();
                                                            }
                                                        });
                                                    }
                                                }

                                            } else {
                                                errorAlert('error');
                                            }
                                        }
                                        formData['inventory_id'] = inventory_id;
                                        $.ajax({
                                            url: '../../Includes/IT/completerequest.php',
                                            type: 'POST',
                                            data: JSON.stringify(formData),
                                            beforeSend: function () {

                                            },
                                            success: function (response) {
                                                let responseData = parseInt(response);
                                                if (responseData === 1) {
                                                    successAlert('Request ' + id + ' updated!');
                                                    $.ajax({
                                                        url: '../../Includes/IT/serialbyidget.php',
                                                        type: 'POST',
                                                        data: JSON.stringify(formData),
                                                        success: function (response) {
                                                            let dollar = null;
                                                            if (type === 'Cell Phone') {
                                                                dollar = '$900';
                                                            }
                                                            if (type === 'Radio') {
                                                                dollar = '$850';
                                                            }
                                                            if (type === 'Tablet') {
                                                                dollar = '$1500';
                                                            }
                                                            if (type === 'Laptop') {
                                                                dollar = '$2000';
                                                            }
                                                            if (type === 'Hotspot') {
                                                                dollar = '$600';
                                                            }
                                                            let serial = JSON.parse(response)[0].part_number;
                                                            $.confirm({
                                                                type: 'orange',
                                                                content: 'Please select the acknowledgement type.',
                                                                icon: 'fa fa-warning',
                                                                title: 'Acknowledgement',
                                                                buttons: {
                                                                    digital: {
                                                                        text: 'Digital',
                                                                        btnClass: 'btn btn-vprop-blue',
                                                                        action: function () {
                                                                            let serial = JSON.parse(response)[0].part_number;
                                                                            let urlString = "?id=" + e.employee_id +
                                                                                "&name=" + name +
                                                                                "&inv_id=" + inventory_id +
                                                                                "&type=" + type +
                                                                                "&dollar=" + dollar +
                                                                                "&serial=" + serial +
                                                                                "&userId=" + <?php echo $_SESSION['user_id']; ?> +
                                                                                    "&request=" + e.id;
                                                                            window.open("../../Includes/IT/useracknowledgement.php" + urlString);
                                                                        }
                                                                    },
                                                                    print: {
                                                                        text: 'Print',
                                                                        btnClass: 'btn btn-secondary',
                                                                        action: function () {
                                                                            acknowledgementPdf(e, inventory_id);

                                                                        }
                                                                    },
                                                                    cancel: function () {

                                                                    }
                                                                }
                                                            });
                                                        }
                                                    });

                                                } else {
                                                    errorAlert('Failed to update ' + id);
                                                }
                                                table.ajax.reload();
                                            },
                                            error: function () {
                                                errorAlert('Bad response');
                                            },
                                            complete: function () {
                                                let div = $('#pdf-content');
                                                div.children().remove();
                                                div.hide();
                                            }
                                        });
                                    }

                                } else {
                                    if (!inventory_id) {
                                        errorAlert('You must select a serial number!');
                                    } else {
                                        if (inventory_id === "0") {
                                            errorAlert('You must select a serial number!');
                                        } else {
                                            formData['inventory_id'] = inventory_id;
                                            $.ajax({
                                                url: '../../Includes/IT/completerequest.php',
                                                type: 'POST',
                                                data: JSON.stringify(formData),
                                                beforeSend: function () {

                                                },
                                                success: function (response) {
                                                    let responseData = parseInt(response);
                                                    if (responseData === 1) {
                                                        successAlert('Request ' + id + ' updated!');
                                                        let formData = {};
                                                        let date = new Date();
                                                        let div = $('#pdf-content');
                                                        let paycomData = {};
                                                        paycomData['id'] = formData['id'];
                                                        formData['inventory_id'] = inventory_id;
                                                        $.ajax({
                                                            url: '../../Includes/IT/serialbyidget.php',
                                                            type: 'POST',
                                                            data: JSON.stringify(formData),
                                                            success: function (response) {
                                                                let dollar = null;
                                                                if (type === 'Cell Phone') {
                                                                    dollar = '$900';
                                                                }
                                                                if (type === 'Radio') {
                                                                    dollar = '$850';
                                                                }
                                                                if (type === 'Tablet') {
                                                                    dollar = '$1500';
                                                                }
                                                                if (type === 'Laptop') {
                                                                    dollar = '$2000';
                                                                }
                                                                if (type === 'Hotspot') {
                                                                    dollar = '$600';
                                                                }
                                                                let serial = JSON.parse(response)[0].part_number;
                                                                $.confirm({
                                                                    type: 'orange',
                                                                    content: 'Please select the acknowledgement type.',
                                                                    icon: 'fa fa-warning',
                                                                    title: 'Acknowledgement',
                                                                    buttons: {
                                                                        digital: {
                                                                            text: 'Digital',
                                                                            btnClass: 'btn btn-vprop-blue',
                                                                            action: function () {
                                                                                let serial = JSON.parse(response)[0].part_number;
                                                                                let urlString = "?id=" + e.employee_id +
                                                                                    "&name=" + name +
                                                                                    "&inv_id=" + inventory_id +
                                                                                    "&type=" + type +
                                                                                    "&dollar=" + dollar +
                                                                                    "&serial=" + serial +
                                                                                    "&userId=" + <?php echo $_SESSION['user_id']; ?> +
                                                                                        "&request=" + e.id;
                                                                                window.open("../../Includes/IT/useracknowledgement.php" + urlString);
                                                                            }
                                                                        },
                                                                        print: {
                                                                            text: 'Print',
                                                                            btnClass: 'btn btn-secondary',
                                                                            action: function () {
                                                                                acknowledgementPdf(e, inventory_id);
                                                                            }
                                                                        },
                                                                        cancel: function () {

                                                                        }
                                                                    }
                                                                });
                                                            }
                                                        });
                                                    } else {
                                                        errorAlert('Failed to update ' + id);
                                                    }
                                                    table.ajax.reload();
                                                },
                                                error: function () {
                                                    errorAlert('Bad response');
                                                },
                                                complete: function () {

                                                }
                                            });
                                        }
                                    }
                                }

                            }
                        }
                    }
                },
                cancel: function () {

                }
            },
            onContentReady: function () {
                if (type === 'Desktop') {
                    let $jcontent = $('.jconfirm-content');
                    let $monitor_serial = $('.monitor-serial');
                    let typeData = {};
                    typeData['type'] = 'Monitor';
                    let $monitors = this.$content.find('.monitors-select');
                    $monitors.on('change', function () {
                        $jcontent.find('.serial-group').remove();
                        $jcontent.find('.monitor-serial').children().remove();
                        for (let i = 0; i < $monitors.val(); i++) {
                            $jcontent.append('' +
                                '<div class="form-group col-xl-12 serial-group">' +
                                '<select class="form-control monitor-' + i + ' monitor-serial">' +
                                '<option value="0">Serial for monitor ' + (i + 1) + '</option>' +
                                '</select>' +
                                '</div>');
                            if (i === 0) {
                                $.ajax({
                                    url: '../../Includes/IT/serialsbytypeget.php',
                                    type: 'POST',
                                    data: JSON.stringify(typeData),
                                    success: function (response) {
                                        if (parseInt(response) !== 0) {
                                            $.each(JSON.parse(response), function (key, value) {
                                                $('.monitor-serial').append('<option value="' + value.id + '">' + value.part_number + '</option>');
                                            });
                                        } else {
                                            $monitor_serial.replaceWith('<input type="text" value="No serials found" class="form-control serial-error" disabled>');
                                        }

                                    }
                                });
                            }
                        }
                        //This select on change makes sure that the user cannot select the same serial more than once
                        $('select').on('change', function () {
                            let select = $('select');
                            let prevValue = $(this).data('previous');
                            let value = $(this).val();
                            select.not(this).find('option[value="' + prevValue + '"]').show();
                            $(this).data('previous', value);
                            select.not(this).find('option[value="' + value + '"]').hide();
                        });
                    });
                }
                let typeData = {};
                typeData['type'] = e.type;
                let self = this;
                this.$content.find('form').on('submit', function (e) {
                    e.preventDefault();
                    self.$$formSubmit.trigger('click');
                });
                serialsByTypePopulate(typeData);
            }
        });
    }

    function removeInventoryConfirm(title, form, formData, e, table) {
        $.confirm({
            icon: 'fa fa-warning',
            title: title,
            type: 'orange',
            content: form,
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: "btn-vprop-green",
                    action: function () {
                        let note = this.$content.find('.note').val();
                        if (!note) {
                            errorAlert('You must enter an explanation!');
                            return false;
                        } else {
                            formData['note'] = note;
                        }
                        $.ajax({
                            url: '../../Includes/IT/removeinventory.php',
                            type: 'POST',
                            data: JSON.stringify(formData),
                            beforeSend: function () {

                            },
                            success: function (response) {
                                let responseData = parseInt(response);
                                if (responseData === 1) {
                                    successAlert('Removed device from inventory!');
                                } else {
                                    errorAlert('Failed to remove device from inventory');
                                }
                                table.ajax.reload();
                            },
                            error: function () {
                                errorAlert('Failed to update ' + id)
                            },
                            complete: function () {

                            }
                        });
                    }
                },
                cancel: function () {

                },
            }
        });
    }

    function assetSubmit(formData, table) {
        $.ajax({
            url: '../../Includes/IT/inventoryinsert.php',
            type: 'POST',
            data: JSON.stringify(formData),
            success: function (data) {
                if (parseInt(data) > 0) {
                    successAlert('Added successfully');
                    /*$.alert({
                        type: 'green',
                        icon: 'fa fa-check',
                        title: 'Success',
                        columnClass: 'col-md-6 col-md-offset-3',
                        content: 'Added successfully'
                    });*/
                }
            },
            complete: function () {
                table.ajax.reload();
                $('#inventory-add-modal').hide();
            },
            error: function () {

            }
        });
    }

    function editAssetAssign(formData, table) {
        $.ajax({
            url: '../../Includes/IT/editassetassign.php',
            type: 'POST',
            data: JSON.stringify(formData),
            success: function (data) {
                if (parseInt(data) === 1) {
                    successAlert('Changed assignment');

                    /* $.alert({
                         type: 'green',
                         icon: 'fa fa-check',
                         title: 'Success',
                         columnClass: 'col-md-6 col-md-offset-3',
                         content: 'Added successfully'
                     });*/
                    $('#inventory-make-select').children('option:not(:first)').remove();
                }
            },
            complete: function () {
                table.ajax.reload();
            },
            error: function () {

            }
        });
        $('#edit-assign-modal').modal('hide');
    }

    function assetTypesPopulate() {
        $('#inventory-type-select').children('option:not(:first)').remove();
        $.ajax({
            url: '../../Includes/IT/assettypesget.php',
            type: 'POST',
            success: function (response) {
                $.each(JSON.parse(response), function (key, value) {
                    $('#inventory-type-select').append('<option value="' + value.id + '">' + value.type + '</option>');
                });
            },
            error: function () {
                $('#inventory-type-select').append('<option>No asset types found</option>');
            }
        });
    }

    function assetMakesPopulate(formData) {
        $('#inventory-make-select').children('option:not(:first)').remove();
        $.ajax({
            url: '../../Includes/IT/assetmakesbytypeget.php',
            type: 'POST',
            data: JSON.stringify(formData),
            success: function (response) {
                $.each(JSON.parse(response), function (key, value) {
                    $('#inventory-make-select').append('<option value="' + value.id + '">' + value.make + '</option>');
                });
            },
            error: function () {
                $('#inventory-type-select').append('<option>No asset makes found</option>');
            }
        });
    }

    function inputError(input) {
        $(input).focus().removeClass().addClass("form-control border border-danger");
    }

    function inputValid(input) {
        $(input).removeClass().addClass("form-control border border-success");
    }

    function formError(div, text) {
        if ($('#alert').length === 0) { //if there isn't already an alert on screen
            $(div).before('<div class="alert alert-danger alert-dismissible fade show" id="alert" role="alert"><strong>Oops!</strong> ' + text + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    }

    function clearForm(form) {
        $('#inventory-type-select').children('option:not(:first)').remove();
        $(form + " :input").removeClass().addClass('form-control').val("");
        $('.alert').alert('close');
    }

    function acknowledgementPdf(e, inventoryId) {
        let pdfData = {};
        pdfData['name'] = e.first_name + ' ' + e.last_name;
        pdfData['type'] = e.type;
        pdfData['id'] = e.employee_id;
        pdfData['requestId'] = e.id;
        pdfData['inventoryId'] = inventoryId
        pdfData['userId'] = "<?php echo $_SESSION['user_id']; ?>";
        let queryString = $.param(pdfData);
        window.open('../../Includes/IT/create_acknowledgement_pdf.php?' + queryString);
    }

    function businessUnitsGet(select) {
        $.ajax({
            url: '../../Includes/HR/divisionsget.php',
            success: function (response) {
                $.each(JSON.parse(response), function (key, value) {
                    $(select).append('<option value="' + value.id + '">' + value.division + '</option>');
                });
            }
        });
    }

    function sitesGet(select, formData) {
        $.ajax({
            url: '../../Includes/HR/sitesget.php',
            type: 'POST',
            data: JSON.stringify(formData),
            success: function (response) {
                $.each(JSON.parse(response), function (key, value) {
                    $(select).append('<option value="' + value.id + '">' + value.site + '</option>');
                });
            }
        });
    }
</script>


