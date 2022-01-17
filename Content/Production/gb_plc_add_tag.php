<?php
/* * *****************************************************************************************************************************************
 * File Name: gb_plc_add_tag.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 01/24/2018|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
require_once('../../Includes/security.php');
require_once('../../Includes/Security/dbaccess.php');
require_once('../../Includes/emailfunctions.php');

$debugging = 0; //set this to 1 to see debugging output

$t=time(); //variable used for obtaining the current time
$errorMessage = ""; //used in error message emails
$userID = $_SESSION['user_id'];
//display information if we are in debugging mode
if($debugging)
{
    echo "The current Linux user is: ";
    echo exec('whoami');
    echo "<br/>";
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    echo "<strong>Debugging Enabled - qcfunctions.php</strong><br/>";  
    echo "Start time: ";
    echo(date("Y-m-d H:i:s",$t));
    echo "<br/>";
}

try
  {
    $allPlantsSQL = "CALL sp_gb_plc_PlantsGet()";
    $dbc = databaseConnectionInfo();
    $dbconn = new mysqli
            (    
              $dbc['silicore_hostname'],
              $dbc['silicore_username'],
              $dbc['silicore_pwd'],
              $dbc['silicore_dbname']
            );
    $plantResults = $dbconn->query($allPlantsSQL);
    mysqli_close($dbconn);
  }
catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error connecting to the MySQL database";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    exit("Stopping PHP execution");
  }

try
  {
    $allClassificationsSQL = "CALL sp_gb_plc_ClassificationsGet()";
    $dbc = databaseConnectionInfo();
    $dbconn = new mysqli
            (    
              $dbc['silicore_hostname'],
              $dbc['silicore_username'],
              $dbc['silicore_pwd'],
              $dbc['silicore_dbname']
            );
    $classifcationsResults = $dbconn->query($allClassificationsSQL);
    mysqli_close($dbconn);
  }
catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error connecting to the MySQL database";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
  }
  
try
  {
    $allUnitsSQL = "CALL sp_gb_plc_unitsGet()";
    $dbc = databaseConnectionInfo();
    $dbconn = new mysqli
            (    
              $dbc['silicore_hostname'],
              $dbc['silicore_username'],
              $dbc['silicore_pwd'],
              $dbc['silicore_dbname']
            );
    $unitResults = $dbconn->query($allUnitsSQL);
    mysqli_close($dbconn);
  }
catch (Exception $e)
  {
    $errorMessage = $errorMessage . "Error connecting to the MySQL database";
    sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
    exit("Stopping PHP execution");
  }
 
$plantOptions = '';
$classificationOptions = '' ;
$unitOptions = '';


while($plantRes = $plantResults->fetch_assoc())
  {
    $plantId = $plantRes['id'];
    $plant = $plantRes['name'];
    $plantOptions = $plantOptions . "<option value='" . $plantId . "'>" . $plant . "</option>";
  }

while($classification = $classifcationsResults->fetch_assoc())
  {
    $class = $classification['classification'];
    $classificationOptions = $classificationOptions . "<option value='" . $class . "'>" . $class . "</option>";
  }
  
while($unitRes = $unitResults->fetch_assoc())
  {
    $unit = $unitRes['units'];
    $unitOptions = $unitOptions . "<option value='" . $unit . "'>" . $unit . "</option>";
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
  width:20%;
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

<!-- HTML -->

<h2>Add Tag</h2>
<div class='float-inputs'>
  <table>
    <tr>
<?php
      echo ("
        <form action='../../Includes/Production/gb_plc_tag_insert.php' method='post'
          <td style='vertical-align:top;width:50%' >
            <label>Device: </label>
            <input type='text' name='device_description' required><br>

            <label>Tag: </label>
            <input type='text' name='tag' required><br>

            <label>PLC Tag: </label>
            <input type='text' name='plc_tag' required><br>

            <label>Plant: </label>
            <select name='select_plant' required>
              {$plantOptions} 
            </select><br><br>
            
            <label>Classification: </label>
            <select name='select_classification' required>
              {$classificationOptions} 
            </select><br><br>

            <label>Units: </label>
            <select name='select_units' required>
              {$unitOptions}
            </select><br><br>
            
            <input type='submit' vlaue='submit'>
          </td>
        </form>
              ");
?>

    </tr>
  </table>
</div>