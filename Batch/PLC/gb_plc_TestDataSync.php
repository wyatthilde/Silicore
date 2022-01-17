<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_plc_1MinuteDataSync.php
 * Project: silicore_site
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/29/2017|nolliff|KACE:17349 - Initial creation
 * 
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('/var/www/sites/silicore/Includes/security.php');
require_once ('/var/www/sites/silicore/Includes/Security/dbaccess.php');

$mydbconn = dbmysql();
$query = 'CALL sp_gb_plc_1MinuteMaxGet()';
$latestSqlID = $mydbconn->query($query);

if (!$latestSqlID) 
  {
    echo ('Could not run query: ' . mysql_error($mydbconn));
    exit;

  }
  

while($result = mysqli_fetch_assoc($latestSqlID))
  {
    $latestId = $result['Id'];
	}

$latestID = 43304;

$msdbconn = dbmssql();
$query = 'EXEC [dbo].[sp_gb_plc_TestNewRecordsGet] @Id = '.$latestID.';';


$newRecords = sqlsrv_query($msdbconn, $query);

if (!$latestSqlID) {
    echo 'Could not run query: ' . mssql_get_last_message($msdbconn);
    exit;
}

while($record = sqlsrv_fetch_array($newRecords, SQLSRV_FETCH_ASSOC))
  {
    $id = $record['Id'];
    $timestamp = $record['Timestamp']->format('Y-m-d H-i-s');
    $name = $record['Name'];
    $value = $record['Value'];
    $quality = $record['Quality'];
    
    $dbconn = dbmysql();
    $query = "CALL sp_gb_plc_1MinuteRecordInsert ("
            . $id . ", '"
            . $timestamp . "', '"
            . $name . "', "
            . $value . ", "
            . $quality . ");";
    $result = $dbconn->query($query);
    echo $query ."<br>";
    if(!$result)
    {
      echo ("Error: " . mysqli_error($dbconn) . "<br>");
    }
    
    if($value <= 400 && $name == 'PLC.EH3.C13_SCL_VALUE')
      {
        $body = "Name: " . $name . "<br>Value: " . $value . "<br>Time: " . $timestamp;
        SendPHPMail("nolliff@vprop.com","Batch test plc email",$body,("/Batch/PLC/gb_plc_TestDataSync.php"),0,0);
      }
  }
  
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

function dbmssql()
{
try
  {
    $dbcreds = databaseConnectionInfo();
    $connarray = array
    (
      "Database" => $dbcreds['silicoreplc_dbname'],
      "Uid" => $dbcreds['silicoreplc_dbuser'],
      "PWD" => $dbcreds['silicoreplc_pwd']
    );
    $dbconn = sqlsrv_connect($dbcreds['silicoreplc_dbhost'],$connarray);

    return $dbconn;
  }
catch (Exception $e)
  {
    echo ("Error while trying to get data" . $e);   
  }
}
//========================================================================================== END PHP
?>

<!-- HTML -->
