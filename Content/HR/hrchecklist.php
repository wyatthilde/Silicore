<?php
/*******************************************************************************************************************************************
 * File Name: hrchecklist.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[User]|[Task Ticket] - [development]
 * =========================================================================================================================================
 * 06/30/2017|ktaylor|KACE:16070 - Initial creation
 * 07/05/2017|ktaylor|KACE:16070 - Added Email functionality and Update SQL.
 * 07/06/2017|ktaylor|KACE:16070 - Fixed Update SQL by changing the way I disabled checkboxes.
 * 07/07/2017|ktaylor|KACE:16070 - Full functionality and changed to fetch_assoc.
 * 07/10/2017|ktaylor|KACE:16070 - Changed two page design to one page design.
 * 07/11/2017|ktaylor|KACE:16070 - Fixed 'model after'  bug, cleaned up switch case names and added CSS.
 * 07/13/2017|ktaylor|KACE:16070 - Added stored procedures for insert and update and noticed tinyint bug.
 * 07/14/2017|ktaylor|KACE:16070 - Added stored procedures for select and select by id, found and fixed tinyint bug, and erased the echo's
 *                                 for debugging.
 * 07/14/2017|ktaylor|KACE:16070 - Added link to edit employee by ID.
 * 07/21/2017|ktaylor|KACE:16070 - Added create_date, create_user_id.
 * 07/24/2017|ktaylor|KACE:16070 - Added edit_date, edit_user_id, and is_active.
 * 07/25/2017|ktaylor|KACE:16070 - Added dropdown for department_id linked to database table.
 * 08/09/2017|ktaylor|KACE:16070 - Added disable and checked to checkboxes.
 * 08/09/2017|ktaylor|KACE:16070 - Added Add 'Active' column with a 'Yes' or 'No' (based on the boolean, like if(is_active) then 'yes').
 * 08/09/2017|ktaylor|KACE:16070 - Commented out the 'ID' column.
 * 08/09/2017|ktaylor|KACE:16070 - Switched First, Last names in UI.
 * 08/11/2017|ktaylor|KACE:16070 - Added dropdown for sites linked to database table.
 * 08/14/2017|ktaylor|KACE:16070 - Added comments field, ie, table, form and sprocs.
 * 08/15/2017|ktaylor|KACE:16070 - Changed comment field size to 1024.
 * 08/18/2017|ktaylor|KACE:16070 - Created a super global server switch.
 * 08/21/2017|kkuehn|KACE:16069 - Fixing bugs, adding features for initial publishing.
 * 08/24/2017|ktaylor|KACE:16281 - Added the model after in both the insert case and update case for email request.
 * 08/24/2017|ktaylor|KACE:16282 - Added extra option with selected and disabled chosen for case 2 on line 368 in file hrchecklist.php.  Thus,
 *                                 "Please Select" grayed-out as well.
 * 09/05/2017|ktaylor|KACE:16070 - Spocs updated to drop procedure.
 * 09/05/2017|ktaylor|KACE:16281 - Model after field added for email.
 * 09/05/2017|ktaylor|KACE:16282 - Several spocs changed and 'General' department has been removed.
 * 09/08/2017|ktaylor|KACE:16591 - $SiteBuildType variable added multiple times to identify originating server.
 * 09/11/2017|ktaylor|KACE:16591 - $SiteBuildType variable moved to end of the subject line.
 * 09/22/2017|ktaylor|KACE:18732 - $HRProgram variable addded for employee id (paycom).
 * 09/22/2017|ktaylor|KACE:18779 - Enlarged comment box and fixed CSS.
 * 09/25/2017|ktaylor|KACE:18780 - $datepicker added for start date and separation date.
 * 09/25/2017|ktaylor|KACE:18780 - Start date replace create date on first page.
 * 09/25/2017|ktaylor|KACE:18780 - Added line in script to pre-select start date.
 * 09/25/2017|kkuehn|KACE:18773 - Added more fields to hr_checklist.
 * 09/27/2017|ktaylor|KACE:18774 - Added job title dropdown.
 * 10/06/2017|whildebrandt|KACE:18984 - Added text boxes and associated variables. Altered sprocs for compatibility.
 * 10/06/2017|nolliff|KACE:18775 - Populated textboxes from data from table, altered email funtions
 * 10/09/2017|nolliff|KACE:18775 - Fixed bug caused by lack of assignment of user_id.
 * 10/09/2017|nolliff|KACE:18775 - Changed EmpUpdate and EmpInsert to use now() isntead of a date passed to sproc to fix bug
 * 10/09/2017|nolliff|KACE:18775 - added placeholders to detial fields
 * 10/11/2017|nolliff|KACE:18775 - Fixed sproc call to properly handle dates, now passes null rather than a placeholder date for start and
 *                                 separation dates
 * 10/11/2017|nolliff|KACE:18794 - Job titles now dynamically generate when department is selected, prepopulation still functions.
 * 10/17/2017|ktaylor|KACE:18776 - JavaSript added to dynamically generate Manager.
 * 10/19/2017|ktaylor|KACE:18794 - Edit page updated to include new changes with Job Titles and Manager.
 * 10/19/2017|ktaylor|KACE:18776 - Manager changed from text to id.
 * 10/23/2017|ktaylor|KACE:18777 - Javascript added to dynamically generate Silicore Model After.
 * 10/26/2017|ktaylor|KACE:18777 - Add user and edit user functioning for Modle After.
 * 10/26/2017|ktaylor|KACE:18777 - Fixed adjustment email for model after so it does not send out user_id.
 * 10/31/2017|ktaylor|KACE:18777 - Javascript added to dynamically generate Email Model After and add user done.
 * 10/31/2017|ktaylor|KACE:18776 - Changed manager to key off department onchange instead of job title onchange.
 * 11/13/2017|ktaylor|KACE:18xxx - Added 'Please Select' back to dropdowns.
 * 11/17/2017|ktaylor|KACE:18774 - Added 'is approved' to add user page.
 * 11/21/2017|ktaylor|KACE:18774 - Added 'is approved' to edit user page.
 * 11/22/2017|ktaylor|KACE:18774 - fixed UI bugs and moved order of operation for update.
 * 11/27/2017|ktaylor|KACE:18774 - Completed 'is approved' email functionality.
 * 12/06/2017|ktaylor|KACE:18774 - Fixed try throw catch and added it to edit user.
 * 12/11/2017|ktaylor|KACE:18774 - Fixed dropdown job title bug on edit user.
 * 01/10/2018|ktaylor|KACE:18774 - Added filter so manager can only see his department.
 * 01/10/2018|ktaylor|KACE:18774 - Disabled editing once is approved set.
 * 01/17/2018|nolliff|KACE:18774 - Doing some cleanup, changed buttons to allow ignoring of forms
 * 01/19/2018|nolliff|KACE:18774 - Added search bar
 * 01/23/2018|kkuehn|KACE:18774 - Removing [LIVE] from the email subject, adding global functionality for sending email requests. Cleaning up
 *                                code redundancies/syntax/usage issues.
 * 01/24/2018|kkuehn|KACE:18774 - Cleaning up code redundancies/syntax/usage issues. Continued work on global messaging functionality.
 * 02/06/2018|kkuehn|KACE:18774 - Cleaning up code redundancies/syntax/usage issues. Continued work on global messaging functionality.
 * 02/09/2018|kkuehn|KACE:18774/20765 - Cleaning up code redundancies/syntax/usage issues. Continued work on global messaging functionality.
 *                                      Adding manager name to the request email, rearranging email format. Removing Silicore Account Model
 *                                      from the UI and sp_hr_EmpInsert.
 * 02/16/2018|kkuehn|KACE:18774/20765 - Adding code/section-level permissions for all IT techs to be able to edit device/account text fields
 * 02/19/2018|kkuehn|KACE:18774/20765 - Continued clean up of context switching, redundant/ambiguous code, continued functionality adds.
 * 03/05/2018|kkuehn|KACE:18774/20765 - Continued clean up of context switching, redundant/ambiguous code, adding superglobal variable filtering
 * 03/06/2018|kkuehn|KACE:18774/20765 - Continued clean up of context switching, redundant/ambiguous code, adding superglobal variable filtering
 * 03/08/2018|kkuehn|KACE:18774/20765 - Continued clean up of context switching, redundant/ambiguous code, adding superglobal variable filtering.
 *                                      There are a lot of conditionals that can be changed to shorthand. Also need to remove a lot of commented
 *                                      code. Look into why there are includes on this page that should already be contained in the template.
 * 03/12/2018|kkuehn|KACE:18774/20765 - Continued as described above...removed more references to Silicore account model. Removing unneccessary
 *                                      line breaks in the UI.
 * 03/12/2018|kkuehn|KACE:18774/20765 - Continued as described above...removing all Silicore account model code altogether. We shouldn't need
 *                                      it in the future.
 * 04/24/2018|ktaylor|KACE:18774 - Fixed 'is approved' bug.
 * 04/26/2018|ktaylor|KACE:18774 - Fixed 'is active' bug.
 * 05/10/2018|ktaylor|KACE:20959 - Added uniforms, credit cards, business cards, fuel cards for add user case.
 * 05/10/2018|ktaylor|KACE:20765 - Changed IT tolkens.
 * 05/15/2018|ktaylor|KACE:20959 - Added uniforms, credit cards, business cards, fuel cards for edit user case.
 * 06/05/2018|zthale|KACE:23242 - Added form validation for Last Name and First Name fields.
 * 06/12/2018|zthale|KACE:23044 - Added embedded <style> properties to fix minor CSS issues with text being cut-off from header, and font decreasing in size w/ Bootstrap.
 * 06/25/2018|gndede|KACE:23088 - Added paginantion to the report view.
 * 06/26/2018|gndede|KACE:23450 - fixed the submit button to avoid double submit.
 * 08/07/2018|whildebrandt|24352 - Working on general CSS.
 ******************************************************************************************************************************************/

//==================================================================== BEGIN PHP
//include other files
require_once('/var/www/configuration/db-mysql-sandbox.php'); //contains database connection info
require_once('../../Includes/emailfunctions.php'); //contains email functionality
require_once('../../Includes/pagevariables.php'); //contains page-level globals
//suppress warning messages
error_reporting(E_ERROR | E_PARSE);
// Turn off all error reporting
error_reporting(0);

// Get the currently logged in user's information from the global object in /Includes/pagevariables.php
global $singleUserObject;

// <editor-fold defaultstate="collapsed" desc="Set Debugging Options">  
$debugging = 0; //set this to 1 to see debugging output
$currenttime = time();
if ($debugging) {
    echo("<b>Debugging Variables</b><br />");
    echo("\$PageName: " . $PageName . "<br />");
    echo("\$PageDept: " . $PageDept . "<br />");
    echo("User_ID: " . $singleUserObject->vars["id"] . "<br />");
    echo("User: " . $singleUserObject->vars["display_name"] . "<br />");
    echo("User deparment_id: " . $singleUserObject->vars["main_department_id"]);
    echo("<br /><br />");
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    echo("<br /><br />");
}
// </editor-fold>

include_once('../../Includes/HR/hrFunctions.php');
?>
<link rel="stylesheet" type="text/css"
      href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.css"/>
<link type="text/css" rel="stylesheet"
      href="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.css">
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-flash-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.js"
        defer="defer"></script>

<script src="../../Includes/jquery-ui-1.12.1.custom/datetimepicker/jquery.datetimepicker.full.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=fo9qov044ipc78vge1lgx3p9zxxjg7y012b25wykieqcj191"></script>
<script>tinymce.init({selector: 'textarea'});</script>

