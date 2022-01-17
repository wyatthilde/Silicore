<?php
/* * *****************************************************************************************************************************************
 * File Name: hroffboard.php
 * Project: smashbox
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 05/17/2018|ktaylor|KACE:xxxxx - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
//========================================================================================== END PHP
//include other files
require_once('\var\www\configuration\db-mysql-sandbox.php'); //contains database connection info
require_once('../../Includes/emailfunctions.php'); //contains email functionality
require_once('../../Includes/pagevariables.php'); //contains page-level globals

// Get the currently logged in user's information from the global object in /Includes/pagevariables.php
global $singleUserObject;

// <editor-fold defaultstate="collapsed" desc="Set Debugging Options">  
$debugging = 0; //set this to 1 to see debugging output
$currenttime = time();
if ($debugging) 
{
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

function searchNames() 
{
  var input, filter, table, tr, td, i;
  input = document.getElementById("nameSearchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) 
  {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) 
    {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) 
      {
        tr[i].style.display = "";
      } 
      else 
      {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>


<!-- HTML -->


  <h2>Employee List</h2>

  <div class="datagrid">
    <form action="hroffboard.php" method="POST">
     
 
 
<?php

    try
    {    
      $dbconn = new mysqli
      (
        $dbc['silicore_hostname'],
        $dbc['silicore_username'],
        $dbc['silicore_pwd'],
        $dbc['silicore_dbname']
      );             
      $employeesSQL = "call sp_hr_EmpSelect()"; 
    }
    catch (Exception $e)
    {
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

    $result01 = mysqli_query($dbconn, $employeesSQL);
    mysqli_close($dbconn);
    
?> 
      
<input type="text" id="nameSearchInput" onkeyup="searchNames()" placeholder="Search in Last Names..." title="Type in a name">
<br /><br />
    <table id="myTable" class="tablesorter hrEmployeeGridTable" style="width:1200px; border-color: #000000;" cellpadding="0" cellspacing="0" border="1">
      <thead style="text-decoration: underline">
      <tr>
        <th class="headerRowCell">Last Name</th>
        <th class="headerRowCell">First Name</th>
        <th class="headerRowCell"><?php echo $HRProgram?>  ID</th>
        <th class="headerRowCell">Department</th>
        <th class="headerRowCell">Manager</th>
        <th class="headerRowCell">Site</th>
        <th class="headerRowCell">Start Date</th>
        <th class="headerRowCell">Active?</th>
        <th class="headerRowCell">Action</th>
      </tr>
      </thead>
      
<?php
  
$UserDepartment = $singleUserObject->vars['main_department_id']  ;
$UserType = $singleUserObject->vars['user_type_id'] ;
$ManagerName = '';

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
            $UserDepartment == 9 ||$UserDepartment == 10 || $UserType == 5)
    {          
      echo
      ("
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
        </td>
        <td style='padding:0px;text-align:center;'>
      ");

      if($UserType >= 3 || $userPermissionsArray['vista']['granbury']['hr'] >= 1 || $userPermissionsArray['vista']['granbury']['it'] >= 1 )			
      {
        echo
        ("
          <form method='post' action='hrchecklist.php' class='inline'>
            <input type='hidden' name='id' value='{$employee['id']}'>
            <button type='submit' name='editemployee' value='{$employee['id']}' class='hrlink-button'>
            Off Board
            </button>
          </form> 
        ");                                                       
      }
      echo ("</td></tr>");
    }        
} 
?>
    </table>
 
      
    </form>
  </div>
               
<?php