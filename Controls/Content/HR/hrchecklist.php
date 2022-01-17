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
 * 07/14/2017|ktaylor|KACE:16070 - Added stored procedures for select and select by id, found and fixed tinyint bug, and erased the echo's for debugging.
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
 * 08/24/2017|ktaylor|KACE:16282 - Added extra option with selected and disabled chosen for case 2 on line 368 in file hrchecklist.php.  Thus, "Please Select" grayed-out as well. 
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
 * 10/11/2017|nolliff|KACE:18775 - Fixed sproc call to properly handle dates, now passes null rather than a placeholder date for start and separation dates
 * 10/11/2017|nolliff|kace:18794 - Job titles now dynamically generate when department is selected, prepopulation still functions. 
 * 10/17/2017|ktaylor|kace:18776 - JavaSript added to dynamically generate Manager.   
 * 10/19/2017|ktaylor|kace:18794 - Edit page updated to include new changes with Job Titles and Manager.
 * 10/19/2017|ktaylor|kace:18776 - Manager changed from text to id.
 * 10/23/2017|ktaylor|kace:18777 - Javascript added to dynamically generate Silicore Model After. 
 * 10/26/2017|ktaylor|kace:18777 - Add user and edit user functioning for Modle After.
 * 10/26/2017|ktaylor|kace:18777 - Fixed adjustment email for model after so it does not send out user_id.
 * 10/31/2017|ktaylor|kace:18777 - Javascript added to dynamically generate Email Model After and add user done. 
 * 10/31/2017|ktaylor|kace:18776 - Changed manager to key off department onchange instead of job title onchange.
 * 11/13/2017|ktaylor|kace:18xxx - Added 'Please Select' back to dropdowns.
 * 11/17/2017|ktaylor|kace:18774 - Added 'is approved' to add user page.
 * 11/21/2017|ktaylor|kace:18774 - Added 'is approved' to edit user page.
 * 11/22/2017|ktaylor|kace:18774 - fixed UI bugs and moved order of operation for update.
 * 11/27/2017|ktaylor|kace:18774 - Completed 'is approved' email functionality.
 * 12/06/2017|ktaylor|kace:18774 - Fixed try throw catch and added it to edit user.
 * 12/11/2017|ktaylor|kace:18774 - Fixed dropdown job title bug on edit user.
 * 01/10/2018|ktaylor|kace:18774 - Added filter so manager can only see his department.
 * 01/10/2018|ktaylor|kace:18774 - Disabled editing once is approved set.
 * 01/17/2018|nolliff|kace:18774 - Doing some cleanup, changed buttons to allow ignoring of forms
******************************************************************************************************************************************/

//==================================================================== BEGIN PHP

?>

<link type="text/css" rel="stylesheet" href="../../Includes/hrstyles.css">

<script src="../../Includes/jquery-ui-1.12.1.custom/jquery.tablesorter.js"></script>

<script>
$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
); 

</script>
<script>

$(function() 
 {
  $("#start-date").datepicker({ dateFormat: 'yy-mm-dd' });
  $("#start-date").datepicker("setDate", new Date());
  $("#separation-date").datepicker({ dateFormat: 'yy-mm-dd' });
  $("#start-date-edit").datepicker({ dateFormat: 'yy-mm-dd' });
  setSelection();
 });
  
  // dynamic dropdown 
  
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


$jobQuery = "call sp_hr_JobTitlesGetAll()";
$jobTitles = mysqli_query($dbconn, $jobQuery);
mysqli_close($dbconn);
          
while($jobTitle = $jobTitles->fetch_assoc())
  {
    $titleNames[] = $jobTitle['name'];
    $titleIDs[] = $jobTitle['id'];
    $titleDescriptions[] = $jobTitle['description'];
    $titleDepartments[] = $jobTitle['department_id'];
    
    
    if (isset($_POST['editemployee']) && isset($_POST['id']))
    {
        
    $dbconn = new mysqli
    (
      $dbc['silicore_hostname'],
      $dbc['silicore_username'],
      $dbc['silicore_pwd'],
      $dbc['silicore_dbname']
    );

    $Id=$_POST['id'];

   $data005 = "call sp_hr_EmpSelectById('$Id')";

   $result005 = mysqli_query($dbconn, $data005);
   $row005 = mysqli_fetch_assoc($result005);
   mysqli_close($dbconn);

      $titleDepartments[]= $row005['department_id'];
     }

/*
     else

     { 
         $titleDepartments[] = $jobTitle['department_id'];

     }
*/

     }

  
$dbc = databaseConnectionInfo();
$dbconn = new mysqli
  (
    $dbc['silicore_hostname'],
    $dbc['silicore_username'],
    $dbc['silicore_pwd'],
    $dbc['silicore_dbname']
  );


$managerQuery = "call sp_hr_DeptManagersGetAll()";
//echo $data022 . "<br>";
$managerNames = mysqli_query($dbconn, $managerQuery);
mysqli_close($dbconn);
          
while($managerName = $managerNames->fetch_assoc())
  {
    $nameMgrnames[] = $managerName['mgrname'];
    $nameIDs[] = $managerName['id'];
    $nameDepartments[] = $managerName['main_department_id'];
  }
     
  
  
$dbc = databaseConnectionInfo();
$dbconn = new mysqli
  (
    $dbc['silicore_hostname'],
    $dbc['silicore_username'],
    $dbc['silicore_pwd'],
    $dbc['silicore_dbname']
  );


$modelQuery = "call sp_hr_EmpGetAll()";
//echo $data022 . "<br>";
$modelAfters = mysqli_query($dbconn, $modelQuery);
mysqli_close($dbconn);
          
while($modelAfter = $modelAfters->fetch_assoc())
  {
    $modelNames[] = $modelAfter['empname'];
    $modelIDs[] = $modelAfter['id'];
    $modelDepartments[] = $modelAfter['main_department_id'];
  }
  
  
$dbc = databaseConnectionInfo();
$dbconn = new mysqli
  (
    $dbc['silicore_hostname'],
    $dbc['silicore_username'],
    $dbc['silicore_pwd'],
    $dbc['silicore_dbname']
  );


$emailModelQuery = "call sp_hr_EmpGetAll()";
//echo $data022 . "<br>";
$emailModelAfters = mysqli_query($dbconn, $emailModelQuery);
mysqli_close($dbconn);
          
while($emailModelAfter = $emailModelAfters->fetch_assoc())
  {
    $emailModelNames[] = $emailModelAfter['empname'];
    $emailModelIDs[] = $emailModelAfter['id'];
    $emailModelDepartments[] = $emailModelAfter['main_department_id'];
  }

     
?>
 

