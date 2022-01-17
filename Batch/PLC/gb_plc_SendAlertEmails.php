<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_plc_SendAlertEmails.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 02/07/2018|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('/var/www/sites/silicore/Includes/security.php');
require_once ('/var/www/sites/silicore/Includes/Security/dbaccess.php');
require_once('/var/www/sites/silicore/Includes/emailfunctions.php');

$currentHour = date('H');
echo $currentHour;

$dbc = databaseConnectionInfo();
$thresholdConn = new mysqli
  (
    $dbc['silicore_hostname'],
    $dbc['silicore_username'],
    $dbc['silicore_pwd'],
    $dbc['silicore_dbname']
  );
try
{
  $catchError = "There was a problem while trying to retrieve the latest ID with CALL sp_gb_plc_ThresholdByTagIdGet()";
  $thresholdGetSQL = 'CALL sp_gb_plc_ThresholdsGetAll()';
  $thresholds = $thresholdConn->query($thresholdGetSQL);
  
  mysqli_close($thresholdConn);
}// end try
catch(Exception $e)
{
  echo(("Exception: " . $catchError . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
  exit("Stopping PHP execution");
}// end catch

if($currentHour < 6 || $currentHour >= 7) 
  {
    if($currentHour < 18 || $currentHour >= 19) 
    {
      while($thresholdRes = mysqli_fetch_array($thresholds))
        {
          $threshold = $thresholdRes['threshold'];
          $userId = $thresholdRes['user_id'];
          $tagId = $thresholdRes['tag_id'];
          echo $tagId;
          $totalizerArray = array();
          $arrayIndex = 0;


          $dbc = databaseConnectionInfo();
          $totalConn = new mysqli
            (
              $dbc['silicore_hostname'],
              $dbc['silicore_username'],
              $dbc['silicore_pwd'],
              $dbc['silicore_dbname']
            );
          try
            {
              $catchError = "There was a problem while trying to retrieve the latest ID with CALL sp_gb_plc_HourReadingsByTagIdGet()";
              $hourlyTotalSQL = 'CALL sp_gb_plc_HourReadingsByTagIdGet(' . $tagId . ')';
              ECHO "<BR>" . $hourlyTotalSQL . "<BR>";
              $totalResults = $totalConn->query($hourlyTotalSQL);

              mysqli_close($totalConn);
            }// end try
          catch(Exception $e)
            {
              echo(("Exception: " . $catchError . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
              exit("Stopping PHP execution");
            }// end catch



          while($hourlyTotalResult = mysqli_fetch_array($totalResults))
            {
              $totalizerArray[$arrayIndex] = $hourlyTotalResult['value'];
              $timeArray[$arrayIndex] = $hourlyTotalResult['timestamp'];
              $arrayIndex++;
            }

          $hourlyTotal = max($totalizerArray) - min($totalizerArray);

          if($threshold > $hourlyTotal)
            {
              sendAlertEmail($userId, $tagId, $threshold, $totalizerArray, $timeArray);
            }
      }//end while 
    }//end if 
  }//end if
  
function sendAlertEmail($userId, $tagId, $threshold, $totalizerArray, $timeArray)
  {
    $totalText = '';
    $dbc = databaseConnectionInfo();
    $emailConn = new mysqli
      (
        $dbc['silicore_hostname'],
        $dbc['silicore_username'],
        $dbc['silicore_pwd'],
        $dbc['silicore_dbname']
      );
    try
      {
        $catchError = "There was a problem while trying to retrieve the latest ID with CALL sp_gb_adm_EmailByUserIdGet()";
        $emailSql = 'CALL sp_gb_adm_EmailByUserIdGet(' . $userId . ')';
        echo $emailSql;
        $emailResult = $emailConn->query($emailSql);
      }// end try
    catch(Exception $e)
      {
        echo(("Exception: " . $catchError . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
        exit("Stopping PHP execution");
      }// end catch
    
      
    $dbc = databaseConnectionInfo();
    $tagConn = new mysqli
      (
        $dbc['silicore_hostname'],
        $dbc['silicore_username'],
        $dbc['silicore_pwd'],
        $dbc['silicore_dbname']
      );
    try
      {
        $catchError = "There was a problem while trying to retrieve the latest ID with CALL sp_gb_adm_EmailByUserIdGet()";
        $tagSql = 'CALL sp_gb_plc_TagByIdGet(' . $tagId . ')';
        echo "<BR>" . $tagSql . "<BR>";
        $tagResult = $tagConn->query($tagSql);
        if (mysqli_num_rows($tagResult)==0) { echo"wat"; }
        echo print_r($tagResult);
      }// end try
    catch(Exception $e)
      {
        echo(("Exception: " . $catchError . "<br /><br />Error message: " . $e->getMessage() . "<br /><br />"));
        exit("Stopping PHP execution");
      }// end catch
    
    while($emailRes = mysqli_fetch_array($emailResult))
      {
        $userEmail = $emailRes['email']; 
      }
    while($tagRes = mysqli_fetch_array($tagResult))
      {
        $tag = $tagRes['tag']; 
      }
      
    for( $i = 0; $i < count($totalizerArray); $i++)
    {
      $totalText = $totalText . "<br>" . ($i + 1 ) . " Time: " . $timeArray[$i] . " Total: " . $totalizerArray[$i];
    }
    $subject = $tag . " Under Threshold of " . $threshold;
    $msg = "Tag " . $tag . " was recorded as being lower than your set threshold of " . $threshold . ".<br>"
            . "The following are the times in 10 minute incriments: " . $totalText;
    
    SendPHPMail($userEmail,$subject,$msg, "Email Alert Script",0,0);     
  }
//========================================================================================== END PHP
?>

<!-- HTML -->