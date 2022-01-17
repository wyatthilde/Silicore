<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_plc_06_AnalogInsert.php
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 12/04/2017|nolliff|KACE:16787 - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP


//////////////////step 6, update the warehouse with the analog information from the ESP system
//TagQuality of 192 is a good data read within the PLC

require_once('/var/www/sites/silicore/Includes/security.php');
require_once('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once('/var/www/sites/silicore/Includes/emailfunctions.php');
require_once('/var/www/sites/silicore/Includes/Production/productionfunctions.php');

try
  {
    $maxId10MinuteSQL = "CALL sp_gb_plc_600IntervalMaxIdGet()";
    $maxId10MinuteResult = mysqli_query(dbmysqli(),$maxId10MinuteSQL);
    while($id= mysqli_fetch_array($maxId10MinuteResult))
    {
      $maxId10Minute = $id['MaxId'];
    }
  }
catch(Exception $ex)
  {
    echo("Error: " .  __LINE__ . " " .$ex);
  }
  
try
  {
    $maxId1MinuteSQL = "CALL sp_gb_plc_60IntervalMaxIdGet()";
    $maxId1MinuteResult = mysqli_query(dbmysqli(),$maxId1MinuteSQL);
    while($id= mysqli_fetch_array($maxId1MinuteResult))
    {
      $maxId1Minute = $id['MaxId'];
    }
  }
catch(Exception $ex)
  {
    echo("Error: " .  __LINE__ . " " .$ex);
  }

try
  {
    $mssqlcon = mssqldb();
    
   $analogDate = '2017-10-31';
   $intervalTagSQL = "EXEC sp_gb_plc_IntervalTagGet @timestamp ='" . $analogDate . "'" ; 
    
   //$intervalTagSQL = "EXEC sp_gb_plc_IntervalTagByIdGet @60id = " . $maxId1Minute . ", @600id=" . $maxId10Minute;
    
    echo $intervalTagSQL . "<br>";
    $intervalResults = sqlsrv_query($mssqlcon, $intervalTagSQL);
  }
catch(Exception $ex)
  {
    echo("Error: " .  __LINE__ . " " .$ex);
  }

while($intervalResult = sqlsrv_fetch_array($intervalResults)) {

	
	$id = $intervalResult['TableIndex'];
	$intervalSeconds = $intervalResult['interval_seconds'];
	$tagPlc = $intervalResult['TagItemID'];
	$tagId = "null";
  $analogValue = $intervalResult['TagValue'];
	$analogDateStamp = date_format($intervalResult['TagTimestamp'], 'Y-m-d H:i:s');
  
  try
    {
      $tagIdSQL = "CALL sp_gb_plc_IdByTagGet('" . $tagPlc . "')";
      $tagIdResults = mysqli_query(dbmysqli(), $tagIdSQL );
      echo $tagIdSQL . "<br>";
      while($tagIdRes = mysqli_fetch_array($tagIdResults))
        {
          $tagId =  $tagIdRes['id'];
          Echo "id= " . $tagId . "<br>";
        }
    }
  catch(Exception $ex)
    {
      echo("Error: " .  __LINE__ . " " .$ex);
    }
	//convert product descriptions to product ids
	if ($analogValue == "100M") 
    {
      $analogValue = 1;
    } 
    elseif ($analogValue == "40/70") 
    {
      $analogValue = 2;
    }
    
  try
    {
      $analogInsertSQL = "CALL sp_gb_plc_AnalogDataInsert("
              . $id . ","
              . $tagId . ",'"
              . $tagPlc . "',"
              . $analogValue . ",'"
              . $analogDateStamp . "',"
              . $intervalSeconds . ")";
      echo $analogInsertSQL . "<br>";
      mysqli_query(dbmysqli(), $analogInsertSQL);
    }
  catch(Exception $ex)
    {
      echo("Error: " .  __LINE__ . " " .$ex);
    }

} 


//pull out the inventory records and insert them into the inventory table
//////////////////end step 6

//========================================================================================== END PHP
?>

<!-- HTML -->