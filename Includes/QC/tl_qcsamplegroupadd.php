<?php
/* * *****************************************************************************************************************************************
 * File Name: tl_qcsamplegroupadd.php
 * Project: Silicore
 * Description: This adds a group of new QC samples to the database.
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description]
 * =========================================================================================================================================
 * 09/11/2017|mnutsch|KACE:17959 - Initial creation
 * 09/25/2014|mnutsch|KACE:17957 - Added code to process groups of samples.
 * 10/11/2017|mnutsch|KACE:19045 - Updated text for external sample email notifications.
 * 01/22/2018|mnutsch|KACE:18518 - Cleaned up code: replaced index usage with
 * associative array usage; added a stored procuedure call.
 * 01/24/2018|mnutsch|KACE:18518 - Cleaned up code: added a stored procedure call.
 * 01/30/2018|mnutsch|KACE:18968 - Added sample group IDs.
 * 02/06/2018|mnutsch|KACE:20777 - Fixed a bug related to the formatting of time.
 *
 * **************************************************************************************************************************************** */

//Set Debugging Options
$debugging = 0; //set this to 1 to see debugging output

$t=time(); //variable used for obtaining the current time

//display information if we are in debugging mode
if($debugging == 1)
{
  echo "The current Linux user is: ";
  echo exec('whoami');
  echo "<br/>";
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  echo "<strong>Debugging Enabled</strong><br/>";
  echo "Start time: ";
  echo(date("Y-m-d H:i:s",$t));
  echo "<br/>";
}

$validationMessage = ""; //text string explaining any validation errors.
$isValidationError = 0; //boolean to tell us if there is a problem
$sampleIDs = ""; //string of new sample ID numbers

//checkIfEmpty($argValue, $argName)
//check if the value is an empty string
//set the validation message
//return 1 if validation fails.
function checkIfEmpty($argValue, $argName)
{
  //echo "argValue is " . $argValue . "<br/>";
  //echo "argName is " . $argName . "<br/>";
  if($argValue == "")
  {
    $validationMessage = $argName . " must be entered.";
    echo "Validation message is " . $validationMessage . "<br/>";
    return 1;
  }
  else if(strlen($argValue) == 0)
  {
    $validationMessage = $argName . " must be entered.";
    echo "Validation message is " . $validationMessage . "<br/>";
    return 1;
  }
  else
  {
    return 0;
  }
}

// begin the session
session_start();

//include other files
require_once('../../Includes/QC/tl_qcfunctions.php'); //contains database connection info
require_once('../../Includes/emailfunctions.php'); //contains email functionality

$debugging = 0;

//read the input values from the form
$userId = test_input($_POST['userId']);
$siteId = test_input($_POST['siteId']);
$plantId = test_input($_POST['plantId']);
$testTypeId = test_input($_POST['testTypeId']);
$compositeTypeId = test_input($_POST['compositeTypeId']);
$labTech = test_input($_POST['labTech']);
$sampler = test_input($_POST['sampler']);
$operator = test_input($_POST['operator']);
$numberOfGroups = test_input($_POST['numberOfGroups']);

$locationId = array();
$locationCount = 0;
if(isset($_POST['locationId']))
{
  if(is_array($_POST['locationId']))
  {
    //echo("DEBUG: locationId is an array.<br/>");
    $locationCount = count($_POST['locationId']);
    //echo "DEBUG: The count of locationId is: " . $locationCount . "<br/>";
    for($i = 0; $i < $locationCount; $i++)
    {
      //echo $i. ": " . $_POST['locationId'][$i] . "<br/>";
      $locationId[$i] = $_POST['locationId'][$i];

    }
  }
  else
  {
    //echo("DEBUG: locationId is NOT an array.<br/>");
    $locationCount = 1;
    $locationId[0] = $_POST['locationId'];
  }

}
else
{
  $locationCount = 0;
  $locationId[0] = "0";
}

$dt = test_input($_POST['dt']); //the date and time of the sample

