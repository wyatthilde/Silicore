<?php
/* * *****************************************************************************************************************************************
 * File Name: runtimeCorrection.php
 * Project: silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 11/13/2017|nolliff|KACE:19535 - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('/var/www/sites/silicore/Includes/security.php');
require_once('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once('/var/www/sites/silicore/Includes/emailfunctions.php');

function dbmysql()
{
  try
    {
    $dbc = databaseConnectionInfo();
    $dbconn = new mysqli
    (
      $dbc['silicore_hostname'],
      $dbc['silicore_username'],
      $dbc['silicore_pwd'],
      $dbc['silicore_dbname']
    );
    return $dbconn;
    
    mysqli_close($dbconn);
    }
  catch (Exception $e)
  {
    echo ("Error while trying to get data" . $e);   
  }
}


$tag = "a1SC11_RUNTIME";
$startDate = "2017-10-26 00:00:00";
$endDate = date("Y-m-d H:i:s");

$mydbconn = dbmysql();
$query = "CALL sp_gb_plc_runtimeGet('". $tag ."', '" . $startDate . "','" . $endDate . "' )";
$runtimeRecords = $mydbconn->query($query);



if (!$runtimeRecords) 
  {
    echo ('Could not run query: ' . mysqli_error($mydbconn));
    exit;
  }  

while($record = mysqli_fetch_assoc($runtimeRecords))
  {
    $id = $record['id'];
    $runtime = $record['real_runtime'];
    $duration = $runtime/60;
    $query = "CALL sp_gb_plc_runtimeCorrect(" . $id . "," . $runtime . "," . $duration . ")";
    echo($query . "<BR>");
    
    try
    {
    $dbconn = dbmysql();
    $dbconn->query($query);
    }
    catch(Exception $e)
    {
      echo ("Error: " . $e);
    }
	}
//========================================================================================== END PHP
?>

<!-- HTML -->