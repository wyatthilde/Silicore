<?php
/* * *****************************************************************************************************************************************
 * File Name: silicoreusers.php
 * Project: silicore_site
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 08/30/2017|nolliff|KACE:18394 - Initial creation
 * 08/31/2017|nolliff|KACE:18394 - Added basic table functionality, data is displayed
 * 08/31/2017|nolliff|KACE:18394 - Added CSS and tablesort
 * 08/31/2017|nolliff|KACE:18394 - Added javascript function to interpret department ID
 * 05/31/2018|zthale|KACE:23044 - Added pagination functionality with table, removed original table sorter code, since dataTable provides sorting.
 * 06/04/2018|zthale|KACE:23044 - Added embedded <style> properties to fix minor CSS issues with text being cut-off from header, and font decreasing in size w/ Bootstrap.
 * 06/20/2018|zthale|KACE:23044 - Edited table properties to be more uniform among other site tables.
 * 07/05/2018|zthale|KACE:23088 - Adjusted table style properties to conform to new website redesign.
 * **************************************************************************************************************************************** */
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.0/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.4.0/r-2.2.2/rg-1.0.3/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js"></script>
<script src="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.full.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/custom-data-source/dom-text.js"></script>
<style>
    .check:focus {
        border-color: transparent;
        box-shadow: none;
    }
    .modal-content {
        width: 100% !important;
        max-width: 1080px !important;
    }
</style>
<div class="modal fade" id="edit-user-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-light" style="min-height:725px;">
            <div class="modal-header pb-0 border-bottom-0">
                <ul class="nav nav-tabs w-100" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#user-edit" aria-controls="user-edit" role="tab" data-toggle="tab">User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#permission-edit" aria-controls="permission-edit" role="tab" data-toggle="tab">Permissions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#roles-edit" aria-controls="roles-edit" role="tab" data-toggle="tab">Roles</a>
                    </li>
                </ul>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0" style="max-height: 630px;">
                <div class="tab-content border-left border-right border-bottom">
                    <div role="tabpanel" class="tab-pane fade show active" id="user-edit">
                        <div class="container bg-white">
                            <div class="form-row pt-2" id="user-form-content">
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="permission-edit">
                        <div class="container bg-white">
                            <div class="form-row pt-2" id="permissions-form-content">
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="roles-edit">
                        <div class="container bg-white">
                            <div class="form-row pt-2" id="qc-roles-content">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-basic" data-dismiss="modal" id="edit-user-close">Close</button>
                <button type="button" class="btn btn-vprop-blue-medium edit-user-submit " id="edit-user-submit">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <h4>Silicore Users</h4>
    <div class="card">
        <div class="card-header" id="user-card-header">
        </div>
        <div class="card-body" id="user-card-body">
            <div style="text-align:center;">
                <div class="loader" id="loader" style="display:inline-block;"><img src="..\..\Images\vprop_logo_navbar.gif" style='width:55%;'/><span class="text-align-center">Processing</span></div>
            </div>
            <div class="table-responsive-xl hide" id="table-wrapper">
                <table class="table table-xl table-striped table-hover table-bordered nowrap" id='users-table' style="width: 100%;">
                    <thead class="th-vprop-blue-medium">
                    <tr>
                        <th>ID&ensp;</th>
                        <th>First Name&ensp;</th>
                        <th>Last Name</th>
                        <th>Display Name</th>
                        <th>Email</th>
                        <th>Company&ensp;</th>
                        <th>Department</th>
                        <th>User Type</th>
                        <th>Last Login</th>
                        <th>Start Date</th>
                        <th>Separation Date</th>
                        <th>Status&ensp;</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer" id="user-card-footer">
        </div>
    </div>
</div>

