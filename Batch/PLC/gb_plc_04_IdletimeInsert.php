<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_plc_04_IdletimeInsert.php
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/30/2017|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('/var/www/sites/silicore/Includes/security.php');
require_once('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once('/var/www/sites/silicore/Includes/emailfunctions.php');
require_once('/var/www/sites/silicore/Includes/Production/productionfunctions.php');


try
{
  $maxIdSQL = "CALL sp_gb_plc_IdletimeMaxIdGet()";
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
//  $date = '2017-10-31';
//  $idletimeSQL = "EXECUTE sp_gb_plc_IdletimeByDateGet @date='" . $date . "'";
  $idletimeSQL = "EXECUTE sp_gb_plc_IdletimeByIdGet @Id=" . $maxID;
  echo $idletimeSQL . "<br>";
  $idletimeResults = sqlsrv_query($mssqlconn, $idletimeSQL);
}
catch(Exception $ex)
{
  echo("Error: " .  __LINE__ . " " .$ex);
}

while($idletime = sqlsrv_fetch_array($idletimeResults)) 
  {
	
    $id = $idletime['id'];
    $shiftId = $idletime['ShiftId'];
    $endDate = date_format($idletime['ItEnd'], 'Y-m-d H:i:s');
    $durationMinutes = $idletime['ItAmount'];
    $reason = $idletime['ItReason'];
    $comment = $idletime['Comment'];
    $startDate = date("Y-m-d H:i:s", strtotime($endDate) - ($durationMinutes * 60));
    $endDtShort = substr(date("YmdHi", strtotime($endDate)), 0, 11); //shorten the date to an 11 digit integer, effectively rounding it to the nearest ten minutes and making it easy for mysql to handle in joins

    $duration = round($durationMinutes / 60, 2);


    //insert the record
  try
    {
      if($duration > 0)
        {
          $idletimeInsertSQL = "CALL sp_gb_plc_IdletimeInsert("
            . $id . ","
            . $shiftId . ",'"
            . $startDate . "','"
            . $endDate . "',"
            . $durationMinutes . ","
            . $duration . ",'"
            . $reason . "','"
            . $comment . "')";
          echo $idletimeInsertSQL . "<br>";
          mysqli_query(dbmysqli(), $idletimeInsertSQL);
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