<?php
/* * *****************************************************************************************************************************************
 * File Name: tl_plc_10MinuteDataSync.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 05/17/2018|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('/var/www/sites/silicore/Includes/security.php');
require_once ('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once('/var/www/sites/silicore/Includes/emailfunctions.php');

/*
 * Connect to MYSQL DB and retrieve latest ID 
 */

try
{
  $catchError = "There was a problem while trying to retrieve the latest ID with CALL sp_tl_plc_10MinuteMaxGet()";
  $query = 'CALL sp_tl_plc_10MinuteMaxGet()';
  $latestSqlId = dbmysql()->query($query);
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
    $latestId = $result['MAX(Id)'];
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
    $newRecordsSQL = "EXEC [dbo].[sp_10MinuteNewRecordsGet] @Id = '" . $latestId . "';";
    
    echo "<br>" . $newRecordsSQL . "<br>";
    
    $new10MinuteRecords = sqlsrv_query($msdbconn, $newRecordsSQL);
    
    echo print_r($new10MinuteRecords);

    
  } 
catch (Exception $ex) 
  {
    $catchError = "There was a problem while trying to retrieve the latest ID with CALL sp_tl_plc_10MinuteNewRecordsGet";
    echo(("Exception: " . $catchError . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
    exit("Stopping PHP execution");
  }
    
while($record = sqlsrv_fetch_array($new10MinuteRecords))
  {
    //use name to retrieve tag id, if none exists then it creates a tag in the table and sends an email
    $name = $record['Name'];
  
    try
    {
      $catchError = "There was a problem while trying to retrieve tag_id with CALL sp_tl_plc_TagIdByNameGet()";
      $tagIdSQL = "CALL sp_tl_plc_TagIdByNameGet('" . $name . "')";
      echo "<br>" . $tagIdSQL . "<br>";
      $tagIdResult = dbmysql()->query($tagIdSQL);
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
          $catchError = "There was a problem while trying to retrieve tag_id with CALL sp_tl_plc_TagAutomatedInsert()";
          $tagInsertSQL = "CALL sp_tl_plc_TagAutomatedInsert('" . $tagShort . "','" . $tagPlc . "','" . $tagEhouse. "')";
          echo "<br>" . $tagInsertSQL . "<br>";
          $tagIdResult = dbmysql()->query($tagInsertSQL);

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
    if($value < 0 )
        {
          $value = 0;
        }
    try
    {
      $insert10MinuteSQL = "CALL sp_tl_plc_10MinuteRecordInsert ("
              . $id . ", '"
              . $timestamp . "', '"
              . $tagId . "', "
              . $value . ", "
              . $quality . ");";
      echo "<br>" . $insert10MinuteSQL . "<br>";
      if($quality === 192)
        {
        dbmysql()->query($insert10MinuteSQL);
        }

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
  
  
  
function dbmssqltl()
    {
      $dbcreds = databaseConnectionInfo();
      $connarray = array
    (
    "Database" => $dbcreds['silicore_tl_dbname'],
    "Uid" => $dbcreds['silicore_tl_username'],
    "PWD" =>$dbcreds['silicore_tl_pwd']
    );
    $dbconn = sqlsrv_connect($dbcreds['silicore_tl_hostname'],$connarray) or die('MSSQL error: ' . sqlsrv_errors());
    
    return $dbconn;
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

        }
      catch (Exception $e)
        {
          $_SESSION['sample_error'] = "Error while trying to get data" . $e;   
        }
    }
//========================================================================================== END PHP
?>

<!-- HTML -->