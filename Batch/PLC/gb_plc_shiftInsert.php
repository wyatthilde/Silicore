<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_plc_shiftInsert.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 05/22/2018|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once ('../../Includes/Security/dbaccess.php');
require_once('../../Includes/emailfunctions.php');
require_once('../../Includes/Production/productionfunctions.php');
/*
 * Connect to MYSQL DB and retrieve latest ID 
 */
echo "starting";
try
{
  $catchError = "There was a problem while trying to retrieve the latest ID with CALL sp_tl_plc_10MinuteMaxGet()";
  $query = 'CALL sp_gb_plc_ShiftsMaxIdGet()';
  $latestSqlId = dbmysqli()->query($query);
  if(!$latestSqlId)
    {
      throw new Exception(mysqli_error($dbcSiteName));
    }
}
  catch(Exception $e)
{
  echo(("Exception: " . $catchError . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
  exit("Stopping PHP execution");
}// end catch
  
  while($result = mysqli_fetch_assoc($latestSqlId))
  {
    $latestId = $result['maxId'];
	}
  
if($latestId == "" or $latestId == null)
    {
      $latestId = 22286;
    }
    
$dbcreds = databaseConnectionInfo();
$connarray = array
  (
    "Database" => $dbcreds['silicoreplc_dbname'],
    "Uid" => $dbcreds['silicoreplc_dbuser'],
    "PWD" => $dbcreds['silicoreplc_pwd']
  );
print_r(sqlsrv_connect($dbcreds['silicoreplc_dbhost'],$connarray));
try
  {
    $msdbconn = sqlsrv_connect($dbcreds['silicoreplc_dbhost'],$connarray);
    $newRecordsSQL = "EXEC [dbo].[sp_gb_plc_RuntimesGet] @shiftId = '" . $latestId . "';";
        var_dump($msdbconn);
    echo "<br>" . $newRecordsSQL . "<br>";
    
    $newShifts = sqlsrv_query($msdbconn, $newRecordsSQL);
    var_dump($newShifts);
    //echo print_r($newShifts);
    
    //sqlsrv_close($msdbconn);
  } 
catch (Exception $ex) 
  {
    $catchError = "There was a problem while trying to retrieve the latest ID with EXEC sp_gb_plc_RuntimesGet";
    echo(("Exception: " . $catchError . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
    exit("Stopping PHP execution");
  }
    
 while($shift = sqlsrv_fetch_array($newShifts))
  {
    //use name to retrieve tag id, if none exists then it creates a tag in the table and sends an email
    $id = $shift['Id'];
    $startDate = $shift['StartDate']->format('Y-m-d H:i:s');
    if($shift['EndDate'] != null && $shift['EndDate'] != '')
      {
      $endDate = $shift['EndDate']->format('Y-m-d H:i:s');
      }
      else 
      {
        $endDate = '';
      }
    $operator =  $shift['OperatorName'];
    $prodArea = $shift['ProdAreaId'];
    $timeMin = $shift['TimeMin'];
    $duration = $timeMin / 60;
    $time = substr($startDate,  11, -3);
    
    
    
    if($shift['downtime'] != null || $shift['downtime'] != '')
      {
          $downtime = $shift['downtime'];
      }
    else
      {
          $downtime = 0;
      }
      
    if($shift['schdowntime'] != null || $shift['schdowntime'] != '')
      {
          $schdowntime = $shift['schdowntime'];
      }
    else
      {
          $schdowntime = 0;
      }
      
    if($shift['idletime'] != null || $shift['idletime'] != '')
      {
          $idletime = $shift['idletime'];
      }
    else
      {
          $idletime = 0;
      }
    
    $uptime = $timeMin - $idletime - $downtime - $schdowntime;
    
    if($uptime > 720)
      {
        $uptime = 720 - $idletime - $downtime -$schdowntime;
       }
    
    $isDay = dateIsBetween('4:30', '6:30', $time);
    
    try
    {
      $insertShiftSQL = "CALL sp_gb_plc_ShiftInsert ("
              . $id . ", "
              . $prodArea . ","
              . $isDay . ",'"
              . $startDate . "', '"
              . $endDate . "', '"
              . $operator . "', "
              . $timeMin . ","
              . $duration . ","
              . $uptime . ","
              . $downtime . ","
              . $schdowntime . ","
              . $idletime . ");";


      if($timeMin > 5 && $endDate != '')//arbitrary to prevent short shifts 
        {
          echo "<br>" . $insertShiftSQL . "<br>";
          $InseerShiftConn = dbmysqli();
          $query = $InseerShiftConn->query($insertShiftSQL) or die(mysqli_error($InseerShiftConn));
      }

    }// end try
    catch(Exception $e)
    {
      echo(("Exception: " . $catchError . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
      exit("Stopping PHP execution");
    }// end catch
    
  }
function dateIsBetween($from, $to, $date) {
    $date = is_int($date) ? $date : strtotime($date); // convert non timestamps
    $from = is_int($from) ? $from : strtotime($from); // ..
    $to = is_int($to) ? $to : strtotime($to);         // ..
	if(($date > $from) && ($date < $to))
	   	{
          return 1; 
		}
	else 
      {
        return 0;
      }
}

//========================================================================================== END PHP
?>

<!-- HTML -->