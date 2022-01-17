<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_plc_10MinuteDataSync.php
 * Project: silicore_site
 * Description: 
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 09/29/2017|nolliff|KACE:17349 - Initial creation
 * 03/15/2018|nolliff|Kace:XXXXX - Changed script to only insert record if quality is 192
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once ('../../Includes/Security/dbaccess.php');
require_once('../../Includes/emailfunctions.php');
require_once('../../Includes/Production/productionfunctions.php');

 echo ("Starting Data Transfer"); 
/*
 * Connect to MYSQL DB and retrieve latest ID 
 */
try
{
  $catchError = "There was a problem while trying to retrieve the latest ID with CALL sp_gb_plc_10MinuteMaxGet()";
  $query = 'CALL sp_gb_plc_10MinuteMaxGet()';
  $latestSqlId = dbmysqli()->query($query);

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
    $newRecordsSQL = "EXEC [dbo].[sp_gb_plc_10MinuteNewRecordsGet] @Id = '" . $latestId . "';";
    
    echo "<br>" . $newRecordsSQL . "<br>";
    
    $new10MinuteRecords = sqlsrv_query($msdbconn, $newRecordsSQL);
    
    echo print_r($new10MinuteRecords);
    
    //sqlsrv_close($msdbconn);
  } 
catch (Exception $ex) 
  {
    $catchError = "There was a problem while trying to retrieve the latest ID with CALL sp_gb_plc_10MinuteNewRecordsGet";
    echo(("Exception: " . $catchError . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
    exit("Stopping PHP execution");
  }
  
//write new records to mysql table
while($record = sqlsrv_fetch_array($new10MinuteRecords))
  {
    //use name to retrieve tag id, if none exists then it creates a tag in the table and sends an email
    $name = $record['Name'];

    try
    {
      $catchError = "There was a problem while trying to retrieve tag_id with CALL sp_gb_plc_TagIdByNameGet()";
      $tagIdSQL = "CALL sp_gb_plc_TagIdByNameGet('" . $name . "')";
      echo "<br>" . $tagIdSQL . "<br>";
      $tagIdResult = dbmysqli()->query($tagIdSQL);
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
        
        try
        {
          $catchError = "There was a problem while trying to retrieve tag_id with CALL sp_gb_plc_TagAutomatedInsert()";
          $tagInsertSQL = "CALL sp_gb_plc_TagAutomatedInsert('" . $tagShort . "','" . $tagPlc . "','" . $tagEhouse. "')";
          echo "<br>" . $tagInsertSQL . "<br>";
          $tagIdResult = dbmysqli()->query($tagInsertSQL);
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
    
    echo "<br> time test: ". $record['Timestamp']->format('H:i:s')."<br>";
    $value = $record['Value'];
    $quality = $record['Quality'];
        
    if($record['Timestamp']->format('H:i:s') > '05:20:00' && $record['Timestamp'] -> format('H:i:s') < '05:30:00' )
      
      {
       $eos = 1;
      }
    else if ($record['Timestamp']->format('H:i:s') > '17:20:00' && $record['Timestamp'] -> format('H:i:s') < '17:30:00' )
      {
       $eos = 1;
      }
    else
      {
        $eos = 0;
      }
    
        if($value < 0 )
        {
          $value = 0;
        }
    try
    {
      $insert10MinuteSQL = "CALL sp_gb_plc_10MinuteRecordInsert ("
              . $id . ", '"
              . $timestamp . "', '"
              . $tagId . "', "
              . $value . ", "
              . $quality . ","
              . $eos . ");";
      echo "<br>" . $insert10MinuteSQL . "<br>";
      if($quality === 192)
        {
          dbmysqli()->query($insert10MinuteSQL);
        }
      mysqli_close($Insert10MinuteConn);
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
