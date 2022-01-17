<?php
/* * *****************************************************************************************************************************************
 * File Name: plc_threshold_update.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/29/2018|nolliff|KACE:xxxxx - Initial creation
 * 07/16/2018|nolliff|KACE:xxxxx - renamed to plc_threshold_update.php
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');

header('Location: ../../Controls/Production/plc_plant_thresholds.php');

if(isset($_POST['threshold_id']) && $_POST['threshold_id'] != '')
  {
    $thresholdId = filter_input(INPUT_POST,'threshold_id');
    $tagId = filter_input(INPUT_POST,'tag_id');
    $userId = $_SESSION['user_id'];
    $threshold = filter_input(INPUT_POST,'threshold_value');
    $gaugeMax = filter_input(INPUT_POST,'gauge_max');    
    $actionLimit = filter_input(INPUT_POST,'action_limit');
    $warningLimit = filter_input(INPUT_POST,'warning_limit');
    $site = filter_input(INPUT_POST,'site');

    if(isset($_POST['alert_on']))
      {
        $alertOn = 1;
      }
    else
      {
       $alertOn = 0;
      }
      
    if(!isset($threshold) || $threshold == '')
      {
        $threshold = 'null';
      }
    if(!isset($gaugeMax) || $gaugeMax == '')
      {
        $gaugeMax = 'null';
      }  
    if(!isset($actionLimit) || $actionLimit == '')
      {
        $actionLimit = 'null';
      }
    if(!isset($warningLimit) || $warningLimit == '')
      {
        $warningLimit = 'null';
      }

    try
      {

        $thresholdUpdateSQL = "CALL sp_" . $site . "_plc_PlantThresholdsUpdate("
                . $thresholdId . "," 
                . $userId . ","
                . $threshold . ","
                . $gaugeMax . ","
                . $actionLimit . ","
                . $warningLimit . ","
                . $alertOn . ")";
        
        echo ($thresholdUpdateSQL);
        $dbc = databaseConnectionInfo();
        $dbconn = new mysqli
                (    
                  $dbc['silicore_hostname'],
                  $dbc['silicore_username'],
                  $dbc['silicore_pwd'],
                  $dbc['silicore_dbname']
                );
        $thresholdRes = $dbconn->query($thresholdUpdateSQL);
        mysqli_close($dbconn);
      }
    catch (Exception $e)
      {
        $errorMessage = $errorMessage . "Error connecting to the MySQL database";
        sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
        exit("Stopping PHP execution");
      }
  }
else
  {
    $tagId = filter_input(INPUT_POST,'tag_id');
    $userId = $_SESSION['user_id'];
    $threshold = filter_input(INPUT_POST,'threshold_value');
    $gaugeMax = filter_input(INPUT_POST,'gauge_max');    
    $actionLimit = filter_input(INPUT_POST,'action_limit');
    $warningLimit = filter_input(INPUT_POST,'warning_limit');
    $site = filter_input(INPUT_POST,'site');

    
    if(isset($_POST['alert_on']))
      {
        $alertOn = 1;
      }
    else
      {
       $alertOn = 0;
      }
        if(!isset($threshold) || $threshold == '')
      {
        $threshold = 'null';
      }
    if(!isset($gaugeMax) || $gaugeMax == '')
      {
        $gaugeMax = 'null';
      }  
    if(!isset($actionLimit) || $actionLimit == '')
      {
        $actionLimit = 'null';
      }
    if(!isset($warningLimit) || $warningLimit == '')
      {
        $warningLimit = 'null';
      }
      
      
    try
      {

        $thresholdInsertSQL = "CALL sp_" . $site . "_plc_PlantThresholdsInsert("
                . $tagId . "," 
                . $userId . ","
                . $threshold . ","
                . $gaugeMax . ","
                . $actionLimit . ","
                . $warningLimit . ","
                . $alertOn . ")";
        echo ($thresholdInsertSQL);

        $dbc = databaseConnectionInfo();
        $dbconn = new mysqli
                (    
                  $dbc['silicore_hostname'],
                  $dbc['silicore_username'],
                  $dbc['silicore_pwd'],
                  $dbc['silicore_dbname']
                );
        $thresholdRes = $dbconn->query($thresholdInsertSQL);
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