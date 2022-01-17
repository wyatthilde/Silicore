<?php
/* * *****************************************************************************************************************************************
 * File Name: silicoreuseredit.php
 * Project: silicore_site
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 08/31/2017|nolliff|KACE:18394 - Initial creation
 * 09/15/2017|nolliff|KACE:18575 - Added permission options for all QC sites
 * 05/29/2018|zthale|KACE:20553 - File will now pre-populate Manager ID box with previous data, and populate with new data the Manager ID on Main Department select box change.
 * 05/29/2018|zthale|KACE:20553 - Added "unknown" to Manager ID select box, which inputs 0 to database.
 * 07/16/2018|whildebrandt|KACE:24212 - Changed datepicker to datetimepicker. This prevents JQuery from failing as we have changed the name.
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once ('../../Includes/Security/dbaccess.php');


if(!isset($_POST['edit_id']) && !isset($_POST['edit_id']))
  {
    echo ("<script type=\"text/javascript\">window.location = \"../../Controls/Development/silicoreusers.php\";</script>");
  }

$userEditID = filter_input(INPUT_POST, 'edit_id');
$dbconn = dbmysql();//returns connection string
$query = 'CALL sp_adm_UserGet(' . $userEditID . ')';
$result = $dbconn->query($query);

$deptQuery = 'CALL sp_adm_DepartmentsGetAll';
$departments = $dbconn->query($deptQuery);

$dbconn = dbmysql();
$permQuery = "CALL sp_adm_UserPermissionsGet(".$userEditID.")";
$permissions = $dbconn->query($permQuery);
  
$dbconn = dbmysql();
$permQuery = "CALL sp_adm_LocationsQCGet()";
$qcLocations = $dbconn->query($permQuery);

//Get all permissions 
while($permission = $permissions->fetch_assoc())
  {
    $permissionDepartments[] = $permission['permission'];
    $permissionLevels[] = $permission['permission_level'];
    $permissionSites[] = $permission['site'];

  }
   
//get all QC locations
while($location = $qcLocations->fetch_assoc())
{
  $locations[] = $location['description'];
}
//php functions

//returns connection string
function dbmysql()
{
  try
    {
    $dbc = databaseConnectionInfo();
    $dbconn = new mysqli
    (
      $dbc['silicore_hostname'],
      $dbc['silicore_username'],
      $dbc['silicore_pwd'],
      $dbc['silicore_dbname']
    );
    return $dbconn;
    
    mysqli_close($dbconn);
    }
  catch (Exception $e)
  {
    $_SESSION['sample_error'] = "Error while trying to get data" . $e;   
  }
}

//returns html select box with all active departments
function departmentSelect($id)
{
  $dbconn = dbmysql();
  $deptQuery = 'CALL sp_adm_DepartmentsGetAll';
  $departments = $dbconn->query($deptQuery);
  $allDepartments = "";
  while($department = $departments->fetch_assoc())
    {
      if($id == $department['id'])
        {
         $departmentString = "<option selected='selected' value='" . $department['id'] . "'>" . $department['name'] . "</option>";
        }
      else
        {
         $departmentString = "<option value='" . $department['id'] . "'>" . $department['name'] . "</option>";
        }
      $allDepartments = $allDepartments . " " . $departmentString;    

    }  
    return $allDepartments;
}

//returns html label, checkbox, and select box for each active department 
function departmentChecks($id,$locations)
{
  $dbconn = dbmysql();
  $deptQuery = 'CALL sp_adm_DepartmentsGetAll';
  $departments = $dbconn->query($deptQuery);
  
  $dbconn = dbmysql();
  $permQuery = "CALL sp_adm_UserPermissionsGet(".$id.")";
  $permissions = $dbconn->query($permQuery);

  $count = 0;
  $allDepartmentChecks = "";
  $permDept ="";

    while($permission = $permissions->fetch_assoc())
    {
      $permDept[]=$permission['permission'];
    }
    
  while($department = $departments->fetch_assoc())
    {
      if($department['name'] == 'QC')
      { 
        while($count<count($locations))
          { 
            $departmentLabel = "<label>" . $department['name'] . " - " . $locations[$count] . ":</label>";
            $departmentCheck = "<input type=checkbox "
                              . "id= '" . strtolower($department['name']) . "_" . trimLower($locations[$count]) . "_checkbox' "
                              . "name='" . strtolower($department['name']). "_" . trimLower($locations[$count]) . "_checkbox' "
                              . "value='" . $department['id'] . "'>";       
            $permissionLevel = permissionSelect($department['name'],$permDept, $locations[$count]) . "<br><br>";
            $allDepartmentChecks = $allDepartmentChecks . " " . $departmentLabel . " " . $departmentCheck . " ". $permissionLevel; 
            $count++;
          }    
      }
      else
      {
        $departmentLabel = "<label>" . $department['name'] . ":</label>";
        $departmentCheck = "<input type=checkbox id= '" . strtolower($department['name']) . "_checkbox' "
                            . "name='" . strtolower($department['name']) . "_checkbox' value='" . $department['id'] . "'>";       
        $permissionLevel = permissionSelect($department['name'],$permDept) . "<br><br>";
        $allDepartmentChecks = $allDepartmentChecks . " " . $departmentLabel . " " . $departmentCheck . " ". $permissionLevel;    
      }
    } 
    
    return $allDepartmentChecks;
}

//returns select boxes for departmentChecks function
function permissionSelect($department,$deptArr,$location = null)
{
  $dbconn = dbmysql();
  $userTypeQuery = 'CALL sp_adm_UserTypesGet';
  $types = $dbconn->query($userTypeQuery);
  while($type = $types->fetch_assoc())
  {
    $permVal[]=$type['value'];
    $permName[]=$type['name'];
  }
  $options= "";
  $count=0;
  while($count < count($permVal))
  {
    $option = "<option value='" . $permVal[$count] . "'>" . $permVal[$count] . " " . $permName[$count] . "</option>";    
    $options = $options . ' ' . $option;
    $count++;
  }
  if($department == "QC")
    {
      $selectBox = "<select style='margin-left:0px' id='" . strtolower($department). "_" . trimLower($location). "_select'"
                  . " name ='" . strtolower($department) . "_" . trimLower($location) . "_select'><option>Select...</option>" 
                  . $options ."</select>";
    }
 else
    {
      $selectBox = "<select style='margin-left:0px' id='" . strtolower($department) . "_select'"
                  . " name ='" . strtolower($department) . "_select'><option>Select...</option>" . $options ."</select>";
    }
    return $selectBox;
}

function userTypeSelect($userType)
  {
    $dbconn = dbmysql();
    $userTypeQuery = 'CALL sp_adm_UserTypesGet';
    $types = $dbconn->query($userTypeQuery);    
    $options="";
    while($type = $types->fetch_assoc())
      {
        if($userType==$type['id'])
          {
            $option = "<option selected value='" . $type['value'] . "'>" . $type['value'] . " " . $type['name'] . "</option> ";
          }
        else
          {
            $option = "<option value='" . $type['value'] . "'>" . $type['value'] . " " . $type['name'] . "</option>";
          }
          
        $options = $options . ' ' . $option;
      }
    $userTypeSelectBox = "<select style='margin-bottom:5px' id='user_type_id' name ='user_type_id'>"
                          . "<option>Select...</option>" . $options ."</select>";
    return $userTypeSelectBox;
  }
function trimLower($location)
  {
    $trimmed = str_replace(' ', '_', $location);
    $lowered = strtolower($trimmed);
    return $lowered;
  }
  
function getManagerIdByDepartment($department, $managerId = 0)
{  
  	$main_department = $department;
    
	$dbconn = dbmysql();
    $query = "CALL sp_dev_UserByDeptGet('$main_department')";
    
    $managers = mysqli_query($dbconn, $query) or die("Error in Selecting " . mysqli_error($dbconn));
    
     $options= "";
     
	while($row = mysqli_fetch_assoc($managers))
	{
        if($managerId == $row['id'])
          {
            $option = '<option selected=\'selected\' value="' .$row['id'] .'">' .$row['id'] . ' - ' .$row['first_name'] . ' ' . $row['last_name'].'</option>';
          }
          else
          {
            $option = '<option value="' .$row['id'] .'">' .$row['id'] . ' - ' .$row['first_name'] . ' ' . $row['last_name'].'</option>';
        }
   
        $options = $options . ' ' . $option;
	}
  
        $managerIdSelectBox =  "<select name='manager_id' id='manager_id'>"
                   .  "<option value='0'>Select...</option><option value='0'>Unknown</option>" . $options . "</select>";
  
    return $managerIdSelectBox;
}
  
//========================================================================================= END PHP
?>
<script defer>
  //checks boxes and selects correct value for   
  function setSelection()
  {

    var deptArr = <?php echo json_encode($permissionDepartments); ?>;
    var levelArr = <?php echo json_encode($permissionLevels); ?>;
    var sites = <?php echo json_encode($permissionSites); ?>;
    var count = deptArr.length;
    
    for(i = 0; i <count; i++)
    {
      if(deptArr[i] === "qc")
        { 

              //document.write("<div>" + sites[i] + " " + deptArr[i] + " " + levelArr[i] + "</div>");
              var selectBox = deptArr[i] + "_" + sites[i] + "_select";
              var checkBox = deptArr[i] + "_" + sites[i] +"_checkbox";
              
              var checkBoxElement = document.getElementById(checkBox);
              var selectElement = document.getElementById(selectBox);

              
              if(typeof(checkBoxElement) != 'undefined' && checkBoxElement != null)
              {
                checkBoxElement.checked = true;

                if(typeof(selectElement) != 'undefined' && selectElement != null)
                {
                  selectElement.value = levelArr[i];
                }         
              }
            
        }
      else
        { 
          var selectBox = deptArr[i] + "_select";
          var checkBox = deptArr[i] + "_checkbox";

          var checkBoxElement = document.getElementById(checkBox);
          var selectElement = document.getElementById(selectBox);


          if(typeof(checkBoxElement) != 'undefined' && checkBoxElement != null)
          {
            checkBoxElement.checked = true;

            if(typeof(selectElement) != 'undefined' && selectElement != null)
            {
              selectElement.value = levelArr[i];
            }
            }
         }
    }
    
  }
</script>

<script>
			$(document).ready(function() {
				$("#main_department_id").change(function() {
					$.get('../../Config/Development/getManagerIdByDepartment.php?main_department_id=' + $(this).val(), function(data) {
						$("#manager_id").html(data);
					}); 
				});
			});
</script>

<style>
/********************************************************************************** BEGIN Float Input Styles */