//validate the data received
if(checkIfEmpty($siteId, "Site") == 1) { $isValidationError = 1; };
if(checkIfEmpty($plantId, "Plant") == 1) { $isValidationError = 1; };
if(checkIfEmpty($dt, "Date Time") == 1) { $isValidationError = 1; };
if(checkIfEmpty($testTypeId, "Test Type") == 1) { $isValidationError = 1; };
if(checkIfEmpty($compositeTypeId, "Composite Type") == 1) { $isValidationError = 1; };
if(checkIfEmpty($labTech, "Lab Tech") == 1) { $isValidationError = 1; };
if(checkIfEmpty($sampler, "Sampler") == 1) { $isValidationError = 1; };
if(checkIfEmpty($operator, "Operator") == 1) { $isValidationError = 1; };
for($i = 0; $i<$locationCount; $i++)
{
  if(checkIfEmpty($locationId[$i], "Location") == 1) { $isValidationError = 1; };
}
if($locationCount == 0)
{
  $validationMessage = "A location must be selected.";
  $isValidationError = 1;
}
if(checkIfEmpty($numberOfGroups, "Number of Groups") == 1) { $isValidationError = 1; };

if($isValidationError == 1)
{
  //echo "Validation error: " . $validationMessage;

  //set the form values as session variables
  $_SESSION['siteId'] = $siteId;
  $_SESSION['plantId'] = $plantId;
  $_SESSION['dt'] = $dt;
  $_SESSION['testTypeId'] = $testTypeId;
  $_SESSION['compositeTypeId'] = $compositeTypeId;
  $_SESSION['labTech'] = $labTech;
  $_SESSION['sampler'] = $sampler;
  $_SESSION['operator'] = $operator;
  $_SESSION['locationId'] = $locationId;
  $_SESSION['locationCount'] = $locationCount;

  $_SESSION['validationMessage'] = $validationMessage;

  echo "Debug: " . $validationMessage . "<br/>";
  //redirect the user
  header('Location: ../../Controls/QC/tl_samplegroupadd.php?validationStatus=fail');
}

$date = date("Y-m-d", strtotime($dt));
$time = date("H:i", strtotime($dt));

$dateShort = substr(date("Ymd", strtotime($dt)), 0, 8); //shorten the date to an 8 digit integer
$dtShort = substr(date("YmdHi", strtotime($dt)), 0, 11); //shorten the date to an 11 digit integer, effectively rounding it to the nearest ten minutes and making it easy for mysql to handle in joins

//group the times recorded together based on when the measurements are performed
if ($time >= "23:15" || $time < "02:15")
{
  $groupTime = "00:00:00";
} elseif ($time < "05:15")
{
  $groupTime = "03:00:00";
} elseif ($time < "08:15")
{
  $groupTime = "06:00:00";
} elseif ($time < "11:15")
{
  $groupTime = "09:00:00";
} elseif ($time < "14:15")
{
  $groupTime = "12:00:00";
} elseif ($time < "17:15")
{
  $groupTime = "15:00:00";
} elseif ($time < "20:15")
{
  $groupTime = "18:00:00";
} else
{
  $groupTime = "21:00:00";
}

if($debugging == 1)
{

  echo "finished reading form input.<br/><br/>";

  echo "siteId = " . $siteId . "<br/>";
  echo "plantId = " . $plantId . "<br/>";
  echo "dt = " . $dt . "<br/>";
  echo "testTypeId = " . $testTypeId . "<br/>";
  echo "compositeTypeId = " . $compositeTypeId . "<br/>";

  for($i = 0; $i < $locationCount; $i++)
  {
    echo "locationId " . $i . " = " . $locationId[$i] . "<br/>";
  }
  echo "date = " . $date . "<br/>";
  echo "time = " . $time . "<br/>";
  echo "dateShort = " . $dateShort . "<br/>";
  echo "dtShort = " . $dtShort . "<br/>";
  echo "groupTime = " . $groupTime . "<br/>";
  echo "labTech = " . $labTech . "<br/>";
  echo "sampler = " . $sampler . "<br/>";
  echo "operator = " . $operator . "<br/>";

}

