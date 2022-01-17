<?php
/**
 * Created by PhpStorm.
 * User: whildebrandt
 * Date: 8/1/2018
 * Time: 12:24 PM
 */


include_once('../../Includes/HR/hrFunctions.php');
?>

<link rel="stylesheet" type="text/css"
      href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.css"/>
<link type="text/css" rel="stylesheet"
      href="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.css">
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.js"
        defer="defer"></script>

<a class="btn btn-secondary float-left text-white mt-1" role="button" href="hrchecklist.php">Back to Registration</a>
<div class="container-fluid" style="width:75%; margin-top: 1%;">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xl-4">
                    <h2>Job Titles</h2>
                </div>
                <div class="col-xl-4"></div>
                <div class="col-xl-4">
                    <button class="btn btn-light" type="button" id="minimize-card-content" style="margin-top:1%;float:right;"><span><i class="fas fa-window-minimize"
                                                                                                                                       style="margin-bottom:50%;"></span></i></button>
                </div>
            </div>
    </div>
        <div id="job-title-card-content">
            <div class="card-body">
                <div id="add-form">
                    <form id="jobTitleForm" method='' action='' novalidate="novalidate">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <input type="hidden" id="userId" value="<?php echo $user_id; ?>">
                                    <div class="form-group col-lg-12">
                                        <label for="siteSelect">Site:</label>
                                        <select id="siteSelect" name="siteSelect" class="form-control">
                                            <option></option>
                                            <?php
                                            $siteObject = NULL;
                                            $siteObject = getSites();
                                            foreach ($siteObject as $siteItem) {
                                                if ($siteItem->vars["description"] == "Granbury") {
                                                    echo "<option value='10' selected>Granbury</option>"; //Select granbury by default.
                                                } else {
                                                    echo "<option value=" . $siteItem->vars["id"] . ">" . $siteItem->vars["description"] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="departmentSelect">Department:</label>
                                        <select id="departmentSelect" name="departmentSelect" class="form-control">
                                            <option></option>
                                            <?php
                                            $deptsObject = NULL;
                                            $deptsObject = getDepts();
                                            foreach ($deptsObject as $deptItem) {
                                                echo "<option value=" . $deptItem->vars["id"] . ">" . $deptItem->vars["name"] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="jobTitle">Job Title:</label>
                                        <input type="text" class="form-control" id="jobTitle" name="jobTitle" placeholder="Title">
                                    </div>
                                    <div class="form-group col-lg-12" style="display:none;">
                                        <label for="jobDescription">Description:</label>
                                        <input type="text" class="form-control" id="jobDescription" name="jobDescription"
                                               placeholder="Job description">
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="userTypeSelect">User Type:</label>
                                        <select id="userTypeSelect" name="userTypeSelect" class="form-control">
                                            <option></option>
                                            <?php
                                            $userTypeObject = NULL;
                                            $userTypeObject = getUserTypes();
                                            foreach ($userTypeObject as $userTypeItem) {
                                                if ($userTypeItem->vars["name"] == "Standard") {
                                                    echo "<option value='1' selected>Standard</option>"; //Select standard user by default.
                                                } else {
                                                    echo "<option value=" . $userTypeItem->vars["id"] . ">" . $userTypeItem->vars["name"] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class=" btn btn-vprop-green float-right" onclick="InsertJobTitle()">Add New Title</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="edit-form" style="display:none;">
                    <form id="job-title-update" action="" method="" novalidate="novalidate">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-lg-12"></div>
                                    <div class="form-group col-lg-12">
                                        <label for="idTextBox">ID:</label>
                                        <input type="text" id="idTextBox" class="form-control" value="<?php if (isset($_GET['id'])) {
                                            $id = $_GET['id'];
                                            echo $id;
                                        } else {
                                            echo '';
                                        } ?>" disabled>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="siteEditSelect">Site:</label>
                                        <select id="siteEditSelect" name="siteSelect" class="form-control">
                                            <option></option>
                                            <?php
                                            $siteObject = NULL;
                                            $siteObject = getSites();
                                            foreach ($siteObject as $siteItem) {
                                                if ($siteItem->vars["description"] == "Granbury") {
                                                    echo "<option value='10' selected>Granbury</option>"; //Select granbury by default.
                                                } else {
                                                    echo "<option value=" . $siteItem->vars["id"] . ">" . $siteItem->vars["description"] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="departmentEditSelect">Department:</label>
                                        <select id="departmentEditSelect" name="departmentSelect" class="form-control">
                                            <option></option>
                                            <?php
                                            $deptsObject = NULL;
                                            $deptsObject = getDepts();
                                            foreach ($deptsObject as $deptItem) {
                                                echo "<option value=" . $deptItem->vars["id"] . ">" . $deptItem->vars["name"] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="idTextBox">Job Title:</label>
                                        <input type="text" id="jobTitleEditTextBox" class="form-control" value="<?php if (isset($_GET['name'])) {
                                            $id = $_GET['name'];
                                            echo $id;
                                        } else {
                                            echo '';
                                        } ?>">
                                    </div>
                                    <div class="form-group col-lg-12" style="display:none;">
                                        <label for="idTextBox">Description:</label>
                                        <input type="text" id="descriptionEditTextBox" class="form-control" value="<?php if (isset($_GET['description'])) {
                                            $id = $_GET['description'];
                                            echo $id;
                                        } else {
                                            echo '';
                                        } ?>">
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="userTypeEditSelect">User Type:</label>
                                        <select id="userTypeEditSelect" name="userTypeSelect" class="form-control">
                                            <?php
                                            $userTypeObject = NULL;
                                            $userTypeObject = getUserTypes();
                                            foreach ($userTypeObject as $userTypeItem) {

                                                echo "<option value=" . $userTypeItem->vars["id"] . ">" . $userTypeItem->vars["name"] . "</option>";

                                            }


                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="isActiveEditSelect">Active:</label>
                                        <select class="form-control" id="isActiveEditSelect">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer" id="update-card-footer">
                                <button class="btn btn-secondary float-left" id="back-btn" onclick="goBack();">Cancel</button>
                                <button type="button" class=" btn btn-vprop-green float-right" onclick="updateJobTitle()">Update Title</button>
                            </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="jobTitlesTable" class="table table-xl table-bordered table-hover nowrap" style="background-color:white;">
                            <thead class="vprop-blue-medium" style="color:white;">
                            <tr>
                                <th class="vprop-blue-medium">ID</th>
                                <th class="vprop-blue-medium">Site</th>
                                <th class="vprop-blue-medium">Department</th>
                                <th class="vprop-blue-medium">Job Title</th>

                                <th>User Type</th>
                                <th>Active</th>
                                <th>Created Date</th>
                                <th>Created By</th>
                                <th>Modified Date</th>
                                <th>Modified By</th>
                                <th class="vprop-blue-medium">Edit</th>

                            </tr>
                            </thead>
                            <tbody id="tableBody">
                            <?php getJobTitles(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>


    function goBack() {
        $('#edit-form').hide();
        $('#add-form').show();
    }

    $(document).ready(function () {

        $("#minimize-card-content").click(function () {
            $("#job-title-card-content").slideToggle();
            $(".btn i").toggleClass('fas fa-window-maximize');
            $(".btn i").toggleClass('fas fa-window-minimize');
        });

        var table = $('#jobTitlesTable').DataTable({
            ajax: {
                url: "../../Includes/jobTitleData.json",
                dataSrc: "",
                type: 'POST',
            },
            columns: [
                {data: "id"},
                {data: "site_id"},
                //{data: "site_name"},
                {data: "department_id"},
                //{data: "department_name"},
                {data: "name"},
                //{data: "description"},
                {
                    data: "user_type_id",
                    render: function (data, type, row) {
                        switch (data) {
                            case '6':
                                return 'Read Only';
                                break;
                            case '1':
                                return 'Standard';
                                break;
                            case '2':
                                return 'Shift Lead';
                                break;
                            case '3':
                                return 'Manager';
                                break;
                            case '4':
                                return 'Director';
                                break;
                            case '5':
                                return 'Administrator';
                                break;
                        }
                    }
                },
                //{data: "user_type"},
                {
                    data: "is_active",
                    "render": function (data, type, row) {
                        switch (data) {
                            case '0' :
                                return 'No';
                                break;
                            case '1' :
                                return 'Yes';
                                break;
                            default :
                                return 'N/A';
                                break;
                        }

                    }
                },
                {data: "create_date"},
                {data: "create_user_id"},
                {data: "edit_date"},
                {data: "edit_user_id"},
                {
                    data: null,
                    sortable: false,
                    "render": function (data, type, row) {
                        return "<a class='btn btn-light' role='button' id='edit-btn' value='" + JSON.stringify(data) + "'><i class='fas fa-edit' style='color:green;'></i></a>";
                    }
                }
            ],
            processing: true,
            scrollY: "450px",
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            pageLength: 50,
            fixedColumn: true,
            fixedColumns:
                {
                    leftColumns: 1,
                    rightColumns: 1

                },
            order: [
                0,
                "desc"
            ]
        });
        $('#jobTitlesTable').on("click", "#edit-btn", function () {
            var data = table.row(this).data();

            $('html,body').animate({scrollTop: 0}, 'slow');
            $('#edit-form').show();
            $('#add-form').hide();

            $('#idTextBox').val(data.id);
            $('#siteEditSelect').val(data.site_id);
            $('#departmentEditSelect').val(data.department_id);
            $('#jobTitleEditTextBox').val(data.name);
            $('#descriptionEditTextBox').val(data.description);
            $('#userTypeEditSelect').val(data.user_type_id);
            $('#isActiveEditSelect').val(data.is_active);
        });
    });

    function InsertJobTitle() {
        var formData = {};
        formData["site"] = $('#siteSelect').val();
        formData["department"] = $('#departmentSelect').val();
        formData["title"] = $('#jobTitle').val();
        formData["description"] = $('#jobDescription').val();
        formData["user_type"] = $('#userTypeSelect').val();
        formData["is_active"] = $('#isActiveTextBox').val();
        formData["user_id"] = $('#userId').val();
        $('#jobTitleForm').on('click', function (event) {
            $.ajax
            ({
                dataType: "text",
                type: 'POST',
                url: '../../Includes/HR/jobtitlesubmit.php',
                data: JSON.stringify(formData),
                success: function (response) {
                    alert(response+' row(s) affected');
                    location.reload();
                }
            });
        });
    }

    function updateJobTitle() {
        var formData = {};
        formData["id"] = $('#idTextBox').val();
        formData["site"] = $('#siteEditSelect').val();
        formData["department"] = $('#departmentEditSelect').val();
        formData["title"] = $('#jobTitleEditTextBox').val();
        formData["description"] = $('#descriptionEditTextBox').val();
        formData["user_type"] = $('#userTypeEditSelect').val();
        formData["user_id"] = $('#userId').val();
        formData["is_active"] = $('#isActiveEditSelect').val();
        $('#job-title-update').on('click', function (event) {
            $.ajax
            ({
                type: 'POST',
                url: '../../Includes/HR/jobtitleupdate.php',
                data: JSON.stringify(formData),
                dataType: 'text',
                success: function (response) {
                    alert(response+' row(s) affected');
                    location.reload();
                }
            });

        });
    }

</script>