<script>
function populateJobTitles()
  {
    var departmentID = document.getElementById("slcDepartmentId").value;
    var titleSelect = document.getElementById("slcJobTitleId");
    var managerSelect = document.getElementById("slcManager");
    var modelSelect = document.getElementById("txtSilicoreAccountModel");
    var emailModelSelect = document.getElementById("txtEmailAccountModel");
    
    
    var titleNames = <?php echo json_encode($titleNames); ?>;
    var titleIDs = <?php echo json_encode($titleIDs); ?>;
    var titleDscrpts = <?php echo json_encode($titleDescriptions); ?>;
    var titleDepts = <?php echo json_encode($titleDepartments); ?>;
    
    var nameMgrnames = <?php echo json_encode($nameMgrnames); ?>;
    var nameIDs = <?php echo json_encode($nameIDs); ?>;
    var nameDepts = <?php echo json_encode($nameDepartments); ?>;
    
    var modelNames = <?php echo json_encode($modelNames); ?>;
    var modelIDs = <?php echo json_encode($modelIDs); ?>;
    var modelDepts = <?php echo json_encode($modelDepartments); ?>;
    
    var emailModelNames = <?php echo json_encode($emailModelNames); ?>;
    var emailModelIDs = <?php echo json_encode($emailModelIDs); ?>;
    var emailModelDepts = <?php echo json_encode($emailModelDepartments); ?>;
    
    var titleCount = titleIDs.length;
    
    titleSelect.options.length = 0;
    
    var prePopOption = document.createElement("option");
    prePopOption.text = "Please Select";
    prePopOption.value = "0";
    titleSelect.add(prePopOption);
 
//    alert(departmentID);
  
 /*
    var att01 = document.createAttribute("selected");
    att01.value = "selected";
 //   titleSelect.add(att01);
    titleSelect.setAttributeNode(att01);
    
    var att02 = document.createAttribute("disabled");
    att02.value = "disabled";
 //   titleSelect.add(att02);
    titleSelect.setAttributeNode(att02);
 
 */
 
    for(i = 0; i<titleCount+1; i++)
    {   
     // alert(titleDepts[i]);
      //alert(departmentID);
      if(titleDepts[i] === departmentID)
      {
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
    
    for(i = 0; i<managerCount; i++)
    {
      if(nameDepts[i] === departmentID)
      {
        var option = document.createElement("option");
        option.text = nameMgrnames[i];
        option.value = nameIDs[i];
        managerSelect.add(option);
      }
    }
   
    
    var modelCount = modelIDs.length;
    
    modelSelect.options.length = 0;
    
    var prePopOption = document.createElement("option");
    prePopOption.text = "Please Select";
    prePopOption.value = "0";
    modelSelect.add(prePopOption);
    
    for(i = 0; i<modelCount; i++)
    {
      if(modelDepts[i] === departmentID)
      {
        var option = document.createElement("option");
        option.text = modelNames[i];
        option.value = modelIDs[i];
        modelSelect.add(option);
      }
    }
    
    
    var emailModelCount = emailModelIDs.length;
    
    emailModelSelect.options.length = 0;
    
    var prePopOption = document.createElement("option");
    prePopOption.text = "Please Select";
    prePopOption.value = "0";
    emailModelSelect.add(prePopOption);
    
    for(i = 0; i<emailModelCount; i++)
    {
      if(emailModelDepts[i] === departmentID)
      {
        var option = document.createElement("option");
        option.text = emailModelNames[i];
        option.value = emailModelIDs[i];
        emailModelSelect.add(option);
      }
    }
      
  }
</script>






<?php

//include other files
require_once('/var/www/configuration/db-mysql-sandbox.php'); //contains database connection info
require_once('../../Includes/emailfunctions.php'); //contains database connection info
require_once('../../Includes/pagevariables.php'); //contains database connection info
          
global $singleUserObject;



//Set Debugging Options
$debugging = 0; //set this to 1 to see debugging output

$t = time(); //variable used for obtaining the current time
//display information if we are in debugging mode
if ($debugging) 
{
    echo "The current Linux user is: ";
    echo exec('whoami');
    echo "<br/>";
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    echo "<strong>Debugging Enabled</strong><br/>";
    echo "Start time: ";
    echo(date("Y-m-d H:i:s", $t));
    echo "<br/>";
}


$dbc = databaseConnectionInfo();


switch($ServerSubDomain)
{
  case "silicore-dev":
    $addressDev = "devteam@vistasand.com";
    $addressHelp = "devteam@vistasand.com";
    $sendPHPMailDebugFlag = 1;
    break;
  case "silicore-test":
    $addressDev = "devteam@vistasand.com";
    $addressHelp = "devteam@vistasand.com";
    $sendPHPMailDebugFlag = 1;
    break;
  case "silicore":
    $addressDev = "development@vistasand.com";
    $addressHelp = "help@vistasand.com";
    $sendPHPMailDebugFlag = 0;
    break;
  default:
    $addressDev = "devteam@vistasand.com";
    $addressHelp = "devteam@vistasand.com";
    $sendPHPMailDebugFlag = 1;
    break;
}


             

if (empty($_POST)|| isset($_POST['selectallemployees'])) 
{ 
    $x=1;  //top page
}

if (isset($_POST['addemployee'])) 
{ 
    $x=2; // insert employee
}

if (isset($_POST['insertemployee']) && !empty($_POST['txtLastName']) && !empty($_POST['txtFirstName'])) 
{ 
    $x=3; //see all after inserting employee
}          
 
/*if (empty($_POST)) 
{ 
    $x=4;
}
 * 
 */
if (isset($_POST['editemployee']) && isset($_POST['id']))
{ 
    $x=5; // edit employee
} 
if (isset($_POST['updateemployee']))
{
    $x=6; // update and see all after updating employee
}  
 
switch ($x) 
{
  case 1: //see employee 

?>

  <h2>Employee List</h2>

  <div class="datagrid">
    <form action="hrchecklist.php" method="POST">
      <input type="submit" name="addemployee" value="Add new Employee" class="submitButton">
      <br /><br />
 
<?php

// echo ("<br />" . "case 1");
            
// Include our custom connection

// $dbconn = new mysqli(SANDBOX_DB_HOST, SANDBOX_DB_USER, SANDBOX_DB_PWD, SANDBOX_DB_DBNAME001);
    try
    {
    
    $dbconn = new mysqli
     (
       $dbc['silicore_hostname'],
       $dbc['silicore_username'],
       $dbc['silicore_pwd'],
       $dbc['silicore_dbname']
     );

// get the records from the database
             
    $employeesSQL = "call sp_hr_EmpSelect()";
    
    
    }
    catch (Exception $e)
    {
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

    $result01 = mysqli_query($dbconn, $employeesSQL);
    mysqli_close($dbconn);
   
// display records in a table

// set table headers
  

?>            
<!--<div class="hrfront-table">
-->
<!--<div class="datagrid">-->
    <table id="myTable" class="tablesorter">
      <thead style="text-decoration: underline">
      <tr>
<!--   <th>ID</th>  -->
        <th class="headerRowCell">Last Name</th>
        <th class="headerRowCell">First Name</th>
        <th class="headerRowCell"><?php echo $HRProgram?>  ID</th>
        <th class="headerRowCell">Department</th>
        <th class="headerRowCell">Manager</th>
        <th class="headerRowCell">Site</th>
        <th class="headerRowCell">Start Date</th>
        <th class="headerRowCell">Is Active</th>
        <th class="headerRowCell">Action</th>
      </tr>
      </thead>
<?php
  
     $UserDepartment = $singleUserObject->vars['main_department_id']  ;
     $UserType = $singleUserObject->vars['user_type_id'] ;
     //echo "$UserDepartment ";


      while ($employee = mysqli_fetch_assoc($result01))
      {
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

      $NameManager=$employee['manager_user_id']; 

      while($manager = mysqli_fetch_assoc($managerResults))
      {
        if($NameManager==$manager['id'] )
        {
          $ManagerName=$manager['mgrname'];
        }

      } 
        if(($UserDepartment == $employee['department_id'] && $UserType >= 3 )||
                $UserDepartment == 9 || $UserType == 5)
        {
          
			  	echo("
				  <tr>      
					<td style='padding:0px;text-align:center;'>{$employee['last_name']}</td>
					<td style='padding:0px;text-align:center;'>{$employee['first_name']}</td>
					<td style='padding:0px;text-align:center;'>{$employee['employee_id']}</td>
					<td style='padding:0px;text-align:center;'>{$employee['name']}</td>
					<td style='padding:0px;text-align:center;'>{$ManagerName}</td>            
					<td style='padding:0px;text-align:center;'>{$employee['description']}</td>     
					<td style='padding:0px;text-align:center;'>{$employee['start_date']}</td>
					<td style='padding:0px;text-align:center;'>"
					. ($employee['is_active'] == '1' ? 'Yes' : 'No') . "
					</td>");
        
          if($UserType >= 3)
			
		   {
          echo("
            <td style='padding:0px;text-align:center;'>
            <form method='post' action='hrchecklist.php' class='inline'>
              <input type='hidden' name='id' value='{$employee['id']}'>
              <button type='submit' name='editemployee' value='{$employee['id']}' class='hrlink-button'>
              Edit
              </button>
            </form>  

              </td>		
            </tr>");                                                       
			}

        }
        
        } 
?>
    </table>
    <br /> 
      <input type="submit" name="addemployee" value="Add new Employee" class="submitButton">
    </form>
  </div>
               
<?php
  break;
                  
  case 2: //create employee
// echo "case 2";
          
?>
  <div class="hrformgroup">
    <form name="form" method="POST" action="hrchecklist.php">
    <br /> 

    <h2>Add New Employee</h2>
  
    <table>

    <tr>
      <td style="vertical-align:top;text-align:left;">
        <table style="border:none">
          <tr>
            <td style="border:none">Last Name:</td>
            <td style="border:none"><input type="text" name="txtLastName" required/></td>
          </tr>
          <tr>
            <td style="border:none">First Name:</td>
            <td style="border:none"><input type="text" name="txtFirstName" required/></td>
          </tr>
          <tr>
            <td style="border:none"><?php echo $HRProgram?>  ID:</td>
            <td style="border:none"><input type="text" name="txtEmployeeId" required/></td>
          </tr> 
          
                    <tr>
            <td style="border:none">Site:</td>
            <td style="border:none">

   <?php

//        $dbconn = new mysqli(SANDBOX_DB_HOST, SANDBOX_DB_USER, SANDBOX_DB_PWD, SANDBOX_DB_DBNAME001);
          $dbconn = new mysqli
          (
            $dbc['silicore_hostname'],
            $dbc['silicore_username'],
            $dbc['silicore_pwd'],
            $dbc['silicore_dbname']
          );

          $data021 = "call sp_hr_SiteSelect()";
//        $data021 = "SELECT * FROM main_sites";
          $result021 = mysqli_query($dbconn, $data021);
          mysqli_close($dbconn);
//        $row021 = mysqli_fetch_array($result021)

?>                   
          <select name="slcSiteId" id="slcSiteId">

<?php

          while ($row021 = mysqli_fetch_assoc($result021))
//       foreach ($row021 as $site) 
          {      
            if($row021[id] == "10")
            {
?>
            <option value="<?php echo($row021['id'])?>" selected="selected"> <?php echo($row021['description'])?></option>

<?php                      

            } 
            else
            {
?>
            <option value="<?php echo($row021['id'])?>"> <?php echo($row021['description'])?></option>

<?php 
            }
          }

?>    
          </select> 
            <br />
            </td>
            
          <tr>
            
          <tr>
            <td style="border:none">Department:</td>
            <td style="border:none;text-align:left;">
<?php
                              
//$dbconn = new mysqli(SANDBOX_DB_HOST, SANDBOX_DB_USER, SANDBOX_DB_PWD, SANDBOX_DB_DBNAME001);
          $dbconn = new mysqli
          (
            $dbc['silicore_hostname'],
            $dbc['silicore_username'],
            $dbc['silicore_pwd'],
            $dbc['silicore_dbname']
          );

          $data02 = "call sp_hr_DeptSelect()";
//        $data02 = "SELECT * FROM main_departments";
          $result02 = mysqli_query($dbconn, $data02);
          mysqli_close($dbconn);
//        $row029 = mysqli_fetch_array($result02);
//        echo  $row029[1]."test"."<br />"; 

?>            
              <select  onchange="populateJobTitles()"  name="slcDepartmentId" id="slcDepartmentId" required  >

<?php
          
          while ($row02 = mysqli_fetch_assoc($result02))
 //       foreach ($row02 as $department) 
 //       starting with id 2 because id 1 is general
          {      
            if($row02[id] == "2")
            {
?>
            <option value="<?php echo($row02['id'])?>" selected="selected" disabled="disabled"> Please Select</option>
            <option value="<?php echo($row02['id'])?>"> <?php echo($row02['name'])?></option>

<?php                
            } 
            else
            {
?>
            <option value="<?php echo($row02['id'])?>"> <?php echo($row02['name'])?></option>

<?php                       
            }
          }

  ?>    
          </select>
            <br />
            </td>
          </tr>
          
        <tr>
        <td style="border:none">Job Title:</td>
        <td style="border:none;text-align:left;">
   

          <select  name="slcJobTitleId" id="slcJobTitleId" required  >
          
          </select>
            <br />
            </td>
          </tr>       
         
          <tr>
            <td style="border:none">Manager:</td>
            <td style="border:none;text-align:left;">
              
            <select name="slcManager" id="slcManager" required >
            </select>
            <br />
            </td>
          </tr>

            <td style="border:none">Start Date</td>
            <td style="border:none"><input type="text" id="start-date" name="txtStartDate" /></td>
          </tr>
          <tr>
            <td style="border:none">Separation Date</td>
            <td style="border:none"><input type="text" id="separation-date" name="txtSeparationDate" /></td>
          </tr>
          
          <tr>
            <td style="border:none" colspan="2">
            <input type="hidden" name="chkIsActive" value="0" />
            <input type="checkbox" name="chkIsActive" value="1" checked> Is Active</td>
          </tr> 
          
<?php           
          if($userPermissionsArray['vista']['granbury']['hr'] < 4)
          {
            echo "continue";
          }
          else
          {
          ?>
          <tr>
            <td style="border:none" colspan="2">
            <input type="hidden" name="chkIsApproved" value="0" />
            <input type="checkbox" name="chkIsApproved" value="1">
            
            Is Approved</td>
            </tr>
          <?php
           }         
?>
          
        </table>
      </td>
                   
      <td style="padding:30px 30px 30px 20px">
          <ul style="list-style-type:none">
            
            <li>
              <input type="hidden" name="chkSilicoreAccountRequested" value="0" />
              <input type="checkbox" name="chkSilicoreAccountRequested" value="1" checked >
              Silicore Account
            </li>
            <li>
              Model After:  
              <select id="txtSilicoreAccountModel" name="txtSilicoreAccountModel"   required>
              </select>
              <br />
            </li><br>
            <li>
              <input type="hidden" name="chkEmailAccountRequested" value="0" />
              <input type="checkbox" name="chkEmailAccountRequested" value="1" > 
              Email Account
            </li><br>
            
            <li>
              Model After:  
              <select id="txtEmailAccountModel" name="txtEmailAccountModel" > 
              </select>
              <br />
            </li><br>   
            
            <li>
              
                <input type="hidden" name="chkCellPhoneRequested" value="0" />
                <input type="checkbox" name="chkCellPhoneRequested" value="1" >
                Cell Phone: 
             <input type="text" name="txtCellPhoneRequested" placeholder="Serial Number, Android/iPhone, etc." > 
            </li><br> 
            
            <li>
             <input type="hidden" name="chkLaptopRequested" value="0" />
             <input type="checkbox" name="chkLaptopRequested" value="1" >
             Laptop:  
             <input type="text" name="txtLaptopRequested" placeholder="Serial number, model number, etc." > 
            </li> <br>
            <li>
             <input type="hidden" name="chkDesktopRequested" value="0" />
             <input type="checkbox" name="chkDesktopRequested" value="1" >
             Desktop:  
             <input type="text" name="txtDesktopRequested" placeholder="Serial number, RAM, etc."> 
            </li><br>
            
            <li>
             Monitors: 
             <input type="text" name="txtMonitorsRequested" placeholder="Number, Size, etc.">
            </li><br>    
            
            <li>
             <input type="hidden" name="chkTabletRequested" value="0" />
             <input type="checkbox" name="chkTabletRequested" value="1" > 
             Tablet:
             <input type="text" name="txtTabletRequested" placeholder="Serial Number, Android/iPad, etc." > 
            </li><br>
            
            <li>
             <input type="hidden" name="chkTwoWayRadioRequested" value="0" />
             <input type="checkbox" name="chkTwoWayRadioRequested" value="1">
             Radio:  
             <input type="text" name="txtTwoWayRadioRequested" placeholder="Serial Number, etc." > 
            </li><br>
            <li>
              Special Software:  
              <input type="text" name="txtSpecialSoftwareRequested"  placeholder="Photoshop, CAD, etc." maxlength="45">
            </li><br>
            <li>
              Comments:  <br />
              <textarea id="hrformgrouparea" name="txaComments" colspan="2" rows="15" cols="45" maxlength="1024"></textarea>
            </li>

          </ul> 
     </td>                        
    </tr>
  </table>

<?php
            
    $user_id = $_SESSION["user_id"];
    $Date01 = date("Y/m/d H:i:s");
            
?>

    <p>
      <input type="hidden" name="hidden"  />
      <input type="hidden" name="txtCreateDate" value="<?php echo($Date01)?>"/>
      <input type="hidden" name="txtCreateUserId"value="<?php echo($user_id)?>"  />
      <input type="submit" name="insertemployee" value="Create Employee" class="submitButton" >
      <input type="submit" name="selectallemployees" value="See all Employees" class="submitButton" formnovalidate>
    </p>

    </form>
  </div>

<?php
            
  break;
         
  case 3:// Insert employee then print employee table with edit checkbox 
            
//  echo "case 3". "<br />";
//  $Date02 = $_POST['txtCreateDate'];
//  $UserId = $_POST['txtCreateUserId'];
//  echo($Date02 . "<br />");
//  echo($UserId . "<br />");
            
        
?>
  <h2>Employee List</h2>
  <div class="datagrid">

  <p id="demo"></p>
  <form action="hrchecklist.php" method="POST">

  <input type="submit" name="addemployee" value="Add new Employee" class="submitButton">
  <br /><br />
<?php

$dbconn = new mysqli
(
  $dbc['silicore_hostname'],
  $dbc['silicore_username'],
  $dbc['silicore_pwd'],
  $dbc['silicore_dbname']
);

$data031 = "call sp_hr_EmpGetAll()";  
// xxx$data031 = "  xxxx";
$result031 = mysqli_query($dbconn, $data031);

mysqli_close($dbconn);
  
$nameSilicoreAccountModel=$_POST['txtSilicoreAccountModel']; 
 
while($row031 = mysqli_fetch_assoc($result031))
{
  if($nameSilicoreAccountModel==$row031['id'] )
  {
    $SilicoreAccountModelName=$row031['empname'];
  }

}       

$dbconn = new mysqli
(
  $dbc['silicore_hostname'],
  $dbc['silicore_username'],
  $dbc['silicore_pwd'],
  $dbc['silicore_dbname']
);

$data032 = "call sp_hr_EmpGetAll()";  
// xxx$data031 = "  xxxx";
$result032 = mysqli_query($dbconn, $data032);

mysqli_close($dbconn);
  
$nameEmailAccountModel=$_POST['txtEmailAccountModel']; 
 
while($row032 = mysqli_fetch_assoc($result032))
{
  if($nameEmailAccountModel==$row032['id'] )
  {
    $EmailAccountModelName=$row032['empname'];
  }

}   
  

//  Include our custom connection
    
    $dbconn = new mysqli
     (
       $dbc['silicore_hostname'],
       $dbc['silicore_username'],
       $dbc['silicore_pwd'],
       $dbc['silicore_dbname']
     );


  $LastName = $_POST['txtLastName'];
  $FirstName = $_POST['txtFirstName'];
  $EmployeeId = $_POST['txtEmployeeId'];
  $DepartmentId = $_POST['slcDepartmentId'];
  $JobTitleId = $_POST['slcJobTitleId'];
  $Manager = $_POST['slcManager'];
  $SiteId = $_POST['slcSiteId'];
  $SilicoreAccountRequested=$_POST['chkSilicoreAccountRequested'];  
  $SilicoreAccountModel=$_POST['txtSilicoreAccountModel'];
  $EmailAccountRequested=$_POST['chkEmailAccountRequested'];
  $EmailAccountModel=$_POST['txtEmailAccountModel'];
  $CellPhoneRequested=$_POST['chkCellPhoneRequested'];   
  $CellPhoneDetail=$_POST['txtCellPhoneRequested'];
  $LaptopRequested=$_POST['chkLaptopRequested'];     
  $LaptopDetail=$_POST['txtLaptopRequested'];
  $DesktopRequested=$_POST['chkDesktopRequested'];
  $DesktopDetail=$_POST['txtDesktopRequested'];
  $MonitorsRequested=$_POST['txtMonitorsRequested'];
  $TabletRequested=$_POST['chkTabletRequested'];
  $TabletDetail=$_POST['txtTabletRequested'];
  $TwoWayRadioRequested=$_POST['chkTwoWayRadioRequested'];
  $TwoWayRadioDetail=$_POST['txtTwoWayRadioRequested'];
  $SpecialSoftwareRequested=$_POST['txtSpecialSoftwareRequested'];
  $Comments=$_POST['txaComments'];
  $ApprovedUserId = $_SESSION['user_id'];
  $CreateDate=$_POST['txtCreateDate'];
  $CreateUserId=$_POST['txtCreateUserId'];          
  
  
  if (isset($_POST['txtStartDate']) && $_POST['txtStartDate'] != ''  )
  {
    $StartDate = "'".filter_input(INPUT_POST, 'txtStartDate')."'";
  }
  else
  {
    $StartDate= "null";
  }
  if(isset($_POST['chkIsActive']) && $_POST['chkIsActive'] != '')
    {
      $IsActive = 1;
    }
  else
    {
      $IsActive = 0;
    }
    
  if(isset($_POST['chkIsApproved']) && $_POST['chkIsApproved'] != '')
    {
      $IsApproved = 1;
    }
  else
    {
      $IsApproved = 0;
    }
//  insert date for new employee
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
              '$SilicoreAccountModel',
              '$EmailAccountRequested',
              '$EmailAccountModel',
              '$CellPhoneRequested',
              '$LaptopRequested',
              '$DesktopRequested',
              '$MonitorsRequested',
              '$TabletRequested',
              '$TwoWayRadioRequested',
              '$SpecialSoftwareRequested',
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
     
    
try
  {
    $result03 = mysqli_query($dbconn, $employeeInsertSQL);
    if ($result03 == 0)
    {
      echo("Error description: " . mysqli_error($dbconn));
      throw new Exception("Error! There was a problem when attempting to insert this new employee using call sp_hr_EmpInsert.");
    }

   else
    {
      //echo $data03;
      //success!
  
   
    
  //    email development (development@vistasand.com) or support (help@vistasand.com)
                      
   if ($IsApproved==1)
  {  
  
  if ($SilicoreAccountRequested == 1)
  {
     $address=$addressDev;
     $subject ="Silicore Account Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
     $body = ($FirstName .' '. $LastName .' '. "needs a Silicore account." .'  '. "Model after" .' '. $SilicoreAccountModelName .'.');
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }

  if ($EmailAccountRequested == 1)
  {
     $address=$addressHelp;
     $subject = "Email Account Needed - " . $FirstName . " " . $LastName .":  ". "Model is after" ." ". $EmailAccountModelName . "." . " " . $SiteBuildType;
     $body = ($FirstName .' '. $LastName .' '. "needs an email account.");
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }

  if ($CellPhoneRequested == 1)
  {
     $address=$addressHelp;
     $subject ="Cell Phone Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
     $body = ($FirstName .' '. $LastName .' '. "needs an cell phone.");
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }

  if ($LaptopRequested == 1)
  {
     $address=$addressHelp;   
     $subject ="Laptop  Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
     $body = ($FirstName .' '. $LastName .' '. "needs an laptop."); 
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }

  if ($DesktopRequested == 1)
  {
     $address=$addressHelp;
     $subject ="Desktop Computer  Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
     $body = ($FirstName .' '. $LastName .' '. "needs a desktop computer" .'  '. "with" .' '. $MonitorsRequested .' '.'monitors.');
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }

  if ($TabletRequested == 1)
  {
     $address=$addressHelp;
     $subject ="Tablet  Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
     $body = ($FirstName .' '. $LastName .' '. "needs a tablet.");
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }

  if ($TwoWayRadioRequested == 1)
  {
     $address=$addressHelp;
     $subject ="Two-Way Radio  Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
     $body = ($FirstName .' '. $LastName .' '. "needs a two-way radio.");
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }

  if (!empty($SpecialSoftwareRequested))
  {
     $address=$addressHelp;
     $subject ="Special Software  Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
     $body = ($FirstName .' '. $LastName .' '. "needs" . ' '. $SpecialSoftwareRequested .'.');
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }
  
  
  }//end of if approved
  
  
  }//part of else
  
  }//end of try

catch (Exception $e)
  { 
    echo 'Caught exception: ',  $e->getMessage(), "\n";
    //$_SESSION['sample_error'] = "Error retrieving data" . $e;

  } 
  
     mysqli_close($dbconn); 
  
 // Include our custom connection
//             $dbconn = new mysqli(SANDBOX_DB_HOST, SANDBOX_DB_USER, SANDBOX_DB_PWD, SANDBOX_DB_DBNAME001);
$dbconn = new mysqli
 (
   $dbc['silicore_hostname'],
   $dbc['silicore_username'],
   $dbc['silicore_pwd'],
   $dbc['silicore_dbname']
 );

// get the records from the database
             
  $data04 = "call sp_hr_EmpSelect()";
/* $data04 = "SELECT main_hr_checklist.*, main_departments.name
    FROM main_hr_checklist
    LEFT JOIN main_departments 
    ON main_hr_checklist.department_id = main_departments.id
    ORDER BY main_hr_checklist.id"; 
*/
   $result04 = mysqli_query($dbconn, $data04);
// close database connection
   mysqli_close($dbconn);

?>
<!-- // display records in a table
        echo "<table>";

    //  set table headers
        echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Employee ID</th><th>Department</th><th>Manager</th><th></th></tr>";
-->                  
  <table id="myTable" class="tablesorter">
    <thead style="text-decoration: underline">
    <tr>
<!--  <th>ID</th>  -->
      <th>Last Name</th>
      <th>First Name</th>
      <th><?php echo "$HRProgram" . '  ' ?>ID</th>
      <th>Department</th>
      <th>Manager</th>
      <th>Site</th>
      <th>Start Date</th>
      <th>Is Active</th>
      <th>Action</th>
    </tr>
    </thead>

<?php            
    $UserDepartment = $singleUserObject->vars['main_department_id']  ;
    $UserType = $singleUserObject->vars['user_type_id'] ;              
    
    while ($row04 = mysqli_fetch_assoc($result04))
    {
     if(($UserDepartment == $row04['department_id'] && $UserType >= 3 )||
                ($UserDepartment == 9 ) || ($UserType == 5 && $UserDepartment == 2))
                
     {
?>
    <tr>
         
      <td style="padding:0px;text-align:center;"><?php echo($row04['last_name']) ?></td>
      <td style="padding:0px;text-align:center;"><?php echo($row04['first_name']) ?> </td>
      <td style="padding:0px;text-align:center;"><?php echo($row04['employee_id']) ?> </td>
      <td style="padding:0px;text-align:center;"><?php echo($row04['name']) ?> </td>
      
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
  
$NameManager=$row04['manager_user_id']; 
 
while($row041 = mysqli_fetch_assoc($result041))
{
  if($NameManager==$row041['id'] )
  {
    $ManagerName=$row041['mgrname'];
  }

} 

?>
      <td style="padding:0px;text-align:center;"><?php echo($ManagerName) ?> </td>
      <td style="padding:0px;text-align:center;"><?php echo($row04['description']) ?> </td>
      <td style="padding:0px;text-align:center;"><?php echo($row04['start_date']) ?> </td>
      <td style="padding:0px;text-align:center;">
<?php       
      if($row04['is_active']=="1")
      {
        echo("Yes");
      }
      if($row04['is_active']=="0")
      {
        echo("No");
      }
?>
      </td>
      
      <td style="padding:0px;text-align:center;">
<?php        
      if($row04['is_approved']=="0")
        
      {
?>
      
      <form method="post" action="hrchecklist.php" class="inline">
        <input type="hidden" name="id" value="<?php echo($row04['id']) ?>">
        <button type="submit" name="editemployee" value="<?php echo($row04['id']) ?>" class="hrlink-button">
         Edit
        </button>
      </form> 
 <?php 
      }
      else 
      {
        echo "<a href='hrchecklist.php'>None</a>";
      }
  ?>
      </td>

    </tr>  
             
<?php
    }
    }

?>
  </table>
  <br />
    <input type="submit" name="addemployee" value="Add new Employee" class="submitButton">        
    </form>
  </div>

<?php

  break;      
  
  case 5: //edit employee
            
// echo "case 5". "<br />";
                    
// $dbconn = new mysqli(SANDBOX_DB_HOST, SANDBOX_DB_USER, SANDBOX_DB_PWD, SANDBOX_DB_DBNAME001);

  $dbconn = new mysqli
   (
     $dbc['silicore_hostname'],
     $dbc['silicore_username'],
     $dbc['silicore_pwd'],
     $dbc['silicore_dbname']
   );
          
  $Id=$_POST['id'];

//  $data05 = "SELECT * FROM main_hr_checklist WHERE id=$Id";

  $data05 = "call sp_hr_EmpSelectById('$Id')";
            
  $result05 = mysqli_query($dbconn, $data05);
  $row05 = mysqli_fetch_assoc($result05);
  mysqli_close($dbconn);
            
  $user_id = $_SESSION["user_id"];
  $Date04 = date("Y/m/d H:i:s");
?>
  <div class="hrformgroup">
    <form action="hrchecklist.php" method="post">
    <table>

      <h2>Edit Employee</h2>

      <tr>
        <td style="vertical-align:top;">
          <table style="border:none">
<!--           <tr>
               <td style="border:none">Table ID:</td>
               <td style="border:none"><input type="text" name="txtId" value="<?php// echo $row05['id']?>"/></td>
             </tr>  
-->            
            <tr>
              <td style="border:none">Last Name:</td>
              <td style="border:none"><input type="text" name="txtLastName" value="<?php echo $row05['last_name']?>" required/></td>
            </tr>
            <tr>
              <td style="border:none">First Name:</td>
              <td style="border:none"><input type="text" name="txtFirstName" value="<?php echo $row05['first_name']?>" required/></td>
            </tr>
            <tr>
              <td style="border:none"><?php echo $HRProgram?>  ID:</td>
              <td style="border:none"><input type="text" name="txtEmployeeId" value="<?php echo $row05['employee_id']?>" required/></td>
            </tr>
            
            <tr>
              <td style="border:none">Site:</td>
              <td style="border:none">
<?php                        
                        
  
//$dbconn = new mysqli(SANDBOX_DB_HOST, SANDBOX_DB_USER, SANDBOX_DB_PWD, SANDBOX_DB_DBNAME001);

              $dbconn = new mysqli
               (
                 $dbc['silicore_hostname'],
                 $dbc['silicore_username'],
                 $dbc['silicore_pwd'],
                 $dbc['silicore_dbname']
               );

// this section is for editing the site location of the user with a dropdown
              
              
              $data061 = "call sp_hr_SiteSelect()";
//            $data061 = "SELECT id, name FROM main_sites";
              $result061 = mysqli_query($dbconn, $data061);
                           
              mysqli_close($dbconn);
               
//$dbconn = new mysqli(SANDBOX_DB_HOST, SANDBOX_DB_USER, SANDBOX_DB_PWD, SANDBOX_DB_DBNAME001);

              $dbconn = new mysqli
               (
                 $dbc['silicore_hostname'],
                 $dbc['silicore_username'],
                 $dbc['silicore_pwd'],
                 $dbc['silicore_dbname']
               );                        

              $data071 = "call sp_hr_EmpDeptSiteSelectById($Id)";    
/*            $data071 = "SELECT main_hr_checklist.*, main_departments.name
                          FROM main_hr_checklist
                          LEFT JOIN main_departments 
                          ON main_hr_checklist.department_id = main_departments.id  
                          WHERE main_hr_checklist.id=".'"'.$Id.'"';
*/
    
//            echo($data071);
                           
              $result071 = mysqli_query($dbconn,$data071);
//            echo($result071);
              $row071 = mysqli_fetch_assoc($result071);
              mysqli_close($dbconn);                                   

?>                   
              <select name="slcSiteId" id="slcSiteId">
                                         
<?php
              while ($row061 = mysqli_fetch_assoc($result061))
              {      
                if($row061['description']==$row071['description'])                               
                {

?>
                <option value="<?php echo($row071['site_id'])?>" selected="selected"> <?php echo($row071['description'])?></option>
                      
<?php 
                } 
                else
                {
?>
                <option value="<?php echo($row061['id'])?>"> <?php echo($row061['description'])?></option>
                      
<?php 
                 }
               }
  
?>    
              </select>  
              </td>
            </tr>
            
            <tr>
              <td style="border:none">Department:</td>
              <td style="border:none">

<?php
                              
// $dbconn = new mysqli(SANDBOX_DB_HOST, SANDBOX_DB_USER, SANDBOX_DB_PWD, SANDBOX_DB_DBNAME001);

// $dbconn = new mysqli ($dbc['silicore_hostname'],$dbc['silicore_username'],$dbc['silicore_pwd'],$dbc['silicore_dbname']);


              $dbconn = new mysqli
               (
                 $dbc['silicore_hostname'],
                 $dbc['silicore_username'],
                 $dbc['silicore_pwd'],
                 $dbc['silicore_dbname']
               );

              $data06 = "call sp_hr_DeptSelect()";
//            $data06 = "SELECT id, name FROM main_departments";
              $result06 = mysqli_query($dbconn, $data06);

              mysqli_close($dbconn);

// $dbconn = new mysqli(SANDBOX_DB_HOST, SANDBOX_DB_USER, SANDBOX_DB_PWD, SANDBOX_DB_DBNAME001);

              $dbconn = new mysqli
               (
                 $dbc['silicore_hostname'],
                 $dbc['silicore_username'],
                 $dbc['silicore_pwd'],
                 $dbc['silicore_dbname']
               ); 
//set and edit department id in dropdown
              
              
              $data07 = "call sp_hr_EmpDeptSiteSelectById($Id)";    
/*            $data07 = "SELECT main_hr_checklist.*, main_departments.name
                         FROM main_hr_checklist
                         LEFT JOIN main_departments 
                         ON main_hr_checklist.department_id = main_departments.id 
                         LEFT JOIN main_sites
                         ON main_hr_checklist.site_id = main_sites.id  
                         WHERE main_hr_checklist.id=".'"'.$Id.'"';
*/
    
//            echo($data07);
                           
              $result07 = mysqli_query($dbconn,$data07);
 //           echo($result07);
              $row07 = mysqli_fetch_assoc($result07);
          
              mysqli_close($dbconn);                                   
?>                   
                       
              <select onchange="populateJobTitles()" name="slcDepartmentId" id="slcDepartmentId">
                                         
<?php
              while ($row06 = mysqli_fetch_assoc($result06))
              {      
                if($row06['name']==$row07['name'])                               
                {
?>
              <option value="<?php echo($row07['department_id'])?>" selected="selected" required> <?php echo($row07['name'])?></option>
                      
<?php           } 
                else
                {
?>
              <option value="<?php echo($row06['id'])?>"> <?php echo($row06['name'])?></option>
                      
<?php           }
              }
 
                       
?>    
              </select>  
              </td>
            </tr>
            
              <td style="border:none">Job Title:</td>
              <td style="border:none">

<?php


// set and edit Job Title in dropdown



// $dbconn = new mysqli(SANDBOX_DB_HOST, SANDBOX_DB_USER, SANDBOX_DB_PWD, SANDBOX_DB_DBNAME001);

// $dbconn = new mysqli ($dbc['silicore_hostname'],$dbc['silicore_username'],$dbc['silicore_pwd'],$dbc['silicore_dbname']);


              $dbconn = new mysqli
               (
                 $dbc['silicore_hostname'],
                 $dbc['silicore_username'],
                 $dbc['silicore_pwd'],
                 $dbc['silicore_dbname']
               );

              $data062 = "call sp_hr_JobSelect()";
//            $data062 = "SELECT id, name FROM main_departments";
              $result062 = mysqli_query($dbconn, $data062);

              mysqli_close($dbconn);

// $dbconn = new mysqli(SANDBOX_DB_HOST, SANDBOX_DB_USER, SANDBOX_DB_PWD, SANDBOX_DB_DBNAME001);

              $dbconn = new mysqli
               (
                 $dbc['silicore_hostname'],
                 $dbc['silicore_username'],
                 $dbc['silicore_pwd'],
                 $dbc['silicore_dbname']
               ); 

              
              
              $data072 = "call sp_hr_EmpDeptSiteSelectById($Id)";    
/*            $data072 = "SELECT main_hr_checklist.*, main_departments.name
                         FROM main_hr_checklist
                         LEFT JOIN main_departments 
                         ON main_hr_checklist.department_id = main_departments.id 
                         LEFT JOIN main_sites
                         ON main_hr_checklist.site_id = main_sites.id  
                         WHERE main_hr_checklist.id=".'"'.$Id.'"';
*/
    
//            echo($data072);
                           
              $result072 = mysqli_query($dbconn,$data072);
 //           echo($result07);
              $row072 = mysqli_fetch_assoc($result072);
          
              mysqli_close($dbconn);                                   
?>                   
                       
              <select name="slcJobTitleId" id="slcJobTitleId" required>
                                         
<?php
              while ($row062 = mysqli_fetch_assoc($result062))
              {      
                if($row062['name']==$row072['job_title_name'])                               
                {
?>
              <option value="<?php echo($row072['job_title_id'])?>" selected="selected"> <?php echo($row072['job_title_name'])?></option>
                      
<?php           

                } 
                else
                {
?>
              <option value="<?php echo($row062['id'])?>"> <?php echo($row062['name'])?></option>
                      
<?php           }
              }
 
                       
?>    
              </select>  
              </td>
            </tr>
            
            
            <tr>
              <td style="border:none">Manager:</td>
              <td style="border:none">
                
                
<?php


// set and edit Manager in dropdown

              $dbconn = new mysqli
               (
                 $dbc['silicore_hostname'],
                 $dbc['silicore_username'],
                 $dbc['silicore_pwd'],
                 $dbc['silicore_dbname']
               );

              $data063 = "call sp_hr_DeptManagersGetAll()";
//            xxxxxxxxx$data063 = "SELECT id, name FROM main_departments";
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
/*            xxxxxx$data073 = "SELECT main_hr_checklist.*, main_departments.name
                         FROM main_hr_checklist
                         LEFT JOIN main_departments 
                         ON main_hr_checklist.department_id = main_departments.id 
                         LEFT JOIN main_sites
                         ON main_hr_checklist.site_id = main_sites.id  
                         WHERE main_hr_checklist.id=".'"'.$Id.'"';
*/
    
//            echo($data073);
                           
              $result073 = mysqli_query($dbconn,$data073);
 //           echo($result07);
              $row073 = mysqli_fetch_assoc($result073);
          
              mysqli_close($dbconn);                        
                            
?>                               
              <select name="slcManager" id="slcManager" required >
                
<?php
              while ($row063 = mysqli_fetch_assoc($result063))
              {      
                if($row063['mgrname']==$row073['mgrname'])                               
                {
?>
              <option value="<?php echo($row073['manager_user_id'])?>" selected="selected"> <?php echo($row073['mgrname'])?></option>
                      
<?php           } 
                else
                {
?>
              <option value="<?php echo($row063['id'])?>"> <?php echo($row063['mgrname'])?></option>
                      
<?php           }
              }
                       
?>    
              </select> 
              </td>
            </tr>

            <tr>
              <td style="border:none">Start Date</td>
              <td style="border:none"><input type="text" id="start-date-edit" name="txtStartDate" value="<?php echo $row05['start_date']?>" /></td>
            </tr>
            <tr>
              <td style="border:none">Separation Date</td>
              <td style="border:none"><input type="text" id="separation-date" name="txtSeparationDate" value="<?php echo $row05['separation_date']?>" /></td>
            </tr>                      
            <tr>
              <td style="border:none" colspan="2">
              <input type="hidden" name="chkIsActive" value="0" />
              <input type="checkbox" name="chkIsActive" value="1"  <?php if ($row05['is_active']==="1") {echo "checked";} ?>> Is Active</td>
            </tr>  
            
          <?php
          if($userPermissionsArray['vista']['granbury']['hr'] < 4)
          {
         
          ?>
            </table>
          </td>
          <?php
        
          }
          else
          {
          ?>
            <tr>
              <td style="border:none" colspan="2">
              <input type="hidden" name="chkIsApproved" value="0" />
              <input type="checkbox" name="chkIsApproved" value="1"  <?php if ($row05['is_approved']==="1") {echo "checked";} ?>> Is Approved</td>
            </tr> 
          </table>
        </td>
        
        
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
// xxx$data031 = "  xxxx";
$result054 = mysqli_query($dbconn, $data054);

mysqli_close($dbconn);
  
$nameSilicoreAccountModel=$row05['silicore_account_model']; 
 
while($row054 = mysqli_fetch_assoc($result054))
{
  if($nameSilicoreAccountModel==$row054['id'] )
  {
    $SilicoreAccountModelName=$row054['empname'];
  }

}                              

$dbconn = new mysqli
(
  $dbc['silicore_hostname'],
  $dbc['silicore_username'],
  $dbc['silicore_pwd'],
  $dbc['silicore_dbname']
);

$data055 = "call sp_hr_EmpGetAll()";  
// xxx$data031 = "  xxxx";
$result055 = mysqli_query($dbconn, $data055);

mysqli_close($dbconn);
  
$nameEmailAccountModel=$row05['email_account_model_id']; 
 
while($row055 = mysqli_fetch_assoc($result055))
{
  if($nameEmailAccountModel==$row055['id'] )
  {
    $EmailAccountModelName=$row055['empname'];
  }

}
          
          
          if(isset($row05['two_way_radio_notes']) && $row05['two_way_radio_notes'] !="")
          {
            $radioTxt = $row05['two_way_radio_notes'];
          }
          else
          {
            $radioTxt = "Serial Number, etc." ;
          }
?>               
        <td style="padding:30px 30px 30px 20px">
        <ul style="list-style-type:none">
          <li>
            <input type="hidden" name="chkSilicoreAccountRequested" value="0" />
            <input type="checkbox" name="chkSilicoreAccountRequested" value="1" <?php if ($row05['silicore_account_requested']==="1") {echo("disabled checked");} ?>>
            Silicore Account
          </li>
          <li>
            <label>Model After: </label> 
<?php           
  // set and edit Silicore Model After in dropdown

              $dbconn = new mysqli
               (
                 $dbc['silicore_hostname'],
                 $dbc['silicore_username'],
                 $dbc['silicore_pwd'],
                 $dbc['silicore_dbname']
               );

              $data064 = "call sp_hr_EmpGetAll()";
 
              $result064 = mysqli_query($dbconn, $data064);

              mysqli_close($dbconn);
              
              
              
              $dbconn = new mysqli
               (
                 $dbc['silicore_hostname'],
                 $dbc['silicore_username'],
                 $dbc['silicore_pwd'],
                 $dbc['silicore_dbname']
               ); 

              
              
              $data074 = "call sp_hr_EmpDeptSiteSelectById($Id)";    
 

    
//            echo($data073);
                           
              $result074 = mysqli_query($dbconn,$data074);
 //           echo($result07);
              $row074 = mysqli_fetch_assoc($result074);
          
              mysqli_close($dbconn);                        
                            
?>                               
              <select name="txtSilicoreAccountModel" id="txtSilicoreAccountModel"   required >
                
<?php
              while ($row064 = mysqli_fetch_assoc($result064))
              {      
                if($row064['id']==$row074['silicore_account_model'])                               
                {
?>
              <option value="<?php echo($row074['silicore_account_model'])?>" selected="selected"> <?php echo($SilicoreAccountModelName) ?></option>
                      
<?php           } 
                else
                {
?>
              <option value="<?php echo($row064['id'])?>"> <?php echo($row064['empname'])?></option>
                      
<?php           }
              }
                       
?>    
              </select> 
              <br /> 
          
          </li>
          <li>
            <input type="hidden" name="chkEmailAccountRequested" value="0" />
            <input type="checkbox" name="chkEmailAccountRequested" value="1" <?php if ($row05['email_account_requested']==="1") {echo "disabled checked";} ?>>
            Email Account
          </li>
          <li>
            <label>Model After: </label>
 <?php           
  // set and edit Email Model After in dropdown

              $dbconn = new mysqli
               (
                 $dbc['silicore_hostname'],
                 $dbc['silicore_username'],
                 $dbc['silicore_pwd'],
                 $dbc['silicore_dbname']
               );

              $data065 = "call sp_hr_EmpGetAll()";
 
              $result065 = mysqli_query($dbconn, $data065);

              mysqli_close($dbconn);
              
              
              
              $dbconn = new mysqli
               (
                 $dbc['silicore_hostname'],
                 $dbc['silicore_username'],
                 $dbc['silicore_pwd'],
                 $dbc['silicore_dbname']
               ); 

              
              
              $data075 = "call sp_hr_EmpDeptSiteSelectById($Id)";    
 

    
//            echo($data073);
                           
              $result075 = mysqli_query($dbconn,$data075);
 //           echo($result07);
              $row075 = mysqli_fetch_assoc($result075);
          
              mysqli_close($dbconn);                        
                            
?>                    
            <select name="txtEmailAccountModel" id="txtEmailAccountModel"  > 
              
              
<?php
              while ($row065 = mysqli_fetch_assoc($result065))
              {      
                if($row065['id']==$row075['email_account_model_id'])                               
                {
?>
              <option value="<?php echo($row075['email_account_model_id'])?>" selected="selected"> <?php echo($EmailAccountModelName) ?></option>
                      
<?php           } 
                else
                {
?>
              <option value="<?php echo($row065['id'])?>"> <?php echo($row065['empname'])?></option>
                      
<?php           }
              }
                       
?>    
              </select> 
              <br />             
              
              
 
          </li>      
          <li>

            <label>Cell Phone:
              <input type="hidden" name="chkCellPhoneRequested" value="0" />
              <input type="checkbox" name="chkCellPhoneRequested" value="1" <?php if ($row05['cell_phone_requested']==="1") {echo "disabled checked";} ?>>
            </label>  
            <input type="text" name="txtCellPhoneRequested" value="<?php echo ($row05['cell_phone_notes']) ?>" placeholder="Serial Number, Android/iPhone, etc."> 
          </li> 
          <li>
            <label>Laptop: 
              <input type="hidden" name="chkLaptopRequested" value="0" />
              <input type="checkbox" name="chkLaptopRequested" value="1" <?php if ($row05['laptop_requested']==="1") {echo "disabled checked";} ?>>
            </label> 
            <input type="text" name="txtLaptopRequested" value="<?php echo($row05['laptop_notes']) ?>" placeholder="Serial number, model number, etc."> 
          </li>
          <li>

            <label>Desktop:
              <input type="hidden" name="chkDesktopRequested" value="0" />
              <input type="checkbox" name="chkDesktopRequested" value="1" <?php if ($row05['desktop_requested']==="1") {echo "disabled checked";} ?> >
            </label>  
            <input type="text" name="txtDesktopRequested" value="<?php echo($row05['desktop_notes']) ?>" placeholder="Serial number, RAM, etc."> 
          </li>
          <li>
            <label>Monitors:</label>  
            <input type="text" name="txtMonitorsRequested" value="<?php echo $row05['monitors_requested'] ?>" placeholder="Number, Size, etc.">
          </li>       
          <li>

            <label>Tablet:
              <input type="hidden" name="chkTabletRequested" value="0" />
              <input type="checkbox" name="chkTabletRequested" value="1" <?php if($row05['tablet_requested']==="1"){echo "disabled checked";}?>>
            </label>  
            <input type="text" name="txtTabletRequested" value="<?php echo ($row05['tablet_notes']) ?>" placeholder="Serial Number, Android/iPad, etc."> 
          </li>
          <li>
            <label>Radio:
              <input type="hidden" name="chkTwoWayRadioRequested" value="0" />
              <input type="checkbox" name="chkTwoWayRadioRequested" value="1" <?php if ($row05['two_way_radio_requested']==="1") {echo "disabled checked";} ?>>
            </label> 
            <input type="text" name="txtTwoWayRadioRequested" value="<?php echo($row05['two_way_radio_notes']) ?>" placeholder="Serial Number, etc."> 
          </li>
          <li>
            <label>Software:</label> 
            <input type="text" name="txtSpecialSoftwareRequested" value="<?php echo $row05['special_software_requested'] ?>"placeholder="Photoshop, CAD, etc.">
          </li>
          <li>Comments:  <br /><textarea id="hrformgrouparea" rows="15" cols="45" colspan="2" name="txaComments"><?php echo($row05['comments'])?></textarea></li><br />
        </ul> 
        </td>                        
      </tr>            
    </table>
  <br />
  <input type="hidden" name="txtId" value="<?php echo $row05['id']?>">
  <input type="hidden" name="trythis" value="one"> 
  <input type="hidden" name="txtEditDate" value="<?php echo($Date04)?>"/>
  <input type="hidden" name="txtEditUserId" value="<?php echo($user_id)?>"/>           
  <input type="submit" name="updateemployee" value="Update Employee" class="submitButton" formnovalidate>  
<!--  <input type="submit" name="selectallemployees" value="See all Employees">  -->

    </form  >
  </div>  

<script>
  //window.onload = alert("hello");
  //populateJobTitles();
</script>

<?php 
  break;
 
  case 6: //update and see employees
            
// echo "case 6". "<br />";
            
// $dbconn = new mysqli(SANDBOX_DB_HOST, SANDBOX_DB_USER, SANDBOX_DB_PWD, SANDBOX_DB_DBNAME001);

  $dbconn = new mysqli
   (
     $dbc['silicore_hostname'],
     $dbc['silicore_username'],
     $dbc['silicore_pwd'],
     $dbc['silicore_dbname']
   );

  $Id=$_POST['txtId'];

//  $data08 = "SELECT * FROM main_hr_checklist WHERE id=".'"'.$Id.'"';
  $data08 = "call sp_hr_EmpSelectByID('$Id')";
  $result08 = mysqli_query($dbconn, $data08);
  $row08 = mysqli_fetch_assoc($result08);

  mysqli_close($dbconn);
  
  
  
$dbconn = new mysqli
(
  $dbc['silicore_hostname'],
  $dbc['silicore_username'],
  $dbc['silicore_pwd'],
  $dbc['silicore_dbname']
);

$data056 = "call sp_hr_EmpGetAll()";  
// xxx$data031 = "  xxxx";
$result056 = mysqli_query($dbconn, $data056);

mysqli_close($dbconn);
  
$nameSilicoreAccountModel=$_POST['txtSilicoreAccountModel']; 
 
while($row056 = mysqli_fetch_assoc($result056))
{
  if($nameSilicoreAccountModel==$row056['id'] )
  {
    $SilicoreAccountModelName=$row056['empname'];
  }

} 



$dbconn = new mysqli
(
  $dbc['silicore_hostname'],
  $dbc['silicore_username'],
  $dbc['silicore_pwd'],
  $dbc['silicore_dbname']
);

$data057 = "call sp_hr_EmpGetAll()";  
// xxx$data031 = "  xxxx";
$result057 = mysqli_query($dbconn, $data057);

mysqli_close($dbconn);

$nameEmailAccountModel=$_POST['txtEmailAccountModel']; 
 
while($row057 = mysqli_fetch_assoc($result057))
{
  if($nameEmailAccountModel==$row057['id'] )
  {
    $EmailAccountModelName=$row057['empname'];
  }

}
  
    
            
//  $dbconn = new mysqli(SANDBOX_DB_HOST, SANDBOX_DB_USER, SANDBOX_DB_PWD, SANDBOX_DB_DBNAME001);

  $dbconn = new mysqli
   (
     $dbc['silicore_hostname'],
     $dbc['silicore_username'],
     $dbc['silicore_pwd'],
     $dbc['silicore_dbname']
   );
           
/*                
  $SilicoreAccountRequested="0";
  $SilicoreAccountModel="0";
  $EmailAccountRequested="0";
  $CellPhoneRequested="0";        
  $LaptopRequested="0";        
  $DesktopRequested="0";
  $MonitorsRequested="0";
  $TabletRequested="0";
  $TwoWayRadioRequested="0";
  $SpecialSoftwareRequested="0";
*/      
  
  $Id=$_POST['txtId'];
  $LastName = $_POST['txtLastName'];
  $FirstName = $_POST['txtFirstName'];
  $EmployeeId = $_POST['txtEmployeeId'];
  $DepartmentId = $_POST['slcDepartmentId'];
  $JobTitleId = $_POST['slcJobTitleId'];
  $Manager = $_POST['slcManager'];
  $SiteId = $_POST['slcSiteId'];

  $SilicoreAccountRequested = $_POST['chkSilicoreAccountRequested'];
  $SilicoreAccountModel = $_POST['txtSilicoreAccountModel'];
  $EmailAccountRequested = $_POST['chkEmailAccountRequested'];
  $EmailAccountModel = $_POST['txtEmailAccountModel'];
  $CellPhoneRequested = $_POST['chkCellPhoneRequested'];
  $CellPhoneDetail = $_POST['txtCellPhoneRequested'];
  $LaptopRequested = $_POST['chkLaptopRequested'];
  $LaptopDetail = $_POST['txtLaptopRequested'];
  $DesktopRequested = $_POST['chkDesktopRequested'];
  $DesktopDetail = $_POST['txtDesktopRequested'];
  $MonitorsRequested = $_POST['txtMonitorsRequested'];
  $TabletRequested = $_POST['chkTabletRequested'];
  $TabletDetail = $_POST['txtTabletRequested'];
  $TwoWayRadioRequested = $_POST['chkTwoWayRadioRequested'];
  $TwoWayRadioDetail = $_POST['txtTwoWayRadioRequested'];
  $SpecialSoftwareRequested = $_POST['txtSpecialSoftwareRequested'];
  $Comments = $_POST['txaComments'];
  $ApprovedUserId = $_SESSION['user_id'];  
  $CreateUserId = $_SESSION['user_id'];          
  $EditUserID = $_SESSION['user_id'];
 
  if (isset($_POST['txtSeparationDate']) && $_POST['txtSeparationDate'] != ''  )
  {
     $SeparationDate = "'".filter_input(INPUT_POST, 'txtSeparationDate')."'";
  }
  else
  {
    $SeparationDate= "null";
  }
  
  if (isset($_POST['txtStartDate']) && $_POST['txtStartDate'] != ''  )
  {
    $StartDate = "'".filter_input(INPUT_POST, 'txtStartDate')."'";
  }
  else
  {
    $StartDate= "null";
  }
 

  if(isset($_POST['chkIsActive']) && $_POST['chkIsActive'] != '')
    {
      $IsActive = 1;
    }
  else
    {
      $IsActive = 0;
    }
    
  if(isset($_POST['chkIsApproved']) && $_POST['chkIsApproved'] != '')
    {
      $IsApproved = 1;
    }
  else
    {
      $IsApproved = 0;
    }

  // this section will disable changes to the database for a check to uncheck.
           
  if ($SilicoreAccountRequested == "0" && $row08['silicore_account_requested'] == "1")                          
  {                          
    $SilicoreAccountRequested = "1";
  }

  if ($EmailAccountRequested == "0" && $row08['email_account_requested'] == "1")                          
  {                         
    $EmailAccountRequested = "1";
  }

  if ($CellPhoneRequested == "0" && $row08['cell_phone_requested'] == "1")                          
  {
    $CellPhoneRequested = "1";
  }

  if ($LaptopRequested == "0" && $row08['laptop_requested'] =="1")                          
  {                          
    $LaptopRequested = "1";
  }

  if ($DesktopRequested == "0" && $row08['desktop_requested'] == "1")                          
  {                          
    $DesktopRequested = "1";
  }

  if ($TabletRequested == "0" && $row08['tablet_requested'] == "1")                          
  {                          
    $TabletRequested = "1";
  }

  if ($TwoWayRadioRequested == "0" && $row08['two_way_radio_requested'] == "1")                          
  {                          
    $TwoWayRadioRequested = "1";
  }
           
 /* 
  if (!empty($row05[create_date]))                          
  {                          
    $CreateDate = $row05[create_date];
  }

  if (!empty($row05[create_user_id]))                          
  {                          
    $CreateUserId = $row05[create_user_id];
  }  
  * 
  */
           
 // echo ("<br />" . "$TwoWayRadioRequested". "$row05[two_way_radio_requested]"." <br /> cha cha cha <br />");
   
  
  
   
       
       
  $data09 = "call sp_hr_EmpUpdate
          ( '$Id',
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
            '$SilicoreAccountModel',
            '$EmailAccountRequested',
            '$EmailAccountModel',
            '$CellPhoneRequested',
            '$LaptopRequested',
            '$DesktopRequested',
            '$MonitorsRequested',
            '$TabletRequested',
            '$TwoWayRadioRequested',
            '$SpecialSoftwareRequested',
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

try
  {
    $result09 = mysqli_query($dbconn, $data09);
    //echo $data09;
    if ($result09 == 0)
    {
      echo("Error description: " . mysqli_error($dbconn));
      throw new Exception("Error! There was an issue when attempting to update this employee through sp_hr_EmpUpdate.");
    }

   else
    {
      
      //success!
  
  
  





  
//  email development (development@vistasand.com) or support (help@vistasand.com)

  
  if ($IsApproved==1)
  {  
    
    
  if (($SilicoreAccountRequested == "1" && $row08['silicore_account_requested'] == "0") ||
          ($row08['silicore_account_requested'] == "1" && $row08['is_approved'] == "0"))
  {
     $address=$addressDev;
     $subject ="Silicore Account  Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
     $body = ($FirstName ." ". $LastName ." ". "needs a Silicore account." ."  ". "Model is after" ." ". $SilicoreAccountModelName .".");
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }
//echo $SilicoreAccountModel;
  /*           if ($SilicoreAccountRequested == "1" && $row08['silicore_account_requested'] == "1" && !empty($SilicoreAccountModel) && empty($row08['silicore_account_model'])) 
  {
     $address=$addressDev;
     $subject = "Silicore Account Model Adjustment";
     $body = ("The Silicore account for ". $FirstName ." ". $LastName ." ". "should be modeled after" ." ". $SilicoreAccountModel .".");
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }
  */           
  if (($SilicoreAccountModel !== $row08['silicore_account_model']) && !empty($row08['silicore_account_model'])) 
  {
     $address=$addressDev;
     $subject ="Silicore Account Model Adjustment - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
     $body = ("The Silicore account for ". $FirstName ." ". $LastName ." ". "should be modeled after" ." ". $SilicoreAccountModelName .".");
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }

  if (($EmailAccountRequested == "1" && $row08['email_account_requested'] == "0")
    || ($row08['email_account_requested'] =="1" && $row08['is_approved'] == "0"))
    
  {
     $address=$addressHelp;
     $subject = $SiteBuildType . "Email Account  Needed - " . $FirstName . " " . $LastName .":  ". "Model is after" ." ". $EmailAccountModelName ."."." " . $SiteBuildType;
     $body = ($FirstName ." ". $LastName ." ". "needs an email account.");
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0);    
  }

  /*           if ($EmailAccountRequested == "0" && $row01[email_account_requested] == "1")
  {
     $address="ktaylor@vistasand.com";
     $subject ="Email Account Removed";
     $body = ($FirstName ." ". $LastName ." ". "needs his email removed.");
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0);   
  }
  */                      
  if (($CellPhoneRequested === "1" && $row08['cell_phone_requested'] === "0")
    || ($row08['cell_phone_requested'] =="1" && $row08['is_approved'] == "0"))
  {
    $address=$addressHelp;
    $subject ="Cell Phone  Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
    $body = ($FirstName ." ". $LastName ." ". "needs a cell phone. <br>Details: " . $CellPhoneDetail);
    SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }

  if (($LaptopRequested === "1" && $row08['laptop_requested'] ==="0")
    || ($row08['laptop_requested'] =="1" && $row08['is_approved'] == "0"))
  {
     $address=$addressHelp;
     $subject ="Laptop  Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
     $body = ($FirstName ." ". $LastName ." ". "needs a laptop.<br>Details: " . $LaptopDetail);
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }

  if (($DesktopRequested === "1" && $row08['desktop_requested'] === "0")
    || ($row08['desktop_requested'] =="1" && $row08['is_approved'] == "0"))
  {
     $address=$addressHelp;
     $subject ="Desktop Computer  Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
     $body = ($FirstName ." ". $LastName ." ". "needs a desktop computer with" ." ". $MonitorsRequested ." "."monitors. <br>Details: ". $DesktopDetail);
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }

  if (($MonitorsRequested !== $row08['monitors_requested'] && $row08['desktop_requested'] === "1")
    || ($row08['monitors_requested'] =="1" && $row08['is_approved'] == "0"))
  {
     $address=$addressHelp;
     $subject ="Monitor Request Adjustment - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
     $body = ($FirstName ." ". $LastName ." ". "needs" . " ". $MonitorsRequested ." "."monitors.");
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }

  if (($TabletRequested === "1" && $row08['tablet_requested'] === "0")
    || ($row08['tablet_requested'] =="1" && $row08['is_approved'] == "0"))
  {
     $address=$addressHelp;
     $subject ="Tablet  Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
     $body = ($FirstName ." ". $LastName ." ". "needs a tablet. <br>Details: " . $TabletDetail);
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }

  if (($TwoWayRadioRequested === "1" && $row08['two_way_radio_requested'] === "0")
    || ($row08['two_way_radio_requested'] =="1" && $row08['is_approved'] == "0"))
  {
     $address=$addressHelp;
     $subject ="Two-Way Radio Needed - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
     $body = ($FirstName ." ". $LastName ." ". "needs a two-way radio.<br> Details: " . $TwoWayRadioDetail);
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }

  if ((!empty($SpecialSoftwareRequested) && empty($row08['special_software_requested']))
    || (!empty($row08['special_software_requested']) && $row08['is_approved'] == "0"))
  {
     $address=$addressHelp;
     $subject ="Special Software Requested - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
     $body = ($FirstName ." ". $LastName ." ". "needs" . " ". $SpecialSoftwareRequested .".");
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }

  if (($SpecialSoftwareRequested !== $row08['special_software_requested']) && !empty($row08['special_software_requested']))
  {
     $address=$addressHelp;
     $subject ="Special Software Request Adjustment - " . $FirstName . " " . $LastName . " " . $SiteBuildType;
     $body = ($FirstName ." ". $LastName ." ". "needs" . " ". $SpecialSoftwareRequested .".");
     SendPHPMail($address, $subject, $body,("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }
  }
  
  
   
     }

  }
    

                    
     
    catch (Exception $e)
    { 
      echo 'Caught exception: ',  $e->getMessage(), "\n";
      //$_SESSION['sample_error'] = "Error retrieving data" . $e;
  
    }

 mysqli_close($dbconn);

           
/*   echo "<br />" . $MonitorsRequested . "<br />" . $row01[monitors_requested] . "<br />" ;
              
  if (!empty($_POST['txtMonitorsRequested']) && empty($row01[monitors_requested]))
  {
     $body= "needs" .' '. $MonitorsRequested .' '."monitors";
     SendPHPMail("ktaylor@vistasand.com", "Monitors Needed", ($FirstName .' '. $LastName .' '. $body),("/$PageDept/$PageName"),$sendPHPMailDebugFlag,0); 
  }
*/    
             
//   echo("<br />" . "continue"."<br />" ); 
            
            
 /*  $data02 = "UPDATE main_hr_checklist
                      
      SET first_name='$FirstName',
          last_name='$LastName',
          employee_id='$EmployeeId',
          department_id='$DepartmentId',
          manager='$Manager',
          silicore_account_requested='$SilicoreAccountRequested',
          silicore_account_model='$SilicoreAccountModel',
          email_account_requested='$EmailAccountRequested', 
          cell_phone_requested='$CellPhoneRequested',
          laptop_requested='$LaptopRequested',
          desktop_requested='$DesktopRequested',
          monitors_requested='$MonitorsRequested',
          tablet_requested='$TabletRequested',
          two_way_radio_requested='$TwoWayRadioRequested',
          special_software_requested='$SpecialSoftwareRequested'
                              
          WHERE id=".'"'.$Id.'"';
   
*/        

// Include our custom connection
// $dbconn = new mysqli(SANDBOX_DB_HOST, SANDBOX_DB_USER, SANDBOX_DB_PWD, SANDBOX_DB_DBNAME001);

  $dbconn = new mysqli
   (
     $dbc['silicore_hostname'],
     $dbc['silicore_username'],
     $dbc['silicore_pwd'],
     $dbc['silicore_dbname']
   );
 
// get the records from the database

  $data10 = "call sp_hr_EmpSelect";

/*   $data10 = "SELECT main_hr_checklist.*, main_departments.name
                FROM main_hr_checklist
                LEFT JOIN main_departments 
                ON main_hr_checklist.department_id = main_departments.id
                ORDER BY main_hr_checklist.id"; 
*/
  $result10 = mysqli_query($dbconn, $data10);
  mysqli_close($dbconn);



?>          
  <h2>Employee List</h2>
  <div class="datagrid">   
  <form action="hrchecklist.php" method="post">
  <input type="submit" name="addemployee" value="Add new Employee" class="submitButton">
  <br /><br />
 <!-- <table>
             
      <tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Employee ID</th><th>Department</th><th>Manager</th><th></th></tr>
 --> 
            
  <table id="myTable" class="tablesorter">
    <thead style="text-decoration: underline">
    <tr>
    <!--    <th>ID</th>  -->
      <th>Last Name</th>
      <th>First Name</th>
      <th><?php echo $HRProgram?>  ID</th>
      <th>Department</th>
      <th>Manager</th>
      <th>Site</th>
      <th>Start Date</th>
      <th>Is Active</th>
      <th>Action</th>
    </tr>
    </thead>
 
<?php

     $UserDepartment = $singleUserObject->vars['main_department_id']  ;
     $UserType = $singleUserObject->vars['user_type_id'] ;
     
//  display records in a table
    while ($row10 = mysqli_fetch_assoc($result10))
    {
      
        if(($UserDepartment == $row10['department_id'] && $UserType >= 3 )||
                ($UserDepartment == 9 )|| ($UserType == 5 && $UserDepartment == 2))
                
    {

?>
   <tr>
              
<!--   <td style="padding:0px;text-align:center;">
       <form method="post" action="hrchecklist.php" class="inline">
         <input type="hidden" name="id" value="<?php // echo($row10['id']) ?>">
         <button type="submit" name="editemployee" value="<?php // echo($row10['id']) ?>" class="hrlink-button">
         <?php // echo("$row10[id]") ?>
         </button>
       </form>       
       </td>
-->
              
      <td style="padding:0px;text-align:center;"><?php echo($row10['last_name']) ?></td>
      <td style="padding:0px;text-align:center;"><?php echo($row10['first_name']) ?> </td>
      <td style="padding:0px;text-align:center;"><?php echo($row10['employee_id']) ?> </td>
      <td style="padding:0px;text-align:center;"><?php echo($row10['name']) ?> </td>
      
      
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
// xxx$data031 = "  xxxx";
$result101 = mysqli_query($dbconn, $data101);

mysqli_close($dbconn);
  
$NameManagerId=$row10['manager_user_id']; 
 

$ManagerName = '';


while($row101 = mysqli_fetch_assoc($result101))
{
  if($NameManagerId==$row101['id'] )
  {
    $ManagerName=$row101['mgrname'];
  }

} 

  ?>
      <td style="padding:0px;text-align:center;"><?php echo($ManagerName) ?> </td>
      <td style="padding:0px;text-align:center;"><?php echo($row10['description']) ?> </td>
      <td style="padding:0px;text-align:center;"><?php echo($row10['start_date']) ?> </td>
      <td style="padding:0px;text-align:center;">
<?php       
      if($row10['is_active']=="1")
      {
        echo("Yes");
      }
      if($row10['is_active']=="0")
      {
        echo("No");
      }
?>
      </td>
      
      <td style="padding:0px;text-align:center;">
        
<?php        
        if($row10['is_approved']=="0")
        
       {
?>    
      <form method="post" action="hrchecklist.php" class="inline">
        <input type="hidden" name="id" value="<?php echo($row10['id']) ?>">
        <button type="submit" name="editemployee" value="<?php echo($row10['id']) ?>" class="hrlink-button">
         Edit
        </button>
      </form> 

<?php 
        }
        else 
        {
        echo "<a href='hrchecklist.php'>None</a>";
        }
?>          
      </td>

    </tr>  
             
<?php 
    }
    }
?>
    </table>            
    <br />
    <input type="submit" name="addemployee" value="Add new Employee" class="submitButton">
    </form>
  </div>
<?php          
  
  break;
        
  default:
// code to be executed if n is different from all labels;

// echo "case 6b"."<br />";
              
?>
  <br /><br />
<?php 
   print "One of two things happened, either click an employee to edit or put in the information to add employee.";
?>             
  <br /><br />      
  <form>
    <input type="submit"  name="selectallemployees" value="Go back to all Employees" class="submitButton" formnovalidate>
  </form>
<?php  
                
  // close database connection
//     mysqli_close($dbconn);                
         
}

//====================================================================== END PHP

?>
     