<script>
    $(function () {
        let globalData = null;
        let date = new Date().toDateString();
        let $usersTable = $('#users-table').DataTable({
            dom: "<\'row\'<\'col-xl-12\'Bf>>" + "<\'row\'<\'col-xl-12\'tr>>" + "<\'row\'<\'col-xl-5\'i><\'col-xl-7\'p>>",
            ajax: {url: '../../Includes/Development/allusersget.php', dataSrc: ""},
            scrollY: '500px',
            pageLength: 100,
            //scrollX: true,
            columns: [
                {data: 'id'},
                {data: 'first_name'},
                {data: 'last_name'},
                {data: 'display_name'},
                {data: 'email'},
                {data: 'company'},
                {
                    data: 'main_department_id', render: function (data) {
                        switch (parseInt(data)) {
                            case 1:
                                return "General";
                            case 2:
                                return "Development";
                            case 3:
                                return "Production";
                            case 4:
                                return "Quality Control";
                            case 5:
                                return "Loadout";
                            case 6:
                                return "Logistics";
                            case 7:
                                return "Accounting";
                            case 8:
                                return "Safety";
                            case 9:
                                return "Human Resources";
                            case 10:
                                return "Information Technology";
                            default:
                                return "No Department";
                        }
                    }
                },
                {
                    data: 'user_type_id', render: function (data) {
                        switch (parseInt(data)) {
                            case 1:
                                return "Standard";
                            case 2:
                                return "Shift Lead";
                            case 3:
                                return "Manager";
                            case 4:
                                return "Director";
                            case 5:
                                return "Administrator";
                            case 6:
                                return "Read Only";
                            default:
                                return "No Type ID found";
                        }
                    }
                },
                {
                    data: 'last_logged', render: function (data) {
                        return data !== null ? data : 'Not found';
                    }
                },
                {data: 'start_date', visible: false},
                {data: 'separation_date', visible: false},
                {
                    data: 'is_active', render: function (data) {
                        return data === '1' ? 'Active' : 'Inactive';
                    }
                },
                {
                    data: null, render: function (row, meta, type, data) {
                        return '<button type="button" class="btn btn-basic edit-user"><i class="fa fa-edit text-success"></i></button>';
                    }
                }
            ],
            buttons: [{extend: 'excel', text: 'Export', className: 'users-export', title: 'Silicore Users Export ' + date}],
            initComplete: function () {
                $('#loader').remove();
                $('#table-wrapper').show();
                $("#users-table_length").remove();
                $("#users-table_filter").detach().appendTo('#user-card-header').addClass('form-inline float-left');
                $("#users-table_paginate").detach().appendTo('#user-card-footer').addClass('float-right');
                $("#users-table_info").detach().appendTo('#user-card-footer').addClass('float-left');
                $(".users-export").detach().appendTo('#user-card-header').removeClass().addClass('btn btn-vprop-green form-inline float-right');
                $('.dataTables_scrollBody').css("height", "unset").css("max-height", "500px");
                $('#users-table_wrapper').css('width', '100%');
                $('#users-table').DataTable().columns.adjust();
            }
        });
        let $userModal = $('#edit-user-modal');

        $('#users-table tbody').on('click', 'tr .edit-user', function () {
            let data = $usersTable.row($(this).closest('tr')).data();
            globalData = data;
            editUserForm(data);
            $('#user-edit-tab').addClass('active');
            $('[href="#user-edit"]').tab('show');
            $('#edit-user-modal').modal('toggle');
        });
        $('#permissions-form-content').on('click', '.permission-checkbox', function () {
            let elem = Object();
            elem.self = $(this);
            elem.id = elem.self.prop('id');
            let genSelect = $('#General-select');
            let gbQcSelect = $('#QC-Granbury-select');
            let tlQcSelect = $('#QC-Tolar-select');
            let wtQcSelect = $('#QC-west-texas-select');
            let hrSelect = $('#HR-select');
            let itSelect = $('#IT-select');
            let devSelect = $('#Development-select');
            let safetySelect = $('#Safety-select');
            let logSelect = $('#Logistics-select');
            let prodSelect = $('#Production-select');
            let loadSelect = $('#Loadout-select');
            checkbox(elem.self);
            if (elem.id === 'General-check') {
                if (elem.self.val() === '1') {
                    genSelect.prop('disabled', false);
                    genSelect.val(1);
                } else {
                    genSelect.prop('disabled', true);
                    genSelect.val(-1);
                }
            }
            if (elem.id === 'Development-check') {
                if (elem.self.val() === '1') {
                    devSelect.prop('disabled', false);
                    devSelect.val(1);
                } else {
                    devSelect.prop('disabled', true);
                    devSelect.val(-1);
                }
            }
            if (elem.id === 'Production-check') {
                if (elem.self.val() === '1') {
                    prodSelect.prop('disabled', false);
                    prodSelect.val(1);
                } else {
                    prodSelect.prop('disabled', true);
                    prodSelect.val(-1);
                }
            }
            if (elem.id === 'QC-Granbury-check') {
                if (elem.self.val() === '1') {
                    gbQcSelect.prop('disabled', false);
                    gbQcSelect.val(1);
                } else {
                    gbQcSelect.prop('disabled', true);
                    gbQcSelect.val(-1);
                }
            }
            if (elem.id === 'QC-Tolar-check') {
                if (elem.self.val() === '1') {
                    tlQcSelect.prop('disabled', false);
                    tlQcSelect.val(1);
                } else {
                    tlQcSelect.prop('disabled', true);
                    tlQcSelect.val(-1);
                }
            }
            if (elem.id === 'QC-west-texas-check') {
                if (elem.self.val() === '1') {
                    wtQcSelect.prop('disabled', false);
                    wtQcSelect.val(1);
                } else {
                    wtQcSelect.prop('disabled', true);
                    wtQcSelect.val(-1);
                }
            }
            if (elem.id === 'Logistics-check') {
                if (elem.self.val() === '1') {
                    logSelect.prop('disabled', false);
                    logSelect.val(1);
                } else {
                    logSelect.prop('disabled', true);
                    logSelect.val(-1);
                }
            }
            if (elem.id === 'Safety-check') {
                if (elem.self.val() === '1') {
                    safetySelect.prop('disabled', false);
                    safetySelect.val(1);
                } else {
                    safetySelect.prop('disabled', true);
                    safetySelect.val(-1);
                }
            }
            if (elem.id === 'HR-check') {
                if (elem.self.val() === '1') {
                    hrSelect.prop('disabled', false);
                    hrSelect.val(1);
                } else {
                    hrSelect.prop('disabled', true);
                    hrSelect.val(-1);
                }
            }
            if (elem.id === 'IT-check') {
                if (elem.self.val() === '1') {
                    itSelect.prop('disabled', false);
                    itSelect.val(1);
                } else {
                    itSelect.prop('disabled', true);
                    itSelect.val(-1);
                }
            }
            if (elem.id === 'Loadout-check') {
                if (elem.self.val() === '1') {
                    loadSelect.prop('disabled', false);
                    loadSelect.val(1);
                } else {
                    loadSelect.prop('disabled', true);
                    loadSelect.val(-1);
                }
            }
        });
        $userModal.on('shown.bs.modal', function() {
           $.when(permissionsGet(globalData)).done(function() {

           });
        });
        $userModal.on('hidden.bs.modal', function () {
            clearForm();
        });
        $('#qc-roles-content').on('click', 'button', function () {
            checkbox($(this));
        });
        $('#edit-user-submit').on('click', function () {
            let formData = {};
            formData['current_user'] = <?php echo $_SESSION['user_id']; ?>;
            let permissionForm = $('#permissions-form-content');
            let rolesInputs = $('#roles-edit input, #roles-edit select, #roles-edit button');
            let permissionInputs = $('#permissions-form-content input, #permissions-form-content select, #permissions-form-content button');
            if (permissionForm.length === 1) {
                $.when(permissionsGet(globalData)).done(function () {
                    permissionInputs.each(function () {
                        let value = $(this).val();
                        let key = $(this).attr('id');
                        formData[key] = value;
                    });
                    rolesInputs.each(function () {
                        let value = $(this).val();
                        let key = $(this).attr('id');
                        if (value === ""){
                            value = '0';
                        }
                        formData[key] = value;

                    });
                    $('#permissions-form-content').children().remove();
                    $('#qc-roles-content').children().remove();
                });
            } else {
                permissionInputs.each(function () {
                    let value = $(this).val();
                    let key = $(this).attr('id');
                    formData[key] = value;
                });
                rolesInputs.each(function () {
                    let value = $(this).val();
                    let key = $(this).attr('id');
                    if (value === ""){
                        value = '0';
                    }
                    formData[key] = value;
                    console.log(formData);
                });
            }
            let userInputs = $('#user-edit input, #user-edit select');
            userInputs.each(function () {
                let value = $(this).val();
                let key = $(this).attr('id');
                formData[key] = value;
            });
            $('#edit-user-modal').modal('hide');
            $.ajax({
                url: '../../Includes/Development/silicoreuserupdate.php',
                type: 'POST',
                data: JSON.stringify(formData),
                success: function(data) {
                    console.log(data);
                    let response = JSON.parse(data);
                    if(response.user === 1 && response.permissions === 1){
                        successAlert('Changes made successfully!');
                    }
                    else if(response.user === 0 && response.permissions === 1){
                        successAlert('Changes made successfully!');
                    }
                    else if(response.user === '[]' && response.permissions === 1){
                        successAlert('Changes made successfully!');
                    } else {
                        errorAlert('Something went wrong');
                    }

                },
                complete: function() {
                    $usersTable.ajax.reload();
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

    function editUserForm(data) {
        let form = $('#user-form-content');
        if (data.separation_date === null) {
            data.separation_date = "";
        }
        let gStart = '<div class="col-xl-12"><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text bg-transparent border-0" style="width:115px;">';
        let groupEnd = '</div></div>';
        let idInput = gStart + 'ID</span></div><input id="id-input" type="text" class="form-control rounded-left" value="' + data.id + '" disabled>' + groupEnd;
        let name = gStart + 'Name</span></div><input id="first-name" type="text" class="form-control" value="' + data.first_name + '"><input id="last-name" type="text" class=form-control value="' + data.last_name + '">' + groupEnd;
        let displayName = gStart + 'Display</span></div><input id="display-name" type="text" class="form-control rounded-left" value="' + data.display_name + '">' + groupEnd;
        let email = gStart + 'Email</span></div><input id="email" type="text" class="form-control rounded-left" value="' + data.email + '">' + groupEnd;
        let company = gStart + 'Company</span></div><input id="company" type="text" class="form-control rounded-left" value="' + data.company + '">' + groupEnd;
        let department = gStart + 'Department</span></div><select id="department" type="text" class="form-control rounded-left"></select>' + groupEnd;
        let userType = gStart + 'User Type</span></div><select id="user-type" class="form-control rounded-left"></select>' + groupEnd;
        let lastLogin = gStart + 'Last Login</span></div><input id="last-logged" type="text" class="form-control rounded-left" value="' + data.last_logged + '" disabled>' + groupEnd;
        let dates = gStart + 'Start & End</span></div><input id="start-date" type="text" class="form-control rounded-left" value="' + data.start_date + '"><input id="separation-date" type="text" class=form-control value="' + data.separation_date + '">' + groupEnd;
        let status = gStart + 'Status</span></div><select id="status" type="text" class="form-control rounded-left"><option value="0">Inactive</option><option value="1">Active</option>' + groupEnd;
        let userForm = idInput + name + displayName + email + company + department + userType + lastLogin + dates + status;
        form.append(userForm);
        selectBoxFill(data);
        form.find('#status').val(data.is_active);
    }

    function selectBoxFill(data) {
        let userData = data;
        let form = $('#user-form-content');
        $.ajax({
            url: '../../Includes/Development/departmentsget.php',
            dataSrc: '',
            success: function (response) {
                let data = JSON.parse(response);
                $.each(data, function (key, value) {
                    form.find('#department').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                form.find('#department').val(userData.main_department_id);
            }
        });
        $.ajax({
            url: '../../Includes/Development/usertypesget.php',
            dataSrc: '',
            success: function(response) {
                let data = JSON.parse(response);
                $.each(data, function (key, value) {
                    form.find('#user-type').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                form.find('#user-type').val(userData.user_type_id);
            }
        });

    }

    function permissionsGet(globalData) {
        $.ajax({
            url: '../../Includes/Development/departmentsget.php',
            dataSrc: '',
            success: function (response) {
                let data = JSON.parse(response);
                let pForm = $('#permissions-form-content');
                let hasQC = 0;
                $.each(data, function (key, value) {
                    let dept = value.name;
                    if (value.name === 'QC') {
                        let sites = ['Granbury', 'Tolar', 'West_Texas'];
                        $.each(sites, function (index, value) {
                            if (value === 'West_Texas') {
                                let pGroupStart = '<div class="form-group form-check-inline col-xl-12">';
                                let pGroupEnd = '</div>';
                                let label = '<label for="' + dept + '-check" class="mt-2" style="width:280px;">' + dept + ' - West Texas</label>';
                                let button = '<button type="button" class="btn bg-transparent ml-2 permission-checkbox check check" id="' + dept + '-west-texas-check"><i class="far fa-square text-secondary"></i></button>';
                                let select = '<select class="form-control ml-2" id="' + dept + '-west-texas-select" title="' + dept + ' West Texas Permission"></select>';
                                let permissionForm = pGroupStart + label + button + select + pGroupEnd;
                                pForm.append(permissionForm);
                            } else {
                                let pGroupStart = '<div class="form-group form-check-inline col-xl-12">';
                                let pGroupEnd = '</div>';
                                let label = '<label for="' + dept + '-check" class="mt-2" style="width:280px;">' + dept + ' - ' + value + '</label>';
                                let button = '<button type="button" class="btn bg-transparent ml-2 permission-checkbox check" id="' + dept + '-' + value + '-check"><i class="far fa-square text-secondary"></i></button>';
                                let select = '<select class="form-control ml-2" id="' + dept + '-' + value + '-select" title="' + dept + ' ' + value + ' Permission"></select>';
                                let permissionForm = pGroupStart + label + button + select + pGroupEnd;
                                pForm.append(permissionForm);
                            }
                        });
                        hasQC = 1;
                    } else {
                        if (dept !== 'Accounting') {
                            let pGroupStart = '<div class="form-group form-check-inline col-xl-12">';
                            let pGroupEnd = '</div>';
                            let label = '<label for="' + dept + '-check" class="mt-2" style="width:280px;">' + value.name + '</label>';
                            let button = '<button type="button" class="btn bg-transparent ml-2 permission-checkbox check" id="' + value.name + '-check"><i class="far fa-square text-secondary"></i></button>';
                            let select = '<select class="form-control ml-2" id="' + value.name + '-select" title="' + value.name + ' Permission"></select>';
                            let permissionForm = pGroupStart + label + button + select + pGroupEnd;
                            pForm.append(permissionForm);
                        }
                    }

                });
                if (hasQC === 1) {
                    let rolesForm = $('#qc-roles-content');
                    let fgStart = '<div class="form-group form-check-inline col-xl-12">';
                    let fgEnd = '</div>';
                    let samplerLabel = '<label for="sampler-check" class="mt-2" style="width:55px;">Sampler</label>';
                    let samplerButton = '<button type="button" class="btn bg-transparent ml-2 sampler-check check" id="sampler-check"><i class="far fa-square text-secondary"></i></button>';
                    let labtechLabel = '<label for="labtech-check" class="mt-2" style="width:55px;">Labtech</label>';
                    let labtechButton = '<button type="button" class="btn bg-transparent ml-2 labtech-check check" id="labtech-check"><i class="far fa-square text-secondary"></i></button>';
                    let operatorLabel = '<label for="operator-check" class="mt-2" style="width:55px;">Operator</label>';
                    let operatorButton = '<button type="button" class="btn bg-transparent ml-2 operator-check check" id="operator-check"><i class="far fa-square text-secondary"></i></button>';
                    rolesForm.append(fgStart + operatorLabel + operatorButton + fgEnd + fgStart + samplerLabel + samplerButton + fgEnd + fgStart + labtechLabel + labtechButton + fgEnd);
                }
            },
            complete: function () {
                $.ajax({
                    url: '../../Includes/Development/permissionsget.php',
                    dataSrc: '',
                    success: function (response) {
                        let data = JSON.parse(response);
                        $.each(data, function (key, value) {
                            $('#permissions-form-content select').append('<option value="' + value.value + '">' + value.name + '</option>');
                        });
                        $('#permissions-form-content select').append($('<option>', {value: -1, text: 'None'}));
                    },
                    complete: function () {
                        let formData = {};
                        formData['user_id'] = $('#id-input').val();
                        $.ajax({
                            url: '../../Includes/Development/permissionsbyuserget.php',
                            type: 'POST',
                            data: JSON.stringify(formData),
                            success: function (response) {
                                let data = JSON.parse(response);
                                let genSelect = $('#General-select');
                                let gbQcSelect = $('#QC-Granbury-select');
                                let tlQcSelect = $('#QC-Tolar-select');
                                let wtQcSelect = $('#QC-west-texas-select');
                                let hrSelect = $('#HR-select');
                                let itSelect = $('#IT-select');
                                let devSelect = $('#Development-select');
                                let safetySelect = $('#Safety-select');
                                let logSelect = $('#Logistics-select');
                                let prodSelect = $('#Production-select');
                                let loadSelect = $('#Loadout-select');
                                let permissions = {};
                                $.each(data, function (key, value) {
                                    if (value.permission === 'qc') {
                                        if (value.site === 'granbury') {
                                            permissions['gbqc'] = value.permission_level;
                                        }
                                        if (value.site === 'tolar') {
                                            permissions['tlqc'] = value.permission_level;
                                        }
                                        if (value.site === 'west_texas') {
                                            permissions['wtqc'] = value.permission_level;
                                        }
                                    } else {
                                        permissions[value.permission] = value.permission_level;
                                    }
                                });
                                if ('general' in permissions) {
                                    checkbox($('#General-check'));
                                    genSelect.val(permissions.general);
                                } else {
                                    genSelect.prop('disabled', true);
                                    genSelect.val(-1);
                                }
                                if ('gbqc' in permissions) {
                                    checkbox($('#QC-Granbury-check'));
                                    gbQcSelect.val(permissions.gbqc);
                                } else {
                                    gbQcSelect.prop('disabled', true);
                                    gbQcSelect.val(-1);
                                }
                                if ('tlqc' in permissions) {
                                    checkbox($('#QC-Tolar-check'));
                                    tlQcSelect.val(permissions.tlqc);
                                } else {
                                    tlQcSelect.prop('disabled', true);
                                    tlQcSelect.val(-1);
                                }
                                if ('wtqc' in permissions) {
                                    checkbox($('#QC-west-texas-check'));
                                    wtQcSelect.val(permissions.wtqc);
                                } else {
                                    wtQcSelect.prop('disabled', true);
                                    wtQcSelect.val(-1);
                                }
                                if ('hr' in permissions) {
                                    checkbox($('#HR-check'));
                                    hrSelect.val(permissions.hr);
                                } else {
                                    hrSelect.prop('disabled', true);
                                    hrSelect.val(-1);
                                }
                                if ('it' in permissions) {
                                    checkbox($('#IT-check'));
                                    itSelect.val(permissions.it);
                                } else {
                                    itSelect.prop('disabled', true);
                                    itSelect.val(-1);
                                }
                                if ('development' in permissions) {
                                    checkbox($('#Development-check'));
                                    devSelect.val(permissions.development);
                                } else {
                                    devSelect.prop('disabled', true);
                                    devSelect.val(-1);
                                }
                                if ('safety' in permissions) {
                                    checkbox($('#Safety-check'));
                                    safetySelect.val(permissions.safety);
                                } else {
                                    safetySelect.prop('disabled', true);
                                    safetySelect.val(-1);
                                }
                                if ('logistics' in permissions) {
                                    checkbox($('#Logistics-check'));
                                    logSelect.val(permissions.logistics);
                                } else {
                                    logSelect.prop('disabled', true);
                                    logSelect.val(-1);
                                }
                                if ('production' in permissions) {
                                    checkbox($('#Production-check'));
                                    prodSelect.val(permissions.production);
                                } else {
                                    prodSelect.prop('disabled', true);
                                    prodSelect.val(-1);
                                }
                                if ('loadout' in permissions) {
                                    checkbox($('#Loadout-check'));
                                    loadSelect.val(permissions.loadout);
                                } else {
                                    loadSelect.prop('disabled', true);
                                    loadSelect.val(-1);
                                }
                                let result = [];
                                if (globalData.qc_operator === '1') {
                                    checkbox($('#operator-check'));
                                    result.push('Operator');
                                }
                                if (globalData.qc_sampler === '1') {
                                    checkbox($('#sampler-check'));
                                    result.push('Sampler');
                                }
                                if (globalData.qc_labtech === '1') {
                                    checkbox($('#labtech-check'));
                                    result.push('Labtech');
                                }
                                if (result.length <= 0) {
                                    $('#roles-feedback').text('Current: None');
                                }
                                if (result.length > 0 && result.length < 2) {
                                    $('#roles-feedback').text('Current: (' + result + ')');
                                }
                                if (result.length > 1 && result.length < 3) {
                                    $('#roles-feedback').text('Current: (' + result.join(' and ') + ')');
                                }
                                if (result.length > 2) {
                                    $('#roles-feedback').text('Current: (' + result.join(', ') + ')');
                                }
                            }

                        });
                    }
                });
            }
        }).done(function () {
                return this;
            });
    }

    function clearForm() {
        $('#user-form-content').children().remove();
        $('#permissions-form-content').children().remove();
        $('#qc-roles-content').children().remove();
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
</script>