.float-inputs label 
{
  position: absolute;
  width: 150px;

}
.float-inputs input, select 
{
  width:50%;
  margin:0;
  margin-left: 160px;
  margin-bottom: 15px;
  border-radius: 3px;
  padding: 12px 18px;
  border: 1px solid #ccc;
}
.float-inputs input[type=checkbox]
{
  margin-top: 5px;
  width:5%
}
  .float-inputs.check-select 
{
    margin-left: 0;
}
.float-inputs input[type=text].hasDatepicker
{
  width:50%;
}
.float-inputs.permissions input, select 
{
  margin-bottom: 0px;
}
/********************************************************************************** END Float Input Styles */
</style>
<!-- HTML -->
<h2>Edit User Information</h2>
<div class='float-inputs'>
  <form action='../../Includes/Development/updatesilicoreuser.php' method='post'>
    <?php 
      while ($row = $result->fetch_assoc())
      {
        $deparmentSelection = departmentSelect($row['main_department_id']);
        $departmentCheckboxes = departmentChecks($userEditID ,$locations);
        $userTypeSelectBox = userTypeSelect($row['user_type_id']);
        $managerIdSelectBox = getManagerIdByDepartment($row['main_department_id'], $row['manager_id']);

        echo("
                <table>
                  <tr>
                    <td style='vertical-align:top;width:50%' >
                    <label>First Name: </label>
                    <input type='text' name='first_name' value='{$row['first_name']}'><br>

                    <label>Last Name: </label>
                    <input type='text' name='last_name' value='{$row['last_name']}'><br>

                    <label>Display Name: </label>
                    <input type='text' name='display_name' value='{$row['display_name']}'><br>

                    <label>Email: </label>
                    <input type='text' name='email' value='{$row['email']}'><br>

                    <label>Company: </label>
                    <input type='text' name='company' value='{$row['company']}'><br>

                    <label>Main Department: </label>
                      <select name='main_department_id' id='main_department_id' style='margin-bottom: 15px'>
                      {$deparmentSelection}
                      </select>
                    <br>
                    <label>Start Date: </label>
                    <input type='text' id='start_date' name='start_date' value='{$row['start_date']}' ><br>

                    <label>Separation Date: </label>
                    <input type='text' id='separation_date' name='separation_date' value='{$row['separation_date']}'><br>

                    <label>Is Active: </label>
                    <input type='checkbox' name='is_active' value='{$row['is_active']}' "
                    . ($row['is_active'] == 1 ? 'checked=\'checked\'':'') . "><br>

                    <label>Is Labtech: </label>
                    <input type='checkbox' name='qc_labtech' value='{$row['qc_labtech']}' "
                    . ($row['qc_labtech'] == 1 ? 'checked=\'checked\'':'') . "><br>

                    <label>Is Sampler: </label>
                    <input type='checkbox' name='qc_sampler' value='{$row['qc_sampler']}' "
                    . ($row['qc_sampler'] == 1 ? 'checked=\'checked\'':'') . "><br>

                    <label>Is Operator: </label>
                    <input type='checkbox' name='qc_operator' value='{$row['qc_operator']}' "
                    . ($row['qc_operator'] == 1 ? 'checked=\'checked\'':'') . "><br>

                    <label>User Type: </label>
                    {$userTypeSelectBox}<br>   

                    <label>Manager ID: </label>
                    {$managerIdSelectBox}<br>
           
                    <input type='hidden' name='active_in_db' value='{$row['is_active']}'>
                    <input type='hidden' name='edit_id' value='{$userEditID}'>
                  <input type='submit' Value='Submit'>
                  </td>
                  <td style='vertical-align:top;width:100%' class='permissions'>
                    <div style='cursor:pointer;padding-bottom:10px' id='permission-heading'>
                      <h3>
                      Permissions
                      <div style='display:none' id='arrow-up'>&#9650;</div>
                      <div style='display:inline-block' id='arrow-down'>&#9660;</div> 
                      </h3>
                    </div>
                    <div id='checkBoxes' style='display:block'>
                      {$departmentCheckboxes}
                    </div>
                  </td>
                  </tr>
                  </table>
                  ");
            }
    ?>
    <script>
      $(function() 
        {
         $('#start_date').datetimepicker({ dateFormat: 'yy-mm-dd' });
         $('#separation_date').datetimepicker({ dateFormat: 'yy-mm-dd' });
         setSelection();
        });
        $('#permission-heading').on('click',function(){
            $('#arrow-up').toggleClass('display-inline-block ');
            $('#arrow-down').toggle();
            $(this).next('#checkBoxes').slideToggle();

        });
    </script>

    <style>
      .arrow-up{margin-left:-20px;width:25px;display:inline-block;}
      .arrow-down{margin-left:-20px;width:25px;display:inline-block;}
    </style>
  </form>
</div>