<script>
    $(function () {
        $("#start-date").datetimepicker({dateFormat: 'yy-mm-dd'});
        $("#start-date").datetimepicker("setDate", new Date());
        $("#separation-date").datetimepicker({dateFormat: 'yy-mm-dd'});
        $("#start-date-edit").datetimepicker({dateFormat: 'yy-mm-dd'});
//  setSelection();
    });

    function searchNames() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("nameSearchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                }
                else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<?php
$dbc = databaseConnectionInfo();
$dbconn = new mysqli
(
    $dbc['silicore_hostname'],
    $dbc['silicore_username'],
    $dbc['silicore_pwd'],
    $dbc['silicore_dbname']
);
$jobTitleQuery = "call sp_hr_JobTitlesGetAll()";
$jobTitles = mysqli_query($dbconn, $jobTitleQuery);
mysqli_close($dbconn);

while ($jobTitle = $jobTitles->fetch_assoc()) {
    $titleNames[] = $jobTitle['name'];
    $titleIDs[] = $jobTitle['id'];
    $titleDescriptions[] = $jobTitle['description'];
    $titleDepartments[] = $jobTitle['department_id'];

    if (isset($_POST['editemployee']) && isset($_POST['id'])) {
        $dbc = databaseConnectionInfo();
        $dbconn = new mysqli
        (
            $dbc['silicore_hostname'],
            $dbc['silicore_username'],
            $dbc['silicore_pwd'],
            $dbc['silicore_dbname']
        );

        $Id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        $data005 = "call sp_hr_EmpSelectById('$Id')";
        $result005 = mysqli_query($dbconn, $data005);
        $row005 = mysqli_fetch_assoc($result005);
        mysqli_close($dbconn);
        $titleDepartments[] = $row005['department_id'];
    }
}

$dbconn = new mysqli
(
    $dbc['silicore_hostname'],
    $dbc['silicore_username'],
    $dbc['silicore_pwd'],
    $dbc['silicore_dbname']
);
$managerQuery = "call sp_hr_DeptManagersGetAll()";
$managerNames = mysqli_query($dbconn, $managerQuery);
mysqli_close($dbconn);

while ($managerName = $managerNames->fetch_assoc()) {
    $nameMgrnames[] = $managerName['mgrname'];
    $nameIDs[] = $managerName['id'];
    $nameDepartments[] = $managerName['main_department_id'];
}

$dbconn = new mysqli
(
    $dbc['silicore_hostname'],
    $dbc['silicore_username'],
    $dbc['silicore_pwd'],
    $dbc['silicore_dbname']
);

$emailModelQuery = "call sp_hr_EmpGetAll()";
$emailModelAfters = mysqli_query($dbconn, $emailModelQuery);
mysqli_close($dbconn);

while ($emailModelAfter = $emailModelAfters->fetch_assoc()) {
    $emailModelNames[] = $emailModelAfter['empname'];
    $emailModelIDs[] = $emailModelAfter['id'];
    $emailModelDepartments[] = $emailModelAfter['main_department_id'];
}

?>

<script>
    function populateJobTitles() {
        var siteID = document.getElementById("slcSiteId").value;
        var departmentID = document.getElementById("slcDepartmentId").value;
        var titleSelect = document.getElementById("slcJobTitleId");
        var managerSelect = document.getElementById("slcManager");
        var emailModelSelect = document.getElementById("txtEmailAccountModel");

        var titleNames = <?php echo json_encode($titleNames); ?>;
        var titleIDs = <?php echo json_encode($titleIDs); ?>;
        //var titleDscrpts = <?php // echo json_encode($titleDescriptions); ?>;
        var titleDepts = <?php echo json_encode($titleDepartments); ?>;

        var nameMgrnames = <?php echo json_encode($nameMgrnames); ?>;
        var nameIDs = <?php echo json_encode($nameIDs); ?>;
        var nameDepts = <?php echo json_encode($nameDepartments); ?>;

        var emailModelNames = <?php echo json_encode($emailModelNames); ?>;
        var emailModelIDs = <?php echo json_encode($emailModelIDs); ?>;
        var emailModelDepts = <?php echo json_encode($emailModelDepartments); ?>;

        var titleCount = titleIDs.length;

        titleSelect.options.length = 0;

        var prePopOption = document.createElement("option");
        prePopOption.text = "Please Select";
        prePopOption.value = "0";
        titleSelect.add(prePopOption);

        for (i = 0; i < titleCount + 1; i++) {
            if (titleDepts[i] === departmentID) {
                var option = document.createElement("option");
                option.text = titleNames[i];
                option.value = titleIDs[i];
                titleSelect.add(option);
            }
        }

        var managerCount = nameIDs.length;

        managerSelect.options.length = 0;

        var prePopOption = document.createElement("option");
        prePopOption.text = "Please Select";
        prePopOption.value = "0";
        managerSelect.add(prePopOption);

        for (i = 0; i < managerCount; i++) {
            if (nameDepts[i] === departmentID) {
                var option = document.createElement("option");
                option.text = nameMgrnames[i];
                option.value = nameIDs[i];
                managerSelect.add(option);
            }
        }

        var emailModelCount = emailModelIDs.length;

        emailModelSelect.options.length = 0;

        var prePopOption = document.createElement("option");
        prePopOption.text = "Please Select";
        prePopOption.value = "0";
        emailModelSelect.add(prePopOption);

        for (i = 0; i < emailModelCount; i++) {
            if (emailModelDepts[i] === departmentID) {
                var option = document.createElement("option");
                option.text = emailModelNames[i];
                option.value = emailModelIDs[i];
                emailModelSelect.add(option);
            }
        }

    }
</script>


<script>
    $(document).ready(function () {
        $(".hide01").(function () {
            $("td").hide();
        });
    });
</script>

<?php

$dbc = databaseConnectionInfo();

// KACE:18774 - kkuehn: This switch should be kept specific to this page(s)
switch ($ServerSubDomain) {
    case "silicore-dev":
        $addressDev = "devteam@vistasand.com";
        $addressHelp = "devteam@vistasand.com";
        $addressUniform = "devteam@vistasand.com";
        $addressCreditCard = "devteam@vistasand.com";
        $addressFuelCard = "devteam@vistasand.com";
        $sendPHPMailDebugFlag = 1;
        break;
    case "silicore-test":
        $addressDev = "devteam@vistasand.com";
        $addressHelp = "devteam@vistasand.com";
        $addressUniform = "devteam@vistasand.com";
        $addressCreditCard = "devteam@vistasand.com";
        $addressFuelCard = "devteam@vistasand.com";
        $sendPHPMailDebugFlag = 1;
        break;
    case "silicore":
        $addressDev = "development@vistasand.com";
        $addressHelp = "help@vistasand.com";
        $addressUniform = "mine_uniforms@vprop.com";
        $addressCreditCard = "mine_ccrequest@vprop.com";
        $addressFuelCard = "mine_fuelcard@vprop.com";
        $sendPHPMailDebugFlag = 0;
        break;
    default:
        $addressDev = "devteam@vistasand.com";
        $addressHelp = "devteam@vistasand.com";
        $addressUniform = "devteam@vistasand.com";
        $addressCreditCard = "devteam@vistasand.com";
        $addressFuelCard = "devteam@vistasand.com";
        $sendPHPMailDebugFlag = 1;
        break;
}

// Set x according to current page action/purpose
// NOTE: 'x' (or PageAction, etc.) should be set at the form level in the HTML, then we could eliminate all of these if statements.
//       Granted, there is other logic happening here, but it could be handled with form-submit validation.
if (empty($_POST) || isset($_POST['selectallemployees'])) {
    $x = 1; // see all employees
}
if (isset($_POST['addemployee'])) {
    $x = 2; // create new employee    
}
if (isset($_POST['insertemployee']) && !empty($_POST['txtLastName']) && !empty($_POST['txtFirstName'])) {
    $x = 3; // create new employee then show employee table (with edit links)
}
if (isset($_POST['editemployee']) && isset($_POST['id'])) {
    $x = 5; // edit existing employee
}
if (isset($_POST['updateemployee'])) {
    $x = 6; // update existing employee then show employee table (with edit links)
}

switch ($x) {
    /**************************************************************************************************************************
     * CASE: Show all current employees **********************************************************************************CLEAN
     *************************************************************************************************************************/
    case 1:

        ?>
        <?php  if($userPermissionsArray['vista']['granbury']['hr'] >= 4)
    {
        echo('<a role="button" class="btn btn-vprop-blue" href="hrmanage.php" style="float:right; margin-top:1%; position:fixed; color:white;">Manage</a>');
    }
        ?>
        <div class="container" style="max-width:75%;">
            <!--<h2>Employee List</h2>-->
<div class="card">
    <div class="card-header">
        <h2>Registration Form</h2>
    </div>
    <div class="card-body">
                <form action="hrchecklist.php" method="POST">
                    <input type="submit" name="addemployee" value="Add New Employee" class="btn btn-vprop-green">
                    <br/><br/>

                    <?php

                    try {
                        $dbconn = new mysqli
                        (
                            $dbc['silicore_hostname'],
                            $dbc['silicore_username'],
                            $dbc['silicore_pwd'],
                            $dbc['silicore_dbname']
                        );
                        $employeesSQL = "call sp_hr_EmpSelect()";
                    } catch (Exception $e) {
                        echo 'Caught exception: ', $e->getMessage(), "\n";
                    }

                    $result01 = mysqli_query($dbconn, $employeesSQL);
                    mysqli_close($dbconn);

                    ?>

                    <!--<input type="text" id="nameSearchInput" onkeyup="searchNames()" placeholder="Search in Last Names..." title="Type in a name">-->
                    <br/><br/>
                    <table id="myTable" class="table table-bordered table-striped">
                        <!--<table id="developers" class="display" width="100%" cellspacing="0">-->


                        <thead style="background-color:#4C7AD0; color:white;">
                        <tr>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th><?php echo $HRProgram ?> ID</th>
                            <th>Department</th>
                            <th>Manager</th>
                            <th>Site</th>
                            <th>Start Date</th>
                            <th>Active?</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <?php
                        $UserDepartment = $singleUserObject->vars['main_department_id'];
                        $UserType = $singleUserObject->vars['user_type_id'];
                        $ManagerName = '';

                        while ($employee = mysqli_fetch_assoc($result01)) {
                            $dbconn = new mysqli
                            (
                                $dbc['silicore_hostname'],
                                $dbc['silicore_username'],
                                $dbc['silicore_pwd'],
                                $dbc['silicore_dbname']
                            );
                            $managerSQL = "call sp_hr_DeptManagersGetAll()";
                            $managerResults = mysqli_query($dbconn, $managerSQL);
                            mysqli_close($dbconn);

                            $NameManager = $employee['manager_user_id'];

                            while ($manager = mysqli_fetch_assoc($managerResults)) {
                                if ($NameManager == $manager['id']) {
                                    $ManagerName = $manager['mgrname'];
                                }

                            }
                            if (($UserDepartment == $employee['department_id'] && $UserType >= 3) ||
                                $UserDepartment == 9 || $UserDepartment == 10 || $UserType == 5) {
                                echo
                                ("
        <tr>      
        <td >{$employee['last_name']}</td>
        <td >{$employee['first_name']}</td>
        <td >{$employee['employee_id']}</td>
        <td >{$employee['name']}</td>
        <td >{$ManagerName}</td>            
        <td >{$employee['description']}</td>     
        <td >{$employee['start_date']}</td>
        <td >"
                                    . ($employee['is_active'] == '1' ? 'Yes' : 'No') . "
        </td>
        <td >
      ");

                                if ($employee['is_active'] == '1') {
                                    if ($UserType >= 3 || $userPermissionsArray['vista']['granbury']['hr'] >= 1 || $userPermissionsArray['vista']['granbury']['it'] >= 1) {
                                        echo
                                        ("
          <form method='post' action='hrchecklist.php' class='inline'>
            <input type='hidden' name='id' value='{$employee['id']}'>
            <button type='submit' name='editemployee' value='{$employee['id']}' class='btn'>
            <!--Edit--><i class='fa fa-edit' style='color:green'></i>
            </button>           
          </form> 
        ");
                                    }
                                }
                                echo("</td></tr>");
                            }
                        }
                        ?>

                    </table>

                    <br/></form>
                <input type="submit" name="addemployee" value="Add New Employee" class="btn btn-vprop-green">
    </div>
        </div>
        </div>
        <?php
        break;

    /**************************************************************************************************************************
     * CASE: Create new employee form *****************************************************************************************
     *************************************************************************************************************************/
    case 2:

        ?>
    <div class="container" style="width:75%;">
        <form name="form" method="POST" action="hrchecklist.php">
            <div class="jumbotron-fluid" style="background-color:white; padding: 1%;">
            <h2>Add New Employee</h2>
                <div class="form-row">
            <div class='form-group col-xl-6'>
                <div class='form-group col-xl'>
                    <label for="txtLastName">Last Name: </label>
                    <input type="text" title="Field must contain only alphabetical characters (max length of 32)." maxlength="32" name="txtLastName" pattern="[A-Za-z]{1,32}" class="form-control"
                           required>
                </div>
                <div class='form-group col-xl'>
                    <label for="txtFistName">First Name: </label>
                    <input type="text" title="Field must contain only alphabetical characters (max length of 32)." maxlength="32" name="txtFirstName" pattern="[A-Za-z]{1,32}" class="form-control"
                           required>
                </div>
                <div class="form-group col-xl">
                    <label for="txtEmployeeId"><?php echo $HRProgram ?> ID: </label>
                    <input type="text" class="form-control" name="txtEmployeeId" required/>
                </div>
                <div class="form-group col-xl">
                    <label for="slcSiteId">Site: </label>
                    <select class="form-control" name="slcSiteId" id="slcSiteId">
                        <?php
                        $dbconn = new mysqli
                        (
                            $dbc['silicore_hostname'],
                            $dbc['silicore_username'],
                            $dbc['silicore_pwd'],
                            $dbc['silicore_dbname']
                        );
                        $data021 = "call sp_hr_SiteSelect()";
                        $result021 = mysqli_query($dbconn, $data021);
                        mysqli_close($dbconn);

                        while ($row021 = mysqli_fetch_assoc($result021)) {
                            if ($row021['id'] == "10") {
                                echo "<option value='" . $row021['id'] . "' selected=\"selected\">" . $row021['description'] . "</option>'";
                            } else {
                                echo "<option value='" . $row021['id'] . "'>" . $row021['description'] . "</option>'";
                            }
                        }

                        ?>
                    </select>
                </div>
                <div class="form-group col-xl">
                    <label for="slcDepartmentId">Department: </label>
                    <select onchange="populateJobTitles()" class="form-control" name="slcDepartmentId" id="slcDepartmentId" required>
                        <?php
                        $dbconn = new mysqli
                        (
                            $dbc['silicore_hostname'],
                            $dbc['silicore_username'],
                            $dbc['silicore_pwd'],
                            $dbc['silicore_dbname']
                        );
                        $data02 = "call sp_hr_DeptSelect()";
                        $result02 = mysqli_query($dbconn, $data02);
                        mysqli_close($dbconn);

                        while ($row02 = mysqli_fetch_assoc($result02)) //starting with id 2 because id 1 is general
                        {
                            if ($row02['id'] == "2") {
                                echo "<option value='" . $row02['id'] . "' selected=\"selected\" disabled>Please Select</option>'";
                                echo "<option value='" . $row02['id'] . "'>" . $row02['name'] . "</option>";
                            } else {
                                echo "<option value='" . $row02['id'] . "'>" . $row02['name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-xl">
                    <label for="slcJobTitleId">Job Title: </label>
                    <select class="form-control" onchange="this.nextElementSibling.value=this.value"" name="slcJobTitleId" id="slcJobTitleId" required></select>
                </div>
                <div class="form-group col-xl">
                    <label for="slcManager">Manager: </label>
                    <select class="form-control" name="slcManager" id="slcManager" required></select>
                </div>
                <div class="form-group col-xl">
                    <label>Start Date: </label>
                    <input type="text" id="start-date" class="form-control" name="txtStartDate"/>
                </div>
                <div class="form-group col-xl">
                    <label for="txtSeparationDate">Separation Date: </label>
                    <input type="text" id="separation-date" class="form-control" name="txtSeparationDate"/>
                </div>
                <div class="form-group col-xl">
                    <fieldset style="border:solid 1px #ced4da; padding:1%;">
                    <legend>Status </legend>
                    <input type="hidden" name="chkIsActive" value="0"/>
                    <p><input type="checkbox" name="chkIsActive" class="form-check-inline" value="1" checked>
                    <label for="chkIsActive" class="form-check-label">Active </label></p>
                    <input type="hidden" name="chkIsApproved" class="form-check-inline" value="0"/>
                    <?php

                    if ($userPermissionsArray['vista']['granbury']['hr'] > 3) {
                        echo "<input type='checkbox' name='chkIsApproved' class='form-check-inline' value='1'>";
                    } else {
                        echo "<input type='checkbox' name='chkIsApproved' class='form-control' value='1' disabled>";
                    }

                    ?>
                    <label for="chkIsApproved" class="form-check-label">Approved </label>
                    </fieldset>
                </div>
                <div class="form-group col-xl">
                    <fieldset style="border:solid 1px #ced4da; padding:1%;">
                    <legend>Requests</legend>
                    <p><input type="hidden" name="chkUniformRequested" value="0"/>
                    <input type="checkbox" name="chkUniformRequested" value="1" class="form-check-inline">
                    <label for="chkUniformRequested" class="form-check-label">Uniform(s) </label></p>
                    <p><input type="hidden" name="chkBusinessCardsRequested" value="0">
                    <input type="checkbox" name="chkBusinessCardsRequested" value="1" class="form-check-inline">
                    <label for="chkBusinessCardsRequested" class="form-check-label">Business Cards </label></p>
                    <p><input type="hidden" name="chkFuelCardRequested" value="0"/>
                    <input type="checkbox" class="form-check-inline" name="chkFuelCardRequested" value="1" >
                    <label for="chkFuelCardRequested" class="form-check-label">Fuel Card</label></p>
                    <p><input type="hidden" name="chkCreditCardRequested" value="0"/>
                    <input type="checkbox" class="form-check-inline" name="chkCreditCardRequested" value="1">
                    <label for="chkCreditCardRequested" class="form-check-label">Credit Card</label></p>
                    </fieldset>
                </div>
            </div>
            <div class="form-group col-xl-6">
                <div class="form-group col-xl">
                    <fieldset style="border:solid 1px #ced4da; padding:1%;">
                        <legend>Accounts</legend>
                        <div class="form-check form-check-inline">
                            <input type="hidden" name="chkSilicoreAccountRequested" value="0"/>
                            <input type="checkbox" name="chkSilicoreAccountRequested" class="form-check-inline" value="1" checked>
                            <label for="chkSilicoreAccountRequested" class="form-check-label">Silicore </label>
                        </div>
                        <br/>
                        <br/>
                        <div class="form-check form-check-inline">
                            <input type="hidden" name="chkEmailAccountRequested" value="0"/>
                            <input type="checkbox" name="chkEmailAccountRequested" class="form-check-inline" value="1">
                            <label for="chkEmailAccountRequested" class="form-check-label">Email </label>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label for="txtEmailAccountModel">Model After:</label>
                            <select id="txtEmailAccountModel" class="form-control" name="txtEmailAccountModel"></select>
                        </div>
                    </fieldset>
                </div>
                <div class="form-group col-xl">
                    <input type="hidden" name="chkCellPhoneRequested" value="0"/>
                    <input type="checkbox" name="chkCellPhoneRequested" value="1">
                    <label>Cell Phone: &nbsp; </label>
                    <input type="text" name="txtCellPhoneRequested" class="form-control"
                           placeholder="Serial Number, Android/iPhone, etc.">
                </div>
                <div class="form-group col-xl">
                    <input type="hidden" name="chkLaptopRequested" value="0"/>
                    <input type="checkbox" name="chkLaptopRequested" value="1">
                    <label>Laptop: &nbsp; </label>


                    <input type="text" name="txtLaptopRequested" class="form-control"
                           placeholder="Serial number, model number, etc.">

                </div>
                <div class="form-group col-xl">

                    <input type="hidden" name="chkDesktopRequested" value="0"/>
                    <input type="checkbox" name="chkDesktopRequested" value="1">
                    <label>Desktop: </label>


                    <input type="text" name="txtDesktopRequested" class="form-control"
                           placeholder="Serial number, RAM, etc.">

                </div>
                <div class="form-group col-xl">

                    <label>Monitors: </label>


                    <input type="number" name="txtMonitorsRequested" class="form-control" placeholder="Number.">

                </div>
                <div class="form-group col-xl">

                    <input type="hidden" name="chkTabletRequested" value="0"/>
                    <input type="checkbox" name="chkTabletRequested" value="1">
                    <label>Tablet: </label>


                    <input type="text" name="txtTabletRequested" class="form-control"
                           placeholder="Serial Number, Android/iPad, etc.">

                </div>
                <div class="form-group col-xl">

                    <input type="hidden" name="chkTwoWayRadioRequested" value="0"/>
                    <input type="checkbox" name="chkTwoWayRadioRequested" value="1">
                    <label>Radio:</label>


                    <input type="text" name="txtTwoWayRadioRequested" class="form-control"
                           placeholder="Serial Number, etc.">

                </div>
                <div class="form-group col-xl">

                    <label>Software:;</label>


                    <input type="text" name="txtSpecialSoftwareRequested" class="form-control"
                           placeholder="Photoshop, CAD, etc." maxlength="45">

                </div>
                <div class="form-group col-xl">

                    <label>Comments:</label><br/>
                    <textarea id="hrformgrouparea" name="txaComments" class="hrTextArea" colspan="2" rows="17"
                              cols="50" maxlength="1024"></textarea>
                    <script type="text/javascript">
                        CKEDITOR.replace('hrformgrouparea');
                    </script>

                </div>
            </div>
        </div>
            <?php
            $user_id = $_SESSION["user_id"];
            $Date01 = date("Y/m/d H:i:s");
            ?>
            <input type="hidden" name="hidden"/>
            <input type="hidden" name="txtCreateDate" value="<?php echo($Date01) ?>"/>
            <input type="hidden" name="txtCreateUserId" value="<?php echo($user_id) ?>"/>
            <input type="submit" name="insertemployee" value="Save New Employee"
                   class="btn btn-vprop-green">&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" name="selectallemployees" value="See All Employees" class="btn btn-vprop-blue"
                   formnovalidate>&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
        </form>
    </div>
        <?php
        break;

    /**************************************************************************************************************************
     * CASE: Insert new employee, send email(s) if applicable, then show employee table again (with edit links) ***************
     *************************************************************************************************************************/
    case 3:

        ?>

        <!-- <h2>Employee List</h2>-->
        <fieldset>
            <legend>Employee List</legend>
            <div class="datagrid">

                <p id="demo"></p>
                <form action="hrchecklist.php" method="POST">

                    <input type="submit" name="addemployee" value="Save Employee" class="btn submitButton">
                    <br/><br/>

                    <?php
                    $dbconn = new mysqli
                    (
                        $dbc['silicore_hostname'],
                        $dbc['silicore_username'],
                        $dbc['silicore_pwd'],
                        $dbc['silicore_dbname']
                    );

                    $data031 = "call sp_hr_EmpGetAll()";
                    $result031 = mysqli_query($dbconn, $data031);

                    mysqli_close($dbconn);

                    $dbconn = new mysqli
                    (
                        $dbc['silicore_hostname'],
                        $dbc['silicore_username'],
                        $dbc['silicore_pwd'],
                        $dbc['silicore_dbname']
                    );

                    $data032 = "call sp_hr_EmpGetAll()";
                    $result032 = mysqli_query($dbconn, $data032);

                    mysqli_close($dbconn);

                    $nameEmailAccountModel = filter_input(INPUT_POST, 'txtEmailAccountModel', FILTER_SANITIZE_NUMBER_INT);

                    while ($row032 = mysqli_fetch_assoc($result032)) {
                        if ($nameEmailAccountModel == $row032['id']) {
                            $EmailAccountModelName = $row032['empname'];
                        }
                    }

                    $LastName = filter_input(INPUT_POST, 'txtLastName', FILTER_SANITIZE_STRING);
                    $FirstName = filter_input(INPUT_POST, 'txtFirstName', FILTER_SANITIZE_STRING);
                    $EmployeeId = filter_input(INPUT_POST, 'txtEmployeeId', FILTER_SANITIZE_NUMBER_INT);
                    $DepartmentId = filter_input(INPUT_POST, 'slcDepartmentId', FILTER_SANITIZE_NUMBER_INT);
                    $JobTitleId = filter_input(INPUT_POST, 'slcJobTitleId', FILTER_SANITIZE_NUMBER_INT);
                    $Manager = filter_input(INPUT_POST, 'slcManager', FILTER_SANITIZE_STRING);
                    $SiteId = filter_input(INPUT_POST, 'slcSiteId', FILTER_SANITIZE_NUMBER_INT);
                    $SilicoreAccountRequested = filter_input(INPUT_POST, 'chkSilicoreAccountRequested', FILTER_SANITIZE_NUMBER_INT);
                    $EmailAccountRequested = filter_input(INPUT_POST, 'chkEmailAccountRequested', FILTER_SANITIZE_NUMBER_INT);
                    $EmailAccountModel = filter_input(INPUT_POST, 'txtEmailAccountModel', FILTER_SANITIZE_STRING);
                    $UniformRequested = filter_input(INPUT_POST, 'chkUniformRequested', FILTER_SANITIZE_NUMBER_INT);
                    $BusinessCardsRequested = filter_input(INPUT_POST, 'chkBusinessCardsRequested', FILTER_SANITIZE_NUMBER_INT);
                    $FuelCardRequested = filter_input(INPUT_POST, 'chkFuelCardRequested', FILTER_SANITIZE_NUMBER_INT);
                    $CreditCardRequested = filter_input(INPUT_POST, 'chkCreditCardRequested', FILTER_SANITIZE_NUMBER_INT);
                    $CellPhoneRequested = filter_input(INPUT_POST, 'chkCellPhoneRequested', FILTER_SANITIZE_NUMBER_INT);
                    $CellPhoneDetail = filter_input(INPUT_POST, 'txtCellPhoneRequested', FILTER_SANITIZE_STRING);
                    $LaptopRequested = filter_input(INPUT_POST, 'chkLaptopRequested', FILTER_SANITIZE_NUMBER_INT);
                    $LaptopDetail = filter_input(INPUT_POST, 'txtLaptopRequested', FILTER_SANITIZE_STRING);
                    $DesktopRequested = filter_input(INPUT_POST, 'chkDesktopRequested', FILTER_SANITIZE_NUMBER_INT);
                    $DesktopDetail = filter_input(INPUT_POST, 'txtDesktopRequested', FILTER_SANITIZE_STRING);
                    $MonitorsRequested = filter_input(INPUT_POST, 'txtMonitorsRequested', FILTER_SANITIZE_STRING);
                    $TabletRequested = filter_input(INPUT_POST, 'chkTabletRequested', FILTER_SANITIZE_NUMBER_INT);
                    $TabletDetail = filter_input(INPUT_POST, 'txtTabletRequested', FILTER_SANITIZE_STRING);
                    $TwoWayRadioRequested = filter_input(INPUT_POST, 'chkTwoWayRadioRequested', FILTER_SANITIZE_STRING);
                    $TwoWayRadioDetail = filter_input(INPUT_POST, 'txtTwoWayRadioRequested', FILTER_SANITIZE_STRING);
                    $SpecialSoftwareRequested = filter_input(INPUT_POST, 'txtSpecialSoftwareRequested', FILTER_SANITIZE_STRING);
                    $Comments = filter_input(INPUT_POST, 'txaComments', FILTER_SANITIZE_STRING);
                    $ApprovedUserId = $_SESSION['user_id']; // filter_input(INPUT_SESSION,[sessvar],[filter]) is not implemented in PHP yet.
                    $CreateDate = filter_input(INPUT_POST, 'txtCreateDate', FILTER_SANITIZE_STRING);
                    $CreateUserId = filter_input(INPUT_POST, 'txtCreateUserId', FILTER_SANITIZE_STRING);

                    if (isset($_POST['txtStartDate']) && $_POST['txtStartDate'] != '') {
                        $StartDate = "'" . filter_input(INPUT_POST, 'txtStartDate', FILTER_SANITIZE_STRING) . "'";
                    } else {
                        $StartDate = "null";
                    }

                    //if($_POST['chkIsActive']=="1")

                    if (isset($_POST['chkIsActive']) && $_POST['chkIsActive'] != '') {
                        $IsActive = 1;
                    } else {
                        $IsActive = 0;
                    }

                    //if($_POST['chkIsApproved']=="1")
                    // This doesn't seem to be working correctly. Creating without checking active is still sending emails
                    if (isset($_POST['chkIsApproved']) && $_POST['chkIsApproved'] != '' && $_POST['chkIsApproved'] == "1") {
                        $IsApproved = 1;
                    } else {
                        $IsApproved = 0;
                    }

                    // Get site name for email request body strings
                    $dbcSiteName = new mysqli
                    (
                        $dbc['silicore_hostname'],
                        $dbc['silicore_username'],
                        $dbc['silicore_pwd'],
                        $dbc['silicore_dbname']
                    );
                    try {
                        $errGetSiteName = "There was a problem while trying to retrieve the site name using sp_hr_SiteNameGetById();";
                        $sqlGetSiteName = "call sp_hr_SiteNameGetById('$SiteId')";
                        $datSiteName = mysqli_query($dbcSiteName, $sqlGetSiteName);
                        if (!$datSiteName) {
                            throw new Exception(mysqli_error($dbcSiteName));
                        }
                    }// end try
                    catch (Exception $e) {
                        echo(("Exception: " . $errGetSiteName . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
                        exit("Stopping PHP execution");
                    }// end catch

                    try {
                        $errUseSiteName = "There was a problem while trying to process the site name.";
                        $arrSiteName = mysqli_fetch_assoc($datSiteName);
                        $SiteName = $arrSiteName['description'];
                        mysqli_close($dbcSiteName);
                    }// end try
                    catch (Exception $e) {
                        echo(("Exception: " . $errUseSiteName . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
                        exit("Stopping PHP execution");
                    }// end catch

                    // Get manager name for email request body strings
                    $dbcManagerName = new mysqli
                    (
                        $dbc['silicore_hostname'],
                        $dbc['silicore_username'],
                        $dbc['silicore_pwd'],
                        $dbc['silicore_dbname']
                    );
                    try {
                        $errGetManagerName = "There was a problem while trying to retrieve this employee's manager using sp_hr_ManagerNameGetById();";
                        $sqlGetManagerName = "call sp_hr_ManagerNameGetById('$Manager')";
                        $datManagerName = mysqli_query($dbcManagerName, $sqlGetManagerName);
                        if (!$datManagerName) {
                            throw new Exception(mysqli_error($dbcManagerName));
                        }
                    }// end try
                    catch (Exception $e) {
                        echo(("Exception: " . $errGetManagerName . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
                        exit("Stopping PHP execution");
                    }// end catch

                    try {
                        $errUseManagerName = "There was a problem while trying to process the manager name.";
                        $arrManagerName = mysqli_fetch_assoc($datManagerName);
                        $ManagerName = $arrManagerName['display_name'];
                        mysqli_close($dbcManagerName);
                    }// end try
                    catch (Exception $e) {
                        echo(("Exception: " . $errUseManagerName . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
                        exit("Stopping PHP execution");
                    }// end catch

                    $employeeInsertSQL = "call sp_hr_EmpInsert
  (
    '$LastName',
    '$FirstName',
    '$EmployeeId',
    '$DepartmentId',
    '$JobTitleId',    
    '$Manager',
    '$SiteId',
    $StartDate,
    '$SilicoreAccountRequested',
    '$EmailAccountRequested',
    '$EmailAccountModel',
    '$CellPhoneRequested',
    '$LaptopRequested',
    '$DesktopRequested',
    '$MonitorsRequested',
    '$TabletRequested',
    '$TwoWayRadioRequested',
    '$SpecialSoftwareRequested',
    '$UniformRequested',
    '$BusinessCardsRequested',
    '$CreditCardRequested',
    '$FuelCardRequested',
    '$Comments',
    '$IsApproved',
    '$ApprovedUserId',
    '$CreateUserId',
    '$IsActive',
    '$CellPhoneDetail',
    '$LaptopDetail',
    '$DesktopDetail',
    '$TabletDetail',
    '$TwoWayRadioDetail'
  )";
                    //echo $employeeInsertSQL;
                    //echo "";
                    $dbconn = new mysqli
                    (
                        $dbc['silicore_hostname'],
                        $dbc['silicore_username'],
                        $dbc['silicore_pwd'],
                        $dbc['silicore_dbname']
                    );

                    try {
                        $result03 = mysqli_query($dbconn, $employeeInsertSQL);
                        if ($result03 == 0) {
                            echo("Error description: " . mysqli_error($dbconn));
                            throw new Exception("Error! There was a problem when attempting to insert this new employee using call sp_hr_EmpInsert.");
                        } else {
                            if ($IsApproved == 1) {
                                /**
                                 * Function: buildEmailRequest.
                                 * Author: kkuehn
                                 *  $recipient
                                 *  $subject
                                 *  $body
                                 * Description: Builds and sends an email request according to incoming unique parameters to the appropriate team for the task.
                                 * Notes: Still need to add the proper @param info in this docblock
                                 */
                                function buildEmailRequest($recipient, $subject, $body)
                                {
                                    global $debugging;
                                    global $FirstName;
                                    global $LastName;
                                    global $PageDept;
                                    global $PageName;
                                    global $SiteBuildType;
                                    global $sendPHPMailDebugFlag;
                                    global $SiteName;
                                    global $ManagerName;
                                    $employeename = $FirstName . " " . $LastName;
                                    // KACE:18774 - Change SiteBuildType to SiteName the email subject line if server = live
                                    $sitebuildlabel = ($SiteBuildType != "[Live]" ? (" " . $SiteBuildType) : " (" . $SiteName . ")");
                                    $subjectstring = $subject . " Needed - " . $employeename . $sitebuildlabel;
                                    $bodystring = ($employeename . " " . $body . "<br />");
                                    $bodystring .= ("Location: " . $SiteName . "<br />Manager: " . $ManagerName . "<br />");

                                    if ($debugging) {
                                        echo("\$bodystring : " . $bodystring . "<br /><br />");
                                        exit("Stopping PHP execution");
                                    }
                                    SendPHPMail($recipient, $subjectstring, $bodystring, ("/$PageDept/$PageName"), $sendPHPMailDebugFlag, 0);
                                } // end of buildEmailRequest()

                                if ($SilicoreAccountRequested == 1) {
                                    $subject = "Silicore Account";
                                    $body = ("needs a Silicore account. Model after " . $EmailAccountModelName . ".");
                                    buildEmailRequest($addressDev, $subject, $body);
                                }
                                if ($EmailAccountRequested == 1) {
                                    $subject = "Email Account";
                                    $body = ("needs an email account. Model after " . $EmailAccountModelName . ".");
                                    buildEmailRequest($addressHelp, $subject, $body);
                                }
                                if ($CellPhoneRequested == 1) {
                                    $subject = "Cell Phone";
                                    $body = ("needs a cell phone.");
                                    buildEmailRequest($addressHelp, $subject, $body);
                                }
                                if ($LaptopRequested == 1) {
                                    $subject = "Laptop";
                                    $body = ("needs a laptop.");
                                    buildEmailRequest($addressHelp, $subject, $body);
                                }
                                if ($DesktopRequested == 1) {
                                    $subject = "Desktop Computer";
                                    $body = ("needs a desktop computer " . "with " . $MonitorsRequested . " monitor(s).");
                                    buildEmailRequest($addressHelp, $subject, $body);
                                }
                                if ($TabletRequested == 1) {
                                    $
                                    $subject = "Tablet";
                                    $body = ("needs a tablet.");
                                    buildEmailRequest($addressHelp, $subject, $body);
                                }
                                if ($TwoWayRadioRequested == 1) {
                                    $subject = "Two-Way Radio";
                                    $body = "needs a two-way radio.";
                                    buildEmailRequest($addressHelp, $subject, $body);
                                }
                                if (!empty($SpecialSoftwareRequested)) {
                                    $subject = "Special Software";
                                    $body = ("needs " . $SpecialSoftwareRequested . ".");
                                    buildEmailRequest($addressHelp, $subject, $body);
                                }
                                if ($UniformRequested == 1) {
                                    $subject = "Uniform Requested";
                                    $body = "needs a uniform.";
                                    buildEmailRequest($addressUniform, $subject, $body);
                                }
                                if ($BusinessCardsRequested == 1) {
                                    $subject = "Business Cards Requested";
                                    $body = "need business cards.";
                                    buildEmailRequest($addressHelp, $subject, $body);
                                }
                                if ($CreditCardRequested == 1) {
                                    $subject = "Credit Card Requested";
                                    $body = "needs a credit card.";
                                    buildEmailRequest($addressCreditCard, $subject, $body);
                                }
                                if ($FuelCardRequested == 1) {
                                    $subject = "Fuel Card Requested";
                                    $body = "needs a fuel card.";
                                    buildEmailRequest($addressFuelCard, $subject, $body);
                                }

                            }//end of if approved

                        }//end of else

                    }//end of try

                    catch (Exception $e) {
                        echo 'Caught exception: ', $e->getMessage(), "\n";
                    }//end of catch
                    mysqli_close($dbconn);

                    // Get employee data from main_hr_checklist, main_sites, main_departments
                    $dbconn = new mysqli
                    (
                        $dbc['silicore_hostname'],
                        $dbc['silicore_username'],
                        $dbc['silicore_pwd'],
                        $dbc['silicore_dbname']
                    );
                    $data04 = "call sp_hr_EmpSelect()";
                    $result04 = mysqli_query($dbconn, $data04);
                    mysqli_close($dbconn);

                    ?>


                    <table id="myTable" class="table table-bordered table-striped dt-responsive">
                        <thead style="background-color:#4C7AD0; color:white;">
                        <tr>
                            <!-- <table id="myTable" class="tablesorter">
                               <thead style="text-decoration: underline">
                               <tr>-->
                            <!--<th>Last Name</th>
      <th>First Name</th>
      <th><?php echo "$HRProgram" . '  ' ?>ID</th>
      <th>Department</th>
      <th>Manager</th>
      <th>Site</th>
      <th>Start Date</th>
      <th>Is Active</th>
      <th>Action</th>-->
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th><?php echo $HRProgram ?> ID</th>
                            <th>Department</th>
                            <th>Manager</th>
                            <th>Site</th>
                            <th>Start Date</th>
                            <th>Active?</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <?php
                        $UserDepartment = $singleUserObject->vars['main_department_id'];
                        $UserType = $singleUserObject->vars['user_type_id'];

                        while ($row04 = mysqli_fetch_assoc($result04)) {
                            if (($UserDepartment == $row04['department_id'] && $UserType >= 3) ||
                                ($UserDepartment == 9) || ($UserDepartment == 10) || ($UserType == 5 && $UserDepartment == 2)) {
                                ?>

                                <tr>
                                    <td><?php echo($row04['last_name']) ?></td>
                                    <td><?php echo($row04['first_name']) ?> </td>
                                    <td><?php echo($row04['employee_id']) ?> </td>
                                    <td><?php echo($row04['name']) ?> </td>

                                    <?php
                                    // change manager user_id to name
                                    $dbconn = new mysqli
                                    (
                                        $dbc['silicore_hostname'],
                                        $dbc['silicore_username'],
                                        $dbc['silicore_pwd'],
                                        $dbc['silicore_dbname']
                                    );
                                    $data041 = "call sp_hr_DeptManagersGetAll()";
                                    $result041 = mysqli_query($dbconn, $data041);
                                    mysqli_close($dbconn);

                                    $NameManager = $row04['manager_user_id'];

                                    while ($row041 = mysqli_fetch_assoc($result041)) {
                                        if ($NameManager == $row041['id']) {
                                            $ManagerName = $row041['mgrname'];
                                        }

                                    }
                                    ?>
                                    <td><?php echo($ManagerName) ?> </td>
                                    <td><?php echo($row04['description']) ?> </td>
                                    <td><?php echo($row04['start_date']) ?> </td>
                                    <td>
                                        <?php
                                        if ($row04['is_active'] == "1") {
                                            echo("Yes");
                                        }
                                        if ($row04['is_active'] == "0") {
                                            echo("No");
                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        if ($row04['is_active'] == '1') {
                                            ?>
                                            <form method="post" action="hrchecklist.php"
                                                  onsubmit="addemployee.disabled = true; return true;" class="inline">
                                                <input type="hidden" name="id" value="<?php echo($row04['id']) ?>">
                                                <button type="submit" name="editemployee"
                                                        value="<?php echo($row04['id']) ?>" class="btn hrlink-button">
                                                    Edit
                                                </button>
                                            </form>
                                            <?php
                                        } else {
                                            //echo "<a href='hrchecklist.php'>None</a>";
                                            echo "<a href='#'>None</a>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>

                    <br/>
                    <input type="submit" name="addemployee" value="Add new Employee" class="btn submitButton">
                </form>
                </div>
        </fieldset>




        <?php

        break;

    /**************************************************************************************************************************
     * CASE: Edit existing employee form **************************************************************************************
     *************************************************************************************************************************/
    case 5:

        $Id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        $dbconn = new mysqli
        (
            $dbc['silicore_hostname'],
            $dbc['silicore_username'],
            $dbc['silicore_pwd'],
            $dbc['silicore_dbname']
        );
        $data05 = "call sp_hr_EmpSelectById('$Id')";
        $result05 = mysqli_query($dbconn, $data05);
        $row05 = mysqli_fetch_assoc($result05);
        mysqli_close($dbconn);
        //echo $data05;
        $user_id = $_SESSION["user_id"];
        $Date04 = date("Y/m/d H:i:s");
        ?>
<div class="container" style="width:75%;">
            <form class="form" action="hrchecklist.php" method="post">
                <div class="jumbotron-fluid" style="background-color:white; padding: 1%;">
                <h2>Edit Employee</h2>
                <div class="form-row">
                    <div class="form-group col-xl-6">
                        <div class="form-group col-xl">
                            <label for="txtLastName">Last Name:</label>
                            <input type="text" class="form-control"
                                   title="Field must contain only alphabetical characters (max length of 32)."
                                   maxlength="32"
                                   name="txtLastName" pattern="[A-Za-z]{1,32}" value="<?php echo $row05['last_name'] ?>"
                                   required>
                        </div>
                        <div class="form-group col-xl">
                            <label for="txtFirstName">First Name:</label>
                            <input type="text" class="form-control"
                                   title="Field must contain only alphabetical characters (max length of 32)."
                                   maxlength="32"
                                   name="txtFirstName" pattern="[A-Za-z]{1,32}"
                                   value="<?php echo $row05['first_name'] ?>"
                                   required>
                        </div>
                        <div class="form-group col-xl">
                            <label for="txtEmplyeeId"><?php echo $HRProgram ?>ID:</label>
                            <input type="text" class="form-control" name="txtEmployeeId"
                                   value="<?php echo $row05['employee_id'] ?>" required/>
                        </div>
                        <div class="form-group col-xl">
                            <label for="slcSiteId">Site:</label>

                            <?php

                            $dbconn = new mysqli
                            (
                                $dbc['silicore_hostname'],
                                $dbc['silicore_username'],
                                $dbc['silicore_pwd'],
                                $dbc['silicore_dbname']
                            );
                            $data061 = "call sp_hr_SiteSelect()";
                            $result061 = mysqli_query($dbconn, $data061);
                            mysqli_close($dbconn);

                            $dbconn = new mysqli
                            (
                                $dbc['silicore_hostname'],
                                $dbc['silicore_username'],
                                $dbc['silicore_pwd'],
                                $dbc['silicore_dbname']
                            );
                            $data071 = "call sp_hr_EmpDeptSiteSelectById($Id)";
                            $result071 = mysqli_query($dbconn, $data071);
                            $row071 = mysqli_fetch_assoc($result071);
                            mysqli_close($dbconn);

                            ?>
                            <select name="slcSiteId" class="form-control" id="slcSiteId">
                                <?php
                                while ($row061 = mysqli_fetch_assoc($result061)) {
                                    if ($row061['description'] == $row071['description']) {

                                        ?>
                                        <option value="<?php echo($row071['site_id']) ?>"
                                                selected="selected"> <?php echo($row071['description']) ?></option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo($row061['id']) ?>"> <?php echo($row061['description']) ?></option>
                                        <?php
                                    }
                                }

                                ?>
                            </select>
                        </div>
                        <div class="form-group col-xl">
                            <label for="slcDepartmentId">Department:</label>

                            <?php

                            $dbconn = new mysqli
                            (
                                $dbc['silicore_hostname'],
                                $dbc['silicore_username'],
                                $dbc['silicore_pwd'],
                                $dbc['silicore_dbname']
                            );
                            $data06 = "call sp_hr_DeptSelect()";
                            $result06 = mysqli_query($dbconn, $data06);
                            mysqli_close($dbconn);

                            $dbconn = new mysqli
                            (
                                $dbc['silicore_hostname'],
                                $dbc['silicore_username'],
                                $dbc['silicore_pwd'],
                                $dbc['silicore_dbname']
                            );
                            $data07 = "call sp_hr_EmpDeptSiteSelectById($Id)";
                            $result07 = mysqli_query($dbconn, $data07);
                            $row07 = mysqli_fetch_assoc($result07);
                            mysqli_close($dbconn);
                            ?>

                            <select onchange="populateJobTitles()" class="form-control" name="slcDepartmentId"
                                    id="slcDepartmentId">

                                <?php
                                while ($row06 = mysqli_fetch_assoc($result06)) {
                                    if ($row06['name'] == $row07['name']) {
                                        ?>
                                        <option value="<?php echo($row07['department_id']) ?>" selected="selected"
                                                required> <?php echo($row07['name']) ?></option>

                                    <?php } else {
                                        ?>
                                        <option value="<?php echo($row06['id']) ?>"> <?php echo($row06['name']) ?></option>

                                    <?php }
                                }


                                ?>
                            </select>
                        </div>
                        <div class="form-group col-xl">
                            <label for="slcJobTitleId">Job Title:</label>
                            <?php
                            $dbconn = new mysqli
                            (
                                $dbc['silicore_hostname'],
                                $dbc['silicore_username'],
                                $dbc['silicore_pwd'],
                                $dbc['silicore_dbname']
                            );
                            $data062 = "call sp_hr_JobSelect()";
                            $result062 = mysqli_query($dbconn, $data062);
                            mysqli_close($dbconn);

                            $dbconn = new mysqli
                            (
                                $dbc['silicore_hostname'],
                                $dbc['silicore_username'],
                                $dbc['silicore_pwd'],
                                $dbc['silicore_dbname']
                            );
                            $data072 = "call sp_hr_EmpDeptSiteSelectById($Id)";
                            $result072 = mysqli_query($dbconn, $data072);
                            $row072 = mysqli_fetch_assoc($result072);
                            mysqli_close($dbconn);
                            ?>
                            <select name="slcJobTitleId" class="form-control" id="slcJobTitleId" required>

                                <?php
                                while ($row062 = mysqli_fetch_assoc($result062)) {
                                    if ($row062['name'] == $row072['job_title_name']) {
                                        ?>
                                        <option value="<?php echo($row072['job_title_id']) ?>"
                                                selected="selected"> <?php echo($row072['job_title_name']) ?></option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo($row062['id']) ?>"> <?php echo($row062['name']) ?></option>

                                        <?php
                                    }
                                }

                                ?>
                            </select>
                        </div>
                        <div class="form-group col-xl">
                            <label for="slcManager">Manager:</label>
                            <?php
                            $dbconn = new mysqli
                            (
                                $dbc['silicore_hostname'],
                                $dbc['silicore_username'],
                                $dbc['silicore_pwd'],
                                $dbc['silicore_dbname']
                            );

                            $data063 = "call sp_hr_DeptManagersGetAll()";
                            $result063 = mysqli_query($dbconn, $data063);

                            mysqli_close($dbconn);


                            $dbconn = new mysqli
                            (
                                $dbc['silicore_hostname'],
                                $dbc['silicore_username'],
                                $dbc['silicore_pwd'],
                                $dbc['silicore_dbname']
                            );

                            $data073 = "call sp_hr_EmpDeptSiteSelectById($Id)";

                            $result073 = mysqli_query($dbconn, $data073);
                            $row073 = mysqli_fetch_assoc($result073);

                            mysqli_close($dbconn);
                            ?>
                            <select name="slcManager" class="form-control" id="slcManager" required>
                                <?php
                                while ($row063 = mysqli_fetch_assoc($result063)) {
                                    if ($row063['mgrname'] == $row073['mgrname']) {
                                        ?>
                                        <option value="<?php echo($row073['manager_user_id']) ?>" selected="selected"> <?php echo($row073['mgrname']) ?></option>
                                    <?php } else {
                                        ?>
                                        <option value="<?php echo($row063['id']) ?>"> <?php echo($row063['mgrname']) ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-xl">
                            <label for="txtStartDate">Start Date:</label>
                            <input type="text" id="start-date-edit" class="form-control" name="txtStartDate" value="<?php echo $row05['start_date'] ?>" autocomplete="off">
                        </div>
                        <div class="form-group col-xl">
                            <label for="txtSeparationDate">Separation Date:</label>
                            <input type="text" id="separation-date" class="form-control" name="txtSeparationDate" value="<?php echo $row05['separation_date'] ?>" autocomplete="off">
                        </div>
                        <!--<editor-fold desc="Checkboxes">-->

                                <div class="form-group col-xl">
                                    <input type="hidden" name="chkUniformRequestedHidden" value="0"/>
                                    <input type="checkbox" class="form-check-inline" id="chkUniformRequested" name="chkUniformRequested" value="1"
                                        <?php if ($row05['uniform_requested'] === "1") {
                                        echo "checked";
                                    } ?>>
                                    <label for="chkUniformRequested" class="form-check-label">Uniform(s)</label>
                                </div>
                                <div class="form-group col-xl">
                                    <input type="hidden" name="chkBusinessCardsRequested" value="0">
                                    <input type="checkbox" name="chkBusinessCardsRequested" class="form-check-inline" value="1" <?php if ($row05['business_card_requested'] === "1") {
                                        echo "checked";
                                    } ?>>
                                    <label for="chkBusinessCardsRequested" class="form-check-label">Business Cards</label>
                                </div>
                                <div class="form-group col-xl">
                                    <input type="hidden" name="chkFuelCardRequested" value="0"/>
                                    <input type="checkbox" class="form-check-inline" id="chkFuelCardRequested" name="chkFuelCardRequested" value="1" <?php if ($row05['fuel_card_requested'] === "1") {
                                        echo "checked";
                                    } ?>>
                                    <label for="chkFuelCardRequested" class="form-check-label">Fuel Card</label>
                                </div>
                                <div class="form-group col-xl">
                                    <input type="hidden" name="chkCreditCardRequested" value="0"/>
                                    <input type="checkbox" class="form-check-inline" name="chkCreditCardRequested" value="1" <?php if ($row05['credit_card_requested'] === "1") {
                                        echo "checked";
                                    } ?>>Credit Card
                                </div>
                                <div class="form-group col-xl">
                                    <input type="hidden" name="chkIsActive" value="0"/>
                                    <input type="checkbox" id="chkIsActive" class="form-check-inline" name="chkIsActive" value="1" <?php if ($row05['is_active'] === "1") {
                                        echo "checked";
                                    } ?>>
                                    <label for="chkIsActive" class="form-check-label">Active</label>
                                </div>
                                <?php
                                if ($userPermissionsArray['vista']['granbury']['hr'] < 4){
                                ?>
                                <div class="form-group col-xl">
                                    <input type="hidden" name="chkIsApproved" value="0"/>
                                    <input type="checkbox" class="form-check-inline" id="chkIsApproved" name="chkIsApproved" value="1" <?php if ($row05['is_approved'] === "1") {
                                        echo "checked";
                                    } ?>>
                                    <label for="chkIsApproved" class="form-check-label">Please leave this box as is</label>
                                </div>
                            </div>
                            <?php
                            }else{
                            ?>
                            <div class="form-group col-xl">
                                <input type="hidden" name="chkIsApproved" value="0"/>
                                <input type="checkbox" class="form-check-inline" id="chkIsApproved" name="chkIsApproved" value="1" <?php if ($row05['is_approved'] === "1") {
                                    echo "checked";
                                } ?>>
                                <label for="chkIsApproved" class="form-check-label">Approved</label>
                                <?php
                                }
                                $dbconn = new mysqli
                                (
                                    $dbc['silicore_hostname'],
                                    $dbc['silicore_username'],
                                    $dbc['silicore_pwd'],
                                    $dbc['silicore_dbname']
                                );
                                $data054 = "call sp_hr_EmpGetAll()";
                                $result054 = mysqli_query($dbconn, $data054);
                                mysqli_close($dbconn);

                                $dbconn = new mysqli
                                (
                                    $dbc['silicore_hostname'],
                                    $dbc['silicore_username'],
                                    $dbc['silicore_pwd'],
                                    $dbc['silicore_dbname']
                                );
                                $data055 = "call sp_hr_EmpGetAll()";
                                $result055 = mysqli_query($dbconn, $data055);
                                mysqli_close($dbconn);
                                $nameEmailAccountModel = $row05['email_account_model_id'];
                                while ($row055 = mysqli_fetch_assoc($result055)) {
                                    if ($nameEmailAccountModel == $row055['id']) {
                                        $EmailAccountModelName = $row055['empname'];
                                    }

                                }
                                if (isset($row05['two_way_radio_notes']) && $row05['two_way_radio_notes'] != "") {
                                    $radioTxt = $row05['two_way_radio_notes'];
                                } else {
                                    $radioTxt = "Serial Number, etc.";
                                }
                                ?>
                            </div>
                            <!--</editor-fold>-->

                    </div>
                    <div class="form-group col-xl-6">
                        <fieldset style="border:solid 1px #ced4da; padding:1%;">
                            <legend>Accounts</legend>
                            <div class="form-group col-xl">
                                <input type="hidden" name="chkSilicoreAccountRequested" value="0"/>
                                <input type="checkbox" class="form-check-inline" id="chkSilicoreAccountRequested" name="chkSilicoreAccountRequested" value="1"
                                    <?php if ($row05['silicore_account_requested'] === "1") {
                                        echo("disabled checked");
                                    } ?>>
                                <label for="chkSilicoreAccountRequested" class="form-check-label">Silicore Account</label>
                            </div>
                            <div class="form-group col-xl">
                                <input type="hidden" name="chkEmailAccountRequested" value="0"/>
                                <input type="checkbox" class="form-check-inline" id="chkEmailAccountRequestedInput" name="chkEmailAccountRequestedInput" value="1"
                                    <?php if ($row05['email_account_requested'] === "1") {
                                        echo "disabled checked";
                                    } ?>>
                                <label for="chkEmailAccountRequestedInput" class="form-check-label">Email Account</label>
                            </div>
                            <div class="form-group col-xl">
                                <label for="txtEmailAccountModel" class="col-form-label">Model After:</label>
                                <?php
                                $dbconn = new mysqli
                                (
                                    $dbc['silicore_hostname'],
                                    $dbc['silicore_username'],
                                    $dbc['silicore_pwd'],
                                    $dbc['silicore_dbname']
                                );
                                $empallSQL = "call sp_hr_EmpGetAll()";
                                $empallResults = mysqli_query($dbconn, $empallSQL);
                                mysqli_close($dbconn);

                                $dbconn = new mysqli
                                (
                                    $dbc['silicore_hostname'],
                                    $dbc['silicore_username'],
                                    $dbc['silicore_pwd'],
                                    $dbc['silicore_dbname']
                                );
                                $empdataSQL = "call sp_hr_EmpDeptSiteSelectById($Id)";
                                $empdataResults = mysqli_query($dbconn, $empdataSQL);
                                $empdataRow = mysqli_fetch_assoc($empdataResults);
                                mysqli_close($dbconn);
                                ?>
                                <select class="form-control" name="txtEmailAccountModel" id="txtEmailAccountModel">
                                    <?php
                                    while ($empallRow = mysqli_fetch_assoc($empallResults)) {
                                        if ($empallRow['id'] == $empdataRow['email_account_model_id']) {
                                            echo("<option value=" . $empdataRow['email_account_model_id'] . " selected=\"selected\">" . $EmailAccountModelName . "</option>");
                                        } else {
                                            echo("<option value=" . $empallRow['id'] . ">" . $empallRow['empname'] . "</option>");
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </fieldset>
                        <div class="form-group col-xl">
                            <label for="txtCellPhoneRequested" class="col-form-label">Cell Phone:</label>
                            <input type="hidden" name="chkCellPhoneRequested" value="0"/>
                            <input type="checkbox" class="form-check-inline" name="chkCellPhoneRequested" value="1" <?php if ($row05['cell_phone_requested'] === "1") {
                                echo "disabled checked";
                            } ?> />
                            <input type="text" class="form-control" name="txtCellPhoneRequested" value="<?php echo($row05['cell_phone_notes']) ?>" placeholder="Serial Number, Android/iPhone, etc."/>
                        </div>
                        <div class="form-group col-xl">
                            <label for="chkLaptopRequested" class="col-form-label">Laptop:</label>
                            <input type="hidden" name="chkLaptopRequested" value="0"/>
                            <input type="checkbox" class="form-check-inline" name="chkLaptopRequested" value="1" <?php if ($row05['laptop_requested'] === "1") {
                                echo "disabled checked";
                            } ?> />
                            <input type="text" class="form-control" name="txtLaptopRequested" value="<?php echo($row05['laptop_notes']) ?>" placeholder="Serial number, model number, etc."/>
                        </div>
                        <div class="form-group col-xl">
                            <label for="chkDesktopRequested" class="col-form-label">Desktop:</label>
                            <input type="hidden" name="chkDesktopRequested" value="0"/>
                            <input type="checkbox" class="form-check-inline" name="chkDesktopRequested" value="1" <?php if ($row05['desktop_requested'] === "1") {
                                echo "disabled checked";
                            } ?> />
                            <input type="text" class="form-control" name="txtDesktopRequested" value="<?php echo($row05['desktop_notes']) ?>" placeholder="Serial number, RAM, etc."/>
                        </div>
                        <div class="form-group col-xl">
                            <label for="txtMonitorsRequested" class="col-form-label">Monitors:</label>
                            <input type="number" class="form-control" name="txtMonitorsRequested" value="<?php echo $row05['monitors_requested'] ?>" placeholder="1"/>
                        </div>
                        <div class="form-group col-xl">
                            Tablet:
                            <input type="hidden" name="chkTabletRequested" value="0"/>
                            <input type="checkbox" name="chkTabletRequested" value="1" <?php if ($row05['tablet_requested'] === "1") {
                                echo "disabled checked";
                            } ?> />
                            <input type="text" class="form-control" name="txtTabletRequested" value="<?php echo($row05['tablet_notes']) ?>" placeholder="Serial Number, Android/iPad, etc."/>
                        </div>
                        <div class="form-group col-xl">
                            Radio:
                            <input type="hidden" name="chkTwoWayRadioRequested" value="0"/>
                            <input type="checkbox" name="chkTwoWayRadioRequested" value="1" <?php if ($row05['two_way_radio_requested'] === "1") {
                                echo "disabled checked";
                            } ?> />
                            <input type="text" class="form-control" name="txtTwoWayRadioRequested" value="<?php echo($row05['two_way_radio_notes']) ?>" placeholder="Serial Number, etc."/>
                        </div>
                        <div class="form-group col-xl">
                            Software:
                            <input type="text" class="form-control" name="txtSpecialSoftwareRequested" value="<?php echo $row05['special_software_requested'] ?>" placeholder="Photoshop, CAD, etc."/>
                        </div>
                        <div class="form-group col-xl">
                            Comments: <br/><textarea id="hrformgrouparea" rows="15" cols="45" colspan="2" name="txaComments"><?php echo($row05['comments']) ?></textarea>
                            <script type="text/javascript">
                                CKEDITOR.replace('hrformgrouparea');
                            </script>
                        </div>
                        <input type="hidden" name="txtId" value="<?php echo $row05['id'] ?>">
                        <input type="hidden" name="trythis" value="one">
                        <input type="hidden" name="txtEditDate" value="<?php echo($Date04) ?>"/>
                        <input type="hidden" name="txtEditUserId" value="<?php echo($user_id) ?>"/>
                        <input type="submit" name="updateemployee" value="Save" class="btn btn-vprop-green" formnovalidate>
                        &nbsp; &nbsp;&nbsp;&nbsp;
                        <input type="submit" name="selectallemployees" value="See All Employees" class="btn btn-vprop-blue"
                               formnovalidate>
                    </div>
                    </div>

            </form>
</div>


        <?php
        break;

    /**************************************************************************************************************************
     * CASE: Update existing employee, send email(s) if applicable, then show employee table again (with edit links) **********
     *************************************************************************************************************************/
    case 6:

        $Id = filter_input(INPUT_POST, 'txtId', FILTER_SANITIZE_NUMBER_INT);
        $dbconn = new mysqli
        (
            $dbc['silicore_hostname'],
            $dbc['silicore_username'],
            $dbc['silicore_pwd'],
            $dbc['silicore_dbname']
        );
        $data08 = "call sp_hr_EmpSelectByID('$Id')";
        $result08 = mysqli_query($dbconn, $data08);
        $row08 = mysqli_fetch_assoc($result08);
        mysqli_close($dbconn);
//  echo $data08;

        $dbconn = new mysqli
        (
            $dbc['silicore_hostname'],
            $dbc['silicore_username'],
            $dbc['silicore_pwd'],
            $dbc['silicore_dbname']
        );
        $data056 = "call sp_hr_EmpGetAll()";
        $result056 = mysqli_query($dbconn, $data056);
        mysqli_close($dbconn);

        $dbconn = new mysqli
        (
            $dbc['silicore_hostname'],
            $dbc['silicore_username'],
            $dbc['silicore_pwd'],
            $dbc['silicore_dbname']
        );
        $data057 = "call sp_hr_EmpGetAll()";
        $result057 = mysqli_query($dbconn, $data057);
        mysqli_close($dbconn);

        $nameEmailAccountModel = filter_input(INPUT_POST, 'txtEmailAccountModel', FILTER_SANITIZE_NUMBER_INT);

        while ($row057 = mysqli_fetch_assoc($result057)) {
            if ($nameEmailAccountModel == $row057['id']) {
                $EmailAccountModelName = $row057['empname'];
            }
        }

        $dbconn = new mysqli
        (
            $dbc['silicore_hostname'],
            $dbc['silicore_username'],
            $dbc['silicore_pwd'],
            $dbc['silicore_dbname']
        );
        $Id = filter_input(INPUT_POST, 'txtId', FILTER_SANITIZE_NUMBER_INT);
        $LastName = filter_input(INPUT_POST, 'txtLastName', FILTER_SANITIZE_STRING);
        $FirstName = filter_input(INPUT_POST, 'txtFirstName', FILTER_SANITIZE_STRING);
        $EmployeeId = filter_input(INPUT_POST, 'txtEmployeeId', FILTER_SANITIZE_NUMBER_INT);
        $DepartmentId = filter_input(INPUT_POST, 'slcDepartmentId', FILTER_SANITIZE_NUMBER_INT);
        $JobTitleId = filter_input(INPUT_POST, 'slcJobTitleId', FILTER_SANITIZE_NUMBER_INT);
        $Manager = filter_input(INPUT_POST, 'slcManager', FILTER_SANITIZE_STRING);
        $SiteId = filter_input(INPUT_POST, 'slcSiteId', FILTER_SANITIZE_NUMBER_INT);
        $UniformRequested = filter_input(INPUT_POST, 'chkUniformRequested', FILTER_SANITIZE_NUMBER_INT);
        $BusinessCardsRequested = filter_input(INPUT_POST, 'chkBusinessCardsRequested', FILTER_SANITIZE_NUMBER_INT);
        $FuelCardRequested = filter_input(INPUT_POST, 'chkFuelCardRequested', FILTER_SANITIZE_NUMBER_INT);
        $CreditCardRequested = filter_input(INPUT_POST, 'chkCreditCardRequested', FILTER_SANITIZE_NUMBER_INT);

        $SilicoreAccountRequested = filter_input(INPUT_POST, 'chkSilicoreAccountRequested', FILTER_SANITIZE_NUMBER_INT);
        $EmailAccountRequested = filter_input(INPUT_POST, 'chkEmailAccountRequested', FILTER_SANITIZE_NUMBER_INT);
        $EmailAccountModel = filter_input(INPUT_POST, 'txtEmailAccountModel', FILTER_SANITIZE_NUMBER_INT); // NOTE: this is a select list (slc), not text.
        $CellPhoneRequested = filter_input(INPUT_POST, 'chkCellPhoneRequested', FILTER_SANITIZE_NUMBER_INT);
        $CellPhoneDetail = filter_input(INPUT_POST, 'txtCellPhoneRequested', FILTER_SANITIZE_STRING);
        $LaptopRequested = filter_input(INPUT_POST, 'chkLaptopRequested', FILTER_SANITIZE_NUMBER_INT);
        $LaptopDetail = filter_input(INPUT_POST, 'txtLaptopRequested', FILTER_SANITIZE_STRING);
        $DesktopRequested = filter_input(INPUT_POST, 'chkDesktopRequested', FILTER_SANITIZE_NUMBER_INT);
        $DesktopDetail = filter_input(INPUT_POST, 'txtDesktopRequested', FILTER_SANITIZE_STRING);
        $MonitorsRequested = filter_input(INPUT_POST, 'txtMonitorsRequested', FILTER_SANITIZE_STRING);
        $TabletRequested = filter_input(INPUT_POST, 'chkTabletRequested', FILTER_SANITIZE_NUMBER_INT);
        $TabletDetail = filter_input(INPUT_POST, 'txtTabletRequested', FILTER_SANITIZE_STRING);
        $TwoWayRadioRequested = filter_input(INPUT_POST, 'chkTwoWayRadioRequested', FILTER_SANITIZE_NUMBER_INT);
        $TwoWayRadioDetail = filter_input(INPUT_POST, 'txtTwoWayRadioRequested', FILTER_SANITIZE_STRING);
        $SpecialSoftwareRequested = filter_input(INPUT_POST, 'txtSpecialSoftwareRequested', FILTER_SANITIZE_STRING);
        $Comments = filter_input(INPUT_POST, 'txaComments', FILTER_SANITIZE_STRING);
        $ApprovedUserId = $_SESSION['user_id']; // filter_input(INPUT_SESSION,[sessvar],[filter]) is not implemented in PHP yet.
        // $CreateUserId = $_SESSION['user_id']; // Why do we need CreateUserId in this context? This should be modify only.
        $EditUserID = $_SESSION['user_id']; // filter_input(INPUT_SESSION,[sessvar],[filter]) is not implemented in PHP yet.

        if (isset($_POST['txtSeparationDate']) && $_POST['txtSeparationDate'] != '') {
            $SeparationDate = "'" . filter_input(INPUT_POST, 'txtSeparationDate', FILTER_SANITIZE_STRING) . "'";
        } else {
            $SeparationDate = "null";
        }

        if (isset($_POST['txtStartDate']) && $_POST['txtStartDate'] != '') {
            $StartDate = "'" . filter_input(INPUT_POST, 'txtStartDate', FILTER_SANITIZE_STRING) . "'";
        } else {
            $StartDate = "null";
        }

        $IsActive = $_POST['chkIsActive'];

        if ($_POST['chkIsActive'] == "1") //  if(isset($_POST['chkIsActive']) && $_POST['chkIsActive'] != '')
        {
            $IsActive = 1;
        } else {
            $IsActive = 0;
        }

        $IsApproved = $_POST['chkIsApproved'];

        /* if ($IsApproved == "1")
         if(isset($_POST['chkIsApproved']) && $_POST['chkIsApproved'] != '')
         {
           $IsApproved = "1";
         }
         else
         {
           $IsApproved = "0";
         }
       */

        // Disabling checkboxes in the edit phase is the cause for the code below because
        // it changes the checked boxes to a ZERO
        // All of the following conditionals should be reformatted to the following shorthand:
        // $EmailAccountRequested = ($EmailAccountRequested == "0" && $row08['email_account_requested'] == "1") ? 1 : 0;


        if ($SilicoreAccountRequested == "0" && $row08['silicore_account_requested'] == "1") {
            $SilicoreAccountRequested = "1";
        }

        if ($EmailAccountRequested == "0" && $row08['email_account_requested'] == "1") {
            $EmailAccountRequested = "1";
        }

        if ($CellPhoneRequested == "0" && $row08['cell_phone_requested'] == "1") {
            $CellPhoneRequested = "1";
        }

        if ($LaptopRequested == "0" && $row08['laptop_requested'] == "1") {
            $LaptopRequested = "1";
        }

        if ($DesktopRequested == "0" && $row08['desktop_requested'] == "1") {
            $DesktopRequested = "1";
        }

        if ($TabletRequested == "0" && $row08['tablet_requested'] == "1") {
            $TabletRequested = "1";
        }

        if ($TwoWayRadioRequested == "0" && $row08['two_way_radio_requested'] == "1") {
            $TwoWayRadioRequested = "1";
        }

        if ($UniformRequested == "0" && $row08['uniform_requested'] == "1") {
            $UniformRequested = "1";
        }
        else {
            $UniformRequested = "0";
        }
        if ($BusinessCardsRequested == "0" && $row08['business_card_requested'] == "1") {
            $BusinessCardsRequested = "1";
        }
        else {
            $BusinessCardsRequested = "0";
        }
        if ($CreditCardRequested == "0" && $row08['credit_card_requested'] == "1") {
            $CreditCardRequested = "1";
        }
        else {
            $CreditCardRequested = "0";
        }
        if ($FuelCardRequested == "0" && $row08['fuel_card_requested'] == "1") {
            $FuelCardRequested = "1";
        }
        else {
            $FuelCardRequested = "0";
        }

        $data09 = "call sp_hr_EmpUpdate
    ( 
      '$Id',
      '$LastName',                      
      '$FirstName',
      '$EmployeeId',
      '$DepartmentId',
      '$JobTitleId',            
      '$Manager',
      '$SiteId',
      $StartDate,
      $SeparationDate, 
      '$SilicoreAccountRequested',
      '$EmailAccountRequested',
      '$EmailAccountModel',
      '$CellPhoneRequested',
      '$LaptopRequested',
      '$DesktopRequested',
      '$MonitorsRequested',
      '$TabletRequested',
      '$TwoWayRadioRequested',
      '$SpecialSoftwareRequested',
      '$UniformRequested',
      '$BusinessCardsRequested',
      '$CreditCardRequested',
      '$FuelCardRequested',
      '$Comments',
      '$IsApproved',
      '$ApprovedUserId',
      '$EditUserID',
      '$IsActive',
      '$CellPhoneDetail',
      '$LaptopDetail',
      '$DesktopDetail',
      '$TabletDetail',
      '$TwoWayRadioDetail'
     )";

        try {
            $result09 = mysqli_query($dbconn, $data09);
            if ($result09 == 0) {
                echo("Error description: " . mysqli_error($dbconn));
                throw new Exception("Error! There was an issue when attempting to update this employee through sp_hr_EmpUpdate.");
            } else {
                if ($IsApproved === "1") {

                    if (($SilicoreAccountRequested == "1" && $row08['silicore_account_requested'] == "0") ||
                        ($row08['silicore_account_requested'] == "1" && $row08['is_approved'] == "0")) {
                        $address = $addressDev;
                        $subject = "Silicore Account  Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
                        $body = ($FirstName . " " . $LastName . " " . "needs a Silicore account." . "  " . "Model is after" . " " . $EmailAccountModelName . ".");
                        SendPHPMail($address, $subject, $body, ("/$PageDept/$PageName"), $sendPHPMailDebugFlag, 0);
                    }

                    if (($EmailAccountRequested == "1" && $row08['email_account_requested'] == "0")
                        || ($row08['email_account_requested'] == "1" && $row08['is_approved'] == "0")) {
                        $address = $addressHelp;
                        $subject = $SiteBuildType . "Email Account  Needed - " . $FirstName . " " . $LastName . ":  " . "Model is after" . " " . $EmailAccountModelName . "." . " " . $SiteBuildType;
                        $body = ($FirstName . " " . $LastName . " " . "needs an email account.");
                        SendPHPMail($address, $subject, $body, ("/$PageDept/$PageName"), $sendPHPMailDebugFlag, 0);
                    }

                    if (($CellPhoneRequested === "1" && $row08['cell_phone_requested'] === "0")
                        || ($row08['cell_phone_requested'] == "1" && $row08['is_approved'] == "0")) {
                        $address = $addressHelp;
                        $subject = "Cell Phone  Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
                        $body = ($FirstName . " " . $LastName . " " . "needs a cell phone. <br>Details: " . $CellPhoneDetail);
                        SendPHPMail($address, $subject, $body, ("/$PageDept/$PageName"), $sendPHPMailDebugFlag, 0);
                    }

                    if (($LaptopRequested === "1" && $row08['laptop_requested'] === "0")
                        || ($row08['laptop_requested'] == "1" && $row08['is_approved'] == "0")) {
                        $address = $addressHelp;
                        $subject = "Laptop  Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
                        $body = ($FirstName . " " . $LastName . " " . "needs a laptop.<br>Details: " . $LaptopDetail);
                        SendPHPMail($address, $subject, $body, ("/$PageDept/$PageName"), $sendPHPMailDebugFlag, 0);
                    }

                    if (($DesktopRequested === "1" && $row08['desktop_requested'] === "0")
                        || ($row08['desktop_requested'] == "1" && $row08['is_approved'] == "0")) {
                        $address = $addressHelp;
                        $subject = "Desktop Computer  Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
                        $body = ($FirstName . " " . $LastName . " " . "needs a desktop computer with" . " " . $MonitorsRequested . " " . "monitors. <br>Details: " . $DesktopDetail);
                        SendPHPMail($address, $subject, $body, ("/$PageDept/$PageName"), $sendPHPMailDebugFlag, 0);
                    }

                    if (($MonitorsRequested !== $row08['monitors_requested'] && $row08['desktop_requested'] === "1")
                        || ($row08['monitors_requested'] == "1" && $row08['is_approved'] == "0")) {
                        $address = $addressHelp;
                        $subject = "Monitor Request Adjustment - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
                        $body = ($FirstName . " " . $LastName . " " . "needs" . " " . $MonitorsRequested . " " . "monitors.");
                        SendPHPMail($address, $subject, $body, ("/$PageDept/$PageName"), $sendPHPMailDebugFlag, 0);
                    }

                    if (($TabletRequested === "1" && $row08['tablet_requested'] === "0")
                        || ($row08['tablet_requested'] == "1" && $row08['is_approved'] == "0")) {
                        $address = $addressHelp;
                        $subject = "Tablet  Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
                        $body = ($FirstName . " " . $LastName . " " . "needs a tablet. <br>Details: " . $TabletDetail);
                        SendPHPMail($address, $subject, $body, ("/$PageDept/$PageName"), $sendPHPMailDebugFlag, 0);
                    }

                    if (($TwoWayRadioRequested === "1" && $row08['two_way_radio_requested'] === "0")
                        || ($row08['two_way_radio_requested'] == "1" && $row08['is_approved'] == "0")) {
                        $address = $addressHelp;
                        $subject = "Two-Way Radio Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
                        $body = ($FirstName . " " . $LastName . " " . "needs a two-way radio.<br> Details: " . $TwoWayRadioDetail);
                        SendPHPMail($address, $subject, $body, ("/$PageDept/$PageName"), $sendPHPMailDebugFlag, 0);
                    }

                    if ((!empty($SpecialSoftwareRequested) && empty($row08['special_software_requested']))
                        || (!empty($row08['special_software_requested']) && $row08['is_approved'] == "0")) {
                        $address = $addressHelp;
                        $subject = "Special Software Requested - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
                        $body = ($FirstName . " " . $LastName . " " . "needs" . " " . $SpecialSoftwareRequested . ".");
                        SendPHPMail($address, $subject, $body, ("/$PageDept/$PageName"), $sendPHPMailDebugFlag, 0);
                    }

                    if (($SpecialSoftwareRequested !== $row08['special_software_requested']) && !empty($row08['special_software_requested'])) {
                        $address = $addressHelp;
                        $subject = "Special Software Request Adjustment - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
                        $body = ($FirstName . " " . $LastName . " " . "needs" . " " . $SpecialSoftwareRequested . ".");
                        SendPHPMail($address, $subject, $body, ("/$PageDept/$PageName"), $sendPHPMailDebugFlag, 0);
                    }
                    if (($UniformRequested === "1" && $row08['uniform_requested'] === "0")
                        || ($row08['uniform_requested'] == "1" && $row08['is_approved'] == "0")) {
                        $address = $addressUniform;
                        $subject = "Uniform Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
                        $body = ($FirstName . " " . $LastName . " " . "needs a uniform.<br> Details: " . $TwoWayRadioDetail);
                        SendPHPMail($address, $subject, $body, ("/$PageDept/$PageName"), $sendPHPMailDebugFlag, 0);
                    }
                    if (($BusinessCardsRequested === "1" && $row08['business_card_requested'] === "0")
                        || ($row08['business_card_requested'] == "1" && $row08['is_approved'] == "0")) {
                        $address = $addressHelp;
                        $subject = "Business Cards Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
                        $body = ($FirstName . " " . $LastName . " " . "needs business cards.<br> Details: " . $TwoWayRadioDetail);
                        SendPHPMail($address, $subject, $body, ("/$PageDept/$PageName"), $sendPHPMailDebugFlag, 0);
                    }
                    if (($CreditCardRequested === "1" && $row08['credit_card_requested'] === "0")
                        || ($row08['credit_card_requested'] == "1" && $row08['is_approved'] == "0")) {
                        $address = $addressCreditCard;
                        $subject = "Credit Card Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
                        $body = ($FirstName . " " . $LastName . " " . "needs a credit card.<br> Details: " . $TwoWayRadioDetail);
                        SendPHPMail($address, $subject, $body, ("/$PageDept/$PageName"), $sendPHPMailDebugFlag, 0);
                    }
                    if (($FuelCardRequested === "1" && $row08['fuel_card_requested'] === "0")
                        || ($row08['fuel_card_requested'] == "1" && $row08['is_approved'] == "0")) {
                        $address = $addressFuelCard;
                        $subject = "Fuel Card Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
                        $body = ($FirstName . " " . $LastName . " " . "needs fuel card.<br> Details: " . $TwoWayRadioDetail);
                        SendPHPMail($address, $subject, $body, ("/$PageDept/$PageName"), $sendPHPMailDebugFlag, 0);
                    }
                } // end if in else
            } // end else
        } // end try
        catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        } // end catch
        mysqli_close($dbconn);

        $dbconn = new mysqli
        (
            $dbc['silicore_hostname'],
            $dbc['silicore_username'],
            $dbc['silicore_pwd'],
            $dbc['silicore_dbname']
        );
        $data10 = "call sp_hr_EmpSelect";
        $result10 = mysqli_query($dbconn, $data10);
        mysqli_close($dbconn);

//echo $data09;

        ?>


        <!--<h2>Employee List</h2>-->
        <legend>Employee List</legend>
        <div>
            <form action="hrchecklist.php" method="post">
                <input type="submit" name="addemployee" value="Add New Employee" class="btn btn-vprop-green">
                <br/><br/>
                <table id="myTable" class="table table-bordered table-striped">
                    <thead class="th-vprop-blue-medium">
                    <tr>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th><?php echo $HRProgram ?> ID</th>
                        <th>Department</th>
                        <th>Manager</th>
                        <th>Site</th>
                        <th>Start Date</th>
                        <th>Active?</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <?php
                    $UserDepartment = $singleUserObject->vars['main_department_id'];
                    $UserType = $singleUserObject->vars['user_type_id'];

                    while ($row10 = mysqli_fetch_assoc($result10)) {
                        if (($UserDepartment == $row10['department_id'] && $UserType >= 3) ||
                            ($UserDepartment == 9) || ($UserType == 5 && $UserDepartment == 2) ||
                            ($UserDepartment == 10)) {
                            ?>

                            <tr>
                                <td><?php echo($row10['last_name']) ?></td>
                                <td><?php echo($row10['first_name']) ?> </td>
                                <td><?php echo($row10['employee_id']) ?> </td>
                                <td><?php echo($row10['name']) ?> </td>

                                <?php
                                // change manager user_id to name
                                $dbconn = new mysqli
                                (
                                    $dbc['silicore_hostname'],
                                    $dbc['silicore_username'],
                                    $dbc['silicore_pwd'],
                                    $dbc['silicore_dbname']
                                );
                                $data101 = "call sp_hr_DeptManagersGetAll()";
                                $result101 = mysqli_query($dbconn, $data101);
                                mysqli_close($dbconn);

                                $NameManagerId = $row10['manager_user_id'];
                                $ManagerName = '';

                                while ($row101 = mysqli_fetch_assoc($result101)) {
                                    if ($NameManagerId == $row101['id']) {
                                        $ManagerName = $row101['mgrname'];
                                    }

                                }
                                ?>
                                <td><?php echo($ManagerName) ?> </td>
                                <td><?php echo($row10['description']) ?> </td>
                                <td><?php echo($row10['start_date']) ?> </td>
                                <td>

                                    <?php
                                    if ($row10['is_active'] == "1") {
                                        echo("Yes");
                                    }
                                    if ($row10['is_active'] == "0") {
                                        echo("No");
                                    }
                                    ?>
                                </td>

                                <td>

                                    <?php
                                    if ($row10['is_active'] == '1') {
                                        ?>
                                        <form method="post" action="hrchecklist.php" class="inline">
                                            <input type="hidden" name="id" value="<?php echo($row10['id']) ?>">
                                            <button type="submit" name="editemployee"
                                                    value="<?php echo($row10['id']) ?>" class="btn">
                                                <span><i class="fas fa-edit" style="color:green;"></i></span>
                                            </button>
                                        </form>

                                        <?php
                                    } else {
                                        //echo "<a href='hrchecklist.php'>None</a>";
                                        echo "<a href='#'>None</a>";
                                    }
                                    ?>
                                </td>
                            </tr>

                            <?php
                        } // end if
                    } // end while
                    ?>
                </table>

                <br/>
                <input type="submit" name="addemployee" value="Add New Employee" class="btn btn-vprop-green">
            </form>
        </div>


        <?php
        break;

    /**************************************************************************************************************************
     * CASE: Code to be executed if x isn't associated with a defined action **************************************************
     *************************************************************************************************************************/
    default:
        echo("<br /><br />One of two things happened, either click an employee to edit or put in the information to add employee.");
        echo("<br /><br />");
        echo("
      <form>
        <input type=\"submit\"  name=\"selectallemployees\" 
          value=\"Go back to all Employees\" class=\"btn\" formnovalidate>
      </form>");
}
//====================================================================== END PHP

// require_once('../../Includes/Templates/footer.php');
?>
<script>
    $(document).ready(function () {
        var table = $('#myTable').DataTable({
            scrollY: "450px",
            paging: true,
            pageLength: 10
        });
    });
</script>