<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_plc_03_DowntimeInsert.php
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/29/2017|nolliff|KACE:16787 - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP

require_once('/var/www/sites/silicore/Includes/security.php');
require_once('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once('/var/www/sites/silicore/Includes/emailfunctions.php');
require_once('/var/www/sites/silicore/Includes/Production/productionfunctions.php');


try
{
  $maxIdSQL = "CALL sp_gb_plc_DowntimeMaxIdGet()";
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
  $mssqlconn = mssqldb();
//$date = '2017-10-31';
//$downtimeSQL = "EXECUTE sp_gb_plc_DowntimeByDateGet @date='" . $date . "'";
  $downtimeSQL = "EXECUTE sp_gb_plc_DowntimeByIdGet @Id=" . $maxID;
  echo $downtimeSQL . "<br>";
  $downtimeResults = sqlsrv_query($mssqlconn,$downtimeSQL);
}
catch(Exception $ex)
{
  echo("Error: " .  __LINE__ . " " .$ex);
}

while($downtime = sqlsrv_fetch_array($downtimeResults)) {
	
	$id = $downtime['id'];
  $dtId = $downtime['DtId'];
	$shiftId = $downtime['ShiftId'];
	$endDt = $downtime['DtEnd']->format('Y-m-d H:i:s');
	$durationMinutes = $downtime['DtAmount'];
	$reason = $downtime['DtReason'];
	$deviceName = $downtime['DeviceName'];
	$comment = $downtime['Comment'];
  if($reason == "Scheduled")
    {
      $isScheduled = 1;	
    }
  else
    {
      $isScheduled = 0;
    }
	$startDt = date("Y-m-d H:i:s", strtotime($endDt) - ($durationMinutes * 60));
	$duration = round($durationMinutes / 60, 2);
  
	try
  {
    if($duration > 0)
      {
        $downtimeInsertSQL = "CALL sp_gb_plc_DowntimeInsert("
          . $id . ","
          . $shiftId . ",'"
          . $startDt . "','"
          . $endDt . "',"
          . $durationMinutes . ","
          . $duration . ",'"
          . $reason . "','"
          . $deviceName . "','"
          . $comment . "',"
          . $isScheduled . ")";
        echo $downtimeInsertSQL . "<br>";
          //insert the record
        mysqli_query(dbmysqli(), $downtimeInsertSQL);    
      }
    }
  catch(Exception $ex)
    {
      echo("Error: " .  __LINE__ . " " .$ex);
    }
}
//========================================================================================== END PHP
?>

<!-- HTML -->