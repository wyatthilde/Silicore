<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_plc_05_ShiftInsert.php
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/01/2017|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHp


require_once('/var/www/sites/silicore/Includes/security.php');
require_once('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once('/var/www/sites/silicore/Includes/emailfunctions.php');
require_once('/var/www/sites/silicore/Includes/Production/productionfunctions.php');



//get max id for runtime table in mysql
try
  {
    $maxIdSQL = "CALL sp_gb_plc_ShiftsMaxIdGet()";
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
    
    //date should only be used once, keeping it in for just in case
//      $shiftDate = '2017-10-31';
//      $shiftSQL = "EXECUTE sp_gb_plc_ShiftByDateGet @date='" . $shiftDate . "'";  
    
    //retrieves all new records based on max id from mysql table
    $shiftSQL = "EXECUTE sp_gb_plc_ShiftByIdGet @Id=" . $maxID;
    echo $shiftSQL . "<br>";
    $shiftResults = sqlsrv_query($mssqlConn, $shiftSQL);
  }
catch(Exception $ex)
  {
    //echo used for debugging, error email will be implemented later
    echo("Error: " .  __LINE__ . " " .$ex);
  }
  
while($shiftRes = sqlsrv_fetch_array($shiftResults)) 
{
	$id = $shiftRes['Id'];
	$shiftId = $shiftRes['ShiftId'];
	$plantAreaId = $shiftRes['ProdAreaId'];
	$plantArea = $shiftRes['ProdArea'];
	$startDt = date_format($shiftRes['StartDate'], 'Y-m-d H:i:s');
	$operator = $shiftRes['OperatorName'];
  if($plantAreaId == 8)
          {
  echo( "<br> " . $plantAreaId . " TIME: " . $shiftRes['TimeMin']) . "<br>" ; 
    }
  if($shiftRes['TimeMin'] != null && $shiftRes['TimeMin'] != "")
    {
    	$durationMinutes = $shiftRes['TimeMin'];
    }
  else
    {
      $durationMinutes = 0;
    }
    
	$duration = round($durationMinutes / 60, 2);
		
	if ($shiftRes['EndDate'] != null && $shiftRes['EndDate'] != "") 
    {
      $endDt = "'" . date_format($shiftRes['EndDate'], 'Y-m-d H:i:s') . "'";
    } 
  else 
    {
      $endDt = "null";
    }

	switch ((int)$plantAreaId) {
		case 1: // Wet Plant #2 (New)
			$plantId = 3;
			break;
		case 5: // Carrier 1 (100T)
			$plantId = 6;
			break;
		case 6: // Rotary 1 (new rotary)
			$plantId = 7;
			break;
		case 8: // Carrier 2 (200T)
			$plantId = 8;
			break;
		default:
			// Do nothing, fall out of switch
	}
  $shiftDate = date_format($shiftRes['StartDate'], 'Y-m-d');
  
  $nightShiftStartTime = "18:00";
  $dayShiftStartTime = "6:00";
	$hour = date('H', strtotime($startDt));
  
    
  if ($hour >= date("H", strtotime($dayShiftStartTime)) && $hour < date("H", strtotime($nightShiftStartTime)))
    {
      $shift = 'Day';
    } 
  else
    {
      $shift = "Night";
    }
       
try
  {
    $downtimeDurationSQL = "CALL sp_gb_plc_DowntimeDurationSumGet(" . $shiftId . ")";
    $idletimeDurationSQL = "CALL sp_gb_plc_IdletimeDurationSumGet(" . $shiftId . ")";

    $downtimeSumResult = mysqli_query(dbmysqli(), $downtimeDurationSQL);
    $idletimeSumResult = mysqli_query(dbmysqli(), $idletimeDurationSQL);
    
    while($downtimeSum = mysqli_fetch_array($downtimeSumResult))
      {
        $downtime = $downtimeSum['downtime_minutes'] / 60;
        $downtimeRnd = round($downtime, 2);
      }
    while($idletimeSum = mysqli_fetch_array($idletimeSumResult))
      {
        $idletime = $idletimeSum['idletime_minutes'] / 60;
        $idletimeRnd = round($idletime, 2);
      }
  }
catch(Exception $ex)
  {
    echo("Error: " .  __LINE__ . " " .$ex);
  }
	
	$uptime = $duration - $downtime - $idletime;
	$uptimeRnd = round($uptime, 2);
  
	if ($duration > 0) 
    {
      $uptimePercent = round($uptime / $duration, 4);
      $downtimePercent = round($downtime / $duration, 4);
      $idletimePercent = round($idletime / $duration, 4);
    } 
  else 
    {
      $uptimePercent = 0;
      $downtimePercent = 0;
      $idletimePercent = 0;
    }
if ($endDt != "null" && $durationMinutes <= 10) 
      {
        $isRemoved = 1;
      }
else
  {
    $isRemoved = 0;
  }
	//insert the record
try
  {
    $insertShiftSQL = "CALL sp_gb_plc_ShiftInsert("
            . $id . ","
            . $plantAreaId . ",'"
            . $plantArea . "',"
            . $plantId . ",'"
            . $shiftDate . "','"
            . $shift . "','"
            . $startDt . "',"
            . $endDt . ",'"
            . $operator . "',"
            . $durationMinutes . ","
            . $duration . ","
            . $uptimeRnd . ","
            . $uptimePercent . ","
            . $downtimeRnd  . ","
            . $downtimePercent . ","
            . $idletimeRnd . ","
            . $idletimePercent . ","
            . $isRemoved . ")";
    
    echo $insertShiftSQL . "<br>";
		mysqli_query(dbmysqli(), $insertShiftSQL );
  }
catch(Exception $ex)
  {
    echo("Error: " .  __LINE__ . " " .$ex);
  }
}

//========================================================================================== END PHP
?>

<!-- HTML -->