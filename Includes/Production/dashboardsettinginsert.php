<?php
/* * *****************************************************************************************************************************************
 * File Name: dashboardsettinginsert.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/17/2018|__USER__|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');

$site=filter_input(INPUT_POST,'site');
$jsonSettings = filter_input(INPUT_POST,'json_string');      
$userId = $_SESSION['user_id'];   


try
    {

      $settingUpdateSQL = "CALL sp_" . $site . "_plc_DashboardSettingInsert(". $user_id . ",'" . $jsonSettings . "')";

      echo ($settingUpdateSQL);
      $dbc = databaseConnectionInfo();
      $dbconn = new mysqli
              (    
                $dbc['silicore_hostname'],
                $dbc['silicore_username'],
                $dbc['silicore_pwd'],
                $dbc['silicore_dbname']
              );
      $dbconn->query($settingUpdateSQL);
      mysqli_close($dbconn);
    }
  catch (Exception $e)
    {
      $errorMessage = $errorMessage . "Error connecting to the MySQL database";
      sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
      exit("Stopping PHP execution");
    }


//========================================================================================== END PHP
?>

<!-- HTML -->