<?php
/* * *****************************************************************************************************************************************
 * File Name: scorecardsettinginsert.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 08/14/2018|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');


  $site=filter_input(INPUT_POST,'site');
  
if($site == 'gb')
  {
    $date = filter_input(INPUT_POST,'start_date');    
    $grossRotarySetting = filter_input(INPUT_POST,'rotary_gross_setting');      
    $netRotarySetting = filter_input(INPUT_POST,'rotary_net_setting');
    $outputRotarySetting = filter_input(INPUT_POST,'rotary_output_setting');
    $gross100TSetting = filter_input(INPUT_POST,'carrier100_gross_setting');      
    $net100TSetting = filter_input(INPUT_POST,'carrier100_net_setting');
    $output100TSetting = filter_input(INPUT_POST,'carrier100_output_setting');
    $gross200TSetting = filter_input(INPUT_POST,'carrier200_gross_setting');      
    $net200TSetting = filter_input(INPUT_POST,'carrier200_net_setting');
    $output200TSetting = filter_input(INPUT_POST,'carrier200_output_setting');
    $userId = $_SESSION['user_id'];   
    
    
    try
    {

      $settingUpdateSQL = "CALL sp_" . $site . "_plc_ScorecardSettingInsert('"
              . $date . "'," 
              . $grossRotarySetting . ","
              . $netRotarySetting . ","
              . $outputRotarySetting . ","
              . $gross100TSetting . ","
              . $net100TSetting . ","
              . $output100TSetting . ","
              . $gross200TSetting . ","
              . $net200TSetting . ","
              . $output200TSetting . ","
              . $userId . ")";

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
    
  }  
  
if($site == 'tl')
  {
  $date = filter_input(INPUT_POST,'start_date');
  $outputSetting = filter_input(INPUT_POST,'output_setting');
  $netSetting = filter_input(INPUT_POST,'net_setting');
  $grossSetting = filter_input(INPUT_POST,'gross_setting');     
  $userId = $_SESSION['user_id'];   
  
  try
    {

      $settingUpdateSQL = "CALL sp_" . $site . "_plc_ScorecardSettingInsert('"
              . $date . "'," 
              . $outputSetting . ","
              . $netSetting . ","
              . $grossSetting . ","
              . $userId . ")";

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
  
}
  
//========================================================================================== END PHP
?>

<!-- HTML -->