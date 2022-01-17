<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_plc_02_RuntimeInsert.php
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/17/2017|nolliff|KACE:16787 - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

require_once('/var/www/sites/silicore/Includes/security.php');
require_once('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once('/var/www/sites/silicore/Includes/emailfunctions.php');
require_once('/var/www/sites/silicore/Includes/Production/productionfunctions.php');



//get max id for runtime table in mysql
try
  {
    $maxIdSQL = "CALL sp_gb_plc_RuntimeMaxIdGet()";
    $maxIdResult = mysqli_query(dbmysqli(),$maxIdSQL);
    while($id= mysqli_fetch_array($maxIdResult))
    {
      $maxID = $id['maxId'];
    }
  }
catch(Exception $ex)
  {
    echo("Error: " .  __LINE__ . " " .$ex);
  }
if($maxID == "" or $maxID == null)
    {
      $maxID = 0;
    }
try
  {
    $mssqlConn = mssqldb();
    
    //date should only be used once
//    $runtimeDate = '2017-10-31';
//    $runtimeSQL = "EXECUTE sp_gb_plc_RuntimesByDateWithIdGet @startDate='" . $runtimeDate . "'";  
    
//    retrieves all new records based on max id from mysql table
    $runtimeSQL = "EXECUTE sp_gb_plc_RuntimesByIdGet @Id=" . $maxID;
    
    echo $runtimeSQL . "<br>";
    $runtimeResults = sqlsrv_query($mssqlConn, $runtimeSQL);
  }
catch(Exception $ex)
  {
    //echo used for debugging, error email will be implemented later
    echo("Error: " .  __LINE__ . " " .$ex);
  }
  
while($report = sqlsrv_fetch_array($runtimeResults)) 
  {
    $id = $report['Id'];                   
    $shiftId = $report['ShiftId'];
    $durationMinutes = $report['Runtime'];
    //due to bug in esp 
    //59000 is just an arbitrarily high number
    if($durationMinutes >= 59000)
      {
        $duration = 999.9;
      }
    else
      {
        $duration = round($durationMinutes / 60, 2);
      }

    $device = $report['RuntimeDescription'];
    $tagId = 'null';
    $tag = $report['Tag'];

    $startDate = $report['StartDate']->format('Y-m-d H:i:s');
    echo "<br>" . $startDate . "<br>";
    //gets tagId from the tag name, backwards I know
    $tagIdSQL = "CALL sp_gb_plc_IdByTagGet('" . $tag . "')";
    $tagResults = mysqli_query(dbmysqli(), $tagIdSQL);
    
    //echo $tagIdSQL . "<br>";
    while($tagRes = mysqli_fetch_array($tagResults))
      {
        $tagId = $tagRes['id'];
      }
      if($duration > 0)
        {
          $runtimeInsertSQL = "CALL sp_gb_plc_RuntimeInsert("
                . $id . ","
                . $shiftId . ","
                . $durationMinutes . ","
                . $duration . ",'"
                . $device . "'," 
                . $tagId. ",'" 
                . $tag . "','" 
                . $startDate . "')";
        echo $runtimeInsertSQL . "<br>";
        mysqli_query(dbmysqli(), $runtimeInsertSQL);   
      }
  }
//========================================================================================== END PHP
?>

<!-- HTML -->