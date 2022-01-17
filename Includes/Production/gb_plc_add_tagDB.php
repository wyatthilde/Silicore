<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_plc_add_sample.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/24/2018|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

require_once('../security.php');
require_once ('../Security/dbaccess.php');
require_once ('devAdminFunctions.php');
addTag();

function addTag()
{
  $device = filter_input(INPUT_POST, 'device_description');
  $tag = filter_input(INPUT_POST, 'tag');
  $plc_tag = filter_input(INPUT_POST, 'plc_tag');
  $classification = filter_input(INPUT_POST, 'select_classification');
  $units = filter_input(INPUT_POST, 'select_units');
  $plantId = filter_input(INPUT_POST, 'selectplant');
  $userID = $_SESSION['user_id'];

  try
    {
      $tagInsertSQL = "CALL sp_gb_plc_TagInsert("
              . $device . ""
              . $classification . ""
              . $tag . ""
              . $plc_tag . ""
              . $units . ""
              . $plantId . ")";
      $dbconn = new mysqli(SANDBOX_DB_HOST,SANDBOX_DB_USER,SANDBOX_DB_PWD,SANDBOX_DB_DBNAME001);
      $dbconn->query($tagInsertSQL);
      mysqli_close($dbconn);
    }
  catch (Exception $e)
    {
      $errorMessage = $errorMessage . "Error connecting to the MySQL database";
      sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    }
}
//========================================================================================== END PHP
?>
