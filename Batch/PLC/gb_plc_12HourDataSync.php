<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_plc_12HourDataSync.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 03/28/2018|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('/var/www/sites/silicore/Includes/security.php');
require_once ('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once('/var/www/sites/silicore/Includes/emailfunctions.php');

 echo ("Starting Data Transfer"); 
/*
 * Connect to MYSQL DB and retrieve latest ID 
 */
$dbc = databaseConnectionInfo();
$latestIdConn = new mysqli
  (
    $dbc['silicore_hostname'],
    $dbc['silicore_username'],
    $dbc['silicore_pwd'],
    $dbc['silicore_dbname']
  );
try
{
  $catchError = "There was a problem while trying to retrieve the latest ID with CALL sp_gb_plc_12HourMaxGet()";
  $query = 'CALL sp_gb_plc_12HourMaxGet()';
  $latestSqlId = $latestIdConn->query($query);
  mysqli_close($latestIdConn);
  if(!$latestSqlId)
  {
    throw new Exception(mysqli_error($dbcSiteName));
  }
}// end try
catch(Exception $e)
{
  echo(("Exception: " . $catchError . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
  exit("Stopping PHP execution");
}// end catch
 
//store max(id) in a variable
while($result = mysqli_fetch_assoc($latestSqlId))
  {
    $latestId = $result['MAX(Id)'];
	}
  
  if($latestId == "" or $latestId == null)
    {
      $latestId = 0;
    }
/*
 * Connect to MSSQL DB and retrieve new records 
 */
$dbcreds = databaseConnectionInfo();
$connarray = array
  (
    "Database" => $dbcreds['silicoreplc_dbname'],
    "Uid" => $dbcreds['silicoreplc_dbuser'],
    "PWD" => $dbcreds['silicoreplc_pwd']
  );

try
  {
    $msdbconn = sqlsrv_connect($dbcreds['silicoreplc_dbhost'],$connarray);
    $newRecordsSQL = "EXEC [dbo].[sp_gb_plc_12HourNewRecordsGet] @Id = '" . $latestId . "';";
    echo "<br>" . $newRecordsSQL . "<br>";
    
    $new12HourRecords = sqlsrv_query($msdbconn, $newRecordsSQL);
    
    echo print_r($new12HourRecords);
    
    //sqlsrv_close($msdbconn);
  } 
catch (Exception $ex) 
  {
    $catchError = "There was a problem while trying to retrieve the latest ID with CALL sp_gb_plc_12HourNewRecordsGet";
    echo(("Exception: " . $catchError . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
    exit("Stopping PHP execution");
  }
  
//write new records to mysql table
while($record = sqlsrv_fetch_array($new12HourRecords))
  {
    //use name to retrieve tag id, if none exists then it creates a tag in the table and sends an email
    $name = $record['Name'];
  
    $dbc = databaseConnectionInfo();
    $tagIdConn = new mysqli
      (
        $dbc['silicore_hostname'],
        $dbc['silicore_username'],
        $dbc['silicore_pwd'],
        $dbc['silicore_dbname']
      );
    try
    {
      $catchError = "There was a problem while trying to retrieve tag_id with CALL sp_gb_plc_TagIdByNameGet()";
      $tagIdSQL = "CALL sp_gb_plc_TagIdByNameGet('" . $name . "')";
      echo "<br>" . $tagIdSQL . "<br>";
      $tagIdResult = $tagIdConn->query($tagIdSQL);
      mysqli_close($tagIdConn);
      $numRows = mysqli_num_rows($tagIdResult);
      echo "<BR> ROWS RETURNED: " . $numRows; 
      if(mysqli_num_rows($tagIdResult) == 0)
      {
        //crate new tag
        $tagPlc = $name;
        $tagArr = explode(".",$tagPlc);
        
        if(isset($tagArr[5]))
        {
          $tagShort = $tagArr[4] . '.' . $tagArr[5];
        }
        else
        {
           $tagShort = $tagArr[4];
        }
        $tagEhouse = $tagArr[1];
        $dbc = databaseConnectionInfo();
        $createTagConn = new mysqli
          (
            $dbc['silicore_hostname'],
            $dbc['silicore_username'],
            $dbc['silicore_pwd'],
            $dbc['silicore_dbname']
          );
        
        try
        {
          $catchError = "There was a problem while trying to retrieve tag_id with CALL sp_gb_plc_TagAutomatedInsert()";
          $tagInsertSQL = "CALL sp_gb_plc_TagAutomatedInsert('" . $tagShort . "','" . $tagPlc . "','" . $tagEhouse. "')";
          echo "<br>" . $tagInsertSQL . "<br>";
          $tagIdResult = $createTagConn->query($tagInsertSQL);
          mysqli_close($createTagConn);
          sendTagEmail($tagPlc);
        }
        catch(Exception $e)
        {
          echo(("Exception: " . $catchError . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
          exit("Stopping PHP execution");
        }// end catch
      }
    }// end try
    catch(Exception $e)
    {
      echo(("Exception: " . $catchError . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
      exit("Stopping PHP execution");
    }// end catch
    
    
    while($tagIdRes = mysqli_fetch_assoc($tagIdResult))
      {
        $tagId = $tagIdRes['id'];
      }
    $id = $record['Id'];
    $timestamp = $record['Timestamp']->format('Y-m-d H-i-s');
    $value = $record['Value'];
    $quality = $record['Quality'];
        
    $dbc = databaseConnectionInfo();
    $Insert12HourConn = new mysqli
      (
        $dbc['silicore_hostname'],
        $dbc['silicore_username'],
        $dbc['silicore_pwd'],
        $dbc['silicore_dbname']
      );
    try
    {
      $insert12HourSQL = "CALL sp_gb_plc_12HourRecordInsert ("
              . $id . ", '"
              . $timestamp . "', '"
              . $tagId . "', "
              . $value . ", "
              . $quality . ");";
      echo "<br>" . $insert12HourSQL . "<br>";
      if($quality === 192)
        {
          $Insert12HourConn->query($insert12HourSQL);
        }
      mysqli_close($Insert12HourConn);
    }// end try
    catch(Exception $e)
    {
      echo(("Exception: " . $catchError . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
      exit("Stopping PHP execution");
    }// end catch
    
  }
  
  function sendTagEmail($tag)
  {
    $msg = "The following tag was created and needs configuration: " . $tag;
    SendPHPMail("devteam@vistasand.com", "New Tag Added", $msg, "10 Minute Batch Script",0,0);
  }

//========================================================================================== END PHP
?>

<!-- HTML -->