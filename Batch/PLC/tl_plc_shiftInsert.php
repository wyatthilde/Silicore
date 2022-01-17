<?php
/* * *****************************************************************************************************************************************
 * File Name: tl_plc_shiftInsert.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 05/23/2018|__USER__|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('/var/www/sites/silicore/Includes/security.php');
require_once ('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once('/var/www/sites/silicore/Includes/emailfunctions.php');
require_once('/var/www/sites/silicore/Includes/Production/productionfunctions.php');
/*
 * Connect to MYSQL DB and retrieve latest ID 
 */
echo "starting";
try
{
  $catchError = "There was a problem while trying to retrieve the latest ID with CALL sp_tl_plc_10MinuteMaxGet()";
  $query = 'CALL sp_tl_plc_ShiftsMaxIdGet()';
  $latestSqlId = dbmysqli()->query($query);
  if(!$latestSqlId)
    {
      throw new Exception(mysqli_error(dbmysqli()));
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
      $latestId = 0;
    }
    
$dbcreds = databaseConnectionInfo();
$connarray = array
  (
    "Database" => $dbcreds['silicore_tl_dbname'],
    "Uid" => $dbcreds['silicore_tl_username'],
    "PWD" => $dbcreds['silicore_tl_pwd']
  );

try
  {
    $msdbconn = sqlsrv_connect($dbcreds['silicore_tl_hostname'],$connarray);
    $newRecordsSQL = "EXEC [dbo].[sp_tl_plc_RuntimesGet] @shiftId = '" . $latestId . "';";
        var_dump($msdbconn);
    echo "<br>" . $newRecordsSQL . "<br>";
    
    $newShifts = sqlsrv_query($msdbconn, $newRecordsSQL);
    var_dump($newShifts);
    //echo print_r($newShifts);
    
    //sqlsrv_close($msdbconn);
  } 
catch (Exception $ex) 
  {
    $catchError = "There was a problem while trying to retrieve the latest ID with EXEC sp_tl_plc_RuntimesGet";
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
    
    if($shift['idletime'] != null || $shift['idletime'] != '')
      {
          $idletime = $shift['idletime'];
      }
    else
      {
          $idletime = 0;
      }
      
    $uptime = $timeMin - $idletime - $downtime;
      
    $isDay = dateIsBetween('4:30', '6:30', $time);
    
    try
    {
      $insertShiftSQL = "CALL sp_tl_plc_ShiftInsert ("
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