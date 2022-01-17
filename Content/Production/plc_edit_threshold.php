<?php
/* * *****************************************************************************************************************************************
 * File Name: plc_edit_threshold.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/24/2018|nolliff|KACE:xxxxx - Initial creation
 * 07/16/2018|nolliff|KACE:xxxxx - renamed to plc_edit_threshold.php
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');

$debugging = 0; //set this to 1 to see debugging output
$userId = $_SESSION['user_id'];
$site = filter_input(INPUT_POST,'site');
//display information if we are in debugging mode
//echo $site;
if($debugging)
{
    echo "The current Linux user is: ";
    echo exec('whoami');
    echo "<br/>";
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    echo "<strong>Debugging Enabled - gb_plc_edit_threshold.php</strong><br/>";  
    echo "Start time: ";
    echo(date("Y-m-d H:i:s",$t));
    echo "<br/>";
}

$thresholdId = filter_input(INPUT_POST,'threshold_id');
$tagId = filter_input(INPUT_POST,'tag_id');
$alertOn = 0;
$thresholdValue = '';
$gaugeMax = '';
$actionLimit = '';
$warningLimit = '';

if(!isset($_POST['threshold_id']) && !isset($_POST['tag_id']))
  {
    echo ("<script type=\"text/javascript\">window.location = \"../../Controls/Production/gb_plc_plant_thresholds.php\";</script>");
  }

if(isset($thresholdId) && $thresholdId != '')
  {
    try
      {
        $dbc = databaseConnectionInfo();

        $thresholdSQL = "CALL sp_" . $site . "_plc_userThresholdGet(" . $tagId . "," . $userId . ")";
//        echo $thresholdSQL;
        $dbconn = new mysqli
                (    
                  $dbc['silicore_hostname'],
                  $dbc['silicore_username'],
                  $dbc['silicore_pwd'],
                  $dbc['silicore_dbname']
                );
        $thresholdRes = $dbconn->query($thresholdSQL);
        mysqli_close($dbconn);
      }
    catch (Exception $e)
      {
        $errorMessage = $errorMessage . "Error connecting to the MySQL database";
        sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
        exit("Stopping PHP execution");
      }
    while($threshold = $thresholdRes->fetch_assoc())
      {
        $alertOn = $threshold['send_alert'];
        $thresholdValue = $threshold['threshold'];
        $gaugeMax = $threshold['gauge_max'];
        $actionLimit = $threshold['gauge_action_limit'];
        $warningLimit = $threshold['gauge_warning_limit'];
      }
      
    try
      {
        $tagSQL = "CALL sp_" . $site . "_plc_tagByIdGet(" . $tagId . ")";
//        echo $tagSQL;
        $dbc = databaseConnectionInfo();
        $dbconn = new mysqli
                (    
                  $dbc['silicore_hostname'],  
                  $dbc['silicore_username'],   
                  $dbc['silicore_pwd'],   
                  $dbc['silicore_dbname']
                );
        $tagResult = $dbconn->query($tagSQL);
        mysqli_close($dbconn);
      }
    catch (Exception $e)
      {
        $errorMessage = $errorMessage . "Error connecting to the MySQL database";
        sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
        exit("Stopping PHP execution");
      }
    while($tagRes = $tagResult->fetch_assoc())
      {
        $device = $tagRes['ui_label'];
        $tag = $tagRes['tag'];
        $tagPlc = $threshold['tag_plc'];
      }
      
  }
else
  {

    try
      {
        $dbc = databaseConnectionInfo();
        $tagSQL = "CALL sp_" . $site . "_plc_tagByIdGet(" . $tagId . ")";
        echo $tagSQL;
        $dbconn = new mysqli
                (    
                  $dbc['silicore_hostname'],
                  $dbc['silicore_username'], 
                  $dbc['silicore_pwd'],  
                  $dbc['silicore_dbname']
                );
        $tagResult = $dbconn->query($tagSQL);
        mysqli_close($dbconn);
      }
    catch (Exception $e)
      {
        $errorMessage = $errorMessage . "Error connecting to the MySQL database";
        sendErrorMessage($debugging, $errorMessage);
        exit("Stopping PHP execution");
      }
    while($tagRes = $tagResult->fetch_assoc())
      {
        $device = $tagRes['ui_label'];
        $tag = $tagRes['tag'];
        $tagPlc = $tagRes['address'];
      }
  }
//========================================================================================== END PHP
?>
<style>
/********************************************************************************** BEGIN Float Input Styles */

.float-inputs label 
{
  position: absolute;
  width: 150px;

}
.float-inputs input, select 
{
  width:30%;
  margin:0;
  margin-left: 160px;
  margin-bottom: 15px;
  border-radius: 3px;
  padding: 12px 18px;
  border: 1px solid #ccc;
}
.float-inputs input[type=checkbox]
{
  margin-top: 5px;
  width:5%
}
  .float-inputs.check-select 
{
    margin-left: 0;
}
.float-inputs input[type=text].hasDatepicker
{
  width:50%;
}
.float-inputs.permissions input, select 
{
  margin-bottom: 0px;
}
/********************************************************************************** END Float Input Styles */
</style>
<script>

function check(elementName) {

    if(document.getElementById(elementName).value == "")
    {
        document.getElementById("alert_on").checked = false;
    }
    else
    {
      document.getElementById("alert_on").checked = true;
    }
    
}
</script>
<!-- HTML -->
<h2>Edit Thresholds</h2>
<h3>
  <?php echo ("Device: " . $device . " || TAG: " . $tag); ?>
</h3>
<div class='float-inputs'>
  <table>
    <tr>
<?php
      echo ("
        <form action='../../Includes/Production/plc_threshold_update.php' method='post'>
          <td style='vertical-align:top;width:80%'>
          <h4>Email Settings</h4>
            <label>Send Alerts: </label>
            <input type='checkbox' id ='alert_on' name='alert_on' ".($alertOn == 1 ? "checked" : '').">
              <br>
            <label>Email Threshold: </label>
            <input type='text' id='threshold_value' name='threshold_value' placeholder='Tons Per Hour' title='Please use whole numbers' 
              pattern='[0-9]{1,}' value='{$thresholdValue}'  onkeyup= \"check('threshold_value')\"><br>
 
            <h4>Gauge Setings</h4>
            <br>            
            <img src='../../Images/gaugeSettings.jpg'>
            <br>
            <label>Gauge Max: </label>
            <input type='text'  name='gauge_max' title='Please use whole numbers' pattern='[0-9]{1,}' value='{$gaugeMax}'><br>  
              
            <label>Warning Limit: </label>
            <input type='text'  name='warning_limit' title='Please use whole numbers' pattern='[0-9]{1,}' value='{$warningLimit}'><br>
              
            <label>Action Limit: </label>
            <input type='text'  name='action_limit' title='Please use whole numbers' pattern='[0-9]{1,}' value='{$actionLimit}'><br>


  
            <input type='hidden' name='threshold_id' value='{$thresholdId}'>
            <input type='hidden' name='tag_id' value='{$tagId}'>

            <input type='hidden' name='site' value='{$site}'>
            <input type='submit' vlaue='submit'>
            </form>
            <form action='../../Controls/Production/plc_plant_thresholds.php'>
              <input type='submit' value='Tag List' formnovalidate> 
            </form> 
            <br>

          </td>
          <td>

          </td>

              ");
?>

    </tr>
  </table>
</div>