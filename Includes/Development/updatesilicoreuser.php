<?php
/* * *****************************************************************************************************************************************
 * File Name: updatesilicoreuser.php
 * Project: silicore_site
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/01/2017|nolliff|KACE:18394 - Initial creation
 * 09/15/2017|nolliff|KACE:18575 - Added updatedDeptPermission function
 * 11/06/2017|nolliff|KACE:18550 - Added functionality to send email upon activatiion and reactivation of account
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
//require_once('../security.php');
require_once ('../Security/dbaccess.php');
require_once ('devAdminFunctions.php');
updateSilicoreUser();
updateDeptPermission();

header('Location: ../../Controls/Development/silicoreusers.php');



function updateSilicoreUser()
{
  $id = filter_input(INPUT_POST, 'edit_id');
  $first_name = filter_input(INPUT_POST, 'first_name');
  $last_name = filter_input(INPUT_POST, 'last_name');
  $display_name = filter_input(INPUT_POST, 'display_name');
  $email = filter_input(INPUT_POST, 'email');
  $company = filter_input(INPUT_POST, 'company');
  $main_department_id = filter_input(INPUT_POST, 'main_department_id');
  $start_date = filter_input(INPUT_POST, 'start_date');
  $user_id = $_SESSION['user_id'];
  $active_in_db = filter_input(INPUT_POST, 'active_in_db');
  $department_name = departmentSwitch($main_department_id);
  $manager_id = filter_input(INPUT_POST, 'manager_id');
  
  echo "Main Department ID: " . $main_department_id . "<br>";
  echo "Department Name: " . $department_name . "<br>";
  echo "Manager ID: " . $manager_id . "<br>";
  
  if(isset($_POST['is_active']))
    {
      $is_active = 1;
    }
  else
    {
      $is_active = 0;
    }
  if(isset($_POST['qc_labtech']))
    {
      $qc_labtech = 1;
    }
  else
    {
      $qc_labtech = 0;
    }

  if(isset($_POST['qc_sampler']))
    {
      $qc_sampler = 1;
    }
  else
    {
      $qc_sampler = 0;
    }

  if(isset($_POST['qc_operator']))
    {
      $qc_operator = 1;
    }
  else
    {
      $qc_operator = 0;
    }

  if(isset($_POST['user_type_id']) && $_POST['user_type_id'] != '' )
    {
      $user_type_id = filter_input(INPUT_POST, 'user_type_id');
    }
  else
    {
      $user_type_id = "null";
    }
    echo $user_type_id;
    
  if(isset($_POST['manager_id']) && $_POST['manager_id'] != '')
    {
      $manager_id = filter_input(INPUT_POST, 'manager_id');
    }
  else
    {
      $manager_id = "null";
    }
    
if(isset($_POST['separation_date']) && $_POST['separation_date'] != '' )
    {
      $separation_date = "'".filter_input(INPUT_POST, 'separation_date')."'";
    }
  else
    {
      $separation_date = "null";
    }

  $permission_level = permissionLevelSet($user_type_id);

  $dbconn = dbmysqli();//returns connection string
  
  $query = "CALL sp_adm_UserUpdate(" . 
          $id . ",'" . 
          $first_name . "','" . 
          $last_name . "','" . 
          $display_name . "','" . 
          $email . "','" . 
          $company . "'," . 
          $main_department_id . ",'" .
          $start_date . "'," . 
          $separation_date . "," .
          $is_active . "," .
          $qc_labtech . "," . 
          $qc_sampler . "," .
          $qc_operator . "," .
          $user_type_id . "," .
          $manager_id . "," .
          $user_id . ",'" .
          $department_name . "'," .
          $permission_level.")";
  //echo $query;
  $result = $dbconn->query($query);
  echo $query . "<br>";
  echo $user_type_id . " " . $main_department_id;
  if($user_type_id>=3 && $main_department_id !=9 )
    {
    
      $dbconn = dbmysqli();//returns connection string
      $query = "CALL sp_adm_UserUpdatePermission(" . $id ."," . $user_id . ",'hr',0,'granbury')";
      echo "<br>" . $query;
      $dbconn->query($query);
    }
  
  if($active_in_db == 0 && $is_active == 1)
    {
    sendActivateEmail($email, $first_name, $last_name);
    }
}

function updateDeptPermission()
{
  $dbconn = dbmysqli();//returns connection string
  $deptQuery = 'CALL sp_adm_DepartmentsGetAll';
  $departments = $dbconn->query($deptQuery);
    while($department = $departments->fetch_assoc())
    {
      $deptNames[]= strtolower($department['name']);
    }
  $dbconn = dbmysqli();
  $permQuery = "CALL sp_adm_LocationsQCGet()";
  $qcLocations = $dbconn->query($permQuery);
  

  while($location = $qcLocations->fetch_assoc())
  {
    $locations[] = str_replace(' ', '_' , strtolower($location['description']));
  }
//  echo '"'.implode('","', $locations).'" <br>';
//  echo '"'.implode('","', $deptNames).'" <br>';
  for($i=0; $i < count($deptNames); $i++)
  {
    if($deptNames[$i] == "qc")
      {
        for($c = 0; $c < count($locations); $c++)
          {
            $deptCheckbox = $deptNames[$i]. '_' . $locations[$c] .'_checkbox';

            if(isset($_POST[$deptCheckbox]))
              { 
                $id = filter_input(INPUT_POST, 'edit_id');
                $user_id = $_SESSION['user_id'];
                $permissionDept = $deptNames[$i];
                $deptSelect = $deptNames[$i]. '_' . $locations[$c] . '_select';
                $permissionLevel = permissionSwitch(filter_input(INPUT_POST, $deptSelect));
                $site = $locations[$c];
                
                $dbconn = dbmysqli();//returns connection string
                $query = "CALL sp_adm_UserUpdatePermission("
                        . $id .","
                        . $user_id . ",'"
                        . $permissionDept . "',"
                        . $permissionLevel . ",'"
                        . $site . "')";
              echo "<br>" . $query;
                $dbconn->query($query);
              }
            else
              {
                $id = filter_input(INPUT_POST, 'edit_id');
                $permissionDept = $deptNames[$i];
                $site = $locations[$c];
                $dbconn = dbmysqli();//returns connection string
                $query = "CALL sp_adm_UserPermissionDelete("
                        . $id . ",'"
                        . $permissionDept . "','"
                        . $site . "')";
                echo "<br>" . $query;
                $dbconn->query($query);
              }
        
          }
      }
    else
      {
        $deptCheckbox = $deptNames[$i].'_checkbox';

        if(isset($_POST[$deptCheckbox]))
          { 
            $id = filter_input(INPUT_POST, 'edit_id');
            $user_id = $_SESSION['user_id'];
            $permissionDept = $deptNames[$i];
            $deptSelect = $deptNames[$i]. '_select';
            $permissionLevel = permissionSwitch(filter_input(INPUT_POST, $deptSelect));
            $site = 'granbury';
            $dbconn = dbmysqli();//returns connection string
            $query = "CALL sp_adm_UserUpdatePermission("
                    . $id .","
                    . $user_id . ",'"
                    . $permissionDept . "',"
                    . $permissionLevel . ",'"
                    . $site . "')";
            //echo "<br>" . $query;
            $dbconn->query($query);
          }
        else
          {
            $id = filter_input(INPUT_POST, 'edit_id');
            $permissionDept = $deptNames[$i];
            $site = 'granbury';
            $dbconn = dbmysqli();//returns connection string
            $query = "CALL sp_adm_UserPermissionDelete("
                    . $id . ",'"
                    . $permissionDept . "','"
                    . $site . "')";
             //echo "<br>" . $query;
            $dbconn->query($query);
          }
      }
  }
}

function sendActivateEmail($email,$fname, $lname)
{
  //echo $email;
  $body = $fname . " " . $lname . " your silicore account has been activated.";
  SendPHPMail($email, "Silicore Account Activated", $body,("/Includes/Development/updatesilicoreuser.php"),0,0);
}


function departmentSwitch($deptID)
{
      switch($deptID)
    {
      case 1:
        return "general";
        break;
      case 2:
        return "development";
        break;
      case 3:
        return "production";
        break;
      case 4:
        return "qc";
        break;    
      case 5:
        return "loadout";
        break;
      case 6:
        return "logistics";
        break;      
      case 7:
        return "accounting";
        break;    
      case 8:
        return "safety";
        break;        
      case 9:
        return "hr";
        break;
      case 10:
        return "it";
        break;
      default:
        return $deptID;
        
    }

}

function permissionSwitch($permissionLevel)
{
      switch($permissionLevel)
    {
      case "1 Standard":
        return 1;
        break;
      case "2 Shift Lead":
        return 2;
        break;
      case "3 Manager":
        return 3;
        break;
      case "4 Director":
        return 4;
        break;    
      case "5 Administrator":
        return 5;
        break;
      case "0 Read Only":
        return 0;
        break;
      default:
        return $permissionLevel;
        break;
    }
}

function permissionLevelSet($userType)
{
  if ($userType != "null" && $userType != "" && $userType != 6)
  {
    return $userType;
  }
  else
    {
      return 0;
    }
}
//==============================================================================//============ END PHP
?>

<!-- HTML -->