//query MySQL and read shift information using $plantId and $dt
$shiftId = "";
$shiftDate = "";
$shift = "";
$shiftStartDt = "";
$shiftEndDt = "";
$shiftUptime = "";
try
{
  $mySQLConnectionLocal = connectToMySQLQC(); //connect to the database, requires qcfunctions.php

  $table_name = "main_users";

  //$sql = "SELECT * FROM main_shifts WHERE site_id = '$plantId' and '$dt' >= start_time order by start_time desc LIMIT 1"; //direct SQL method
  $sql = "CALL sp_tl_qc_ShiftsGetBySiteAndDate(" . $plantId . ",'" . $dt . "');";

  $result =  $mySQLConnectionLocal->query($sql); //direct SQL method

  //$result = $mySQLConnectionLocal->query("CALL sp_GetLocation('$locationId');"); //stored procedure method

  $resultCount = 0;
  while($row = $result->fetch_assoc())
  {
    $shiftId = $row['id'];
    $shiftDate = $row['start_time'];
    $shift = $report['shift']; //Day, Night, etc.
    $shiftStartDt = $row['start_time'];
    $shiftEndDt = $row['end_time'];

    if (strlen($shiftEndDt) == 0)
    {
      $shiftUptime = 12;
    } else
    {
      $shiftUptime = t - $shiftStartDt;
    }
    $resultCount = $resultCount + 1;
  }

  disconnectFromMySQLQC($mySQLConnectionLocal);

  if($debugging == 1)
  {
    echo "<br/>Values read from main_shifts<br/>";
    echo "shiftId = " . $shiftId . "<br/>";
    echo "shiftDate = " . $shiftDate . "<br/>";
    echo "shift = " . $shift . "<br/>";
    echo "shiftStartDt = " . $shiftStartDt . "<br/>";
    echo "shiftEndDt = " . $shiftEndDt . "<br/>";
    echo "shiftUptime = " . $shiftUptime . "<br/>";
  }
}
catch (Exception $e)
{
  $errorMessage = $errorMessage . "Error reading qc location data.";
  sendErrorMessage($debugging, $errorMessage); //requires emailfunctions.php
  if($debugging == 1)
  {
    echo $errorMessage;
    //$error = $e->getMessage();
    //echo $error;
  }
}

$userRepeatabilityCount = 0;
$maxGroupID = 0;
$currentGroupID = 0;
//iterate through the number of Sample Groups
$samplesAddedCount = 0;
for($j = 0; $j < $numberOfGroups; $j++)
{
  //get the max group ID
  $maxGroupID = sampleGroupMaxGet();
  if($maxGroupID == NULL)
  {
    $maxGroupID = 0;
  }

  //set currentGroupID to max group ID + 1
  $currentGroupID = $maxGroupID + 1;

  //increment the dt and time by 1 minute * j counter
  //convert to datetime objects
  $dt = new DateTime($dt);
  $time = new DateTime($time);
  //increment both values by 1 minute
  $dt->add(new DateInterval('PT1M'));
  $time->add(new DateInterval('PT1M'));
  //convert back to strings
  $dt = $dt->format('Y-m-d H:i:s');
  $time = $time->format('H:i:s');

  //iterate through the locations
  for($i = 0; $i < $locationCount; $i++)
  {
    //insert the values into the samples table, returns the inserted id
    $newSilicoreSampleId = insertSample($testTypeId, $compositeTypeId, $siteId, $plantId, $locationId[$i], $dt, $date, $dateShort, $dtShort, $time, $groupTime, $date, $labTech, $sampler, $operator, $userId);

    //insert the group id and sample id into the group samples table
    $newSampleGroupResult = sampleGroupInsert($currentGroupID, $newSilicoreSampleId);

    //read the user's repeatability count
    $userRepeatabilityCount = getRepeatabilityByUserId($userId);
    //echo "The user's repeatability count is " . $userRepeatabilityCount . "<br/>";
    //if the user's repeatability count is greater than 0, then decrease it by 1
    if($userRepeatabilityCount > 0)
    {
      //echo "Updating the user's repeatability.<br/>";
      updateRepeatability($userId, ($userRepeatabilityCount - 1));
    }

    //add this sample ID to a list of samples
    if($samplesAddedCount > 0) //if there is more than one sample being created and this is not the first
    {
      $sampleIDs = $sampleIDs . ", " . $newSilicoreSampleId;
    }
    else
    {
      $sampleIDs = $sampleIDs . $newSilicoreSampleId;
    }

    $samplesAddedCount++; //used to determine if we should put a comma in front of the sample ID
  }
}

//if the sample site is not the local site, then e-mail the QC manager that this is an External Sample
$sendExternalQCSampleNotificationResult = 0;
if($siteId != 50) //siteID 10 = Granbury, 50 = Tolar
{
  $siteObject = getSiteById($siteId);
  $sendExternalQCSampleNotificationResult = sendExternalQCSampleNotification(1, $siteObject->vars['description'], $sampleIDs, "Tolar");
}

if($debugging)
{
  echo "DEBUG: The sendExternalQCSampleNotificationResult = " . $sendExternalQCSampleNotificationResult . "<br/>";
  echo "Finished adding QC samples group.";
}

//redirect the user to the Samples page
header('Location: ../../Controls/QC/tl_samples.php?view=summary&completionStatus=Incomplete');

/***************************************
* Name: function test_input($data)
* Description: This function removes harmful characters from input.
* Source: https://www.w3schools.com/php/php_form_validation.asp
****************************************/
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>